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

//update the location of those have been left for 50 days
$updateSQL = "update tbrepair set cLocation='L25' where dtCDate is not null and cLocation='L15' and (TO_DAYS(now()) - TO_DAYS(dtCDate))>50";
mysql_select_db($database_localhost, $localhost);
$Result1 = mysql_query($updateSQL, $localhost);

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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "addremark")) {
  $insertSQL = sprintf("INSERT INTO tbmemo (cJN, cAuthType, cAuth, cAuthContact, dtDate, cTitle, cContent) VALUES (%s, %s, %s, %s, %s, 'remark', %s)",
                       GetSQLValueString($_POST['cJN'], "text"),
                       GetSQLValueString($_POST['cAuthType'], "text"),
                       GetSQLValueString($_POST['cAuth'], "text"),
                       GetSQLValueString($_POST['cAuthContact'], "text"),
                       "NOW()",
                       GetSQLValueString($_POST['cContent'], "text"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($insertSQL, $localhost) or die(mysql_error());
}

$colname_rs = "1";
if (isset($_GET['cJN'])) {
  $colname_rs = (get_magic_quotes_gpc()) ? $_GET['cJN'] : addslashes($_GET['cJN']);
}
mysql_select_db($database_localhost, $localhost);
$dt_fm = "%d %b %Y";
$query_rs = sprintf("SELECT *,DATE_FORMAT(dtECDate,'%s') as dtECDate2, (TO_DAYS(now()) - TO_DAYS(dtCDate)) as iDayLmt FROM tbrepair WHERE cJN = '%s'", $dt_fm, $colname_rs);
$rs = mysql_query($query_rs, $localhost) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);
$totalRows_rs = mysql_num_rows($rs);


mysql_select_db($database_localhost, $localhost);
$query_rs = "select *, DATE_FORMAT(dtDate,'%d %b %Y  %p %h:%i') AS dtSDate  from tbmemo where cAuthType='remark' and cJN='". $colname_rs ."' order by iID";
$rm = mysql_query($query_rs, $localhost) or die(mysql_error());
$totalRows_rm = mysql_num_rows($rm);

mysql_select_db($database_localhost, $localhost);
$query_typein = "select * from tbtypeinperson";
$rs_typein = mysql_query($query_typein, $localhost) or die(mysql_error());
$row_typein = mysql_fetch_assoc($rs_typein);
$totalRows_typein = mysql_num_rows($rs_typein);


mysql_select_db($database_localhost, $localhost);
$query_product = "select stock_stockout.*, stock_product.name, stock_product.model, stock_product.branch from stock_stockout inner join stock_product on stock_stockout.product_id=stock_product.id where stock_stockout.job_num='". $colname_rs ."' order by stock_stockout.id";
$rs_product = mysql_query($query_product, $localhost) or die(mysql_error());
$row_product = mysql_fetch_assoc($rs_product);
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
<?php }?> | <a href="log.php?cJN=<?php echo $row_rs['cJN']; ?>">Job Logs</a></td>
  </tr>
