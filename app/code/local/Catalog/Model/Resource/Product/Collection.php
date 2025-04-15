<?php
class Catalog_Model_Resource_Product_Collection extends Core_Model_Resource_Collection_Abstract
{
    public function addAttributeToSelect($attributes)
    {
        // print_r($attributes);
        foreach ($attributes as $attribute) {
            $a = Mage::getModel('catalog/attribute')->load($attribute, "name");
            $attribute_id = $a->getAttributeId();
            // print_r($a);
            $this->leftJoin(["cpa_{$a->getName()}"=>'catalog_product_attribute'], "main_table.product_id = cpa_{$a->getName()}.product_id AND cpa_{$a->getName()}.attribute_id ={$attribute_id } ",
                             [$a->getName() => "value"]);
        }
        return $this;
    }

    public function addAttributeToFilter($attribute,$value)
    {
         $this->addAttributeToSelect([$attribute]);
         //echo "<pre>";
        // print_r($value);
        $valueArray = is_array($value)? $value: explode(',', $value);
       // $value_array = explode(",",$value);
        $this->addFieldToFilter("cpa_{$attribute}.value",["IN"=>$valueArray]);
    }

    public function addCategoryFilter($categoryId){
       
        $this->addFieldToFilter('category_id',["IN"=>$categoryId]);
        return $this; 
    }
}

