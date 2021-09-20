<?php require_once('../Connections/localhost.php'); ?>
<?php
session_start();
$updated = "false";
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO tbmemo (cJN, cAuthType, cAuth, cAuthContact, dtDate, cTitle, cContent) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['cJN'], "text"),
                       GetSQLValueString($_POST['cAuthType'], "text"),
                       GetSQLValueString($_POST['cAuth'], "text"),
                       GetSQLValueString($_POST['cAuthContact'], "text"),
                       "NOW()",
                       GetSQLValueString($_POST['cTitle'], "text"),
                       GetSQLValueString($_POST['cContent'], "text"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($insertSQL, $localhost) or die(mysql_error());
  
  
  $updateSQL = sprintf("UPDATE tbmemo SET cIsRead='checked' WHERE cAuthContact=%s",
                       GetSQLValueString($_POST['cAuthContact'], "text"));

  mysql_select_db($database_localhost, $localhost);
  mysql_query($updateSQL, $localhost) or die(mysql_error());
  $updated = "true";
}

$colname_mm = "-1";
if (isset($_GET['Ref'])) {
  $colname_mm = (get_magic_quotes_gpc()) ? $_GET['Ref'] : addslashes($_GET['Ref']);
}
mysql_select_db($database_localhost, $localhost);
$query_mm = "SELECT *,DATE_FORMAT(dtDate,'%d %b %Y <br> %p %h:%i') AS dtSDate FROM tbmemo WHERE cAuthContact = '". $colname_mm ."' ORDER BY iID ASC";
$mm = mysql_query($query_mm, $localhost) or die(mysql_error());
$row_mm = mysql_fetch_assoc($mm);
$totalRows_mm = mysql_num_rows($mm);

?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>Memo</title>
<link href="../manage/css.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.BLagent {
	font-weight: bold;
	background-color: #F68B1E;
	border: 1px solid #404041;
}
.BLtbtech {
	font-weight: bold;
	background-color: #CADB2A;
	border: 1px solid #404041;
}
.BLtbopr {
	font-weight: bold;
	background-color: #CADB2A;
	border: 1px solid #404041;
}
.BGagent {
	background-color: #FEE0C2;
}
.BGtbtech {
	background-color: #f0f5c5;
}
.BGtbopr {
	background-color: #f0f5c5;
}
-->
</style>
</head>
<?php include('myfunction.php');?>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td align="center">
	<?php
	if($totalRows_mm >0){
	?>
	  <?php do { ?>
	  <table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr class="">
            <td class="BG<?php echo $row_mm['cAuthType'];?>"><?php echo $row_mm['dtSDate']; ?></td>
            <td class="BL<?php echo $row_mm['cAuthType'];?>"><?php echo $row_mm['cTitle']; ?></td>
          </tr>
          <tr>
            <td width="15%" height="20" valign="top" class="BG<?php echo $row_mm['cAuthType'];?>"><?php echo $row_mm['cAuthType']=="agent"?$row_mm['cAuth']:"Omnitech"; ?><br>
            &nbsp;</td>
            <td width="85%" valign="top"><?php echo str_replace("\n","<br>",$row_mm['cContent']); ?></td>
          </tr>
        </table>
	  <?php } while ($row_mm = mysql_fetch_assoc($mm)); ?>
	<?php }else{?>
	&nbsp;<br>
	<strong>There is no memo so far.</strong><br>
	&nbsp;
	<?php }?>
	</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="2" cellpadding="5">
      <form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <tr>
    <td bgcolor="#efefef">Title:
      <br>
      <input name="cTitle" type="text" id="cTitle" class="ipt_srf" style="width:100%"></td>
  </tr>
  <tr>
    <td bgcolor="#f4f4f4">Content:<br>
      <textarea name="cContent" wrap="virtual" class="ipt_srf" id="cContent" style="height:110px; width:100%"></textarea>    </td>
  </tr>
  <tr>
    <td><input type="submit" name="Submit" value="Submit">
      <input name="cJN" type="hidden" id="cJN" value="<?php echo $row_mm['cJN']; ?>">
      <input name="cAuth" type="hidden" id="cAuth" value="<?php echo $_SESSION['RP_Userrealname'];?>">
      <input name="cAuthType" type="hidden" id="cAuthType" value="<?php echo $_SESSION['RP_UserGroup'];?>">
      <input name="cAuthContact" type="hidden" id="cAuthContact" value="<?php echo $row_mm['cAuthContact'];?>"></td>
  </tr>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="MM_insert" value="form1">
  </form>
</table>
<script language="javascript">
<!--
if(<?php echo $updated;?>){
	alert("Thanks for your reply!");
}
window.opener.location.reload();
//-->
</script>
</body>
</html>
<?php
mysql_free_result($mm);
?>
