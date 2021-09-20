<?php
require_once ('Base.php');
FLEA::loadClass('FLEA_Helper_Pager');

class Controller_Stockout extends Controller_Base {
	
	var $_stockout;
	
	function Controller_Stockout() {
		parent::Controller_Base();
		$this->_stockout =& FLEA::getSingleton("Model_Stockout");
	}
	
	function actionIndex() {
		$page = isset($_GET['page']) ? (int)$_GET['page'] : 0;
       	$pagesize = 30;
		
		$order = "stockout_date desc";
		$condition = array();
		
		$pager = new FLEA_Helper_Pager($this->_stockout, $page, $pagesize, $condition, $order);
		
		$viewData = array(
			'stockout_list' => $pager->findAll(),
			'pageinfo' => $pager->getPagerData(),
		);
		$this->_executeView(TPL_DIR.'stockout_index.tpl', $viewData);
	}
}