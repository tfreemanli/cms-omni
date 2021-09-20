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
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_req = 20;
$pageNum_req = 0;
if (isset($_GET['pageNum_req'])) {
  $pageNum_req = $_GET['pageNum_req'];
}
$startRow_req = $pageNum_req * $maxRows_req;

//deal with the search functing
$where_clu = " where iID is not null ";

$cJN="";
$cCName="";
$cCLastName="";
$cAddr="";
$cPhn="";
$cMake="";
$cModel="";
$cIMEI="";
$cClaim="";
$cSbmBy="";
$cMemo="";
$cStatus="";
$cLocation="";

$cMJ = "0";

if(isset($_GET['cJN'])){
	$cJN=$_GET['cJN'];
	$where_clu .= " and cJN like '%". $cJN."%'";
}
if(isset($_GET['cCName'])){
	$cCName=$_GET['cCName'];
	$where_clu .= " and cCName like '%". $cCName."%'";
}
if(isset($_GET['cCLastName'])){
	$cCLastName=$_GET['cCLastName'];
	$where_clu .= " and cCLastName like '%". $cCLastName."%'";
}
if(isset($_GET['cAddr'])){
	$cAddr=$_GET['cAddr'];
	$where_clu .= " and CONCAT(cCAdd1,' ',cCAdd2,' ',cCAdd3) like '%". str_replace(" ","%",$cAddr) ."%'";
}
if(isset($_GET['cPhn'])){
	$cPhn=$_GET['cPhn'];
	$where_clu .= " and (cCHomePhn like '%". $cPhn."%' or cCWorkPhn like '%". $cPhn."%' or cCFax like '%". $cPhn."%')";
}
if(isset($_GET['cMake'])){
	$cMake=$_GET['cMake'];
	$where_clu .= " and cMake like '%". $cMake."%'";
}
if(isset($_GET['cModel'])){
	$cModel=$_GET['cModel'];
	$where_clu .= " and cModel like '%". $cModel."%'";
}
if(isset($_GET['cIMEI'])){
	$cIMEI=$_GET['cIMEI'];
	$where_clu .= " and cIMEI like '%". $cIMEI."%'";
}
if(isset($_GET['cClaim'])){
	$cClaim=$_GET['cClaim'];
	$where_clu .= " and cClaim like '%". $cClaim."%'";
}
if(isset($_GET['cSbmBy'])){
	$cSbmBy=$_GET['cSbmBy'];
	$where_clu .= " and cSbmBy like '%". $cSbmBy."%'";
}

if(isset($_GET['myjob']) && $_GET['myjob']==1){
	$where_clu .= " and cAssign ='". $_SESSION['RP_Username'] ."'";
	$cMJ = "1";
}

if(isset($_GET['cMemo'])){
	$cMemo = $_GET['cMemo'];
	$where_clu .= " and cJN in (select distinct cJN from tbmemo where cContent like '%". $cMemo ."%')";
}

if(isset($_GET['cLocation'])){
	$cLocation = $_GET['cLocation'];
	$where_clu .= " and cLocation like '%". $cLocation ."%'";
}

if(isset($_GET['cStatus'])){
	$cStatus = $_GET['cStatus'];
	$where_clu .= " and cStatus like '%". $cStatus ."%'";
}
//end of search funtion

mysql_select_db($database_localhost, $localhost);
$query_req = "SELECT iID, cJN, cStatus, cLocation, DATE_FORMAT(dtSDate,'%d %b %Y') AS dtSDate, iSbmType, cSbm, cSbmBy, cCName, cCLastName, cMake, cModel, cMemo, cMemoReply, cIsReplyRead, iCrrID, cCrrTrk, tbcourier.name, tbcourier.url FROM tbrepair left join tbcourier on tbrepair.iCrrID=tbcourier.id ".$where_clu." ORDER BY iID DESC";
$query_limit_req = sprintf("%s LIMIT %d, %d", $query_req, $startRow_req, $maxRows_req);
$req = mysql_query($query_limit_req, $localhost) or die(mysql_error());
$row_req = mysql_fetch_assoc($req);

if (isset($_GET['totalRows_req'])) {
  $totalRows_req = $_GET['totalRows_req'];
} else {
  $all_req = mysql_query($query_req);
  $totalRows_req = mysql_num_rows($all_req);
}
$totalPages_req = ceil($totalRows_req/$maxRows_req)-1;

