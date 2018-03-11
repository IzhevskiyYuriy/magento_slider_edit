<?php

class  RonisBT_Banners_Block_Adminhtml_Banners_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

     protected function _prepareCollection()
    {
        $collection = Mage::getModel('banners/bannereditor')->getCollection();

        /* @var $collection Mage_Cms_Model_Mysql4_Block_Collection */
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn("banner_id", array(
            "header" => Mage::helper("banners")->__("ID"),
            "align" =>"right",
            "width" => "50px",
            "type" => "number",
            "index" => "id",
        ));

        $this->addColumn('title', array(
            'header'    => Mage::helper('banners')->__('Title'),
            'index'     => 'title',
        ));

        $this->addColumn("url", array(
            "header" => Mage::helper("banners")->__("Link"),
            "index" => "url",
        ));

        $this->addColumn("position_sort", array(
            "header" => Mage::helper("banners")->__("Sorting Order"),
            "index" => "position_sort",
        ));

        $this->addColumn("block_status", array(
            "header" => Mage::helper("banners")->__("Status"),
            "index" => "block_status",
            "type"      => "options",
            "options"   => Mage::getModel('banners/source_status')->toArray(),
        ));
        

        return parent::_prepareColumns();
    }

    /**
     * Row click url
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('banner_id' => $row->getId()));
    }
    
    protected function _prepareMassaction() {
       // parent::_prepareMassaction();
        
        $this->setMassactionIdField('banner_id');
        $this->getMassactionBlock()->setIdFieldName('banner_id');
        $this->getMassactionBlock()
                ->addItem('delete',
                    array(
                        'label' => Mage::helper('banners')->__('Delete'),
                        'url' => $this->getUrl('*/*/massDelete'),
                        'confirm' => Mage::helper('banners')->__('Are you sure?')
                    )
                )
                ->addItem('status',
                    array(
                        'label' => Mage::helper('banners')->__('Update status'),
                        'url' => $this->getUrl('*/*/massStatus'),
                        'additional' => array(
                            'banners_status' => array(
                                    'name' => 'banner_status',
                                    'type' => 'select',
                                    'class' => 'required-entry',
                                    'label' => Mage::helper('banners')->__('Status'),
                                    'values' => Mage::getModel('banners/source_status')->toOptionArray()
                                )
                            )
                        
                        )
                );
        return $this;
    }
    
    

}