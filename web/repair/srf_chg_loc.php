<?php require_once('../Connections/localhost.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "admin";
$MM_authorizedGroups = "tbtech,tbopr";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "error.php?info=Sorry, you are not authorised for this operation.";
if (!((isset($_SESSION['RP_Username'])) && (isAuthorized($MM_authorizedUsers, $MM_authorizedGroups, $_SESSION['RP_Username'], $_SESSION['RP_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "chg_loc")) {
	  $updateSQL = sprintf("UPDATE tbrepair SET dtCDate='%s-%s-%s', cSrvChg=%s, cIIFP=%s, cFCS5=%s, cIsWrty=%s, cIsCmmisn=%s, cSrvReport=%s, cStatus=%s, cLocation=%s, iCrrID=%s, cCrrTrk=%s, cStsOnReport=%s, cIsReplyRead = 'checked', cRemark=%s WHERE iID=%s",
						   $_POST['year'],
						   $_POST['month'],
						   $_POST['date'],
						   GetSQLValueString($_POST['cSrvChg'], "text"),
                       	   GetSQLValueString(isset($_POST['cIIFP']) ? "true" : "", "defined","'(included inspection fee paid)'","' '"),
						   GetSQLValueString(isset($_POST['cFCS5']) ? "true" : "", "defined","'(included inspection fee $45.0 paid)'","' '"),
                       	   GetSQLValueString(isset($_POST['cIsWrty']) ? "true" : "", "defined","'Warranty'","' '"),
                       	   GetSQLValueString(isset($_POST['cIsCmmisn']) ? "true" : "", "defined","'Commission'","' '"),
						   GetSQLValueString($_POST['cSrvReport'], "text"),
						   GetSQLValueString($_POST['cStatus'], "text"),
						   GetSQLValueString($_POST['cLocation'], "text"),
						   GetSQLValueString($_POST['iCrrID'], "text"),
						   GetSQLValueString($_POST['cCrrTrk'], "text"),
						   GetSQLValueString($_POST['cStsOnReport'], "text"),
						   GetSQLValueString($_POST['cRemark'], "text"),
						   GetSQLValueString($_POST['iID'], "int"));
	
	  mysql_select_db($database_localhost, $localhost);
	  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());
	  
	  if($_POST['cLocation']=='L20'){//if its set to 'Have been pick up', then insert a remark automatically
			$insertSQL = sprintf("INSERT INTO tbmemo (cJN, cAuthType, cAuth, cAuthContact, dtDate, cTitle, cContent) VALUES (%s, %s, %s, '', %s, 'remark', %s)",
						   GetSQLValueString($_POST['cJN'], "text"),
						   GetSQLValueString("remark", "text"),
						   GetSQLValueString("SYSTEM", "text"),
						   "NOW()",
						   GetSQLValueString("Has been picked up", "text"));
		  mysql_select_db($database_localhost, $localhost);
		  $Result1 = mysql_query($insertSQL, $localhost) or die(mysql_error());
	  }
  
  //insert Job Log  
  mysql_select_db($database_localhost, $localhost);
  $logperson = $_SESSION['RP_WHOAMI'];
  $logcontent = "Job Done. Complete Date=".$_POST['date']."-".$_POST['month']."-".$_POST['year'].", Status=".$_POST['cStatus']. ", Location=". $_POST['cLocation']. ", Service Charge=$". $_POST['cSrvChg'];
  $sql_log = sprintf("insert tblog (cJN, dtDate, cPerson, cContent) values (%s, %s, %s, %s)",
  					$_POST['cJN'],
					"NOW()",
                    GetSQLValueString($logperson, "text"),
                    GetSQLValueString($logcontent, "text"));
  $Result1 = mysql_query($sql_log, $localhost) or die(mysql_error());
	  
	  $insertGoTo = "rtp.php?cJN=".$_POST['cJN'];
	  //$insertGoTo = "req_list_all.php";
	  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Chg Loc</title>
</head>

<body>

</body>
</html>