$queryString_req = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_req") == false && 
        stristr($param, "totalRows_req") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_req = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_req = sprintf("&totalRows_req=%d%s", $totalRows_req, $queryString_req);
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
	var JN = MM_findObj('cJN');
	var FN = MM_findObj('cCName');
	var LN = MM_findObj('cCLastName');
	var ADDR = MM_findObj('cCAdd');
	var PHN = MM_findObj('cPhn');
	var MK = MM_findObj('cMake');
	var MDL = MM_findObj('cModel');
	var IMEI = MM_findObj('cIMEI');
	var CLAIM = MM_findObj('cClaim');
	var SBM = MM_findObj('cSbm');
	var MEMO = MM_findObj('cMemo');
	var mj = MM_findObj('myjob');
	var LOCATION = MM_findObj('cLocation');
	var STATUS = MM_findObj('cStatus');
	
	var query="?";
	if(JN.value!="") query+=("cJN="+ JN.value +"&");
	if(FN.value!="") query+=("cCName="+ FN.value +"&");
	if(LN.value!="") query+=("cCLastName="+ LN.value +"&");
	if(ADDR.value!="") query+=("cAddr="+ ADDR.value +"&");
	if(PHN.value!="") query+=("cPhn="+ PHN.value +"&");
	if(MK.value!="") query+=("cMake="+ MK.value +"&");
	if(MDL.value!="") query+=("cModel="+ MDL.value +"&");
	if(IMEI.value!="") query+=("cIMEI="+ IMEI.value +"&");
	if(CLAIM.value!="") query+=("cClaim="+ CLAIM.value +"&");
	if(SBM.value!="") query+=("cSbmBy="+ SBM.value +"&");
	if(SBM.value!="") query+=("cSbmBy="+ SBM.value +"&");
	if(MEMO.value!="") query+=("cMemo="+ MEMO.value +"&");
	if(LOCATION.value!="") query+=("cLocation="+ LOCATION.value +"&");
	if(STATUS.value!="") query+=("cStatus="+ STATUS.value +"&");
	
	//alert(query);
	MM_goToURL('window','req_list_all.php'+ query+'myjob='+ mj.value);
	return;
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
<table width="100%"  border="0" align="center" cellpadding="5" cellspacing="10">
  <tr>
    <td width="29%" class="Mgr_Heading">Repair Requests </td>
    <td width="71%" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0" cellspacing="2" cellpadding="2">
<form method="post" name="fmSch2" id="fmSch2" onSubmit="javascript:do_sch();return false;">
        <tr>
          <td colspan="2">Job Number:
            <input name="cJN" type="text" id="cJN" size="8">&nbsp;&nbsp;&nbsp;&nbsp;First Name:  
            <input name="cCName" type="text" id="cCName" size="15"> 
            &nbsp;&nbsp;&nbsp;Last Name: 
            <input name="cCLastName" type="text" id="cCLastName" size="15">&nbsp;Memo: 
            <input name="cMemo" type="text" id="cMemo" size="17"></td>
        </tr>
        <tr>
          <td colspan="2">Address:
            <input name="cCAdd" type="text" id="cCAdd" size="38"> 
            &nbsp;Phone:
            <input name="cPhn" type="text" id="cPhn" size="20">
            Dealer:
            <input name="cSbm" type="text" id="cSbm" size="14"></td>
        </tr>
        <tr>
          <td>Make:
            <input name="cMake" type="text" id="cMake" size="15">
&nbsp;
            Model:
            <input name="cModel" type="text" id="cModel" size="17">
&nbsp;
            &nbsp;IMEI:
<input name="cIMEI" type="text" id="cIMEI" size="17">
&nbsp;
            &nbsp;Claim No:
<input name="cClaim" type="text" id="cClaim" size="17"></td>
          <td><input type="reset" name="Submit2" value="Clear"></td>
        </tr>
        <tr>
          <td width="75%">Status:
            <select name="cStatus" id="cStatus">
            <option value="S">Any</option>
            <option value="S05">waiting to assign(S05)</option>
            <option value="S10">Inspection(S10)</option>
            <option value="S15">Waiting for parts(S15)</option>
            <option value="S20">Waiting to be confirm(S20)</option>
            <option value="S25">Unserviceable(S25)</option>
            <option value="S30">Repaired(S30)</option>
            <option value="S35">Other(S35)</option>
          </select>
            Location:
              <select name="cLocation" id="cLocation">
            <option value="L"> Any </option>
            <option value="L10">Has been sent to dealer(L10)</option>
            <option value="L15">Ready to be picked upr(L15)</option>
            <option value="L20">Has been picked up/delivered(L20)</option>
            <option value="L25">Keep in lieu of payment(L25)</option>
            <option value="L30">Other (L30)</option>
          </select></td>
          <td width="25%"><input type="submit" name="Submit" value="Search">
            <input name="myjob" type="hidden" id="myjob" value="<?php echo $cMJ;?>">
  try '%' if  not sure </td>
        </tr>
		</form>
      </table></td>
    </tr>
