<?php

class MD_AdvancedCatalog_Block_Adminhtml_Catalog_Product_Edit_Renderer_Quick
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $value = $row->getData($this->getColumn()->getIndex());
        if (is_numeric($value)) {
            $value = floatval($value);
        }
        if (!($entityId = $row->getData("entity_id")) || $value === NULL) return $value;
        return "
            <div>
                <span class='advanced-catalog-quick-edit' data-entity-id='$entityId' data-attribute='{$this->getColumn()->getIndex()}'>$value</span>
                <a class='advanced-catalog-quick-edit-btn' title='Editar'><i class='fa fa-edit'></i></a>
                <a class='advanced-catalog-quick-edit-save' title='Salvar'><i class='fa fa-check'></i></a>
                <a class='advanced-catalog-quick-edit-close' title='Fechar'><i class='fa fa-close'></i></a>
            </div>
        ";
    }
}
