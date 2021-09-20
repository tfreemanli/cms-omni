<?php require_once('Connections/localhost.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
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
}

mysql_select_db($database_localhost, $localhost);
$query_RS1 = "SELECT * FROM tbwebinfo WHERE title = 'contact'";
$RS1 = mysql_query($query_RS1, $localhost) or die(mysql_error());
$row_RS1 = mysql_fetch_assoc($RS1);
$totalRows_RS1 = mysql_num_rows($RS1);

session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Omnitech Computer Repair</title>
<link href="css.css" rel="stylesheet" type="text/css" />
</head>


<body class="welcome_body">
<?php include('./inc_com_head.php');?>
<table width="1027" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="124" class="com_menu_normal"><a href="./index_com.php" class="a3">HOME</a></td>
    <td width="4" class="com_menu_gap">&nbsp;</td>
    <td width="124" class="com_menu_normal"><a href="./com_computer.php" class="a3">Computer</a></td>
    <td width="4" class="com_menu_gap">&nbsp;</td>
    <td width="124" class="com_menu_normal"><a href="./com_apple.php" class="a3">Apple</a></td>
    <td width="4" class="com_menu_gap">&nbsp;</td>
    <td width="124" class="com_menu_normal"><a href="./com_psp.php" class="a3">PSP</a></td>
    <td width="4" class="com_menu_gap">&nbsp;</td>
    <td width="124" class="com_menu_normal"><a href="./com_xbox.php" class="a3">XBox</a></td>
    <td width="4" class="com_menu_gap">&nbsp;</td>
    <td width="124" class="com_menu_normal"><a href="./com_wii.php" class="a3">Wii</a></td>
    <td width="4" class="com_menu_gap">&nbsp;</td>
    <td width="124" class="com_menu_normal"><a href="./com_playstation.php" class="a3">Playstation</a></td>
    <td width="4" class="com_menu_gap">&nbsp;</td>
    <td class="com_menu_current">Contact</td>
  </tr>
</table>
<table width="1027" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="255" bgcolor="#e4e5e6" valign="top"><p><img src="images/ins_com_leftimg.gif" width="255" height="414" /></p></td>
    <td width="772" valign="top" bgcolor="#FFFFFF"><table width="772" border="0" cellspacing="0" cellpadding="25">
      <tr>
        <td><?php echo $row_RS1['desc']; ?></td>
      </tr>
    </table></td>
  </tr>
</table>
<?php include('./inc_com_footer.php');?>

</body>
</html>
<?php
mysql_free_result($RS1);
?>