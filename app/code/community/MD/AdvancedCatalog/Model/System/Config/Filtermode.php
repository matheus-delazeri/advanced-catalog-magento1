<?php

class MD_AdvancedCatalog_Model_System_Config_Filtermode extends Mage_Core_Model_Abstract
{
    public function toOptionArray()
    {
        $helper = Mage::helper("advancedcatalog");
        return array(
            array("label" => $helper->__("Accordion"), "value" => $helper->__("accordion")),
            array("label" => $helper->__("Default"), "value" => $helper->__("default"))
        );
    }
}
