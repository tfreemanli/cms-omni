<?php
require_once (ROOT_PATH.'/libs/FLEA/FLEA/Db/TableDataGateway.php');

class Model_User extends FLEA_Db_TableDataGateway {
	var $tableName = 'tbopr';
	var $primaryKey = 'iID';
	
	function validator($login, $password) {
		$condition =  array(
			'cLogin' => $login,
			'cPsw' => $password,
			'cStatus' => 'normal',
			"role <> 'tech'",	
		);
		$user = $this->find($condition);
		
		if($user) {
			return $user;
		} else {
			return false;
		}
	}
	
	function getDropdownArray() {
		$condition = "role <> 'tech'";
		$order ="cName";
		$users = $this->findAll($condition, $order);
		
		$data = array();
		foreach ($users as $user) {
			$data[$user['iID']] = $user['cName'];
		}
		
		return $data;
	}
}
?>