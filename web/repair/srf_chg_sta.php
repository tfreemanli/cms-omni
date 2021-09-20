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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "chg_sta")) {
  //if the status is set to S15/S20, then write into the database
  if($_POST['cStatus']=="S10" || $_POST['cStatus']=="S15" || $_POST['cStatus']=="S20"){
	  $updateSQL = sprintf("UPDATE tbrepair SET dtECDate='%s-%s-%s', cStatus=%s, cLocation='L05', cRemark=%s WHERE iID=%s",
						   $_POST['year'],
						   $_POST['month'],
						   $_POST['date'],
						   GetSQLValueString($_POST['cStatus'], "text"),
						   GetSQLValueString($_POST['cRemark'], "text"),
						   GetSQLValueString($_POST['iID2'], "int"));
	
	  mysql_select_db($database_localhost, $localhost);
	  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());
  
  //insert Job Log  
  mysql_select_db($database_localhost, $localhost);
  $logperson = $_SESSION['RP_WHOAMI'];
  $logcontent = "Job Status changed. ECD=".$_POST['date']."-".$_POST['month']."-".$_POST['year'].", Status=".$_POST['cStatus'];
  $sql_log = sprintf("insert tblog (cJN, dtDate, cPerson, cContent) values (%s, %s, %s, %s)",
  					$_POST['cJN'],
					"NOW()",
                    GetSQLValueString($logperson, "text"),
                    GetSQLValueString($logcontent, "text"));
  $Result1 = mysql_query($sql_log, $localhost) or die(mysql_error());

	  
	  $insertGoTo = "rtp.php?cJN=".$_POST['cJN'];
	  //$insertGoTo = "req_list_all.php";
	  header(sprintf("Location: %s", $insertGoTo));
	  
  }else if($_POST['cStatus']=="S25" || $_POST['cStatus']=="S30" || $_POST['cStatus']=="S35"){
  	//if the status is set to S25/S30, then more info is to be collected in this page
	$colname_rs = "1";
	if (isset($_POST['cJN'])) {
	  $colname_rs = (get_magic_quotes_gpc()) ? $_POST['cJN'] : addslashes($_POST['cJN']);
	}
	mysql_select_db($database_localhost, $localhost);
	$query_rs = sprintf("SELECT * FROM tbrepair WHERE cJN = '%s'", $colname_rs);
	$rs = mysql_query($query_rs, $localhost) or die(mysql_error());
	$row_rs = mysql_fetch_assoc($rs);
	$totalRows_rs = mysql_num_rows($rs);
  }
}

mysql_select_db($database_localhost, $localhost);
$query_rs_crr = "SELECT * FROM tbcourier ORDER BY name ASC";
$rs_crr = mysql_query($query_rs_crr, $localhost) or die(mysql_error());
$row_rs_crr = mysql_fetch_assoc($rs_crr);
$totalRows_rs_crr = mysql_num_rows($rs_crr);
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
<style type="text/css">
<!--
.style1 {
	font-size: 16px;
	font-weight: bold;
	color: #D11838;
}
-->
</style>
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

