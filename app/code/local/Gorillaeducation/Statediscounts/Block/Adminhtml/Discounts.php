<?php

class Gorillaeducation_Statediscounts_Block_Adminhtml_Discounts extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'gorillaeducation_statediscounts';
        $this->_controller = 'adminhtml_discounts';
        $this->_headerText = $this->__('State\'s Discounts');

        parent::__construct();
    }
}