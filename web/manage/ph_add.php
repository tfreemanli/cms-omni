<?php require_once('../Connections/localhost.php'); ?>
<?php session_start();?>
<?php 

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

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['AC_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['AC_Username'], $_SESSION['AC_UserGroup'])))) {   
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

	$errorMsg = "";
	//modi by freeman for file upload
	$file_size_max = 102400;
	// 限制文件上传最大容量(bytes)
	$store_dir = "../productimg/";
	// 上传文件的储存位置
	$accept_overwrite = true;
	//允许读写文件
	// 检查文件大小
	if ($cImg_size > $file_size_max) {
		$errorMsg =  "Sorry, the uploaded file exceeds ".$file_size_max." byte";
	    header(sprintf("Location: %s", "error.php?info=".$errorMsg));
		exit;
	}
	// 检查读写文件
	if (file_exists($store_dir . $cImg_name) && !$accept_overwrite) {
		$errorMsg =  "The same file exists. pls upload again.";
	    header(sprintf("Location: %s", "error.php?info=".$errorMsg));
		exit;
	}
	//复制文件到指定目录
	//$newname = $_POST['dtDate']. $_POST['cBD']. "." .preg_replace('/.*\.(.*[^\.].*)*/iU','\\1',$upload_file_name);
	$newname = date('YmdHis').rand(0,9)."." .preg_replace('/.*\.(.*[^\.].*)*/iU','$1',$cImg_name);
	if (! @ copy($cImg,$store_dir . $newname)) {
		$errorMsg =  "Upload fail.";
	    header(sprintf("Location: %s", "error.php?info=".$errorMsg));
		exit;
	}
	
	//end file upload
	
	//set ShowIndex
	if(isset($_POST['iShowIndex']) && $_POST['iShowIndex']!=0){
		  $strSQL = "update tbphone set iShowIndex=0 where iShowIndex='".$_POST['iShowIndex']."'";
		  mysql_select_db($database_localhost, $localhost);
		  $Result1 = mysql_query($strSQL, $localhost);
	}
	//end set ShowIndex
	
  $insertSQL = sprintf("INSERT INTO tbphone (cPC, iShowIndex, cFeature, cBrand, cModel, cNetwork, cSize, cWeight, cDisplay, cRT, cMem, cBattery, cStandby, cTTime, cPrice1, cPrice2, cInStk, cWrty, cImg, cIs3G, dtDate) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, now())",
                       GetSQLValueString($_POST['cPC'], "text"),
                       GetSQLValueString($_POST['iShowIndex'], "int"),
                       GetSQLValueString($_POST['cFeature'], "text"),
                       GetSQLValueString($_POST['cBrand'], "text"),
                       GetSQLValueString($_POST['cModel'], "text"),
                       GetSQLValueString($_POST['cNetwork'], "text"),
                       GetSQLValueString($_POST['cSize'], "text"),
                       GetSQLValueString($_POST['cWeight'], "text"),
                       GetSQLValueString($_POST['cDisplay'], "text"),
                       GetSQLValueString($_POST['cRT'], "text"),
                       GetSQLValueString($_POST['cMem'], "text"),
                       GetSQLValueString($_POST['cBattery'], "text"),
                       GetSQLValueString($_POST['cStandby'], "text"),
                       GetSQLValueString($_POST['cTTime'], "text"),
                       GetSQLValueString($_POST['cPrice1'], "text"),
                       GetSQLValueString($_POST['cPrice2'], "text"),
                       GetSQLValueString($_POST['cInStk'], "text"),
                       GetSQLValueString($_POST['cWrty'], "text"),
                       GetSQLValueString($newname, "text"),
                       GetSQLValueString(isset($_POST['cIs3G']) ? "true" : "", "defined","'checked'","' '"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($insertSQL, $localhost) or die(mysql_error());

  $insertGoTo = "ph_list.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>

<html><!-- InstanceBegin template="/Templates/tpl_manage.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>manage pages</title>
<!-- InstanceEndEditable --> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="javascript" src="../js/common.js"></script>
<!-- InstanceBeginEditable name="head" -->
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
//-->
</script>
<!-- InstanceEndEditable -->
<link href="css.css" rel="stylesheet" type="text/css">
</head>

<body>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" background="images/m_top_bg.gif">
  <tr>
    <td><img src="../images/backg-top.gif" width="61" height="24"></td>
    <td width="114" rowspan="2" valign="top"><table width="114" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="114"><img src="images/m_top_right.gif" width="114" height="71"></td>
        </tr>
        <tr>
          <td width="114" height="18" background="images/m_topright_bg.gif"><table width="108" border="0" cellspacing="0" cellpadding="0">
              <tr align="center">
                <td width="38">help</td>
                <td width="70">contact us </td>
              </tr>
          </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><img src="images/m_logo.gif" width="261" height="65"></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="1%"><img src="images/m_top_bar_left.gif" width="28" height="22"></td>
    <td width="98%" background="images/m_top_bar_cen.gif">&nbsp;</td>
    <td width="1%"><img src="images/m_top_bar_right.gif" width="24" height="22"></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="195" valign="top" background="images/m_mid_leftbg.gif"><br>
      <?php include('inc_menu.php');?>
<p>&nbsp;</p>
<p>&nbsp;</p><p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p></td>
    <td width="797" valign="top" bgcolor="#FFFFFF"><!-- InstanceBeginEditable name="main" -->
<br>
<table width="100%"  border="0" align="center" cellpadding="5" cellspacing="10">
  <tr>
    <td width="82%" class="Mgr_Heading">Mobile Phone</td>
    <td width="18%" align="center" class="td_block"><a href="ph_list.php">&lt;&lt; Back to list</a> </td>
  </tr>
</table>
<br>
<table width="98%"  border="0" align="center" cellpadding="2" cellspacing="1">
<form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1">
  <tr>
    <td width="113" align="right">Brand</td>
    <td width="226"><select name="cBrand" class="ipt_normal" id="cBrand">
      <option value="Nokia">Nokia</option>
      <option value="Samsung">Samsung</option>
      <option value="Motorola">Motorola</option>
      <option value="Sony Ericsson">Sony Ericsson</option>
      <option value="LG">LG</option>
      <option value="Alcatel">Alcatel</option>
      <option value="Panasonic">Panasonic</option>
      <option value="BenQ-Siemens">BenQ-Siemens</option>
      <option value="Siemens">Siemens</option>
      <option value="BenQ">BenQ</option>
      <option value="Philips">Philips</option>
      <option value="NEC">NEC</option>
      <option value="Sagem">Sagem</option>
      <option value="Sharp">Sharp</option>
      <option value="Toshiba">Toshiba</option>
      <option value="Pantech">Pantech</option>
      <option value="VK Mobile">VK Mobile</option>
      <option value="Palm">Palm</option>
      <option value="HTC">HTC</option>
      <option value="Qtek">Qtek</option>
      <option value="i-mate">i-mate</option>
      <option value="O2">O2</option>
      <option value="BlackBerry">BlackBerry</option>
      <option value="Haier">Haier</option>
      <option value="Bird">Bird</option>
      <option value="Eten">Eten</option>
      <option value="HP">HP</option>
      <option value="XCute">XCute</option>
      <option value="Asus">Asus</option>
      <option value="Gigabyte">Gigabyte</option>
      <option value="Apple">Apple</option>
      <option value="Vodafone">Vodafone</option>
      <option value="T-Mobile">T-Mobile</option>
      <option value="i-mobile">i-mobile</option>
    </select></td>
    <td width="92" align="right">Model</td>
    <td width="325"><input name="cModel" type="text" class="ipt_normal" id="cModel"></td>
    </tr>
  <tr>
    <td align="right">3G:</td>
    <td colspan="2"><input name="cIs3G" type="checkbox" id="cIs3G" value="checked">
      <input name="cPC" type="hidden" class="ipt_normal" id="cPC">
      <input name="cNetwork" type="hidden" class="ipt_normal" id="cNetwork">
      <input name="cSize" type="hidden" class="ipt_normal" id="cSize">
      <input name="cDisplay" type="hidden" class="ipt_normal" id="cDisplay">
      <input name="cRT" type="hidden" class="ipt_normal" id="cRT">
      <input name="cWeight" type="hidden" class="ipt_normal" id="cWeight2">
      <input name="cMem" type="hidden" class="ipt_normal" id="cMem2">
      <input name="cTTime" type="hidden" class="ipt_normal" id="cTTime2">
      <input name="cBattery" type="hidden" class="ipt_normal" id="cBattery">
      <input name="cPrice1" type="hidden" class="ipt_normal" id="cPrice1">
      <input name="cWrty" type="hidden" class="ipt_normal" id="cWrty2">
      <input name="cStandby" type="hidden" class="ipt_normal" id="cStandby">
      <input name="cPrice2" type="hidden" class="ipt_normal" id="cPrice2">
      <input name="cInStk" type="hidden" class="ipt_normal" id="cInStk2"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Image:</td>
    <td colspan="2"><input name="cImg" type="file" id="cImg2"></td>
    <td>*recommend 140x186 px</td>
  </tr>
  <tr>
    <td align="right">Features</td>
    <td colspan="3"><textarea name="cFeature" wrap="VIRTUAL" class="text_normal" id="cFeature"></textarea></td>
  </tr>
  <tr>
    <td align="right" class="font_white_9bold">&nbsp;</td>
    <td colspan="3"><input name="Submit" type="submit" class="btn" onClick="MM_validateForm('cModel','','R');return document.MM_returnValue" value="Submit">
      <input name="Submit2" type="reset" class="btn" value="Reset">
      <select name="iShowIndex">
        <option value="0" selected>NOT</option>
        <option value="2">1st</option>
        <option value="1">2nd</option>
      </select>
      Show on Homepage      </td>
  </tr>
  <input type="hidden" name="MM_insert" value="form1">
</form>
</table>
<!-- InstanceEndEditable --></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="200" background="images/m_btm.gif">&nbsp;</td>
    <td align="right" background="images/m_btm_bg.gif"><p><img src="images/m_btm_right.gif" width="667" height="52"></p></td>
  </tr>
</table>
</body>
<!-- InstanceEnd --></html>
