<?php

class RonisBT_Banners_Model_Source_Status extends Varien_Object
{
    const STATUS_ENABLED	= 1;
    const STATUS_DISABLED	= 0;

   public function toOptionArray()
    {
        return array(
            array('value' => self::STATUS_ENABLED , 'label' => Mage::helper('banners')->__('Enabled')),
            array('value' => self::STATUS_DISABLED  , 'label' => Mage::helper('banners')->__('Disabled'))

        );
    }

    public function toArray()
    {
        return array (
          self::STATUS_ENABLED => Mage::helper('banners')->__('Enabled'),
          self::STATUS_DISABLED => Mage::helper('banners')->__('Disabled'),

        );
    }
}