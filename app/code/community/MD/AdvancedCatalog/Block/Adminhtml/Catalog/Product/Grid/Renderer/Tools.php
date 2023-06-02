<?php

class MD_AdvancedCatalog_Block_Adminhtml_Catalog_Product_Grid_Renderer_Tools
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $product = Mage::getModel("catalog/product")->load($row->getData("entity_id"));
        $toolsHTML = "<div style='display: flex; grid-column-gap: 5px'>";

        if ($product->getVisibility() != Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE
            && $product->getStatus() != Mage_Catalog_Model_Product_Status::STATUS_DISABLED) {
            $toolsHTML .= "<a target='_blank' href='{$product->getProductUrl()}'><i class='fa fa-external-link'></i></a>";
        }

        if ($product->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE) {
            $windowName = Mage::helper("advancedcatalog")->__("Associated Products");
            $associatedPopUpURL = Mage::helper("adminhtml")
                ->getUrl("adminhtml/advancedcatalog_catalog_product/associatedGridPopUp",
                    array("id" => $product->getId()));
            $toolsHTML .= '<a onClick=
                "let assocWin = window.open(\''.$associatedPopUpURL.'\', \''.$windowName.'\', \'width=1400,height=700,resizable=1,scrollbars=1\');assocWin.focus()">
                <i class="fa fa-cogs"></i>
            </a>';
        }

        return $toolsHTML . "</div>";
    }
}

