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
	$sql_query = "select * from stock_stockout where id='".$_GET['id']."'";
	$rs = mysql_query($sql_query, $localhost) or die(mysql_error());
	$row = mysql_fetch_assoc($rs);
	
		$pid = $row['product_id'];
		$qty = $row['quantity'];
		$sql_update = "update stock_product set quantity=quantity+".$qty." where id='".$pid."'";
		mysql_query($sql_update, $localhost) or die(mysql_error());
	
	
	$sql_out = "delete from stock_stockout where id='".$_GET['id']."'";
	mysql_query($sql_out, $localhost) or die(mysql_error());
	
	mysql_select_db($database_localhost, $localhost);
	  $logperson = $_SESSION['RP_WHOAMI'];
	  $logcontent = "part back to stock, part name=".$_GET['pname'];
	  $sql_log = sprintf("insert tblog (cJN, dtDate, cPerson, cContent) values (%s, %s, %s, %s)",
						$_GET['job_num'],
						"NOW()",
						GetSQLValueString($logperson, "text"),
						GetSQLValueString($logcontent, "text"));
	  $Result1 = mysql_query($sql_log, $localhost) or die(mysql_error());
	
	header("Location: rtp.php?cJN=". $_GET['job_num']); 
	mysql_free_result($rs);
}
?>