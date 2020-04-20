<?php

##eloom.licenca##

class Eloom_Bling_Model_Service_Nfe_Out extends Eloom_Bling_Model_Service_Nfe {

  private $logger;

  public function __construct() {
    $this->logger = Eloom_Bootstrap_Logger::getLogger(__CLASS__);
    $this->nfeToXmlService = Mage::getModel('eloom_bling/service_nfe_outToXml');
    $this->shipmentModel = Mage::getModel('eloom_bling/shipment');
    $this->configModel = Mage::getModel('eloom_bling/config');
    /**
     * config values
     */
    $this->apikey = $this->configModel->getApiKey();
    $this->commentNfe = $this->configModel->getNfeOutComment();
    $this->serieNfe = $this->configModel->getNfeOutSerie();
  }

  public function send($orderId) {
    $this->order = Mage::getModel('sales/order')->load($orderId);

    $isEnabled = $this->configModel->isInitialStatusMappedOnNfeOut($this->order->getStatus());
    if (!$isEnabled) {
      return Eloom_Bling_Result::getInstance()->addErrorMessage(sprintf('Pedido %s - Status não liberado para gerar NF.', $this->order->getIncrementId()));
    }
    $serieNfe = $this->serieNfe;
    if (empty($serieNfe)) {
      return Eloom_Bling_Result::getInstance()->addErrorMessage(sprintf('Pedido %s - Série da NF não informada.', $this->order->getIncrementId()));
    }
    $xml = $this->nfeToXmlService->parseXml($this->order);

    $this->logger->info('XML enviado ao Bling');
    $this->logger->info($xml);

    /**
     * Envia a NF
     */
    $data = array('apikey' => $this->apikey, 'xml' => rawurlencode($xml));
    $response = $this->sendNfe($data);

    if(!$response || $response == null) {
			$message = sprintf('Pedido %s - %s.', $this->order->getIncrementId(), 'Não obteve retorno do Bling. Entre em contato com seu desenvolvedor.');
			Eloom_Bling_Result::getInstance()->addErrorMessage($message);
			$this->logger->error($message);
		} else if (isset($response->retorno->erros)) {
      if (is_array($response->retorno->erros)) {
        foreach ($response->retorno->erros as $error) {
          $message = sprintf('Pedido %s - %s (%s).', $this->order->getIncrementId(), $error->erro->msg, $error->erro->cod);
          Eloom_Bling_Result::getInstance()->addErrorMessage($message);
          $this->logger->error($message);
        }
      }
      if ($response->retorno->erros instanceof stdClass) {
        $error = $response->retorno->erros;
        $message = sprintf('Pedido %s - %s (%s).', $this->order->getIncrementId(), $error->erro->msg, $error->erro->cod);
        Eloom_Bling_Result::getInstance()->addErrorMessage($message);
        $this->logger->error($message);
      }
    } else if ($response->retorno->notasfiscais) {
      $isImmediatelyTimerTracking = $this->configModel->isImmediatelyTimerTracking();
			$shippingMethodCode = $this->configModel->getShippingMethodCode($this->order->getShippingMethod());

      foreach ($response->retorno->notasfiscais as $nf) {
        /**
         * Grava NFE
         */
        $rastreador = $nf->notaFiscal->codigos_rastreamento->codigo_rastreamento;
				if($this->configModel->isTrackingNumberIsNfNumber($shippingMethodCode)) {
					$rastreador = $nf->notaFiscal->numero;
				}
        $nfe = Mage::getModel('eloom_bling/nfe');
        $nfe->create()->setOrderId($this->order->getId())->setStoreId(trim($this->order->getStoreId()))->setBlingNumber(trim($nf->notaFiscal->numero))->setTrackingNumber(($isImmediatelyTimerTracking ? trim($rastreador) : null))->setBlingId(trim($nf->notaFiscal->idNotaFiscal))->save();

        /**
         * Salvando informações no Magento
         */
        if ($isImmediatelyTimerTracking && isset($rastreador)) {
          $this->shipmentModel->createShipment($this->order, $rastreador, $shippingMethodCode);
        }

        /**
         * Muda Status do Pedido
         */
        $toStatus = $this->configModel->getFinalStatusMappedOnNfeOut($this->order->getStatus());
        if ($toStatus) {
          /*
          $state = $this->_getAssignedState($toStatus);
          if($state) {
            $this->order->setState($state, true);
          }
          */
          $comment = "Status alterado automaticamente após sincronizar com Bling.";
          $this->order->addStatusHistoryComment($comment, $toStatus, true);
          $this->order->setStatus($toStatus);
          $this->order->setIsVisibleOnFront(false);
          $this->order->save();
          $this->order->sendOrderUpdateEmail(true, $comment);
        }
        $message = sprintf('Pedido %s - Gerou Nf %s.', $this->order->getIncrementId(), trim($nf->notaFiscal->numero));
        Eloom_Bling_Result::getInstance()->addSuccessMessage($message);
        $this->logger->info($message);
      }
    }
  }

  /**
   * Get the assigned state of an order status
   *
   * @param string order_status
   */
  protected function _getAssignedState($status) {
    $item = Mage::getResourceModel('sales/order_status_collection')
      ->joinStates()
      ->addFieldToFilter('main_table.status', $status)
      ->getFirstItem();

    return $item->getState();
  }

}
