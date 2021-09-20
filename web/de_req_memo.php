<?php require_once('Connections/localhost.php'); ?>
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
  
  //insert Job Log  
  mysql_select_db($database_localhost, $localhost);
  $logperson = $_POST['cAuth'];
  $logcontent = "Memo entered by dealer.";
  $sql_log = sprintf("insert tblog (cJN, dtDate, cPerson, cContent) values (%s, %s, %s, %s)",
  					$_POST['cJN'],
					"NOW()",
                    GetSQLValueString($logperson, "text"),
                    GetSQLValueString($logcontent, "text"));
  $Result1 = mysql_query($sql_log, $localhost) or die(mysql_error());
  
  //新增Memo时把isRead的字段写个"no",告知后台有新的memo; cMemo写个yes,表示该job有memo存在.
  $updateSQL = sprintf("UPDATE tbrepair SET cMemo='yes', cMemoReply='yes', cIsReplyRead='', cIsReplyRead2='checked' WHERE cJN=%s",
                       GetSQLValueString($_POST['cJN'], "text"));

  mysql_select_db($database_localhost, $localhost);
  mysql_query($updateSQL, $localhost) or die(mysql_error());
  $updated = "true";
}

$colname_rs = "-1";
if (isset($_GET['cJN'])) {
  $colname_rs = (get_magic_quotes_gpc()) ? $_GET['cJN'] : addslashes($_GET['cJN']);
}
mysql_select_db($database_localhost, $localhost);
$query_rs = sprintf("SELECT * FROM tbrepair WHERE cJN = '%s'", $colname_rs);
$rs = mysql_query($query_rs, $localhost) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);
$totalRows_rs = mysql_num_rows($rs);

$colname_mm = "-1";
if (isset($_GET['cJN'])) {
  $colname_mm = (get_magic_quotes_gpc()) ? $_GET['cJN'] : addslashes($_GET['cJN']);
}
mysql_select_db($database_localhost, $localhost);
$query_mm = "SELECT *,DATE_FORMAT(dtDate,'%d %b %Y <br> %p %h:%i') AS dtSDate FROM tbmemo WHERE cAuthType<>'remark' and cJN = '". $colname_mm ."' ORDER BY iID ASC";
$mm = mysql_query($query_mm, $localhost) or die(mysql_error());
$row_mm = mysql_fetch_assoc($mm);
$totalRows_mm = mysql_num_rows($mm);

//打开页面时把已经完成的Job的isReplyRead2的字段写个"checked",表示dealer/agen已经读过memo,以后可以不再显示
//2008-2-7
mysql_select_db($database_localhost, $localhost);
$updateSQL = sprintf("UPDATE tbrepair SET cIsReplyRead2='checked' WHERE cJN=%s and (cStatus='S25' or cStatus='S30' or cStatus='S35')",$colname_mm);
mysql_query($updateSQL, $localhost);
?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title><?php echo $row_rs['cMake']; ?> <?php echo $row_rs['cModel']; ?> - Job Memo</title>
<link href="./css.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.BLdealer {
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
.BGdealer {
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
<?php include('repair/myfunction.php');?>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="5" bgcolor="#f4f4f4">
  <tr>
    <td width="12%"><strong>    
    Job No.</strong></td>
    <td width="38%"><?php echo $row_rs['cJN']; ?></td>
    <td width="8%">&nbsp;</td>
    <td width="42%">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Model:</strong></td>
    <td><strong><?php echo $row_rs['cMake']; ?> <?php echo $row_rs['cModel']; ?></strong></td>
    <td><strong>IMEI:</strong></td>
    <td><?php echo $row_rs['cIMEI']; ?></td>
  </tr>
  <tr>
    <td><strong>Status:</strong></td>
    <td><?php echo getStatus($row_rs['cStatus']); ?></td>
    <td><strong> Location:</strong></td>
    <td><?php echo getLocation($row_rs['cLocation']); ?></td>
  </tr>
  <tr>
    <td><strong>Srv Charge:</strong></td>
	<?php
	$fontcolor = "#000000";
	$chk2 = "";
	if($row_rs['cIsWrty']!="") {$fontcolor = "#FF0000"; $chk2="checked";}
	$chk3 = "";
	if($row_rs['cIsCmmisn']!="") {$chk3="checked";}
	?>
    <td colspan="3">$<?php echo $row_rs['cSrvChg']; ?>
	<?php 
	$chk = "";
	if($row_rs['cIIFP']!=""){$chk="checked";}
	?>
	<input name="cIIFP" type="checkbox" id="cIIFP" value="checkbox" <?php echo $chk; ?> disabled>
          inc insp fee
	      <input name="cIsWrty" type="checkbox" id="cIsWrty" value="checkbox" <?php echo $chk2; ?> disabled>
          Wrrty</td>
  </tr>
</table>
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
            <td width="15%" height="20" valign="top" class="BG<?php echo $row_mm['cAuthType'];?>"><?php echo $row_mm['cAuthType']=="dealer"?$row_mm['cAuth']:"Omnitech"; ?><br>
            &nbsp;</td>
            <td width="85%" valign="top"><?php echo str_replace("\n","<br>",$row_mm['cContent']); ?></td>
          </tr>
              </table>
	  <?php } while ($row_mm = mysql_fetch_assoc($mm)); ?>
	<?php }else{?>
	&nbsp;<br>
	<strong>There is no memo for this job so far.</strong><br>
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
      <input name="cTitle" type="text" id="cTitle" class="ipt_srf" value="<?php echo $row_rs['cMake'];?> <?php echo $row_rs['cModel']; ?>" style="width:100%"></td>
  </tr>
  <tr>
    <td bgcolor="#f4f4f4">Content:<br>
      <textarea name="cContent" wrap="virtual" class="ipt_srf" id="cContent" style="height:110px; width:100%"></textarea>    </td>
  </tr>
  <tr>
    <td><input type="submit" name="Submit" value="Submit">
      <input name="cJN" type="hidden" id="cJN" value="<?php echo $row_rs['cJN']; ?>">
      <input name="cAuth" type="hidden" id="cAuth" value="<?php echo $_SESSION['DE_Userrealname'];?>">
      <input name="cAuthType" type="hidden" id="cAuthType" value="<?php echo $_SESSION['DE_UserGroup'];?>">
      <input name="cAuthContact" type="hidden" id="cAuthContact"></td>
  </tr>
  <input type="hidden" name="MM_insert" value="form1">
  </form>
</table>
<script language="javascript">
<!--
window.opener.location.reload();
if(<?php echo $updated;?>){
	alert("Thanks for your reply!");
}
//-->
</script>
</body>
</html>
<?php
mysql_free_result($rs);

mysql_free_result($mm);
?>
