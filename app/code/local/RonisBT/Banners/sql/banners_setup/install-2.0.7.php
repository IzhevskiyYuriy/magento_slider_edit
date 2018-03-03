<?php
/** @var Mage_Core_Model_Resource_Setup $installer */
$installer = $this;
$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($this->getTable('banners/bannereditor'))
    ->addColumn('banner_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'identity' => true,
        'unsigned' => true,
        'nullable' => false,
        'primary' => true
    ])
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, [
        'nullable' => false,
    ])
    ->addColumn('url', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, [
        'nullable' => false,
    ])
    ->addColumn('image', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, [
        'nullable' => false,
    ])
    ->addColumn('position_sort', Varien_Db_Ddl_Table::TYPE_INTEGER, null, [
        'nullable' => false,
    ])
    ->addColumn('block_status', Varien_Db_Ddl_Table::TYPE_TINYINT, null, [
        'nullable' => false,
    ]);

$installer->getConnection()->createTable($table);
$installer->endSetup();
