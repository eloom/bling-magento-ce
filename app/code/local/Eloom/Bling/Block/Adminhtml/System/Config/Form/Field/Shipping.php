<?php

##eloom.licenca##

class Eloom_Bling_Block_Adminhtml_System_Config_Form_Field_Shipping extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract {

  protected $_methodsRenderer;

  public function _prepareToRender() {
    $this->addColumn('method', array(
        'label' => Mage::helper('eloom_bling')->__('Método de Frete'),
        'renderer' => $this->_getMethodsRenderer(),
        'style' => 'width:100px',
    ));
    $this->addColumn('bling_carrier', array(
      'label' => Mage::helper('eloom_bling')->__('Bling - Transportadora'),
      'style' => 'width:100px',
    ));
    $this->addColumn('bling_service', array(
        'label' => Mage::helper('eloom_bling')->__('Bling - Serviço'),
        'style' => 'width:200px',
    ));

    $this->_addAfter = false;
    $this->_addButtonLabel = Mage::helper('eloom_bling')->__('Add');
  }

  protected function _getMethodsRenderer() {
    if (!$this->_methodsRenderer) {
      $this->_methodsRenderer = $this->getLayout()->createBlock('eloom_bling/adminhtml_system_config_form_field_shipping_allmethods', '', array('is_render_to_js_template' => true));
    }
    return $this->_methodsRenderer;
  }

  protected function _prepareArrayRow(Varien_Object $row) {
    $row->setData('option_extra_attr_' . $this->_getMethodsRenderer()->calcOptionHash($row->getData('method')), 'selected="selected"');
  }

}
