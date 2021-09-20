<?php
class Controller_Index extends FLEA_Controller_Action {
	
	var $_user;
	
	function Controller_Index() {
		$this->_user =& FLEA::getSingleton('Model_User');
	}
	
	//login page
	function actionIndex() {
		$msg = '';
		if(isset($_POST['login']) && isset($_POST['password'])) {
			$user = $this->_user->validator($_POST['login'], $_POST['password']);
			
			if ($user) {
				$_SESSION['uid'] = $user['iID'];
				$_SESSION['name'] = $user['cName'];
				$_SESSION['role'] = $user['role'];
				
				redirect(url('dashboard', 'index'));
			} else {
				$msg = "invalid login name or password!";
			}
			
		}
		$viewData = array(
			'msg' => $msg,
		);
		
		$this->_executeView(TPL_DIR. 'login.tpl', $viewData);
	}
	
	//logout
	function actionLogout() {
		session_destroy();
		redirect(url('index', 'index'));
	}
	
	//for outter program login
	function actionBridge() {
    $uid = $_GET['uid'];
    $name = $_GET['name'];
    $role = $_GET['role'];
    $key = $_GET['key'];
    
    $login = (md5($uid.$name.$role) === $key) ? 1: 0;
    
    if($role == "tech" || !$login) {
      echo "Invalid login";
      
    } else {
      $_SESSION['uid'] = $uid;
      $_SESSION['name'] = $name;
      $_SESSION['role'] = $role;
      
      redirect(url('dashboard', 'index'));
    }
	}
}
?>