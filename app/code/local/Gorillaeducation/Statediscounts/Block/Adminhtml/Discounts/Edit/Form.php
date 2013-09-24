<?php

class Gorillaeducation_Statediscounts_Block_Adminhtml_Discounts_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Init class
     */
    public function __construct()
    {
        parent::__construct();

        $this->setId('gorillaeducation_statediscounts_discounts_form');
        $this->setTitle($this->__('Discounts Information'));
    }

    /**
     * Setup form fields for inserts/updates
     *
     * return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $model = Mage::registry('gorillaeducation_statediscounts');

        $form = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method'    => 'post'
        ));

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend'    => Mage::helper('gorillaeducation_statediscounts')->__('Discounts Information'),
            'class'     => 'fieldset-wide',
        ));

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array(
                'name' => 'id',
            ));
        }

        $fieldset->addField('directory_country_region_id', 'select', array(
            'name'      => 'directory_country_region_id',
            'label'     => Mage::helper('gorillaeducation_statediscounts')->__('State'),
            'title'     => Mage::helper('gorillaeducation_statediscounts')->__('State'),
            'values' => Mage::getModel('directory/region')->getCollection()
                ->addFieldToFilter('country_id', array('eq' => 'US'))
                ->toOptionArray(),
            'required'  => true,
        ));

        $fieldset->addField('discount', 'text', array(
            'name'      => 'discount',
            'label'     => Mage::helper('gorillaeducation_statediscounts')->__('Discount'),
            'title'     => Mage::helper('gorillaeducation_statediscounts')->__('Discount'),
            'required'  => true,
        ));

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}