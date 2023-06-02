<?php

class MD_AdvancedCatalog_Block_Adminhtml_Catalog_Category_Edit_Buttons extends Mage_Adminhtml_Block_Catalog_Category_Abstract
{
    public function addButtons()
    {
        $bulkDeleteURL = Mage::helper("adminhtml")->getUrl("adminhtml/advancedcatalog_catalog_category/bulkDelete");
        $this->getParentBlock()->getChild('form')
            ->addAdditionalButton('bulk-delete-categories', array(
                'label' => $this->helper('advancedcatalog')->__('Bulk Delete Categories'),
                'class' => 'delete',
                'onclick' => "window.location = '$bulkDeleteURL'"
            ));
        return $this;
    }
}