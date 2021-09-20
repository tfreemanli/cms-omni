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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  if($_POST['cIsVIP']=='0'){
	  $insertSQL = sprintf("INSERT INTO tbcust (cName, cLastName, cHomePhn, cWorkPhn, cAdd1, cAdd2, cAdd3, cFax, cEmail, cMake, cModel, cIMEI) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($_POST['cName'], "text"),
						   GetSQLValueString($_POST['cLastName'], "text"),
						   GetSQLValueString($_POST['cHomePhn'], "text"),
						   GetSQLValueString($_POST['cWorkPhn'], "text"),
						   GetSQLValueString($_POST['cAdd1'], "text"),
						   GetSQLValueString($_POST['cAdd2'], "text"),
						   GetSQLValueString($_POST['cAdd3'], "text"),
						   GetSQLValueString($_POST['cFax'], "text"),
						   GetSQLValueString($_POST['cEmail'], "text"),
						   GetSQLValueString($_POST['cMake'], "text"),
						   GetSQLValueString($_POST['cModel'], "text"),
						   GetSQLValueString($_POST['cIMEI'], "text"));
  }else{
	  $insertSQL = sprintf("INSERT INTO tbcust (cName, cLastName, cHomePhn, cWorkPhn, cAdd1, cAdd2, cAdd3, cFax, cEmail, cIsVIP, cVIPNum, cVIPVDate, cVIPEDate, cSbmBy, cMake, cModel, cIMEI) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, '1', %s, %s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($_POST['cName'], "text"),
						   GetSQLValueString($_POST['cLastName'], "text"),
						   GetSQLValueString($_POST['cHomePhn'], "text"),
						   GetSQLValueString($_POST['cWorkPhn'], "text"),
						   GetSQLValueString($_POST['cAdd1'], "text"),
						   GetSQLValueString($_POST['cAdd2'], "text"),
						   GetSQLValueString($_POST['cAdd3'], "text"),
						   GetSQLValueString($_POST['cFax'], "text"),
						   GetSQLValueString($_POST['cEmail'], "text"),
						   GetSQLValueString($_POST['cVIPNum'], "text"),
						   GetSQLValueString($_POST['cVIPVDate'], "text"),
						   GetSQLValueString($_POST['cVIPEDate'], "text"),
						   GetSQLValueString($_SESSION['RP_Username'], "text"),
						   GetSQLValueString($_POST['cMake'], "text"),
						   GetSQLValueString($_POST['cModel'], "text"),
						   GetSQLValueString($_POST['cIMEI'], "text"));
  }

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($insertSQL, $localhost) or die(mysql_error());

  $insertGoTo = "ct_list.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><!-- InstanceBegin template="/Templates/tpl_repair.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>Repair Center</title>
<!-- InstanceEndEditable --><link href="../manage/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../js/common.js"></script>
<!-- InstanceBeginEditable name="head" -->
<script language="javascript">
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

function add_usr(){
		MM_validateForm('cName','','R');
	if(document.MM_returnValue){
		var frm = MM_findObj('form1');
		frm.submit();
	}
	return true;
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
    <td  valign="top">	<!-- InstanceBeginEditable name="main" -->
<table width="100%"  border="0" align="center" cellpadding="5" cellspacing="10">
  <tr>
    <td width="82%" class="Mgr_Heading">Customer</td>
    <td width="18%" align="center" class="td_block"><a href="ct_list.php">&lt;&lt; Back to list</a>  </td>
  </tr>
</table>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="10">
  <tr>
    <td><table width="100%"  border="0" align="center" cellpadding="3" cellspacing="5">
      <form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
        <tr>
          <td width="20%" align="right" class="td_block">*First Name:</td>
          <td width="80%">
            <input name="cName" type="text" class="ipt_normal" id="cName3"></td>
        </tr>
        <tr>
          <td align="right" class="td_block">Last Name: </td>
          <td><input name="cLastName" type="text" class="ipt_normal" id="cLastName3"><input type="hidden" name="cIsVIP" value="0">
            <input name="cVIPNum" type="hidden" class="ipt_normal" id="cVIPNum3">
            <input name="cVIPVDate" type="hidden" class="ipt_normal" id="cVIPVDate">
            <input name="cVIPEDate" type="hidden" class="ipt_normal" id="cVIPEDate2"></td>
        </tr>
        <tr>
          <td align="right" class="td_block">Email:</td>
          <td><input name="cEmail" type="text" class="ipt_normal" id="cEmail3"></td>
        </tr>
        <tr>
          <td align="right" class="td_block">Home Phone:</td>
          <td><input name="cHomePhn" type="text" class="ipt_normal" id="cHomePhn3"></td>
        </tr>
        <tr>
          <td align="right" class="td_block">Work/Other Phone: </td>
          <td><input name="cWorkPhn" type="text" class="ipt_normal" id="cWorkPhn3"></td>
        </tr>
        <tr>
          <td align="right" class="td_block">Address:</td>
          <td><input name="cAdd1" type="text" class="ipt_normal" id="cAdd13"></td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td><input name="cAdd2" type="text" class="ipt_normal" id="cAdd23"></td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td><input name="cAdd3" type="text" class="ipt_normal" id="cAdd33"></td>
        </tr>
        <tr>
          <td align="right" class="td_block">Home Fax: </td>
          <td><input name="cFax" type="text" class="ipt_normal" id="cFax3"></td>
        </tr>
        <tr>
          <td colspan="2" class="font_white_9bold"><blockquote>
              <p class="Mgr_Heading">Product Purchases</p>
          </blockquote></td>
        </tr>
        <tr>
          <td align="right" class="td_block">Make:</td>
          <td><input name="cMake" type="text" class="ipt_normal" id="cMake3"></td>
        </tr>
        <tr>
          <td align="right" class="td_block">Model:</td>
          <td><input name="cModel" type="text" class="ipt_normal" id="cModel3"></td>
        </tr>
        <tr>
          <td align="right" class="td_block">Serise:</td>
          <td><input name="cIMEI" type="text" class="ipt_normal" id="cIMEI3"></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input name="Submit" type="button" class="btn" value=" Submit " onClick="add_usr()"></td>
        </tr>
        <input type="hidden" name="MM_insert" value="form1">
      </form>
    </table></td>
    </tr>
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
