<?php require_once('../Connections/localhost.php'); ?>
<?php
include('invfunction.php');

//doInvAuto();
mysql_select_db($database_localhost, $localhost);
$today=getdate();
$Year=$today["year"];
$Month=$today["mon"];
$duedate = "20-".$Month."-".$Year;

	if($Month== 1){
		$Month = "12";
		$Year -= 1;
	}else{
		$Month -= 1;
	}

if(isset($_GET['action']) && $_GET['action']=="reinv"){
	setInvDate("Drop", $Year, $Month, $localhost);
	cleanInv($Year, $Month, $localhost);
	die('inv all clean:'.$Year.'-'.$Month);
}

if(isset($_GET['action']) && $_GET['action']=="showmail"){
	sendInvMail($Year, $Month, $localhost, $duedate);
	die();
}

if(!needDoInv($Year, $Month,$localhost)){
	echo "<br>No Need to Cal ".$Year."-".$Month;
}else{
	//$ret = ;
	if(setInvDate("set", $Year, $Month, $localhost) || 
		cleanInv($Year, $Month, $localhost) ||
		copyInv($Year, $Month, $localhost) || 
		calInv($Year, $Month, $localhost) || 
		sendInvMail($Year, $Month, $localhost, $duedate)){
		
		echo "<br>Error!";
		setInvDate("Drop", $Year, $Month, $localhost);
	}else{
		echo "<br>Wiiiiin!";
		echo "<br>".$today['min'];
	}
	
}//end if needDoInv()
?>