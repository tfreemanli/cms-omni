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
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rs = 30;
$pageNum_rs = 0;
if (isset($_GET['pageNum_rs'])) {
  $pageNum_rs = $_GET['pageNum_rs'];
}
$startRow_rs = $pageNum_rs * $maxRows_rs;

//deal with the search functing
$where_clu = " where iID is not null and cIsVIP='0' ";
$cField="cName";
$cOp="like";
$cVal="";
if(isset($_GET['cField'])){
	if($_GET['cOp']=="like"){
		$where_clu .= " and ".$_GET['cField']." like '%". $_GET['cVal']."%'";
	}else{
		$where_clu .= " and ".$_GET['cField'].$_GET['cOp']."'". $_GET['cVal']."'";
	}
	$cField=$_GET['cField'];
	$cOp=$_GET['cOp'];
	$cVal=$_GET['cVal'];
}

	$where_clu .= " and  cStatus = 'normal'";
//end of search funtion

mysql_select_db($database_localhost, $localhost);
$query_rs = "SELECT * FROM tbcust ".$where_clu." ORDER BY iID DESC";
$query_limit_rs = sprintf("%s LIMIT %d, %d", $query_rs, $startRow_rs, $maxRows_rs);
$rs = mysql_query($query_limit_rs, $localhost) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);

if (isset($_GET['totalRows_rs'])) {
  $totalRows_rs = $_GET['totalRows_rs'];
} else {
  $all_rs = mysql_query($query_rs);
  $totalRows_rs = mysql_num_rows($all_rs);
}
$totalPages_rs = ceil($totalRows_rs/$maxRows_rs)-1;

$queryString_rs = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rs") == false && 
        stristr($param, "totalRows_rs") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rs = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rs = sprintf("&totalRows_rs=%d%s", $totalRows_rs, $queryString_rs);
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
function do_sch(){
	var field = MM_findObj('field');
	var op = MM_findObj('op');
	var val = MM_findObj('val');
	//var mj = MM_findObj('myjob');
	if(val.value==''){
		alert('Pls input search value');
		val.focus();
		return false;
	}
	if(field.selectedIndex < 0){
		alert('Pls select which field you are searching');
		field.focus();
		return false;
	}
	if(op.selectedIndex < 0){
		alert('Pls select the searching op');
		op.focus();
		return false;
	}
	MM_goToURL('window','ct_list.php?cField='+ field.options[field.selectedIndex].value +'&cOp='+ op.options[op.selectedIndex].value +'&cVal='+ val.value);
	return;
}
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
<table width="100%"  border="0" align="center" cellpadding="5" cellspacing="10">
  <tr>
    <td width="82%" class="Mgr_Heading">Customer</td>
    <td width="18%" align="center" class="td_block"><a href="ct_add.php">ADD &gt;&gt;</a> </td>
  </tr>
</table>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="10">
  <tr>
      <form method="post" name="fmSch" id="fmSch" onSubmit="javascript:do_sch();return false;">
    <td>
&nbsp;&nbsp;&nbsp;
        <select name="field" id="field">
          <option value="cName">First Name</option>
          <option value="cLastName">Last Name</option>
          <option value="cHomePhn">Home Phone</option>
          <option value="cWorkPhn">Work Phone</option>
        </select>
        <select name="op" id="op">
          <option value="=">=</option>
          <option value="<>">!=</option>
          <option value="like">Like</option>
        </select>
        <input name="val" type="text" id="val">
        <input type="button" name="search" value="search" onClick="javascript:do_sch();"></td>
      </form>
      <script language="javascript">
<!--
	var f = MM_findObj('field');
	var o = MM_findObj('op');
	var v = MM_findObj('val');
	f.value = "<?php echo $cField ;?>";
	o.value = "<?php echo $cOp ;?>";
	v.value = "<?php echo $cVal ;?>";
//-->
</script>
    </tr>
  <tr>
    <td><table width="100%"  border="0" align="center" cellpadding="5" cellspacing="0">
      <tr class="font_white_9bold" align="center">
        <td width="115" background="../manage/images/m_tb_head.gif" class="right_solid_1">Name</td>
        <td width="109" background="../manage/images/m_tb_head.gif" class="right_solid_1">Home Ph </td>
        <td width="100" background="../manage/images/m_tb_head.gif" class="right_solid_1">Work/Other Ph</td>
        <td width="115" background="../manage/images/m_tb_head.gif" class="right_solid_1">Address</td>
        <td width="76" background="../manage/images/m_tb_head.gif" class="right_solid_1">Email</td>
        <td width="46" background="../manage/images/m_tb_head.gif" class="right_solid_1">Opr</td>
      </tr>
      <?php
   $col = "#FFFFFF";
    do { ?>
      <tr bgcolor="<?php echo $col;?>" class="font_red_12">
        <td class="right_solid_2"><?php echo $row_rs['cName']; ?> <?php echo $row_rs['cLastName']; ?></td>
        <td class="right_solid_2"><?php echo $row_rs['cHomePhn']; ?>&nbsp;</td>
        <td class="right_solid_2"><?php echo $row_rs['cWorkPhn']; ?>&nbsp;</td>
        <td class="right_solid_2"><?php echo $row_rs['cAdd1']; ?>, <?php echo $row_rs['cAdd2']; ?>, <?php echo $row_rs['cAdd3']; ?></td>
        <td class="right_solid_2"><?php echo $row_rs['cEmail']; ?>&nbsp;</td>
        <td class="right_solid_1"><a href="ct_edit.php?iID=<?php echo $row_rs['iID']; ?>">Modify</a></td>
      </tr>
      <?php
  		if($col == "#FFFFFF"){
			$col = "#E3E3E3";
		}else{
			$col = "#FFFFFF";
		}
    } while ($row_rs = mysql_fetch_assoc($rs)); ?>
      <tr>
        <td colspan="10" bgcolor="<?php echo $col?>">
          <table border="0" width="50%" align="center">
            <tr>
              <td width="23%" align="center">
                <?php if ($pageNum_rs > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_rs=%d%s", $currentPage, 0, $queryString_rs); ?>">First</a>
                <?php } // Show if not first page ?>
              </td>
              <td width="31%" align="center">
                <?php if ($pageNum_rs > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_rs=%d%s", $currentPage, max(0, $pageNum_rs - 1), $queryString_rs); ?>">Previous</a>
                <?php } // Show if not first page ?>
              </td>
              <td width="23%" align="center">
                <?php if ($pageNum_rs < $totalPages_rs) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_rs=%d%s", $currentPage, min($totalPages_rs, $pageNum_rs + 1), $queryString_rs); ?>">Next</a>
                <?php } // Show if not last page ?>
              </td>
              <td width="23%" align="center">
                <?php if ($pageNum_rs < $totalPages_rs) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_rs=%d%s", $currentPage, $totalPages_rs, $queryString_rs); ?>">Last</a>
                <?php } // Show if not last page ?>
              </td>
            </tr>
        </table></td>
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

?>
