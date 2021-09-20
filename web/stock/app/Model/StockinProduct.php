<?php
require_once (ROOT_PATH.'/libs/FLEA/FLEA/Db/TableDataGateway.php');

class Model_StockinProduct extends FLEA_Db_TableDataGateway {
	
	var $tableName = 'stock_stockin_product';
	var $primaryKey = 'id';
	
	var $belongsTo = array(
		array(
			'tableClass' => 'Model_Product',
			'foreignKey' => 'product_id',
			'mappingName' => 'product',	
		),
	);

	function createNew($data) {
		$id = $this->create($data);
		
		if($id) {
			$_product =& FLEA::getSingleton('Model_Product');
			
			$condition = array('id' => $data['product_id']);
			$_product->incrField($condition, 'quantity', $data['quantity']);
			
			//modify by freeman 12-8-2010
			//update the product price according to stock-in price
			$data2 = array(
				'id' => $data['product_id'],
				'stockinprice' => $data['price'],
			);
			$_product->update($data2);
		}
		
		return $id;
	}
	
	function editData($data) {
		$oldData = $this->find($data['id']);
		
		$rs = $this->update($data);
		
		if ($rs) {
			$_product =& FLEA::getSingleton('Model_Product');
			
			$condition = array('id' => $data['product_id']);
			
			$deviation = $data['quantity'] - $oldData['quantity'];
			if ($deviation > 0) {
				$_product->incrField($condition, 'quantity', $deviation);
			} else {
				$_product->decrField($condition, 'quantity', abs($deviation));
			}
			
			//modify by freeman 12-8-2010
			//update the product price according to stock-in price
			$data2 = array(
				'id' => $data['product_id'],
				'stockinprice' => $data['price'],
			);
			$_product->update($data2);
		}
		
		return $rs;
	}
	
	function delDataById($id) {
		$data = $this->find($id);	
		$rs = $this->removeBypkv($id);
		if ($rs) {
			$_product =& FLEA::getSingleton('Model_Product');
			$condition = array('id' => $data['product_id']);
			$_product->decrField($condition, 'quantity', $data['quantity']);
		}
		
		return $rs;
	}
}