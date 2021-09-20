<?php require_once('../Connections/localhost.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "admin";
$MM_authorizedGroups = "tbtech,tbopr";
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "assign")) {
  $updateSQL = sprintf("UPDATE tbrepair SET cAssign=%s, cStatus='S10', cLocation='L05', dtECDate=NOW() WHERE iID=%s",
                       GetSQLValueString($_POST['cAssign'], "text"),
                       GetSQLValueString($_POST['iID'], "int"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());
  
  //insert Job Log  
  mysql_select_db($database_localhost, $localhost);
  $logperson = $_SESSION['RP_WHOAMI'];
  $logcontent = "Job assigned to " . $_POST['cAssign'];
  $sql_log = sprintf("insert tblog (cJN, dtDate, cPerson, cContent) values (%s, %s, %s, %s)",
  					$_POST['cJN'],
					"NOW()",
                    GetSQLValueString($logperson, "text"),
                    GetSQLValueString($logcontent, "text"));
  $Result1 = mysql_query($sql_log, $localhost) or die(mysql_error());

}

$colname_rs = "1";
if (isset($_GET['cJN'])) {
  $colname_rs = (get_magic_quotes_gpc()) ? $_GET['cJN'] : addslashes($_GET['cJN']);
}
mysql_select_db($database_localhost, $localhost);
$dt_fm = "%d %b %Y";
$query_rs = sprintf("SELECT *,DATE_FORMAT(dtSDate,'%s') as dtSDate2 FROM tbrepair WHERE cJN = '%s'",$dt_fm, $colname_rs);
$rs = mysql_query($query_rs, $localhost) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);
$totalRows_rs = mysql_num_rows($rs);

mysql_select_db($database_localhost, $localhost);
$query_tech = "select * from tbopr where role='tech' and cStatus='normal'";
$rs_tech = mysql_query($query_tech, $localhost) or die(mysql_error());
$row_tech = mysql_fetch_assoc($rs_tech);
$totalRows_tech = mysql_num_rows($rs_tech);
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
    <td  valign="top">	<!-- InstanceBeginEditable name="main" -->
<table width="100%"  border="0" align="center" cellpadding="5" cellspacing="10">
  <tr>
      <td><?php include('myfunction.php');?>
  Go To: <a href="srf.php?cJN=<?php echo $row_rs['cJN']; ?>">Service Request Form</a> | <a href="rtp.php?cJN=<?php echo $row_rs['cJN']; ?>">Service Tracking Pages</a> | <a href="#"  onClick="MM_openBrWindow('memo_4j.php?cJN=<?php echo $row_rs['cJN'];?>','Memo','status=yes,scrollbars=yes,resizable=yes,width=640,height=480')">Job Memo</a>
	  <?php
	if($row_rs['cStatus']=='25' || $row_rs['cStatus']=='S30'){
	?>
	  | <a href="sri.php?cJN=<?php echo $row_rs['cJN']; ?>" target="_blank">Service Report/Invoice</a>
	  <?php }?>  | <a href="log.php?cJN=<?php echo $row_rs['cJN']; ?>">Job Logs</a></td>
      </tr>
</table>
<table width="750" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF" class="underline">
  <tr>
    <td align="right">Status:</td>
    <td align="left" class="Mgr_Heading"><?php echo getStatus($row_rs['cStatus']); ?>
	<?php
	if($_SESSION['RP_Username']=="admin" || ($row_rs['cStatus']=='S05' && $_SESSION['RP_UserGroup']!="tbopr")){
	?>
	<script language="javascript">
	<!--
	function req_del(id,jn){
	if(cfm()){
		MM_goToURL('window','req_del.php?ID=' + id + '&cJN=' + jn);
		//alert('yes ticked.');
		return true;
	}
	return false;	}
	//-->
	</script>
    <input name="button" type="button" class="btn" onClick="javascript:req_del(<?php echo $row_rs['iID'];?>,<?php echo $row_rs['cJN'];?>);" value="Cancel this request">	
    <?php
	}
	?>	
	<?php
	//if($_SESSION['RP_Username']=="admin"){
	?>
    <input name="button" type="button" class="btn" onClick="javascript:MM_goToURL('window','req_edit.php?cJN=<?php echo $row_rs['cJN'];?>');" value="Edit the Request">
    <?php // }?></td>
  </tr>
  <tr>
    <td width="99" align="right">Location:</td>
  <td width="688" align="left"><?php echo getLocation($row_rs['cLocation']); ?>&nbsp;</td>
  </tr>

  <tr><form action="<?php echo $editFormAction; ?>" method="POST" name="assign" id="assign">
    <td align="right">Assign To: </td>
    <td align="left"><?php
