<?php
require_once (ROOT_PATH.'/libs/FLEA/FLEA/Db/TableDataGateway.php');

class Model_Remark extends  FLEA_Db_TableDataGateway {
	var $tableName = 'stock_remark';
	var $primaryKey = 'id';
	
	var $belongsTo = array(
		array(
			'tableClass' => 'Model_User',
			'foreignKey' => 'operator_id',
			'mappingName' => 'operator',
		),	
	);
}
?>