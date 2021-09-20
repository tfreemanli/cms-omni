<?php
require_once (ROOT_PATH.'/libs/FLEA/FLEA/Db/TableDataGateway.php');

class Model_Brand extends  FLEA_Db_TableDataGateway {
	var $tableName = 'stock_brand';
	var $primaryKey = 'id';
	
	function getDropdownArray() {
		$order ="name";
		$brands = $this->findAll(null, $order);
		
		$data = array();
		foreach ($brands as $brand) {
			$data[$brand['id']] = $brand['name'];
		}
		
		return $data;
	}
	
}
?>