if($row_rs['cStatus']=="S05" && $_SESSION['RP_UserGroup']=="tbtech"){
?>
          <input name="Assign" type="submit" class="btn" value="Get this job!">          
          <input type="hidden" name="MM_update" value="assign">
          <input name="cJN" type="hidden" id="cJN" value="<?php echo $row_rs['cJN']; ?>">
          <input name="iID" type="hidden" id="iID" value="<?php echo $row_rs['iID']; ?>">
          <input name="cAssign" type="hidden" id="cAssign" value="<?php echo $_SESSION['RP_Username'];?>">
<?php
}else if($row_rs['cStatus']=="S05" && $_SESSION['RP_UserGroup']=="tbopr"){
?>
                    
          <input type="hidden" name="MM_update" value="assign">
          <input name="cJN" type="hidden" id="cJN" value="<?php echo $row_rs['cJN']; ?>">
          <input name="iID" type="hidden" id="iID" value="<?php echo $row_rs['iID']; ?>">
		  <select name="cAssign" id="cAssign">
		  	<?php 
			do{
			?>
			<option value="<?php echo $row_tech["cLogin"];?>"><?php echo $row_tech["cLogin"];?></option>
			<?php 
			}while($row_tech = mysql_fetch_assoc($rs_tech));
			?>
		  </select> <input name="Assign" type="submit" class="btn" value="Assign">
<?php
	mysql_free_result($rs_tech);
}else{
?>
<?php echo $row_rs['cAssign']; ?>
<?php
}
?></td>
    </form>
  </tr>
  <tr>
    <td colspan="2" align="right">Job No.&nbsp;&nbsp;&nbsp;&nbsp;<span class="Mgr_Heading"><?php echo $row_rs['cJN']; ?></span><br>
        <span class="Mgr_Heading"><?php echo $row_rs['dtSDate2']; ?></span></td>
  </tr>
  <tr>
    <td colspan="2" align="center" class="Mgr_Heading">SERVICE REQUEST FORM <br></td>
  </tr>
</table>
<table width="750" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF" class="underline">
  <tr>
    <td colspan="4" class="Mgr_Heading">Job Details </td>
  </tr>
  <tr>
    <td width="91" align="right">Submitted By:</td>
    <td width="254">&nbsp;<span class="Mgr_Heading"><?php echo $row_rs['cSbmBy']; ?></span>
    </td>
    <td width="129" align="right">Staff Name:</td>
    <td width="252" class="Mgr_Heading"><?php echo $row_rs['cStfName']; ?></td>
  </tr>
</table>
<table width="750" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF" class="underline">
  <tr>
    <td colspan="4" class="Mgr_Heading">Customer Details </td>
  </tr>
  <tr>
    <td width="71" align="right"><span class="head_red_bold">*</span>Name:</td>
    <td width="272" class="Mgr_Heading"><?php echo $row_rs['cCName']; ?> <?php echo $row_rs['cCLastName']; ?></td>
    <td width="98" align="right"><span class="head_red_bold">*</span>Home Ph:</td>
    <td width="285" class="Mgr_Heading"><?php echo $row_rs['cCHomePhn']; ?></td>
  </tr>
  <tr>
    <td align="right"><span class="head_red_bold">*</span>Address:</td>
    <td class="Mgr_Heading"><?php echo $row_rs['cCAdd1']; ?></td>
    <td align="right">Work Ph: </td>
    <td class="Mgr_Heading"><?php echo $row_rs['cCWorkPhn']; ?></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td class="Mgr_Heading"><?php echo $row_rs['cCAdd2']; ?></td>
    <td align="right">Mobile:</td>
    <td class="Mgr_Heading"><?php echo $row_rs['cCFax']; ?></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td class="Mgr_Heading"><?php echo $row_rs['cCAdd3']; ?></td>
    <td align="right">Notify Exceeds: </td>
    <td class="Mgr_Heading"><?php echo $row_rs['fCChgLmt']; ?></td>
  </tr>
  <tr>
    <td align="right"><span class="head_red_bold">*</span>Email:</td>
    <td class="Mgr_Heading"><?php echo $row_rs['cCEmail']; ?></td>
    <td>&nbsp;</td>
    <td><?php if($row_rs['cAgentName']!=null) echo "Agent: ".$row_rs['cAgentName'];?>&nbsp;</td>
  </tr>
