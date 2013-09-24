<?php

class Gorillaeducation_Productcomments_Block_Adminhtml_Comments_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Init class
     */
    public function __construct()
    {
        parent::__construct();

        $this->setId('gorillaeducation_productcomments_comments_form');
        $this->setTitle($this->__('Product comment Information'));
    }

    /**
     * Setup form fields for inserts/updates
     *
     * return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $model = Mage::registry('gorillaeducation_productcomments');

        $form = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method'    => 'post'
        ));

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend'    => Mage::helper('gorillaeducation_productcomments')->__('Product comment Information'),
            'class'     => 'fieldset-wide',
        ));

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array(
                'name' => 'id',
            ));
        }

        $fieldset->addField('product_id', 'select', array(
            'name'      => 'product_id',
            'label'     => Mage::helper('gorillaeducation_statediscounts')->__('Product'),
            'title'     => Mage::helper('gorillaeducation_statediscounts')->__('Product'),
            'values'    => Mage::getModel('catalog/product')->getCollection()->toOptionArray(),
            'required'  => true,
        ));

        $fieldset->addField('username', 'text', array(
            'name'      => 'username',
            'label'     => Mage::helper('gorillaeducation_productcomments')->__('Username'),
            'title'     => Mage::helper('gorillaeducation_productcomments')->__('Username'),
            'required'  => true,
        ));

        $fieldset->addField('content', 'textarea', array(
            'name'      => 'content',
            'label'     => Mage::helper('gorillaeducation_productcomments')->__('Content'),
            'title'     => Mage::helper('gorillaeducation_productcomments')->__('Content'),
            'required'  => true,
        ));

        $fieldset->addField('is_enabled', 'checkbox', array(
            'label'     => Mage::helper('gorillaeducation_productcomments')->__('Is Enabled'),
            'name'      => 'Checkbox',
            'disabled'  => false,
            'tabindex'  => 1,
            'required'  => true,
        ));

        $fieldset->addField('created_at', 'date', array(
            'name'      => 'created_at',
            'label'     => Mage::helper('gorillaeducation_productcomments')->__('Created At'),
            'title'     => Mage::helper('gorillaeducation_productcomments')->__('Created At'),
            'image'     => $this->getSkinUrl('images/grid-cal.gif'),
            'format'    => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_FULL),
            'time'      => true
        ));



        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}