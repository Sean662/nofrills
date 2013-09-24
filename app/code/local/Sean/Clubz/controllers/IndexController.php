<?php

class Sean_Clubz_IndexController extends Mage_Core_Controller_Front_Action
{
    public function helloworldAction()
    {
        $block = new Sean_Clubz_Block_Helloworld();
        echo $block->toHtml();
    }

    public function layoutAction()
    {
        $layout = Mage::getSingleton('core/layout');
        $block  = $layout->createBlock('sean_clubz/helloworld', 'root');
        echo $layout->addOutputBlock('root')->setDirectOutput(false)->getOutput();
    }
}