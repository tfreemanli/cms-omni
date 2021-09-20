<?php
// *** Logout the current user.
$logoutGoTo = "login.php";
session_start();
unset($_SESSION['RP_Username']);
unset($_SESSION['RP_UserGroup']);
unset($_SESSION['RP_Userrealname']);
unset($_SESSION['RP_BranchList']);
session_unregister('RP_Username');
session_unregister('RP_UserGroup');
session_unregister('RP_Userrealname');
session_unregister('RP_BranchList');
	
	//Clear Whoami, wait the operator select again in inc_menu.php and setWhoami.php
	unset($_SESSION['RP_WHOAMI']);
	session_unregister('RP_WHOAMI');
	
if ($logoutGoTo != "") {header("Location: $logoutGoTo");

exit;
}
?>