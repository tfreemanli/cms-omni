<?php require_once('../Connections/localhost.php'); ?>
<?php
include('./myfunction.php');

session_start();
$MM_authorizedUsers = "admin";
$MM_authorizedGroups = "tbopr";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "error.php?info=Sorry, you are not authorised for this operation.";
if (!((isset($_SESSION['RP_Username'])) && (isAuthorized($MM_authorizedUsers, $MM_authorizedGroups, $_SESSION['RP_Username'], $_SESSION['RP_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
$dealer = "omnitech";
$today=getdate();
$Year=$today["year"];
$Month=$today["mon"];
if(isset($_GET['year'])){
	$Year=$_GET['year'];
	$Month=$_GET['month'];
	$dealer = $_GET['dealer'];
}
$tmpYear = $Year;
$tmpMonth = $Month+1;
if($tmpMonth==13){
	$tmpMonth = 1;
	$tmpYear = $Year+1;
}
$obMonth = array('','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
$duedate = "20-".$tmpMonth."-".$tmpYear;


mysql_select_db($database_localhost, $localhost);
	$sql = "select * from tbdeal where cLogin='".$dealer."' and  cStatus='normal'";
	$RS = mysql_query($sql, $localhost) or $ret=mysql_error();
	$row_RS = mysql_fetch_assoc($RS);
		//get SrvChg and commision of this month
		$sql_pay = "select sum(cSrvChg) as cSrvChg, sum(cCmmisn) as cCmmisn from tbinv_pay where cYear='".$Year."' and cMonth='".$Month."' and cSbm='".$row_RS['cLogin']."'";
		$RS_pay = mysql_query($sql_pay, $localhost) or $ret=mysql_error();
		$row_RS_pay = mysql_fetch_assoc($RS_pay);
		$SrvChg = 0.0;
		$Cmmisn = 0.0;
		if($row_RS_pay['cSrvChg'] != null && $row_RS_pay['cSrvChg'] != ""){
			$SrvChg = $row_RS_pay['cSrvChg'];
			$Cmmisn = $row_RS_pay['cCmmisn'];
		}
			//modi at 13-1-2008, as PAYMENT RECEIVED shows all payment during last month
			//$sql_prevpay = "select DATE_FORMAT(dtDate,'%d %b %Y') AS dtPrevDate,cPaid, cRef from tbinv_pay where cType='2' and cSbm='".$row_RS['cLogin']."' and dtDate<'".$Year."-".$Month."-31' order by dtDate desc limit 0,1";
			$sql_prevpay = "select DATE_FORMAT(dtDate,'%d %b %Y') AS dtPrevDate,cPaid, cRef from tbinv_pay where cType='2' and cSbm='".$row_RS['cLogin']."' and dtDate between '".$Year."-".$Month."-1' and '".$Year."-".$Month."-31' order by dtDate desc";
			
			$RS_prevpay = mysql_query($sql_prevpay,$localhost) or $ret=mysql_error();
			$prevpay = 0.0;
			$prevpaydate = "";
			$row_RS_prevpay = mysql_fetch_assoc($RS_prevpay);
			if($row_RS_prevpay['dtPrevDate'] != null && $row_RS_prevpay['dtPrevDate'] != ""){
				$prevpay = $row_RS_prevpay['cPaid'];
				$prevpaydate = $row_RS_prevpay['dtPrevDate'];
			}
			
			//get credit of this dealer
			
			$sql_credit = "select (sum(cPaid)+sum(cCmmisn)-sum(cSrvChg)) as credit from tbinv_pay where cSbm='".$row_RS['cLogin']."' and dtDate<='".$Year."-".$Month."-31'";
			$RS_credit = mysql_query($sql_credit,$localhost) or $ret=mysql_error();
			$row_RS_credit = mysql_fetch_assoc($RS_credit);
			$credit = 0.0;
			if($row_RS_credit['credit'] != null && $row_RS_credit['credit'] != ""){
				$credit = $row_RS_credit['credit'];
			}
			
			//get inv detail of this dealer
			$sql_dtl = "select * from tbinv_dtl where cYear='".$Year."' and cMonth='".$Month."' and cSbm='".$row_RS['cLogin']."'";
			$RS_dtl = mysql_query($sql_dtl,$localhost) or $ret=mysql_error();
			
			
?>
<html>
<head>
<meta http-equiv=Content-Type content=text/html; charset=iso-8859-1>
<title>Invoice</title>
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
.STYLE5 {
	color: #990000;
	font-weight: bold;
}
.Mgr_Heading1 {font-family: Tahoma, Arial, Helvetica, sans-serif;
	font-size: 18px;
	font-weight: bold;
	color: #3e3e3e;
	line-height: 18px;
}
.STYLE6 {font-size: 24px}
-->
</style>
</head>

<body onLoad="javascript:prt(false)">
<table width=640 border=0 cellspacing=0 cellpadding=0>
  <tr>
    <td width=442> <img width=378 height=92 src=http://www.omnitech.co.nz/images/logo_simple.gif> </td>
    <td width=198 rowspan=3 align=right><p><span class="style4"><span class="Mgr_Heading1"><span class="STYLE6">Tax Invoice</span></span><br>
    </span>for <?php echo $obMonth[$Month];?> <?php echo $Year;?><span class="style4"><br><br>
        Omni Tech Ltd<br>
      GST No. 091-388-367<br>
    378 Great North Road<br>
  Henderson<br>
  Auckland, New Zealand<br>
      Ph:09-8383943<br>
      09-8383945<br>  
      Fax:09-8383947<br>
  Email:info@omnitech.co.nz<br> 
    </span></p></td>
  </tr>
  <tr>
    <td><p><strong>TO:</strong><br><?php echo $row_RS['cName'];?><br><?php echo $row_RS['cMailAdd'];?><br><?php echo $row_RS['cContact'];?></p></td>
  </tr>
  <tr>
    <td><strong>INVOICE NUMBER:</strong> M<?php echo $Year;?><?php echo substr(strval($Month+100),1,2);?><?php echo substr(strval($row_RS['iID']+1000),1,3);?></td>
  </tr>
</table>
<hr align=left width=640 size=1>
<table width=640 border=0 cellspacing=0 cellpadding=5>
  <tr>
    <td width=470 class=Mgr_Heading>Credit balance </td>
    <td width=150 align=right class=Mgr_Heading>$<?php echo money_format('%n', $credit);?></td>
  </tr>
  <tr>
    <td colspan=2><table width=562 border=0 cellspacing=0 cellpadding=2>
	<?php 
if($prevpaydate != ""){ ?>
	<!--//<tr>
	  <td>&nbsp;</td>
	  <td class=style4>Previous credit </td>
	  <td>$<?php echo $credit-$prevpay;?></td>
	  </tr>//-->
	  <?php do{ ?>
		  <tr>
			<td width=47>&nbsp;</td>
			<td width=352 class=style4><?php echo ($row_RS_prevpay['cRef']!='')?$row_RS_prevpay['cRef']:'Payment received';?> <?php echo $row_RS_prevpay['dtPrevDate'];?></td>
			<td width=151>$<?php echo  money_format('%n', $row_RS_prevpay['cPaid']);?></td>
		  </tr>
	  <?php	
	  }while($row_RS_prevpay = mysql_fetch_assoc($RS_prevpay));
}// end if prevpaydate!=''?>
<tr>
        <td width=47>&nbsp;</td>
        <td width=352 class=style4>Credit balance </td>
        <td width=151>$<?php echo  money_format('%n', $credit);?></td>
      </tr>
	  </table></td>
  </tr>
</table>
<hr align=left width=640 size=1>
<table width=640 border=0 cellspacing=0 cellpadding=5>
  <tr>
    <td width=470 class=Mgr_Heading>Current charges</td>
    <td width=150 align=right class=Mgr_Heading>$<?php echo  money_format('%n', ($SrvChg-$Cmmisn-$credit));?></td>
  </tr>
  <tr>
    <td colspan=2><table width=624 border=0 cellspacing=0 cellpadding=2>
        <tr>
          <td width=50>&nbsp;</td>
          <td width=349 class=style4>Service Charges</td>
          <td width=108>$<?php echo  money_format('%n', ($SrvChg-$Cmmisn));?></td>
          <td width=101>&nbsp;</td>
        </tr>
        <tr>
          <td align="right">GST incl </td>
          <td class=style4>Total Amount </td>
          <td>$<?php echo  money_format('%n', ($SrvChg-$Cmmisn-$credit));?></td>
          <td><span class="STYLE5">due <?php echo $duedate;?></span></td>
        </tr>
    </table></td>
  </tr>
</table>
<hr align=left width=640 size=1>
<table width=640 border=0 cellspacing=0 cellpadding=5>
  <tr>
    <td width=470 class=Mgr_Heading>Details</td>
    <td width=150 align=right class=Mgr_Heading>&nbsp;</td>
  </tr>
</table>
<table width=640 border=0 cellspacing=0 cellpadding=2>
  <tr align=center bgcolor=#e3e3e3 class=style4>
    <td width=125>Job No. </td>
    <td width=123>Complete Date </td>
    <td width=123>Status</td>
    <td width=124>ServiceCharge</td>
    <td width=125>Commision</td>
  </tr>
 <?php 
   $col = "#FFFFFF";
   $row_RS_dtl = mysql_fetch_assoc($RS_dtl);
    do { 
		$c = ($row_RS_dtl['cIsCmmisn']!="" && $row_RS_dtl['cIsCmmisn']!=null)? "$20.00":"&nbsp;";
?>
  <tr bgcolor=<?php echo $col ;?>>
    <td align=center><?php echo $row_RS_dtl['cJN'];?></td>
    <td align=center><?php echo $row_RS_dtl['dtCDate'];?></td>
    <td align=center><?php echo getStatus($row_RS_dtl['cStatus']);?></td>
    <td align=right>$<?php echo $row_RS_dtl['cSrvChg'];?></td>
    <td align=center><?php echo $c;?></td>
  </tr>
<?php
  
  		if($col == "#FFFFFF"){
			$col = "#F3F3F3";
		}else{
			$col = "#FFFFFF";
		}
  }while ($row_RS_dtl = mysql_fetch_assoc($RS_dtl));
?>
<tr bgcolor=<?php echo $col;?>>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align=right>Subtotal</td>
    <td align=right>$<?php echo  money_format('%n', $SrvChg);?></td>
    <td align=center>$<?php echo  money_format('%n', $Cmmisn);?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align=right class=style4>Total</td>
    <td align=right>$<?php echo  money_format('%n', ($SrvChg-$Cmmisn));?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan=3>This invoice is due on <?php echo $duedate;?></td>
    <td colspan=2 class=style4>* All price above is GST inclusive </td>
  </tr>
  <tr>
    <td colspan=5><span class=style4>Payment Method:</span> <br>
1. By Cheque - Please make your cheque title to Omni Tech Ltd and send it to 378 Great North Road, Henderson, 0612, Auckland. <br>
2. By Internet Banking - Please transfer the total amount due to our Westpac account as follow: <br>
Account Name: Omni Tech Ltd <br>
Account Number: 03-0155-0657330-00 <br>
<br>
<STRONG>PLEASE NOTE:</STRONG><BR>
<STRONG>COST OF RECOVERY   &amp; INTEREST @ 3% PER MONTH WILL BE CHARGED ON ALL OVERDUE   ACCOUNTS.</STRONG></td>
  </tr>
</table>
</body>
</html>
<?php
	mysql_free_result($RS);
	mysql_free_result($RS_pay);
	mysql_free_result($RS_prevpay);
	mysql_free_result($RS_credit);
	mysql_free_result($RS_dtl);
?>