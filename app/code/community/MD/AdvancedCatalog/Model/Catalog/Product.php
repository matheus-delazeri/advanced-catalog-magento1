<?php

class MD_AdvancedCatalog_Model_Catalog_Product extends Mage_Core_Model_Abstract
{
    protected $_helper;
    protected $_product;
    protected function _construct()
    {
        parent::_construct();
        $this->_helper = Mage::helper("advancedcatalog");
    }

    public function setProduct($product)
    {
        $this->_product = $product;
        return $this;
    }

    protected function _prepareNew($sku)
    {
        $_product = Mage::getModel('catalog/product');
        $_product
            ->setWebsiteIds(array(1))
            ->setAttributeSetId(4)
            ->setTypeId('simple')
            ->setCreatedAt(strtotime('now'))
            ->setSku($sku)
            ->setStatus(1)
            ->setTaxClassId(0)
            ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
            ->setMsrpEnabled(1)
            ->setMsrpDisplayActualPriceType(4)
            ->setPrice(0)
            ->setWeight(0)
            ->setName($sku)
            ->setDescription($sku)
            ->setShortDescription($sku)
            ->setStockData(Mage::getModel("advancedcatalog/catalog_product_stock")->getStockData(array()))
            ->setMediaGallery(array('images' => array(), 'values' => array()));

        return $_product;
    }

    protected function skuExists($sku)
    {
        return (bool)Mage::getModel('catalog/product')->getIdBySku($sku);
    }
}