<script language="javascript">
<!--
	var JN = MM_findObj('cJN');
	var FN = MM_findObj('cCName');
	var LN = MM_findObj('cCLastName');
	var ADDR = MM_findObj('cCAdd');
	var PHN = MM_findObj('cPhn');
	var MK = MM_findObj('cMake');
	var MDL = MM_findObj('cModel');
	var IMEI = MM_findObj('cIMEI');
	var CLAIM = MM_findObj('cClaim');
	var SBM = MM_findObj('cSbm');
	var MEMO = MM_findObj('cMemo');
	var LOCATION = MM_findObj('cLocation');
	var STATUS = MM_findObj('cStatus');
	
	JN.value = '<?php echo $cJN;?>';
	FN.value = '<?php echo $cCName;?>';
	LN.value = '<?php echo $cCLastName;?>';
	ADDR.value = '<?php echo $cAddr;?>';
	PHN.value = '<?php echo $cPhn;?>';
	MK.value = '<?php echo $cMake;?>';
	MDL.value = '<?php echo $cModel;?>';
	IMEI.value = '<?php echo $cIMEI;?>';
	CLAIM.value = '<?php echo $cClaim;?>';
	SBM.value = '<?php echo $cSbmBy;?>';
	MEMO.value = '<?php echo $cMemo;?>';
	LOCATION.value = '<?php echo $cLocation;?>';
	STATUS.value = '<?php echo $cStatus;?>';
