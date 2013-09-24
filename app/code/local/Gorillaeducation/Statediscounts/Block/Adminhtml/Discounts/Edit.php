<?php

class Gorillaeducation_Statediscounts_Block_Adminhtml_Discounts_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Init class
     */
    public function __construct()
    {
        $this->_blockGroup = 'gorillaeducation_statediscounts';
        $this->_controller = 'adminhtml_discounts';

        parent::__construct();

        $this->_updateButton('save', 'label', $this->__('Save Discounts'));
        $this->_updateButton('delete', 'label', $this->__('Delete Discounts'));
    }

    /**
     * Get Header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        if (Mage::registry('gorillaeducation_statediscounts')->getId()) {
            return $this->__('Edit Discounts');
        }
        else {
            return $this->__('New Discounts');
        }
    }
}