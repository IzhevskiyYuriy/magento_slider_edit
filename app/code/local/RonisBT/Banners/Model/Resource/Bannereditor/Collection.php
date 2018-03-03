<?php

/**
 * Class RonisBT_Banners_Model_Resource_Bannereditor_Collection
 * отвечает за набор данных (коллекции)
 */
class RonisBT_Banners_Model_Resource_Bannereditor_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('banners/bannereditor');
    }

}