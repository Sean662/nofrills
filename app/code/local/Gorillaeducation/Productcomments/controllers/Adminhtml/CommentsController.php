<?php

class Gorillaeducation_Productcomments_Adminhtml_CommentsController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_initAction()
            ->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $this->_initAction();

        $id  = $this->getRequest()->getParam('id');
        $model = Mage::getModel('gorillaeducation_productcomments/comments');

        if ($id) {
            $model->load($id);

            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('This comment no longer exists.'));
                $this->_redirect('*/*/');

                return;
            }
        }

        $this->_title($model->getId() ? $model->getName() : $this->__('New Comment'));

        $data = Mage::getSingleton('adminhtml/session')->getCommentsData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('gorillaeducation_productcomments', $model);

        $this->_initAction()
            ->_addBreadcrumb($id ? $this->__('Edit Comment') : $this->__('New Comment'), $id ? $this->__('Edit Comment') : $this->__('New Comment'))
            ->_addContent($this->getLayout()->createBlock('gorillaeducation_productcomments/adminhtml_comments_edit')->setData('action', $this->getUrl('*/*/save')))
            ->renderLayout();
    }

    public function deleteAction()
    {
        $discount_id = $this->getRequest()->getParam('id', false);
        try {
            Mage::getModel('gorillaeducation_productcomments/comments')->setId($discount_id)->delete();
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('gorillaeducation_productcomments')->__('Product comment successfully deleted'));

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
            $model = Mage::getSingleton('gorillaeducation_productcomments/comments');
            $model->setData($postData);

            try {
                $model->save();

                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The comment has been saved.'));
                $this->_redirect('*/*/');

                return;
            }
            catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('An error occurred while saving this discount.'));
            }

            Mage::getSingleton('adminhtml/session')->setCommentsData($postData);
            $this->_redirectReferer();
        }
    }

    public function messageAction()
    {
        $data = Mage::getModel('gorillaeducation_productcomments/comments')->load($this->getRequest()->getParam('id'));
        echo $data->getContent();
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('gorillaeducation_productcomments/adminhtml_comments_grid')->toHtml()
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
            ->_setActiveMenu('catalog/gorillaeducation_productcomments_comments')
            ->_title($this->__('Sales'))->_title($this->__('Comments'))
            ->_addBreadcrumb($this->__('Catalog'), $this->__('Catalog'))
            ->_addBreadcrumb($this->__('Comments'), $this->__('Comments'));

        return $this;
    }

    /**
     * Check currently called action by permissions for current user
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('catalog/gorillaeducation_productcomments_comments');
    }

    public function exportCsvAction()
    {
        $fileName   = 'product_comments.csv';
        $content    = $this->getLayout()->createBlock('gorillaeducation_productcomments/adminhtml_comments_grid')
            ->getCsv();

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