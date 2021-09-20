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
if(isset($_SESSION['JNsEDIT']) && $_SESSION['JNsEDIT']=="YES"){
	header("Location: do_edit.php?iID=".$_SESSION['DOID']); 
    exit;
}

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_do = 30;
$pageNum_do = 0;
if (isset($_GET['pageNum_do'])) {
  $pageNum_do = $_GET['pageNum_do'];
}
$startRow_do = $pageNum_do * $maxRows_do;

mysql_select_db($database_localhost, $localhost);
$query_do = "SELECT *,DATE_FORMAT(dtDate,'%d %b %Y') AS dtSDate FROM tbdo ORDER BY iID DESC";
$query_limit_do = sprintf("%s LIMIT %d, %d", $query_do, $startRow_do, $maxRows_do);
$do = mysql_query($query_limit_do, $localhost) or die(mysql_error());
$row_do = mysql_fetch_assoc($do);

if (isset($_GET['totalRows_do'])) {
  $totalRows_do = $_GET['totalRows_do'];
} else {
  $all_do = mysql_query($query_do);
  $totalRows_do = mysql_num_rows($all_do);
}
$totalPages_do = ceil($totalRows_do/$maxRows_do)-1;

$queryString_do = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_do") == false && 
        stristr($param, "totalRows_do") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_do = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_do = sprintf("&totalRows_do=%d%s", $totalRows_do, $queryString_do);
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
        <td width="82%" class="Mgr_Heading">Delivery Order  </td>
        <td width="18%" align="center">&nbsp;</td>
      </tr>
    </table>
	<table width="784"  border="0" align="center" cellpadding="5" cellspacing="0">
      <tr background="../manage/images/m_tb_head.gif">
        <td width="78" align="center" background="../manage/images/m_tb_head.gif" class="font_white_9bold">Date</td>
        <td width="231" align="center" background="../manage/images/m_tb_head.gif" class="font_white_9bold">Dealer</td>
        <td width="308" align="center" background="../manage/images/m_tb_head.gif" class="font_white_9bold">Deliver To </td>
        <td width="51" align="center" background="../manage/images/m_tb_head.gif" class="font_white_9bold">Item Qty </td>
        <td width="66" align="center" background="../manage/images/m_tb_head.gif" class="font_white_9bold">Opr</td>
        </tr>
        <?php
		$col = "#FFFFFF";
		 do { ?>
      <tr  bgcolor="<?php echo $col;?>">
          <td class="right_solid_2"><?php echo $row_do['dtSDate']; ?></td>
          <td class="right_solid_2"><?php echo $row_do['cName']; ?></td>
          <td class="right_solid_2"><?php echo $row_do['cAdd']; ?></td>
          <td class="right_solid_2"><?php echo $row_do['cItemQty']; ?></td>
          <td class="right_solid_2"><a href="do_edit.php?iID=<?php echo $row_do['iID'];?>">Edit</a> <a href="do_del.php?iID=<?php echo $row_do['iID'];?>" onClick="javascript:if(!cfm()) return false;">Delete</a></td>
      </tr>
          <?php
			    if($col == "#FFFFFF"){
					$col = "#E3E3E3";
				}else{
					$col = "#FFFFFF";
				}
		   } while ($row_do = mysql_fetch_assoc($do)); ?>
    </table>
	
    <table border="0" width="50%" align="center">
      <tr>
        <td width="23%" align="center"><?php if ($pageNum_do > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_do=%d%s", $currentPage, 0, $queryString_do); ?>">First</a>
              <?php } // Show if not first page ?>
        </td>
        <td width="31%" align="center"><?php if ($pageNum_do > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_do=%d%s", $currentPage, max(0, $pageNum_do - 1), $queryString_do); ?>">Previous</a>
              <?php } // Show if not first page ?>
        </td>
        <td width="23%" align="center"><?php if ($pageNum_do < $totalPages_do) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_do=%d%s", $currentPage, min($totalPages_do, $pageNum_do + 1), $queryString_do); ?>">Next</a>
              <?php } // Show if not last page ?>
        </td>
        <td width="23%" align="center"><?php if ($pageNum_do < $totalPages_do) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_do=%d%s", $currentPage, $totalPages_do, $queryString_do); ?>">Last</a>
              <?php } // Show if not last page ?>
        </td>
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
mysql_free_result($do);
mysql_free_result($all_do);
?>
