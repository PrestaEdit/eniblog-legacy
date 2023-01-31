<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

class AdminEniBlogCategoryController extends ModuleAdminController
{
    /**
     * Construct
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function __construct()
    {
        $this->bootstrap = true;
        $this->table = 'pm_membercard_frequencies';
        $this->sub_table = 'frequencies';
        $this->identifier = 'id_frequency';
        $this->primary = 'id_frequency';
        $this->className = '\MemberCard\Models\Frequency';
        $this->lang = false;
        $this->multishop_context = Shop::CONTEXT_ALL;

        $this->addRowAction('edit');
        $this->addRowAction('delete');

        $frequenciesArray = [];
        $frequencies = Frequency::getTypes();
        foreach ($frequencies as $frequency) {
            $frequenciesArray[(int) $frequency['id_type']] = $frequency['name'];
        }

        $this->fields_list = [
            'id_frequency' => [
                'title' => $this->l('ID #'),
                'align' => 'left',
                'class' => 'fixed-width-sm',
                'type' => 'int',
            ],
            'value' => [
                'title' => $this->l('Value'),
                'class' => 'fixed-width-sm',
                'align' => 'center',
                'type' => 'int',
            ],
            'frequency_name' => [
                'type' => 'select',
                'list' => $frequenciesArray,
                'title' => $this->l('Type'),
                'name' => 'name',
                'align' => 'center',
                'filter_key' => 'a!type'
            ],
        ];

        parent::__construct();

        $this->_select .= 'IF(a.`type` = 2, "'.Translate::getModuleTranslation('pm_membercard', 'weeks', 'Frequency').'", "'.Translate::getModuleTranslation('pm_membercard', 'months', 'Frequency').'") AS `frequency_name`, ';

        $this->meta_title = $this->trans('Cards', [], 'Modules.Pmmembercard.Admin');
    }

    /**
     * {@inheritdoc}
     *
     * @since 1.0.0
     */
    public function setMedia($isNewTheme = false)
    {
        parent::setMedia($isNewTheme);
        // @TODO: include assets to load icons

        $this->addJs(_MODULE_DIR_ . $this->module->name . '/views/js/Form.js');
    }

    /**
     * {@inheritdoc}
     *
     * @since 1.0.0
     */
    public function renderForm()
    {
        /* Card $obj */
        if (!($obj = $this->loadObject(true))) {
            return;
        }

        $this->fields_form = [
            'legend' => [
                'title' => $this->trans('Frequency', [], 'Modules.Pmmembercard.Admin'),
                'icon' => 'icon-repeat',
            ],
            'submit' => [
                'title' => $this->trans('Save', [], 'Admin.Actions'),
            ],
            'input' => [
                [
                    'type' => 'text',
                    'required' => true,
                    'class' => 'fixed-width-xl',
                    'label' => $this->trans('Frequency', [], 'Modules.Pmmembercard.Admin'),
                    'name' => 'value',
                    'query' => Frequency::getType((int) $this->context->language->id, 1, 0, 'value', 'ASC'),
                ],
                [
                    'type' => 'select',
                    'label' => $this->trans('Term', [], 'Modules.Pmmembercard.Admin'),
                    'name' => 'type',
                    'options' => [
                        'query' => Frequency::getTypes(),
                        'id' => 'id_type',
                        'name' => 'name',
                    ],
                ],
            ]
        ];

        if ($this->display == 'add') {
            $this->fields_form['legend']['title'] = $this->trans('Add frequency', [], 'Modules.Pmmembercard.Admin');
        } else {
            $this->fields_form['legend']['title'] = $this->trans('Edit frequency', [], 'Modules.Pmmembercard.Admin');
        }

        return parent::renderForm();
    }
}
