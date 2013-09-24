<?php

class Gorillaeducation_Statediscounts_Model_Sales_Quote_Address_Total_State extends Mage_Sales_Model_Quote_Address_Total_Abstract
{
    public function __construct()
    {
        $this->setCode('state');
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return Mage::helper('gorillaeducation_statediscounts')->__('State\'s Discounts');
    }

    /**
     * Collect totals information about insurance
     *
     * @param   Mage_Sales_Model_Quote_Address $address
     *
     * @return Gorillaeducation_Statediscounts_Model_Sales_Quote_Address_Total_State
     */
    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        parent::collect($address);

        if (($address->getAddressType() == 'shipping')) {
            $quote = $address->getQuote();

            $address->setStatediscountAmount(0);
            $address->setBaseStatediscountAmount(0);

            $shipping_region_id = $quote->getShippingAddress()->getRegionId();

            if ($shipping_region_id) {
                $state_discount = Mage::getModel('gorillaeducation_statediscounts/discounts')->load((int)$shipping_region_id, 'directory_country_region_id');

                if ($state_discount->getDiscount() && (float)$state_discount->getDiscount() > 0) {
                    $totals = array_sum($address->getAllTotalAmounts());
                    $baseTotals = array_sum($address->getAllBaseTotalAmounts());

                    $address->setStatediscountAmount(-$totals * $state_discount->getDiscount() / 100);
                    $address->setBaseStatediscountAmount(-$baseTotals * $state_discount->getDiscount() / 100);

                    $address->setGrandTotal($address->getGrandTotal() + $address->getStatediscountAmount());
                    $address->setBaseGrandTotal($address->getBaseGrandTotal() + $address->getBaseStatediscountAmount());
                }
            }
        }

        return $this;
    }

    /**
     * Add giftcard totals information to address object
     *
     * @param   Mage_Sales_Model_Quote_Address $address
     *
     * @return Gorillaeducation_Statediscounts_Model_Sales_Quote_Address_Total_State
     */
    public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
        if ($address->getAddressType() == 'shipping') {
            $address->addTotal(array(
                'code'  => $this->getCode(),
                'title' => $this->getLabel(),
                'value' => $address->getStatediscountAmount(),
            ));
        }

        return $this;
    }
}
