<?php require_once('./Connections/localhost.php'); ?>
<?php

$colname_rs = "1";
if (isset($_GET['cJN'])) {
  $colname_rs = (get_magic_quotes_gpc()) ? $_GET['cJN'] : addslashes($_GET['cJN']);
}
mysql_select_db($database_localhost, $localhost);
$dt_fm = "%d %b %Y, %h:%i %p";
$query_rs = sprintf("SELECT *, DATE_FORMAT(dtSDate,'%s') as dtSDate2 FROM tbrepair WHERE cJN = '%s'", $dt_fm, $colname_rs);
$rs = mysql_query($query_rs, $localhost) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);
$totalRows_rs = mysql_num_rows($rs);

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

session_start();

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE tbrepair SET cStatus=%s, cLocation=%s, iSbmType=%s, cSbm=%s, cSbmBy=%s, cStfName=%s, cIIFP=%s, cCName=%s, cCLastName=%s, cCHomePhn=%s, cCAdd1=%s, cCAdd2=%s, cCAdd3=%s, cCWorkPhn=%s, cCFax=%s, cCEmail=%s, fCChgLmt=%s, cFUD3=%s, cFUD5=%s, cMake=%s, cClaim=%s, cModel=%s, cIMEI=%s, cFUDFax=%s, cA1=%s, cA2=%s, cA3=%s, cAother=%s, cFCS1=%s, cFCS2=%s, cFCS3=%s, cFCS4=%s, cFCS5=%s, cFCS6=%s, cFCS7=%s, cFCS8=%s, cFCD1=%s, cFCD2=%s, cFCD3=%s, cFCM1=%s, cFCM2=%s, cFCM3=%s, cFCM4=%s, cFCM5=%s, cFCM6=%s, cFCM7=%s, cFCM8=%s, cFCP1=%s, cFCP2=%s, cFCP3=%s, cFCP4=%s, cFCG1=%s, cFCG2=%s, cFCG3=%s, cFCG4=%s, cFCG5=%s, cFCG6=%s, cFCG7=%s, cFCG8=%s, cFCG9=%s, cFCU1=%s, cFCU2=%s, cFCU3=%s, cFCDesc=%s, cLMake=%s, cLModel=%s, cLDeposit=%s, cLIMEI=%s, cLB=%s, cLC=%s, cLother=%s, cAgentID=%s, cAgentName=%s WHERE iID=%s",
                       GetSQLValueString($_POST['cStatus'], "text"),
                       GetSQLValueString($_POST['cLocation'], "text"),
                       GetSQLValueString($_POST['iSbmType'], "int"),
                       GetSQLValueString($_POST['cSbm'], "text"),
                       GetSQLValueString($_POST['cSbmBy'], "text"),
                       GetSQLValueString($_POST['cStfName'], "text"),
                       GetSQLValueString(isset($_POST['cIIFP']) ? "true" : "", "defined","'(included inspection fee paid)'","' '"),
                       GetSQLValueString($_POST['cCName'], "text"),
                       GetSQLValueString($_POST['cCLastName'], "text"),
                       GetSQLValueString($_POST['cCHomePhn'], "text"),
                       GetSQLValueString($_POST['cCAdd1'], "text"),
                       GetSQLValueString($_POST['cCAdd2'], "text"),
                       GetSQLValueString($_POST['cCAdd3'], "text"),
                       GetSQLValueString($_POST['cCWorkPhn'], "text"),
                       GetSQLValueString($_POST['cCFax'], "text"),
                       GetSQLValueString($_POST['cCEmail'], "text"),
                       GetSQLValueString($_POST['fCChgLmt'], "double"),
                       GetSQLValueString(isset($_POST['cFUD3']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFUD5']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString($_POST['cMake'], "text"),
                       GetSQLValueString($_POST['cClaim'], "text"),
                       GetSQLValueString($_POST['cModel'], "text"),
                       GetSQLValueString($_POST['cIMEI'], "text"),
                       GetSQLValueString($_POST['cFUDFax'], "text"),
                       GetSQLValueString(isset($_POST['cA1']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cA2']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cA3']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString($_POST['cAother'], "text"),
                       GetSQLValueString($_POST['cFCS1'], "text"),
                       GetSQLValueString($_POST['cFCS2'], "text"),
                       GetSQLValueString($_POST['cFCS3'], "text"),
                       GetSQLValueString($_POST['cFCS4'], "text"),
                       GetSQLValueString(isset($_POST['cFCS5']) ? "true" : "", "defined","'(included inspection fee $45.0 paid)'","' '"),
                       GetSQLValueString($_POST['cFCS6'], "text"),
                       GetSQLValueString($_POST['cFCS7'], "text"),
                       GetSQLValueString($_POST['cFCS8'], "text"),
                       GetSQLValueString($_POST['cFCD1'], "text"),
                       GetSQLValueString($_POST['cFCD2'], "text"),
                       GetSQLValueString($_POST['cFCD3'], "text"),
                       GetSQLValueString(isset($_POST['cFCM1']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCM2']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCM3']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCM4']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCM5']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCM6']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCM7']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCM8']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString($_POST['cFCP1'], "text"),
                       GetSQLValueString($_POST['cFCP2'], "text"),
                       GetSQLValueString($_POST['cFCP3'], "text"),
                       GetSQLValueString($_POST['cFCP4'], "text"),
                       GetSQLValueString($_POST['cFCG1'], "text"),
                       GetSQLValueString($_POST['cFCG2'], "text"),
                       GetSQLValueString($_POST['cFCG3'], "text"),
                       GetSQLValueString($_POST['cFCG4'], "text"),
                       GetSQLValueString($_POST['cFCG5'], "text"),
                       GetSQLValueString($_POST['cFCG6'], "text"),
                       GetSQLValueString($_POST['cFCG7'], "text"),
                       GetSQLValueString($_POST['cFCG8'], "text"),
                       GetSQLValueString($_POST['cFCG9'], "text"),
                       GetSQLValueString(isset($_POST['cFCU1']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCU2']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString($_POST['cFCU3'], "text"),
					   GetSQLValueString($_POST['cFCDesc'], "text"),
                       GetSQLValueString($_POST['cLMake'], "text"),
                       GetSQLValueString($_POST['cLModel'], "text"),
                       GetSQLValueString($_POST['cLDeposit'], "text"),
                       GetSQLValueString($_POST['cLIMEI'], "text"),
                       GetSQLValueString(isset($_POST['cLB']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cLC']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString($_POST['cLother'], "text"),
                       GetSQLValueString($_POST['cAgentID'], "text"),
                       GetSQLValueString($_POST['agName'], "text"),
                       GetSQLValueString($_POST['iID'], "int"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());
  
  //insert Job Log  
  mysql_select_db($database_localhost, $localhost);
  $logperson = $_POST['cStfName'];
  $logcontent = "Job info is modified by Dealer ". $_POST['cSbmBy'];
  $sql_log = sprintf("insert tblog (cJN, dtDate, cPerson, cContent) values (%s,%s,%s,%s)",
  					$_POST['cJN'],
					"NOW()",
                    GetSQLValueString($logperson, "text"),
                    GetSQLValueString($logcontent, "text"));
  $Result1 = mysql_query($sql_log, $localhost) or die(mysql_error());

  $updateGoTo = "de_srf.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
?>
<html><!-- InstanceBegin template="/Templates/index_simple.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>OmniTech</title>
<!-- InstanceEndEditable --><link href="css.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" type="text/JavaScript">
<!--



function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
<!-- InstanceBeginEditable name="head" -->
<style type="text/css">
<!--
.style2 {color: #999999}
-->
</style>
<script type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<!-- InstanceEndEditable -->
</head>

<body>
<table width="780" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="378"><img src="images/logo_simple.gif" width="378" height="92"></td>
    <td width="402" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
</table>
<table width="780" border="0" align="center" cellpadding="0" cellspacing="0" background="images/menu_btm.gif">
  <tr>
    <td><img src="images/1x1.gif" width="1" height="8"></td>
  </tr>
</table>
<table width="780" height="44" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="236" align="center"><?php include('./inc_sch.php');?>
    </td>
    <td width="544" align="center">&nbsp;</td>
  </tr>
</table>
<table width="780" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#CCCCCC">
    <td valign="top"><img src="images/1x1.gif" width="1" height="5"></td>
  </tr>
  <tr>
    <td valign="top"><!-- InstanceBeginEditable name="main" -->
	<?php include('repair/myfunction.php');?>
<table width="750" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF" class="underline">
  <tr>
    <td align="right">Status:</td>
    <td align="left" class="btn"><?php echo getStatus($row_rs['cStatus']); ?></td>
  </tr>
  <tr>
    <td width="83" align="right">Location:</td>
  <td width="655" align="left"><?php echo getLocation($row_rs['cLocation']); ?>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="right">Job No.&nbsp;&nbsp;&nbsp;&nbsp;<span class="head_black_bold"><?php echo $row_rs['cJN']; ?></span><br>
        <span class="head_black_bold"><?php echo $row_rs['dtSDate2']; ?></span></td>
  </tr>
  <tr>
    <td colspan="2" align="center" class="head_black_bold">SERVICE REQUEST FORM <br></td>
  </tr>
</table>
<?php 
if($row_rs['cStatus']=="S05"){
?><form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
<table width="750" border="0" align="center" cellpadding="3" cellspacing="0" class="underline">
  <tr>
    <td colspan="4" class="head_black_bold">Job Details </td>
  </tr>
  <tr>
    <td width="91" align="right"><span class="head_red_bold">*</span>Submitted By:</td>
    <td width="254"><input name="cSbmBy" type="text" class="ipt_srf" id="cSbmBy" value="<?php echo $row_rs['cSbmBy']; ?>">
    </td>
    <td width="129" align="right"><span class="head_red_bold">*</span>Staff Name:</td>
    <td width="252"><input name="cStfName" type="text" class="ipt_srf" id="cStfName" value="<?php echo $row_rs['cStfName']; ?>"></td>
  </tr>
</table>
<table width="750" border="0" align="center" cellpadding="3" cellspacing="0" class="underline">
  <tr>
    <td colspan="4" class="head_black_bold">Customer Details </td>
  </tr>
  <tr>
    <td width="71" align="right"><span class="head_red_bold">*</span>Name:</td>
    <td width="272"><table width="100%"  border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td width="48%"><input name="cCName" type="text" class="ipt_srf" id="cCName" value="<?php echo $row_rs['cCName']; ?>"></td>
        <td width="52%"><input name="cCLastName" type="text" class="ipt_srf" id="cCLastName" value="<?php echo $row_rs['cCLastName']; ?>"></td>
      </tr>
      <tr align="center">
        <td><span class="style2">(first name)</span></td>
        <td><span class="style2">(last name)</span></td>
      </tr>
    </table></td>
    <td width="98" align="right"><span class="head_red_bold">*</span>Home Ph:</td>
    <td width="285"><input name="cCHomePhn" type="text" class="ipt_srf" id="cCHomePhn" value="<?php echo $row_rs['cCHomePhn']; ?>"></td>
  </tr>
  <tr>
    <td align="right">Address:</td>
    <td><input name="cCAdd1" type="text" class="ipt_srf" id="cCAdd1" value="<?php echo $row_rs['cCAdd1']; ?>"></td>
    <td align="right">Work Ph: </td>
    <td><input name="cCWorkPhn" type="text" class="ipt_srf" id="cCWorkPhn" value="<?php echo $row_rs['cCWorkPhn']; ?>"></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td><input name="cCAdd2" type="text" class="ipt_srf" id="cCAdd2" value="<?php echo $row_rs['cCAdd2']; ?>"></td>
    <td align="right">Mobile: </td>
    <td><input name="cCFax" type="text" class="ipt_srf" id="cCFax" value="<?php echo $row_rs['cCFax']; ?>"></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td><input name="cCAdd3" type="text" class="ipt_srf" id="cCAdd3" value="<?php echo $row_rs['cCAdd3']; ?>"></td>
    <td align="right">Notify Exceeds: </td>
    <td>$
        <input name="fCChgLmt" type="text" class="ipt_srf" id="fCChgLmt" style="width:100px; " value="<?php echo $row_rs['fCChgLmt']; ?>">
    </td>
  </tr>
  <tr>
    <td align="right">Email:</td>
    <td><input name="cCEmail" type="text" class="ipt_srf" id="cCEmail" value="<?php echo $row_rs['cCEmail']; ?>"></td>
    <td align="right">&nbsp;</td>
    <td><?php if(isset($_SESSION['DE_Username']) && ($_SESSION['DE_Username']=='omnitech' || $_SESSION['DE_Username']=='omnitechaly' || $_SESSION['DE_Username']=='omnitechsp' || $_SESSION['DE_Username']=='omnitechm' || $_SESSION['DE_Username']=='omnitechw' || $_SESSION['DE_Username']=='omnitechsl' || $_SESSION['DE_Username']=='omnitechnl' || $_SESSION['DE_Username']=='omnitechh' || $_SESSION['DE_Username']=='omnitechd')){?>
      Agent:
      <input name="agName" type="text" class="ipt_srf" id="agName" style="width:200px; " onDblClick="MM_openBrWindow('repair/ag_sel.php','Select','scrollbars=yes,resizable=yes,width=600,height=400')" value="<?php echo $row_rs['cAgentName'];?>" readonly>
        <?php }?>
      &nbsp;
        <input name="cAgentID" type="hidden" id="cAgentID" value="<?php echo $row_rs['cAgentID'];?>" readonly></td>
  </tr>
</table>
<table width="750" border="0" align="center" cellpadding="3" cellspacing="0" class="underline">
  <tr>
    <td colspan="6" class="head_black_bold">Faulty Device Details
      <input name="cFUD12" type="hidden" id="cFUD1" value="checked">
        <input name="cFUD22" type="hidden" id="cFUD2" value="checked">
        <input name="cFUD42" type="hidden" id="cFUD4" value="checked"></td>
  </tr>
  <tr>
    <td width="63"><span class="head_red_bold">*</span>Make:</td>
    <td width="258"><input name="cMake" type="text" class="ipt_srf" id="cMake" value="<?php echo $row_rs['cMake']; ?>"></td>
    <td width="83" align="right"><span class="head_red_bold">*</span>Model:</td>
    <td colspan="3"><input name="cModel" type="text" class="ipt_srf" id="cModel" value="<?php echo $row_rs['cModel']; ?>"></td>
  </tr>
  <tr>
    <td><span class="head_red_bold">*</span>IMEI/ESN:</td>
    <td><input name="cIMEI" type="text" class="ipt_srf" id="cIMEI" value="<?php echo $row_rs['cIMEI']; ?>" maxlength="17"></td>
    <td align="right">Security Code:</td>
    <td width="123"><input name="cFUDFax" type="text" class="ipt_srf" id="cFUDFax" value="<?php echo $row_rs['cFUDFax']; ?>"></td>
          <td width="46" align="right">Claim No. </td>
          <td width="141"><input name="cClaim" type="text" class="ipt_srf" id="cClaim" value="<?php echo $row_rs['cClaim']; ?>"></td>
  </tr>
  <tr>
    <td>Accessories:</td>
    <td colspan="5"><input name="cA1" type="checkbox" id="cA1" value="checked" <?php echo $row_rs['cA1']; ?>>
      Battery&nbsp;&nbsp;
      <input name="cA2" type="checkbox" id="cA2" value="checked" <?php echo $row_rs['cA2']; ?>>
      Charger(send with all power-related faults)&nbsp;&nbsp;
      <input name="cA3" type="checkbox" id="cA3" value="checked" <?php echo $row_rs['cA3']; ?>>
      SIM CARD&nbsp;&nbsp;
      <input name="cFUD3" type="checkbox" id="cFUD3" value="checked"<?php echo $row_rs['cFUD3']; ?>>
      MEMORY CARD&nbsp;&nbsp;
      Other:
      <input name="cAother" type="text" class="ipt_login" id="cAother" value="<?php echo $row_rs['cAother']; ?>">    </td>
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
    <td><input name="cFCU1" type="checkbox" id="cFCU1" value="checked" <?php echo $row_rs['cFCU1']; ?>>
      Continuous </td>
    <td><input name="cFCU2" type="checkbox" id="cFCU2" value="checked" <?php echo $row_rs['cFCU2']; ?>>
      Intermittent </td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td>&nbsp;</td>
    <td><span class="head_black_bold">Type of Fault
      <input name="cFCS3" type="hidden" id="cFCS3" value="checked" <?php echo $row_rs['cFCS3']; ?>>
    </span></td>
    <td><input name="cFCM1" type="checkbox" id="cFCM1" value="checked" <?php echo $row_rs['cFCM1']; ?>>
      Power Problem </td>
    <td><input name="cFCM4" type="checkbox" id="cFCM4" value="checked" <?php echo $row_rs['cFCM4']; ?>>
      Ring Problem </td>
    <td><input name="cFCM2" type="checkbox" id="cFCM2" value="checked" <?php echo $row_rs['cFCM2']; ?>>
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
    </span></td>
    <td><input name="cFCM5" type="checkbox" id="cFCM5" value="checked" <?php echo $row_rs['cFCM5']; ?>>
      Microphone Problem </td>
    <td><input name="cFCM8" type="checkbox" id="cFCM8" value="checked" <?php echo $row_rs['cFCM8']; ?>>
      Keypad Problem </td>
    <td><input name="cFCM6" type="checkbox" id="cFCM6" value="checked" <?php echo $row_rs['cFCM6']; ?>>
      Call Problem </td>
  </tr>
  <tr valign="top">
    <td width="8">&nbsp;</td>
    <td width="179" class="head_black_bold">&nbsp;</td>
    <td width="181"><input name="cFCM3" type="checkbox" id="cFCM3" value="checked" <?php echo $row_rs['cFCM3']; ?>>
      Display Problem </td>
    <td width="185"><input name="cFCM7" type="checkbox" id="cFCM7" value="checked" <?php echo $row_rs['cFCM7']; ?>>
      Software Problem </td>
    <td width="167">&nbsp;</td>
  </tr>
  <tr valign="top">
    <td>&nbsp;</td>
    <td>Description of Fault.<br>
      Please describe the fault in as much detail as possible</td>
    <td colspan="3"><textarea name="cFCDesc" rows="6" wrap="VIRTUAL" id="cFCDesc" style="width:100%; "><?php echo $row_rs['cFCDesc']; ?></textarea></td>
  </tr>
  <tr valign="top">
    <td>&nbsp;</td>
    <td><span class="head_black_bold">
      <input name="cFUD5" type="checkbox" id="cFUD5" value="checked"<?php echo $row_rs['cFUD5']; ?>>
    </span>WARRANTY CLAIM</td>
    <td colspan="3"> This only applies for the device that purchase from Omni Tech with proof of purchase retained or for re-service device under same fault occur within 50 days. </td>
  </tr>
</table>
<table width="750" border="0" align="center" cellpadding="3" cellspacing="0" class="underline">
  <tr>
    <td colspan="4" class="head_black_bold">Loan Equipment (if applicable) </td>
  </tr>
  <tr>
    <td width="96" align="right">Handset Make: </td>
    <td width="225"><input name="cLMake" type="text" class="ipt_srf" id="cLMake" value="<?php echo $row_rs['cLMake']; ?>"></td>
    <td width="124" align="right">Handset Model:</td>
    <td width="281"><input name="cLModel" type="text" class="ipt_srf" id="cLModel" value="<?php echo $row_rs['cLModel']; ?>"></td>
  </tr>
  <tr>
    <td align="right">Deposit taken: </td>
    <td><input name="cLDeposit" type="text" class="ipt_srf" id="cLDeposit" value="<?php echo $row_rs['cLDeposit']; ?>"></td>
    <td align="right">IMEI</td>
    <td><input name="cLIMEI" type="text" class="ipt_srf" id="cLIMEI" maxlength="17" value="<?php echo $row_rs['cLIMEI']; ?>"></td>
  </tr>
  <tr>
    <td><input name="cLB" type="checkbox" id="cLB" value="checked" <?php echo $row_rs['cLB']; ?>>
      Battery</td>
    <td><input name="cLC" type="checkbox" id="cLC" value="checked" <?php echo $row_rs['cLC']; ?>>
      Charger</td>
    <td align="right">Other:</td>
    <td><input name="cLother" type="text" class="ipt_srf" id="cLother" value="<?php echo $row_rs['cLother']; ?>"></td>
  </tr>
</table>
<table width="750" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td>
			  <?php 
			  if(in_array($_SESSION['DE_Username'], $_SESSION['DE_BranchList'])){
			  ?>Inspection Fee
      <input name="cIIFP" type="checkbox" id="cIIFP" value="checked" <?php echo ($row_rs['cIIFP']!="")?"checked":""?>>
      &nbsp;Inspection Fee $45.0
      <input name="cFCS5" type="checkbox" id="cFCS5" value="checked" <?php echo ($row_rs['cFCS5']!="")?"checked":""?>>
		<?php
		}
		?></td>
  </tr>
  <tr>
    <td><input name="iSbmType" type="hidden" id="iSbmType" value="1">
        <input name="cStatus" type="hidden" id="cStatus" value="S05">
        <input name="cSbm" type="hidden" class="ipt_srf" id="cSbm" value="<?php echo $_SESSION['DE_Username'];?>">
        <input name="cLocation" type="hidden" id="cLocation" value="L00">
        <input type="hidden" name="MM_insert" value="form1">
        <input name="iID" type="hidden" id="iID" value="<?php echo $row_rs['iID']; ?>">
        <input name="cJN" type="hidden" id="cJN" value="<?php echo $row_rs['cJN']; ?>"></td>
  </tr>
  <tr>
    <td align="center"><input name="Submit" type="submit" onClick="MM_validateForm('cSbmBy','','R','cStfName','','R','cCName','','R','cCLastName','','R','cCHomePhn','','R','cMake','','R','cModel','','R','cIMEI','','R');return document.MM_returnValue" value="Submit"></td>
  </tr>
</table>
<input type="hidden" name="MM_update" value="form1">
</form>
<?php 
}else{
?>
<table width="750" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF" class="underline">
  <tr>
    <td colspan="4" class="head_black_bold">Job Details </td>
  </tr>
  <tr>
    <td width="91" align="right">Submitted By:</td>
    <td width="254">&nbsp;<span class="head_black_bold"><?php echo $row_rs['cSbmBy']; ?></span>    </td>
    <td width="129" align="right">Staff Name:</td>
    <td width="252" class="head_black_bold"><?php echo $row_rs['cStfName']; ?></td>
  </tr>
</table>
<table width="750" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF" class="underline">
  <tr>
    <td colspan="4" class="head_black_bold">Customer Details </td>
  </tr>
  <tr>
    <td width="71" align="right">Name:</td>
    <td width="272" class="head_black_bold"><?php echo $row_rs['cCName']; ?> <?php echo $row_rs['cCLastName']; ?></td>
    <td width="98" align="right">Home Ph:</td>
    <td width="285" class="head_black_bold"><?php echo $row_rs['cCHomePhn']; ?></td>
  </tr>
  <tr>
    <td align="right">Address:</td>
    <td class="head_black_bold"><?php echo $row_rs['cCAdd1']; ?></td>
    <td align="right">Work Ph: </td>
    <td class="head_black_bold"><?php echo $row_rs['cCWorkPhn']; ?></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td class="head_black_bold"><?php echo $row_rs['cCAdd2']; ?></td>
    <td align="right">Mobile:</td>
    <td class="head_black_bold"><?php echo $row_rs['cCFax']; ?></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td class="head_black_bold"><?php echo $row_rs['cCAdd3']; ?></td>
    <td align="right">Notify Exceeds: </td>
    <td class="head_black_bold"><?php echo $row_rs['fCChgLmt']; ?></td>
  </tr>
  <tr>
    <td align="right">Email:</td>
    <td class="head_black_bold"><?php echo $row_rs['cCEmail']; ?></td>
    <td>&nbsp;</td>
    <td><?php if($row_rs['cAgentName']!=null) echo "Agent: ".$row_rs['cAgentName'];?>&nbsp;</td>
  </tr>
</table>
<table width="750" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF" class="underline">
  <tr>
    <td colspan="6" class="head_black_bold">Faulty Unit Details
        <input name="cFUD3" type="hidden" id="cFUD32" value="checked"  <?php echo $row_rs['cFUD3']; ?>>
        <input name="cFUD5" type="hidden" id="cFUD52" value="checked"  <?php echo $row_rs['cFUD5']; ?>>
        <input name="cFUD1" type="hidden" id="cFUD12" value="checked">
        <input name="cFUD2" type="hidden" id="cFUD22" value="checked">
        <input name="cFUD4" type="hidden" id="cFUD42" value="checked"></td>
  </tr>
  <tr>
    <td width="65">Make:</td>
    <td width="182" class="head_black_bold"><?php echo $row_rs['cMake']; ?></td>
    <td width="91" align="right">Model:</td>
    <td width="168" class="head_black_bold"><?php echo $row_rs['cModel']; ?></td>
    <td width="80" class="head_black_bold">&nbsp;</td>
    <td width="128" class="head_black_bold">&nbsp;</td>
  </tr>
  <tr>
    <td>IMEI/ESN:</td>
    <td class="head_black_bold"><?php echo $row_rs['cIMEI']; ?></td>
    <td align="right">Security Code:</td>
    <td class="head_black_bold"><?php echo $row_rs['cFUDFax']; ?></td>
    <td align="right">Claim No. </td>
    <td class="head_black_bold"><?php echo $row_rs['cClaim']; ?></td>
  </tr>
  <tr>
    <td>Accessories:</td>
    <td colspan="5"><input name="cA1" type="checkbox" id="cA1" value="checked"  <?php echo $row_rs['cA1']; ?> disabled>
      Battery&nbsp;&nbsp;
      <input name="cA2" type="checkbox" id="cA2" value="checked"  <?php echo $row_rs['cA2']; ?> disabled>
      Charger
      <input name="cA3" type="checkbox" id="cA3" value="checked"  <?php echo $row_rs['cA3']; ?> disabled>
      SIM Card &nbsp;&nbsp;
      <input name="cA5" type="checkbox" id="cA5" value="checked"  <?php echo $row_rs['cFUD3']; ?> disabled>
      MEMORY CARD Other: <span class="head_black_bold"><?php echo $row_rs['cAother']; ?></span> </td>
  </tr>
</table>
<table width="750" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF" class="underline">
  <tr valign="top">
    <td colspan="5" class="Mgr_Heading">Fault Details</td>
  </tr>
  <tr valign="top">
    <td>&nbsp;</td>
    <td class="Mgr_Heading">Timing of Fault </td>
    <td><input name="cFCU1" type="checkbox" id="cFCU1" value="checked" <?php echo $row_rs['cFCU1']; ?> disabled>
      Continuous </td>
    <td><input name="cFCU2" type="checkbox" id="cFCU2" value="checked" <?php echo $row_rs['cFCU2']; ?> disabled>
      Intermittent </td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td>&nbsp;</td>
    <td><span class="Mgr_Heading">Type of Fault </span></td>
    <td><input name="cFCM1" type="checkbox" id="cFCM1" value="checked" <?php echo $row_rs['cFCM1']; ?> disabled>
      Power Problem </td>
    <td><input name="cFCM4" type="checkbox" id="cFCM4" value="checked" <?php echo $row_rs['cFCM4']; ?> disabled>
      Ring Problem </td>
    <td><input name="cFCM2" type="checkbox" id="cFCM2" value="checked" <?php echo $row_rs['cFCM2']; ?> disabled>
      Earpiece Problem </td>
  </tr>
  <tr valign="top">
    <td>&nbsp;</td>
    <td><span class="Mgr_Heading"> </span></td>
    <td><input name="cFCM5" type="checkbox" id="cFCM5" value="checked" <?php echo $row_rs['cFCM5']; ?> disabled>
      Microphone Problem </td>
    <td><input name="cFCM8" type="checkbox" id="cFCM8" value="checked" <?php echo $row_rs['cFCM8']; ?> disabled>
      Keypad Problem </td>
    <td><input name="cFCM6" type="checkbox" id="cFCM6" value="checked" <?php echo $row_rs['cFCM6']; ?> disabled>
      Call Problem </td>
  </tr>
  <tr valign="top">
    <td width="8">&nbsp;</td>
    <td width="179" class="Mgr_Heading">&nbsp;</td>
    <td width="181"><input name="cFCM3" type="checkbox" id="cFCM3" value="checked" <?php echo $row_rs['cFCM3']; ?> disabled>
      Display Problem </td>
    <td width="185"><input name="cFCM7" type="checkbox" id="cFCM7" value="checked" <?php echo $row_rs['cFCM7']; ?> disabled>
      Software Problem </td>
    <td width="167">&nbsp;</td>
  </tr>
  <tr valign="top">
    <td>&nbsp;</td>
    <td>Description of Fault.<br>
      Please describe the fault in as much detail as possible</td>
    <td colspan="3"><textarea name="cFCDesc" rows="6" wrap="VIRTUAL" id="textarea" style="width:100%; "><?php echo $row_rs['cFCDesc']; ?></textarea></td>
  </tr>
  <tr valign="top">
    <td>&nbsp;</td>
    <td><span class="Mgr_Heading">
      <input name="cFUD52" type="checkbox" id="cFUD5" value="checked" <?php echo $row_rs['cFUD5']; ?> disabled>
    </span>WARRANTY CLAIM</td>
    <td colspan="3"> This only applies for the device that purchase from Omni Tech with proof of purchase retained or for re-service device under same fault occur within 50 days. </td>
  </tr>
</table>
    <table width="750" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF" class="underline">
      <tr>
        <td colspan="4" class="Mgr_Heading">Loan Equipment (if applicable) </td>
      </tr>
      <tr>
        <td width="96" align="right">Handset Make: </td>
        <td width="225"><?php echo $row_rs['cLMake']; ?></td>
        <td width="124" align="right">Handset Model:</td>
        <td width="281"><?php echo $row_rs['cLModel']; ?></td>
      </tr>
      <tr>
        <td align="right">Deposit taken: </td>
        <td><?php echo $row_rs['cLDeposit']; ?></td>
        <td align="right">IMEI</td>
        <td><?php echo $row_rs['cLIMEI']; ?></td>
      </tr>
      <tr>
        <td><input name="cLB" type="checkbox" id="cLB" value="checked" <?php echo $row_rs['cLB']; ?> disabled>
      Battery</td>
        <td><input name="cLC" type="checkbox" id="cLC" value="checked" <?php echo $row_rs['cLC']; ?> disabled>
      Charger</td>
        <td align="right">Other:</td>
        <td><?php echo $row_rs['cLother']; ?></td>
      </tr>
    </table>
    <table width="750" border="0" align="center" cellpadding="3" cellspacing="0">
      <tr>
        <td bgcolor="#FFFFFF">
		<?php 
		if(in_array($_SESSION['DE_Username'], $_SESSION['DE_BranchList'])){
		if($row_rs['cFCS5']==""){
		?>
		Inspection paid
            <input name="cIIFP" type="checkbox" id="cIIFP" value="checkbox" <?php echo ($row_rs['cIIFP']!="")?"checked":""?> disabled>
		<?php
		}else{
		?>
		Inspection Fee $45.0
      		<input name="cFCS5" type="checkbox" id="cFCS5" value="checked" <?php echo ($row_rs['cFCS5']!="")?"checked":""?> disabled="disabled">
		<?php
		}}
		?></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" bgcolor="#FFFFFF"></td>
      </tr>
    </table>
<?php 
}
?>
    <!-- InstanceEndEditable --></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($rs);
?>
