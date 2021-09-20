<?php
//initialize the session
session_start();

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  session_unregister('DE_Username');
  session_unregister('DE_UserGroup');
  session_unregister('DE_Userrealname');
  session_unregister('DE_VIP');
  session_unregister('DE_SC_ITEMS');
  session_unregister('DE_BranchList');
	
  $logoutGoTo = "index_ph.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}else{
	header("Location: index_ph.php");
	exit;
}
?>