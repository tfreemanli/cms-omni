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

if ((isset($_GET['act'])) && ($_GET['act'] == "del")) {
  $deleteSQL = sprintf("DELETE FROM tbcart WHERE cRef=%s",
                       GetSQLValueString($_GET['ref'], "text"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($deleteSQL, $localhost) or die(mysql_error());
  
  $deleteSQL = sprintf("DELETE FROM tbcartitems WHERE cRef=%s",
                       GetSQLValueString($_GET['ref'], "text"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($deleteSQL, $localhost) or die(mysql_error());

  header("Location: sc_list.php");
}

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
$query_Recordset1 = sprintf("SELECT * FROM tbcart WHERE cRef is not null %s ORDER BY cRef DESC",$where_clu);
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
<table width="530"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="9" rowspan="3"><img src="../manage/images/cms_09.gif" width="9" height="32"></td>
    <td width="474" background="../manage/images/cms_10.gif"><img src="../manage/images/cms_10.gif" width="466" height="3"></td>
    <td width="47" rowspan="3"><a href="ac_add.php"><img src="images/cms_12.gif" width="47" height="32" border="0"></a></td>
  </tr>
  <tr>
    <td height="25" bgcolor="#FFFFFF" class="Mgr_Heading">Shopping Cart Order</td>
  </tr>
  <tr>
    <td height="4" background="../manage/images/cms_17.gif"><img src="../manage/images/cms_17.gif" width="466" height="4"></td>
  </tr>
</table><br>
<br>
<table width="530"  border="0" cellpadding="0" cellspacing="0">
  <tr class="font_white_9bold" align="center">
    <td width="1%" valign="top" background="images/cms_20.gif"><img src="images/cms_19.gif" width="11" height="12"></td>
    <td width="7%" height="12" background="images/cms_22.gif" class="right_solid_1">Ref</td>
    <td width="10%" background="images/cms_22.gif" class="right_solid_1">Date</td>
    <td width="10%" background="images/cms_22.gif" class="right_solid_1">Name</td>
    <td width="15%" background="images/cms_22.gif" class="right_solid_1">Contact/Email</td>
    <td width="10%" background="images/cms_22.gif" class="right_solid_1">Price</td>
    <td width="10%" background="images/cms_22.gif" class="right_solid_1">Collect By</td>
    <td width="25%" background="images/cms_22.gif" class="right_solid_1">Address</td>
    <td width="7%" background="images/cms_22.gif">Opr</td>
  </tr>
  <?php
   $col = "#FFFFFF";
   do { ?>
  <tr bgcolor="<?php echo $col?>" class="font_red_12">
    <td width="1%" valign="top" background="images/cms_20.gif"><img name="" src="" width="1" height="1" alt=""></td>
    <td class="right_solid_1"><a href="sc_edit.php?ref=<?php echo $row_Recordset1['cRef'];?>"><?php echo $row_Recordset1['cRef']; ?></a></td>
    <td class="right_solid_1"><?php echo $row_Recordset1['dtDate']; ?></td>
    <td class="right_solid_1"><?php echo $row_Recordset1['cFName']; ?> <?php echo $row_Recordset1['cLName']; ?></td>
    <td class="right_solid_1"><?php echo $row_Recordset1['cContact']; ?><br><?php echo $row_Recordset1['cEmail']; ?></td>
    <td class="right_solid_1"><?php echo $row_Recordset1['fPrice']; ?></td>
    <td class="right_solid_1"><?php echo $row_Recordset1['iCB']; ?></td>
    <td class="right_solid_1"><?php echo $row_Recordset1['cAdd']; ?></td>
    <td><a href="#" onClick="javascript: if(cfm()) MM_goToURL('window','sc_list.php?act=del&ref=<?php echo $row_Recordset1['cRef'];?>');">Cancel</a></td>
  </tr>
  <?php
  		if($col == "#FFFFFF"){
			$col = "#E3E3E3";
		}else{
			$col = "#FFFFFF";
		}
   } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
  <tr>
    <td background="images/cms_20.gif">&nbsp;</td>
    <td colspan="8" bgcolor="<?php echo $col?>">
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
mysql_free_result($Recordset1);

mysql_free_result($cat);
?>
