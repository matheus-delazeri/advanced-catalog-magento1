<?php

class MD_AdvancedCatalog_Block_Adminhtml_Catalog_Product_Edit_Tab_Super_Settings extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Super_Settings
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('settings', array(
            'legend' => Mage::helper('catalog')->__('Select Configurable Attributes ')
        ));

        $product = $this->_getProduct();
        $attributes = $product->getTypeInstance(true)
            ->getSetAttributes($product);

        $fieldset->addField('req_text', 'note', array(
            'text' => '<ul class="messages"><li class="notice-msg"><ul><li>'
                . $this->__('Only attributes with scope "Global", input type "Dropdown" and Use To Create Configurable Product "Yes" are available.')
                . '</li></ul></li></ul>'
        ));

        $hasAttributes = false;

        foreach ($attributes as $attribute) {
            if ($product->getTypeInstance(true)->canUseAttribute($attribute, $product)) {
                $hasAttributes = true;
                $fieldset->addField('attribute_' . $attribute->getAttributeId(), 'checkbox', array(
                    'label' => "[".$attribute->getAttributeCode()."] - " . $attribute->getFrontend()->getLabel(),
                    'title' => $attribute->getFrontend()->getLabel(),
                    'name' => 'attribute',
                    'class' => 'attribute-checkbox',
                    'value' => $attribute->getAttributeId()
                ));
            }
        }

        if ($hasAttributes) {
            $fieldset->addField('attributes', 'hidden', array(
                'name' => 'attribute_validate',
                'value' => '',
                'class' => 'validate-super-product-attributes'
            ));

            $fieldset->addField('continue_button', 'note', array(
                'text' => $this->getChildHtml('continue_button'),
            ));
        } else {
            $fieldset->addField('note_text', 'note', array(
                'text' => $this->__('This attribute set does not have attributes which we can use for configurable product')
            ));

            $fieldset->addField('back_button', 'note', array(
                'text' => $this->getChildHtml('back_button'),
            ));
        }

        $this->setForm($form);
    }
}