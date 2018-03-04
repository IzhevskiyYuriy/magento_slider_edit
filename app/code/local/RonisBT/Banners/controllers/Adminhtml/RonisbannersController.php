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
       
            if ($postData) {
                try {
                    //save image
                    try {
                        if (isset($_FILES)){
                            if ($_FILES['image']['name']) {
                                if ($this->getRequest()->getParam("banner_id")) {
                                        $model = Mage::getModel("banners/bannereditor")->load($this->getRequest()->getParam("banner_id"));
                                            if ($model->getData('image')) {
                                                $io = new Varien_Io_File();
                                                $io->rm(Mage::getBaseDir('media').DS.implode(DS,explode('/',$model->getData('image'))));	
                                            }
                                        }
                                        $path = Mage::getBaseDir('media') . DS . 'banners' . DS .'banners'.DS;
                                        $uploader = new Varien_File_Uploader('image');
                                        $uploader->setAllowedExtensions(array('jpg','png','gif'));
                                        $uploader->setAllowRenameFiles(false);
                                        $uploader->setFilesDispersion(false);
                                        $type = $_FILES[image][type];
                                      //  $implGetType = explode('/', $type);
                                        $destFile = $path.$_FILES['image']['name'];
                                       
                                        $filename = $uploader->getNewFileName($destFile);
                                        
                                       /**
                                        * TODO 
                                        * в модели вынести логику по работет с  картинками 
                                        * .'.'. $implGetType[1]
                                        */
                                       // print_r(strlen($filename));exit;
                                        $uploader->save($path, $filename);
                                        $postData['image'] = 'banners/banners/'.$filename ;
                            }
                        }
                        } catch (Exception $e) {
                            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                            $this->_redirect('*/*/edit', array('banner_id' => $this->getRequest()->getParam('banner_id')));
                            return;
                        }
                            //save image
                            $model = Mage::getModel("banners/bannereditor")
                                ->addData($postData)
                                ->setId($this->getRequest()->getParam("banner_id"))
                                ->save();

                            Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Banners was successfully saved"));
                            Mage::getSingleton("adminhtml/session")->setResponsivebannersliderData(false);
                            if ($this->getRequest()->getParam("back")) {
                                    $this->_redirect("*/*/edit", array("banner_id" => $model->getId()));
                                    return;
                            }
                            $this->_redirect("*/*/");
                            return;
                    } catch (Exception $e) {
                        Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
                        Mage::getSingleton("adminhtml/session")->setResponsivebannersliderData($this->getRequest()->getPost());
                        $this->_redirect("*/*/edit", array("banner_id" => $this->getRequest()->getParam("banner_id")));
                        return;
				}
            }
            
            $this->_redirect("*/*/");
    }
    
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

    
    public function savedAction()
    {
        try {
            $bannerId = (int) $this->getRequest()->getParam('banner_id');
            $banner = Mage::getModel('banners/bannereditor')->load($bannerId);

            /**
             * перечисление параметров формы...
             */
             /*$banner
                     ->setTitle($this->getRequest()->getParams('title'))
                     ->save;
              */       
                     
            $banner
                    ->setData($this->getRequest()->getParams())
                    ->save();

            if (!$banner->getId()) {
                Mage::getSingleton('adminhtml/session')->addData('Cannot save the banner');
            }
        } catch(Exception $e) {
            Mage::logException($e);
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
//            $this->_redirect("*/*/edit", array("banner_id" => $this->getRequest()->getParam("banner_id")));
  //      return;
            
        }
        /**
         *  if saved Success 
         */
        Mage::getSingleton('adminhtml/session')->addSuccess('Banner was saved successfully');
        
        $this->_redirect('*/*/' . $this->getRequest()->getParam('banner', 'index'), array('banner_id' => $banner->getId()));
        //$this->_redirect("*/*/edit", array("banner_id" => $this->getRequest()->getParam("banner_id")));
    //    $this->_redirect("*/*/");

    }

}