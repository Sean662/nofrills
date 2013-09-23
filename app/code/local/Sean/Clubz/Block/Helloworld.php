<?php

class Sean_Clubz_Block_Helloworld extends Mage_Core_Block_Template
{
    public function _construct()
    {
        $this->setTemplate('helloworld.phtml');
        return parent::_construct();
    }

    public function _beforeToHtml()
    {
        $block_1 = new Mage_Core_Block_Text();
        $block_1->setText('Block #1.');
        $this->setChild('the_first', $block_1);

        $block_2 = new Mage_Core_Block_Text();
        $block_2->setText('Block #2.');
        $this->setChild('the_second', $block_2);
    }

    public function fetchTitle()
    {
        return 'Hello Fancy World!';
    }
}