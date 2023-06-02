<?php

class MD_AdvancedCatalog_Block_Adminhtml_Catalog_Product_Edit_Tab_Super_Associated extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Super_Config
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    public function _construct()
    {
        parent::_construct();
    }

    protected function _prepareLayout()
    {
        $_layout = parent::_prepareLayout();
        $_layout->setTemplate("md/advancedcatalog/catalog/product/edit/super/associated.phtml");
        $this->setConfigurableSettings();
        /** Unset default blocks */
        $_layout->unsetChild("create_empty");
        $_layout->unsetChild("create_from_configurable");
        $_layout->unsetChild("simple");

        $_layout->setChild("associated_form",
            $_layout->getLayout()->createBlock('advancedcatalog/adminhtml_catalog_product_edit_tab_super_associated_form',
                'advanced.catalog.product.edit.tab.super.associated.form')
        );
        $_layout->setChild("grid",
            $_layout->getLayout()->createBlock('advancedcatalog/adminhtml_catalog_product_edit_tab_super_associated_grid',
                'advanced.catalog.product.edit.tab.super.associated.grid')
        );

        return $_layout;

    }

    protected function _getProduct()
    {
        return Mage::registry("current_product");
    }

    public function getConfigurableSettings($product)
    {
        $data = array();
        $attributes = $this->_getProduct()->getTypeInstance(true)
            ->getUsedProductAttributes($this->_getProduct());
        foreach ($attributes as $attribute) {
            $data[] = array(
                'attribute_id' => $attribute->getId(),
                'label' => $product->getAttributeText($attribute->getAttributeCode()),
                'value_index' => $product->getData($attribute->getAttributeCode())
            );
        }

        return $data;
    }

    protected function setConfigurableSettings()
    {
        $this->setData("configurable_settings", $this->getConfigurableSettings($this->_getProduct()));
    }

    public function getTabLabel()
    {
        return Mage::helper('advancedcatalog')->__('Associated Products');
    }

    public function getTabTitle()
    {
        return Mage::helper('advancedcatalog')->__('Associated Products');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }
}