</table>
<?php
  if($row_rs['cStatus']=='S05' || $row_rs['cStatus']==''){
  //if status is "waiting to assign"
  ?>
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td colspan="2" align="center" class="Mgr_Heading">Repair Tracking Pages<br>&nbsp;</td>
  </tr>
  <tr>
    <td width="189" align="right">Job No.&nbsp;</td>
    <td width="607" align="left"><span class="Mgr_Heading"><?php echo $row_rs['cJN']; ?></span></td>
  </tr>
  <tr>
    <td align="right">Make:</td>
    <td align="left"><?php echo $row_rs['cMake']; ?></td>
  </tr>
  <tr>
    <td align="right">Model:</td>
    <td align="left"><?php echo $row_rs['cModel']; ?></td>
  </tr>
  <tr>
    <td align="right">IMEI:</td>
    <td align="left"><?php echo $row_rs['cIMEI']; ?></td>
  </tr>
  <tr>
    <td align="right">Repair Status:</td>
    <td align="left"><?php echo getStatus($row_rs['cStatus']); ?></td>
  </tr>
  <tr>
    <td align="right"> Current Location:</td>
    <td align="left"><?php echo getLocation($row_rs['cLocation']); ?></td>
  </tr>
  <tr>
    <td align="right">Estimate completion date :</td>
    <td align="left">&nbsp;</td>
  </tr>
<?php
if($row_rs['cStatus']=="S05" && $_SESSION['RP_UserGroup']=="tbtech"){
?>
  <tr>
  <td width="189" align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="607" align="left" bgcolor="#FFFFFF"><form action="<?php echo $editFormAction; ?>" method="POST" name="assign" id="assign">
          <input name="Assign" type="submit" value="Get this job!">          
          <input type="hidden" name="MM_update" value="assign">          
          <input name="cAssign" type="hidden" id="cAssign" value="<?php echo $_SESSION['RP_Username'];?>">
          <input name="cJN" type="hidden" id="cJN" value="<?php echo $row_rs['cJN']; ?>">
          <input name="iID" type="hidden" id="iID" value="<?php echo $row_rs['iID']; ?>">
    </form></td>
  </tr>
<?php
}else if($row_rs['cStatus']=="S05" && $_SESSION['RP_UserGroup']=="tbopr"){
	mysql_select_db($database_localhost, $localhost);
	$query_tech = "select * from tbopr where role='tech'";
	$rs_tech = mysql_query($query_tech, $localhost) or die(mysql_error());
	$row_tech = mysql_fetch_assoc($rs_tech);
	$totalRows_tech = mysql_num_rows($rs_tech);
?>
  <tr>
  <td width="189" align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="607" align="left" bgcolor="#FFFFFF"><form action="<?php echo $editFormAction; ?>" method="POST" name="assign" id="assign">         
          <input type="hidden" name="MM_update" value="assign"> 
          <input name="cJN" type="hidden" id="cJN" value="<?php echo $row_rs['cJN']; ?>">         
          <input name="iID" type="hidden" id="iID" value="<?php echo $row_rs['iID']; ?>"><select name="cAssign" id="cAssign">
		  	<?php 
			do{
			?>
			<option value="<?php echo $row_tech["cLogin"];?>"><?php echo $row_tech["cLogin"];?></option>
			<?php 
			}while($row_tech = mysql_fetch_assoc($rs_tech));
			?>
		  </select> <input name="Assign" type="submit" class="btn" value="Assign">
    </form></td>
  </tr>
<?php
	mysql_free_result($rs_tech);
}
?>
  <tr>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="left" bgcolor="#FFFFFF">
<?php
if($_SESSION['RP_Username']=="admin" || $_SESSION['RP_UserGroup']!="tbopr"){
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
	<input type="button" value="Cancel this request" onClick="javascript:req_del(<?php echo $row_rs['iID'];?>, <?php echo $row_rs['cJN'];?>);">
	<?php
	}
	?>&nbsp;	</td>
  </tr>
</table>
  <?php
  }//end if status is "waiting to assign"
  ?>
  <?php
  //if status is "Inspection", "Wait 4 parts" or "Waint confirm"
  if($row_rs['cStatus']=="S10" || $row_rs['cStatus']=="S15" || $row_rs['cStatus']=="S20"){
  ?>
<form action="srf_chg_sta.php" method="post" name="fmEditStatus" id="fmEditStatus">
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td colspan="2" align="center" class="Mgr_Heading">Repair Tracking Pages<br>&nbsp;</td>
  </tr>
  <tr>
    <td width="189" align="right">Job No.&nbsp;</td>
    <td width="615" align="left"><span class="Mgr_Heading"><?php echo $row_rs['cJN']; ?></span></td>
  </tr>
  <tr>
    <td align="right">Make:</td>
    <td align="left"><?php echo $row_rs['cMake']; ?></td>
  </tr>
  <tr>
    <td align="right">Model:</td>
    <td align="left"><?php echo $row_rs['cModel']; ?></td>
  </tr>
  <tr>
    <td align="right">IMEI:</td>
    <td align="left"><?php echo $row_rs['cIMEI']; ?></td>
  </tr>
  <tr>
    <td align="right">Repair Status:</td>
    <td align="left"><select name="cStatus" id="cStatus">
            <option value="S10">Inspection(S10)</option>
            <option value="S15">Waiting for parts(S15)</option>
            <option value="S20">Waiting to be confirm by customer(S20)</option>
            <option value="S25">Unserviceable(S25)</option>
            <option value="S30">Repaired(S30)</option>
            <option value="S35">Other(S35)</option>
          </select>
		  <script language="javascript">
		  <!--
		  var objStaLst = MM_findObj('cStatus');
		  objStaLst.value = "<?php echo $row_rs['cStatus']; ?>";
		  //-->
		  </script></td>
  </tr>
  <tr>
    <td width="189" align="right">       Current Location:</td>
  <td width="615" align="left"><?php echo getLocation($row_rs['cLocation']); ?>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Estimate completion date :</td>
    <td align="left">      <select name="date" id="date">
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
<?php

if($_SESSION['RP_UserGroup']=="tbopr" || ($row_rs['cAssign']== $_SESSION['RP_Username'] && $_SESSION['RP_UserGroup']=="tbtech")){
?>
  <tr>
    <td align="right">&nbsp;</td>
    <td align="left"><input type="submit" name="Submit" value="Submit">
      <input name="iID2" type="hidden" id="iID2" value="<?php echo $row_rs['iID']; ?>">
      <input name="cJN" type="hidden" id="cJN" value="<?php echo $row_rs['cJN']; ?>">
      <input type="hidden" name="MM_update" value="chg_sta">
      <input name="cMemo" type="hidden" id="cMemo" value="<?php echo $row_rs['cMemo'];?>">
      <input name="cRemark" type="hidden" id="cRemark" value="<?php echo $row_rs['cRemark'];?>"></td>
  </tr>
<?php
}//end if 
?>
</table>
		<?php
			$d = $row_rs['dtECDate'];
			if($d!="" && $d!="1970-01-01"){
				$ad = getdate($d);
				$str = substr($d,0,4).",".substr($d,5,2).",".substr($d,8,2);
				$y = substr($d,0,4);
				$m = substr($d,5,2);
				$dt = substr($d,8,2);
			}else{
				$ad = getdate();
				$y = $ad["year"];
				$m = $ad["mon"];
				$dt = $ad["mday"];
			}
			//echo "str=".$str.";d=".$d;
		?>
      <script language="javascript">
	  	<!--//
		dt = new Date(<?php echo $str;?>);
		//dt = new Date();
		//alert(dt.toString());
		var dat = MM_findObj("date");
		var month = MM_findObj("month");
		var year = MM_findObj("year");
		//alert(dt.getDate());
		dat.value = <?php echo $dt;?>//dt.getDate();
		month.value = <?php echo $m;?>//dt.getMonth();
		year.value = <?php echo $y;?>//dt.getYear();
		//-->
	  </script>
</form>
<?php
}//end if status
?>
  
  
  
  <?php
  if($row_rs['cStatus']=="S25" || $row_rs['cStatus']=="S30" || $row_rs['cStatus']=="S35"){
  
  
mysql_select_db($database_localhost, $localhost);
$query_rs_crr = "SELECT * FROM tbcourier ORDER BY name ASC";
$rs_crr = mysql_query($query_rs_crr, $localhost) or die(mysql_error());
$row_rs_crr = mysql_fetch_assoc($rs_crr);
$totalRows_rs_crr = mysql_num_rows($rs_crr);

  ?>
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
	obj.value="It is working";
}
function clkN(){
	var obj = MM_findObj('cStsOnReport');
	obj.value="It is not working";
}
//-->
</script>
<form action="srf_chg_loc.php" method="post" name="fmEditStatus" id="fmEditStatus">
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td colspan="2" align="center" class="Mgr_Heading">Repair Tracking Pages<br>&nbsp;</td>
  </tr>
  <tr>
    <td width="22%" align="right">Job No.&nbsp;</td>
    <td width="78%" align="left"><span class="Mgr_Heading"><?php echo $row_rs['cJN']; ?></span></td>
  </tr>
  <tr>
    <td align="right">Make:</td>
    <td align="left"><?php echo $row_rs['cMake']; ?></td>
  </tr>
  <tr>
    <td align="right">Model:</td>
    <td align="left"><?php echo $row_rs['cModel']; ?></td>
  </tr>
  <tr>
    <td align="right">IMEI:</td>
    <td align="left"><?php echo $row_rs['cIMEI']; ?></td>
  </tr>
  <tr>
    <td align="right">Repair Status:</td>
    <td align="left"><?php echo getStatus($row_rs['cStatus']); ?></td>
  </tr>
  <tr>
    <td align="right">Current Location:</td>
  <td align="left">
          <select name="cLocation" id="cLocation">
            <option value="L10">Has been sent to dealer(L10)</option>
            <option value="L15">Ready to be picked up from Repair Center(L15)</option>
            <option value="L20">Has been picked up/delivered(L20)</option>
            <option value="L25">Keep in lieu of payment(L25)</option>
            <option value="L30">Other (L30)</option>
          </select></td>
  </tr>
  <tr id="LyrCrr">
    <td colspan="2">
	<table width="100%" cellpadding="2" cellspacing="0">
  <tr>
    <td width="22%" align="right">Courier:</td>
    <td width="78%" align="left"><select name="iCrrID" id="iCrrID">
      <option value="">&nbsp;</option>
      <?php
