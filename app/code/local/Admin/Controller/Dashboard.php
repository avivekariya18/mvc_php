<?php

class Admin_Controller_Dashboard extends Core_Controller_Admin_Action
{
    public function listAction()
    {
        $layout = $this->getLayout();
        $list = $layout->createBlock('admin/dashboard_list')
            ->setTemplate('admin/dashboard/list.phtml');
        $layout->getChild('content')->addChild('list', $list);
        $layout->getChild('head')->addCss('admin/dashboard/list.css');
        $layout->toHtml();
    }
    public function exportCsvAction(): void
    {
        Mage::getModel('Admin/Csv')
            ->exportCsv(Mage::getModel("sale/Order"));
        Mage::getModel('Admin/Csv')
            ->exportCsv(Mage::getModel("catalog/category"));
        Mage::getModel('Admin/Csv')
            ->exportCsv(Mage::getModel("Catalog/Product"));
    }
}
