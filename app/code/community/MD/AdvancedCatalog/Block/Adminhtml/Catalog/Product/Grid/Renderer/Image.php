<?php

class MD_AdvancedCatalog_Block_Adminhtml_Catalog_Product_Grid_Renderer_Image
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $imageField = Mage::helper("advancedcatalog")->getConfig("image_field", "admin_list");
        $product = Mage::getModel("catalog/product")->load($row->getData("entity_id"));
        try{
            $imageURL = Mage::helper('catalog/image')->init($product, $imageField);
        }
        catch(Exception $e) {
            $imageURL = Mage::getDesign()->getSkinUrl('images/catalog/product/placeholder/image.jpg',array('_area'=>'frontend'));
        }


        return "<img src='{$imageURL}' width='90px' />";
    }
}

