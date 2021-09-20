<?php require_once('../Connections/localhost.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "admin";
$MM_authorizedGroups = "tbopr";
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
if (!((isset($_SESSION['RP_Username'])) && (isAuthorized($MM_authorizedUsers, $MM_authorizedGroups, $_SESSION['RP_Username'], $_SESSION['RP_UserGroup'])))) {   
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
//get the availiable dealers
mysql_select_db($database_localhost, $localhost);
$query_dealer = "SELECT iID,cLogin,cName FROM tbdeal where cStatus='normal' ORDER BY iID";
$rs_dealer = mysql_query($query_dealer, $localhost) or die(mysql_error());
$row_dealer = mysql_fetch_assoc($rs_dealer);

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

	if(strlen($_POST['cJN'])!=6){
		die("Job Number entered error.");
	}
	mysql_select_db($database_localhost, $localhost);
	$query_dealer = "SELECT cName FROM tbdeal where cLogin='".$_POST['cSbm']."'";
	$rs_dealer = mysql_query($query_dealer, $localhost) or die(mysql_error());
	$row_dealer = mysql_fetch_assoc($rs_dealer);
	
  $insertSQL = sprintf("INSERT INTO tbrepair (cJN, dtSDate, cStatus, cLocation, iSbmType, cSbm, cSbmBy, cStfName, cCName, cCLastName, cCHomePhn, cCAdd1, cCAdd2, cCAdd3, cCWorkPhn, cCFax, cCEmail, fCChgLmt, cFUD1, cFUD2, cFUD3, cFUD4, cFUD5, cMake, cModel, cIMEI, cFUDFax, cA1, cA2, cA3, cAother, cFCS1, cFCS2, cFCS3, cFCS4, cFCS5, cFCS6, cFCS7, cFCS8, cFCD1, cFCD2, cFCD3, cFCM1, cFCM2, cFCM3, cFCM4, cFCM5, cFCM6, cFCM7, cFCM8, cFCP1, cFCP2, cFCP3, cFCP4, cFCG1, cFCG2, cFCG3, cFCG4, cFCG5, cFCG6, cFCG7, cFCG8, cFCG9, cFCU1, cFCU2, cFCU3, cFCDesc, cLMake, cLModel, cLDeposit, cLIMEI, cLB, cLC, cIIFP, cLother) VALUES ('%s', %s, %s, %s, %s, %s, %s, %s,%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,%s,%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s ,%s)",
                       $_POST['cJN'],
					   "NOW()",
                       GetSQLValueString($_POST['cStatus'], "text"),
                       GetSQLValueString($_POST['cLocation'], "text"),
                       GetSQLValueString($_POST['iSbmType'], "int"),
                       GetSQLValueString($_POST['cSbm'], "text"),
                       GetSQLValueString($row_dealer['cName'], "text"),
                       GetSQLValueString($_POST['cStfName'], "text"),
                       GetSQLValueString($_POST['cCName'], "text"),
                       GetSQLValueString($_POST['cCLastName'], "text"),
                       GetSQLValueString($_POST['cCHomePhn'], "text"),
					   
					   //edit by freeman 28/12/2008, mysql not allow add=null, at lease add=''
                       //GetSQLValueString($_POST['cCAdd1'], "text"),
                       //GetSQLValueString($_POST['cCAdd2'], "text"),
                       //GetSQLValueString($_POST['cCAdd3'], "text"),
					   ("'".$_POST['cCAdd1']."'"),
					   ("'".$_POST['cCAdd2']."'"),
					   ("'".$_POST['cCAdd3']."'"),
					   
                       GetSQLValueString($_POST['cCWorkPhn'], "text"),
                       GetSQLValueString($_POST['cCFax'], "text"),
                       GetSQLValueString($_POST['cCEmail'], "text"),
                       GetSQLValueString($_POST['fCChgLmt'], "double"),
                       GetSQLValueString($_POST['cFUD1'], "text"),
                       GetSQLValueString($_POST['cFUD2'], "text"),
                       GetSQLValueString(isset($_POST['cFUD3']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString($_POST['cFUD4'], "text"),
                       GetSQLValueString(isset($_POST['cFUD5']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString($_POST['cMake'], "text"),
                       GetSQLValueString($_POST['cModel'], "text"),
                       GetSQLValueString($_POST['cIMEI'], "text"),
                       GetSQLValueString($_POST['cFUDFax'], "text"),
                       GetSQLValueString(isset($_POST['cA1']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cA2']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString($_POST['cA3'], "text"),
                       GetSQLValueString($_POST['cAother'], "text"),
                       GetSQLValueString(isset($_POST['cFCS1']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCS2']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCS3']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCS4']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCS5']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCS6']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCS7']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCS8']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCD1']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCD2']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCD3']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCM1']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCM2']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCM3']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCM4']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCM5']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCM6']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCM7']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCM8']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCP1']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCP2']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCP3']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCP4']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCG1']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCG2']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCG3']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCG4']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCG5']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCG6']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCG7']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCG8']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCG9']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCU1']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCU2']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCU3']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString($_POST['cFCDesc'], "text"),
                       GetSQLValueString($_POST['cLMake'], "text"),
                       GetSQLValueString($_POST['cLModel'], "text"),
                       GetSQLValueString($_POST['cLDeposit'], "text"),
                       GetSQLValueString($_POST['cLIMEI'], "text"),
                       GetSQLValueString(isset($_POST['cLB']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cLC']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cIIFP']) ? "true" : "", "defined","'(included inspection fee paid)'","' '"),
                       GetSQLValueString($_POST['cLother'], "text"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($insertSQL, $localhost) or die(mysql_error());
  
  //Insert the Customer's info
  $insertSQL = sprintf("INSERT INTO tbcust (cName, cLastName, cHomePhn, cWorkPhn, cAdd1, cAdd2, cAdd3, cFax, cEmail) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['cCName'], "text"),
                       GetSQLValueString($_POST['cCLastName'], "text"),
                       GetSQLValueString($_POST['cCHomePhn'], "text"),
                       GetSQLValueString($_POST['cCWorkPhn'], "text"),
                       GetSQLValueString($_POST['cCAdd1'], "text"),
                       GetSQLValueString($_POST['cCAdd2'], "text"),
                       GetSQLValueString($_POST['cCAdd3'], "text"),
                       GetSQLValueString($_POST['cCFax'], "text"),
                       GetSQLValueString($_POST['cCEmail'], "text"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($insertSQL, $localhost);

  //Jump to success page
  $insertGoTo = "srf.php?cJN=".$_POST['cJN'];
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
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
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
    <td  valign="top">	<!-- InstanceBeginEditable name="main" --><form name="form1" method="POST" action="srf_manual_add.php">
      <table width="750" border="0" align="center" cellpadding="3" cellspacing="0" class="underline">
        <tr>
          <td align="right"><span class="head_black_bold">Job No.&nbsp;&nbsp;&nbsp;&nbsp;</span>
            <input name="cJN" type="text" class="ipt_srf" id="cJN" value="" size="6" maxlength="6">            
            &nbsp;</td>
        </tr>
        <tr>
          <td align="center" class="head_black_bold">SERVICE REQUEST FORM <br></td>
        </tr>
      </table>
      <table width="750" border="0" align="center" cellpadding="3" cellspacing="0" class="underline">
        <tr>
          <td colspan="4" class="head_black_bold">Job Details </td>
        </tr>
        <tr>
          <td width="91" align="right"><span class="head_red_bold">*</span>Submitted By:</td>
          <td width="254">
    <select name="cSbm" id="cSbm">
      <?php do {?>
      <option value="<?php echo $row_dealer['cLogin'];?>"><?php echo $row_dealer['cName'];?></option>
      <?php 
    } while ($row_dealer = mysql_fetch_assoc($rs_dealer)); 
  ?>
    </select>
          </td>
          <td width="129" align="right">Staff Name:</td>
          <td width="252"><input name="cStfName" type="text" class="ipt_srf" id="cStfName"></td>
        </tr>
      </table>
      <table width="750" border="0" align="center" cellpadding="3" cellspacing="0" class="underline">
        <tr>
          <td colspan="4" class="head_black_bold">Customer Details </td>
        </tr>
        <tr>
          <td width="71" align="right"><span class="head_red_bold">*</span>Name:</td>
          <td width="272">
            <table width="100%"  border="0" cellspacing="1" cellpadding="0">
              <tr>
                <td width="48%"><input name="cCName" type="text" class="ipt_srf" id="cCName"></td>
                <td width="52%"><input name="cCLastName" type="text" class="ipt_srf" id="cCLastName"></td>
              </tr>
              <tr align="center">
                <td><span class="style2">(first name)</span></td>
                <td><span class="style2">(last name)</span></td>
              </tr>
            </table></td>
          <td width="98" align="right"><span class="head_red_bold">*</span>Home Ph:</td>
          <td width="285"><input name="cCHomePhn" type="text" class="ipt_srf" id="cCHomePhn"></td>
        </tr>
        <tr>
          <td align="right">Address:</td>
          <td><input name="cCAdd1" type="text" class="ipt_srf" id="cCAdd1"></td>
          <td align="right">Work Ph: </td>
          <td><input name="cCWorkPhn" type="text" class="ipt_srf" id="cCWorkPhn"></td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td><input name="cCAdd2" type="text" class="ipt_srf" id="cCAdd2"></td>
          <td align="right">Mobile:</td>
          <td><input name="cCFax" type="text" class="ipt_srf" id="cCFax"></td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td><input name="cCAdd3" type="text" class="ipt_srf" id="cCAdd3"></td>
          <td align="right">Notify Exceeds: </td>
          <td>$<input name="fCChgLmt" type="text" class="ipt_srf" id="fCChgLmt" style="width:100px; "> Inc GST</td>
        </tr>
        <tr>
          <td align="right">Email:</td>
          <td><input name="cCEmail" type="text" class="ipt_srf" id="cCEmail"></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <table width="750" border="0" align="center" cellpadding="3" cellspacing="0" class="underline">
        <tr>
          <td colspan="4" class="head_black_bold">Faulty Device Details
              <input name="cFUD1" type="hidden" id="cFUD12" value="checked">
              <input name="cFUD2" type="hidden" id="cFUD22" value="checked">
              <input name="cFUD4" type="hidden" id="cFUD42" value="checked"></td>
        </tr>
        <tr>
          <td width="75"><span class="head_red_bold">*</span>Make:</td>
          <td width="246"><input name="cMake" type="text" class="ipt_srf" id="cMake"></td>
          <td width="83" align="right"><span class="head_red_bold">*</span>Model:</td>
          <td width="322"><input name="cModel" type="text" class="ipt_srf" id="cModel"></td>
        </tr>
        <tr>
          <td><span class="head_red_bold">*</span>IMEI/ESN:</td>
          <td><input name="cIMEI" type="text" class="ipt_srf" id="cIMEI" maxlength="17">
              <input name="cFUDFax" type="hidden" class="ipt_srf" id="cFUDFax" value=""></td>
          <td align="right">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Accessories:</td>
          <td colspan="3"><input name="cA1" type="checkbox" id="cA1" value="checked">
      Battery&nbsp;&nbsp;
      <input name="cA2" type="checkbox" id="cA2" value="checked">
      Charger&nbsp;&nbsp;
      <input name="cA3" type="checkbox" id="cA3" value="checked">
      SIM CARD&nbsp;&nbsp;
      <input name="cFUD3" type="checkbox" id="cFUD3" value="checked">
      MEMORY CARD&nbsp;&nbsp; Other:
      <input name="cAother" type="text" class="ipt_srf" id="cAother">
          </td>
        </tr>
      </table>
      <table width="750" border="0" align="center" cellpadding="3" cellspacing="0" class="underline">
        <tr valign="top">
          <td colspan="5" class="head_black_bold">Fault Details:</td>
        </tr>
        <tr valign="top">
          <td>&nbsp;</td>
          <td class="head_black_bold">Timing of Fault
              <input name="cFCU3" type="hidden" id="cFCU3" value="checked">
              <input name="cFCG1" type="hidden" id="cFCG1" value="checked">
              <input name="cFCG5" type="hidden" id="cFCG5" value="checked">
              <input name="cFCG2" type="hidden" id="cFCG2" value="checked">
              <input name="cFCG4" type="hidden" id="cFCG4" value="checked">
              <input name="cFCG7" type="hidden" id="cFCG7" value="checked">
              <input name="cFCG9" type="hidden" id="cFCG9" value="checked">
              <input name="cFCG3" type="hidden" id="cFCG33" value="checked">
              <input name="cFCG6" type="hidden" id="cFCG63" value="checked">
              <input name="cFCG8" type="hidden" id="cFCG83" value="checked">
              <input name="cFCD3" type="hidden" id="cFCD33" value="checked">
              <input name="cFCD1" type="hidden" id="cFCD14" value="checked">
              <input name="cFCD2" type="hidden" id="cFCD24" value="checked">
              <input name="cFCP3" type="hidden" id="cFCP34" value="checked">
              <input name="cFCP4" type="hidden" id="cFCP44" value="checked">
              <input name="cFCP2" type="hidden" id="cFCP24" value="checked">
              <input name="cFCP1" type="hidden" id="cFCP14" value="checked"></td>
          <td><input name="cFCU1" type="checkbox" id="cFCU1" value="checked">
      Continuous </td>
          <td><input name="cFCU2" type="checkbox" id="cFCU2" value="checked">
      Intermittent </td>
          <td>&nbsp;</td>
        </tr>
        <tr valign="top">
          <td>&nbsp;</td>
          <td><span class="head_black_bold">Type of Fault
                <input name="cFCS3" type="hidden" id="cFCS3" value="checked">
          </span></td>
          <td><input name="cFCM1" type="checkbox" id="cFCM1" value="checked">
      Power Problem </td>
          <td><input name="cFCM4" type="checkbox" id="cFCM4" value="checked">
      Ring Problem </td>
          <td><input name="cFCM2" type="checkbox" id="cFCM2" value="checked">
      Earpiece Problem </td>
        </tr>
        <tr valign="top">
          <td>&nbsp;</td>
          <td><span class="head_black_bold">
            <input name="cFCS6" type="hidden" id="cFCS6" value="checked">
            <input name="cFCS7" type="hidden" id="cFCS7" value="checked">
            <input name="cFCS8" type="hidden" id="cFCS8" value="checked">
            <input name="cFCS1" type="hidden" id="cFCS1" value="checked">
            <input name="cFCS4" type="hidden" id="cFCS4" value="checked">
            <input name="cFCS2" type="hidden" id="cFCS2" value="checked">
            <input name="cFCS5" type="hidden" id="cFCS5" value="checked">
          </span></td>
          <td><input name="cFCM5" type="checkbox" id="cFCM5" value="checked">
      Microphone Problem </td>
          <td><input name="cFCM8" type="checkbox" id="cFCM8" value="checked">
      Keypad Problem </td>
          <td><input name="cFCM6" type="checkbox" id="cFCM6" value="checked">
      Call Problem </td>
        </tr>
        <tr valign="top">
          <td width="8">&nbsp;</td>
          <td width="179" class="head_black_bold">&nbsp;</td>
          <td width="181"><input name="cFCM3" type="checkbox" id="cFCM3" value="checked">
      Display Problem </td>
          <td width="185"><input name="cFCM7" type="checkbox" id="cFCM7" value="checked">
      Software Problem </td>
          <td width="167">&nbsp;</td>
        </tr>
        <tr valign="top">
          <td>&nbsp;</td>
          <td>Description of Fault.<br>
      Please describe the fault in as much detail as possible</td>
          <td colspan="3"><textarea name="cFCDesc" rows="6" wrap="VIRTUAL" id="textarea" style="width:100%; "></textarea></td>
        </tr>
        <tr valign="top">
          <td>&nbsp;</td>
          <td><span class="head_black_bold">
            <input name="cFUD5" type="checkbox" id="cFUD5" value="checked">
          </span>WARRANTY CLAIM</td>
          <td colspan="3"> This only applies for the device that purchase from Omni Tech with proof of purchase retained or for re-service device under same fault occur within 90 days. </td>
        </tr>
      </table>
      <table width="750" border="0" align="center" cellpadding="3" cellspacing="0" class="underline">
        <tr>
          <td colspan="4" class="head_black_bold">Loan Equipment (if applicable) </td>
        </tr>
        <tr>
          <td width="96" align="right">Handset Make: </td>
          <td width="225"><input name="cLMake" type="text" class="ipt_srf" id="cLMake"></td>
          <td width="124" align="right">Handset Model:</td>
          <td width="281"><input name="cLModel" type="text" class="ipt_srf" id="cLModel"></td>
        </tr>
        <tr>
          <td align="right">Deposit taken: </td>
          <td><input name="cLDeposit" type="text" class="ipt_srf" id="cLDeposit"></td>
          <td align="right">IMEI</td>
          <td><input name="cLIMEI" type="text" class="ipt_srf" id="cLIMEI" maxlength="17"></td>
        </tr>
        <tr>
          <td><input name="cLB" type="checkbox" id="cLB" value="checked">
      Battery</td>
          <td><input name="cLC" type="checkbox" id="cLC" value="checked">
      Charger</td>
          <td align="right">Other:</td>
          <td><input name="cLother" type="text" class="ipt_srf" id="cLother"></td>
        </tr>
      </table>
      <table width="750" border="0" align="center" cellpadding="3" cellspacing="0">
        <tr>
          <td>Inspection Fee
              <input name="cIIFP" type="checkbox" id="cIIFP" value="checked"></td>
        </tr>
        <tr>
          <td><input name="iSbmType" type="hidden" id="iSbmType" value="3">
              <input name="cStatus" type="hidden" id="cStatus" value="S05">
              <input name="cLocation" type="hidden" id="cLocation" value="L00">
              <input type="hidden" name="MM_insert" value="form1">
              <a href="termncond.php" target="_blank">Terms &amp; Conditions &gt;&gt; </a></td>
        </tr>
        <tr>
          <td align="center"><input name="Submit" type="submit" onClick="MM_validateForm('cJN','','RisNum','cCName','','R','cCLastName','','R','cCHomePhn','','R','cMake','','R','cModel','','R','cIMEI','','R');return document.MM_returnValue" value="Submit"></td>
        </tr>
      </table>
    </form><!-- InstanceEndEditable -->
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
mysql_free_result($rs_dealer);
?>