</table>
<table width="750" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF" class="underline">
  <tr>
    <td colspan="6" class="Mgr_Heading">Faulty Unit Details 
      <input name="cFUD3" type="hidden" id="cFUD32" value="checked"  <?php echo $row_rs['cFUD3']; ?>>
      <input name="cFUD5" type="hidden" id="cFUD52" value="checked"  <?php echo $row_rs['cFUD5']; ?>>
      <input name="cFUD1" type="hidden" id="cFUD12" value="checked">
      <input name="cFUD2" type="hidden" id="cFUD22" value="checked">
      <input name="cFUD4" type="hidden" id="cFUD42" value="checked"></td>
  </tr>
  <tr>
    <td width="69"><span class="head_red_bold">*</span>Make:</td>
    <td width="147" class="Mgr_Heading"><?php echo $row_rs['cMake']; ?></td>
    <td width="84" align="right"><span class="head_red_bold">*</span>Model:</td>
    <td width="200" class="Mgr_Heading"><?php echo $row_rs['cModel']; ?></td>
    <td width="76" class="Mgr_Heading">&nbsp;</td>
    <td width="138" class="Mgr_Heading">&nbsp;</td>
  </tr>
  <tr>
    <td><span class="head_red_bold">*</span>IMEI/ESN:</td>
    <td class="Mgr_Heading"><?php echo $row_rs['cIMEI']; ?></td>
    <td align="right">Security Code:</td>
    <td class="Mgr_Heading"><?php echo $row_rs['cFUDFax']; ?></td>
    <td align="right">Claim No. </td>
    <td class="Mgr_Heading"><?php echo $row_rs['cClaim']; ?></td>
  </tr>
  <tr>
    <td>Accessories:</td>
    <td colspan="5"><input name="cA1" type="checkbox" id="cA1" value="checked"  <?php echo $row_rs['cA1']; ?> disabled>
      Battery&nbsp;&nbsp;
      <input name="cA2" type="checkbox" id="cA2" value="checked"  <?php echo $row_rs['cA2']; ?> disabled>
      Charger
      <input name="cA3" type="checkbox" id="cA3" value="checked"  <?php echo $row_rs['cA3']; ?> disabled> 
      SIM Card   
&nbsp;&nbsp;
<input name="cA5" type="checkbox" id="cA5" value="checked"  <?php echo $row_rs['cFUD3']; ?> disabled>
MEMORY CARDOther:
      <span class="Mgr_Heading"><?php echo $row_rs['cAother']; ?></span>      </td>
  </tr>
</table>
<table width="750" border="0" align="center" cellpadding="3" cellspacing="0" class="underline">
  <tr valign="top">
    <td colspan="5" class="Mgr_Heading">Fault Details</td>
  </tr>
  <tr valign="top">
    <td>&nbsp;</td>
    <td class="Mgr_Heading">Timing of Fault
        </td>
    <td><input name="cFCU1" type="checkbox" id="cFCU1" value="checked" <?php echo $row_rs['cFCU1']; ?> disabled>
      Continuous </td>
    <td><input name="cFCU2" type="checkbox" id="cFCU2" value="checked" <?php echo $row_rs['cFCU2']; ?> disabled>
      Intermittent </td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top">
    <td>&nbsp;</td>
    <td><span class="Mgr_Heading">Type of Fault
          </span></td>
    <td><input name="cFCM1" type="checkbox" id="cFCM1" value="checked" <?php echo $row_rs['cFCM1']; ?> disabled>
      Power Problem </td>
    <td><input name="cFCM4" type="checkbox" id="cFCM4" value="checked" <?php echo $row_rs['cFCM4']; ?> disabled>
      Ring Problem </td>
    <td><input name="cFCM2" type="checkbox" id="cFCM2" value="checked" <?php echo $row_rs['cFCM2']; ?> disabled>
      Earpiece Problem </td>
  </tr>
  <tr valign="top">
    <td>&nbsp;</td>
    <td><span class="Mgr_Heading">
      </span></td>
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
<table width="750" border="0" align="center" cellpadding="3" cellspacing="0" class="underline">
  <tr>
    <td colspan="4" class="Mgr_Heading">Loan Equipment (if applicable) </td>
  </tr>
  <tr>
    <td width="96" align="right">Handset Make: </td>
    <td width="225"><?php echo $row_rs['cLMake']; ?></td><td width="124" align="right">Handset Model:</td>
      <td width="281"><?php echo $row_rs['cLModel']; ?></td></tr>
  <tr>
    <td align="right">Deposit taken: </td>
    <td><?php echo $row_rs['cLDeposit']; ?></td><td align="right">IMEI</td>
      <td><?php echo $row_rs['cLIMEI']; ?></td></tr>
  <tr>
    <td><input name="cLB" type="checkbox" id="cLB" value="checked" <?php echo $row_rs['cLB']; ?> disabled>
      Battery</td>
    <td><input name="cLC" type="checkbox" id="cLC" value="checked" <?php echo $row_rs['cLC']; ?> disabled>
      Charger</td>
    <td align="right">Other:</td>
    <td><?php echo $row_rs['cLother']; ?></td></tr>
</table>
<table width="750" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td bgcolor="#FFFFFF">
		<?php 
		if($row_rs['cFCS5']==""){
		?>Inspection paid       <input name="cIIFP" type="checkbox" id="cIIFP" value="checkbox" <?php echo ($row_rs['cIIFP']!="")?"checked":""?> disabled>
		<?php
		}else{
		?>&nbsp;Inspection Fee $45.0
      		<input name="cFCS5" type="checkbox" id="cFCS5" value="checked" <?php echo ($row_rs['cFCS5']!="")?"checked":""?> disabled="disabled">
		<?php
		}
		?></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF"></td>
  </tr>
</table>
<p>&nbsp;</p>
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
