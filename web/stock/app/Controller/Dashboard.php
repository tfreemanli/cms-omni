<?php
require_once ('Base.php');

class Controller_Dashboard extends Controller_Base {
	
	var $_product;
	var $_category;
	var $_brand;
	var $_stockin;
	var $_faulty;
	var $_supplier;
	
	function Controller_Dashboard() {
		parent::Controller_Base();
		$this->_product =& FLEA::getSingleton('Model_Product');
		$this->_category =& FLEA::getSingleton('Model_Category'); 
		$this->_brand =& FLEA::getSingleton('Model_Brand'); 
		$this->_stockin =& FLEA::getSingleton('Model_Stockin');
		$this->_faulty =& FLEA::getSingleton('Model_Faulty'); 
		$this->_supplier =& FLEA::getSingleton('Model_Supplier'); 
	}
	
	function actionIndex() {
		$supplier_count = $this->_supplier->findCount();
		$category_count = $this->_category->findCount();
		$brand_count = $this->_brand->findCount();
		$stockin_count = $this->_stockin->findCount();
		$faulty_count = $this->_faulty->findCount();
		$product_count = $this->_product->findCount();
		
		
		$viewData = array(
			'supplier' => $supplier_count,
			'category' => $category_count,
			'brand' => $brand_count,
			'stockin' => $stockin_count,
			'faulty' => $faulty_count,
			'product' => $product_count,	
		);
		
		$this->_executeView(TPL_DIR.'dashboard.tpl', $viewData);
	}
}
?>