<?php
require_once (ROOT_PATH.'/libs/FLEA/FLEA/Db/TableDataGateway.php');

class Model_Stockin extends FLEA_Db_TableDataGateway {
	var $tableName = 'stock_stockin';
	var $primaryKey = 'id';
	
	var $belongsTo = array(
		array(
			'tableClass' => 'Model_Supplier',
			'foreignKey' => 'supplier_id',
			'mappingName' => 'supplier',
		),
		
		array(
			'tableClass' => 'Model_User',
			'foreignKey' => 'operator_id',
			'mappingName' => 'operator',
		),	
	);
	
	function delDataById($id) {
		$rs = $this->removeByPkv($id);
		
		if($rs) {
			$condition = array("stockin_id" => $id);
			
			$_remark =& FLEA::getSingleton('Model_Remark');
			$_remark->removeByConditions($condition);
			
			$_stockinProduct =& FLEA::getSingleton('Model_StockinProduct');
			$products = $_stockinProduct->findAll($condition);
			
			foreach ($products as $product) {
				$_stockinProduct->delDataById($product['id']);
			}
		}
		
		return $rs;
	}
}

?>