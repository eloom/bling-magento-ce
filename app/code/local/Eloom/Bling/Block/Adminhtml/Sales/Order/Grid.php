<?php

##eloom.licenca##

class Eloom_Bling_Block_Adminhtml_Sales_Order_Grid extends Mage_Adminhtml_Block_Sales_Order_Grid {

    protected function _prepareMassaction() {
        parent::_prepareMassaction();
        
        $this->getMassactionBlock()->addItem(
                'eloom_bling_nfe_out', array('label' => $this->__('Emitir Nf-e (Saída)'),
            'url' => $this->getUrl('eloom_bling/adminhtml_nfe/sendNfeOut')
                )
        );
    }

}
