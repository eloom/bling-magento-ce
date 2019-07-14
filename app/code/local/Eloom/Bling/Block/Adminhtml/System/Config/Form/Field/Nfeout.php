<?php

##eloom.licenca##

class Eloom_Bling_Block_Adminhtml_System_Config_Form_Field_Nfeout extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract {

  protected $_initialStatus;
  protected $_finalStatus;

  public function _prepareToRender() {
    $this->addColumn('initial', array(
        'label' => Mage::helper('eloom_bling')->__('Status Inicial'),
        'renderer' => $this->_getInitialStatus(),
        'style' => 'width:100px',
    ));
    $this->addColumn('operation', array(
        'label' => Mage::helper('eloom_bling')->__('Natureza da Operação'),
        'style' => 'width:150px',
    ));
    $this->addColumn('final', array(
        'label' => Mage::helper('eloom_bling')->__('Status Final'),
        'renderer' => $this->_getFinalStatus(),
        'style' => 'width:100px',
    ));
    $this->_addAfter = false;
    $this->_addButtonLabel = Mage::helper('eloom_bling')->__('Add');
  }

  protected function _getInitialStatus() {
    if (!$this->_initialStatus) {
      $this->_initialStatus = $this->getLayout()->createBlock('eloom_bling/adminhtml_system_config_form_field_order_status', '', array('is_render_to_js_template' => true));
    }
    return $this->_initialStatus;
  }

  protected function _getFinalStatus() {
    if (!$this->_finalStatus) {
      $this->_finalStatus = $this->getLayout()->createBlock('eloom_bling/adminhtml_system_config_form_field_order_status', '', array('is_render_to_js_template' => true));
    }
    return $this->_finalStatus;
  }

  protected function _prepareArrayRow(Varien_Object $row) {
    $row->setData('option_extra_attr_' . $this->_getInitialStatus()->calcOptionHash($row->getData('initial')), 'selected="selected"');
    $row->setData('option_extra_attr_' . $this->_getFinalStatus()->calcOptionHash($row->getData('final')), 'selected="selected"');
  }

}
