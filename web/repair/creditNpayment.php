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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST['id'])) && ($_POST['id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM tbinv_pay WHERE iID=%s",
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($deleteSQL, $localhost) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "fmPAY")) {
	$temp = $_POST['year']."-".$_POST['month']."-".$_POST['date'];
  $insertSQL = sprintf("INSERT INTO tbinv_pay (cType, cSbm, dtDate, cPaid, cRef) VALUES (2, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['sbm'], "text"),
                       GetSQLValueString($temp, "text"),
                       GetSQLValueString($_POST['cPaid'], "double"),
                       GetSQLValueString($_POST['cRef'], "text"));
  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($insertSQL, $localhost) or die(mysql_error());
}

$today=getdate();
$Year=$today["year"];
$Month=$today["mon"];
$Date = $today["mday"];
$firstday = $Year."-".$Month."-1";

$colname_RS_dealer = "1";
if (isset($_POST['sbm'])) {
  $colname_RS_dealer = (get_magic_quotes_gpc()) ? $_POST['sbm'] : addslashes($_POST['sbm']);
}
mysql_select_db($database_localhost, $localhost);
$query_RS_dealer = sprintf("SELECT * FROM tbdeal WHERE cLogin = '%s'", $colname_RS_dealer);
$RS_dealer = mysql_query($query_RS_dealer, $localhost) or die(mysql_error());
$row_RS_dealer = mysql_fetch_assoc($RS_dealer);
$totalRows_RS_dealer = mysql_num_rows($RS_dealer);

$colname_RS_paid = "1";
if (isset($_POST['sbm'])) {
  $colname_RS_paid = (get_magic_quotes_gpc()) ? $_POST['sbm'] : addslashes($_POST['sbm']);
}
mysql_select_db($database_localhost, $localhost);
$query_RS_paid = "SELECT *,DATE_FORMAT(dtDate,'%d %b %Y') AS dtFmDate FROM tbinv_pay WHERE cType='2' and cSbm = '".$colname_RS_paid."' ORDER BY dtDate DESC";
$RS_paid = mysql_query($query_RS_paid, $localhost) or die(mysql_error());
$row_RS_paid = mysql_fetch_assoc($RS_paid);
$totalRows_RS_paid = mysql_num_rows($RS_paid);

$dealer = $row_RS_dealer['cLogin'];

