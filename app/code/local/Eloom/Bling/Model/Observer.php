<?php

##eloom.licenca##

class Eloom_Bling_Model_Observer {

  public function addNfeMassAction($observer) {
    $block = $observer->getEvent()->getBlock();
    if ($block instanceof Mage_Adminhtml_Block_Widget_Grid_Massaction) {
      if ($block->getParentBlock() instanceof Mage_Adminhtml_Block_Sales_Order_Grid) {
        $block->addItem('eloom_bling_nfe_out', array(
          'label' => 'Emitir Nf-e (Saída)',
          'url' => Mage::app()->getStore()->getUrl('eloom_bling/adminhtml_nfe/sendNfeOut'),
        ));
      }
    }
  }
}