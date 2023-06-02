<?php

class MD_AdvancedCatalog_Model_List_Order extends Mage_Core_Model_Abstract
{
    protected $_helper;

    protected function _construct()
    {
        parent::_construct();
        $this->_helper = Mage::helper("advancedcatalog");
        $this->_init("advancedcatalog/list_order");
    }

    public function getCollection($onlyEnabled = false)
    {
        $collection = parent::getCollection();
        if($onlyEnabled) {
            $ordersEnabled = $this->_helper->getConfig("orders", "list", true);
            $collection->addFieldToFilter("order", array("in" => $ordersEnabled));
        }

        return $collection;
    }

    public function getEnabled()
    {
        $_orders = array();
        $collection = $this->getCollection(true);
        foreach ($collection as $order) {
            $_orders[$order->getData("order")] = $order->getData("label");
        }

        return $_orders;
    }

    public function toOptionArray()
    {
        $_orders = array();
        $collection = $this->getCollection();
        foreach ($collection as $order) {
            $_orders[] = array(
                "value" => $order->getData("order"),
                "label" => $this->_helper->__($order->getData("label"))
            );
        }

        return $_orders;
    }

    public function applyToCollection($collection)
    {
        if($attribute = $this->getData("attribute")) {
            $collection->setOrder($attribute, $this->getData("direction"));
        }

        return $collection;
    }

}
