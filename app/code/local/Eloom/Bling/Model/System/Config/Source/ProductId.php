<?php

##eloom.licenca##

class Eloom_Bling_Model_System_Config_Source_ProductId {

  public function toOptionArray() {
    $helper = Mage::helper('eloom_bling');

    return array(
        //array('value' => 'product_id', 'label' => $helper->__('ID')),
        array('value' => 'sku', 'label' => $helper->__('SKU')),
    );
  }

}
