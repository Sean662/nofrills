<?php
$installer = $this;
$installer->startSetup();

/**
 * Create table 'gorillaeducation_productcomments/comments'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('gorillaeducation_productcomments/comments'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Id')
    ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
    ), 'Product Id')
    ->addColumn('username', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'Username')
    ->addColumn('content', Varien_Db_Ddl_Table::TYPE_TEXT, '2M', array(), 'Content')
    ->addColumn('is_enabled', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
    ), 'Is Enabled')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(), 'Created At')

    ->addForeignKey($installer->getFkName('gorillaeducation_productcomments/comments', 'product_id', 'catalog_product_entity', 'entity_id'),
        'product_id', $installer->getTable('catalog_product_entity'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE
    )
    ->setComment('Product comments');
$installer->getConnection()->createTable($table);

$installer->endSetup();