<?php
require_once ('Base.php');
FLEA::loadClass('FLEA_Helper_Pager');

class Controller_Product extends Controller_Base {
	
	var $_product;
	var $_category;
	var $_brand;
	
	function Controller_Product() {
		parent::Controller_Base();
		$this->_product =& FLEA::getSingleton('Model_Product');
		$this->_category =& FLEA::getSingleton('Model_Category'); 
		$this->_brand =& FLEA::getSingleton('Model_Brand'); 
	}
	
	function actionIndex() {
		$cid = isset($_GET['cid']) ? (int)$_GET['cid'] : 0;
		
		$page = isset($_GET['page']) ? (int)$_GET['page'] : 0;
       	$pagesize = 30;
		$condition = array();
		
		if ($cid != 0) {
			$condition = array("category_id" => $cid);
		}
		
		$pager = new FLEA_Helper_Pager($this->_product, $page, $pagesize, $condition);
		
		$categoryAry = $this->_category->getDropdownArray();
		
		$viewData = array(
			'products' => $pager->findAll(),
			'pageinfo' => $pager->getPagerData(),
			'categoryAry' => $categoryAry,
			'cid' => $cid,
		);
		$this->_executeView(TPL_DIR.'product_index.tpl', $viewData);
	}
	
	function actionAdd() {
		$msg = "";
		
		if(isset($_POST['submit'])) {
			if($_POST['branch'] != 'all'){
				$data = array(
					'category_id' => $_POST['category_id'],
					'name' => $_POST['name'],
					'brand_id' => $_POST['brand_id'],
					'model' => $_POST['model'],
					'description' => $_POST['description'],
					'quantity' => $_POST['quantity'],
					'rrp' => $_POST['rrp'],
					'branch' => $_POST['branch'],
				);
				
				if ($this->_product->create($data)) {
					redirect(url('product', 'index', array('cid' => $_POST['category_id'])));
				} else {
					$msg = "create new product failed";
				}
			}else{ //if add products to all branch
				$data1 = array(
					'category_id' => $_POST['category_id'],
					'name' => $_POST['name'],
					'brand_id' => $_POST['brand_id'],
					'model' => $_POST['model'],
					'description' => $_POST['description'],
					'quantity' => $_POST['quantity'],
					'rrp' => $_POST['rrp'],
					'branch' => 'henderson',
				);
				
				$data2 = array(
					'category_id' => $_POST['category_id'],
					'name' => $_POST['name'],
					'brand_id' => $_POST['brand_id'],
					'model' => $_POST['model'],
					'description' => $_POST['description'],
					'quantity' => '0',
					'rrp' => $_POST['rrp'],
					'branch' => 'sylviapark',
				);
				
				if ($this->_product->create($data1) && $this->_product->create($data2)) {
					redirect(url('product', 'index', array('cid' => $_POST['category_id'])));
				} else {
					$msg = "create new product failed";
				}
			}
			
		}
		
		$brandAry = $this->_brand->getDropdownArray();
		$categoryAry = $this->_category->getDropdownArray();
		
		$viewData = array(
			'msg' => $msg,
			'brandAry' => $brandAry,
			'categoryAry' => $categoryAry,
		);
		$this->_executeView(TPL_DIR.'product_add.tpl', $viewData);
	}
	
	function actionEdit() {
		$msg = "";
		
		if(isset($_POST['submit'])) {
			$data = array(
				'id' => $_POST['id'],
				'category_id' => $_POST['category_id'],
				'name' => $_POST['name'],
				'brand_id' => $_POST['brand_id'],
				'model' => $_POST['model'],
				'description' => $_POST['description'],
				'quantity' => $_POST['quantity'],
				'rrp' => $_POST['rrp'],
				'branch' => $_POST['branch'],
			);
			 
			
			if ($this->_product->update($data)) {
				//add by freeman
				for($n=0;$n < count($_POST['otherid']);$n++) 
				{ 
						//$otherid[$n]就是选中的值。 
						$otherdata = array(
							'id' => $_POST['otherid'][$n],
							'category_id' => $_POST['category_id'],
							'name' => $_POST['name'],
							'brand_id' => $_POST['brand_id'],
							'model' => $_POST['model'],
							'description' => $_POST['description'],
							'rrp' => $_POST['rrp'],
						);
						$this->_product->update($otherdata);
				}
				//end 14-4-2011
				
				redirect(url('product', 'index', array('cid' => $_POST['category_id'])));
			} else {
				$msg = "update new product failed";
			}
			
		}
		
		$brandAry = $this->_brand->getDropdownArray();
		$categoryAry = $this->_category->getDropdownArray();
		
		$product = $this->_product->find((int)$_GET['id']);
		
		//add by freeman
		$condition = array();
		$condition['category_id'] = $product['category_id'];
		$condition['brand_id'] = $product['brand_id'];
		$condition[] = array("model", "%".$product['model']."%", "LIKE");
		$condition[] = array("name", "%".$product['name']."%", "LIKE");
		$otherSimProducts = $this->_product->findAll($condition);
		//end 14-4-2011
		
		$viewData = array(
			'msg' => $msg,
			'brandAry' => $brandAry,
			'categoryAry' => $categoryAry,
			'product' => $product,
			'otherSimProducts' => $otherSimProducts,
		);
		$this->_executeView(TPL_DIR.'product_edit.tpl', $viewData);
	}
	
	function actionDel() {
		$this->_product->removeByPkv((int)$_GET['id']);		
		redirect(url('product', 'index')); 
	}
}
?>