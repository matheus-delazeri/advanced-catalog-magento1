<?php

class MD_AdvancedCatalog_Block_Adminhtml_Catalog_Product_Edit_Tab_Super_Attribute extends Mage_Adminhtml_Block_Widget_Form
{
    protected $_helper;
    protected function _construct()
    {
        parent::_construct();
        $this->_helper = Mage::helper("advancedcatalog");
    }

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id' => 'advanced_catalog_new_attribute',
            'action' => $this->getUrl('*/advancedcatalog_attribute/save'),
            'method' => 'post',
            'enctype' => 'multipart/form-data'
        ));
        $fieldset = $form->addFieldset('advanced_catalog_new_attribute_fieldset', array('legend' => $this->_helper->__('New Attribute')));
        $fieldset->addField('type', 'hidden', array(
            'name' => 'attribute[type]',
            'value' => 'select'
        ));
        $fieldset->addField('code', 'text', array(
            'name' => 'attribute[code]',
            'title' => $this->_helper->__('Code'),
            'label' => $this->_helper->__('Code'),
        ));
        $fieldset->addField('label', 'text', array(
            'name' => 'attribute[label]',
            'title' => $this->_helper->__('Label'),
            'label' => $this->_helper->__('Label'),
        ));
        $fieldset->addField('save', 'button', array(
            'value' => $this->_helper->__('Save'),
            'name' => 'save',
            'class' => 'form-button',
            'onclick' => 'jQuery(`#advanced_catalog_new_attribute`).submit()'
        ));

        if (Mage::getSingleton('adminhtml/session')->getFormData()) {
            $_data = Mage::getSingleton('adminhtml/session')->getFormData();
            Mage::getSingleton('adminhtml/session')->setFormData(null);
        } elseif (Mage::registry('form_data')) {
            $_data = Mage::registry('form_data')->getData();
        }
        $form->addValues($_data);

        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

}

