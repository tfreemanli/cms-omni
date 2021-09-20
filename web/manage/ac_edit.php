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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE tbanm SET cPC=%s, cDesc=%s, cBrand=%s, cType=%s, cModel=%s, cPrice1=%s, cPrice2=%s, cWrty=%s, cInStk=%s WHERE iID=%s",
                       GetSQLValueString($_POST['cPC'], "text"),
                       GetSQLValueString($_POST['cDesc'], "text"),
                       GetSQLValueString($_POST['cBrand'], "text"),
                       GetSQLValueString($_POST['cType'], "text"),
                       GetSQLValueString($_POST['cModel'], "text"),
                       GetSQLValueString($_POST['cPrice1'], "text"),
                       GetSQLValueString($_POST['cPrice2'], "text"),
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

function ac_del(){
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
      <td width="82%" class="Mgr_Heading">Accessories</td>
      <td width="18%" align="center" class="td_block"><a href="ac_list.php">&lt;&lt; Back to list</a> </td>
    </tr>
  </table>
  <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="10">
    <tr>
      <td>        <table width="100%"  border="0" cellpadding="5" cellspacing="2" bgcolor="#CADB2A">
          <form name="form3" enctype="multipart/form-data" method="POST" action="ac_del.php">
            <tr>
              <td width="54%" height="31"><span class="font_white_9bold">■ Delete the product </span></td>
              <td width="46%" align="right"><input name="img" type="hidden" id="img4" value="<?php echo $row_RS1['cImg']; ?>">
                  <input name="iID3" type="hidden" id="iID34" value="<?php echo $row_RS1['iID']; ?>">
                  <input type="button" name="Submit32" value="Delete" onClick="javascript:ac_del();"></td>
            </tr>
            <input type="hidden" name="MM_update3" value="form3">
          </form>
        </table>
        <br>
        <table width="100%"  border="0" cellpadding="2" cellspacing="1">
          <form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1">
            <tr bgcolor="#CADB2A">
              <td colspan="4" class="font_white_9bold"><img src="images/1x1.gif" width="1" height="1" hspace="2" vspace="10" align="absmiddle">Modify the product information </td>
            </tr>
            <tr>
              <td width="103" align="right" class="td_block">Product Code</td>
              <td width="232">
                <input name="cPC" type="text" class="ipt_normal" id="cPC" value="<?php echo $row_RS1['cPC']; ?>"></td>
              <td width="87" rowspan="8" align="right" class="td_block">Description</td>
              <td width="334" rowspan="8"><textarea name="cDesc" wrap="VIRTUAL" class="text_normal" id="textarea2"><?php echo $row_RS1['cDesc']; ?></textarea></td>
            </tr>
            <tr>
              <td align="right" class="td_block">Brand</td>
              <td><select name="cBrand" class="ipt_normal" id="cBrand">
                  <option value="ALL BRANDS">ALL BRANDS</option>
                  <option value="ALCATEL">ALCATEL</option>
                  <option value="IPOD">IPOD</option>
                  <option value="KYOCERA">KYOCERA</option>
                  <option value="Motorola">Motorola</option>
                  <option value="Nokia">Nokia</option>
                  <option value="Panasonic">Panasonic</option>
                  <option value="Samsung">Samsung</option>
                  <option value="SAGEM">SAGEM</option>
                  <option value="SANDISK">SANDISK</option>
                  <option value="SANYO">SANYO</option>
                  <option value="Sharp">Sharp</option>
                  <option value="Siemens">Siemens</option>
                  <option value="Sony">Sony</option>
                  <option value="Sony Ericsson">Sony Ericsson</option>
                  <option value="MISC">MISC</option>
                </select>
                  <script language="javascript">
	  <!--//
	  var obj = MM_findObj('cBrand');
	  obj.value = "<?php echo $row_RS1['cBrand']; ?>";
	  //-->
	      </script></td>
            </tr>
            <tr>
              <td align="right" class="td_block">Type</td>
              <td><select name="cType" class="ipt_normal" id="cType">
                  <option value="Battery">Battery</option>
                  <option value="Bluetooth Devices">Bluetooth Devices</option>
                  <option value="Car Chargers">Car Chargers</option>
                  <option value="Covers-Leather">Covers-Leather</option>
                  <option value="Covers-Cases">Covers-Cases</option>
                  <option value="Covers-Skins">Covers-Skins</option>
                  <option value="Covers-Silicon">Covers-Silicon</option>
                  <option value="Head Devices">Head Devices</option>
                  <option value="Wall Chargers">Wall Chargers</option>
                  <option value="MISC">MISC</option>
                </select>
                  <script language="javascript">
	  <!--//
	  var obj = MM_findObj('cType');
	  obj.value = "<?php echo $row_RS1['cType']; ?>";
	  //-->
	      </script></td>
            </tr>
            <tr>
              <td align="right" class="td_block">Model</td>
              <td><input name="cModel" type="text" class="ipt_normal" id="cModel2" value="<?php echo $row_RS1['cModel']; ?>"></td>
            </tr>
            <tr>
              <td align="right" class="td_block">Price1</td>
              <td><input name="cPrice1" type="text" class="ipt_normal" id="cPrice1" value="<?php echo $row_RS1['cPrice1']; ?>"></td>
            </tr>
            <tr>
              <td align="right" class="td_block">Price2</td>
              <td><input name="cPrice2" type="text" class="ipt_normal" id="cPrice2" value="<?php echo $row_RS1['cPrice2']; ?>"></td>
            </tr>
            <tr>
              <td align="right" class="td_block">Warranty</td>
              <td><input name="cWrty" type="text" class="ipt_normal" id="cWrty2" value="<?php echo $row_RS1['cWrty']; ?>"></td>
            </tr>
            <tr>
              <td align="right" class="td_block">In Stock </td>
              <td><input name="cInStk" type="text" class="ipt_normal" id="cInStk" value="<?php echo $row_RS1['cInStk']; ?>"></td>
            </tr>
            <tr>
              <td colspan="4" align="center" valign="top" class="font_white_9bold"><input name="Submit" type="submit" class="btn" onClick="MM_validateForm('cPC','','R','cModel2','','R','cPrice2','','R','cWrty2','','R','cInStk','','R','textarea2','','R');return document.MM_returnValue" value="Submit">
                  <input name="Submit2" type="reset" class="btn" value="Reset">
                  <input name="iID" type="hidden" id="iID3" value="<?php echo $row_RS1['iID']; ?>"></td>
            </tr>
            <tr>
              <td colspan="4" class="font_white_9bold">&nbsp;</td>
            </tr>
            <input type="hidden" name="MM_update" value="form1">
          </form>
        </table>
        <table width="100%"  border="0" cellpadding="5" cellspacing="2">
          <form name="form2" enctype="multipart/form-data" method="POST" action="<?php echo $editFormAction; ?>">
            <tr bgcolor="#CADB2A">
              <td colspan="2" class="font_white_9bold">Replace the product image</td>
            </tr>
            <tr>
              <td width="57%" height="31" align="center" valign="top">
                <input name="cImg" type="file" id="cImg">
                <input name="oldimg" type="hidden" id="oldimg" value="<?php echo $row_RS1['cImg']; ?>">
                <input name="iID" type="hidden" id="iID" value="<?php echo $row_RS1['iID']; ?>">
                <input type="submit" name="Submit3" onClick="MM_validateForm('cImg','','R');return document.MM_returnValue"  value="Submit">
                <br>
                <br>
        *recommend 200x200 px</td>
              <td width="43%"><img src="../productimg/<?php echo $row_RS1['cImg']?>" width="200" height="200" ></td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="top">&nbsp;</td>
            </tr>
            <input type="hidden" name="MM_update" value="form2">
          </form>
        </table></td>
      </tr>
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
<?php
mysql_free_result($RS1);
?>
