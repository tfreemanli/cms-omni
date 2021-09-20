<?php
require_once ('Base.php');

class Controller_Stockinproduct extends Controller_Base {
	
	var $_stockinProduct;
	var $_product;
	var $_stockin;
	
	function Controller_StockinProduct() {
		parent::Controller_Base();
		$this->_stockinProduct =& FLEA::getSingleton('Model_StockinProduct');	
		$this->_product =& FLEA::getSingleton('Model_Product');	
		$this->_stockin =& FLEA::getSingleton('Model_Stockin');
	}
	
	function actionIndex() {
		
	}
	
	function actionAdd() {
		$msg = "";
		
		$stockin_id = (int)$_GET['stockin_id'];
		
		if (isset($_POST['submit'])) {
			$data = array(
				'stockin_id' => $_POST['stockin_id'],
				'product_id' => $_POST['product_id'],
				'price' => $_POST['price'],
				'quantity' => $_POST['quantity'],
			);
			
			if ($this->_stockinProduct->createNew($data)) {
				redirect(url('stockin', 'view', array('id' => $data['stockin_id'])));
			} else {
				$msg = "add new product record failed";
			}			
		}
		
		
		$stock = $this->_stockin->find((int)$stockin_id);
		$productAry = $this->_product->getDropdownArrayWithBranch($stock['branch']);
		
		$viewData = array(
			'msg' => $msg,
			'stockin_id' => $stockin_id,
			'productAry' => $productAry,
		);
		$this->_executeView(TPL_DIR.'stockin_product_add.tpl', $viewData);
		
	}
	
	function actionEdit() {
		$msg = "";
		
		if (isset($_POST['submit'])) {
			$data = array(
				'id' => $_POST['id'],
				'stockin_id' => $_POST['stockin_id'],
				'product_id' => $_POST['product_id'],
				'price' => $_POST['price'],
				'quantity' => $_POST['quantity'],
			);
			
			if ($this->_stockinProduct->editData($data)) {
				redirect(url('stockin', 'view', array('id' => $data['stockin_id'])));
			} else {
				$msg = "update product record failed";
			}			
		}
		
		$stockinProduct = $this->_stockinProduct->find((int)$_GET['id']);
		
		$stock = $this->_stockin->find((int)$stockinProduct['stockin_id']);
		$productAry = $this->_product->getDropdownArrayWithBranch($stock['branch']);
		
		$viewData = array(
			'msg' => $msg,
			'productAry' => $productAry,
			'stockinProduct' => $stockinProduct,
		);
		$this->_executeView(TPL_DIR.'stockin_product_edit.tpl', $viewData);
	}
	
	function actionDel() {
		$this->_stockinProduct->delDataById((int)$_GET['id']);
		redirect(url('stockin', 'view', array(id => (int)$_GET['stockin_id'])));
	}
	
}
?>