do {  
?>
      <option value="<?php echo $row_rs_crr['id']?>"><?php echo $row_rs_crr['name']?></option>
      <?php
} while ($row_rs_crr = mysql_fetch_assoc($rs_crr));
?>
        </select></td>
  </tr>
  <tr>
    <td align="right">Tracking Num: </td>
    <td align="left"><input name="cCrrTrk" type="text" id="cCrrTrk" value="<?php echo $row_rs['cCrrTrk']; ?>"></td>
  </tr>
	
	</table>
	</td>
    </tr>
  <tr>
    <td align="right">Estimate completion date :</td>
    <td align="left"><?php echo $row_rs['dtECDate2']; ?></td>
  </tr>
  <tr>
    <td align="right">Completion date :</td>
    <td align="left"><select name="date" id="date">
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
      </select> </td>
  </tr>
  <tr>
    <td align="right">Service Charge:</td>
	<?php
	$fontcolor = "#000000";
	$chk2 = "";
	if($row_rs['cIsWrty']!="") {$fontcolor = "#FF0000"; $chk2="checked";}
	$chk3 = "";
	if($row_rs['cIsCmmisn']!="") {$chk3="checked";}
	?>
    <td align="left">$<input name="cSrvChg" type="text" id="cSrvChg" value="<?php echo $row_rs['cSrvChg']; ?>" style="width: 100px; color:<?php echo $fontcolor; ?>;" >
	<?php 
	$chk = "";
	if($row_rs['cIIFP']!=""){$chk="checked";}
	?>
	<input name="cIIFP" type="checkbox" id="cIIFP" value="checkbox" <?php echo $chk; ?>>
          inc insp fee paid
          <input name="cFCS5" type="checkbox" id="cFCS5" value="checkbox" <?php echo ($row_rs['cFCS5']!="")?"checked":""?>>
