<?php
$installer = $this;
$installer->startSetup();

$installer->getConnection()->addColumn($this->getTable('sales/quote_address'), 'statediscount_amount', array(
    'type' => Varien_Db_Ddl_Table::TYPE_DECIMAL,
    'precision' => 10,
    'scale' => 2,
    'nullable'  => false,
    'comment' => 'Statediscount Amount'
));
$installer->getConnection()->addColumn($this->getTable('sales/quote_address'), 'base_statediscount_amount', array(
    'type' => Varien_Db_Ddl_Table::TYPE_DECIMAL,
    'precision' => 10,
    'scale' => 2,
    'nullable'  => false,
    'comment' => 'Base statediscount amount'
));

$installer->getConnection()->addColumn($this->getTable('sales/order'), 'statediscount_amount', array(
    'type' => Varien_Db_Ddl_Table::TYPE_DECIMAL,
    'precision' => 10,
    'scale' => 2,
    'nullable'  => false,
    'comment' => 'Statediscount amount'
));
$installer->getConnection()->addColumn($this->getTable('sales/order'), 'base_statediscount_amount', array(
    'type' => Varien_Db_Ddl_Table::TYPE_DECIMAL,
    'precision' => 10,
    'scale' => 2,
    'nullable'  => false,
    'comment' => 'Base statediscount amount'
));

$installer->endSetup();