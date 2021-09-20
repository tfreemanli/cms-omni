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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO tbagentnote (cYear, cMonth, cAgentID, IsPaid, cNote) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Year'], "text"),
                       GetSQLValueString($_POST['Month'], "text"),
                       GetSQLValueString($_POST['Agent'], "int"),
                       GetSQLValueString(isset($_POST['IsPaid']) ? "true" : "", "defined","'checked'","''"),
                       GetSQLValueString($_POST['cNote'], "text"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($insertSQL, $localhost) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE tbagentnote SET IsPaid=%s, cNote=%s WHERE iID=%s",
                       GetSQLValueString(isset($_POST['IsPaid']) ? "true" : "", "defined","'checked'","''"),
                       GetSQLValueString($_POST['cNote'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());
}

mysql_select_db($database_localhost, $localhost);
$query_rs_all = "SELECT iID, cName, cLastName FROM tbcust WHERE cIsVIP = '1' ORDER BY cName ASC";
$rs_all = mysql_query($query_rs_all, $localhost) or die(mysql_error());
$row_rs_all = mysql_fetch_assoc($rs_all);
$totalRows_rs_all = mysql_num_rows($rs_all);

$currentPage = $_SERVER["PHP_SELF"];

$today=getdate();
$Year=$today["year"];
$Month=$today["mon"];
$Agent = "all";
$where = " WHERE cAgentID IS NOT NULL ";

if(isset($_POST['MM_Query']) && ($_POST['MM_Query']=="form1")){
	$Year = $_POST['Year'];
	$Month = $_POST['Month'];
	$Agent = $_POST['Agent'];
	if($Agent!="all"){
		$where = " WHERE cAgentID = '".$Agent."'";
	}
}
$where .= " and tbrepair.dtCDate between '".$Year."-".$Month."-1' and '".$Year."-".$Month."-31'";

mysql_select_db($database_localhost, $localhost);
$query_rs = "SELECT tbrepair.iID, tbrepair.cStatus, tbrepair.cJN, tbrepair.dtCDate, tbrepair.cSrvChg, tbrepair.cAgentName, tbrepair.cAgentID, 
tbcust.cName, tbcust.cLastName, tbcust.cHomePhn, tbcust.cWorkPhn, tbcust.cEmail 
FROM tbrepair LEFT JOIN tbcust ON tbrepair.cAgentID = tbcust.iID ".$where." ORDER BY tbrepair.cAgentName";
$rs = mysql_query($query_rs, $localhost) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);
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
//-->
</script><!-- InstanceEndEditable -->
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
<table width="100%"  border="0" align="center" cellpadding="5" cellspacing="10">
  <tr>
    <td width="82%" class="Mgr_Heading">Agents Stat</td>
    <td width="18%" align="center">&nbsp;</td>
  </tr>
  <form name="form1" method="post" action="">
  <tr>
    <td class="Mgr_Heading">
      Month:
          <select name="Month" id="Month">
	  <?php
	  for($i=1; $i<=12; $i++){
	  ?>
	  	<option value="<?php echo $i;?>"><?php echo $i;?></option>
	  <?php
	  }
	  ?>
      </select> 
      &nbsp;&nbsp;&nbsp;&nbsp;Year: 
      <select name="Year" id="Year">
        <option value="2007">2007</option>
        <option value="2008">2008</option>
        <option value="2009">2009</option>
        <option value="2010">2010</option>
        <option value="2011">2011</option>
        <option value="2012">2012</option>
      </select>
        &nbsp;&nbsp;&nbsp;Agent:
          <select name="Agent" id="Agent">
		  	<option value="all">Never Mind </option>
        <?php do { ?>
			<option value="<?php echo $row_rs_all['iID']; ?>"><?php echo $row_rs_all['cName']; ?> <?php echo $row_rs_all['cLastName']; ?></option>
          <?php } while ($row_rs_all = mysql_fetch_assoc($rs_all)); ?>
          </select>
    </td>
    <td align="center"><input name="Submit" type="submit" class="btn" value="Submit">
      <input type="hidden" name="MM_Query" value="form1"></td>
  </tr>
    </form>
<script language="javascript">
<!--
	var year = MM_findObj("Year");
	var month = MM_findObj("Month");
	var agent = MM_findObj("Agent");
	year.value = '<?php echo $Year;?>';
	month.value = '<?php echo $Month;?>';
	agent.value = '<?php echo $Agent;?>';
