<?php

class MD_AdvancedCatalog_Helper_Meta extends Mage_Core_Helper_Abstract
{
    const META_CONFIG_PREFIX = "custom_";
    const PRODUCT_VARIABLE_PREFIX = "product_";
    const MIN_KEYWORD_SIZE = 4;
    protected $_metaAttributes;

    public function __construct()
    {
        $this->_metaAttributes = array(
            "meta_title",
            "meta_description",
            "meta_keyword"
        );
    }

    public function parseTags(Mage_Catalog_Model_Product $product)
    {
        $helper = Mage::helper("advancedcatalog");
        foreach ($this->_metaAttributes as $metaAttribute) {
            if ($product->getData($metaAttribute) != "") continue;
            if ($metaText = $helper->getConfig(self::META_CONFIG_PREFIX . $metaAttribute, "admin_create_product")) {
                if (preg_match('/{(.*?)}/', $metaText, $tags) >= 1) {
                    foreach ($tags as $tag) {
                        $attribute = str_replace(self::PRODUCT_VARIABLE_PREFIX, "", $tag);
                        if ($value = (string)$product->getData($attribute)) {
                            if ($metaAttribute == "meta_keyword") {
                                $value = $this->_valueToKeywords($value);
                            }
                            $metaText = str_replace("{" . $tag . "}", $value, $metaText);
                        }
                    }
                }

                $product->setData($metaAttribute, $metaText);
            }
        }

        return $product;
    }

    protected function _valueToKeywords($value)
    {
        $array = explode(" ", $value);
        $excludeWords = explode(",", Mage::helper("advancedcatalog")
            ->getConfig("custom_meta_keyword_exclude", "admin_create_product"));

        return ucwords(strtolower(implode(", ",
            array_filter($array, function ($word) use ($excludeWords) {
                return strlen($word) >= self::MIN_KEYWORD_SIZE && !preg_match('~[0-9]+~', $word) && !in_array($word, $excludeWords);
            })
        )));
    }

}