insp fee $45.0 paid
	      <input name="cIsWrty" type="checkbox" id="cIsWrty" value="checkbox" <?php echo $chk2; ?>>
          Warranty 
              <input name="cIsCmmisn" type="checkbox" id="cIsCmmisn" value="checkbox" <?php echo $chk3; ?>>
              Commission</td>
  </tr>
  <tr valign="top">
    <td align="right">Status(Service Report): </td>
    <td><input name="cStsOnReport" type="text" id="cStsOnReport" value="<?php echo $row_rs['cStsOnReport']; ?>">
      <input type="button" name="Submit2" value="Y" onClick="javascript:clkY();">
      <input type="button" name="Submit3" value="N" onClick="javascript:clkN();"></td>
  </tr>
  <tr valign="top">
	<td align="right">Service Report: </td>
	<td><textarea name="cSrvReport" cols="50" rows="7" wrap="VIRTUAL" id="cSrvReport"><?php echo $row_rs['cSrvReport']; ?></textarea></td>
  </tr>
<?php
if($_SESSION['RP_UserGroup']=="tbopr" || ($row_rs['cAssign']== $_SESSION['RP_Username'] && $_SESSION['RP_UserGroup']=="tbtech")){
?>
  <tr>
    <td align="right">&nbsp;</td>
    <td align="left"><input type="submit" name="Submit" onClick="MM_validateForm('dtCDate','','R','cSrvChg','','R');return document.MM_returnValue" value="Submit">
      <input name="iID" type="hidden" id="iID" value="<?php echo $row_rs['iID']; ?>">
      <input name="cJN" type="hidden" id="cJN" value="<?php echo $row_rs['cJN']; ?>">
		<input name="cStatus" type="hidden" id="cStatus" value="<?php echo $row_rs['cStatus'];?>">
      <input type="hidden" name="MM_update" value="chg_loc">
      <input name="cRemark" type="hidden" id="cRemark" value="<?php echo $row_rs['cRemark'];?>" size="50"></td>
  </tr>
<?php
}
?>
              <?php
			  if(($row_rs['cStatus']=='S25' || $row_rs['cStatus']=='S30') && $row_rs['cLocation']=='L15'){
			  //if 'repaired or unservisable' and 'ready 2b picked up from RC'
			  ?>
              <tr>
                <td>&nbsp;</td>
                <td>You Have <span class="btn"> <?php echo 50 - $row_rs['iDayLmt'];?> Days </span> remained from the service complete date to collect your device. If you can not be contacted or may not occur to collect your mechine after services completion, your device maybe kept in lieu of payment. </td>
              </tr>
			  <?php
			  }
			  if($row_rs['cStatus']=='S25' || $row_rs['cStatus']=='S30' || $row_rs['cStatus']=='S35'){
			  ?>
          <tr>
        <td>&nbsp;</td>
        <td><a href="sri.php?cJN=<?php echo $row_rs['cJN'];?>" target="_blank">View Technical Report &gt;&gt; </a></td>
      </tr>
			  <?php
			  }
			  ?>
