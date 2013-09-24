<?php

class Gorillaeducation_Statediscounts_Adminhtml_DiscountsController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        // Let's call our initAction method which will set some basic params for each action
        $this->_initAction()
            ->renderLayout();
    }

    public function newAction()
    {
        // We just forward the new action to a blank edit form
        $this->_forward('edit');
    }

    public function editAction()
    {
        $this->_initAction();

        // Get id if available
        $id  = $this->getRequest()->getParam('id');
        $model = Mage::getModel('gorillaeducation_statediscounts/discounts');

        if ($id) {
            // Load record
            $model->load($id);

            // Check if record is loaded
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('This discount no longer exists.'));
                $this->_redirect('*/*/');

                return;
            }
        }

        $this->_title($model->getId() ? $model->getName() : $this->__('New Discount'));

        $data = Mage::getSingleton('adminhtml/session')->getDiscountsData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('gorillaeducation_statediscounts', $model);

        $this->_initAction()
            ->_addBreadcrumb($id ? $this->__('Edit Discount') : $this->__('New Discount'), $id ? $this->__('Edit Discount') : $this->__('New Discount'))
            ->_addContent($this->getLayout()->createBlock('gorillaeducation_statediscounts/adminhtml_discounts_edit')->setData('action', $this->getUrl('*/*/save')))
            ->renderLayout();
    }

    public function deleteAction()
    {
        $discount_id = $this->getRequest()->getParam('id', false);
        try {
            Mage::getModel('gorillaeducation_statediscounts/discounts')->setId($discount_id)->delete();
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('gorillaeducation_statediscounts')->__('State\'s discount successfully deleted'));

            return $this->_redirect('*/*/');
        } catch (Mage_Core_Exception $e){
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        } catch (Exception $e) {
            Mage::logException($e);
            Mage::getSingleton('adminhtml/session')->addError($this->__('Somethings went wrong'));
        }

        $this->_redirectReferer();
    }

    public function saveAction()
    {
        $postData = $this->getRequest()->getPost();
        if ($postData) {
            $model = Mage::getSingleton('gorillaeducation_statediscounts/discounts');
            $model->setData($postData);

            try {
                $model->save();

                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The discount has been saved.'));
                $this->_redirect('*/*/');

                return;
            }
            catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('An error occurred while saving this discount.'));
            }

            Mage::getSingleton('adminhtml/session')->setDiscountsData($postData);
            $this->_redirectReferer();
        }
    }

    public function messageAction()
    {
        $data = Mage::getModel('gorillaeducation_statediscounts/discounts')->load($this->getRequest()->getParam('id'));
        echo $data->getContent();
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('gorillaeducation_statediscounts/adminhtml_discounts_grid')->toHtml()
        );
    }

    /**
     * Initialize action
     *
     * Here, we set the breadcrumbs and the active menu
     *
     * @return Mage_Adminhtml_Controller_Action
     */
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('sales/gorillaeducation_statediscounts_discounts')
            ->_title($this->__('Sales'))->_title($this->__('Discounts'))
            ->_addBreadcrumb($this->__('Sales'), $this->__('Sales'))
            ->_addBreadcrumb($this->__('Discounts'), $this->__('Discounts'));

        return $this;
    }

    /**
     * Check currently called action by permissions for current user
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('sales/gorillaeducation_statediscounts_discounts');
    }

    public function exportCsvAction()
    {
        $fileName   = 'state_discounts.csv';
        $content    = $this->getLayout()->createBlock('gorillaeducation_statediscounts/adminhtml_discounts_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'state_discounts.xml';
        $content    = $this->getLayout()->createBlock('gorillaeducation_statediscounts/adminhtml_discounts_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);

        $response->sendResponse();
        exit;
    }
}