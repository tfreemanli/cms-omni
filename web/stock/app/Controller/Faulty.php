<?php
require_once ('Base.php');
FLEA::loadClass('FLEA_Helper_Pager');

class Controller_Faulty extends Controller_Base {
	
	var $_faulty;
	var $_product;
	var $_supplier;
	
	function Controller_Faulty() {
		parent::Controller_Base();
		$this->_faulty =& FLEA::getSingleton('Model_Faulty');
		$this->_product =& FLEA::getSingleton('Model_Product');
		$this->_supplier =& FLEA::getSingleton('Model_Supplier');
	}
	
	function actionIndex() {
		$page = isset($_GET['page']) ? (int)$_GET['page'] : 0;
       	$pagesize = 30;
       	
       	$order = 'faulty_date desc';
       	$pager = new FLEA_Helper_Pager($this->_faulty, $page, $pagesize, null, $condition);
       	
       	$viewData = array(
			'faulties' => $pager->findAll(),
			'pageinfo' => $pager->getPagerData(),
		);
		
		$this->_executeView(TPL_DIR.'faulty_index.tpl', $viewData);
	}
	
	function actionAdd() {
		$msg = '';
		
		if (isset($_POST['submit'])) {
			$data = array(
				'job_num' => $_POST['job_num'],	
				'product_id' => $_POST['product_id'],
				'quantity' => $_POST['quantity'],	
				'operator_id' => $_SESSION['uid'],
				'faulty_date' => time(),
				'supplier_id' => $_POST['supplier_id'],
			);
			
			if ($this->_faulty->addNewFromStock($data)) {
				redirect(url('faulty', 'index'));
			} else {
				$msg = "failed to add new faulty record";
			}		
		}
		if($_SESSION['role']=='admin'){
			$products = $this->_product->getDropdownArray();
		}else{
			$products = $this->_product->getDropdownArrayWithBranch('sylviapark');
		}
		$suppliers = $this->_supplier->getDropdownArray();
		
		$viewData = array(
			'msg' => $msg,
			'products' => $products,
			'suppliers' => $suppliers,
		);
		$this->_executeView(TPL_DIR.'faulty_add.tpl', $viewData);
	}
	
	function actionEdit() {
		$msg = '';
		
		if (isset($_POST['submit'])) {
			$data = array(
				'id' => $_POST['id'],
				'job_num' => $_POST['job_num'],	
				'product_id' => $_POST['product_id'],
				'quantity' => $_POST['quantity'],	
				'operator_id' => $_SESSION['uid'],
				'supplier_id' => $_POST['supplier_id'],
			);
			
			if ($this->_faulty->updateFromStock($data)) {
				redirect(url('faulty', 'index'));
			} else {
				$msg = "failed to update faulty record";
			}		
		}
		
		if($_SESSION['role']=='admin'){
			$products = $this->_product->getDropdownArray();
		}else{
			$products = $this->_product->getDropdownArrayWithBranch('sylviapark');
		}
		$suppliers = $this->_supplier->getDropdownArray();
		
		$faulty = $this->_faulty->find((int)$_GET['id']);
			
		$viewData = array(
			'msg' => $msg,
			'products' => $products,
			'faulty' => $faulty,
			'suppliers' => $suppliers,
		);
		$this->_executeView(TPL_DIR.'faulty_edit.tpl', $viewData);
	}
	
	function actionDel() {
		$this->_faulty->delById((int)$_GET['id']);
		redirect(url('faulty', 'index'));
	}
	
}

?>