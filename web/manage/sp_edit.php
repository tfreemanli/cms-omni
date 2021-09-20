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
	
	//set ShowIndex
	if(isset($_POST['iShowIndex']) && $_POST['iShowIndex']!=0){
		  $strSQL = "update tbanm set iShowIndex=0 where iAorM='". $_POST['iAorM'] ."' and iShowIndex='".$_POST['iShowIndex']."'";
		  mysql_select_db($database_localhost, $localhost);
		  $Result1 = mysql_query($strSQL, $localhost);
	}
	//end set ShowIndex

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE tbanm SET cPC=%s, iShowIndex=%s, cDesc=%s, cBrand=%s, cType=%s, cModel=%s, cPrice1=%s, cWrty=%s, cInStk=%s WHERE iID=%s",
                       GetSQLValueString($_POST['cPC'], "text"),
                       GetSQLValueString($_POST['iShowIndex'], "int"),
                       GetSQLValueString($_POST['cDesc'], "text"),
                       GetSQLValueString($_POST['cBrand'], "text"),
                       GetSQLValueString($_POST['cType'], "text"),
                       GetSQLValueString($_POST['cModel'], "text"),
                       GetSQLValueString($_POST['cPrice1'], "text"),
                       GetSQLValueString($_POST['cWrty'], "text"),
                       GetSQLValueString($_POST['cInStk'], "text"),
                       GetSQLValueString($_POST['iID'], "int"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
	
	
	$errorMsg = "";
	//modi by freeman for file upload
	$file_size_max = 102400;
	// 限制文件上传最大容量(bytes)
	$files_mimes = array('image/jpg','image/gif','image/pjpeg','image/jpeg');	
	$files_exts　= array('.jpg','.gif','.jpeg');
	
	$store_dir = "../productimg/";
	// 上传文件的储存位置
	$accept_overwrite = true;
	//允许读写文件
	
	
	$tmp=$_FILES['cImg']['tmp_name'];
	
	if($tmp && ($tmp != "")){
		// 检查文件大小
		if ($cImg_size > $file_size_max) {
			$errorMsg =  "Sorry, the uploaded file exceeds ".$file_size_max." byte";
			header(sprintf("Location: %s", "error.php?info=".$errorMsg));
			exit;
		}
		
		//echo $cImg_type;
		
		if (!in_array($cImg_type, $files_mimes)) {
			$errorMsg =  "Sorry, only image file is allowed to be uploaded";
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
	
	
	if (($_POST['oldimg'] != "1x1.gif") && file_exists("../productimg/".$_POST['oldimg'])){
		unlink("../productimg/".$_POST['oldimg']);
	}
	
  $updateSQL = sprintf("UPDATE tbanm SET cImg=%s WHERE iID=%s",
                       GetSQLValueString($newname, "text"),
                       GetSQLValueString($_POST['iID'], "int"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());
}

$colname_RS1 = "1";
if (isset($_GET['iID'])) {
  $colname_RS1 = (get_magic_quotes_gpc()) ? $_GET['iID'] : addslashes($_GET['iID']);
}
mysql_select_db($database_localhost, $localhost);
$query_RS1 = sprintf("SELECT * FROM tbanm WHERE iID = %s", $colname_RS1);
$RS1 = mysql_query($query_RS1, $localhost) or die(mysql_error());
$row_RS1 = mysql_fetch_assoc($RS1);
$totalRows_RS1 = mysql_num_rows($RS1);
?>

<html><!-- InstanceBegin template="/Templates/tpl_manage.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>manage pages</title>
<script language="javascript">
<!--

function ev_del(){
	if(cfm()){
		var fm = MM_findObj('form3');
		fm.submit();
		//alert('yes ticked.');
		return true;
	}
	return false;
}
//-->
</script>
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
    <td width="82%" class="Mgr_Heading">&nbsp;</td>
    <td width="18%" align="center" class="td_block"><a href="sp_list.php">&lt;&lt; Back to list</a></td>
  </tr>
</table>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="10">
  <tr>
    <td><table width="530"  border="0" cellpadding="2" cellspacing="1">
        <form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1">
          <tr bgcolor="#CADB2A">
            <td colspan="4" class="font_white_9bold"><img src="images/1x1.gif" width="1" height="1" hspace="2" vspace="10" align="absmiddle">Modify the SPECIAL PROMOTION </td>
          </tr>
          <tr>
            <td width="92" align="right" class="td_block">Content</td>
            <td width="623"><textarea name="cDesc" wrap="VIRTUAL" class="text_normal" id="Content"><?php echo $row_RS1['cDesc']; ?></textarea></td>
          </tr>
          <tr>
            <td colspan="4" align="center" valign="top"><input name="Submit" type="submit" class="btn" onClick="MM_validateForm('Content','','R');return document.MM_returnValue" value="Submit">
                <input name="Submit2" type="reset" class="btn" value="Reset">
				<input name="iAorM" type="hidden" id="iAorM" value="4">
              <input name="iShowIndex" type="hidden" id="iShowIndex" value="1">
<input name="iID" type="hidden" id="iID3" value="<?php echo $row_RS1['iID']; ?>">
                <input name="cBrand" type="hidden" class="ipt_normal" id="cBrand2" value="<?php echo $row_RS1['cBrand']; ?>">
                <input name="cType" type="hidden" class="ipt_normal" id="cType" value="<?php echo $row_RS1['cType']; ?>">
                <input name="cModel" type="hidden" class="ipt_normal" id="cModel" value="<?php echo $row_RS1['cModel']; ?>">
                <input name="cPrice1" type="hidden" class="ipt_normal" id="cPrice1" value="<?php echo $row_RS1['cPrice1']; ?>">
                <input name="cWrty" type="hidden" class="ipt_normal" id="cWrty" value="<?php echo $row_RS1['cWrty']; ?>">
                <input name="cInStk" type="hidden" class="ipt_normal" id="cInStk2" value="<?php echo $row_RS1['cInStk']; ?>">
                <input name="cPC" type="hidden" class="ipt_normal" id="Title" value="<?php echo $row_RS1['cPC']; ?>"></td>
          </tr>
          <tr>
            <td colspan="4" class="font_white_9bold">&nbsp;</td>
          </tr>
          <input type="hidden" name="MM_update" value="form1">
        </form>
      </table>
      </td></tr>
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
<?php
mysql_free_result($RS1);
?>
