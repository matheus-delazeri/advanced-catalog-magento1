<?php

class MD_AdvancedCatalog_Model_Attribute extends Mage_Core_Model_Abstract
{
    protected $_helper;
    protected $_session;

    const PRODUCT_ENTITY_ID = 4;

    public function _construct()
    {
        parent::_construct();
        $this->_helper = Mage::helper('advancedcatalog');
        $this->_session = Mage::getSingleton("core/session");
        $this->setData("types", array(
            'select' => array(
                'value' => 'int',
                'input' => 'select'
            ),
            'text' => array(
                'value' => 'varchar',
                'input' => 'text'
            )
        ));
        $this->setData("mandatory_fields", array('code', 'label', 'type'));
    }

    public function create($data)
    {
        $missingFields = $this->_helper->validateFields($this->getData("mandatory_fields"), $data);
        if (empty($missingFields)) {
            $data['code'] = $this->clearAttributeCode($data['code']);
            if (!$this->attributeCodeExists($data['code'])) {
                $attribute = $this->createBaseAttribute();
                if ($this->saveAttribute($data, $attribute)) {
                    $this->_session->addSuccess($this->_helper->__("Attribute [%s] successfully created!", $data["label"]));
                }
            } else {
                $this->_session->addError($this->_helper->__("Attribute code [%s] already exists", $data['code']));
            }
        } else {
            $missingFields = array_map(function ($field) {
                return $this->_helper->__($field);
            }, $missingFields);
            $this->_session->addError($this->_helper->__("Missing fields: [%s]", implode(", ", $missingFields)));
        }
    }

    protected function attributeCodeExists($attributeCode)
    {
        $attribute = Mage::getModel('catalog/resource_eav_attribute')->loadByCode('catalog_product', $attributeCode);
        return null !== $attribute->getId();
    }

    private function createBaseAttribute()
    {
        $_attribute = Mage::getModel('eav/entity_attribute');
        $_attribute->setData(
            array(
                'is_required' => false,
                'is_user_defined' => true,
                'default_value' => 0
            ));

        return $_attribute;
    }

    private function saveAttribute($data, $attribute)
    {
        $type = $this->getData("types", $data['type']);
        $code = $data['code'];
        $attribute->setData('attribute_code', $code);
        $attribute->setData('attribute_label', $data['label']);
        $attribute->setData('frontend_label', $data['label']);
        $attribute->setData('backend_type', $type['value']);
        $attribute->setData('frontend_input', $type['input']);
        if ($type['input'] == 'select') {
            $attribute->setData('source_model', 'eav/entity_attribute_source_table');
        }

        $attribute->setData('entity_type_id', self::PRODUCT_ENTITY_ID);
        if ($attribute->save()) {
            $this->addAttributeToDefaultSet(self::PRODUCT_ENTITY_ID, $attribute->getId());
            return true;
        }
        return false;
    }

    public function clearAttributeCode($attrCode)
    {
        $codeWithoutAccents = $this->_helper->removeBRAccents($attrCode);
        $code = substr(str_replace("-", "_", preg_replace('/\s+/', '_', $codeWithoutAccents)), 0, 30);
        return str_replace(array("/", "\\"), "_", $code);
    }

    public function load($id, $field = "attribute_id")
    {
        return Mage::getModel('eav/entity_attribute')->load($id, $field);
    }

    public function addOptionsIfNotExists($attribute, $options)
    {
        if (!is_array($options)) $options = array($options);
        $option = array(
            "attribute_id" => $attribute->getId()
        );
        foreach ($options as $optionLabel) {
            if (!$this->optionExists($attribute, $optionLabel)) {
                $key = $this->clearAttributeCode($optionLabel);
                $option['value'][$key][0] = $optionLabel;
            }
        }

        $setup = new Mage_Eav_Model_Entity_Setup('core_setup');
        $setup->addAttributeOption($option);
    }

    private function addAttributeToDefaultSet($entityTypeId, $attributeId)
    {
        $eavSetupModel = Mage::getModel('eav/entity_setup', 'core_setup');
        $attributeSetId = $eavSetupModel->getDefaultAttributeSetId($entityTypeId);
        $eavSetupModel->addAttributeToGroup($entityTypeId, $attributeSetId, 7, $attributeId, null);
    }

    public function isInDefaultAttributeSet($entity, $attrCode, $item)
    {
        $eavConfig = Mage::getModel('eav/config');
        $attributes = $eavConfig->getEntityAttributeCodes(
            $entity,
            $item
        );

        return in_array($attrCode, $attributes);
    }

    private function optionExists($attribute, $optionLabel)
    {
        foreach ($this->getAllOptions($attribute->getData()) as $option => $label) {
            if ($label == $optionLabel) {
                return true;
            }
        }

        return false;
    }

    public function getAllOptions($attribute)
    {
        $options = array();
        if (!is_array($attribute)) $attribute = array("attribute_code" => $attribute);
        $attribute = Mage::getModel('eav/config')
            ->getAttribute(Mage_Catalog_Model_Product::ENTITY, $attribute['attribute_code']);
        try {
            $allOptions = $attribute->getSource()->getAllOptions();
        } catch (Exception $e) {
            $allOptions = array();
        }
        foreach ($allOptions as $option) {
            $value = $option['value'];
            if ($value != "") {
                $options[$value] = $option['label'];
            }
        }

        return $options;
    }

}
