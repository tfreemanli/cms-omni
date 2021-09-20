<?php
require_once (ROOT_PATH.'/libs/FLEA/FLEA/Db/TableDataGateway.php');

class Model_Faulty extends  FLEA_Db_TableDataGateway {
	
	var $tableName = 'stock_faulty';
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
		
		array(
			'tableClass' => 'Model_Supplier',
			'foreignKey' => 'supplier_id',
			'mappingName' => 'supplier',
		),
	);
	
	function addNewFromStock($data) {
		$_product =& FLEA::getSingleton('Model_Product');
		
		$product = $_product->find($data['product_id']);
		
		if($product['quantity'] < $data['quantity'] ) {
			return false;
		}
		
		$rs = $this->create($data);
		
		if($rs) {
			$condition = array('id' => $data['product_id']);
			$_product->decrField($condition, 'quantity', $data['quantity']);
		}
		
		return $rs;
	}
	
	function updateFromStock($data) {
		$_product =& FLEA::getSingleton('Model_Product');
		
		$product = $_product->find($data['product_id']);
		
		$oldData = $this->find($data['id']);
		
		$deviation = $data['quantity'] - $oldData['quantity'];
		
		if ($data['product_id'] == $oldData['$product_id']) {
			if($product['quantity'] < $deviation) {
				return false;
			}	
		} else {
			if($product['quantity'] < $data['quantity']) {
				return false;
			}	
		}
		
		$rs = $this->update($data);
		
		if ($rs) {
			if ($data['product_id'] == $oldData['$product_id']) {
				$condition = array('id' => $data['product_id']);
				if ($deviation > 0) {
					$_product->decrField($condition, 'quantity', $deviation);
				} else {
					$_product->incrField($condition, 'quantity', abs($deviation));
				}		
			} else {
				$_product->incrField(array('id' => $oldData['product_id']), 'quantity', $oldData['quantity']);
				$_product->decrField(array('id' => $data['product_id']), 'quantity', $data['quantity']);
			}		
		}	
		return $rs;
	}
	
	function delById($id) {
		$data = $this->find($id);
		
		$rs = $this->removeByPkv($id);
		
		if ($rs) {
			$_product =& FLEA::getSingleton('Model_Product');
			
			$condition = array('id' => $data['product_id']);
			$_product->incrField($condition, 'quantity', $data['quantity']);
		}
		
		return $rs;
	}
}

?>