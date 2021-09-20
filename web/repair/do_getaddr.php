<?php require_once('../Connections/localhost.php'); ?>
<?php
mysql_select_db($database_localhost, $localhost);
$id = "";
if(isset($_GET['dealer'])) $id=$_GET['dealer'];
$query_dealer = "SELECT iID, cName, cAdd FROM tbdeal where iID='".$id."'";
$dealer = mysql_query($query_dealer, $localhost) or die(mysql_error());
$row_dealer = mysql_fetch_assoc($dealer);
$totalRows_dealer = mysql_num_rows($dealer);
?>
var n = MM_findObj('cName');
var a = MM_findObj('cAdd');
a.value = "<?php echo $row_dealer['cAdd'];?>";
n.value = "<?php echo $row_dealer['cName'];?>";
<?php
mysql_free_result($dealer);
?>