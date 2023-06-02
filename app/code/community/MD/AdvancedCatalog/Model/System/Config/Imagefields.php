<?php

class MD_AdvancedCatalog_Model_System_Config_Imagefields
{
    public function toOptionArray()
    {
        return array(
            array("value" => "image", "label" => Mage::helper("catalog")->__("Base Image")),
            array("value" => "small_image", "label" => Mage::helper("catalog")->__("Small Image")),
            array("value" => "thumbnail", "label" => Mage::helper("catalog")->__("Thumbnail")),
        );
    }
}
