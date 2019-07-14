<?php

##eloom.licenca##

class Eloom_Bling_Adminhtml_NfeController extends Mage_Adminhtml_Controller_Action {

  private $logger;

  protected function _construct() {
    $this->logger = Eloom_Bootstrap_Logger::getLogger(__CLASS__);
    parent::_construct();
  }

  function sendNfeOutAction() {
    try {
      $orderIds = $this->getRequest()->getParam('order_ids');
      $this->responseMessageOut($orderIds);
    } catch (Exception $e) {
      Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
    }

    $this->_redirectReferer();
  }

  protected function responseMessageOut(array $orderIds) {
    if (!is_array($orderIds)) {
      Mage::getSingleton('adminhtml/session')->addError(Mage::helper('tax')->__('Please select Order(s).'));
    }
    $nfeService = Mage::getModel('eloom_bling/service_nfe_out');
    foreach ($orderIds as $orderId) {
      try {
        $nfeService->send($orderId);
      } catch (Exception $exc) {
        $this->logger->error(sprintf("Pedido %s - %s", $orderId, $exc->getTraceAsString()));
      }
    }
    foreach (Eloom_Bling_Result::getInstance()->getSuccessMessages() as $message) {
      Mage::getSingleton('adminhtml/session')->addSuccess($message);
    }
    foreach (Eloom_Bling_Result::getInstance()->getErrorsMessages() as $message) {
      Mage::getSingleton('adminhtml/session')->addError($message);
    }
    Eloom_Bling_Result::getInstance()->reset();
  }

  // FIXME: implementar permissões por usuário
  protected function _isAllowed() {
    return true;
    //return Mage::getSingleton('admin/session')->isAllowed('admin_eloom_bling/adminhtml_nfe');
  }

}
