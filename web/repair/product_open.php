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
if(isset($_POST['MM_update']) && $_POST['MM_update']!=""){
	mysql_select_db($database_localhost, $localhost);
	$sql_out = "insert stock_stockout (product_id, quantity ,job_num , status ) values ('".$_POST['id']."', '".$_POST['qty']."', '".$_POST['job_num']."', 'open')";
	mysql_query($sql_out, $localhost) or die(mysql_error());

	$sql_update = "update stock_product set quantity=quantity-".$_POST['qty']." where id='".$_POST['id']."'";
	mysql_query($sql_update, $localhost) or die(mysql_error());
	
	mysql_select_db($database_localhost, $localhost);
	  $logperson = $_SESSION['RP_WHOAMI'];
	  $logcontent = "Part Open, Part name=".$_POST['pname']." , quantity=".$_POST['qty'];
	  $sql_log = sprintf("insert tblog (cJN, dtDate, cPerson, cContent) values (%s, %s, %s, %s)",
						$_POST['job_num'],
						"NOW()",
						GetSQLValueString($logperson, "text"),
						GetSQLValueString($logcontent, "text"));
	  $Result1 = mysql_query($sql_log, $localhost) or die(mysql_error());
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title></title>
<script language="javascript">
<!--
window.opener.location = "rtp.php?cJN=<?php echo $_POST['job_num'];?>";
self.close();
//-->
</script>
</head>

<body>
</body>
</html>
