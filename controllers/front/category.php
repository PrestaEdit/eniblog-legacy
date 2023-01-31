<?php
class EniBlogCategoryModuleFrontController extends ModuleFrontController
{
    protected $template = 'module:eniblog/views/templates/front/blog.tpl';

    public function __construct()
    {
        parent::__construct();

        $this->setTemplate('module:eniblog/views/templates/front/blog.tpl');

        $this->maintenance = true;
    }
}
