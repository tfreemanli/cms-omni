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
$colname_Recordset1 = "1";
if (isset($_GET['ref'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_GET['ref'] : addslashes($_GET['ref']);
}
mysql_select_db($database_localhost, $localhost);
$query_Recordset1 = sprintf("SELECT * FROM tbdecart WHERE cRef = '%s'", $colname_Recordset1);
$Recordset1 = mysql_query($query_Recordset1, $localhost) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_RS2 = "1";
if (isset($_GET['ref'])) {
  $colname_RS2 = (get_magic_quotes_gpc()) ? $_GET['ref'] : addslashes($_GET['ref']);
}
mysql_select_db($database_localhost, $localhost);
$query_RS2 = sprintf("SELECT * FROM tbdecartitems WHERE cRef = '%s'", $colname_RS2);
$RS2 = mysql_query($query_RS2, $localhost) or die(mysql_error());
$row_RS2 = mysql_fetch_assoc($RS2);
$totalRows_RS2 = mysql_num_rows($RS2);
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
    <td height="25" bgcolor="#FFFFFF" class="Mgr_Heading">Dealer's Order Detail</td>
  </tr>
  <tr>
    <td height="4" background="../manage/images/cms_17.gif"><img src="../manage/images/cms_17.gif" width="466" height="4"></td>
  </tr>
</table>
<br>
<table width="530"  border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="45">Ref:</td>
    <td width="209"><?php echo $row_Recordset1['cRef']; ?></td>
    <td width="60">Date:</td>
    <td width="195"><?php echo $row_Recordset1['dtDate']; ?></td>
  </tr>
  <tr>
    <td>Dealer:</td>
    <td colspan="3"><?php echo $row_Recordset1['cDName']; ?></td>
    </tr>
  <tr>
    <td>Price:</td>
    <td><?php echo $row_Recordset1['fPrice']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br>
<table width="530"  border="0" cellpadding="0" cellspacing="0">
  <tr class="font_white_9bold" align="center">
    <td width="2%" valign="top" background="./images/cms_20.gif"><img src="./images/cms_19.gif" width="11" height="12"></td>
    <td width="21%" background="./images/cms_22.gif" class="right_solid_1"> Image</td>
    <td width="26%" background="./images/cms_22.gif" class="right_solid_1">Product</td>
    <td width="16%" background="./images/cms_22.gif" class="right_solid_1">Price</td>
    <td width="15%" background="./images/cms_22.gif" class="right_solid_1">Qty</td>
    <td width="20%" background="./images/cms_22.gif" class="right_solid_1">Amount</td>
  </tr>
  <?php
   $col = "#FFFFFF";
   $subtotal = 0.0;
	//for each item: 0 type(ph/ac/mp), 1 id, 2 product name, 3 cImg, 4 price, 5 qty
    do { ?>
  <tr bgcolor="<?php echo $col;?>" class="font_red_12">
    <td background="./images/cms_20.gif">&nbsp;</td>
    <td class="right_solid_1"><img src="../productimg/<?php echo $row_RS2['cImg'];?>" width="100" height="100" border="0"></td>
    <td class="right_solid_1"><a href="<?php echo $row_RS2['cType'];?>_edit.php?iID=<?php echo $row_RS2['iPID'];?>"><?php echo $row_RS2['cModel'];?></a></td>
    <td class="right_solid_1"><?php echo 1*$row_RS2['cPrice'];?></td>
    <td class="right_solid_1"><?php echo $row_RS2['iQty'];?></td>
    <td class="right_solid_1"><?php echo $row_RS2['cPrice'] * $row_RS2['iQty'];?></td>
  </tr>
  <?php
		$subtotal+= ($row_RS2['cPrice'] * $row_RS2['iQty']);
			
  		if($col == "#FFFFFF"){
			$col = "#E3E3E3";
		}else{
			$col = "#FFFFFF";
		}
    } while ($row_RS2 = mysql_fetch_assoc($RS2)); ?>
	<!--
  <tr bgcolor="<?php echo $col;?>" class="font_red_12">
    <td class="font_red_12">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right" bgcolor="<?php echo $col;?>">Subtotal:</td>
    <td><?php echo $subtotal;?></td>
  </tr>
  //-->
  <tr bgcolor="<?php echo $col;?>" class="font_red_12">
    <td height="23" class="font_red_12">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right" bgcolor="<?php echo $col;?>">Total:</td>
    <td><?php echo $row_Recordset1['fPrice']; ?></td>
  </tr>
  <tr bgcolor="<?php echo $col;?>" class="font_red_12">
    <td class="font_red_12">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right" bgcolor="<?php echo $col;?>">&nbsp;</td>
    <td>&nbsp;</td>
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

mysql_free_result($RS2);

mysql_free_result($cat);
?>
