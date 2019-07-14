<?php

##eloom.licenca##

class Eloom_Bling_IndexController extends Mage_Core_Controller_Front_Action {

  /**
   * Initialize resource model
   */
  protected function _construct() {
    parent::_construct();
  }

  public function indexAction() {
		$collection = Mage::getModel('eloom_bling/nfe')->getCollection();
		$collection->addFieldToSelect('*');
		$collection->addFieldToFilter('tracking_number', array('null' => true));
		$collection->setOrder('entity_id', 'DESC');

		$pageResult = 10;
		$totalRecords = $collection->getSize();
		$num = ($totalRecords / $pageResult);
		$offset = 0;
		$pageValue = 1;

		for ($i = 0; $i < $num; $i++) {
			if($pageValue > 1) {
				$offset = ($pageValue - 1) * $pageResult;
			}

			$collection = $this->getTrackingNumberCollection($pageResult, $offset);

			foreach ($collection as $nfe) {
				try {
					Mage::log(sprintf("Pedido %s, Page %s, offset %s ", $nfe->getId(), $pageResult, $offset));
				} catch (Exception $e) {
					Mage::log($e->getMessage());
				}
			}

			$pageValue++;
		}
		$response = Mage::helper('core')->jsonEncode(array('total' => $totalRecords));

    $this->getResponse()->setHeader('Content-type', 'application/json', true);
    $this->getResponse()->setBody($response);
  }

  protected function getTrackingNumberCollection($pageResult, $offset) {
		$collection = Mage::getModel('eloom_bling/nfe')->getCollection();
		$collection->addFieldToSelect('*');
		$collection->addFieldToFilter('tracking_number', array('null' => true));
		$collection->setOrder('entity_id', 'DESC');
		$collection->getSelect()->limit(intval($pageResult), $offset);

		return $collection;
	}
}
