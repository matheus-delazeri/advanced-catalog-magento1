<?php

class MD_AdvancedCatalog_Block_Adminhtml_Catalog_Product_Edit_Tab_Super_Associated_Grid extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Super_Config_Grid
{

    protected function _prepareCollection()
    {
        $allowProductTypes = array();
        foreach (Mage::helper('catalog/product_configuration')->getConfigurableAllowedTypes() as $type) {
            $allowProductTypes[] = $type->getName();
        }

        $product = $this->_getProduct();
        $collection = $product->getCollection()
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('sku')
            ->addAttributeToSelect('price')
            ->addFieldToFilter('type_id', $allowProductTypes)
            ->addFilterByRequiredOptions()
            ->joinAttribute('name', 'catalog_product/name', 'entity_id', null, 'inner');

        if (Mage::helper('catalog')->isModuleEnabled('Mage_CatalogInventory')) {
            $collection->joinTable('cataloginventory/stock_item', 'product_id=entity_id', array(
                'is_in_stock',
                'qty'
            ));
        }

        foreach ($product->getTypeInstance(true)->getUsedProductAttributes($product) as $attribute) {
            $collection->addAttributeToSelect($attribute->getAttributeCode());
            $collection->addAttributeToFilter($attribute->getAttributeCode(), array('notnull' => 1));
        }

        $this->setCollection($collection);
        Mage_Adminhtml_Block_Widget_Grid::_prepareCollection();

        if ($this->isReadonly()) {
            $collection->addFieldToFilter('entity_id', array('in' => $this->_getSelectedProducts()));
        }

        return $this;
    }

    protected function _prepareColumns()
    {
        $product = $this->_getProduct();
        $attributes = $product->getTypeInstance(true)->getConfigurableAttributes($product);

        if (!$this->isReadonly()) {
            $this->addColumn('in_products', array(
                'header_css_class' => 'a-center',
                'type' => 'checkbox',
                'name' => 'in_products',
                'values' => $this->_getSelectedProducts(),
                'align' => 'center',
                'index' => 'entity_id',
                'renderer' => 'adminhtml/catalog_product_edit_tab_super_config_grid_renderer_checkbox',
                'attributes' => $attributes
            ));
        }

        $this->addColumn('entity_id', array(
            'header' => Mage::helper('catalog')->__('ID'),
            'sortable' => true,
            'width' => '60px',
            'index' => 'entity_id'
        ));
        $this->addColumn('name', array(
            'header' => Mage::helper('catalog')->__('Name'),
            'index' => 'name'
        ));

        $this->addColumn('sku', array(
            'header' => Mage::helper('catalog')->__('SKU'),
            'width' => '80px',
            'index' => 'sku'
        ));

        $this->addColumn('price', array(
            'header' => Mage::helper('catalog')->__('Price'),
            'type' => 'currency',
            'renderer' => 'advancedcatalog/adminhtml_catalog_product_edit_renderer_quick',
            'currency_code' => (string)Mage::getStoreConfig(Mage_Directory_Model_Currency::XML_PATH_CURRENCY_BASE),
            'index' => 'price'
        ));

        $this->addColumn('qty', array(
            'header' => Mage::helper('catalog')->__('Qty'),
            'renderer' => 'advancedcatalog/adminhtml_catalog_product_edit_renderer_quick',
            'type' => 'number',
            'index' => 'qty'
        ));

        $this->addColumn('is_in_stock', array(
            'header' => Mage::helper('catalog')->__('Stock Availability'),
            'index' => 'is_in_stock',
            'type' => 'options',
            'options' => array(
                1 => Mage::helper('catalog')->__('In Stock'),
                0 => Mage::helper('catalog')->__('Out of Stock')
            )
        ));

        foreach ($attributes as $attribute) {
            $productAttribute = $attribute->getProductAttribute();
            $productAttribute->getSource();
            $this->addColumn($productAttribute->getAttributeCode(), array(
                'header' => $productAttribute->getFrontend()->getLabel(),
                'index' => $productAttribute->getAttributeCode(),
                'type' => $productAttribute->getSourceModel() ? 'options' : 'number',
                'options' => $productAttribute->getSourceModel() ? $this->getOptions($attribute) : ''
            ));
        }

    }

    public function getGridUrl()
    {
        return $this->getUrl('adminhtml/advancedcatalog_catalog_product/associatedGrid', array('_current'=>true));
    }

}

