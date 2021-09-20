<?php require_once('../Connections/localhost.php'); ?>
<?php session_start();?>
<?php 

$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['AC_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['AC_Username'], $_SESSION['AC_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rs1 = 20;
$pageNum_rs1 = 0;
if (isset($_GET['pageNum_rs1'])) {
  $pageNum_rs1 = $_GET['pageNum_rs1'];
}
$startRow_rs1 = $pageNum_rs1 * $maxRows_rs1;

//deal with the search functing
$where_clu = "";
$cBrand="All";
if(isset($_GET['cBrand']) && $_GET['cBrand']!="All"){
		$where_clu = " Where cBrand like '%". $_GET['cBrand']."%'";
	$cBrand=$_GET['cBrand'];
}
//end of search funtion


mysql_select_db($database_localhost, $localhost);
$query_rs1 = "SELECT * FROM tbphone ".$where_clu." ORDER BY  iShowIndex desc, iID desc";
$query_limit_rs1 = sprintf("%s LIMIT %d, %d", $query_rs1, $startRow_rs1, $maxRows_rs1);
$rs1 = mysql_query($query_limit_rs1, $localhost) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);

if (isset($_GET['totalRows_rs1'])) {
  $totalRows_rs1 = $_GET['totalRows_rs1'];
} else {
  $all_rs1 = mysql_query($query_rs1);
  $totalRows_rs1 = mysql_num_rows($all_rs1);
}
$totalPages_rs1 = ceil($totalRows_rs1/$maxRows_rs1)-1;

