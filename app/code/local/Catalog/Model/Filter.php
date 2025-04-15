<?php
class Catalog_Model_Filter extends Core_Model_Abstract
{


    public function getProductCollection()
    {
        $collection = Mage::getModel('catalog/product')->getCollection();
        $this->applyFilter($collection);
        return $collection;
    }

    public function applyFilter($collection)
    {
        $request = Mage::getSingleton('core/request');
        $parameter = $request->getQuery();
        // print_r($parameter);
        if (isset($parameter["category_id"])) {
            $categoryIds = is_array($parameter["category_id"])
                ? $parameter["category_id"]
                : explode(',', $parameter["category_id"]);
            // $collection->addCategoryFilter($parameter["category_id"]);
            $collection->addCategoryFilter($categoryIds);
            unset($parameter["category_id"]);
        }
        // echo "<pre>";
        // print_r($collection);
        if (!empty($parameter)) {
            $attribute_collection = Mage::getModel('catalog/attribute')->getCollection()
                ->addFieldToFilter("name", ["IN" => array_keys($parameter)]);
            //print_r($attribute_collection->getData());

            foreach ($attribute_collection->getData() as $attributeData) {
                $collection->addAttributeToFilter($attributeData->getName(), $parameter[$attributeData->getName()]);
            }
        }

        // print_r($this);
    }
}
