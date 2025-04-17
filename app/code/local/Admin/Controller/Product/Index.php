<?php
// ob_start();
class Admin_Controller_Product_Index extends Core_Controller_Admin_Action
{


    public function newAction()
    {
        // $layout = $this->getLayout();
        $new = $this->getLayout()->createBlock('Admin/product_index_New')
            ->setTemplate('Admin/product/index/new.phtml');
        $this->getLayout()->getChild('content')->addChild('new', $new);
        $this->getLayout()->getChild('head')->addCss('admin/product_index/new.css');
        $this->getLayout()->toHtml();
        //echo "<pre>";
    }

    public function listAction()
    {
        // $layout = $this->getLayout();
        // $Toolbar = $layout->createBlock('Admin/Grid_Toolbar')
        //     ->setTemplate('Admin/grid/toolbar.phtml');
        $list = $this->getLayout()->createBlock('Admin/product_index_list');
        // ->setTemplate('Admin/product/index/list.phtml');
        $this->getLayout()->getChild('content')->addChild('list', $list);

        // $layout->getChild('content')->getChild('list')->addChild('Toolbar', $Toolbar);

        $this->getLayout()->getChild('head')->addCss('admin/list.css');
        $this->getLayout()->toHtml();
    }


    public function saveAction()
    {
        $request = Mage::getModel('core/request');
        $productmodel = Mage::getModel('catalog/product');
        // $attributeModel = Mage::getModel('catalog/Attribute');
        //$productAttributeModel = Mage::getModel('catalog/product_Attribute');
        $imageModel = Mage::getModel('catalog/media_gallery');
        //$attribute = $attributeModel->getCollection()->getData();
        // echo "<pre>";
        // print_r($attribute); 
        // $layout = $this->getLayout();
        // print_r($request->getParam('catlog_product'));
        $product = $request->getParam('catalog_product');
        echo "<pre>";
        // print_r($_FILES);
        // print_r($product);
        //  die();
        // die();
        $productmodel->setData($product);
        // print_r($productmodel);
        $productmodel->save();
        Mage::dispatchEvent('catalog_product_save',[$productmodel]);
        //  $product_id =  $productmodel->getProductId();
        // print_r($product_id);
        //$attributeData = $attributeModel->getCollection()->getData();




        // $productAttributes = array_filter($request->getParam('catalog_attribute'));
        // // print_r($productAttributes);
        // $image = $request->getParam('catalog_media_gallary');
        // //  print_r($request->getParams('catlog_product'));
        // // $data = $product->getData();



        // // Debug $_FILES to check its structure 
        // $productmodel->setData($product);
        // $productObj = $productmodel->save();
        // $product_id =  $productObj->getProductId();
        // //print_r($product_id);

        // $setAttribute = [];
        // if ($product_id) {
        //     // print($product_id);
        //     foreach ($productAttributes as $name => $value) {
        //         // Get attribute_id based on the attribute name
        //         $attributedata = $attributeModel->getCollection()
        //             ->select('attribute_id')
        //             ->addFieldToFilter('name', $name);

        //         $attributeDataArray = $attributedata->getData();

        //         if (!empty($attributeDataArray)) {
        //             $attribute_id = $attributeDataArray[0]->getAttributeId();

        //             // Get existing attribute data for the product
        //             $existingAttribute = $productAttributeModel->getCollection()
        //                 ->select()
        //                 ->addFieldToFilter('product_id', $product_id)
        //                 ->addFieldToFilter('attribute_id', $attribute_id);

        //             $existDatas = $existingAttribute->getData();

        //             if (!empty($existDatas)) {
        //                 $existData = $existDatas[0];

        //                 // Prepare the data to set
        //                 $setAttribute = [
        //                     'value_id' => $existData->getValueId(),
        //                     'attribute_id' => $attribute_id,
        //                     'product_id' => $product_id,
        //                     'value' => $value
        //                 ];

        //                 // Set the data and check for errors

        //                 // echo "<pre>";
        //                 // print_r($d);
        //             } else {
        //                 $setAttribute = [

        //                     'attribute_id' => $attribute_id,
        //                     'product_id' => $product_id,
        //                     'value' => $value
        //                 ];
        //                 echo "No existing attribute data found for product_id: $product_id and attribute_id: $attribute_id.";
        //             }
        //             $productAttributeModel->setData($setAttribute);
        //             $productAttributeModel->save();
        //         } else {
        //             echo "Attribute not found for name: $name.";
        //         }
        //     }

        // }


        $url = $this->getLayout()->getUrl("*/*/list");
        header("Location: $url");
        exit();
    }


    public function deleteAction()
    {
        // echo "<pre>";
        $request = Mage::getModel('core/request');
        $product = Mage::getModel('catalog/product');
        // $product->setData($request->getParam('catlog_product'));
        $id =  $request->getQuery('delete_id');
        // $productAttribute = Mage::getModel('catalog/product_attribute');
        // $productAttributeData =  $productAttribute->getCollection()
        //                                           ->select()
        //                                           ->addFieldToFilter('product_id',$id)
        //                                           ->getData();
        // $imageModel = Mage::getModel('catalog/media_gallery');
        // $imageData = $imageModel->getCollection()
        //                         ->select()
        //                         ->addFieldToFilter('product_id',$id)
        //                         ->getData();
        $product->load($id);
        // echo "<pre>";
        // print_r($product);
        // die();
        // $product->setName("abc");
        // $img = $product->getFilePath();
        // unlink($img);

        $product->delete();
        // $productAttributeData->delete();
        // $imageData->delete();
        // // print_r($product);

        // $layout = $this->getLayout();
        $url = $this->getLayout()->getUrl("*/*/list");
        header("Location: $url");
        $delete = $this->getLayout()->createBlock('Admin/product_index_list')
            ->setTemplate('Admin/product/index/delete.phtml');
        $this->getLayout()->getChild('content')->addChild('delete', $delete);
        $this->getLayout()->toHtml();
        exit();
    }
    public function exportCsvAction()
    {
        Mage::getModel('Admin/Csv')
            ->exportCsv(Mage::getModel("Catalog/Product"));
        Mage::getSingleton('core/message')->Addmessage('success','csv file sucessfully  export!');
    }
}
