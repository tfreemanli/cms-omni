<?php
require_once (ROOT_PATH.'/libs/FLEA/FLEA/Db/TableDataGateway.php');

class Model_Stockout extends FLEA_Db_TableDataGateway {
	var $tableName = 'stock_stockout';
	var $primaryKey = 'id';
	
	var $belongsTo = array(
		array(
			'tableClass' => 'Model_Product',
			'foreignKey' => 'product_id',
			'mappingName' => 'product',
		),
		
		array(
			'tableClass' => 'Model_User',
			'foreignKey' => 'operator_id',
			'mappingName' => 'operator',
		),	
	);
	
}