<?php require_once('Connections/localhost.php'); ?>
<?php
session_start();
//get the current Job Number
mysql_select_db($database_localhost, $localhost);
$query_JN = "SELECT iJN FROM tbjn WHERE iID = 1";
$JN = mysql_query($query_JN, $localhost) or die(mysql_error());
$row_JN = mysql_fetch_assoc($JN);
$totalRows_JN = mysql_num_rows($JN);

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
  $insertSQL = sprintf("INSERT INTO tbrepair (cJN, dtSDate, cStatus, cLocation, iSbmType, cSbm, cSbmBy, cStfName, cCName, cCLastName, cCHomePhn, cCAdd1, cCAdd2, cCAdd3, cCWorkPhn, cCFax, cCEmail, fCChgLmt, cFUD1, cFUD2, cFUD3, cFUD4, cFUD5, cMake, cModel, cIMEI, cFUDFax, cA1, cA2, cA3, cAother, cFCS1, cFCS2, cFCS3, cFCS4, cFCS5, cFCS6, cFCS7, cFCS8, cFCD1, cFCD2, cFCD3, cFCM1, cFCM2, cFCM3, cFCM4, cFCM5, cFCM6, cFCM7, cFCM8, cFCP1, cFCP2, cFCP3, cFCP4, cFCG1, cFCG2, cFCG3, cFCG4, cFCG5, cFCG6, cFCG7, cFCG8, cFCG9, cFCU1, cFCU2, cFCU3, cFCDesc, cLMake, cLModel, cLDeposit, cLIMEI, cLB, cLC, cLother) VALUES ('%s', %s, %s, %s, %s, %s, %s, %s,%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,%s,%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       $row_JN['iJN'],
					   "NOW()",
                       GetSQLValueString($_POST['cStatus'], "text"),
                       GetSQLValueString($_POST['cLocation'], "text"),
                       GetSQLValueString($_POST['iSbmType'], "int"),
                       GetSQLValueString($_POST['cSbm'], "text"),
                       GetSQLValueString($_POST['cSbmBy'], "text"),
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
                       GetSQLValueString($_POST['cLother'], "text"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($insertSQL, $localhost) or die(mysql_error());
  
  //Increase the Job Number
  $updateSQL = "UPDATE tbjn SET iJN=iJN+1 WHERE iID='1'";
  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());
  
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
  $Result1 = mysql_query($insertSQL, $localhost) or die(mysql_error());

  //Jump to success page
  $insertGoTo = "srf_suc.php?cJN=".$row_JN['iJN'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
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
      <form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
      <table width="750" border="0" align="center" cellpadding="3" cellspacing="0" class="underline">
        <tr>
          <td align="right"><span class="head_black_bold">Job No.</span>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row_JN['iJN'];?>&nbsp;</td>
        </tr>
        <tr>
          <td align="center" class="head_black_bold">SERVICE REQUEST FORM <br></td>
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
          <td align="right">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td><input name="cCAdd3" type="text" class="ipt_srf" id="cCAdd3"></td>
          <td align="right">Notify Exceeds: </td>
          <td>$
              <input name="fCChgLmt" type="text" class="ipt_srf" id="fCChgLmt" style="width:100px; ">
          </td>
        </tr>
        <tr>
          <td align="right"><span class="head_red_bold">*</span>Email:</td>
          <td><input name="cCEmail" type="text" class="ipt_srf" id="cCEmail"></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <table width="750" border="0" align="center" cellpadding="3" cellspacing="0" class="underline">
        <tr>
          <td colspan="4" class="head_black_bold">Faulty Unit Details
              <input name="cFUD3" type="hidden" id="cFUD32" value="checked">
              <input name="cFUD5" type="hidden" id="cFUD52" value="checked">
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
          <td><span class="head_red_bold">*</span>Series:</td>
          <td><input name="cIMEI" type="text" class="ipt_srf" id="cIMEI" maxlength="17">
              <input name="cFUDFax" type="hidden" class="ipt_srf" id="cFUDFax" value=""></td>
          <td align="right"><span class="head_red_bold">*</span>Serial:</td>
          <td><input name="cCFax" type="text" class="ipt_srf" id="cCFax"></td>
        </tr>
        <tr>
          <td>Accessories:</td>
          <td colspan="3"><input name="cA1" type="checkbox" id="cA1" value="checked">
      Power Apater &nbsp;&nbsp;
      <input name="cA2" type="checkbox" id="cA2" value="checked">
      Carry Bag &nbsp;&nbsp;
      <input name="cA3" type="checkbox" id="cA3" value="checked">
      Mouse&nbsp;&nbsp; Other:
      <input name="cAother" type="text" class="ipt_login" id="cAother">
          </td>
        </tr>
      </table>
      <table width="750" border="0" align="center" cellpadding="3" cellspacing="0" class="underline">
        <tr valign="top">
          <td colspan="5" class="head_black_bold">Fault Checklist </td>
        </tr>
        <tr valign="top">
          <td>&nbsp;</td>
          <td class="head_black_bold">BOOT</td>
          <td><input name="cFCU1" type="checkbox" id="cFCU12" value="checked">
      Can't boot into Windows</td>
          <td><input name="cFCU2" type="checkbox" id="cFCU22" value="checked">
      System reboot </td>
          <td><input name="cFCU3" type="checkbox" id="cFCU32" value="checked">
      Can't boot at all </td>
        </tr>
        <tr valign="top">
          <td>&nbsp;</td>
          <td class="head_black_bold">DISPLAY
              <input name="cFCG1" type="hidden" id="cFCG12" value="checked">
              <input name="cFCG5" type="hidden" id="cFCG52" value="checked">
              <input name="cFCG2" type="hidden" id="cFCG22" value="checked">
              <input name="cFCG4" type="hidden" id="cFCG42" value="checked">
              <input name="cFCG7" type="hidden" id="cFCG72" value="checked">
              <input name="cFCG9" type="hidden" id="cFCG92" value="checked"></td>
          <td><input name="cFCG3" type="checkbox" id="cFCG32" value="checked">
      Discoloration</td>
          <td><input name="cFCG6" type="checkbox" id="cFCG62" value="checked">
      Line on screen</td>
          <td><input name="cFCG8" type="checkbox" id="cFCG82" value="checked">
      No display at all </td>
        </tr>
        <tr valign="top">
          <td>&nbsp;</td>
          <td>&nbsp; </td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr valign="top">
          <td>&nbsp;</td>
          <td class="head_black_bold">SOUND
              <input name="cFCD3" type="hidden" id="cFCD32" value="checked"></td>
          <td><input name="cFCD1" type="checkbox" id="cFCD12" value="checked">
      Noise</td>
          <td><input name="cFCD2" type="checkbox" id="cFCD22" value="checked">
      No sound</td>
          <td>&nbsp;</td>
        </tr>
        <tr valign="top">
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr valign="top">
          <td valign="top">&nbsp;</td>
          <td rowspan="2" class="head_black_bold">INPUT</td>
          <td valign="top"><input name="cFCP3" type="checkbox" id="cFCP32" value="checked">
      Keyboard not working </td>
          <td valign="top"><input name="cFCP4" type="checkbox" id="cFCP42" value="checked">
      Touchpad not working </td>
          <td valign="top"><input name="cFCP2" type="checkbox" id="cFCP22" value="checked">
      Mouse not working </td>
        </tr>
        <tr valign="top">
          <td valign="top">&nbsp;</td>
          <td valign="top"><input name="cFCP1" type="checkbox" id="cFCP1" value="checked">
      Trackpoint not working </td>
          <td valign="top">&nbsp;</td>
          <td valign="top">&nbsp;</td>
        </tr>
        <tr valign="top">
          <td>&nbsp;</td>
          <td colspan="4" class="head_black_bold">&nbsp;</td>
        </tr>
        <tr valign="top">
          <td>&nbsp;</td>
          <td><span class="head_black_bold">POTRS</span></td>
          <td><input name="cFCM1" type="checkbox" id="cFCM1" value="checked">
      USB port not working </td>
          <td><input name="cFCM4" type="checkbox" id="cFCM4" value="checked">
      PCMCIA slot not working </td>
          <td><input name="cFCM2" type="checkbox" id="cFCM2" value="checked">
      Card reader not working </td>
        </tr>
        <tr valign="top">
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><input name="cFCM5" type="checkbox" id="cFCM5" value="checked">
      LAN port not working </td>
          <td><input name="cFCM8" type="checkbox" id="cFCM8" value="checked">
      Modem port not working </td>
          <td><input name="cFCM6" type="checkbox" id="cFCM6" value="checked">
      Audio port not working </td>
        </tr>
        <tr valign="top">
          <td width="8">&nbsp;</td>
          <td width="179" class="head_black_bold">&nbsp;</td>
          <td width="181"><input name="cFCM3" type="checkbox" id="cFCM32" value="checked">
      Microphone port not working </td>
          <td width="185"><input name="cFCM7" type="checkbox" id="cFCM72" value="checked">
      Headphone port not working</td>
          <td width="167"><input name="cFCS3" type="checkbox" id="cFCS32" value="checked">
      1394 port not working </td>
        </tr>
        <tr valign="top">
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr valign="top">
          <td>&nbsp;</td>
          <td><span class="head_black_bold">POWER
                <input name="cFCS6" type="hidden" id="cFCS62" value="checked">
                <input name="cFCS7" type="hidden" id="cFCS72" value="checked">
                <input name="cFCS8" type="hidden" id="cFCS82" value="checked">
          </span></td>
          <td><input name="cFCS1" type="checkbox" id="cFCS1" value="checked">
      Can't turn on </td>
          <td><input name="cFCS4" type="checkbox" id="cFCS4" value="checked">
      Can't charge battery </td>
          <td><input name="cFCS2" type="checkbox" id="cFCS2" value="checked">
      Power adaptor pin broken </td>
        </tr>
        <tr valign="top">
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp; </td>
          <td>&nbsp; </td>
          <td>&nbsp;</td>
        </tr>
        <tr valign="top">
          <td>&nbsp;</td>
          <td><span class="head_black_bold">OTHERS</span></td>
          <td><input name="cFCS5" type="checkbox" id="cFCS52" value="checked">
      Physical damage </td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr valign="top">
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td colspan="3"><textarea name="cFCDesc" rows="2" wrap="VIRTUAL" id="textarea" style="width:100%; "></textarea></td>
        </tr>
      </table>
      <table width="750" border="0" align="center" cellpadding="3" cellspacing="0">
        <tr>
          <td>
            <input name="cSbmBy" type="hidden" class="ipt_srf" id="cSbmBy" value="Web Customer">
			<input name="cStfName" type="hidden" class="ipt_srf" id="cStfName" value="">
			<input name="iSbmType" type="hidden" id="iSbmType" value="2">
            <input name="cStatus" type="hidden" id="cStatus" value="S05">
			<input name="cSbm" type="hidden" class="ipt_srf" id="cSbm" value="Web Customer">
            <input name="cLocation" type="hidden" id="cLocation" value="L00">
            <input type="hidden" name="MM_insert" value="form1">
            <input name="cLMake" type="hidden" class="ipt_srf" id="cLMake">
            <input name="cLModel" type="hidden" class="ipt_srf" id="cLModel">
            <input name="cLDeposit" type="hidden" class="ipt_srf" id="cLDeposit">
            <input name="cLIMEI" type="hidden" class="ipt_srf" id="cLIMEI" maxlength="17">
            <input name="cLB" type="hidden" id="cLB" value="checked">
            <input name="cLC" type="hidden" id="cLC" value="checked">
            <input name="cLother" type="hidden" class="ipt_srf" id="cLother">
            <input name="cIIFP" type="hidden" id="cIIFP" value="checkbox">
            <a href="termncond.php" target="_blank">Terms &amp; Conditions &gt;&gt; </a></td>
        </tr>
        <tr>
          <td align="center"><input name="Submit" type="submit" value="Submit"></td>
        </tr>
      </table>
      </form>
    <!-- InstanceEndEditable --></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($JN);
?>
