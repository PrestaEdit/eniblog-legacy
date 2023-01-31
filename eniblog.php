<?php
declare(strict_types=1);

if (!defined('_PS_VERSION_')) {
    exit;
}
use PrestaShop\PrestaShop\Core\Module\WidgetInterface;
use PrestaShopBundle\Form\Admin\Type\SwitchType;

class EniBlog extends Module implements WidgetInterface
{
    /**
     * @see parent::construct
     * @return void
     */
    public function __construct()
    {
        $this->name = 'eniblog';
        $this->tab = 'front_office_features';
        $this->author = 'Jonathan Danse';
        $this->version = '1.0.0';

        $this->displayName = $this->l('Blog');
        $this->description = $this->l('n/d');

        $this->ps_versions_compliancy = [
            'min' => '8.0.0',
            'max' => '8.99.99',
        ];
        $this->need_instance = 0;
        $this->bootstrap = true;

        $this->controllers = ['blog'];

        parent::__construct();
    }

    public function install()
    {
        $hooks = [
            'moduleRoutes',
            'displayLeftColumn',
            'displayOverrideTemplate',
            'actionCmsPageFormBuilderModifier',
            'actionAfterCreateCmsPageFormHandler',
            'actionAfterUpdateCmsPageFormHandler',
        ];

        return parent::install()
            && $this->registerHook($hooks)
            && $this->installSQL()
            && $this->installTabs()
            && Configuration::updateValue('ENIBLOG_NB_ARTICLES', 10);
    }

    public function uninstall()
    {
        return
            parent::uninstall()
            && Configuration::deleteByName('ENIBLOG_NB_ARTICLES');
    }

    protected function installTabs()
    {
        $res = true;

        $tab = new Tab();
        $tab->active = true;
        $tab->enabled = true;
        $tab->class_name = 'AdminParentEniBlog';
        $tab->module = $this->name;
        $tab->name = [
            (int) Configuration::get('PS_LANG_DEFAULT') => 'Blog',
        ];
        $tab->icon = 'book';
        $tab->id_parent = (int) Tab::getInstanceFromClassName('AdminParentThemes')->id;
        $tab->wording = 'Blog';
        $tab->wording_domain = 'Modules.Eniblog.Admin';

        $res &= $tab->save();

        /*$tab = new Tab();
        $tab->active = true;
        $tab->enabled = true;
        $tab->class_name = 'AdminEniBlogCategory';
        $tab->module = $this->name;
        $tab->name = [
            (int) Configuration::get('PS_LANG_DEFAULT') => 'Categories',
        ];
        $tab->icon = 'book';
        $tab->id_parent = (int) Tab::getInstanceFromClassName('ENIBLOG')->id;
        $tab->wording = 'Categories';
        $tab->wording_domain = 'Modules.Eniblog.Admin';

        $res &= $tab->save();
        */

        return $res;
    }

    protected function installSQL()
    {
        if (!file_exists(dirname(__FILE__) . '/sql/install.sql')) {
            return false;
        } elseif (!$sql = file_get_contents(dirname(__FILE__) . '/sql/install.sql')) {
            return false;
        }
        $sql = str_replace(['PREFIX_', 'ENGINE_TYPE'], [_DB_PREFIX_, _MYSQL_ENGINE_], $sql);
        $sql = preg_split("/;\s*[\r\n]+/", trim($sql));

        foreach ($sql as $query) {
            if (!Db::getInstance()->execute(trim($query))) {
                return false;
            }
        }

        return true;
    }

    public function getContent()
    {
        $content = '';

        $content .= $this->context->smarty->fetch('module:eniblog/views/templates/admin/configuration.tpl');

        if (Tools::isSubmit('submit' . $this->name)) {
            $content .= $this->postProcess();
        } 

        $content .= $this->renderConfigurationForm();

        return $content;
    }

