<?php

class RonisBT_Banners_Model_Resource_Bannereditor extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('banners/bannereditor', 'banner_id');

    }

}
