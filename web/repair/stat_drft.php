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
$currentPage = $_SERVER["PHP_SELF"];

//deal with the search functing
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
if($cMonth == "1"){
	//$startdate = ($cYear-1)."-12-21";
}else{
	//$startdate = $cYear."-".($cMonth-1)."-21";
}
$startdate = $cYear."-".$cMonth."-1";

$where_clu .= " and dtCDate between '".$startdate."' and '". $enddate."'";

//remove the iSbmType, c's search in tbinv_dtl insdead of tbrepair
//$where_clu .= " and (iSbmType=1 or iSbmType=3) and cSbm = '". $dealer ."'";
$where_clu .= " and cSbm = '". $dealer ."'";
	
//end of search funtion

mysql_select_db($database_localhost, $localhost);
$query_req = "SELECT iID, cJN, cStatus, dtSDate, dtCDate, cSrvChg, cIIFP, cIsWrty, cIsCmmisn FROM tbinv_dtl ".$where_clu." ORDER BY dtCDate DESC";
$req = mysql_query($query_req, $localhost) or die(mysql_error());
$row_req = mysql_fetch_assoc($req);

mysql_select_db($database_localhost, $localhost);
$query_dealer = "SELECT iID,cLogin,cName FROM tbdeal where cStatus='normal' ORDER BY iID";
$rs_dealer = mysql_query($query_dealer, $localhost) or die(mysql_error());
$row_dealer = mysql_fetch_assoc($rs_dealer);

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
.style1 {font-weight: bold}
-->
</style>
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
	  
	<?php include('./myfunction.php');?>
    <table width="100%"  border="0" align="center" cellpadding="5" cellspacing="10">
      <tr>
        <td width="74%" class="Mgr_Heading"><strong>Draft Invoice</strong></td>
		<form method="post" name="fmCNP" id="fmCNP" action="creditNpayment.php">
        <td width="26%" align="center"><input name="GO2" type="submit" class="btn" value=" Credit & Payment ">
		<input type="hidden" name="sbm" value="<?php echo $dealer ;?>">
		<input type="hidden" name="MM_query" value="fmCNP"></td>
		</form>
      </tr>
      <tr>
        <td>Note: This's not an actual invoice.</td>
        <td align="center">&nbsp;</td>
      </tr>
    </table>
    <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="10">
      <tr>
    <form method="post" name="fmStat" id="fmStat" onSubmit="javascript:do_stat();return false;">
        <td>
  <p>&nbsp;&nbsp;&nbsp;
  Year:
      &nbsp;&nbsp;&nbsp;
<select name="year" id="year">
        <option value="2006">2006</option>
        <option value="2007">2007</option>
        <option value="2008">2008</option>
        <option value="2009">2009</option>
        <option value="2010">2010</option>
        <option value="2011">2011</option>
        <option value="2012">2012</option>
      </select>
&nbsp;&nbsp;&nbsp;Month
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
    </select>&nbsp;&nbsp;&nbsp;
    <input type="submit" name="GO" value="GO">
    <a href="invPrt.php?year=<?php echo $cYear ;?>&month=<?php echo $cMonth ;?>&dealer=<?php echo $dealer ;?>"></a><br>
    &nbsp;&nbsp;&nbsp; Dealer : 
    <select name="dealer" id="dealer" onChange="chgDealer();">
      <?php do {?>
      <option value="<?php echo $row_dealer['cLogin'];?>">[<?php echo substr(strval($row_dealer['iID']+1000),1,3);?>]<?php echo $row_dealer['cName'];?></option>
      <?php 
    } while ($row_dealer = mysql_fetch_assoc($rs_dealer)); 
  ?>
    </select>
  </p></td>
