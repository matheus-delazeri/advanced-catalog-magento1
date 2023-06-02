<?php

class MD_AdvancedCatalog_Block_Catalog_Layer_Filter_Attribute extends Mage_Catalog_Block_Layer_Filter_Attribute
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('advancedcatalog/layer/filter.phtml');
    }
}