//-->
</script>
</table>
<?php 
//Delivery Order
$chkout = "";
if(isset($_SESSION['JNsEDIT']) && $_SESSION['JNsEDIT']=="YES"){
	$chkout = "do_edit.php?iID=".$_SESSION['DOID'];
}else{
	$chkout = "do_add.php";
}
$str_do = (isset($_SESSION['JNs']))?$_SESSION['JNs']:"";
$qty = substr_count($str_do, " ");
?>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="10">
  <tr>
    <td width="63%">* <strong>F</strong>=Service Request Form; <strong>T</strong>=Service Tracking Pages; <strong>R</strong>=Service Report; <strong>D</strong>=Discount; <strong>L</strong>=Logs </td>
    <td width="37%"><strong><span id="qty" style="color:#FF0000"><?php echo $qty;?></span></strong> items in Delivery Order 
      <input type="button" name="Submit3" value="Checkout" onClick="javascript:document.location = '<?php echo $chkout;?>';">
      <input type="reset" name="Submit4" value="Empty" onClick="javascript:des();"></td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%"  border="0" align="center" cellpadding="5" cellspacing="0">
      <tr class="font_white_9bold" align="center">
        <td width="80" background="../manage/images/m_tb_head.gif" class="right_solid_1">Job No.</td>
        <td width="90" background="../manage/images/m_tb_head.gif" class="right_solid_1">Submitted By</td>
        <td width="93" background="../manage/images/m_tb_head.gif" class="right_solid_1">Customer</td>
        <td width="81" background="../manage/images/m_tb_head.gif" class="right_solid_1">Make</td>
        <td width="85" background="../manage/images/m_tb_head.gif" class="right_solid_1">Model</td>
        <td width="167" background="../manage/images/m_tb_head.gif" class="right_solid_1">Status</td>
        <td width="160" background="../manage/images/m_tb_head.gif" class="right_solid_1">Location</td>
        <td width="93" background="../manage/images/m_tb_head.gif" class="right_solid_1">Submit Date</td>
        <td width="49" background="../manage/images/m_tb_head.gif" class="right_solid_1">Opr</td>
      </tr>
      <?php
   $col = "#FFFFFF";
    do { ?>
      <tr bgcolor="<?php echo $col;?>" class="font_red_12">
        <td bgcolor="<?php echo $col;?>" class="right_solid_2">
		<a href="srf.php?cJN=<?php echo $row_req['cJN']; ?>"><?php echo $row_req['cJN']; ?></a>
		<?php 
		if($row_req['cStatus']=='S25' ||$row_req['cStatus']=='S30' ||$row_req['cStatus']=='S35'){
		?>
		<input name="cb<?php echo $row_req['cJN']; ?>" type="checkbox" onClick="javascript:ds(this);"  value="<?php echo $row_req['cJN']; ?>" <?php echo (strstr($str_do, $row_req['cJN']))?"checked":"";?>>
		<? }?></td>
        <td class="right_solid_2"><?php echo $row_req['cSbmBy']; ?></td>
        <td class="right_solid_2"><?php echo $row_req['cCName']. " " . $row_req['cCLastName']; ?></td>
        <td class="right_solid_2"><?php echo $row_req['cMake']; ?></td>
        <td class="right_solid_2"><?php echo $row_req['cModel']; ?></td>
        <td class="right_solid_2"><?php echo getStatus($row_req['cStatus']); ?>
            <?php
	if($row_req['cMemo']!= null && $row_req['cMemo']!= ""){
	?>
            <img src="images/button_edit.png" alt="<?php echo $row_req['cMemo'];?>">
            <?php
	}
	if($row_req['cMemoReply']!=null && $row_req['cIsReplyRead']!= "checked"){
	?><img src="images/speaker_icon2.gif" width="16" height="16" hspace="2" vspace="2" align="absbottom">
            <?php
	}
	?>        </td>
        <td class="right_solid_2"><?php echo getLocation($row_req['cLocation']); ?>
		<?php
		if($row_req['iCrrID'] != null && strlen($row_req['cCrrTrk']) > 0){
		?>
		<br><a href="http://<?php echo $row_req['url'];?>" target="_blank" title="<?php echo $row_req['name'];?>">Trk #: <?php echo $row_req['cCrrTrk'];?></a><?php }?></td>
        <td class="right_solid_2"><?php echo $row_req['dtSDate']; ?></td>
        <td><a href="srf.php?cJN=<?php echo $row_req['cJN']; ?>">F</a> <a href="rtp.php?cJN=<?php echo $row_req['cJN']; ?>">T</a>
            <?php
	if($row_req['cStatus']=='S25' || $row_req['cStatus']=='S30' || $row_req['cStatus']=='S35'){
	?>
            <a href="sri.php?cJN=<?php echo $row_req['cJN']; ?>" target="_blank">R</a> <a href="disc.php?cJN=<?php echo $row_req['cJN']; ?>" target="_blank">D</a>
            <?php }?>
            <a href="de_srf_2c.php?cJN=<?php echo $row_req['cJN']; ?>">S</a> 
			<a href="log.php?cJN=<?php echo $row_req['cJN']; ?>">L</a> </td>
      </tr>
      <?php
  		if($col == "#FFFFFF"){
			$col = "#E3E3E3";
		}else{
			$col = "#FFFFFF";
		}
    } while ($row_req = mysql_fetch_assoc($req)); ?>
      <tr>
        <td colspan="10" bgcolor="<?php echo $col?>">
          <table border="0" width="50%" align="center">
            <tr>
              <td width="23%" align="center">
                <?php if ($pageNum_req > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_req=%d%s", $currentPage, 0, $queryString_req); ?>">First</a>
                <?php } // Show if not first page ?>              </td>
              <td width="31%" align="center">
                <?php if ($pageNum_req > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_req=%d%s", $currentPage, max(0, $pageNum_req - 1), $queryString_req); ?>">Previous</a>
                <?php } // Show if not first page ?>              </td>
              <td width="23%" align="center">
                <?php if ($pageNum_req < $totalPages_req) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_req=%d%s", $currentPage, min($totalPages_req, $pageNum_req + 1), $queryString_req); ?>">Next</a>
                <?php } // Show if not last page ?>              </td>
              <td width="23%" align="center">
                <?php if ($pageNum_req < $totalPages_req) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_req=%d%s", $currentPage, $totalPages_req, $queryString_req); ?>">Last</a>
                <?php } // Show if not last page ?>              </td>
            </tr>
        </table></td>
      </tr>
    </table></td>
    </tr>
</table>
<script id="dosession"></script>
<script language="javascript">
<!--
//Delivery Session
function ds(cb){
	//alert("here.");
	if(cb == null) return false;
	var obj = MM_findObj("dosession");
	set = 0;
	//if(cb.checked){
	if(cb.checked == true){
		set = 1;
	}
	//alert(set);
	obj.src= "do_session.php?cJN="+cb.value+"&set="+set;
}

//Delivery Empty Session
function des(){
	if(!cfm()) return false;
	var obj = MM_findObj("dosession");
	obj.src= "do_empty_session.php";
}
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
?>
