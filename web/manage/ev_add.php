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
	
	$tmp=$_FILES['cImg']['tmp_name'];
	
	if($tmp && ($tmp != "")){
	
		//echo "upload";
		//exit;
		
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
		$newname = date('YmdHis').rand(0,9)."." .preg_replace('/.*\.(.*[^\.].*)*/iU','\\1',$cImg_name);
		if (! @ copy($cImg,$store_dir . $newname)) {
			$errorMsg =  "Upload fail.";
			header(sprintf("Location: %s", "error.php?info=".$errorMsg));
			exit;
		}
	}else{
		$newname = "1x1.gif";
	}
	
	//end file upload
	
	//set ShowIndex
	if(isset($_POST['iShowIndex']) && $_POST['iShowIndex']!=0){
		  $strSQL = "update tbanm set iShowIndex=0 where iAorM='". $_POST['iAorM'] ."' and iShowIndex='".$_POST['iShowIndex']."'";
		  mysql_select_db($database_localhost, $localhost);
		  $Result1 = mysql_query($strSQL, $localhost);
	}
	//end set ShowIndex
	
  $insertSQL = sprintf("INSERT INTO tbanm (iAorM, cPC, iShowIndex, cDesc, cBrand, cType, cModel, cPrice1, cWrty, cInStk, cImg, dtDate) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, now())",
                       GetSQLValueString($_POST['iAorM'], "int"),
                       GetSQLValueString($_POST['cPC'], "text"),
                       GetSQLValueString($_POST['iShowIndex'], "int"),
                       GetSQLValueString($_POST['cDesc'], "text"),
                       GetSQLValueString($_POST['cBrand'], "text"),
                       GetSQLValueString($_POST['cType'], "text"),
                       GetSQLValueString($_POST['cModel'], "text"),
                       GetSQLValueString($_POST['cPrice1'], "text"),
                       GetSQLValueString($_POST['cWrty'], "text"),
                       GetSQLValueString($_POST['cInStk'], "text"),
                       GetSQLValueString($newname, "text"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($insertSQL, $localhost) or die(mysql_error());

  $insertGoTo = "ev_list.php";
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
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
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
    <td width="82%" class="Mgr_Heading">Events</td>
    <td width="18%" align="center" class="td_block"><a href="ev_list.php">&lt;&lt; Back to list</a> </td>
  </tr>
</table>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="10">
  <tr>
    <td><table width="530"  border="0" cellpadding="2" cellspacing="1">
      <form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1">
        <tr>
          <td width="54" align="right" class="td_block">Title</td>
          <td width="154">
            <input name="cPC" type="text" class="ipt_normal" id="cPC"></td>
          <td width="45" align="right" class="td_block">Image</td>
          <td width="256"><input name="cImg" type="file" id="cImg2"></td>
        </tr>
        <tr>
          <td align="right" class="td_block">Content</td>
          <td colspan="3"><textarea name="cDesc" wrap="VIRTUAL" class="text_normal" id="cDesc"></textarea></td>
        </tr>
        <tr>
          <td align="right" class="font_white_9bold">&nbsp;</td>
          <td colspan="3"><input name="Submit" type="submit" class="btn" onClick="MM_validateForm('cPC','','R','cDesc','','R');return document.MM_returnValue" value="Submit">
              <input name="Submit2" type="reset" class="btn" value="Reset">
              <select name="iShowIndex">
                <option value="0" selected>NOT</option>
                <option value="3">1st</option>
                <option value="2">2nd</option>
                <option value="1">3rd</option>
              </select>
Show on Homepage
<input name="iAorM" type="hidden" id="iAorM" value="3">
              <input name="cBrand" type="hidden" class="ipt_normal" id="cBrand" value="b">
              <input name="cType" type="hidden" class="ipt_normal" id="cType2" value="t">
              <input name="cModel" type="hidden" class="ipt_normal" id="cModel2" value="m">
              <input name="cPrice1" type="hidden" class="ipt_normal" id="cPrice1" value="0">
              <input name="cWrty" type="hidden" class="ipt_normal" id="cWrty2" value="w">
              <input name="cInStk" type="hidden" class="ipt_normal" id="cInStk2" value="i"></td>
        </tr>
        <input type="hidden" name="MM_insert" value="form1">
      </form>
    </table></td>
    </tr>
</table>
<br>
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
