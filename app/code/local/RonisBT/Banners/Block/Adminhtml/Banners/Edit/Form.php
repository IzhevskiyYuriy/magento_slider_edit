<?php

class RonisBT_Banners_Block_Adminhtml_Banners_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    /**
     * Init form
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('block_form');
        $this->setTitle(Mage::helper('banners')->__('Block Information'));
    }

    /**
     * Load Wysiwyg on demand and Prepare layout
     */
    /*
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
    }
*/
    protected function _prepareForm()
    {
        
        $model = Mage::registry('banners_block');

        $form = new Varien_Data_Form(
            array(
                "id" => "edit_form",
                "action" => $this->getUrl("*/*/save", array("banner_id" => $this->getRequest()->getParam("banner_id"))),
                "method" => "post",
                "enctype" =>"multipart/form-data",
                )
        );

        $form->setHtmlIdPrefix('block_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('banners')->__('Item Information'), 'class' => 'fieldset-wide'));

        if ($model->getBlockId()) {
            $fieldset->addField('block_id', 'hidden', array(
                'name' => 'block_id',
            ));
        }

        $fieldset->addField('title', 'text', array(
            'name'      => 'title',
            'label'     => Mage::helper('banners')->__('Title'),
            'title'     => Mage::helper('banners')->__('Banner title'),
            'required'  => true,
        ));
        
        $fieldset->addField('url', 'text', array(
            'name'      => 'url',
            'label'     => Mage::helper('banners')->__('Link'),
            'title'     => Mage::helper('banners')->__('Banner link'),
            'required'  => true,
        ));
        
        $fieldset->addField('image', 'file', array(
            'name'      => 'image',
            'label'     => Mage::helper('banners')->__('Image'),
            'title'     => Mage::helper('banners')->__('Banner image'),
            'required'  => true,
        ));
        
        $fieldset->addField('position_sort', 'text', array(
            'name'      => 'position_sort',
            'label'     => Mage::helper('banners')->__('Position sort'),
            'title'     => Mage::helper('banners')->__('Position sort'),
            'required'  => true,
        ));
        
        
        $fieldset->addField('block_status', 'select', array(
            'label'     => Mage::helper('banners')->__('Status'),
            'title'     => Mage::helper('banners')->__('Banner status'),
            'name'      => 'block_status',
            'index'     => "block_status",
            'required'  => true,
            'options'   => Mage::getModel('banners/source_status')->toArray(),
        ));
        
       
        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

}