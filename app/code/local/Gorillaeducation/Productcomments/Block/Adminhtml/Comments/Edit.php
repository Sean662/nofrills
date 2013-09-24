<?php

class Gorillaeducation_Productcomments_Block_Adminhtml_Comments_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Init class
     */
    public function __construct()
    {
        $this->_blockGroup = 'gorillaeducation_productcomments';
        $this->_controller = 'adminhtml_comments';

        parent::__construct();

        $this->_updateButton('save', 'label', $this->__('Save Comment'));
        $this->_updateButton('delete', 'label', $this->__('Delete Comment'));
    }

    /**
     * Get Header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        if (Mage::registry('gorillaeducation_productcomments')->getId()) {
            return $this->__('Edit Comment');
        }
        else {
            return $this->__('New Comment');
        }
    }
}