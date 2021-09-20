<?php require_once('../Connections/localhost.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "admin";
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
if (!((isset($_SESSION['RP_Username'])) && (isAuthorized($MM_authorizedUsers,"", $_SESSION['RP_Username'], $_SESSION['RP_UserGroup'])))) {   
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
function sendPsw($to, $login, $psw){
	/* recipients */
	//$to  = "mary@example.com" . ", " ; // note the comma
	//$to .= "kelly@example.com";
	
	/* subject */
	$subject = "Welcome to OmniTech";
	
	/* message */
	$message = '<html>
<head>
<title>Welcome</title>
</head>
<body>
<p>Thank you for registering as our dealer/member at www.OmniTech.co.nz</p>
<p>Your credentials are:</p>
<p> Login: '. $login .' <br>
  Password: '. $psw .'
</p>
<p><strong>Your Mobile Phone Repair Specialist</strong></p>
<p>------------------------------------------------------------------- </p>
<p>Regards,<br>
<strong>OmniTech Phones Repair <br>
</strong>378 Great North Road<br>
        Henderson<br>
      Auckland, New Zealand<br>Ph:09-8383943<br>
        Fax:09-8383947<br>
<a href=mailto:info@omnitech.co.nz>info@omnitech.co.nz </a><br>
www.omnitech.co.nz </p>
</body>
</html>
	';
	
	/* To send HTML mail, you can set the Content-type header. */
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	
	/* additional headers */
	$headers .= "To: ".$to."\r\n";
	$headers .= "From: info@omnitech.co.nz\r\n";
	//$headers .= "Cc: birthdayarchive@example.com\r\n";
	//$headers .= "Bcc: birthdaycheck@example.com\r\n";
	
	/* and now mail it */
	mail($to, $subject, $message, $headers);
}

$updateSQL = sprintf("update tbdeal set cPasswd=right(Concat(RAND(second(now())),''),6), cStatus='normal' where iID=%s",
                       GetSQLValueString($_GET['iID'], "int"));
mysql_select_db($database_localhost, $localhost);
$Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());

//Send Email to the candidate
$querySQL = sprintf("select cLogin, cPasswd, cEmail from tbdeal where iID=%s",
                       GetSQLValueString($_GET['iID'], "int"));
mysql_select_db($database_localhost, $localhost);
$RS = mysql_query($querySQL, $localhost);
$row_RS = mysql_fetch_assoc($RS);
$login = $row_RS['cLogin'];
$psw = $row_RS['cPasswd'];
$email = $row_RS['cEmail'];

sendPsw($email, $login, $psw);
//End Send Email

  $insertGoTo = "de_list_apl.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
  
mysql_free_result($RS);
?>