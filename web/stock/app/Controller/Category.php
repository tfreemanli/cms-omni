<?php
require_once ('Base.php');
class Controller_Category extends Controller_Base {
	
	var $_category;
	
	function Controller_Category() {
		parent::Controller_Base();
		$this->_category =& FLEA::getSingleton('Model_Category'); 
	}
	
	function actionIndex() {	
		$categories = $this->_category->findAll();
		
		$viewData = array('categories' => $categories);
		$this->_executeView(TPL_DIR.'category_index.tpl', $viewData);
	}
	
	function actionAdd() {
		$msg ="";
		if (isset($_POST['submit'])) {
			$data = array(
				'name' => $_POST['name'],
				'description' => $_POST['description'],	
			);
			
			if ($this->_category->create($data)) {
				redirect(url('category', 'index'));
			} else {
				$msg = "create new category failed";
			}			
		}
		
		$categories = $this->_category->findAll();
		
		$viewData = array('msg' => $msg,  'categories' => $categories);
		$this->_executeView(TPL_DIR.'category_add.tpl', $viewData);
	}
	
	function actionEdit() {
		$msg = "";
		if (isset($_POST['submit'])) {
			$data = array(
				'id' => $_POST['id'],
				'name' => trim($_POST['name']),
				'description' => trim($_POST['description']),
			);
			
			if ($this->_category->update($data)) {
				redirect(url('category', 'index'));
			} else {
				$msg = "update new category failed";
			}			
		}
		
		$category = $this->_category->find($_GET['id']);
		
		$viewData = array('msg' => $msg, 'category' => $category);
		$this->_executeView(TPL_DIR.'category_edit.tpl', $viewData);
	}
	
	function actionDel() {
		$this->_category->removeByPkv((int)$_GET['id']);
		redirect(url('category', 'index'));
	}
}
?>