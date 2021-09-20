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
  $updateSQL = sprintf("UPDATE tbwebinfo SET tbwebinfo.desc=%s WHERE title='ldpd'", GetSQLValueString($_POST['desc'], "text"));
  
  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());
}


$colname_RS1 = "1";
if (isset($_GET['t'])) {
  $colname_RS1 = (get_magic_quotes_gpc()) ? $_GET['t'] : addslashes($_GET['t']);
}
mysql_select_db($database_localhost, $localhost);
$query_RS1 = sprintf("SELECT * FROM tbwebinfo WHERE title = 'ldpd'");
$RS1 = mysql_query($query_RS1, $localhost) or die(mysql_error());
$row_RS1 = mysql_fetch_assoc($RS1);
$totalRows_RS1 = mysql_num_rows($RS1);
?>

<html><!-- InstanceBegin template="/Templates/tpl_manage.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>manage pages</title>
<script language="javascript" type="text/javascript" src="../js/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
   tinyMCE.init({
      	mode : "textareas",
      	theme : "advanced",
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough, separator, forecolor,fontselect,fontsizeselect",
　　theme_advanced_buttons2_add_before: "cut,copy,paste,separator",
　　theme_advanced_buttons2 : "undo,redo,separator,hr,link,unlink,image,separator",
　　theme_advanced_buttons2_add :"code",
　　theme_advanced_buttons3 : "",
　　theme_advanced_toolbar_location : "top",
　　theme_advanced_toolbar_align : "default",
　　relative_urls : false,
　　remove_script_host : false
   });
</script>
<!-- /tinyMCE -->
<!-- tinyMCE -->
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
    <td width="18%" align="center">&nbsp;</td>
  </tr>
</table>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="10">
  <tr>
    <td><table width="530"  border="0" cellpadding="2" cellspacing="1">
        <form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1">
          <tr bgcolor="#CADB2A">
            <td colspan="4" class="font_white_9bold"><img src="images/1x1.gif" width="1" height="1" hspace="2" vspace="10" align="absmiddle">Modify the LIQUID DAMAGED PHONE DISCLAIMER </td>
          </tr>
          <tr>
            <td width="79" align="right" valign="top" class="td_block">Content</td>
            <td width="440"><textarea name="desc" wrap="VIRTUAL" id="desc" style="width:450px; height:800px;"><?php echo $row_RS1['desc']; ?></textarea></td>
          </tr>
          <tr>
            <td colspan="4" align="center" valign="top"><input name="Submit" type="submit" class="btn" onClick="MM_validateForm('desc','','R');return document.MM_returnValue" value="Submit">
                <input name="Submit2" type="reset" class="btn" value="Reset">
<input name="id" type="hidden" id="id" value="<?php echo $row_RS1['id']; ?>">
                <input name="title" type="hidden" class="ipt_normal" id="title" value="<?php echo $row_RS1['title']; ?>"></td>
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
