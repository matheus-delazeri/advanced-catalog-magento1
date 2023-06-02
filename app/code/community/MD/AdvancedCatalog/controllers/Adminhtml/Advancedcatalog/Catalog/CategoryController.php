<?php

class MD_AdvancedCatalog_Adminhtml_Advancedcatalog_Catalog_CategoryController extends Mage_Adminhtml_Controller_Action
{
    protected function _isAllowed()
    {
        return true;
    }

    protected function _initCategory($getRootInstead = false)
    {
        $this->_title($this->__('Catalog'))
            ->_title($this->__('Categories'))
            ->_title($this->__('Manage Categories'));

        $categoryId = (int)$this->getRequest()->getParam('id', false);
        $category = Mage::getModel('catalog/category');
        $category->setStoreId(0);

        if ($categoryId) {
            $category->load($categoryId);
            $rootId = Mage::app()->getStore(0)->getRootCategoryId();
            if (!in_array($rootId, $category->getPathIds())) {
                if ($getRootInstead) {
                    $category->load($rootId);
                } else {
                    $this->_redirect('*/*/bulkDelete', array('_current' => true, 'id' => null));
                    return false;
                }
            }
        }

        Mage::register('category', $category);
        Mage::register('current_category', $category);
        return $category;
    }

    public function bulkDeleteAction()
    {
        if ($categoryIds = $this->getRequest()->getParam("category_ids")) {
            $categoryIds = array_unique(explode(",", $categoryIds));
            Mage::getModel("advancedcatalog/catalog_category")->bulkDelete($categoryIds);
            Mage::getSingleton("core/session")
                ->addSuccess(Mage::helper("advancedcatalog")->__("Successfully deleted categories!"));
            $this->_redirectReferer();
        } else {
            $this->loadLayout();
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            $this->renderLayout();
        }
    }

    public function categoriesJsonAction()
    {
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('advancedcatalog/adminhtml_catalog_category_tree')
                ->getCategoryChildrenJson($this->getRequest()->getParam('category'))
        );
    }
}
