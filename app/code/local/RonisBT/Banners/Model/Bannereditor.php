<?php


class RonisBT_Banners_Model_Bannereditor extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('banners/bannereditor');
   }

}