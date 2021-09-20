<?php require_once('../Connections/localhost.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "";
$MM_authorizedGroups = "";
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
//if (!((isset($_SESSION['RP_Username'])) && (isAuthorized($MM_authorizedUsers, $MM_authorizedGroups, $_SESSION['RP_Username'], $_SESSION['RP_UserGroup'])))) {   
if (!isset($_SESSION['RP_Username'])){
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
	$dtDate = $_POST['year']."-".$_POST['month']."-".$_POST['date'];
	
  $insertSQL = sprintf("update tbdo set dtDate=%s, iDID=%s, cName=%s, cAdd=%s, cItemQty=%s where iID=%s",
                       GetSQLValueString($dtDate, "date"),
                       GetSQLValueString($_POST['iDID'], "int"),
                       GetSQLValueString($_POST['cName'], "text"),
                       GetSQLValueString($_POST['cAdd'], "text"),
                       GetSQLValueString(substr_count($_SESSION['JNse'], " "), "text"),
                       GetSQLValueString($_POST['iID'], "text"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($insertSQL, $localhost) or die(mysql_error());
  
  //clear the exsiting items
  mysql_select_db($database_localhost, $localhost);
  $clearSQL = "delete from tbdodetail where iDoID='".$_POST['iID']."'";
  $Result1 = mysql_query($clearSQL, $localhost) or die(mysql_error());
  
  //get the where clu.
  	mysql_select_db($database_localhost, $localhost);
 	$array = explode(" ", trim($_SESSION['JNse']));
	$where = " where 1=2 ";
	$count = count($array);
	for ($i = 0; $i < $count; $i++) {
		$where .= "or cJN='". $array[$i] ."' ";
	}
  $insertSQL = "insert into tbdodetail (iDoID, cJN, cMake, cModel, cIMEI, fSrvChg, iCrrID, cCrrTrk) select '" . $_POST['iID'] . "', cJN, cMake, cModel, cIMEI, cSrvChg, iCrrID, cCrrTrk from tbrepair ". $where;
  //echo $insertSQL;
  $Result1 = mysql_query($insertSQL, $localhost) or die(mysql_error());
	$GLOBALS['JNsEDIT'] = "NO";//this is a flag of Editing mode
	session_register("JNsEDIT");
	$GLOBALS['JNse'] = "";
	session_register("JNse");
	$GLOBALS['JNs'] = "";
	session_register("JNs");
	$GLOBALS['DOID'] = "";
	session_register("DOID");
  
  
  //$insertGoTo = "do_list.php";  
  $insertGoTo = "do_prt.php?iID=".$_POST['iID'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_localhost, $localhost);
$query_dealer = "SELECT iID, cName, cAdd FROM tbdeal";
$dealer = mysql_query($query_dealer, $localhost) or die(mysql_error());
$row_dealer = mysql_fetch_assoc($dealer);
$totalRows_dealer = mysql_num_rows($dealer);

$colname_rs = "-1";
if (isset($_GET['iID'])) {
  $colname_rs = (get_magic_quotes_gpc()) ? $_GET['iID'] : addslashes($_GET['iID']);
}
mysql_select_db($database_localhost, $localhost);
$query_rs = sprintf("SELECT * FROM tbdo WHERE iID = %s", $colname_rs);
$rs = mysql_query($query_rs, $localhost) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);
$totalRows_rs = mysql_num_rows($rs);

$cJNs = (isset($_SESSION['JNs']))?$_SESSION['JNs']:"";
if(!isset($_SESSION['JNsEDIT']) || $_SESSION['JNsEDIT']!="YES"){
	mysql_select_db($database_localhost, $localhost);
	$query_detail = "SELECT * FROM tbdodetail left join tbcourier on tbdodetail.iCrrID=tbcourier.id  where iDoID = '". $colname_rs. "' ORDER BY cJN DESC";
	$detail = mysql_query($query_detail, $localhost) or die(mysql_error());
	$row_detail = mysql_fetch_assoc($detail);
	do{
		$cJNs = $cJNs." ". $row_detail['cJN'];
	}while($row_detail = mysql_fetch_assoc($detail));
}
$GLOBALS['JNse'] = $cJNs;//JNs as addDO.
session_register("JNse");
$array = explode(" ", trim($_SESSION['JNse']));
$where = " where iID is null ";
$count = count($array);
for ($i = 0; $i < $count; $i++) {
	$where .= "or cJN='". $array[$i] ."' ";
}
mysql_select_db($database_localhost, $localhost);
$query_detail = "SELECT * FROM tbrepair left join tbcourier on tbrepair.iCrrID=tbcourier.id ". $where. " ORDER BY cJN DESC";
//echo "<br>".$query_detail."<br>".$_SESSION['JNs'];
$detail = mysql_query($query_detail, $localhost) or die(mysql_error());
$row_detail = mysql_fetch_assoc($detail);
$totalRows_detail = mysql_num_rows($detail);
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
<table width="808"  border="0" align="center" cellpadding="5" cellspacing="10">
      <tr>
        <td width="538" class="Mgr_Heading">Delivery Order - Edit </td>
        <td width="220" align="center">&nbsp;</td>
      </tr>
	  <form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
      <tr>
        <td class="Mgr_Heading"><table width="514" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td width="74">Date</td>
            <td width="426"><select name="date" id="date">
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
		<?php
			$d = $row_rs['dtDate'];
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
		date.value = dt.getDate(dt);
		month.value = dt.getMonth(dt);
		year.value = dt.getYear(dt);
		//-->
	  </script>
          </tr>
          <tr>
            <td>Dealer</td>
            <td><select name="iDID" id="iDID">
              <?php
do {  
?>
              <option value="<?php echo $row_dealer['iID']?>"><?php echo $row_dealer['cName']?></option>
              <?php
} while ($row_dealer = mysql_fetch_assoc($dealer));
  $rows = mysql_num_rows($dealer);
  if($rows > 0) {
      mysql_data_seek($dealer, 0);
	  $row_dealer = mysql_fetch_assoc($dealer);
  }
?>
            </select></td>
		  <script language="javascript">
		  <!--
		  var objLocLst = MM_findObj('iDID');
		  objLocLst.value = "<?php echo $row_rs['iDID']; ?>";
		  //-->
		  </script>
          </tr>
          <tr>
            <td>Deliver to </td>
            <td><input name="cAdd" type="text" class="ipt_normal" id="cAdd" style="width:300px;" value="<?php echo $row_rs['cAdd']; ?>">
<input name="cName" type="hidden" id="cName" value="<?php echo $row_rs['cName']; ?>">
<input name="iID" type="hidden" id="iID" value="<?php echo $row_rs['iID']; ?>">
              <input type="button" name="Submit2" value="Get Address" onClick="javascript:ga();"></td>
          </tr>
        </table></td>
		<script id='getadd'></script>
		<script language="javascript">
		<!--
		function ga(){
			var dealer = MM_findObj('iDID');
			var a= MM_findObj('getadd');
			if(dealer!=null){
				a.src='do_getaddr.php?dealer='+dealer.options[dealer.selectedIndex].value;
			}
			return;
		}
		//-->
		</script>
        <td valign="bottom"><input name="Submit" type="submit" onClick="MM_validateForm('cAdd','','R');return document.MM_returnValue" value="Submit">
          <input name="Submit4" type="button" onClick="MM_goToURL('parent','./do_quitEdit.php?iID=<?php echo $row_rs['iID']; ?>');return document.MM_returnValue" value="Cancel">
          <input name="Submit5" type="button" onClick="MM_goToURL('parent','./do_intoEdit.php?iID=<?php echo $row_rs['iID']; ?>');return document.MM_returnValue" value="Edit Items"></td></tr>
      <input type="hidden" name="MM_update" value="form1">
	    </form>
    </table>
	<table width="700"  border="0" cellpadding="5" cellspacing="0">
      <tr background="../manage/images/m_tb_head.gif">
        <td width="67" align="center" background="../manage/images/m_tb_head.gif" class="font_white_9bold">JN</td>
        <td width="77" align="center" background="../manage/images/m_tb_head.gif" class="font_white_9bold">Make</td>
        <td width="80" align="center" background="../manage/images/m_tb_head.gif" class="font_white_9bold">Model</td>
        <td width="196" align="center" background="../manage/images/m_tb_head.gif" class="font_white_9bold">IMEI</td>
        <td width="94" align="center" background="../manage/images/m_tb_head.gif" class="font_white_9bold">Service Charge </td>
        <td width="126" align="center" background="../manage/images/m_tb_head.gif" class="font_white_9bold">Tracking</td>
        </tr>
        <?php do { ?>
		<tr id="<?php echo $row_detail['cJN']; ?>">
          <td align="center" class="right_solid_2"><?php echo $row_detail['cJN']; ?></td>
          <td align="center" class="right_solid_2"><?php echo $row_detail['cMake']; ?></td>
          <td align="center" class="right_solid_2"><?php echo $row_detail['cModel']; ?></td>
          <td align="center" class="right_solid_2"><?php echo $row_detail['cIMEI']; ?></td>
          <td align="center" class="right_solid_2">$<?php echo $row_detail['cSrvChg']; ?></td>
          <td align="center" class="right_solid_2"><a href="http://<?php echo $row_detail['url'];?>" target="_blank" title="<?php echo $row_detail['name'];?>"><?php echo $row_detail['cCrrTrk']; ?></a></td>
          </tr>
          <?php } while ($row_detail = mysql_fetch_assoc($detail)); ?>
		  
			<script id="dosession"></script>
			<script language="javascript">
			<!--
			//Delivery Session
			function ul(jn){
				//alert("here.");
				var obj = MM_findObj("dosession");
				var row = MM_findObj(jn);
				set = 0;
				obj.src= "do_session.php?cJN="+jn+"&set="+set;
				row.style.visibility = "hidden";
				row.style.display = "none";
			}
			//-->
			</script>
		<tr>
		  <td colspan="6" align="right">
		  <?php 
		  if(isset($_SESSION['JNsEDIT']) && $_SESSION['JNsEDIT']=="YES"){
		  ?>
		  <strong><span id="qty" style="color:#FF0000">You are in ITEM EDIT mode, pls Submit or Cancel your change.</span></strong>		  
		  <?php
		  }else{
		  ?>
		  <strong><span id="qty" style="color:#FF0000"><?php echo $row_rs['cItemQty'];?></span></strong> items in Delivery Order		  
		  <?php
		  }
		  ?></td>
	    </tr>
		<tr>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td>
		    <input name="Submit3" type="submit" onClick="MM_openBrWindow('do_prt.php?iID=<?php echo $row_rs['iID']; ?>&cls=1','','')" value="Print">		  </td>
		  <td>&nbsp;</td>
		</tr>
    </table>
	<!-- editmode:<?php echo $_SESSION['JNsEDIT'];?>|jns:<?php echo $_SESSION['JNs'];?>|jnse:<?php echo $_SESSION['JNse'];?> -->
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
mysql_free_result($dealer);
mysql_free_result($detail);
mysql_free_result($rs);
?>
