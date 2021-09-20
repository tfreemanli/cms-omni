<?php require_once('../Connections/localhost.php'); ?>
<?php
// *** Validate request to login to this site.
session_start();
//include('./invfunction.php');
	

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($accesscheck)) {
  $GLOBALS['PrevUrl'] = $accesscheck;
  session_register('PrevUrl');
}

if (isset($_POST['cLogin'])) {
  $loginUsername=$_POST['cLogin'];
  $password=$_POST['cPsw'];
  $type=$_POST['type'];
  $role = "tech";
  
  //add on 2012-1-16
  $where_clu = " and role='tech'";
  if($type != 'tbtech'){
	  $where_clu = "and role <> 'tech'";
	  }
  
  
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "../repair/index.php";
  $MM_redirectLoginFailed = "../repair/login.php";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_localhost, $localhost);
  
  $LoginRS__query=sprintf("SELECT * FROM tbopr WHERE cLogin='%s' AND cPsw='%s' %s and cStatus='normal'",
    get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password), $where_clu); 
   
  $LoginRS = mysql_query($LoginRS__query, $localhost) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = $type;
  	 $row_LoginRS = mysql_fetch_assoc($LoginRS);
	 
	 //get typeinperson
	mysql_select_db($database_localhost, $localhost);
	$query_whoami = "select cName from tbtypeinperson";
	$rs_whoami = mysql_query($query_whoami, $localhost) or die(mysql_error());
	$arr= array();
  	while($row_whoami = mysql_fetch_assoc($rs_whoami)){
		  $arr[] =$row_whoami['cName'];	
	}
	$GLOBALS['RP_WAIARR'] = $arr;
	session_register("RP_WAIARR");
	mysql_free_result($rs_whoami);
    
    //declare two session variables and assign them
	$role = $row_LoginRS['role'];
	$GLOBALS['RP_KEY'] = md5($row_LoginRS['iID'].$row_LoginRS['cName'].$row_LoginRS['role']);
	$GLOBALS['RP_UID'] = $row_LoginRS['iID'];
    $GLOBALS['RP_Username'] = $row_LoginRS['cLogin'];
    $GLOBALS['RP_UserGroup'] = $loginStrGroup;	 
    $GLOBALS['RP_Userrealname'] = $row_LoginRS['cName'];
	$GLOBALS['RP_ROLE'] = $row_LoginRS['role'];
	$GLOBALS['RP_BranchList'] = array("omnitech", 
									  "omnitechaly", 
									  "omnitechsp", 
									  "omnitechm",
									  "mctstore",
									  "omnitechw",
									  "omnitechsl",
									  "omnitechnl",
									  "omnitechh",
									  "omnitechd",
									  "omnitechspc",
									  "omnitechhc",
									  "omnitechnlc",
									  "omnitechslc",
									  "omnitechmc",
									  "omnitechac",
									  "omnitechch");

    //register the session variables
    session_register("RP_ROLE");
    session_register("RP_KEY");
    session_register("RP_UID");
    session_register("RP_Username");
    session_register("RP_UserGroup");
    session_register("RP_Userrealname");
	session_register("RP_BranchList");
	
	//Clear Whoami, wait the operator select again in inc_menu.php and setWhoami.php
	unset($_SESSION['RP_WHOAMI']);
	session_unregister('RP_WHOAMI');
	
	//Do the automatic Inv Process.
	//doInvAuto($localhost);
	
	mysql_free_result($LoginRS);

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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Repair Center</title>
<link href="../manage/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../js/common.js"></script>
</head>

<body>
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
    <td width="28"><img src="../manage/images/m_top_bar_left.gif" width="28" height="22"></td>
    <td width="940" background="../manage/images/m_top_bar_cen.gif">&nbsp;</td>
    <td width="24"><img src="../manage/images/m_top_bar_right.gif" width="24" height="22"></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="160" valign="top" background="../manage/images/m_mid_leftbg.gif">&nbsp;
    </td>
    <td width="640" valign="top"><p>&nbsp;</p>
      <p>&nbsp;</p>
      <table width="364" border="0" cellspacing="1" cellpadding="5">
      <form name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
        <tr>
          <td width="82" align="right" class="Mgr_Heading">Type</td>
          <td width="259"><input name="type" type="radio" value="tbtech" checked>
        Technician
          <input type="radio" name="type" value="tbopr">
        Operator</td>
        </tr>
        <tr>
          <td align="right">Login</td>
          <td><input name="cLogin" type="text" id="cLogin"></td>
        </tr>
        <tr>
          <td align="right">Password</td>
          <td><input name="cPsw" type="password" id="cPsw"></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input type="submit" name="Submit" value="Login"></td>
        </tr>
      </form>
    </table>
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