//-->
</script>
</table>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="10">
  <tr>
    <td><table width="100%"  border="0" align="center" cellpadding="5" cellspacing="0">
      <tr class="font_white_9bold" align="center">
        <td width="162" background="../manage/images/m_tb_head.gif" class="right_solid_1">AgentName</td>
        <td width="80" background="../manage/images/m_tb_head.gif" class="right_solid_1">Job Num</td>
        <td width="205" background="../manage/images/m_tb_head.gif" class="right_solid_1">Job Status</td>
        <td width="205" background="../manage/images/m_tb_head.gif" class="right_solid_1">Comp Date</td>
        <td width="102" background="../manage/images/m_tb_head.gif" class="right_solid_1">Srv Chg</td>
        <td width="78" background="../manage/images/m_tb_head.gif" class="right_solid_1">Contact</td>
        <td width="52" background="../manage/images/m_tb_head.gif" class="right_solid_1">Email</td>
      </tr>
      <?php
   $col = "#FFFFFF";
   $prevGuy = "";
    do { 
	if($prevGuy!="" && $prevGuy!=$row_rs['cAgentName']){
  		if($col == "#FFFFFF"){
			$col = "#E3E3E3";
		}else{
			$col = "#FFFFFF";
		}
		
	}
	$prevGuy = $row_rs['cAgentName'];
    ?>
      <tr bgcolor="<?php echo $col;?>" class="font_red_12">
        <td class="right_solid_2"><a href="ag_edit.php?iID=<?php echo $row_rs['cAgentID']; ?>"><?php echo $row_rs['cAgentName']; ?></a></td>
        <td class="right_solid_2"><a href="srf.php?cJN=<?php echo $row_rs['cJN']; ?>"><?php echo $row_rs['cJN']; ?></a>&nbsp;</td>
        <td class="right_solid_2"><?php echo getStatus($row_rs['cStatus']); ?>&nbsp;</td>
        <td class="right_solid_2"><?php echo $row_rs['dtCDate']; ?>&nbsp;</td>
        <td class="right_solid_2"><?php echo $row_rs['cSrvChg']; ?>&nbsp;</td>
        <td class="right_solid_2"><?php echo $row_rs['cHomePhn']; ?> <?php echo $row_rs['cWorkPhn']; ?></td>
        <td class="right_solid_1"><?php echo $row_rs['cEmail']; ?></td>
      </tr>
      <?php

    } while ($row_rs = mysql_fetch_assoc($rs)); ?>
    </table></td>
  </tr>
<?php
if($Agent!="all"){

	mysql_select_db($database_localhost, $localhost);
	$query_rs_note = "SELECT iID, IsPaid, cNote FROM tbagentnote WHERE cYear='".$Year."' and cMonth='".$Month."' and cAgentID='".$Agent."'";
	$rs_note = mysql_query($query_rs_note, $localhost) or die(mysql_error());
	$row_rs_note = mysql_fetch_assoc($rs_note);
	$totalRows_rs_note = mysql_num_rows($rs_note);

?>
  <tr>
    <td><table width="100%" border="0" cellspacing="2" cellpadding="5">
          <form name="form2" method="POST" action="">
      <tr>
        <td width="12%" class="Mgr_Heading">Is Paid?</td>
        <td width="88%"><input name="IsPaid" type="checkbox" id="IsPaid" value="checkbox" <?php echo $row_rs_note['IsPaid'];?>>
          <span class="Mgr_Heading">Yes</span></td>
      </tr>
      <tr>
        <td class="Mgr_Heading">Note</td>
        <td><textarea name="cNote" class="text_normal" id="cNote"><?php echo $row_rs_note['cNote'];?></textarea></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input name="Submit2" type="submit" class="btn" value="Apply">
          <input type="hidden" name="id" value="<?php echo $row_rs_note['iID'];?>">
          <input type="hidden" name="Year" value="<?php echo $Year;?>">
          <input type="hidden" name="Month" value="<?php echo $Month;?>">
          <input type="hidden" name="Agent" value="<?php echo $Agent;?>"></td>
      </tr>
	  <?php
	  $act = "MM_insert";
	  if($row_rs_note['iID']!=null && $row_rs_note['iID']!=''){
	  	$act = "MM_update";
	  }
	  ?>
      <input type="hidden" name="<?php echo $act;?>" value="form2">
          <input type="hidden" name="MM_Query" value="form1">
          </form>
    </table>      <p>&nbsp;</p>
      </td>
  </tr>
<?php
}
?>
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
mysql_free_result($rs_all);

mysql_free_result($rs);
?>