    public function renderConfigurationForm()
    {
        $form = [
            'form' => [
                'legend' => [
                    'title' => $this->l('Configuration'),
                ],
                'input' => [
                    [
                        'type' => 'text',
                        'label' => $this->l('Number of articles'),
                        'name' => 'ENIBLOG_NB_ARTICLES',
                        'size' => 3,
                        'required' => true,
                    ],
                ],
                'submit' => [
                    'title' => $this->l('Save'),
                    'class' => 'btn btn-default pull-right',
                ],
            ],
        ];
    
        $helper = new HelperForm();
    
        $helper->table = $this->table;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&' . http_build_query(['configure' => $this->name]);
        $helper->submit_action = 'submit' . $this->name;
    
        $helper->default_form_language = (int) Configuration::get('PS_LANG_DEFAULT');
    
        $helper->fields_value['ENIBLOG_NB_ARTICLES'] = (int) Tools::getValue('ENIBLOG_NB_ARTICLES', Configuration::get('ENIBLOG_NB_ARTICLES', null, null, Context::getContext()->shop->id));
    
        return $helper->generateForm([$form]);
    
    }

    public function postProcess()
    {
        $nbArticles = (int) Tools::getValue('ENIBLOG_NB_ARTICLES', 0);

        if (empty($nbArticles) || !Validate::isUnsignedInt($nbArticles)) {
            // Retourne une erreur
            return $this->displayError($this->l('Invalid value'));
        }

        Configuration::updateValue('ENIBLOG_NB_ARTICLES', (int) $nbArticles, false, null, Context::getContext()->shop->id);
        return $this->displayConfirmation($this->l('Settings updated'));
    }

    public function hookDisplayOverrideTemplate($params)
    {
        if (
            $params['controller'] instanceof CmsController
            && $params['template_file'] == 'cms/page'
        ) {
            //return 'cms/page_extended';
        }
    }

    public function renderWidget($hookName, array $configuration)
    {
        $this->context->smarty->assign($this->getWidgetVariables($hookName, $configuration));

        return $this->context->smarty->fetch('module:eniblog/views/templates/hooks/widget.tpl');
    }
    public function getWidgetVariables($hookName, array $configuration)
    {
        return [
            'hookName' => $hookName,
        ];
    }

    public function hookfDisplayLeftColumn($params)
    {
        return $this->context->smarty->fetch('module:eniblog/views/templates/hooks/leftColumn.tpl');
    }

    public function hookModuleRoutes($params)
    {
        $customRoutes = [];

        $customRoutes['module-' . $this->name . '-blog'] = [
            'controller' => 'blog',
            'rule' => 'blog',
            'keywords' => [],
            'params' => [
                'fc' => 'module',
                'module' => $this->name,
            ],
        ];

        $customRoutes['module-' . $this->name . '-category'] = [
            'controller' => 'category',
            'rule' => 'blog/category{/:id}',
            'keywords' => [
                'id' => [
                    'regexp' => '[0-9]+',
                    'param' => 'id_category'
                ],
            ],
            'params' => [
                'fc' => 'module',
                'module' => $this->name,
            ],
        ];

        return $customRoutes;
    }

    public function hookActionCmsPageFormBuilderModifier(array $params)
    {
        $formBuilder = $params['form_builder'];
        $formBuilder->add('your_new_field', SwitchType::class, [
            'label' => $this->getTranslator()->trans('New field', [], 'Modules.EniBlog.Admin'),
            'required' => false,
        ]);

        $result = false;
        if (null !== $params['id']) {
            // Vous pouvez utilisez votre repository pour obtenir la bonne valeur
            $result = true;
        }

        $params['data']['your_new_field'] = $result;

        $formBuilder->setData($params['data']);
    }

    public function hookActionAfterCreateCmsPageFormHandler(array $params)
    {
        // Lors du premier enregistrement
        $this->handleNewField($params);
    }

    public function hookActionAfterUpdateCmsPageFormHandler(array $params)
    {
        // Lors de la mise à jour
        $this->handleNewField($params);
    }

    public function handleNewField(array $params)
    {
        $cmsPageId = $params['id'];
        /** @var array $cmsPageFormData */
        $cmsPageFormData = $params['form_data'];
        $isYourNewFieldChecked = (bool) $cmsPageFormData['your_new_field'];

        // $isYourNewFieldChecked = true|false
        // Vous pouvez utilisez votre repository pour définir sa donnée
    }
}
