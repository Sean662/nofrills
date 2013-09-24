<?php
$installer = $this;
$installer->startSetup();

$installer->getConnection()->addIndex($installer->getTable('gorillaeducation_statediscounts/discounts'), 'directory_country_region_id(directory_country_region_id)',
    'directory_country_region_id',
    Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
);

$installer->endSetup();