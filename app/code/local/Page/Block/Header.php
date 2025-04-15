<?php
class Page_Block_Header extends Core_Block_Template{
   
    public function __construct(){
        $this->setTemplate('page/header.phtml');
    }
    public function getParentCategory()
    {
        $categoryModel = Mage::getModel('catalog/category');
        $categoryData = $categoryModel->getCollection()
                                      ->select(['name','category_id'])
                                      ->addFieldToFilter("parent_id",1);
        $data = $categoryData->getData();
        // echo "<pre>";
        // print_r($data);
        return $data;
    }
    public function getChildCategory()
    {
        $categoryModel = Mage::getModel('catalog/category');
        $categoryData = $categoryModel->getCollection()
                                  ->select(['name','parent_id','category_id'])
                                  ->leftJoin(["cc"=>"catalog_category"], "main_table.parent_id = cc.category_id",[]) // Correct filter syntax
                                  ->addFieldToFilter("main_table.parent_id",["neq"=> 1]);
        // echo "<pre>";
        // print_r($categoryData);
        $data = $categoryData->getData();
      
        // print_r($data);
        return $data;
    }
    public function getuserId(){
        $customerId = Mage::getSingleton('core/session')
            ->get('customer_id');

        $customerModel = Mage::getModel('customer/account')
            ->load($customerId);
        return $customerModel;
    }
    public function getLogin(){
        return Mage::getSingleton('core/session')
            ->get('login');
    }
    public function getcount(){
        $countdata = Mage::getSingleton('checkout/session')
        ->getcart()
        ->getItemCollection()
        ->getdata();
        return count($countdata);
    }
    public function isAllowed($role)
    {
        $permission =  Mage::getSingleton('admin/session')->getRole()->getPermissions();
        if (isset(json_decode($permission, true)['menu'])) {
            $json = json_decode($permission, true)['menu'];
 
            if (in_array($role, $json)) {
                return true;
            } else {
                return false;
            }
        }
    }
}
?>