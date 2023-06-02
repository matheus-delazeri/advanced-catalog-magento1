<?php
$installer = $this;
$installer->startSetup();

$installer->run("
DROP TABLE IF EXISTS {$this->getTable('advancedcatalog/list_order')};

CREATE TABLE {$this->getTable('advancedcatalog/list_order')} (
  `id` int(20) unsigned NOT NULL auto_increment,
  `order` text NOT NULL default '',
  `attribute` text NOT NULL default '',
  `renderer` text NOT NULL default '',
  `label` text NOT NULL default '',
  `direction` text NOT NULL default '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$defaultOrders = json_decode(file_get_contents(Mage::getBaseDir('lib') . '/AdvancedCatalog/List/Orders.json'), true);
foreach ($defaultOrders as $order) {
    Mage::getModel("advancedcatalog/list_order")
        ->setData($order)
        ->save();
}

$installer->endSetup();