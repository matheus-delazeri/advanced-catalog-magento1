<?php

class MD_AdvancedCatalog_Model_System_Config_Quick_Associated_Customattributes
{
    public function toOptionArray()
    {
        $customAttributes = Mage::getResourceModel("catalog/product_attribute_collection")
            ->addFieldToFilter("is_required", false)
            ->addFieldToFilter("is_user_defined", true);

        $optionsArray = array();
        foreach ($customAttributes as $attribute) {
            $optionsArray[] = array("label" => "[".$attribute->getAttributeCode()."] - ". $attribute->getFrontendLabel(), "value" => $attribute->getId());
        }

        return $optionsArray;
    }
}
