<?php

class Gorillaeducation_Productcomments_Block_Adminhtml_Comments extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'gorillaeducation_productcomments';
        $this->_controller = 'adminhtml_comments';
        $this->_headerText = $this->__('Product comments');

        parent::__construct();
    }
}