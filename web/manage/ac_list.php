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

$maxRows_Recordset1 = 60;
$pageNum_Recordset1 = 0;


//deal with the search functing
$where_clu = "";
$cBrand="All";
$cType="All";
if(isset($_GET['cBrand']) && $_GET['cBrand']!="All"){
		$where_clu = " and cBrand like '%". $_GET['cBrand']."%'";
		$cBrand=$_GET['cBrand'];
}
if(isset($_GET['cType']) && $_GET['cType']!="All"){
		$where_clu .= " and cType like '%". $_GET['cType']."%'";
		$cType=$_GET['cType'];
}
//end of search funtion

if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_localhost, $localhost);
$query_Recordset1 = sprintf("SELECT * FROM tbanm WHERE iAorM = 2 %s ORDER BY cPC, dtDate DESC",$where_clu);
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $localhost) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset1") == false && 
        stristr($param, "totalRows_Recordset1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);
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
	var type = MM_findObj('cType');
	if(brand.selectedIndex < 0){
		alert('Pls select the brand');
		brand.focus();
		return false;
	}
	if(type.selectedIndex < 0){
		alert('Pls select the type');
		type.focus();
		return false;
	}
	MM_goToURL('window','ac_list.php?cBrand='+ brand.options[brand.selectedIndex].value + '&cType=' + type.options[type.selectedIndex].value);
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
    <td width="82%" class="Mgr_Heading">Accessories</td>
    <td width="18%" align="center" class="td_block"><a href="ac_add.php">ADD &gt;&gt;</a> </td>
  </tr>
</table>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="10">
  <tr>
    <td>Brand:
      <select name="cBrand" class="ipt_normal" id="cBrand">
        <option value="All">== Select ==</option>
        <option value="ALL BRANDS">ALL BRANDS</option>
        <option value="ALCATEL">ALCATEL</option>
        <option value="IPOD">IPOD</option>
        <option value="KYOCERA">KYOCERA</option>
        <option value="Motorola">Motorola</option>
        <option value="Nokia">Nokia</option>
        <option value="Panasonic">Panasonic</option>
        <option value="Samsung">Samsung</option>
        <option value="SAGEM">SAGEM</option>
        <option value="SANDISK">SANDISK</option>
        <option value="SANYO">SANYO</option>
        <option value="Sharp">Sharp</option>
        <option value="Siemens">Siemens</option>
        <option value="Sony">Sony</option>
        <option value="Sony Ericsson">Sony Ericsson</option>
        <option value="MISC">MISC</option>
      </select>
Type:
<select name="cType" class="ipt_normal" id="cType">
  <option value="All">== Select ==</option>
  <option value="Battery">Battery</option>
  <option value="Bluetooth Devices">Bluetooth Devices</option>
  <option value="Car Chargers">Car Chargers</option>
  <option value="Covers-Leather">Covers-Leather</option>
  <option value="Covers-Cases">Covers-Cases</option>
  <option value="Covers-Skins">Covers-Skins</option>
  <option value="Covers-Silicon">Covers-Silicon</option>
  <option value="Head Devices">Head Devices</option>
  <option value="Wall Chargers">Wall Chargers</option>
  <option value="MISC">MISC</option>
</select>
<input name="Go" type="button" value="Go" onClick="javascript:do_sch();">
<script language="javascript">
	  <!--//
	  var obj = MM_findObj('cBrand');
	  obj.value = "<?php echo $cBrand; ?>";
	  var obj2 = MM_findObj('cType');
	  obj2.value = "<?php echo $cType; ?>";
	  //-->
	  </script></td>
    </tr>
  <tr>
    <td><table width="100%"  border="0" cellpadding="5" cellspacing="0">
      <tr class="font_white_9bold" align="center">
        <td width="20%" height="12" background="../manage/images/m_tb_head.gif" class="right_solid_1">Product Code </td>
        <td width="15%" background="../manage/images/m_tb_head.gif" class="right_solid_1">Brand</td>
        <td width="14%" background="../manage/images/m_tb_head.gif" class="right_solid_1">Type</td>
        <td width="15%" background="../manage/images/m_tb_head.gif" class="right_solid_1">Model</td>
        <td width="14%" background="../manage/images/m_tb_head.gif" class="right_solid_1">Price1</td>
        <td width="14%" background="../manage/images/m_tb_head.gif" class="right_solid_1">Warranty</td>
        <td width="7%" background="../manage/images/m_tb_head.gif">Stock</td>
      </tr>
      <?php
   $col = "#FFFFFF";
   do { ?>
      <tr bgcolor="<?php echo $col?>" class="font_red_12">
        <td class="right_solid_2"><a href="ac_edit.php?iID=<?php echo $row_Recordset1['iID'];?>"><?php echo $row_Recordset1['cPC']; ?></a></td>
        <td class="right_solid_2"><?php echo $row_Recordset1['cBrand']; ?></td>
        <td class="right_solid_2"><?php echo $row_Recordset1['cType']; ?></td>
        <td class="right_solid_2"><?php echo $row_Recordset1['cModel']; ?></td>
        <td class="right_solid_2"><?php echo $row_Recordset1['cPrice1']; ?></td>
        <td class="right_solid_2"><?php echo $row_Recordset1['cWrty']; ?></td>
        <td><?php echo $row_Recordset1['cInStk']; ?></td>
      </tr>
      <?php
  		if($col == "#FFFFFF"){
			$col = "#E3E3E3";
		}else{
			$col = "#FFFFFF";
		}
   } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
      <tr>
        <td colspan="7" bgcolor="<?php echo $col?>">
          <table border="0" width="50%" align="center">
            <tr>
              <td width="23%" align="center">
                <?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>"><img src="images/First.gif" border=0></a>
                <?php } // Show if not first page ?>
              </td>
              <td width="31%" align="center">
                <?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>"><img src="images/Previous.gif" border=0></a>
                <?php } // Show if not first page ?>
              </td>
              <td width="23%" align="center">
                <?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>"><img src="images/Next.gif" border=0></a>
                <?php } // Show if not last page ?>
              </td>
              <td width="23%" align="center">
                <?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>"><img src="images/Last.gif" border=0></a>
                <?php } // Show if not last page ?>
              </td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<br><br>
<br>
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
mysql_free_result($Recordset1);

mysql_free_result($cat);
?>
