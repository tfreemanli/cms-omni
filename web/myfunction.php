<?php require_once('Connections/localhost.php'); ?>
Done! And the Job No. is 
<?php

mysql_select_db($database_localhost, $localhost);
$query_JN = "SELECT iJN FROM tbjn WHERE iID = 1";
$JN = mysql_query($query_JN, $localhost) or die(mysql_error());
$row_JN = mysql_fetch_assoc($JN);
$totalRows_JN = mysql_num_rows($JN);

echo $row_JN['iJN'];
mysql_free_result($JN);
?>
