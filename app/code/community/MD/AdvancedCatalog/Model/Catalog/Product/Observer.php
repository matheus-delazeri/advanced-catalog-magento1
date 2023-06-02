<?php

class MD_AdvancedCatalog_Model_Catalog_Product_Observer
{

    public function setAdvancedData(Varien_Event_Observer $observer)
    {
        $data = $observer->getEvent()->getRequest()->getParam("advanced_catalog");
        $observer->getProduct()->setData("advanced_catalog", $data);

        return $this;
    }

    public function setMetaData(Varien_Event_Observer $observer)
    {
        $helper = Mage::helper("advancedcatalog");
        if ($helper->getConfig("custom_meta", "admin_create_product")) {
            $product = Mage::helper("advancedcatalog/meta")->parseTags($observer->getProduct());
            $observer->setProduct($product);
        }

        return $this;
    }

    public function saveAdvancedProductData(Varien_Event_Observer $observer)
    {
        $advancedData = $observer->getProduct()->getData("advanced_catalog");
        if (isset($advancedData["configurable"])
            && $observer->getProduct()->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE) {
            Mage::getModel("advancedcatalog/catalog_product_type_configurable")
                ->setProduct($observer->getProduct())
                ->saveAssociated($advancedData["configurable"]);
        }

        return $this;
    }

}