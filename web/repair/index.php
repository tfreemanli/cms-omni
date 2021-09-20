<?php require_once('../Connections/localhost.php'); ?>
<?php require_once('../Connections/localhost.php'); ?><?php
session_start();
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

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
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../repair/login.php";
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
$maxRows_notify = 10;
$pageNum_notify = 0;
if (isset($_GET['pageNum_notify'])) {
  $pageNum_notify = $_GET['pageNum_notify'];
}
$startRow_notify = $pageNum_notify * $maxRows_notify;

mysql_select_db($database_localhost, $localhost);
//$query_notify = "SELECT * FROM tbrepair WHERE cMemo='yes' and cIsReplyRead <> 'checked' and cAssign ='". $_SESSION['RP_Username'] ."'";
$query_notify = "SELECT * FROM tbrepair WHERE (cStatus='S10' or cStatus='S15' or cStatus='S20') and cMemoReply='yes' and cAssign ='". $_SESSION['RP_Username'] ."'";
$query_limit_notify = sprintf("%s LIMIT %d, %d", $query_notify, $startRow_notify, $maxRows_notify);
$notify = mysql_query($query_limit_notify, $localhost) or die(mysql_error());
$row_notify = mysql_fetch_assoc($notify);

if (isset($_GET['totalRows_notify'])) {
  $totalRows_notify = $_GET['totalRows_notify'];
} else {
  $all_notify = mysql_query($query_notify);
  $totalRows_notify = mysql_num_rows($all_notify);
}
$totalPages_notify = ceil($totalRows_notify/$maxRows_notify)-1;

if(isset($_GET['dsa'])){ //dsa = dont show again
	$dsa=$_GET['dsa'];
	mysql_select_db($database_localhost, $localhost);
	$query_dsa = "update tbmemo set cIsRead='y' where iID='". $dsa ."'";
	mysql_query($query_dsa, $localhost) or die(mysql_error());
}

