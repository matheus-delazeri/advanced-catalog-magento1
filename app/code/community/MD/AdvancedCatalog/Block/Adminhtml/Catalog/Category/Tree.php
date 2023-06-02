<?php

class MD_AdvancedCatalog_Block_Adminhtml_Catalog_Category_Tree extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Categories
{
    public function __construct()
    {
        $this->setTemplate("advancedcatalog/catalog/category/tree.phtml");
    }

    /**
     * Start with no category selected
     * @return array
     */
    protected function getCategoryIds()
    {
        return array();
    }

    public function isReadonly()
    {
        return false;
    }

}
