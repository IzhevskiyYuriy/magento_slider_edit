<?php

class RonisBT_Banners_Block_Adminhtml_Banners_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
       
        $this->_objectId = 'banner_id';
        $this->_controller = 'adminhtml_banners';
        $this->_blockGroup = 'banners';
 
        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('banners')->__('Save Banner'));
        $this->_updateButton('delete', 'label', Mage::helper('banners')->__('Delete Banner'));

        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('banners')->__('Save and Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = 
                "function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
            ";
        
        }
    

    /**
     * Get edit form container header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        
        if (Mage::registry('banners_block')->getId()) {
            return Mage::helper('banners')->__("Edit Banner '%s'", $this->escapeHtml(Mage::registry('banners_block')->getTitle()));
        }
        else {
            return Mage::helper('banners')->__('New Banner');
        }
    }

}

