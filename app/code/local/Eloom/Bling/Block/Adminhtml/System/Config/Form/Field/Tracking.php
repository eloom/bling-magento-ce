<?php

##eloom.licenca##

class Eloom_Bling_Block_Adminhtml_System_Config_Form_Field_Tracking extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract {

  protected $_methodsRenderer;

	protected $_genericMethodsRenderer;

	protected $_trackingOrig;

  public function _prepareToRender() {
    $this->addColumn('method', array(
        'label' => Mage::helper('eloom_bling')->__('Método de Frete do Pedido'),
        'renderer' => $this->_getMethodsRenderer(),
        'style' => 'width:100px',
    ));
		$this->addColumn('code', array(
			'label' => Mage::helper('eloom_bling')->__('Método de Frete do Rastreamento'),
			'renderer' => $this->_getGenericMethodsRenderer(),
			'style' => 'width:100px',
		));
		$this->addColumn('tracking', array(
			'label' => Mage::helper('eloom_bling')->__('Origem do Rastreamento'),
			'renderer' => $this->_getTrackingRenderer(),
			'style' => 'width:100px',
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

	protected function _getGenericMethodsRenderer() {
		if (!$this->_genericMethodsRenderer) {
			$this->_genericMethodsRenderer = $this->getLayout()->createBlock('eloom_bling/adminhtml_system_config_form_field_shipping_allGenericMethods', '', array('is_render_to_js_template' => true));
		}
		return $this->_genericMethodsRenderer;
	}

	protected function _getTrackingRenderer() {
		if (!$this->_trackingOrig) {
			$this->_trackingOrig = $this->getLayout()->createBlock('eloom_bling/adminhtml_system_config_form_field_trackingOrig', '', array('is_render_to_js_template' => true));
		}
		return $this->_trackingOrig;
	}

  protected function _prepareArrayRow(Varien_Object $row) {
    $row->setData('option_extra_attr_' . $this->_getMethodsRenderer()->calcOptionHash($row->getData('method')), 'selected="selected"');
		$row->setData('option_extra_attr_' . $this->_getGenericMethodsRenderer()->calcOptionHash($row->getData('code')), 'selected="selected"');
		$row->setData('option_extra_attr_' . $this->_getTrackingRenderer()->calcOptionHash($row->getData('tracking')), 'selected="selected"');
  }

}
