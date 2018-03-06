<?php

class RonisBT_Banners_Block_Index extends Mage_Core_Block_Template
{
    public function getBannersContent()
    {
       return Mage::getResourceModel('banners/bannereditor_collection')
           ->addFieldToFilter('block_status', ['eq' => RonisBT_Banners_Model_Source_Status::STATUS_ENABLED])
           ->setOrder('position_sort', 'ASC');
    }

    public function getImageSrc()
    {
        return Mage::getBaseUrl('media'). $this->getImage();
    }
}