function clkY(){
	var obj = MM_findObj('cStsOnReport');
	obj.value="Phone is working";
}
function clkN(){
	var obj = MM_findObj('cStsOnReport');
	obj.value="Phone is not working";
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
<?php include('myfunction.php');?>
<table width="95%"  border="0" align="center" cellpadding="1" cellspacing="5" bgcolor="#FFFFFF">
  <tr valign="top">
    <td width="60%" bgcolor="#CCCCCC">	<table width="100%"  border="0" cellpadding="5" cellspacing="0" bgcolor="#FFFFFF">
      <form name="form1" method="post" action="srf_chg_loc.php">
	  <tr>
	    <td colspan="2">&nbsp;</td>
	    </tr>
	  <tr>
        <td colspan="2"><div align="center">You are setting the repair status to:<br>          
              <br>
              <span class="style1"><?php echo getStatus($_POST['cStatus']);?>&nbsp;</span><br> 
              <br>
            so pls fill in the following info </div></td>
        </tr>
      <tr valign="top">
        <td align="right">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr valign="top">
        <td width="24%" align="right">*Location:</td>
        <td width="76%">
          <select name="cLocation" id="cLocation"  onChange="show();">
            <option value="L10" selected>Has been sent to dealer(L10)</option>
            <option value="L15">Ready to be picked up from Repair Center(L15)</option>
            <option value="L20">Has been picked up/delivered(L20)</option>
            <option value="L25">Keep in lieu of payment(L25)</option>
            <option value="L30">Other (L30)</option>
          </select></td>
      </tr>
      <tr valign="top" id="LyrCrr">
        <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr valign="top">
        <td width="23%" align="right">Courier:</td>
        <td width="77%"><select name="iCrrID" id="iCrrID">
		<option value="">&nbsp;</option>
          <?php
do {  
?>
          <option value="<?php echo $row_rs_crr['id']?>"><?php echo $row_rs_crr['name']?></option>
          <?php
} while ($row_rs_crr = mysql_fetch_assoc($rs_crr));
  $rows = mysql_num_rows($rs_crr);
  if($rows > 0) {
      mysql_data_seek($rs_crr, 0);
	  $row_rs_crr = mysql_fetch_assoc($rs_crr);
  }
?>
        </select></td>
      </tr>
      <tr valign="top">
        <td align="right">Tracking Num: </td>
        <td><input name="cCrrTrk" type="text" id="cCrrTrk"></td>
      </tr>
        </table></td>
        </tr>
      <tr valign="top">
        <td align="right">*Completion Date: </td>
        <td><select name="date" id="date">
        <?php for($i=1;$i<=31;$i++){?>
			<option value="<?php echo $i;?>"><?php echo $i;?></option>
		<?php }?>
      </select>
      <select name="month" id="month">
        <?php for($i=1;$i<=12;$i++){?>
			<option value="<?php echo $i;?>"><?php echo $i;?></option>
		<?php }?>
      </select>
      <select name="year" id="year">
        <?php for($i=2006;$i<=2016;$i++){?>
			<option value="<?php echo $i;?>"><?php echo $i;?></option>
		<?php }?>
      </select></td>
      </tr>
      <tr valign="top">
        <td align="right">*Service Charge: </td>
        <td><p>$
              <input name="cSrvChg" type="text" id="cSrvChg" value="<?php echo $row_rs['cSrvChg']; ?>" style="width: 100px;">
          </p>
          <p>    
                <input name="cIIFP" type="checkbox" id="cIIFP" value="checkbox" <?php echo ($row_rs['cIIFP']!="")?"checked":""?>>
              inc insp fee paid 
			  <input name="cFCS5" type="checkbox" id="cFCS5" value="checkbox" <?php echo ($row_rs['cFCS5']!="")?"checked":""?>>
              insp fee $45.0 paid <br>
              <input name="cIsWrty" type="checkbox" id="cIsWrty" value="checkbox" >
              Warranty
              <input name="cIsCmmisn" type="checkbox" id="cIsCmmisn" value="checkbox" >
              Commission</p></td>
      </tr>
      <tr valign="top">
        <td align="right">Phone Status (Service Report)</td>
        <td><input name="cStsOnReport" type="text" id="cStsOnReport" value="<?php echo $row_rs['cStsOnReport']; ?>">
          <input type="button" name="Submit2" value="Y" onClick="javascript:clkY();">
          <input type="button" name="Submit3" value="N" onClick="javascript:clkN();"></td>
      </tr>
      <tr valign="top">
        <td align="right">Job Info (Service Report): </td>
        <td><textarea name="cSrvReport" cols="30" rows="7" wrap="VIRTUAL" id="cSrvReport"></textarea></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input name="Submit" type="submit" onClick="MM_validateForm('cSrvChg','','R');return document.MM_returnValue" value="submit">
          <input name="cJN" type="hidden" id="cJN" value="<?php echo $row_rs['cJN']; ?>">
		  <input name="iID" type="hidden" id="iID" value="<?php echo $row_rs['iID']; ?>">
		  <input name="cStatus" type="hidden" id="cStatus" value="<?php echo $_POST['cStatus'];?>">
		  <input type="hidden" name="MM_update" value="chg_loc">
		  <input name="cRemark" type="hidden" id="cRemark" value="<?php echo $_POST['cRemark'];?>"></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
	  </form>
    </table>
		<?php
			$d = $row_rs['dtCDate'];
			if($d!="" && $d!="1970-01-01"){
				$ad = getdate($d);
				$str = substr($d,0,4).",".substr($d,5,2).",".substr($d,8,2);
			}else{
				$str="";
			}
			//echo "str=".$str.";d=".$d;
		?>
      <script language="javascript">
	  	<!--//
		var dt = new Date(<?php echo $str;?>);
		//dt = "";
		var date = MM_findObj("date");
		var month = MM_findObj("month");
		var year = MM_findObj("year");
		var crr = MM_findObj("LyrCrr");
		var objLocLst = MM_findObj('cLocation');
		
		date.value = dt.getDate(dt);
		month.value = 1+dt.getMonth(dt);
		year.value = dt.getYear(dt);
		
		objLocLst.value = "<?php echo $row_rs['cLocation']; ?>";
		//-->
	  </script></td>
    <td width="40%"><table width="95%"  border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td colspan="2" align="right">&nbsp;</td>
        </tr>
      <tr>
        <td width="35%" align="right">Job No.:</td>
        <td width="65%"><?php echo $row_rs['cJN']; ?></td>
      </tr>
      <tr>
        <td align="right">Make:</td>
        <td><?php echo $row_rs['cMake']; ?></td>
      </tr>
      <tr>
        <td align="right">Model:</td>
        <td><?php echo $row_rs['cModel']; ?></td>
      </tr>
      <tr>
        <td align="right">Cur Status:</td>
        <td><?php echo getStatus($row_rs['cStatus']); ?></td>
      </tr>
      <tr>
        <td align="right">Cur Location: </td>
        <td><?php echo getLocation($row_rs['cLocation']); ?></td>
      </tr>
      <tr>
        <td align="right">Est Complete: </td>
        <td><?php echo $row_rs['dtECDate']; ?></td>
      </tr>
    </table></td>
  </tr>
</table>
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

mysql_free_result($rs_crr);
?>
