<?php

class MD_AdvancedCatalog_Block_Adminhtml_Catalog_Product_Edit_Quick
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $value = $row->getData($this->getColumn()->getIndex());
        if (!$entityId = $row->getData("entity_id")) return $value;
        return "
            <div>
            <span class='advanced-catalog-quick-edit' data-entity-id='$entityId' data-attribute='{$this->getColumn()->getIndex()}'>$value</span>
            <a class='advanced-catalog-quick-edit-btn'>Edit</a>
            </div>
        ";
    }
}
