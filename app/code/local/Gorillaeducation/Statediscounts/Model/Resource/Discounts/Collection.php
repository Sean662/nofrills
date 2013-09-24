<?php

class Gorillaeducation_Statediscounts_Model_Resource_Discounts_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('gorillaeducation_statediscounts/discounts');
    }
}