<?php
require_once (ROOT_PATH.'/libs/FLEA/FLEA/Db/TableDataGateway.php');

class Model_Supplier extends  FLEA_Db_TableDataGateway {
	var $tableName = 'stock_supplier';
	var $primaryKey = 'id';
	
	function getDropdownArray() {
		$order ="supplier";
		$suppliers = $this->findAll(null, $order);
		
		$data = array();
		foreach ($suppliers as $supplier) {
			$data[$supplier['id']] = $supplier['supplier'];
		}
		
		return $data;
	}
	
}
?>