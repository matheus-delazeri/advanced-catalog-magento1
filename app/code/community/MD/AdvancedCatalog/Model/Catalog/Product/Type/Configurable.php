<?php

class MD_AdvancedCatalog_Model_Catalog_Product_Type_Configurable extends MD_AdvancedCatalog_Model_Catalog_Product
{
    public function saveAssociated($associationData)
    {
        $this->saveAssociatedAttributesOptions($associationData["attributes"]);
        $simpleProducts = $this->createProductsForAssociation($associationData);
        if (!empty($simpleProducts)) {
            $oldSimpleProducts = $this->_product->getTypeInstance()->getChildrenIds($this->_product->getId())[0];
            /** Associate new products */
            Mage::getResourceModel('catalog/product_type_configurable')
                ->saveProducts($this->_product, array_merge($simpleProducts, $oldSimpleProducts));
        }
    }

    protected function saveAssociatedAttributesOptions($attributes)
    {
        $attributeModel = Mage::getModel("advancedcatalog/attribute");
        foreach ($attributes as $attributeId => $options) {
            if (!empty($options)) {
                $attribute = $attributeModel->load($attributeId);
                $attributeModel->addOptionsIfNotExists($attribute, $options);
            }
        }
    }

    protected function createProductsForAssociation($associationData)
    {
        $simpleProducts = array();

        $allCombinations = $this->getAllCombinations($associationData["attributes"]);
        if (empty($allCombinations)) return $simpleProducts;

        if (!empty($associationData["required_attributes"])) {
            $emptyAttributes = array_filter($associationData["required_attributes"], function ($value) {
                return $value == "";
            });
            if (!empty($emptyAttributes)) {
                Mage::getSingleton("core/session")
                    ->addError($this->_helper->__("Required attributes can't be empty"));
                return $simpleProducts;
            }
        }

        if (!isset($associationData["weight"]) || !$associationData["weight"]) {
            Mage::getSingleton("core/session")
                ->addError($this->_helper->__("Associated products weight can't be empty or 0"));
            return $simpleProducts;
        }

        foreach ($allCombinations as $combination) {
            $sku = $this->_product->getSku();
            $attributes = array();
            foreach ($combination as $attrCode => $option) {
                $sku .= "-{$option['label']}";
                $attributes[$attrCode] = $option["id"];
            }
            if ($this->skuExists($sku)) {
                Mage::getSingleton("core/session")
                    ->addError($this->_helper->__("SKU already exists [%s]", $sku));
                continue;
            }
            if ($this->combinationExists($combination)) {
                Mage::getSingleton("core/session")
                    ->addError($this->_helper->__("Combination %s already associated to this product", $this->_helper->arrayToText($combination, "label")));
                continue;
            }
            $product = $this->_prepareNew($sku);
            $product->addData($attributes);
            $product->addData(array(
                "price" => $this->_product->getPrice(),
                "visibility" => Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE,
                "weight" => (float)$associationData["weight"]
            ));
            if (isset($associationData["required_attributes"])) {
                $product->addData($associationData["required_attributes"]);
            }
            if (isset($associationData["custom_attributes"])) {
                $product->addData($associationData["custom_attributes"]);
            }
            try {
                $product->save();
            } catch (Exception $e) {
                Mage::getSingleton("core/session")
                    ->addError($e->getMessage());
            }
            $simpleProducts[] = $product->getId();
        }

        return $simpleProducts;
    }

    protected function combinationExists($combination)
    {
        $usedProducts = $this->_product->getTypeInstance()->getUsedProducts(null, $this->_product);
        foreach ($usedProducts as $product) {
            $optionsRepeated = 0;
            foreach ($combination as $attributeCode => $option) {
                $attributeValue = $product->getResource()
                    ->getAttribute($attributeCode)
                    ->getFrontend()
                    ->getValue($product);

                if ($attributeValue == $option["label"]) {
                    $optionsRepeated++;
                }
            }
            if ($optionsRepeated == sizeof($combination)) {
                return true;
            }
        }

        return false;
    }

    protected function getAllCombinations($attributes)
    {
        $allCombinations = array(array());
        if ($this->hasMissingFieldAttributes($attributes)) return array();

        foreach ($attributes as $attributeId => $values) {
            $attribute = Mage::getModel("advancedcatalog/attribute")->load($attributeId);
            $attributeCode = $attribute->getAttributeCode();
            $tmp = array();
            foreach ($allCombinations as $combination) {
                foreach ($values as $subKey => $optionLabel) {
                    $newCombination = $combination;
                    $newCombination[$attributeCode] = array(
                        "id" => $attribute->getSource()->getOptionId($optionLabel),
                        "label" => $optionLabel,
                    );
                    $tmp[] = $newCombination;
                }
            }
            $allCombinations = $tmp;
        }

        return $allCombinations;
    }

    protected function hasMissingFieldAttributes($attributes)
    {
        $fieldAttributes = array_filter($attributes);
        $configurableAttributes = $this->_product->getTypeInstance()->getConfigurableAttributesAsArray();
        if (count($fieldAttributes) == 0) return true;
        if (count($fieldAttributes) > 0 && count($fieldAttributes) < count($configurableAttributes)) {
            Mage::getSingleton("core/session")
                ->addError($this->_helper->__("All associative attributes must be filled to create associated products"));
            return true;
        }

        return false;
    }
}