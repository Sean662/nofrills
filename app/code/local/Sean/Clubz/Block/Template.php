<?php

class Sean_Clubz_Block_Template extends Mage_Core_Block_Template
{
    public function fetchView($fileName)
    {
        $a = Mage::getModuleDir('', 'Sean_Clubz') .
            DS .
            'design';
        $this->setScriptPath(
            Mage::getModuleDir('', 'Sean_Clubz') .
            DS .
            'design'
        );
        return parent::fetchView($this->getTemplate());
    }
}