</table>
		<?php
			$d = $row_rs['dtCDate'];
			if($d!="" && $d!="1970-01-01"){
				$ad = getdate($d);
				$str = substr($d,0,4).",".substr($d,5,2).",".substr($d,8,2);
				$y = substr($d,0,4);
				$m = substr($d,5,2);
				$dt = substr($d,8,2);
			}else{
				$ad = getdate();
				$y = $ad["year"];
				$m = $ad["mon"];
				$dt = $ad["mday"];
			}
			//echo "str=".$str.";d=".$d;
		?>
      <script language="javascript">
	  	<!--//
		dt = new Date(<?php echo $str;?>);
		//dt = new Date();
		//alert(dt.toString());
		var dat = MM_findObj("date");
		var month = MM_findObj("month");
		var year = MM_findObj("year");
		var crr = MM_findObj("LyrCrr");
		//alert(dt.getDate());
		dat.value = <?php echo $dt;?>//dt.getDate();
		month.value = <?php echo $m;?>//dt.getMonth();
		year.value = <?php echo $y;?>//dt.getYear();
		
		  var objLocLst = MM_findObj('cLocation');
		  objLocLst.value = "<?php echo $row_rs['cLocation']; ?>";
		  var objCrr = MM_findObj('iCrrID');
		  objCrr.value = "<?php echo $row_rs['iCrrID']; ?>";
		//-->
	  </script>
  </form>
  <?php
  
