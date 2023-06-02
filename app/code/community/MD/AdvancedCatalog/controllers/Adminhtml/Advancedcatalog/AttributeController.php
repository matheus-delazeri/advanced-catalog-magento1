<?php

class MD_AdvancedCatalog_Adminhtml_Advancedcatalog_AttributeController extends Mage_Adminhtml_Controller_Action
{
    protected function _isAllowed()
    {
        return true;
    }

    public function saveAction()
    {
        $attribute = Mage::app()->getRequest()->getParam("");
        Mage::getModel("advancedcatalog/attribute")->create($attribute);
        $this->_redirectReferer();
    }

    public function getAllOptionsAction()
    {
        $attribute = Mage::app()->getRequest()->getParam("attribute");
        $allOptions = Mage::getModel("advancedcatalog/attribute")->getAllOptions($attribute);
        print_r(json_encode($allOptions));
    }

    public function editAction()
    {
        $entityId = Mage::app()->getRequest()->getParam("entity_id");
        $attribute = Mage::app()->getRequest()->getParam("attribute");
        $value = Mage::app()->getRequest()->getParam("value");
        if ($attribute == "qty") {
            Mage::getModel("advancedcatalog/catalog_product_stock")
                ->updateQty($entityId, $value);
        } else {
            Mage::getResourceSingleton('catalog/product_action')
                ->updateAttributes(array($entityId), array($attribute => $value), 0);
        }
    }
}