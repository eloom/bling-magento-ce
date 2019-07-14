<?php

##eloom.licenca##

class Eloom_Bling_Model_Service_Payment_Proxy extends Mage_Core_Model_Abstract {

	const BOLETO_DAYS = 3;

	static $paymentMethod = null;

  /**
   * Initialize resource model
   */
  protected function _construct() {
    if (!isset(self::$paymentMethod)) {
      self::initPaymentMethod();
    }
    parent::_construct();
  }

  private static function initPaymentMethod() {
    if (!isset(self::$paymentMethod)) {
      self::$paymentMethod = array(
				'eloom_payu_cc' => 'eloom_bling/service_payment_payuCc',
				'eloom_payu_boleto' => 'eloom_bling/service_payment_payuBoleto',
				'eloom_mercadopago_cc' => 'eloom_bling/service_payment_mercadopagoCc',
				'eloom_mercadopago_boleto' => 'eloom_bling/service_payment_mercadopagoBoleto',
				'eloom_pagseguro_cc' => 'eloom_bling/service_payment_pagseguroCc',
				'eloom_pagseguro_boleto' => 'eloom_bling/service_payment_pagseguroBoleto',
	      'eloom_yapay_cc' => 'eloom_bling/service_payment_yapayCc',
	      'eloom_yapay_boleto' => 'eloom_bling/service_payment_yapayBoleto'
      );
    }
  }

  public function parseXml($orderId, $payment) {
    $code = $payment->getMethodInstance()->getCode();

    if (array_key_exists($code, self::$paymentMethod)) {
      $mode = Mage::getModel(self::$paymentMethod[$code]);
      return $mode->prepare($orderId);
    }

		$mode = Mage::getModel('eloom_bling/service_payment_mappedConfig');
		return $mode->prepare($orderId);
  }

}
