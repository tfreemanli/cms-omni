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
<html>
<head>
<!-- TemplateBeginEditable name="doctitle" -->
<title>manage pages</title>
<!-- TemplateEndEditable --> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="javascript" src="../js/common.js"></script>
<!-- TemplateBeginEditable name="head" --><!-- TemplateEndEditable -->
<link href="../manage/css.css" rel="stylesheet" type="text/css">
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
          <td width="114" height="18" background="../manage/images/m_topright_bg.gif"><table width="108" border="0" cellspacing="0" cellpadding="0">
              <tr align="center">
                <td width="38">help</td>
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
    <td width="1%"><img src="../manage/images/m_top_bar_left.gif" width="28" height="22"></td>
    <td width="98%" background="../manage/images/m_top_bar_cen.gif">&nbsp;</td>
    <td width="1%"><img src="../manage/images/m_top_bar_right.gif" width="24" height="22"></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="195" valign="top" background="../manage/images/m_mid_leftbg.gif"><br>
      <?php include('../manage/inc_menu.php');?>
<p>&nbsp;</p>
<p>&nbsp;</p><p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p></td>
    <td width="797" valign="top" bgcolor="#FFFFFF"><!-- TemplateBeginEditable name="main" --> 
<table width="538"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="9" rowspan="3"><img src="../manage/images/cms_09.gif" width="9" height="32"></td>
    <td width="482" background="../manage/images/cms_10.gif"><img src="../manage/images/cms_10.gif" width="466" height="3"></td>
    <td width="47" rowspan="3"><img src="../manage/images/cms_11.gif" width="47" height="32"></td>
  </tr>
  <tr>
    <td height="25" bgcolor="#FFFFFF" class="Mgr_Heading">User</td>
    </tr>
  <tr>
    <td height="4" background="../manage/images/cms_17.gif"><img src="../manage/images/cms_17.gif" width="466" height="4"></td>
    </tr>
</table>
<br>
  aaaaaaaaaaaaaaaa<!-- TemplateEndEditable --></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="200" background="../manage/images/m_btm.gif">&nbsp;</td>
    <td align="right" background="../manage/images/m_btm_bg.gif"><p><img src="../manage/images/m_btm_right.gif" width="667" height="52"></p></td>
  </tr>
</table>
</body>
</html>
