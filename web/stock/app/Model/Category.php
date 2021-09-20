<?php
require_once (ROOT_PATH.'/libs/FLEA/FLEA/Db/TableDataGateway.php');

class Model_Category extends  FLEA_Db_TableDataGateway {
	var $tableName = 'stock_category';
	var $primaryKey = 'id';
	
	function getDropdownArray() {
		$order ="name";
		$categorys = $this->findAll(null, $order);
		
		$data = array();
		foreach ($categorys as $category) {
			$data[$category['id']] = $category['name'];
		}
		
		return $data;
	}
}
?>