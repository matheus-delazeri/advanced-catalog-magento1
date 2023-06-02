<?php

class MD_AdvancedCatalog_Block_Catalog_Layer_Filter_Decimal extends Mage_Catalog_Block_Layer_Filter_Decimal
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('advancedcatalog/layer/filter.phtml');
    }
}