<?php

class Gorillaeducation_Productcomments_Model_Resource_Comments extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('gorillaeducation_productcomments/comments', 'id');
    }
}