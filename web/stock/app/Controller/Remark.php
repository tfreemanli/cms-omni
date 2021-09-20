<?php
require_once ('Base.php');

class Controller_Remark extends Controller_Base {
	
	var $_remark;
	var $_user;
	
	function Controller_Remark() {
		$this->_remark =& FLEA::getSingleton('Model_Remark');
		$this->_user =& FLEA::getSingleton('Model_User');
	}
	
	function actionIndex() {
	}
	
	function actionAdd() {
		if (isset($_POST['submit'])) {
			$data = array(
				'stockin_id' => $_POST['stockin_id'],
				'content' => ereg_replace("\r\n","<br>",$_POST['content']),
				'operator_id' => $_POST['operator_id'],
				'remark_date' => time(),
			);
			
			if ($this->_remark->create($data)) {
				redirect(url('stockin', 'view', array('id' => $data['stockin_id'])));
			} else {
				echo "add new remark failed";
				redirect(url('stockin', 'view', array('id' => $data['stockin_id'])), 3);
			}	
		}
	}
	
	function actionEdit() {
		$msg = "";
		
		if (isset($_POST['submit'])) {
			$data = array(
				'id' => $_POST['id'],
				'content' => ereg_replace("\r\n","<br>",$_POST['content']),
				'stockin_id' => $_POST['stockin_id'],
			);
			
			if ($this->_remark->update($data)) {
				redirect(url('stockin', 'view', array('id' => $data['stockin_id'])));
			} else {
				$msg = "add new remark failed";
			}	
		}
		
		$remark = $this->_remark->find((int)$_GET['id']);
		$users = $this->_user->getDropdownArray();
		
		$viewData = array(
			'remark' => $remark,
			'users' => $users,
			'msg' => $msg,
		);
		
		$this->_executeView(TPL_DIR.'remark_edit.tpl', $viewData);
	}
	
	function actionDel() {
		$this->_remark->removeByPkv((int)$_GET['id']);
		redirect(url('stockin', 'view', array(id => (int)$_GET['stockin_id'])));
	}
}

?>