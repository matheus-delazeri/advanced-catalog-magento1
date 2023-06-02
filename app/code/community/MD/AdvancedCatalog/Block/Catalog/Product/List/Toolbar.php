<?php

class MD_AdvancedCatalog_Block_Catalog_Product_List_Toolbar extends Mage_Catalog_Block_Product_List_Toolbar
{

    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('advancedcatalog/product/list/toolbar.phtml');
    }

    public function setCollection($collection)
    {
        $this->_collection = $collection;

        $this->_collection->setCurPage($this->getCurrentPage());

        $limit = (int)$this->getLimit();
        if ($limit) {
            $this->_collection->setPageSize($limit);
        }

        if (Mage::helper("advancedcatalog")->getConfig("out_of_stock_last", "list")) {
            $this->setOutOfStockLast();
        }

        if ($order = $this->getCurrentOrder()) {
            $this->_collection = Mage::getSingleton("advancedcatalog/list_order")
                ->load($order, "order")
                ->applyToCollection($this->_collection);
        }

        return $this;
    }

    public function setAvailableOrders($orders)
    {
        $newOrders = Mage::getModel("advancedcatalog/list_order")->getEnabled();

        parent::setAvailableOrders($orders);

        $this->_availableOrder += $newOrders;

        return $this;
    }

    protected function setOutOfStockLast()
    {
        $stockId = Mage_CatalogInventory_Model_Stock::DEFAULT_STOCK_ID;
        $websiteId = Mage::app()->getStore($this->_collection->getStoreId())->getWebsiteId();

        $this->_collection->getSelect()->joinLeft(
            array('_inv' => $this->_collection->getResource()->getTable('cataloginventory/stock_status')),
            "_inv.product_id = e.entity_id and _inv.website_id=$websiteId and _inv.stock_id=$stockId",
            array('stock_status')
        );
        $this->_collection->addExpressionAttributeToSelect('in_stock', 'IFNULL(_inv.stock_status,0)', array());

        $this->_collection->getSelect()->reset('order');
        $this->_collection->getSelect()->order('in_stock DESC');
    }
}