$queryString_rs1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rs1") == false && 
        stristr($param, "totalRows_rs1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rs1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rs1 = sprintf("&totalRows_rs1=%d%s", $totalRows_rs1, $queryString_rs1);
?>

<html><!-- InstanceBegin template="/Templates/tpl_manage.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>manage pages</title>
<!-- InstanceEndEditable --> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="javascript" src="../js/common.js"></script>
<!-- InstanceBeginEditable name="head" -->

<script language="javascript">
<!--
function do_sch(){
	var brand = MM_findObj('cBrand');
	if(brand.selectedIndex < 0){
		alert('Pls select the brand');
		brand.focus();
		return false;
	}
	MM_goToURL('window','ph_list.php?cBrand='+ brand.options[brand.selectedIndex].value);
	return;
}
//-->
</script>

<link href="css.css" rel="stylesheet" type="text/css">
<!-- InstanceEndEditable -->
<link href="css.css" rel="stylesheet" type="text/css">
</head>

<body>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" background="images/m_top_bg.gif">
  <tr>
    <td><img src="../images/backg-top.gif" width="61" height="24"></td>
    <td width="114" rowspan="2" valign="top"><table width="114" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="114"><img src="images/m_top_right.gif" width="114" height="71"></td>
        </tr>
        <tr>
          <td width="114" height="18" background="images/m_topright_bg.gif"><table width="108" border="0" cellspacing="0" cellpadding="0">
              <tr align="center">
                <td width="38">help</td>
                <td width="70">contact us </td>
              </tr>
          </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><img src="images/m_logo.gif" width="261" height="65"></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="1%"><img src="images/m_top_bar_left.gif" width="28" height="22"></td>
    <td width="98%" background="images/m_top_bar_cen.gif">&nbsp;</td>
    <td width="1%"><img src="images/m_top_bar_right.gif" width="24" height="22"></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="195" valign="top" background="images/m_mid_leftbg.gif"><br>
      <?php include('inc_menu.php');?>
<p>&nbsp;</p>
<p>&nbsp;</p><p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p></td>
    <td width="797" valign="top" bgcolor="#FFFFFF"><!-- InstanceBeginEditable name="main" -->
<br>
<table width="100%"  border="0" align="center" cellpadding="5" cellspacing="10">
  <tr>
    <td width="82%" class="Mgr_Heading">Mobile Phone</td>
    <td width="18%" align="center" class="td_block"><a href="ph_add.php">Add New Mobile &gt;&gt; </a> </td>
  </tr>
</table>
<br>
      &nbsp;&nbsp;&nbsp;&nbsp;Brand: 
      <select name="cBrand" class="ipt_normal" id="cBrand">
      <option value="All">All</option>
      <option value="Nokia">Nokia</option>
      <option value="Samsung">Samsung</option>
      <option value="Motorola">Motorola</option>
      <option value="Sony Ericsson">Sony Ericsson</option>
      <option value="LG">LG</option>
      <option value="Alcatel">Alcatel</option>
      <option value="Panasonic">Panasonic</option>
      <option value="BenQ-Siemens">BenQ-Siemens</option>
      <option value="Siemens">Siemens</option>
      <option value="BenQ">BenQ</option>
      <option value="Philips">Philips</option>
      <option value="NEC">NEC</option>
      <option value="Sagem">Sagem</option>
      <option value="Sharp">Sharp</option>
      <option value="Toshiba">Toshiba</option>
      <option value="Pantech">Pantech</option>
      <option value="VK Mobile">VK Mobile</option>
      <option value="Palm">Palm</option>
      <option value="HTC">HTC</option>
      <option value="Qtek">Qtek</option>
      <option value="i-mate">i-mate</option>
      <option value="O2">O2</option>
      <option value="BlackBerry">BlackBerry</option>
      <option value="Haier">Haier</option>
      <option value="Bird">Bird</option>
      <option value="Eten">Eten</option>
      <option value="HP">HP</option>
      <option value="XCute">XCute</option>
      <option value="Asus">Asus</option>
      <option value="Gigabyte">Gigabyte</option>
      <option value="Apple">Apple</option>
      <option value="Vodafone">Vodafone</option>
      <option value="T-Mobile">T-Mobile</option>
      <option value="i-mobile">i-mobile</option>
      </select> 
      <input name="Go" type="button" value="Go" onClick="javascript:do_sch();">
	  <script language="javascript">
	  <!--//
	  var obj = MM_findObj('cBrand');
	  obj.value = "<?php echo $cBrand; ?>";
	  //-->
	  </script>
<br>
<br>
<table width="98%"  border="0" align="center" cellpadding="5" cellspacing="0">
  <tr class="font_white_9bold" align="center">
    <td width="2%" background="images/m_tb_head.gif" class="right_solid_1"><img src="images/cms_19.gif" width="11" height="12"></td>
    <td width="14%" background="images/m_tb_head.gif" class="right_solid_1">Product Code </td>
    <td width="10%" background="images/m_tb_head.gif" class="right_solid_1">Brand</td>
    <td width="13%" background="images/m_tb_head.gif" class="right_solid_1">Model</td>
    <td width="17%" background="images/m_tb_head.gif" class="right_solid_1">RingTones</td>
    <td width="14%" background="images/m_tb_head.gif" class="right_solid_1">Price</td>
    <td width="12%" background="images/m_tb_head.gif" class="right_solid_1">Warranty</td>
    <td width="18%" background="images/m_tb_head.gif" class="right_solid_1">In Stock</td>
  </tr>
  <?php
   $col = "#FFFFFF";
    do { ?>
  <tr bgcolor="<?php echo $col;?>" class="font_red_12">
    <td>&nbsp;</td>
    <td class="right_solid_2">·<?php echo $row_rs1['cPC']; ?></td>
    <td class="right_solid_2"><a href="ph_edit.php?iID=<?php echo $row_rs1['iID'];?>"><?php echo $row_rs1['cBrand']; ?></a>&nbsp;<?php echo ($row_rs1['iShowIndex']==0)?'':'√'?></td>
    <td class="right_solid_2"><?php echo $row_rs1['cModel']; ?>&nbsp;</td>
    <td class="right_solid_2"><?php echo $row_rs1['cRT']; ?>&nbsp;</td>
    <td class="right_solid_2"><?php echo $row_rs1['cPrice1']; ?>&nbsp;</td>
    <td class="right_solid_2"><?php echo $row_rs1['cWrty']; ?>&nbsp;</td>
    <td class="right_solid_2"><?php echo $row_rs1['cInStk']; ?>&nbsp;</td>
  </tr>
  <?php
  		if($col == "#FFFFFF"){
			$col = "#E3E3E3";
		}else{
			$col = "#FFFFFF";
		}
    } while ($row_rs1 = mysql_fetch_assoc($rs1)); ?>
  <tr>
  	<td background="images/cms_20.gif">&nbsp;</td>
    <td colspan="8" bgcolor="<?php echo $col?>">
      <table border="0" width="50%" align="center">
        <tr>
          <td width="23%" align="center">
            <?php if ($pageNum_rs1 > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_rs1=%d%s", $currentPage, 0, $queryString_rs1); ?>"><img src="images/First.gif" border=0></a>
            <?php } // Show if not first page ?>          </td>
          <td width="31%" align="center">
            <?php if ($pageNum_rs1 > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_rs1=%d%s", $currentPage, max(0, $pageNum_rs1 - 1), $queryString_rs1); ?>"><img src="images/Previous.gif" border=0></a>
            <?php } // Show if not first page ?>          </td>
          <td width="23%" align="center">
            <?php if ($pageNum_rs1 < $totalPages_rs1) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_rs1=%d%s", $currentPage, min($totalPages_rs1, $pageNum_rs1 + 1), $queryString_rs1); ?>"><img src="images/Next.gif" border=0></a>
            <?php } // Show if not last page ?>          </td>
          <td width="23%" align="center">
            <?php if ($pageNum_rs1 < $totalPages_rs1) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_rs1=%d%s", $currentPage, $totalPages_rs1, $queryString_rs1); ?>"><img src="images/Last.gif" border=0></a>
            <?php } // Show if not last page ?>          </td>
        </tr>
      </table></td>
  </tr>
</table>
<!-- InstanceEndEditable --></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="200" background="images/m_btm.gif">&nbsp;</td>
    <td align="right" background="images/m_btm_bg.gif"><p><img src="images/m_btm_right.gif" width="667" height="52"></p></td>
  </tr>
</table>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($rs1);
?>
