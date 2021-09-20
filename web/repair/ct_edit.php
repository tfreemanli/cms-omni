<?php require_once('../Connections/localhost.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "tbopr";
$MM_donotCheckaccess = "false";

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
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "error.php?info=Sorry, you are not authorised for this operation.";
if (!((isset($_SESSION['RP_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['RP_Username'], $_SESSION['RP_UserGroup'])))) {   
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {

	if($_POST['cIsVIP']=='0'){
		  $updateSQL = sprintf("UPDATE tbcust SET cName=%s, cLastName=%s, cIsVIP='0', cVIPNum='', cVIPVDate='', cVIPEDate='', cEmail=%s, cHomePhn=%s, cWorkPhn=%s, cAdd1=%s, cAdd2=%s, cAdd3=%s, cFax=%s, cMake=%s, cModel=%s, cIMEI=%s WHERE iID=%s",
							   GetSQLValueString($_POST['cName'], "text"),
							   GetSQLValueString($_POST['cLastName'], "text"),
							   GetSQLValueString($_POST['cEmail'], "text"),
							   GetSQLValueString($_POST['cHomePhn'], "text"),
							   GetSQLValueString($_POST['cWorkPhn'], "text"),
							   GetSQLValueString($_POST['cAdd1'], "text"),
							   GetSQLValueString($_POST['cAdd2'], "text"),
							   GetSQLValueString($_POST['cAdd3'], "text"),
							   GetSQLValueString($_POST['cFax'], "text"),
						   GetSQLValueString($_POST['cMake'], "text"),
						   GetSQLValueString($_POST['cModel'], "text"),
						   GetSQLValueString($_POST['cIMEI'], "text"),
							   GetSQLValueString($_POST['iID'], "int"));
	}else{
		  $updateSQL = sprintf("UPDATE tbcust SET cName=%s, cLastName=%s, cIsVIP='1', cVIPNum=%s, cVIPVDate=%s, cVIPEDate=%s, cEmail=%s, cHomePhn=%s, cWorkPhn=%s, cAdd1=%s, cAdd2=%s, cAdd3=%s, cFax=%s, cMake=%s, cModel=%s, cIMEI=%s WHERE iID=%s",
							   GetSQLValueString($_POST['cName'], "text"),
							   GetSQLValueString($_POST['cLastName'], "text"),
							   GetSQLValueString($_POST['cVIPNum'], "text"),
							   GetSQLValueString($_POST['cVIPVDate'], "text"),
							   GetSQLValueString($_POST['cVIPEDate'], "text"),
							   GetSQLValueString($_POST['cEmail'], "text"),
							   GetSQLValueString($_POST['cHomePhn'], "text"),
							   GetSQLValueString($_POST['cWorkPhn'], "text"),
							   GetSQLValueString($_POST['cAdd1'], "text"),
							   GetSQLValueString($_POST['cAdd2'], "text"),
							   GetSQLValueString($_POST['cAdd3'], "text"),
							   GetSQLValueString($_POST['cFax'], "text"),
						   GetSQLValueString($_POST['cMake'], "text"),
						   GetSQLValueString($_POST['cModel'], "text"),
						   GetSQLValueString($_POST['cIMEI'], "text"),
							   GetSQLValueString($_POST['iID'], "int"));
	}

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());

  $updateGoTo = "ct_list.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form3")) {
  $updateSQL = sprintf("UPDATE tbcust SET cStatus='deleted' WHERE iID=%s",
                       GetSQLValueString($_POST['iID3'], "int"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());

  $updateGoTo = "ct_list.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rs = "1";
if (isset($_GET['iID'])) {
  $colname_rs = (get_magic_quotes_gpc()) ? $_GET['iID'] : addslashes($_GET['iID']);
}
mysql_select_db($database_localhost, $localhost);
$query_rs = sprintf("SELECT * FROM tbcust WHERE iID = %s", $colname_rs);
$rs = mysql_query($query_rs, $localhost) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);
$totalRows_rs = mysql_num_rows($rs);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html><!-- InstanceBegin template="/Templates/tpl_repair.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>manage pages</title>
<!-- InstanceEndEditable --><link href="../manage/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../js/common.js"></script>
<!-- InstanceBeginEditable name="head" -->
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
  } if (errors) alert('The following error(s) occurred:\n'+errors);
  document.MM_returnValue = (errors == '');
}
function usr_del(){
	if(cfm()){
		var fm = MM_findObj('form3');
		fm.submit();
		//alert('yes ticked.');
		return true;
	}
	return false;
}

function show(){
	var v1 = MM_findObj('DIVVIP1');
	var v2 = MM_findObj('DIVVIP2');
	var v3 = MM_findObj('DIVVIP3');
	v1.style.display = "block";
	v2.style.display = "block";
	v3.style.display = "block";
	return true;
}

function hide(){
	var v1 = MM_findObj('DIVVIP1');
	var v2 = MM_findObj('DIVVIP2');
	var v3 = MM_findObj('DIVVIP3');
	v1.style.display = "none";
	v2.style.display = "none";
	v3.style.display = "none";
	return true;
}
//-->
</script>
<!-- InstanceEndEditable -->
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" background="../manage/images/m_top_bg.gif">
  <tr>
    <td><img src="../images/backg-top.gif" width="61" height="24"></td>
    <td width="114" rowspan="2" valign="top"><table width="114" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="114"><img src="../manage/images/m_top_right.gif" width="114" height="71"></td>
        </tr>
        <tr>
          <td height="18" background="../manage/images/m_topright_bg.gif"><table width="108" border="0" cellspacing="0" cellpadding="0">
              <tr align="center">
                <td width="38"><a href="fb_list.php">help</a></td>
                <td width="70">contact us </td>
              </tr>
          </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><img src="../manage/images/m_logo.gif" width="261" height="65"></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="28" background="../manage/images/m_top_bar_cen.gif"><img src="../manage/images/m_top_bar_left.gif" width="28" height="22"></td>
    <td background="../manage/images/m_top_bar_cen.gif">&nbsp;</td>
    <td width="24" align="right" background="../manage/images/m_top_bar_cen.gif"><img src="../manage/images/m_top_bar_right.gif" width="24" height="22" align="right"></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="193" valign="top" background="../manage/images/m_mid_leftbg.gif"><?php include("inc_menu.php");?></td>
    <td  valign="top">	<!-- InstanceBeginEditable name="main" --><br> 
        <table width="100%"  border="0" align="center" cellpadding="5" cellspacing="10">
          <tr>
            <td width="82%" class="Mgr_Heading">Customer</td>
            <td width="18%" align="center" class="td_block"><a href="ct_list.php">&lt;&lt; Back to list</a> </td>
          </tr>
        </table>
      <br>
<?php
if($_SESSION['RP_Username']=="admin"){
?>
<table width="538"  border="0" cellpadding="5" cellspacing="2" bgcolor="#CADB2A">
  <form name="form3" enctype="multipart/form-data" method="POST" action="<?php echo $editFormAction; ?>">
    <tr>
      <td width="55%" height="31">■ Delete the Customer </td>
      <td width="45%" align="right"><input name="iID3" type="hidden" id="iID3" value="<?php echo $row_rs['iID']; ?>">
          <input type="button" name="Submit32" value="Delete" onClick="javascript:usr_del();"></td>
    </tr>
    <input type="hidden" name="MM_update" value="form3">
  </form>
</table>
<br>
<?php
}
?>
<table width="538" border="0" cellspacing="5" cellpadding="2"><form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <tr bgcolor="#CADB2A">
    <td colspan="2" class="font_white_9bold"><img src="images/1x1.gif" width="1" height="1" hspace="2" vspace="10" align="absmiddle">Modify Customer's information </td>
    </tr>
  <tr>
    <td width="123" align="right" class="td_block">First Name</td>
    <td width="404"><input name="cName" type="text" class="ipt_normal" id="cName" value="<?php echo $row_rs['cName']; ?>"></td>
  </tr>
  <tr>
    <td align="right" class="td_block">Last Name</td>
    <td><input name="cLastName" type="text" class="ipt_normal" id="cLastName" value="<?php echo $row_rs['cLastName']; ?>"><input type="hidden" name="cIsVIP" value="0">
      <input name="cVIPEDate" type="hidden" class="ipt_normal" id="cVIPEDate" value="<?php echo $row_rs['cVIPEDate']; ?>">
      <input name="cVIPVDate" type="hidden" class="ipt_normal" id="cVIPVDate" value="<?php echo $row_rs['cVIPVDate']; ?>">
      <input name="cVIPNum" type="hidden" class="ipt_normal" id="cVIPNum" value="<?php echo $row_rs['cVIPNum']; ?>"></td>
  </tr>
  <tr>
    <td align="right" class="td_block">Email</td>
    <td><input name="cEmail" type="text" class="ipt_normal" id="cEmail" value="<?php echo $row_rs['cEmail']; ?>"></td>
  </tr>
  <tr>
    <td align="right" class="td_block">Home Phone </td>
    <td><input name="cHomePhn" type="text" class="ipt_normal" id="cHomePhn" value="<?php echo $row_rs['cHomePhn']; ?>"></td>
  </tr>
  <tr>
    <td align="right" class="td_block">Work Phone</td>
    <td><input name="cWorkPhn" type="text" class="ipt_normal" id="cWorkPhn" value="<?php echo $row_rs['cWorkPhn']; ?>"></td>
  </tr>
  <tr>
    <td align="right" class="td_block">Address</td>
    <td><input name="cAdd1" type="text" class="ipt_normal" id="cAdd1" value="<?php echo $row_rs['cAdd1']; ?>"></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td><input name="cAdd2" type="text" id="cAdd2" value="<?php echo $row_rs['cAdd2']; ?>"></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td><input name="cAdd3" type="text" id="cAdd3" value="<?php echo $row_rs['cAdd3']; ?>"></td>
  </tr>
  <tr>
    <td align="right" class="td_block">Home Fax</td>
    <td><input name="cFax" type="text" id="cFax" value="<?php echo $row_rs['cFax']; ?>"></td>
  </tr>
  <tr>
    <td colspan="2" class="font_white_9bold">
      <p class="Mgr_Heading">Product Purchases</p>
    </td>
    </tr>
  <tr>
    <td align="right" class="td_block">Make:</td>
    <td><input name="cMake" type="text" class="ipt_normal" id="cMake" value="<?php echo $row_rs['cMake']; ?>"></td>
  </tr>
  <tr>
    <td align="right" class="td_block">Model:</td>
    <td><input name="cModel" type="text" class="ipt_normal" id="cModel" value="<?php echo $row_rs['cModel']; ?>"></td>
  </tr>
  <tr>
    <td align="right" class="td_block">IMEI No:</td>
    <td><input name="cIMEI" type="text" class="ipt_normal" id="cIMEI" value="<?php echo $row_rs['cIMEI']; ?>"></td>
  </tr>
<?php
if($_SESSION['RP_Username']=="admin"){
?>
  <tr>
    <td>&nbsp;</td>
    <td>
      <input name="Submit2" type="submit" class="btn" onClick="MM_validateForm('cName','','R');return document.MM_returnValue" value="submit">
      <input name="iID" type="hidden" id="iID" value="<?php echo $row_rs['iID']; ?>"></td>
  <input type="hidden" name="MM_update" value="form1">
  </tr>
<?php
}
?>
    </form>
</table>
<br>
<br>
  <!-- InstanceEndEditable -->
	</td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="191" background="../manage/images/m_btm.gif">&nbsp;</td>
  <td align="right" background="../manage/images/m_btm_bg.gif"><img src="../manage/images/m_btm_right.gif" width="667" height="52"></td>
  </tr>
</table>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($rs);
?>
