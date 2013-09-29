<?php

class Sean_Clubz_ReferenceController extends Mage_Core_Controller_Front_Action
{
    protected function _initLayout()
    {
        $path_page = Mage::getModuleDir('', 'Sean_Clubz') . DS . 'page-layouts' . DS . 'page.xml';
        $xml = file_get_contents($path_page);

        $layout = Mage::getSingleton('core/layout')
        ->getUpdate()
        ->addUpdate($xml);
    }

    protected function _sendOutput()
    {
        $layout = Mage::getSingleton('core/layout');

        $layout->generateXml()
            ->generateBlocks();

        echo $layout->setDirectOutput(false)->getOutput();
    }

    public function indexAction()
    {
        $this->_initLayout();

        Mage::getSingleton('core/layout')
            ->getUpdate()
            ->addUpdate('
                <reference name="content">
                    <block type="core/text" name="our_message">
                        <action method="setText">
                            <text>Here we go!</text>
                        </action>
                    </block>
                </reference>');

        $this->_sendOutput();
    }

    public function layoutFilesAction()
    {
        $updatesRoot = Mage::app()->getConfig()->getNode('frontend/layout/updates');
        $updateFiles = array();
        foreach($updatesRoot->children() as $updateNode) {
            if ($updateNode->file) {
                $module = $updateNode->getAttribute('module');
                if ($module && Mage::getStoreConfigFlag('advanced/module_disable_output/' . $module)) {
                    continue;
                }
                $updateFiles[] = (string)$updateNode->file;
            }
        }
        $updateFiles[] = 'local.xml';
        var_dump($updateFiles);
    }
}