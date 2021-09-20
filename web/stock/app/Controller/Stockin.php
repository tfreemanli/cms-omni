<?php
require_once ('Base.php');
FLEA::loadClass('FLEA_Helper_Pager');

class Controller_Stockin extends Controller_Base {
	
	var $_stockin;
	var $_user;
	var $_supplier;
	var $_stockinProduct;
	var $_remark;
	
	function Controller_Stockin() {
		parent::Controller_Base();
		$this->_stockin =& FLEA::getSingleton('Model_Stockin');
		$this->_user =& FLEA::getSingleton('Model_User');
		$this->_supplier =& FLEA::getSingleton('Model_Supplier');
		$this->_stockinProduct =& FLEA::getSingleton('Model_StockinProduct');
		$this->_remark =& FLEA::getSingleton('Model_Remark');
	}
	
	//stock in record list
	function actionIndex() {
		$page = isset($_GET['page']) ? (int)$_GET['page'] : 0;
       	$pagesize = 30;
		
		$order = "stock_date desc";
		$condition = array();
		
		$pager = new FLEA_Helper_Pager($this->_stockin, $page, $pagesize, $condition, $order);
		
		$viewData = array(
			'stock_list' => $pager->findAll(),
			'pageinfo' => $pager->getPagerData(),
		);
		$this->_executeView(TPL_DIR.'stockin_index.tpl', $viewData);
	}
	
	//view stock in detail
	function actionView() {
		$stock = $this->_stockin->find((int)$_GET['id']);
		
		//get related products list
		$condition = array('stockin_id' => (int)$_GET['id']);
		$stockinProducts = $this->_stockinProduct->findAll($condition);
		
		//get related remark list
		$order ="remark_date";
		$remarks = $this->_remark->findAll($condition, $order);
		
		$users = $this->_user->getDropdownArray();
		
		$viewData = array(
			'stock' => $stock,
			'stockinProducts' => $stockinProducts,
			'users' => $users,
			'remarks' => $remarks,
		);
		$this->_executeView(TPL_DIR.'stockin_view.tpl', $viewData);
	}
	
	function actionAdd() {
		$msg = "";
		
		if (isset($_POST['submit'])) {
			$dateString = $_POST['stock_date'];
			$stock_timestamp = $this->_strToTimeStamp($dateString);			
			
			$data = array(
				'supplier_id' => $_POST['supplier_id'],
				'operator_id' => $_POST['user_id'],
				'stock_date' => $stock_timestamp,	
				'branch' => $_POST['branch'],
			);
			
			if ($this->_stockin->create($data)) {
				redirect(url('stockin', 'index'));
			} else {
				$msg ="create new stock in list failed";
			}	
		}
		
		$userAry = $this->_user->getDropdownArray();
		$supplierAry = $this->_supplier->getDropdownArray();
		
		$viewData = array(
			'msg' => $msg,
			'userAry' => $userAry,
			'supplierAry' => $supplierAry,	
		);
		$this->_executeView(TPL_DIR.'stockin_add.tpl', $viewData);
	}
	
	function actionEdit() {
		$msg = "";
		
		if (isset($_POST['submit'])) {
			$dateString = $_POST['stock_date'];
			$stock_timestamp = $this->_strToTimeStamp($dateString);			
			
			$data = array(
				'id' => $_POST['id'],
				'supplier_id' => $_POST['supplier_id'],
				'operator_id' => $_POST['user_id'],
				'stock_date' => $stock_timestamp,	
				'branch' => $_POST['branch'],
			);
			
			if ($this->_stockin->update($data)) {
				redirect(url('stockin', 'index'));
			} else {
				$msg ="update new stock in list failed";
			}	
		}
		
		$userAry = $this->_user->getDropdownArray();
		$supplierAry = $this->_supplier->getDropdownArray();
		$stock = $this->_stockin->find((int)$_GET['id']);
		
		$viewData = array(
			'msg' => $msg,
			'userAry' => $userAry,
			'supplierAry' => $supplierAry,
			'stock' => $stock,	
		);
		$this->_executeView(TPL_DIR.'stockin_edit.tpl', $viewData);
	}
	
	function actionDel() {
		$this->_stockin->delDataById((int)$_GET['id']);
		redirect(url("stockin", "index"));
	}
	
	//transfer date string to timestamp
	function _strToTimeStamp($dateString) {
		$datetimeAry = explode(" ", $dateString);
		
		$date = $datetimeAry[0];
		$time = $datetimeAry[1];
		
		$dateAry = explode("-", $date);
		$timeAry = explode(":", $time);
		
		$stock_timestamp = mktime($timeAry[0], $timeAry[1], 0, $dateAry[1], $dateAry[0], $dateAry[2]);
		
		return $stock_timestamp;
	}
	
}
?>