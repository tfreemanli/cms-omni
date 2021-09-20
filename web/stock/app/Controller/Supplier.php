<?php
require_once ('Base.php');

class Controller_Supplier extends Controller_Base {
	
	var $_supplier;
	
	function Controller_Supplier() {
		parent::Controller_Base();
		$this->_supplier =& FLEA::getSingleton('Model_Supplier'); 
	}
	
	// supplier list page
	function actionIndex() {
		$suppliers = $this->_supplier->findAll();
		
		$viewData = array('suppliers' => $suppliers);
		$this->_executeView(TPL_DIR.'supplier_index.tpl', $viewData);
	}
	
	//add new supplier
	function actionAdd() {
		$msg = "";
		if (isset($_POST['submit'])) {
			$data = array(
				'supplier' => trim($_POST['supplier']),
				'contact' => trim($_POST['contact']),
				'phone' => trim($_POST['phone']),
				'email' => trim($_POST['email']),
				'address' => trim($_POST['address']),
			);
			
			if ($this->_supplier->create($data)) {
				redirect(url('supplier', 'index'));
			} else {
				$msg = "create new supplier failed";
			}			
		}
		
		$viewData = array('msg' => $msg);
		$this->_executeView(TPL_DIR.'supplier_add.tpl', $viewData);
	}
	
	//modify supplier
	function actionEdit() {
		$msg = "";
		if (isset($_POST['submit'])) {
			$data = array(
				'id' => $_POST['id'],
				'supplier' => trim($_POST['supplier']),
				'contact' => trim($_POST['contact']),
				'phone' => trim($_POST['phone']),
				'email' => trim($_POST['email']),
				'address' => trim($_POST['address']),
			);
			
			if ($this->_supplier->update($data)) {
				redirect(url('supplier', 'index'));
			} else {
				$msg = "update supplier info failed";
			}	
		}
		
		$supplier = $this->_supplier->find((int)$_GET['id']);
		$viewData = array('supplier' => $supplier);
		$this->_executeView(TPL_DIR.'supplier_edit.tpl', $viewData);	
	}
	
	//delete supplier
	function actionDel() {
		$this->_supplier->removeByPkv((int)$_GET['id']);
		redirect(url('supplier', 'index'));
	}
	
}
?>