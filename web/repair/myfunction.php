<?php
//get the phone status description by StatusCode
function getStatus($aSC){
	$cDesc = "Processing";
	switch($aSC){
		case "S00":
			$cDesc = "Processing";
			break;
		case "S05":
			$cDesc = "waiting to assign";
			break;
		case "S10":
			$cDesc = "Inspection";
			break;
		case "S15":
			$cDesc = "Waiting for parts";
			break;
		case "S20":
			$cDesc = "Waiting to be confirm by customer";
			break;
		case "S25":
			$cDesc = "Unserviceable";
			break;
		case "S30":
			$cDesc = "Repaired";
			break;
		case "S35":
			$cDesc = "Other";
			break;
	}
	return $cDesc;
}

//get the phone location description by Location Code
function getLocation($aLC){
	$cDesc = "Processing";
	switch($aLC){
		case "L00":
			$cDesc = "Being sent to Repair Center";
			break;
		case "L05":
			$cDesc = "Repair center";
			break;
		case "L10":
			$cDesc = "Has been sent to dealer";
			break;
		case "L15":
			$cDesc = "Ready to be picked up from Repair Center";
			break;
		case "L20":
			$cDesc = "Has been picked up/delivered";
			break;
		case "L25":
			$cDesc = "Keep in lieu of payment";
			break;
		case "L30":
			$cDesc = "Other";
			break;
	}
	return $cDesc;
}

function getFBScale($aSC){
	$cDesc = "Unknown";
	switch($aSC){
		case "3":
			$cDesc = "Unsatisfactory";
			break;
		case "4":
			$cDesc = "Satisfaction";
			break;
		case "5":
			$cDesc = "Good";
			break;
		case "6":
			$cDesc = "Very Good";
			break;
		case "7":
			$cDesc = "Excellent";
			break;
	}
	return $cDesc;
}

function getFBTell($aSC){
	$cDesc = "Unknown";
	switch($aSC){
		case "3":
			$cDesc = "Definitely not";
			break;
		case "4":
			$cDesc = "Probably not";
			break;
		case "5":
			$cDesc = "Not Sure";
			break;
		case "6":
			$cDesc = "Probably";
			break;
		case "7":
			$cDesc = "Definitely yes";
			break;
	}
	return $cDesc;
}
?>