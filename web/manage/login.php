<?php require_once('../Connections/localhost.php'); ?>
<?php
// *** Validate request to login to this site.
session_start();

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($accesscheck)) {
  $GLOBALS['PrevUrl'] = $accesscheck;
  session_register('PrevUrl');
}

if (isset($_POST['cLogin'])) {
  $loginUsername=$_POST['cLogin'];
  $password=$_POST['cPsw'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "fb_list.php";
  $MM_redirectLoginFailed = "error.php?info=no such login or password error";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_localhost, $localhost);
  
  $LoginRS__query=sprintf("SELECT cLogin, cPsw, cName FROM tbuser WHERE cLogin='%s' AND cPsw='%s'",
    get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password)); 
   
  $LoginRS = mysql_query($LoginRS__query, $localhost) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
    //declare two session variables and assign them
    $GLOBALS['AC_Username'] = $loginUsername;
    $GLOBALS['AC_UserGroup'] = $loginUsername;	
	$GLOBALS['AC_Userrealname'] = $row_Recordset1['cName'];
	//mysql_free_result($LoginRS);

    //register the session variables
    session_register("AC_Username");
    session_register("AC_UserGroup");
    session_register("AC_Userrealname");

    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<html>
<head>
<title>manage pages</title>
 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="javascript" src="../js/common.js"></script>

<link href="css.css" rel="stylesheet" type="text/css">
</head>

<body>
<br>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" background="../manage/images/m_top_bg.gif">
  <tr>
    <td width="878"><img src="../images/backg-top.gif" width="61" height="24"></td>
    <td width="114" rowspan="2" valign="top"><table width="114" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><img src="../manage/images/m_top_right.gif" width="114" height="71"></td>
        </tr>
        <tr>
          <td height="18" background="../manage/images/m_topright_bg.gif"><table width="108" border="0" cellspacing="0" cellpadding="0">
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
    <td width="217" background="../manage/images/m_mid_leftbg.gif"><br>    </td>
    <td width="775" valign="top" bgcolor="#FFFFFF">
      <p>&nbsp;</p>
      <table width="49%"  border="0" cellpadding="2" cellspacing="5">
        <form name="form" method="POST" action="<?php echo $loginFormAction; ?>">
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td width="39%" class="Mgr_Heading">User Name </td>
            <td width="61%" align="right">
              <input name="cLogin" type="text" class="ipt_normal" id="cLogin">            </td>
          </tr>
          <tr>
            <td class="Mgr_Heading">Password</td>
            <td align="right"><input name="cPsw" type="password" class="ipt_normal" id="cPsw"></td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <td align="right"><input name="Submit3" type="submit" class="btn" value="Submit">
            </td>
          </tr>
        </form>
      </table>    
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="33%" background="../manage/images/m_btm.gif">&nbsp;</td>
    <td width="67%"><p><img src="../manage/images/m_btm_right.gif" width="667" height="52"></p></td>
  </tr>
</table>
</body>
</html>
