<?php

class Sean_Clubz_Block_Youtube extends Mage_Core_Block_Abstract implements Mage_Widget_Block_Interface
{
    protected function _toHtml ()
    {
        return
            '<iframe width="640" height="360" src="//www.youtube.com/embed/nFngGw0biuI?feature=player_detailpage" frameborder="0" allowfullscreen></iframe>'
        ;
    }
}