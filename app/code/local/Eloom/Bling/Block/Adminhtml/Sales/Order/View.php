<?php

##eloom.licenca##

class Eloom_Bling_Block_Adminhtml_Sales_Order_View extends Mage_Adminhtml_Block_Sales_Order_View {

    public function __construct() {
        if (Mage::getModel('eloom_bling/config')->getAllowStatus() != $this->getOrder()->getState()) {
            $this->_addButton('call_to_send_nfe', array('label' => Mage::helper('eloom_bling')->__('Emitir NF-e'),
                'onclick' => 'setLocation(\'' . $this->getUrlSend() . '\')',
                'class' => 'go'), 0, 100, 'header', 'header'
            );
        } else {
            $this->_addButton('call_to_send_order', array(
                'label' => Mage::helper('Sales')->__('Emitir NF-e'),
                'class' => 'disabled'), 0, 100, 'header', 'header'
            );
        }
        parent::__construct();
    }

    public function getUrlSend() {
        return $this->getUrl('eloom_bling/adminhtml_nfe/send');
    }

}
