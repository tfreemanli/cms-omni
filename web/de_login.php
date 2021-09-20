<?php require_once('./Connections/localhost.php'); ?>
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
  $MM_redirectLoginSuccess = "de_req_list.php?2bc=1";
  $MM_redirectLoginFailed = "error.php?info=no such login or password error";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_localhost, $localhost);
  
  $LoginRS__query=sprintf("SELECT cLogin, cPasswd, cName, cVIP FROM tbdeal WHERE cLogin='%s' AND cPasswd='%s' AND cStatus='normal'",
    get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password)); 
   
  $LoginRS = mysql_query($LoginRS__query, $localhost) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
  	 $row_LoginRS = mysql_fetch_assoc($LoginRS);
     $loginStrGroup = "";
    
    //declare two session variables and assign them
    $GLOBALS['DE_Username'] = $loginUsername;
    $GLOBALS['DE_UserGroup'] = "dealer";	
	$GLOBALS['DE_Userrealname'] = $row_LoginRS['cName'];
	$GLOBALS['DE_VIP'] = $row_LoginRS['cVIP'];
	$GLOBALS['DE_BranchList'] = array("omnitech", 
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

	mysql_free_result($LoginRS);

    //register the session variables
    session_register("DE_Username");
    session_register("DE_UserGroup");
    session_register("DE_Userrealname");
    session_register("DE_VIP");
	session_register("DE_BranchList");

    
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>