//get credit of this dealer
$sql_credit = "select (sum(cPaid)+sum(cCmmisn)-sum(cSrvChg)) as credit from tbinv_pay where cSbm='".$dealer."'";
$RS_credit = mysql_query($sql_credit,$localhost) or $ret=mysql_error();
$row_RS_credit = mysql_fetch_assoc($RS_credit);
$credit = 0.0;
if($row_RS_credit['credit'] != null && $row_RS_credit['credit'] != ""){
	$credit = $row_RS_credit['credit'];
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><!-- InstanceBegin template="../Templates/tpl_repair.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>Repair Center</title>
<!-- InstanceEndEditable --><link href="../manage/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../js/common.js"></script>
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" background="../manage/images/m_top_bg.gif">
  <tr>
    <td><img src="../images/backg-top.gif" width="61" height="24"></td>
    <td width="114" rowspan="2" valign="top"><table width="114" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="114"><img src="../manage/images/m_top_right.gif" width="114" height="71"></td>
        </tr>
        <tr>
          <td height="18" background="../manage/images/m_topright_bg.gif"><table width="108" border="0" cellspacing="0" cellpadding="0">
              <tr align="center">
                <td width="38"><a href="fb_list.php">help</a></td>
                <td width="70">contact us </td>
              </tr>
          </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><img src="../manage/images/m_logo.gif" width="261" height="65"></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="28" background="../manage/images/m_top_bar_cen.gif"><img src="../manage/images/m_top_bar_left.gif" width="28" height="22"></td>
    <td background="../manage/images/m_top_bar_cen.gif">&nbsp;</td>
    <td width="24" align="right" background="../manage/images/m_top_bar_cen.gif"><img src="../manage/images/m_top_bar_right.gif" width="24" height="22" align="right"></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="193" valign="top" background="../manage/images/m_mid_leftbg.gif"><?php include("inc_menu.php");?></td>
    <td  valign="top">	<!-- InstanceBeginEditable name="main" -->
<table width="100%"  border="0" align="center" cellpadding="5" cellspacing="10">
      <tr>
        <td width="82%" class="Mgr_Heading">Credit &amp; Payment </td>
        <td width="18%" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td><?php echo $row_RS_dealer['cName'];?>&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
    </table><hr size="1">
	<table width="620" height="36" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr class="Mgr_Heading">
        <td width="389">Credit Balance </td>
        <td width="211" align="right">$<?php echo $credit;?></td>
      </tr>
    </table>
	<hr size="1">
	<table width="620"  border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td colspan="3" class="Mgr_Heading">Payment List </td>
        <td width="83" class="Mgr_Heading">&nbsp;</td>
        </tr>
      <tr>
        <td width="157">Received Date </td>
        <td width="86">Amount</td>
        <td width="254">Ref</td>
        <td>&nbsp;</td>
        </tr>
		<form name="fmPAY" method="POST" action="<?php echo $editFormAction; ?>">
      <tr>
        <td><select name="date" id="date">
        <?php for($i=1;$i<=31;$i++){?>
			<option value="<?php echo $i;?>"><?php echo $i;?></option>
		<?php }?>
      </select>
      <select name="month" id="month">
        <?php for($i=1;$i<=12;$i++){?>
			<option value="<?php echo $i;?>"><?php echo $i;?></option>
		<?php }?>
      </select>
      <select name="year" id="year">
        <?php for($i=2006;$i<=2016;$i++){?>
			<option value="<?php echo $i;?>"><?php echo $i;?></option>
		<?php }?>
      </select></td>
        <td>$<input name="cPaid" type="text" class="ipt_normal" id="cPaid" style="width:75px; "></td>
        <td><input name="cRef" type="text" class="ipt_normal" id="cRef" style="width:250px; "></td>
        <td><input name="Submit" type="submit" class="btn" onClick="MM_validateForm('cPaid','','RisNum');return document.MM_returnValue" value="ADD>>">
          <input type="hidden" name="MM_insert" value="fmPAY">
          <input type="hidden" name="sbm" value="<?php echo $dealer ;?>"></td>
        </tr>
<script language="javascript">
<!--
	var f = MM_findObj('year');
	var o = MM_findObj('month');
	var d = MM_findObj('date');
	d.value = "<?php echo $Date ;?>";
	f.value = "<?php echo $Year ;?>";
	o.value = "<?php echo $Month ;?>";
//-->
</script>
		</form>
      <tr align="center" class="font_white_9bold" background="./images/cms_22.gif">
        <td align="center" class="right_solid_1" background="./images/cms_22.gif">Received Date </td>
        <td align="center" class="right_solid_1" background="./images/cms_22.gif">Amount</td>
        <td align="center" class="right_solid_1" background="./images/cms_22.gif">Ref</td>
        <td background="./images/cms_22.gif">Opr</td>
        </tr>
      <?php
	   $col = "#FFFFFF";
	   do { 
	  			$showBtn = false;
				if($row_RS_paid['dtDate']=='' || strtotime($row_RS_paid['dtDate']) >= strtotime($firstday)){$showBtn=true;}
	  ?>
      <tr bgcolor="<?php echo $col;?>">
        <td align="center" class="right_solid_2"><?php echo $row_RS_paid['dtFmDate']; ?>&nbsp;</td>
        <td align="center" class="right_solid_2"><?php echo $row_RS_paid['cPaid']; ?>&nbsp;</td>
        <td class="right_solid_2"><?php echo $row_RS_paid['cRef']; ?>&nbsp;</td>
		<form name="fmDel" method="post" action="creditNpayment.php" onSubmit="if(!confirm('Are you Sure?')) return false;">
        <td><?php if($showBtn){ ?>
          <input name="del" type="submit" class="btn" value="Delete">          
          <input name="id" type="hidden" value="<?php echo $row_RS_paid['iID'];?>">
		<input name="sbm" type="hidden" value="<?php echo $dealer;?>">
		<?php }else{ ?>
		&nbsp;
		<?php }?></td>
		</form>
      </tr>
      <?php
			if($col == "#FFFFFF"){
				$col = "#F3F3F3";
			}else{
				$col = "#FFFFFF";
			}
	   } while ($row_RS_paid = mysql_fetch_assoc($RS_paid)); ?>
    </table>
	<!-- InstanceEndEditable -->
	</td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="191" background="../manage/images/m_btm.gif">&nbsp;</td>
  <td align="right" background="../manage/images/m_btm_bg.gif"><img src="../manage/images/m_btm_right.gif" width="667" height="52"></td>
  </tr>
</table>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($RS_dealer);
mysql_free_result($RS_credit);
mysql_free_result($RS_paid);
?>