mysql_select_db($database_localhost, $localhost);
$query_ag = "SELECT tbmemo.*,DATE_FORMAT(tbmemo.dtDate,'%d %b %Y') AS dtSDate, tbcust.iID as iAgID, tbcust.cName, tbcust.cLastName FROM tbmemo left join tbcust on tbmemo.cAuth=tbcust.cVIPNum WHERE cAuthType='agent' and cIsRead = '' ORDER BY dtDate DESC";
$ag = mysql_query($query_ag, $localhost) or die(mysql_error());
$row_ag = mysql_fetch_assoc($ag);
$totalRows_ag = mysql_num_rows($ag);
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
      <p class="Mgr_Heading">&nbsp;</p>
      <p class="Mgr_Heading">&nbsp;&nbsp;&nbsp;Welcome <?php echo $_SESSION['RP_Userrealname'];?></p>
      <?php 
	  if($_SESSION['RP_UserGroup']=="tbtech"){
	  ?>
	  <table width="100%" border="0" cellspacing="5" cellpadding="2">
        <tr>
          <td>Dealer's Reply </td>
        </tr>
        <tr>
          <td><table width="100%"  border="0" align="center" cellpadding="5" cellspacing="0">
            <tr class="font_white_9bold" align="center">
              <td width="68" background="../manage/images/m_tb_head.gif" class="right_solid_1">Job No.</td>
              <td width="80" background="../manage/images/m_tb_head.gif" class="right_solid_1">Submitted By</td>
              <td width="75" background="../manage/images/m_tb_head.gif" class="right_solid_1">Customer</td>
              <td width="75" background="../manage/images/m_tb_head.gif" class="right_solid_1">Make</td>
              <td width="82" background="../manage/images/m_tb_head.gif" class="right_solid_1">Model</td>
              <td width="110" background="../manage/images/m_tb_head.gif" class="right_solid_1">Status</td>
              <td width="113" background="../manage/images/m_tb_head.gif" class="right_solid_1">Location</td>
              <td width="113" background="../manage/images/m_tb_head.gif" class="right_solid_1">Submit Date</td>
              <td width="36" background="../manage/images/m_tb_head.gif" class="right_solid_1">Opr</td>
            </tr>
            <?php
   $col = "#FFFFFF";
    do { ?>
            <tr bgcolor="<?php echo $col;?>" class="font_red_12">
              <td bgcolor="<?php echo $col;?>" class="right_solid_2"><a href="srf.php?cJN=<?php echo $row_notify['cJN']; ?>"><?php echo $row_notify['cJN']; ?></a></td>
              <td class="right_solid_2"><?php echo $row_notify['cSbmBy']; ?></td>
              <td class="right_solid_2"><?php echo $row_notify['cCName']; ?></td>
              <td class="right_solid_2"><?php echo $row_notify['cMake']; ?></td>
              <td class="right_solid_2"><?php echo $row_notify['cModel']; ?></td>
              <td class="right_solid_2"><?php echo getStatus($row_notify['cStatus']); ?>
                  <?php
	if($row_notify['cMemo']!= null && $row_notify['cMemo']!= ""){
		//如果cMemo有内容,则显示静止的图标;如果isRead不等于"checked",表示有新的memo,那就显示闪动的图标
		//注:没有memo的记录不会在记录集中,所以其实可以不需要判断cMemo
		$pic = "button_edit.gif";
		if($row_notify['cIsReplyRead']!="checked")  $pic="button_edit_new.gif";
	?>
		<a href="#"><img src="../images/<?php echo $pic;?>" alt="Click for Detail" width="12" height="13" border="0" onClick="MM_openBrWindow('memo_4j.php?cJN=<?php echo $row_notify['cJN'];?>','Memo','status=yes,scrollbars=yes,resizable=yes,width=640,height=480')"></a>
	<?php
	}
	?>              </td>
              <td class="right_solid_2"><?php echo getLocation($row_notify['cLocation']); ?></td>
              <td class="right_solid_2"><?php echo $row_notify['dtSDate']; ?></td>
              <td><a href="srf.php?cJN=<?php echo $row_notify['cJN']; ?>">F</a> <a href="rtp.php?cJN=<?php echo $row_notify['cJN']; ?>">T</a>
                  <?php
	if($row_notify['cStatus']=='S25' || $row_notify['cStatus']=='S30' || $row_notify['cStatus']=='S35'){
	?>
                  <a href="sri.php?cJN=<?php echo $row_notify['cJN']; ?>" target="_blank">R</a> <a href="disc.php?cJN=<?php echo $row_notify['cJN']; ?>" target="_blank">D</a>
                  <?php }?>
                <a href="de_srf_2c.php?cJN=<?php echo $row_notify['cJN']; ?>">S</a> </td>
            </tr>
            <?php
  		if($col == "#FFFFFF"){
			$col = "#E3E3E3";
		}else{
			$col = "#FFFFFF";
		}
    } while ($row_notify = mysql_fetch_assoc($notify)); ?>
            <tr>
              <td colspan="10" bgcolor="<?php echo $col?>">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
      </table>
	  <?php }?>
      <p class="Mgr_Heading"></p>
      <?php 
	  if($_SESSION['RP_UserGroup']=="tbopr" && $totalRows_ag > 0){
	  ?>
      <table width="100%" border="0" cellspacing="5" cellpadding="2">
        <tr>
          <td>Agent's Messages </td>
        </tr>
        <tr>
          <td><table width="100%"  border="0" align="center" cellpadding="5" cellspacing="0">
              <tr class="font_white_9bold" align="center">
                <td width="72" background="../manage/images/m_tb_head.gif" class="right_solid_1">Agent No. </td>
                <td width="188" background="../manage/images/m_tb_head.gif" class="right_solid_1">Agent </td>
                <td width="88" background="../manage/images/m_tb_head.gif" class="right_solid_1">date</td>
                <td width="410" background="../manage/images/m_tb_head.gif" class="right_solid_1">Title</td>
                <td width="126" background="../manage/images/m_tb_head.gif" class="right_solid_1">opr</td>
              </tr>
              <?php
   $col = "#FFFFFF";
    do { ?>
              <tr bgcolor="<?php echo $col;?>" class="font_red_12">
                <td bgcolor="<?php echo $col;?>" class="right_solid_2"><a href="ag_edit.php?iID=<?php echo $row_ag['iAgID']; ?>" target="_blank"><?php echo $row_ag['cAuth']; ?></a></td>
                <td class="right_solid_2"><?php echo $row_ag['cName']; ?> <?php echo $row_ag['cLastName']; ?></td>
                <td class="right_solid_2"><?php echo $row_ag['dtSDate']; ?></td>
                <td class="right_solid_2"><a href="#" onClick="MM_openBrWindow('memo_4a.php?Ref=<?php echo $row_ag['cAuthContact'];?>','Memo','status=yes,scrollbars=yes,resizable=yes,width=640,height=480')"><?php echo substr($row_ag['cTitle'],0,60); ?></a></td>
                <td class="right_solid_2"><a href="index.php?dsa=<?php echo $row_ag['iID'];?>" onClick="if(!confirm('Are you sure?')){return false;}">Don't show again </a></td>
              </tr>
              <?php
  		if($col == "#FFFFFF"){
			$col = "#E3E3E3";
		}else{
			$col = "#FFFFFF";
		}
    } while ($row_ag = mysql_fetch_assoc($ag)); ?>
              <tr>
                <td colspan="6" bgcolor="<?php echo $col?>">&nbsp;</td>
              </tr>
          </table></td>
        </tr>
      </table>
      <?php }?>
<p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
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
mysql_free_result($notify);
mysql_free_result($all_notify);

mysql_free_result($ag);
?>
