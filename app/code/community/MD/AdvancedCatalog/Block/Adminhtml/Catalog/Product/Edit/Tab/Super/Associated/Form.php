<?php

class MD_AdvancedCatalog_Block_Adminhtml_Catalog_Product_Edit_Tab_Super_Associated_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected $_helper;
    protected $_fieldset;

    public function _construct()
    {
        parent::_construct();
        $this->_helper = Mage::helper("advancedcatalog");
    }

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->_fieldset = $form->addFieldset('advanced_catalog_configurable_associated_fieldset', array('legend' => $this->_helper->__('Associated Products')));
        if ($configurableSettings = $this->getParentBlock()->getData("configurable_settings")) {
            $configurableAttributesIds = array_map(function ($setting) {
                return $setting["attribute_id"];
            }, $configurableSettings);
            $this->_fieldset->addField("divider_1", "label", array(
                'title' => '',
                'label' => '',
                'after_element_html' => "<h4 style='text-align: center;font-weight: bold'>" . $this->_helper->__("Required Attributes") . "</h4>"
            ));
            $this->_fieldset->addField("advanced_super_weight", 'text', array(
                'name' => "advanced_catalog[configurable][weight]",
                'title' => $this->_helper->__("Weight"),
                'label' => $this->_helper->__("Weight"),
                'after_element_html' => "<p class='note'>" . $this->_helper->__("Above weight will be applied to all new associated products.") . "</p>",
                'class' => 'validate-number validate-zero-or-greater validate-number-range number-range-0-99999999.9999'
            ));

            $requiredAttributes = Mage::getResourceModel("catalog/product_attribute_collection")
                ->addFieldToFilter("is_required", true)
                ->addFieldToFilter("is_user_defined", true)
                ->addFieldToFilter("main_table.attribute_id", array("nin" => $configurableAttributesIds));
            $this->addAttributesField($requiredAttributes);
            $this->_fieldset->addField("divider_2", "label", array(
                'title' => '',
                'label' => '',
                'after_element_html' => "<hr><br><h4 style='text-align: center;font-weight: bold'>" . $this->_helper->__("Association Attributes") . "</h4>"
            ));

            foreach ($configurableAttributesIds as $attributesId) {
                $attribute = Mage::getModel("advancedcatalog/attribute")
                    ->load($attributesId);
                $this->_fieldset->addField("advanced_super_attribute_" . $attribute->getId(), 'text', array(
                    'title' => $this->_helper->__("[" . $attribute->getAttributeCode() . "] - " . $attribute->getFrontendLabel()),
                    'label' => $this->_helper->__("[" . $attribute->getAttributeCode() . "] - " . $attribute->getFrontendLabel()),
                    'after_element_html' => "<button type='button' class='scalable advanced-super-quick-options'><i class='fa fa-bolt'></i></button><p class='note'>" . $this->_helper->__("Insert an option for <b>%s</b> and press <b><kbd>Enter</kbd></b> to add it", $attribute->getFrontendLabel()) . "</p>",
                    'class' => 'validate-no-html-tags association-attribute'
                ));
            }

            $customAttributesIds = array_diff($this->_helper->getConfig("quick_configurable_custom_attributes", "admin_create_product", true),
                $configurableAttributesIds, $requiredAttributes->getAllIds());
            $customAttributes = Mage::getResourceModel("catalog/product_attribute_collection")
                ->addFieldToFilter("main_table.attribute_id", array("in" => $customAttributesIds));
            if ($customAttributes->count()) {
                $this->_fieldset->addField("divider_3", "label", array(
                    'title' => '',
                    'label' => '',
                    'after_element_html' => "<hr><br><h4 style='text-align: center;font-weight: bold'>" . $this->_helper->__("Custom Attributes") . "</h4>"
                ));
                $this->addAttributesField($customAttributes, "custom");
            }
        }
        $this->setForm($form);

        return parent::_prepareForm();
    }

    protected function addAttributesField($collection, $prefix = "required")
    {
        foreach ($collection as $attribute) {
            $attributeType = $attribute->getFrontendInput();
            $this->_fieldset->addField("advanced_attribute_" . $attribute->getId(), $attributeType, array(
                'label' => $this->_helper->__("[" . $attribute->getAttributeCode() . "] - " . $attribute->getFrontendLabel()),
                'name' => "advanced_catalog[configurable][{$prefix}_attributes][" . $attribute->getAttributeCode() . "]",
                'after_element_html' => "<p class='note'>" . $this->_helper->__("This attribute will be used in associated products") . "<p>",
                'class' => 'validate-no-html-tags',
                'values' => $attribute->getSource()->getAllOptions()
            ));
        }
    }

}

