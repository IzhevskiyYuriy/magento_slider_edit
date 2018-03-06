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
        $bannerId = (int) $this->getRequest()->getParam('banner_id');
        
        $model = Mage::register('banners_block', Mage::getModel('banners/bannereditor')->load($bannerId));
        $bannerObject =   Mage::getSingleton('adminhtml/session')->getBannerObject(true);
        if (!empty($bannerObject)) {
            $model->setData($bannerObject);
        }
        
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('banners/adminhtml_banners_edit'));
        $this->renderLayout();
        
    }
    
    public function saveAction()
    {
        $postData = $this->getRequest()->getPost();

        if (!empty($postData)) {
            try {
                try {
                    if (isset($_FILES)){
                        if (isset($_FILES['image']['name']) && (file_exists($_FILES['image']['tmp_name']))) {

                            $path = Mage::getBaseDir('media') .DS. 'banners' .DS. 'banners' . DS;
                            $uploader = new Varien_File_Uploader('image');
                            $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                            $uploader->setValidMimeTypes(['image/jpeg', 'image/gif', 'image/png']);
                            $uploader->setAllowRenameFiles(false);
                            $uploader->setFilesDispersion(false);

                            $destFile = $path . $_FILES['image']['name'];
                            $filename = $uploader->getNewFileName($destFile);

                            $uploader
                                ->save($path, $filename);
                            $postData['image'] = 'banners/banners/'.$filename ;
                        }

                    }
                } catch (Exception $e) {
                    Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                    return $this->_redirect('*/*/edit', array('banner_id' => $this->getRequest()->getParam('banner_id')));
                                    }
                //save image
                $model = Mage::getModel("banners/bannereditor")
                    ->addData($postData)
                    ->setId($this->getRequest()->getParam("banner_id"))
                    ->save();

                Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Banners was successfully saved"));

                if ($this->getRequest()->getParam("back")) {
                    return $this->_redirect("*/*/edit", array("banner_id" => $model->getId()));

                }
                return $this->_redirect("*/*/");

            } catch (Exception $e) {
                Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
                return $this->_redirect("*/*/edit", array("banner_id" => $this->getRequest()->getParam("banner_id")));

            }
        }

        $this->_redirect("*/*/");
    }
    
//    public function saveAction()
//    {
//        try {
//            $bannerId = (int) $this->getRequest()->getParam('banner_id');
//            $model = Mage::getModel('banners/bannereditor')->load($bannerId);
//
//            $this->_uploadImage('image', $model);
//            $model
//                ->setData($this->getRequest()->getParams())
//                ->save();
//
//            Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Banners was successfully saved"));
//
//            if ($this->getRequest()->getParam("back")) {
//                return $this->_redirect("*/*/edit", array("banner_id" => $model->getId()));
//
//            }
//            return $this->_redirect("*/*/");
//
//        } catch(Exception $e) {
//            Mage::logException($e);
//            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
//           return  $this->_redirect("*/*/edit", array("banner_id" => $this->getRequest()->getParam("banner_id")));
//        }
//
//        $this->_redirect("*/*/");
//    }  }

    
    public function deleteAction()
    {
        if($this->getRequest()->getParam("banner_id") > 0 ) {
            try {
                $model = Mage::getModel("banners/bannereditor")
                    ->setId($this->getRequest()->getParam("banner_id"))
                    ->delete();
                
                Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Banners was successfully deleted"));
                $this->_redirect("*/*/");
            } 
            catch (Exception $e) {
                    Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
                    $this->_redirect("*/*/edit", array("banner_id" => $this->getRequest()->getParam("banner_id")));
            }
        }
        $this->_redirect("*/*/");
    }
    
    public function massStatusAction()
    {
        $statuses = $this->getRequest()->getParams();
        try{
            $banners = Mage::getModel('banners/bannereditor')
                ->getCollection()
                ->addFieldToFilter('banner_id', array('in' => $statuses['massaction']));
        foreach ($banners as $banner) {
            $banner->setBlockStatus($statuses['banner_status'])->save();
        }
        } catch(Exception $e) {
            Mage::logException($e);
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            return $this->_redirect('*/*/');
        }
        Mage::getSingleton('adminhtml/session')->addSuccess('Banners were updated');
        
        return $this->_redirect('*/*/');
    }

}