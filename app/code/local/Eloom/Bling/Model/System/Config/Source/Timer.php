<?php

##eloom.licenca##

class Eloom_Bling_Model_System_Config_Source_Timer {

  const IMMEDIATELY = 'immediately';
  const MANUALLY = 'manually';

  public function toOptionArray() {
    $helper = Mage::helper('eloom_bling');

    return array(
        array('value' => 'manually', 'label' => $helper->__('Será inserido manualmente')),
        array('value' => 'immediately', 'label' => $helper->__('Logo após o Bling gerar')),
        array('value' => '1', 'label' => $helper->__('01 hora após gerado')),
        array('value' => '2', 'label' => $helper->__('02 horas após gerado')),
        array('value' => '3', 'label' => $helper->__('03 horas após gerado')),
        array('value' => '4', 'label' => $helper->__('04 horas após gerado')),
        array('value' => '5', 'label' => $helper->__('05 horas após gerado')),
        array('value' => '6', 'label' => $helper->__('06 horas após gerado')),
        array('value' => '7', 'label' => $helper->__('07 horas após gerado')),
        array('value' => '8', 'label' => $helper->__('08 horas após gerado')),
        array('value' => '9', 'label' => $helper->__('09 horas após gerado')),
        array('value' => '10', 'label' => $helper->__('10 horas após gerado')),
        array('value' => '11', 'label' => $helper->__('11 horas após gerado')),
        array('value' => '12', 'label' => $helper->__('12 horas após gerado')),
        array('value' => '13', 'label' => $helper->__('13 horas após gerado')),
        array('value' => '14', 'label' => $helper->__('14 horas após gerado')),
        array('value' => '15', 'label' => $helper->__('15 horas após gerado')),
        array('value' => '16', 'label' => $helper->__('16 horas após gerado')),
        array('value' => '17', 'label' => $helper->__('17 horas após gerado')),
        array('value' => '18', 'label' => $helper->__('18 horas após gerado')),
        array('value' => '19', 'label' => $helper->__('19 horas após gerado')),
        array('value' => '20', 'label' => $helper->__('20 horas após gerado')),
        array('value' => '21', 'label' => $helper->__('21 horas após gerado')),
        array('value' => '22', 'label' => $helper->__('22 horas após gerado')),
        array('value' => '23', 'label' => $helper->__('23 horas após gerado'))
    );
  }

}
