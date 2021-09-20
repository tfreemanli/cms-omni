<?php require_once('../Connections/localhost.php'); ?>
<?php
session_start();
mysql_select_db($database_localhost, $localhost);
$query_cat = "SELECT * FROM stock_category ORDER BY id ASC";
$cat = mysql_query($query_cat, $localhost) or die(mysql_error());
$row_cat = mysql_fetch_assoc($cat);
$totalRows_cat = mysql_num_rows($cat);

mysql_select_db($database_localhost, $localhost);
$query_brand = "SELECT * FROM stock_brand ORDER BY id ASC";
$brand = mysql_query($query_brand, $localhost) or die(mysql_error());
$row_brand = mysql_fetch_assoc($brand);
$totalRows_brand = mysql_num_rows($brand);

$where_clu = "where stock_product.id is not null ";
$cate = "all";
$cbrand = "all";
$name = "";
$model = "";
$branch = "all";
$colname_product = "-1";
if (isset($_POST['MM_search']) && $_POST['MM_search']!="") {
	if($_POST['category']!="all"){
		$cate = $_POST['category'];
		$where_clu .= " and category_id='". $cate ."'";
	}
	if($_POST['name']!=""){
		$name = $_POST['name'];
		$where_clu .= " and stock_product.name like '%". $name ."%'";
	}
	if($_POST['brand']!="all"){
		$cbrand = $_POST['brand'];
		$where_clu .= " and brand_id='". $cbrand ."'";
	}
	if($_POST['model']!=""){
		$model = $_POST['model'];
		$where_clu .= " and stock_product.model like '%". $model ."%'";
	}
	if($_POST['branch']!="all"){
		$branch = $_POST['branch'];
		$where_clu .= " and branch='". $branch ."'";
	}
}
$maxRows_product = 20;
$pageNum_product = 0;
if (isset($_GET['pageNum_product'])) {
  $pageNum_product = $_GET['pageNum_product'];
}
$startRow_product = $pageNum_product * $maxRows_product;

mysql_select_db($database_localhost, $localhost);
$query_product = "SELECT stock_product.*, stock_category.name as category, stock_brand.name as brand FROM stock_product inner join stock_category, stock_brand ON stock_product.category_id = stock_category.id AND stock_product.brand_id = stock_brand.id $where_clu ORDER BY stock_product.id ASC";
//echo $query_product;
$query_limit_product = sprintf("%s LIMIT %d, %d", $query_product, $startRow_product, $maxRows_product);
$product = mysql_query($query_limit_product, $localhost) or die(mysql_error());
$row_product = mysql_fetch_assoc($product);

if (isset($_GET['totalRows_product'])) {
  $totalRows_product = $_GET['totalRows_product'];
} else {
  $all_product = mysql_query($query_product);
  $totalRows_product = mysql_num_rows($all_product);
}
$totalPages_product = ceil($totalRows_product/$maxRows_product)-1;

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title></title>
<link href="../manage/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../js/common.js"></script>
</head>

<body>
  <table width="99%" border="0" cellspacing="1" cellpadding="2">
<form id="form1" name="form1" method="post" action="<?php echo $editFormAction;?>">
    <tr>
      <td>&nbsp;
  Category:
  <select name="category" id="category">
    <option value="all">ALL</option>
    <?php
do {  
?>
    <option value="<?php echo $row_cat['id']?>"><?php echo $row_cat['name']?></option>
    <?php
} while ($row_cat = mysql_fetch_assoc($cat));
  $rows = mysql_num_rows($cat);
  if($rows > 0) {
      mysql_data_seek($cat, 0);
	  $row_cat = mysql_fetch_assoc($cat);
  }
?>
  </select>
  Name:
  <input name="name" type="text" id="name" />
Brand  
<select name="brand" id="brand">
  <option value="all">All</option>
  <?php
do {  
?>
  <option value="<?php echo $row_brand['id']?>"><?php echo $row_brand['name']?></option>
  <?php
} while ($row_brand = mysql_fetch_assoc($brand));
  $rows = mysql_num_rows($brand);
  if($rows > 0) {
      mysql_data_seek($brand, 0);
	  $row_brand = mysql_fetch_assoc($brand);
  }
?>
  </select>
Model:  
<input name="model" type="text" id="model" />
Branch:
    <select name="branch" id="branch">
        <option value="all">All</option>
        <option value="henderson">Henderson</option>
        <option value="sylviapark">Sylvia Park</option>			
    </select>
<input name="MM_search" type="hidden" id="MM_search" value="search" /></td>
      <td>
  <input type="submit" name="Submit" value="Search" /></td>
    </tr>
</form>
</table>
<script language="javascript">
<!--
var category = MM_findObj('category');
var brand = MM_findObj('brand');
var name = MM_findObj('name');
var model = MM_findObj('model');
var branch = MM_findObj('branch');
category.value = '<?php echo $cate;?>';
brand.value = '<?php echo $cbrand;?>';
name.value = '<?php echo $name;?>';
model.value = '<?php echo $model;?>';
branch.value = '<?php echo $branch;?>';
//-->
</script>
  <table width="99%" border="0" align="center" cellpadding="2" cellspacing="1">
    <tr>
      <td width="23%" height="20" background="../manage/images/m_tb_head.gif" class="font_white_9bold">Product Name </td>
      <td width="11%" background="../manage/images/m_tb_head.gif" class="font_white_9bold">Branch</td>
      <td width="11%" background="../manage/images/m_tb_head.gif" class="font_white_9bold">Category</td>
      <td width="11%" background="../manage/images/m_tb_head.gif" class="font_white_9bold">Brand</td>
      <td width="21%" background="../manage/images/m_tb_head.gif" class="font_white_9bold">Model</td>
      <td width="12%" background="../manage/images/m_tb_head.gif" class="font_white_9bold">Stock Qty</td>
      <td width="22%" background="../manage/images/m_tb_head.gif" class="font_white_9bold">Operation</td>
    </tr>
      <?php do { ?>
    <tr>
        <td class="right_solid_2" style="color:<?php echo ($row_product['branch']=='henderson')?'#06F':'#F60'?>"><?php echo $row_product['name']; ?></td>
        <td class="right_solid_2"><?php echo $row_product['branch']; ?></td>
        <td class="right_solid_2"><?php echo $row_product['category']; ?></td>
        <td class="right_solid_2"><?php echo $row_product['brand']; ?></td>
        <td class="right_solid_2"><?php echo $row_product['model']; ?></td>
        <td class="right_solid_2"><?php echo $row_product['quantity']; ?></td>
        <form id="form2" name="form2" method="post" action="product_open.php"><td>
          <input name="qty" type="text" id="qty" value="1" size="5" />
          <input type="submit" name="Submit2" value="Open" />
          <input name="job_num" type="hidden" id="job_num" value="<?php echo $_GET['cJN'];?>" />
          <input name="id" type="hidden" id="id" value="<?php echo $row_product['id']; ?>" />
          <input name="MM_update" type="hidden" id="MM_update" value="1" />
          <input name="pname" type="hidden" id="pname" value="<?php echo $row_product['name']; ?>" /></td></form>
	</tr>
        <?php } while ($row_product = mysql_fetch_assoc($product)); ?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <?php //echo $query_product;?>
</body>
</html>
<?php
mysql_free_result($cat);

mysql_free_result($brand);

mysql_free_result($product);

mysql_free_result($all_product);
?>
