<?php
require_once ('Base.php');

class Controller_Brand extends Controller_Base {
	
	var $_brand;
	
	function Controller_Brand() {
		parent::Controller_Base();
		$this->_brand =& FLEA::getSingleton('Model_Brand'); 
	}
	
	//brand list
	function actionIndex() {
		$order = "name";
		$brands = $this->_brand->findAll(null, $order);
		
		$viewData = array('brands' => $brands);
		$this->_executeView(TPL_DIR.'brand_index.tpl', $viewData);
	}
	
	//add new brand
	function actionAdd() {
		$msg = "";
		if (isset($_POST['submit'])) {
			$data = array(
				'name' => trim($_POST['name']),
				'description' => trim($_POST['description']),
			);
			
			if ($this->_brand->create($data)) {
				redirect(url('brand', 'index'));
			} else {
				$msg = "create new brand failed";
			}			
		}
		$viewData = array('msg' => $msg);
		$this->_executeView(TPL_DIR.'brand_add.tpl', $viewData);
	}
	
	//edit brand
	function actionEdit() {
		$msg = "";
		if (isset($_POST['submit'])) {
			$data = array(
				'id' => $_POST['id'],
				'name' => trim($_POST['name']),
				'description' => trim($_POST['description']),
			);
			
			if ($this->_brand->update($data)) {
				redirect(url('brand', 'index'));
			} else {
				$msg = "update new brand failed";
			}			
		}
		
		$brand = $this->_brand->find((int)$_GET['id']);
		
		$viewData = array('msg' => $msg, 'brand' => $brand);
		$this->_executeView(TPL_DIR.'brand_edit.tpl', $viewData);
	}
	
	//delete brand
	function actionDel() {
		$this->_brand->removeByPkv((int)$_GET['id']);
		redirect(url('brand', 'index'));
	}
}
?>