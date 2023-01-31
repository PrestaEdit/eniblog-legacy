<?php
class EniBlogBlogModuleFrontController extends ModuleFrontController
{
    protected $template = 'module:eniblog/views/templates/front/blog.tpl';

    public function __construct()
    {
        parent::__construct();

        $this->setTemplate('module:eniblog/views/templates/front/blog.tpl');
    }

    public function setMedia()
    {
        parent::setMedia();

        $this->context->controller->registerStylesheet(
            'test',
            'https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css',
            ['server' => 'remote']
        );

        $this->context->controller->registerStylesheet(
            'module-'.$this->module->name.'-styles',
            'modules/'.$this->module->name.'/views/css/front/styles.css',
        );
    }
}
