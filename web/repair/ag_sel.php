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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	  $insertSQL = sprintf("INSERT INTO tbcust (cName, cLastName, cHomePhn, cWorkPhn, cAdd1, cAdd2, cAdd3, cFax, cEmail, cIsVIP, cVIPNum, cVIPVDate, cVIPEDate, cSbmBy, cMake, cModel, cIMEI) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, '1', %s, %s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($_POST['cName'], "text"),
						   GetSQLValueString($_POST['cLastName'], "text"),
						   GetSQLValueString($_POST['cHomePhn'], "text"),
						   GetSQLValueString($_POST['cWorkPhn'], "text"),
						   GetSQLValueString($_POST['cAdd1'], "text"),
						   GetSQLValueString($_POST['cAdd2'], "text"),
						   GetSQLValueString($_POST['cAdd3'], "text"),
						   GetSQLValueString($_POST['cFax'], "text"),
						   GetSQLValueString($_POST['cEmail'], "text"),
						   GetSQLValueString($_POST['cVIPNum'], "text"),
						   GetSQLValueString($_POST['cVIPVDate'], "text"),
						   GetSQLValueString($_POST['cVIPEDate'], "text"),
						   GetSQLValueString($_SESSION['RP_Username'], "text"),
						   GetSQLValueString($_POST['cMake'], "text"),
						   GetSQLValueString($_POST['cModel'], "text"),
						   GetSQLValueString($_POST['cIMEI'], "text"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($insertSQL, $localhost) or die(mysql_error());
}

$name = "";
$agentnum = "";
$where = "";
if(isset($_POST['cName']) && $_POST['cName']!=''){
	$name = $_POST['cName'];
	$where .= " and (cName like '%". $_POST['cName'] ."%' or cLastName like '%". $_POST['cName'] ."%')";
}
if(isset($_POST['cVIPNum']) && $_POST['cVIPNum']!=''){
	$agentnum = $_POST['cVIPNum'];
	$where .= " and cVIPNum like '%". $_POST['cVIPNum'] ."%'";
}

mysql_select_db($database_localhost, $localhost);
$query_rs = "SELECT * FROM tbcust WHERE cIsVIP = '1' ". $where ." ORDER BY cName ASC";
$rs = mysql_query($query_rs, $localhost) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);
$totalRows_rs = mysql_num_rows($rs);

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk">
<title>Select</title>
<link href="../css.css" rel="stylesheet" type="text/css" />
<script language="javascript">
<!--
function doAgent(aName, aID){
	var father = window.opener.document;
	if(father != null){
		father.all['agName'].value = aName;
		father.all['cAgentID'].value = aID;
		//alert(father.all['cAgentID'].value);
	}else{
		alert("Error, Pls try again.");
	}
	window.close();
}
//-->
</script>
</head>

<body>
<table width="100%"  border="0" cellspacing="5" cellpadding="2"><form name="form1" method="post" action="">
  <tr>
    <td>Name:
      <input name="cName" type="text" class="ipt_srf" id="cName" style="width:100px; " value="<?php echo $name;?>"> 
      Agent#:
      <input name="cVIPNum" type="text" class="ipt_srf" id="cVIPNum" style="width:100px; "  value="<?php echo $agentnum;?>">      <input type="submit" name="Submit2" value="search">
      &nbsp;&nbsp;&nbsp;<a href="ag_add_sp.php">Add&gt;&gt;</a></td>
    </tr></form>
</table><hr size="1">
<table width="100%"  border="0" cellspacing="2" cellpadding="2">
  <tr align="center" bgcolor="#e9e9e9">
    <td width="26%"><strong>Name</strong></td>
    <td width="13%"><strong>Agent#</strong></td>
    <td width="28%"><strong>Phone</strong></td>
    <td width="19%"><strong>Email</strong></td>
    <td width="14%">&nbsp;</td>
  </tr>
  <?php do { ?>
  <tr>
    <td><?php echo $row_rs['cName']; ?> <?php echo $row_rs['cLastName']; ?></td>
    <td><?php echo $row_rs['cVIPNum']; ?></td>
    <td><?php echo $row_rs['cWorkPhn']; ?> <?php echo $row_rs['cHomePhn']; ?></td>
    <td><?php echo $row_rs['cEmail']; ?></td>
    <td align="center"><input type="button" name="Submit" value="PickMe" onClick="doAgent('<?php echo $row_rs['cName']; ?> <?php echo $row_rs['cLastName']; ?>','<?php echo $row_rs['iID']; ?>');">    &nbsp;</td>
  </tr>
  <?php } while ($row_rs = mysql_fetch_assoc($rs)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($rs);
?>
