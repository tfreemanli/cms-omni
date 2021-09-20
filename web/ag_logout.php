<?php
//initialize the session
session_start();

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  session_unregister('AG_Username');
  session_unregister('AG_UserGroup');
  session_unregister('AG_Userrealname');
	
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