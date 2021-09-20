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

$where_clu = " where (cStatus = 'S25' or cStatus = 'S30' or cStatus = 'S35') ";
$dealer = "omnitech";
$today=getdate();
$cYear=$today["year"];
$cMonth=$today["mon"];
if(isset($_POST['year'])){
	$cYear=$_POST['year'];
	$cMonth=$_POST['month'];
	$dealer = $_POST['dealer'];
}
$enddate = $cYear."-".$cMonth."-31";
$startdate = $cYear."-".$cMonth."-1";


mysql_select_db($database_localhost, $localhost);
$sql = "select count(*) as cnt from tbrepair where cSbm = '". $dealer ."' and dtSDate between '". $startdate ."' and '". $enddate ."'";
$rs_total = mysql_query($sql, $localhost) or die(mysql_error());
$row_total = mysql_fetch_assoc($rs_total);
$totalall = $row_total['cnt'];


mysql_select_db($database_localhost, $localhost);
$sql = "select count(*) as cnt from tbrepair where (cStatus = 'S05' or cStatus = 'S10' or cStatus = 'S15' or cStatus = 'S20') and cSbm = '". $dealer ."' and dtSDate between '". $startdate ."' and '". $enddate ."'";
$rs_total = mysql_query($sql, $localhost) or die(mysql_error());
$row_total = mysql_fetch_assoc($rs_total);
$undone = $row_total['cnt'];


mysql_select_db($database_localhost, $localhost);
$sql = "select count(*) as cnt from tbrepair where (cStatus = 'S25' or cStatus = 'S30' or cStatus = 'S35') and cSbm = '". $dealer ."' and dtSDate between '". $startdate ."' and '". $enddate ."'";
$rs_total = mysql_query($sql, $localhost) or die(mysql_error());
$row_total = mysql_fetch_assoc($rs_total);
$total = $row_total['cnt'];

//repaired
$sql_1 = "select count(*) as cnt from tbrepair where cStatus = 'S30' and cSbm = '". $dealer ."' and dtSDate between '". $startdate ."' and '". $enddate ."'";
$rs_total = mysql_query($sql_1, $localhost) or die(mysql_error());
$row_total = mysql_fetch_assoc($rs_total);
$repaired = $row_total['cnt'];

//unservicable
$sql_1 = "select count(*) as cnt from tbrepair where cStatus = 'S25' and cSbm = '". $dealer ."' and dtSDate between '". $startdate ."' and '". $enddate ."'";
$rs_total = mysql_query($sql_1, $localhost) or die(mysql_error());
$row_total = mysql_fetch_assoc($rs_total);
$unserv = $row_total['cnt'];

//other
$sql_1 = "select count(*) as cnt from tbrepair where cStatus = 'S35' and cSbm = '". $dealer ."' and dtSDate between '". $startdate ."' and '". $enddate ."'";
$rs_total = mysql_query($sql_1, $localhost) or die(mysql_error());
$row_total = mysql_fetch_assoc($rs_total);
$other = $row_total['cnt'];

//wrty
$sql_1 = "select count(*) as cnt from tbrepair where cIsWrty <> '' and cSbm = '". $dealer ."' and dtSDate between '". $startdate ."' and '". $enddate ."'";
$rs_total = mysql_query($sql_1, $localhost) or die(mysql_error());
$row_total = mysql_fetch_assoc($rs_total);
$wrty = $row_total['cnt'];
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
        <td class="Mgr_Heading">Dealer Stats </td>
        <td align="center">&nbsp;</td>
      </tr>
          <form name="form1" method="post" action="">
      <tr>
        <td width="82%">Dealer 
          <select name="dealer" id="dealer">
      <?php do {?>
      <option value="<?php echo $row_dealer['cLogin'];?>"><?php echo $row_dealer['cName'];?></option>
      <?php 
    } while ($row_dealer = mysql_fetch_assoc($rs_dealer)); 
  ?>
    </select>
          Year
          <select name="year" id="year">
            <option value="2006">2006</option>
            <option value="2007">2007</option>
            <option value="2008" selected>2008</option>
            <option value="2009">2009</option>
            <option value="2010">2010</option>
            <option value="2011">2011</option>
            <option value="2012">2012</option>
          </select> 
          Month
            <select name="month" id="month">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
              <option value="8">8</option>
              <option value="9">9</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
            </select></td>
        <td width="18%" align="center"><input name="Submit" type="submit" class="btn" value="Submit"></td>
      </tr>
          </form>
    </table>
<script language="javascript">
<!--
	var f = MM_findObj('year');
	var o = MM_findObj('month');
	var d = MM_findObj('dealer');
	d.value = "<?php echo $dealer ;?>";
	f.value = "<?php echo $cYear ;?>";
	o.value = "<?php echo $cMonth ;?>";
//-->
</script>
	<table width="720"  border="0" align="center" cellpadding="5" cellspacing="0">
      <tr background="../manage/images/m_tb_head.gif">
        <td width="97" background="../manage/images/m_tb_head.gif" class="font_white_9bold">Total Jobs </td>
        <td width="83" background="../manage/images/m_tb_head.gif" class="font_white_9bold">Uncompleted</td>
        <td width="79" background="../manage/images/m_tb_head.gif" class="font_white_9bold">Jobs Done </td>
        <td width="93" background="../manage/images/m_tb_head.gif" class="font_white_9bold">Repaired</td>
        <td width="104" background="../manage/images/m_tb_head.gif" class="font_white_9bold">Unservicealbe</td>
        <td width="94" background="../manage/images/m_tb_head.gif" class="font_white_9bold">Others</td>
        <td width="100" background="../manage/images/m_tb_head.gif" class="font_white_9bold">Warranty</td>
      </tr>
      <tr>
        <td class="right_solid_2"><?php echo $totalall;?></td>
        <td class="right_solid_2"><?php echo $undone;?></td>
        <td class="right_solid_2"><?php echo $total;?></td>
        <td class="right_solid_2"><?php echo $repaired;?></td>
        <td class="right_solid_2"><?php echo $unserv;?></td>
        <td class="right_solid_2"><?php echo $other;?></td>
        <td><?php echo $wrty;?></td>
      </tr>
	  <?php if($total!=0){?>
      <tr>
        <td class="right_solid_2">&nbsp;</td>
        <td class="right_solid_2">&nbsp;</td>
        <td class="right_solid_2">&nbsp;</td>
        <td class="right_solid_2"><?php echo round((100*$repaired/$total),2);?>%</td>
        <td class="right_solid_2"><?php echo round((100*$unserv/$total),2);?>%</td>
        <td class="right_solid_2"><?php echo round((100*$other/$total),2);?>%</td>
        <td><?php echo round((100*$wrty/$total),2);?>%</td>
      </tr>
	  <?php }?>
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
mysql_free_result($rs_dealer);
mysql_free_result($rs_total);
?>
