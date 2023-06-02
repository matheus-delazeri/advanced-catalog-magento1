<?php

class MD_AdvancedCatalog_Model_Catalog_Category extends Mage_Core_Model_Abstract
{
    public function bulkDelete($categoryIds)
    {
        foreach ($categoryIds as $id) {
            if (in_array($id, array(1,2,""))) continue; # Avoid root categories deletion
            $_category = Mage::getModel("catalog/category")->load($id);
            if (!$_category->getId()) continue;
            $_category->delete();
        }
    }
}
