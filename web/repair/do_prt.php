<?php require_once('../Connections/localhost.php'); ?>
<?php
include('./myfunction.php');

$colname_rs = "-1";
if (isset($_GET['iID'])) {
  $colname_rs = (get_magic_quotes_gpc()) ? $_GET['iID'] : addslashes($_GET['iID']);
}
mysql_select_db($database_localhost, $localhost);
$query_rs = "SELECT *,DATE_FORMAT(dtDate,'%d %b %Y') AS dtSDate FROM tbdo WHERE iID = '". $colname_rs."'";
$rs = mysql_query($query_rs, $localhost) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);
$totalRows_rs = mysql_num_rows($rs);

$colname_detail = "-1";
if (isset($_GET['iID'])) {
  $colname_detail = (get_magic_quotes_gpc()) ? $_GET['iID'] : addslashes($_GET['iID']);
}
mysql_select_db($database_localhost, $localhost);
$query_detail = sprintf("SELECT * FROM tbdodetail WHERE iDoID = %s ORDER BY cJN DESC", $colname_detail);
$detail = mysql_query($query_detail, $localhost) or die(mysql_error());
$row_detail = mysql_fetch_assoc($detail);
$totalRows_detail = mysql_num_rows($detail);

?>
<html>
<head>
<meta http-equiv=Content-Type content=text/html; charset=iso-8859-1>
<title>Delivery Order</title>
<link href="../manage/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../js/common.js"></script>

<script language="JavaScript" type="text/JavaScript">
<!--


function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function prt(isClose){
	window.print();
	
	if(isClose){
		self.close();
	}
	MM_goToURL('parent','do_list.php');
}
//-->
</script>
<style type=text/css>
<!--
td{
	font-family: Tahoma, Arial, Helvetica, sans-serif;
	font-size: 12px;
	line-height: 14px;
}
.Mgr_Heading {	font-family: Tahoma, Arial, Helvetica, sans-serif;
	font-size: 18px;
	font-weight: bold;
	color: #3e3e3e;
	line-height: 18px;
}
.frame_normal {	border: 1px solid #000000;
}
.style4 {font-size: 12px;
	font-weight: bold;
}
.Mgr_Heading1 {font-family: Tahoma, Arial, Helvetica, sans-serif;
	font-size: 18px;
	font-weight: bold;
	color: #3e3e3e;
	line-height: 18px;
}
.STYLE8 {font-family: Impact, Tahoma, Arial, Helvetica, sans-serif; font-size: 36px; font-weight: bold; color: #3e3e3e; line-height: 36px; }
-->
</style>
</head>
<?php 
$isCls = (isset($_GET['cls']))?"true":"false";
?>
<!--body onLoad="javascript:prt(<?php echo $isCls;?>)"//-->
<body>
<table width=640 border=0 cellspacing=0 cellpadding=0>
  <tr>
    <td width=419> <img width=378 height=92 src=http://www.omnitech.co.nz/images/logo_simple.gif> </td>
    <td width=221 rowspan=2 align=right valign="bottom"><p><span class="style4">        Omni Tech Ltd<span class=style3><br>
      </span>378 Great North Road<br>
        Henderson<br>
        Auckland, New Zealand<br>
    Ph:09-8383943<br>
    &nbsp;&nbsp;&nbsp;09-8383945<br>
        Fax:09-8383947<br>
    Email:info@omnitech.co.nz<br>
    </span></p>    </td>
  </tr>
  <tr>
    <td height="66" align="center"><p><span class="STYLE8">Delivery Order</span></p></td>
  </tr>
</table>
<table width="640" border="0" cellspacing="5" cellpadding="2">
  <tr>
    <td width="95" class="style4">Date: </td>
    <td width="522"><?php echo $row_rs['dtSDate']; ?></td>
  </tr>
  <tr>
    <td class="style4">Delivery To: </td>
    <td><?php echo $row_rs['cName']; ?></td>
  </tr>
  <tr>
    <td class="style4">Address:</td>
    <td><?php echo $row_rs['cAdd']; ?></td>
  </tr>
</table>
<table width="640" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
  <tr>
    <td width="32" align="center" bgcolor="#FFFFFF">No.</td>
    <td width="97" align="center" bgcolor="#FFFFFF">Job Num </td>
    <td width="100" align="center" bgcolor="#FFFFFF">Make</td>
    <td width="111" align="center" bgcolor="#FFFFFF">Model</td>
    <td width="167" align="center" bgcolor="#FFFFFF">IMEI/ESN</td>
    <td width="90" align="center" bgcolor="#FFFFFF">Amount</td>
  </tr>
  <?php
  $i=1;
  $amount=0;
   do { 
   		$amount += $row_detail['fSrvChg'];
   ?>
    <tr>
      <td height="30" align="center" bgcolor="#FFFFFF"><?php echo $i?></td>
      <td align="center" bgcolor="#FFFFFF"><?php echo $row_detail['cJN']; ?></td>
      <td align="center" bgcolor="#FFFFFF"><?php echo $row_detail['cMake']; ?></td>
      <td align="center" bgcolor="#FFFFFF"><?php echo $row_detail['cModel']; ?></td>
      <td align="center" bgcolor="#FFFFFF"><?php echo $row_detail['cIMEI']; ?></td>
      <td align="center" bgcolor="#FFFFFF">$<?php echo $row_detail['fSrvChg']; ?></td>
    </tr>
    <?php
		$i++;
	 } while ($row_detail = mysql_fetch_assoc($detail)); ?>
  <?php
  while($i<11){
  ?>
  <tr>
    <td height="30" align="center" bgcolor="#FFFFFF"><?php echo $i?></td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <?php
  		$i++;
   }?>
</table>
<table width="640" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td width="135">&nbsp;</td>
    <td width="63">&nbsp;</td>
    <td width="99">&nbsp;</td>
    <td width="99">&nbsp;</td>
    <td width="111" align="right">Total:</td>
    <td width="90" align="center">$<?php echo money_format('%n', $amount); ?></td>
  </tr>
  <tr>
    <td align="right">TOTAL QTY DELIVER:</td>
    <td><?php echo $row_rs['cItemQty']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
</table>
<table width="639" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td height="51">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="20">&nbsp;</td>
    <td width="152" class="style4">Signed and received by:</td>
    <td width="184" class="style4">&nbsp;</td>
    <td colspan="2" class="style4">Signed and delivered by:</td>
  </tr>
  <tr>
    <td height="50">&nbsp;</td>
    <td style="border-bottom:2px, solid, #000000;">&nbsp;</td>
    <td>&nbsp;</td>
    <td width="152" style="border-bottom:2px, solid, #000000;">&nbsp;</td>
    <td width="95">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Name:</td>
    <td>&nbsp;</td>
    <td colspan="2">Name:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Date:</td>
    <td>&nbsp;</td>
    <td colspan="2">Date:</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rs);
mysql_free_result($detail);
?>