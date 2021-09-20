<?php
require_once ('Base.php');

class Controller_Search extends Controller_Base {
	
	var $_category;
	var $_brand;
	var $_product;
	var $_stockin;
	var $_stockout;
	var $_faulty;
	
	function Controller_Search() {
		parent::Controller_base();
		$this->_category =& FLEA::getSingleton('Model_Category'); 
		$this->_brand =& FLEA::getSingleton('Model_Brand'); 
		$this->_product =& FLEA::getSingleton('Model_Product');
		$this->_stockin =& FLEA::getSingleton('Model_Stockin');
		$this->_stockout =& FLEA::getSingleton('Model_Stockout');
		$this->_faulty =& FLEA::getSingleton('Model_Faulty');
	}
	
	function actionIndex() {		
		if (isset($_POST['product_submit'])) {
			$products = $this->_searchProduct();
		
		} else if(isset($_POST['stockin_submit'])) {
			$stock_list = $this->_searchStockin();
			
		} else if(isset($_POST['stockout_submit'])) {
			$stockout_list = $this->_searchStockout();
			
		} else if(isset($_POST['faulty_submit'])) {
			$faulties = $this->_searchFaulty();		
		}
			
		$categories = $this->_category->getDropdownArray();
		$brands = $this->_brand->getDropdownArray();
		
		$viewData = array(
			'categories' => $categories,
			'brands' => $brands,	
		);
		
		if (isset($products)) {
			$viewData['products'] = $products;
		}	
		if (isset($stock_list)) {
			$viewData['stock_list'] = $stock_list;
		}
		if (isset($stockout_list)) {
			$viewData['stockout_list'] = $stockout_list;
		}	
		if (isset($faulties)) {
			$viewData['faulties'] = $faulties;
		}
		
		$this->_executeView(TPL_DIR.'search_index.tpl', $viewData);
	}
	
	function _searchProduct() {
		$condition = array();
		if($_POST['category_id'] != "") {
			$condition['category_id'] = $_POST['category_id'];
		}
		if($_POST['brand_id'] != "") {
			$condition['brand_id'] = $_POST['brand_id'];
		}
		if ($_POST['model'] != "") {
			$condition[] = array("model", "%".$_POST['model']."%", "LIKE"); 
		}
		if ($_POST['product'] != "") {
			$condition[] = array("name", "%".$_POST['product']."%", "LIKE"); 
		}
		if($_POST['branch'] != "") {
			$condition['branch'] = $_POST['branch'];
		}
		
		$products = $this->_product->findAll($condition);
		
		return $products;
	}
	
	function _searchStockin() {
		$condition = array();
		if ($_POST['stockin_date_from'] != "") {
			$stockin_date_from = $this->_strTotimestamp($_POST['stockin_date_from']);
			$condition[] = array("stock_date", $stockin_date_from, ">");
		}
		
		if ($_POST['stockin_date_to'] != "") {
			$stockin_date_to = $this->_strTotimestamp($_POST['stockin_date_to']);
			$condition[] = array("stock_date", $stockin_date_to, "<");
		}
		
		$stocks = $this->_stockin->findAll($condition);
		
		return $stocks;
	}
	
	function _searchStockout() {
		$condition = array();
		
		if ($_POST['product'] != "") {
			$condition[] = array("product.name", "%".$_POST['product']."%", "LIKE"); 
		}
		
		if ($_POST['job_num'] != "") {
			$condition[] = array("job_num", "%".$_POST['job_num']."%", "LIKE"); 
		}
		
		if ($_POST['stockout_date_from'] != "") {
			$stockout_date_from = $this->_strTotimestamp($_POST['stockout_date_from']);
			$condition[] = array("stockout_date", $stockout_date_from, ">");
		}
		
		if ($_POST['stockout_date_to'] != "") {
			$stockout_date_to = $this->_strTotimestamp($_POST['stockout_date_to']);
			$condition[] = array("stockout_date", $stockout_date_to, "<");
		}
		
		$stockout = $this->_stockout->findAll($condition);
		
		return $stockout;
	}
	
	function _searchFaulty() {
		$condition = array();
		if ($_POST['product'] != "") {
			$condition[] = array("product.name", "%".$_POST['product']."%", "LIKE"); 
		}
		
		if ($_POST['job_num'] != "") {
			$condition[] = array("job_num", "%".$_POST['job_num']."%", "LIKE"); 
		}
		
		if ($_POST['faulty_date_from'] != "") {
			$faulty_date_from = $this->_strTotimestamp($_POST['faulty_date_from']);
			$condition[] = array("faulty_date", $faulty_date_from, ">");
		}	
		
		if ($_POST['faulty_date_to'] != "") {
			$faulty_date_to = $this->_strTotimestamp($_POST['faulty_date_to']);
			$condition[] = array("faulty_date", $faulty_date_to, "<");
		}
		
		$faulties = $this->_faulty->findAll($condition);
		
		return $faulties;		
	}
	
	function _strTotimestamp ($str) {
		$data = explode('-', $str);
		return mktime(0, 0, 0, $data[1], $data[0], $data[2]);
	}
}
?>