mysql_free_result($rs_crr);

  }//end if status
  ?>
  
  
  <table width="95%" border="0" align="center" cellpadding="2" cellspacing="1">
  <tr>
    <td height="20"><a href="#"  onClick="MM_openBrWindow('product_add.php?cJN=<?php echo $row_rs['cJN'];?>','Memo','status=yes,scrollbars=yes,resizable=yes,width=640,height=480')">Open Product...</a>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><a href="product_all_back.php?job_num=<?php echo $row_rs['cJN'];?>" onClick="if(!cfm()) return false;">All Back to Stock</a> </td>
    <td><a href="product_all_out.php?job_num=<?php echo $row_rs['cJN'];?>" onClick="if(!cfm()) return false;">All StockOut</a></td>
  </tr>
  <tr>
    <td width="30%" height="20" background="../manage/images/m_tb_head.gif" class="font_white_9bold">Product Name </td>
    <td width="14%" background="../manage/images/m_tb_head.gif" class="font_white_9bold">Model</td>
    <td width="14%" background="../manage/images/m_tb_head.gif" class="font_white_9bold">Qty</td>
    <td width="16%" background="../manage/images/m_tb_head.gif" class="font_white_9bold">Status</td>
    <td width="26%" background="../manage/images/m_tb_head.gif" class="font_white_9bold">Operation</td>
  </tr>
  <?php do{?>
  <tr>
    <td class="right_solid_2" style="color:<?php echo ($row_product['branch']=='henderson')?'#06F':'#F60'?>"><?php echo $row_product['name'];?></td>
    <td class="right_solid_2"><?php echo $row_product['model'];?></td>
    <td class="right_solid_2"><?php echo $row_product['quantity'];?></td>
    <td class="right_solid_2"><?php echo $row_product['status'];?></td>
    <td><a href="product_back.php?id=<?php echo $row_product['id'];?>&job_num=<?php echo $row_product['job_num'];?>&pname=<?php echo $row_product['name'];?>" onClick="if(!cfm()) return false;">Back to Stock</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="product_out.php?id=<?php echo $row_product['id'];?>&job_num=<?php echo $row_product['job_num'];?>&pname=<?php echo $row_product['name'];?>" onClick="if(!cfm()) return false;">Stock Out</a> </td>
  </tr>
  <?php }while($row_product = mysql_fetch_assoc($rs_product));?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

  <table width="100%" border="0" cellspacing="0" cellpadding="3">
    <tr>
      <td align="center" class="Mgr_Heading">Remark</td>
    </tr>
    <tr>
      <td>
	  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
	  <?php 
	  while($row_rm = mysql_fetch_assoc($rm)){
	  ?>
        <tr>
          <td width="164" align="right" bgcolor="#ECECEC"><strong><?php echo $row_rm['cAuth'];?></strong> <?php echo $row_rm['dtSDate'];?></td>
          <td width="575" bgcolor="#FFFFFF"><?php echo str_replace("\n","<br>",$row_rm['cContent']); ?></td>
          <td width="41" bgcolor="#FFFFFF">
          <?php if($_SESSION['RP_Username']=="admin"){?>
          <a href="./remark_del.php?iID=<?php echo $row_rm['iID']; ?>&cJN=<?php echo $row_rm['cJN'];?>" onClick="if(!confirm('Are you sure?')){return false;}">Delete</a>
          <?php }?>&nbsp;
          </td>
        </tr>
	  <?php }?>
      </table>
	  </td>
    </tr>
    <tr>
      <td><table width="95%" border="0" align="center" cellpadding="3" cellspacing="2">
        <form method="post" action="<?php echo $editFormAction; ?>" name="formrm" id="formrm">
		<tr>
          <td width="23%">&nbsp;</td>
          <td width="77%"><textarea name="cContent" cols="50" rows="5" id="cContent"></textarea></td>
        </tr>
        <tr>
          <td align="right">Type in person </td>
          <td><select name="cAuth" id="cAuth">
		  	<option value=""></option>
            <?php do{?>
            <option value="<?php echo $row_typein['cName'];?>"><?php echo $row_typein['cName'];?></option>
            <?php }while($row_typein = mysql_fetch_assoc($rs_typein));?>
          </select></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input name="Submit4" type="submit" onClick="MM_validateForm('cAuth','','R');return document.MM_returnValue" value="Submit">
            <input name="cJN" type="hidden" id="cJN" value="<?php echo $colname_rs; ?>">
      <input name="cAuthType" type="hidden" id="cAuthType" value="remark">
      <input name="cAuthContact" type="hidden" id="cAuthContact">
      <input type="hidden" name="MM_insert" value="addremark"></td>
        </tr>
		</form>
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
mysql_free_result($rm);
mysql_free_result($rs_typein);
mysql_free_result($rs_product);
?>