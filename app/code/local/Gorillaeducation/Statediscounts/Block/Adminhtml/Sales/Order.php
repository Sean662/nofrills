<?php

class Gorillaeducation_Statediscounts_Block_Adminhtml_Sales_Order extends Mage_Sales_Block_Order_Totals {

    protected function _initTotals() {
        parent::_initTotals();
        $amt = $this->getSource()->getStatediscountAmount();
        $baseAmt = $this->getSource()->getBaseStatediscountAmount();
        if ($amt != 0) {
            $this->addTotal(new Varien_Object(array(
                'code' => 'state',
                'value' => $amt,
                'base_value' => $baseAmt,
                'label' => 'State\'s Discount',
            )), 'discount');
        }
        return $this;
    }

}