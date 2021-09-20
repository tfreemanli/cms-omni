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
  $MM_redirectLoginSuccess = "ag_memo_list.php";
  $MM_redirectLoginFailed = "error.php?info=no such login or password error";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_localhost, $localhost);
  
  $LoginRS__query=sprintf("SELECT cVIPNum, cPasswd, cName FROM tbcust WHERE cVIPNum='%s' AND cPasswd='%s' AND cStatus='normal' AND cIsVIP='1'",
    get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password)); 
   
  $LoginRS = mysql_query($LoginRS__query, $localhost) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
  	 $row_LoginRS = mysql_fetch_assoc($LoginRS);
     $loginStrGroup = "";
    
    //declare two session variables and assign them
    $GLOBALS['AG_Username'] = $loginUsername;
    $GLOBALS['AG_UserGroup'] = "agent";	
	$GLOBALS['AG_Userrealname'] = $row_LoginRS['cName'];
	mysql_free_result($LoginRS);

    //register the session variables
    session_register("AG_Username");
    session_register("AG_UserGroup");
    session_register("AG_Userrealname");

    
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>