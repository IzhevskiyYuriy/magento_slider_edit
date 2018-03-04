<?php

class RonisBT_Banners_Adminhtml_RonisbannersController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {

       $this->loadLayout();

       $this->_addContent($this->getLayout()->createBlock('banners/adminhtml_banners'));

       $this->renderLayout();
    }
    
    public function newAction()
    {
        $this->_forward('edit');
        
    }
    
    public function editAction()
    {
        $id = $this->getRequest()->getParam('banner_id');
        
        Mage::register('banners_block', Mage::getModel('banners/bannereditor')->load($id));
          
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('banners/adminhtml_banners_edit'));
        $this->renderLayout();
        
    }
    
    public function saveAction()
    {
        $id = $this->getRequest()->getParam('banner_id');
        $banner = Mage::getModel('banners/bannereditor')->load($id);
        
        $banner
                ->setData($this->getRequest()->getParams())
                ->save();
        
    }

}