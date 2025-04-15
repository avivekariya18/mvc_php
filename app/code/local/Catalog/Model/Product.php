<?php
class Catalog_Model_Product extends Core_Model_Abstract
{

   public $status = [0 => "disable", 1 => "Able"];
   public function init()
   {
      $this->_resourceClassName = "Catalog_Model_Resource_Product";
      $this->_collectionClass = "Catalog_Model_Resource_Product_Collection";
   }

   public function getStatusText()
   {
      $statusValue = $this->getStatus();

      return isset($this->status[$statusValue]) ? $this->status[$statusValue] : '';
   }

   protected function _afterLoad()
   {
      if ($this->getProductId()) {
         $collection = Mage::getModel('catalog/product_attribute')
            ->getCollection()
            ->addFieldToFilter("product_id", $this->getProductId())
            ->leftJoin(["attr" => "catalog_attribute"], "attr.attribute_id = main_table.attribute_id", ["name" => "name"]);
         $imageCollection = Mage::getModel('catalog/media_gallery')
            ->getCollection()
            ->addFieldToFilter("product_id", $this->getProductId());
         // echo "<pre>";

         $images = $imageCollection->getData();
         // print_r($images);
         $filePaths = [];
     
         // Collect file paths
         foreach ($images as $image) {
            
            if($image->getDefaultImage() == 1)
            {
               $filePaths['main_image'] = $image->getFilePath();
            }else{
               $filePaths[] = $image->getFilePath();
            }
         }
         
         // Store the file paths in _data
         $this->_data['file_path'] = $filePaths;
       
         // $this->_data['mainImage']= $mainImage;
         $data1 = $collection->getData();
         // print_r($data1);

         foreach ($data1 as $_data) {
            $this->{$_data->getName()} = $_data->getValue();
         }
        
          //die();
         // print_r($this->getData('file_paths'));
      }
      return $this;
   }

   protected function _beforeSave()
   {
      
     
     // $request = Mage::getModel('core/request');
      
      $data = $this->getDeletedImages();
      // var_dump($data);
      $product = explode(",",$data);
      // print_r($product);
      // die();
      if($product[0]){
         foreach($product as $image)
         {
         
            $mediaModel = Mage::getModel('catalog/media_gallery')->getCollection()
                                                                 ->addFieldToFilter('file_path',$image)
                                                                 ->addFieldToFilter('product_id',$this->getProductId())
                                                                 ->getData(); 
                                                               
            $imageModel =  Mage::getModel('catalog/media_gallery');
            $imageModel->load($mediaModel[0]->getMediaId())->delete();
         }

      }
   }

   protected function _afterSave()
   {
      $attributes = Mage::getModel('catalog/attribute')->getCollection()->getData();;
      foreach ($attributes as $_attribute) {
         $productAttributes = Mage::getModel('catalog/product_attribute')
            ->getCollection()
            ->addFieldToFilter('product_id', $this->getProductId())
            ->addFieldToFilter("attribute_id", $_attribute->getAttributeId())
            ->getData();
         $value = $this->{$_attribute->getName()};


         if (isset($productAttributes[0])) {
            $productAttributes[0]->setValue($value)->save();
         } else {
            Mage::getModel('catalog/product_attribute')
               ->setAttributeId($_attribute->getAttributeId())
               ->setProductId($this->getProductId())
               ->setValue($value)
               ->save();
         }
      }

      $imageModel = Mage::getModel('catalog/media_gallery');
      $tableName = $imageModel->getResource()->getTableName();

      $existingImage = Mage::getModel('catalog/media_gallery')
                  ->getCollection()
                  ->addFieldToFilter('product_id', $this->getProductId()) 
                  ->getData();
      print_r($existingImage);
      foreach($existingImage as $row){
         $defaultImage = ($row->getFilePath() == $this->getMainImage()) ? 1 : 0;
         $imageModel = Mage::getModel('catalog/media_gallery');
         $imageModel->load($row->getMediaId());
         $imageModel
         // ->setProductId($this->getProductId())
                     // ->setFilePath($target_file)
                     // ->setType($type)
                     ->setDefaultImage($defaultImage)
                     ->save();
         print_r($defaultImage);
      }
   

      if (isset($_FILES[$tableName]['name']['image'])) {
         foreach ($_FILES[$tableName]['name']['image'] as $index => $fileName) {
            if ($_FILES[$tableName]['error']['image'][$index] == 0) {
               $target_dir = "media/product/";
               $target_file = $target_dir . basename($fileName);
               $type = $_FILES[$tableName]['type']['image'][$index];
               $type = substr($type, 0, strpos($type, '/'));

               // Move the uploaded file
               if (move_uploaded_file($_FILES[$tableName]["tmp_name"]['image'][$index], $target_file)) {
                  $defaultImage = ($fileName == $this->getMainImage()) ? 1 : 0;
                  $existingImage = Mage::getModel('catalog/media_gallery')
                  ->getCollection()
                  ->addFieldToFilter('product_id', $this->getProductId())
                  ->addFieldToFilter('file_path', $target_file)
                  ->getData();

                  $existingImage = !empty($existingImage) ? $existingImage[0] : null;
                  // print_r($existingImage);
                  $imageModel = Mage::getModel('catalog/media_gallery');
                  if ($existingImage && is_object($existingImage) && $existingImage->getMediaId()) {
                     $imageModel->load($existingImage->getMediaId());
                  }
                  print_r($imageModel);
                  
                  $imageModel->setProductId($this->getProductId())
                     ->setFilePath($target_file)
                     ->setType($type)
                     ->setDefaultImage($defaultImage)
                     ->save();

                 // echo $existingImage ? "Image updated: $fileName" : "Image added: $fileName";
               } else {
                  echo "Failed to upload file: " . htmlspecialchars($fileName);
               }
            } else {
               echo "Error uploading file: " . htmlspecialchars($fileName);
            }
         }
      }
   }
}