</form>
<script language="javascript">
<!--
function chgDealer(){
	var s = MM_findObj('sbm');
	var d = MM_findObj('dealer');
	s.value = d.value;
}
//-->
</script>
        </tr>
      <tr>
        <td><a href="invPrt.php?year=<?php echo $cYear ;?>&month=<?php echo $cMonth ;?>&dealer=<?php echo $dealer ;?>" target="_blank" class="td_block">&nbsp;&nbsp;Print Following Invoice&nbsp;&nbsp;</a></td>
      </tr>
      <tr>
        <td><table width="100%"  border="0" align="center" cellpadding="5" cellspacing="0">
          <tr class="font_white_9bold" align="center">
            <td width="28" background="./images/cms_22.gif" class="STYLE1">&nbsp;</td>
            <td width="98" background="./images/cms_22.gif" class="STYLE1">Job No.</td>
            <td width="115" background="./images/cms_22.gif" class="STYLE1">Cmplt Date</td>
            <td width="100" background="./images/cms_22.gif" class="STYLE1">Sbmt Date</td>
            <td width="142" background="./images/cms_22.gif" class="STYLE1">Status</td>
            <td width="103" background="./images/cms_22.gif" class="STYLE1">Srv Chg</td>
            <td width="53" background="./images/cms_22.gif" class="STYLE1">Commision</td>
            <td width="100" background="./images/cms_22.gif" class="STYLE1">Warranty</td>
          </tr>
          <?php
   $col = "#FFFFFF";
   $commision = 0.0;
    do { ?>
          <tr bgcolor="<?php echo $col;?>" class="font_red_12">
            <td bgcolor="<?php echo $col;?>" class="right_solid_2">
              <input type="checkbox" name="checkbox" value="checkbox"></td>
            <td bgcolor="<?php echo $col;?>" class="right_solid_2"><a href="srf.php?cJN=<?php echo $row_req['cJN']; ?>"><?php echo $row_req['cJN']; ?></a></td>
            <td class="right_solid_2"><?php echo $row_req['dtCDate']; ?></td>
            <td class="right_solid_2"><?php echo $row_req['dtSDate']; ?></td>
            <td class="right_solid_2"><?php echo getStatus($row_req['cStatus']); ?></td>
            <td class="right_solid_2"><?php echo $row_req['cSrvChg']; ?></td>
            <td class="right_solid_2">
              <?php
		if($row_req['cIsCmmisn']!="" && $row_req['cIsCmmisn']!=null){
			echo "20.0";
			$commision += 20.0;
		}
		 ?>
        &nbsp;</td>
            <td><?php echo $row_req['cIsWrty']; ?>&nbsp;</td>
          </tr>
          <?php
  		if($col == "#FFFFFF"){
			$col = "#E3E3E3";
		}else{
			$col = "#FFFFFF";
		}
    } while ($row_req = mysql_fetch_assoc($req)); ?>
          <tr class="font_red_12">
            <td colspan="8" align="right" bgcolor="#EFEFEF" class="right_solid_1"><img src="images/1x1.gif" width="1" height="1"></td>
          </tr>
          <tr class="font_red_12">
            <?php 
	  $query_req = "select sum(cSrvChg) as cSrvChg  from tbinv_dtl ". $where_clu;
	  $req = mysql_query($query_req, $localhost) or die(mysql_error());
	  $row_req = mysql_fetch_assoc($req);
	  ?>
            <td colspan="5" align="right" class="right_solid_1"><strong>Subtotal</strong>:</td>
            <td class="right_solid_1"><?php echo $row_req['cSrvChg'];?>&nbsp;</td>
            <td colspan="2" class="right_solid_1">
              <?php
		echo $commision;
		?>
        &nbsp;</td>
          </tr>
          <tr class="font_red_12">
            <td colspan="5" align="right" class="right_solid_1"><strong>Total</strong>:</td>
            <td colspan="3" class="right_solid_1"><?php echo $row_req['cSrvChg'] - $commision;?>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
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
mysql_free_result($req);
mysql_free_result($rs_dealer);
?>
