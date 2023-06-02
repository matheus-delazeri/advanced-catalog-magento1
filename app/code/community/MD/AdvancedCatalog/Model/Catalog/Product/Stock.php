<?php

class MD_AdvancedCatalog_Model_Catalog_Product_Stock extends MD_AdvancedCatalog_Model_Catalog_Product
{
    public function getStockData($stock)
    {
        return array(
            'manage_stock' => (int)isset($stock['qty']),
            'is_in_stock' => (int)isset($stock['qty']) && $stock['qty'] > 0,
            'qty' => isset($stock['qty']) ? $stock['qty'] : 0,
            'stock_id' => 1,
            'store_id' => 1
        );
    }

    public function updateQty($productId, $newQty)
    {
        $stockItem = Mage::getModel('cataloginventory/stock_item')->loadByProduct($productId);
        $stockItem->addData(array(
            'qty' => $newQty,
            'is_in_stock' => (bool)$newQty
        ));
        $stockItem->save();
    }
}