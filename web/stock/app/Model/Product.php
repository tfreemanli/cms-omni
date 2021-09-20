<?php
require_once (ROOT_PATH.'/libs/FLEA/FLEA/Db/TableDataGateway.php');

class Model_Product extends  FLEA_Db_TableDataGateway {
	var $tableName = 'stock_product';
	var $primaryKey = 'id';
	
	var $belongsTo = array(
		array(
			'tableClass' => 'Model_Brand',
			'foreignKey' => 'brand_id',
			'mappingName' => 'brand',
		),	
		
		array(
			'tableClass' => 'Model_Category',
			'foreignKey' => 'category_id',
			'mappingName' => 'category',
		),
	);
	
	function getDropdownArray() {
		$order ="name";
		$products = $this->findAll(null, $order);
		
		$data = array();
		foreach ($products as $product) {
			$data[$product['id']] = $product['name'].'('.$product['branch'].')';
		}
		
		return $data;
	}
	
	function getDropdownArrayWithBranch($branch) {
		$order ="name";
		$products = $this->findAll(null, $order);
		
		$data = array();
		foreach ($products as $product) {
			if($product['branch'] == $branch){
				$data[$product['id']] = $product['name'].'('.$product['branch'].')';
			}
		}
		
		return $data;
	}
	
}
?>