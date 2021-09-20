<?php require_once('../Connections/localhost.php'); ?>
<?php
session_start();
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
} 
if(isset($_GET['id']) && $_GET['id']!=""){
	mysql_select_db($database_localhost, $localhost);
	$dt = _strToTimeStamp();
	$sql_out = "update stock_stockout set stockout_date='".$dt."', operator_id='". $_SESSION['RP_UID'] ."', status='out' where id='".$_GET['id']."'";
	//echo $sql_out;
	mysql_query($sql_out, $localhost) or die(mysql_error());
	
	mysql_select_db($database_localhost, $localhost);
	  $logperson = $_SESSION['RP_WHOAMI'];
	  $logcontent = "Stock Out the part, part name=".$_GET['pname'];
	  $sql_log = sprintf("insert tblog (cJN, dtDate, cPerson, cContent) values (%s, %s, %s, %s)",
						$_GET['job_num'],
						"NOW()",
						GetSQLValueString($logperson, "text"),
						GetSQLValueString($logcontent, "text"));
	  $Result1 = mysql_query($sql_log, $localhost) or die(mysql_error());

	header("Location: rtp.php?cJN=". $_GET['job_num']); 
}


	
	//transfer date string to timestamp
	function _strToTimeStamp() {
		$datetimenow = getdate();
		$cYear=$datetimenow["year"];
		$cMonth=$datetimenow["mon"];
		$cDate = $datetimenow["mday"];
		$cHour = $datetimenow["hours"];
		$cMin = $datetimenow["minutes"];
		//18-11-2008 21:29
		
		$stock_timestamp = mktime($cHour, $cMin, 0, $cMonth, $cDate, $cYear);
		
		return $stock_timestamp;
	}
?>