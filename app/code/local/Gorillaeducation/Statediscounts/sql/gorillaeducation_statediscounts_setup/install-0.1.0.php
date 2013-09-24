<?php
$installer = $this;
$installer->startSetup();

/**
 * Create table 'gorillaeducation_statediscounts/discounts'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('gorillaeducation_statediscounts/discounts'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Id')
    ->addColumn('directory_country_region_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
    ), 'Region Id')
    ->addColumn('discount', Varien_Db_Ddl_Table::TYPE_DECIMAL, '4,2', array(
        'nullable'  => false,
    ))
    ->addForeignKey($installer->getFkName('gorillaeducation_statediscounts/discounts', 'directory_country_region_id', 'directory/country_region', 'region_id'),
        'directory_country_region_id', $installer->getTable('directory/country_region'), 'region_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE
    )
    ->setComment('State Discount');
$installer->getConnection()->createTable($table);

$installer->endSetup();