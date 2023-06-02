<?php

class MD_AdvancedCatalog_Model_Mysql4_List_Order extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('advancedcatalog/list_order', 'id');
    }
}
