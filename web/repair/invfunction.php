<?php
include('./myfunction.php');
//Main Entre of the Automatic Inv Process
function doInvAuto($localhost){
	$ret = 1;
	//mysql_select_db($database_localhost, $localhost);
	$today=getdate();
	$Year=$today["year"];
	$Month=$today["mon"];
	$duedate = "20-".$Month."-".$Year;
	if($Month== 1){
		$Month = "12";
		$Year -= 1;
	}else{
		$Month -= 1;
	}

	if(!needDoInv($Year, $Month,$localhost)){
		//echo "<!-- No Need to Cal ".$Year."-".$Month."//-->";
	}else{
		//$ret = ;
		if(setInvDate("set", $Year, $Month, $localhost) || 
			cleanInv($Year, $Month, $localhost) ||
			copyInv($Year, $Month, $localhost) || 
			calInv($Year, $Month, $localhost) || 
			sendInvMail($Year, $Month, $localhost, $duedate)){
			
			//echo "<!-- AutoInv Error-->";
			setInvDate("Drop", $Year, $Month, $localhost);
		}else{
			//echo "<!--Wiiiiin!-->";
		}
		
	}//end if needDoInv()

	return $ret;
}

//Check whether that month need to do InvProcess or not
function needDoInv($Year, $Month, $localhost){
	$ret = false;
	//mysql_select_db($database_localhost, $localhost);
	$sql = "select * from tbinv_swch where cYear='".$Year."' and cMonth='".$Month."'";
	$RS = mysql_query($sql, $localhost) or $ret=mysql_error();
	//echo $sql . " ". mysql_num_rows($RS);
	if(!mysql_num_rows($RS)){
		$ret = true;
	}
	mysql_free_result($RS);
	return $ret;
}

//open or close the door that left anybody else to enter the IP(InvProcess)
function setInvDate($SetOrDrop, $Year, $Month, $localhost){
	$ret = 0;
	if($SetOrDrop=="set"){
		$sql = "insert into tbinv_swch (cYear, cMonth) values ('".$Year."','".$Month."')";
	}else{
		$sql = "delete from tbinv_swch where cYear='".$Year."' and cMonth='".$Month."'";
	}
	mysql_query($sql, $localhost) or $ret=mysql_error();
	return $ret;
}

//Clean all the Inv Info of some MONTH;
//Just for the preparation of the IP, not for being called from normal business.
function cleanInv($Year, $Month, $localhost){
	$ret = 0;
	$sql = "delete from tbinv_dtl where cYear='".$Year."' and cMonth='".$Month."'";
	mysql_query($sql, $localhost) or $ret=mysql_error();
	$sql = "delete from tbinv_pay where (cType='1' or cType='3') and cYear='".$Year."' and cMonth='".$Month."'";
	mysql_query($sql, $localhost) or $ret=mysql_error();
	return $ret;
}

//Copy Inv Info from tbrepair to tbinv_dtl
function copyInv($Year, $Month, $localhost){
	$ret = 0;
	$sql = "insert into tbinv_dtl (cYear, cMonth, cSbm, cSbmBy, iSbmType, cJN, cStatus, dtSDate, dtCDate, cSrvChg, cIIFP, cIsWrty, cIsCmmisn) ";
	$sql .= " select '".$Year."','".$Month."', cSbm, cSbmBy, iSbmType, cJN, cStatus, dtSDate, dtCDate, cSrvChg, cIIFP, cIsWrty, cIsCmmisn from tbrepair ";
	$sql .= "  where dtCDate>='".$Year."-".$Month."-1' and dtCDate<='".$Year."-".$Month."-31' and iSbmType=1 and  (cStatus = 'S25' or cStatus = 'S30' or cStatus = 'S35') ";
	mysql_query($sql, $localhost) or $ret=mysql_error();
	//echo $sql;
	return $ret;
}

//Calculate from tbinv_dtl to tbinv_pay
function calInv($Year, $Month, $localhost){
	$ret = 0;
	//cType: 1=dealer should pay; 2=dealer paid; 3=dealer commision;
	$sql = "insert into tbinv_pay (cType, dtDate, cYear, cMonth, cSbm, cSrvChg) ";
	$sql .= "select 1, NOW(), '".$Year."', '".$Month."', cSbm, sum(cSrvChg) from tbinv_dtl where dtCDate between '".$Year."-".$Month."-1' and '".$Year."-".$Month."-31' group by cSbm";
	mysql_query($sql, $localhost) or $ret=mysql_error();
	$sql = "insert into tbinv_pay (cType, dtDate, cYear, cMonth, cSbm, cCmmisn) ";
	$sql .= "select 3, NOW(), '".$Year."', '".$Month."', cSbm, 20*count(*) from tbinv_dtl where dtCDate between '".$Year."-".$Month."-1' and '".$Year."-".$Month."-31' and cIsCmmisn is not null and cIsCmmisn <>'' group by cSbm";
	mysql_query($sql, $localhost) or $ret=mysql_error();
	return $ret;
}

//Send the Inv to dealer via Email
function sendInvMail($Year, $Month, $localhost, $duedate){
	$ret = 0;
	//get dealer's info first
	$sql = "select * from tbdeal where cStatus='normal'";
	$RS = mysql_query($sql, $localhost) or $ret=mysql_error();
	while ($row_RS = mysql_fetch_assoc($RS)){ //loop dealer
		//get srvchg and commision of this month
		$sql_pay = "select sum(cSrvChg) as cSrvChg, sum(cCmmisn) as cCmmisn from tbinv_pay where cYear='".$Year."' and cMonth='".$Month."' and cSbm='".$row_RS['cLogin']."'";
		$RS_pay = mysql_query($sql_pay, $localhost) or $ret=mysql_error();
		$row_RS_pay = mysql_fetch_assoc($RS_pay);
		$SrvChg = 0.0;
		$Cmmisn = 0.0;
		if($row_RS_pay['cSrvChg'] != null && $row_RS_pay['cSrvChg'] != ""){
			$SrvChg = $row_RS_pay['cSrvChg'];
			$Cmmisn = $row_RS_pay['cCmmisn'];
		}

		//If this dealer has job in this month
		//if($row_RS_pay['cSrvChg'] != null && $row_RS_pay['cSrvChg'] != ""){
			//echo "<br>".$row_RS['cLogin']." cSrvChg = ".$row_RS_pay['cSrvChg'];
			//get previous payment of this dealer
			$sql_prevpay = "select DATE_FORMAT(dtDate,'%d %b %Y') AS dtPrevDate,cPaid from tbinv_pay where cType='2' and cSbm='".$row_RS['cLogin']."' and dtDate<'".$Year."-".$Month."-31' order by dtDate desc limit 0,1";
			$RS_prevpay = mysql_query($sql_prevpay,$localhost) or $ret=mysql_error();
			$row_RS_prevpay = mysql_fetch_assoc($RS_prevpay);
			$prevpay = 0.0;
			$prevpaydate = "";
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
			//$row_RS_dtl = mysql_fetch_assoc($RS_dtl);
			
			//make the email
			$message = makeMail($row_RS, $prevpaydate, $prevpay, $credit, $SrvChg, $Cmmisn, $RS_dtl, $duedate);
			//echo $message;
			//die();
			
			//send the email
			$subject = "OmniTech Tax Invoice of ".$Month."/".$Year;
			$headers  = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
			
			/* additional headers */
			//$headers .= "To: ".$row_RS['cEmail']."\r\n";
			$headers .= "To: ".$row_RS['cEmail']."\r\n";
			$headers .= "From: info@omnitech.co.nz\r\n";
			//$headers .= "Cc: birthdayarchive@example.com\r\n";
			//$headers .= "Bcc: tfreeman@163.com\r\n";
			
			/* and now mail it */
			//mail($row_RS['cEmail'], $subject, $message, $headers);
			//mail($row_RS['cEmail'], $subject, $message, $headers);
		//}//end if dealer has job in this month
	}//end loop dealer
	mysql_free_result($RS);
	mysql_free_result($RS_pay);
	mysql_free_result($RS_prevpay);
	mysql_free_result($RS_credit);
	mysql_free_result($RS_dtl);
	return $ret;
}//end function sendInvMail()

function makeMail($row_dealer, $prevpaydate, $prevpay, $credit, $srvchg, $cmmisn, $RS_dtl, $duedate){
	//$mailHTML = getMailHTML($row_dealer);//inc dealer's info
	//$invTabHTML = getInvTabHTML($RS_dtl);//inc inv detail table and subtotal
	$mail = "<html>
<head>
<meta http-equiv=Content-Type content=text/html; charset=iso-8859-1>
<title>Invoice</title>
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
-->
</style>
</head>

<body>
<table width=640 border=0 cellspacing=0 cellpadding=0>
  <tr>
    <td width=300> <img width=378 height=92 src=http://www.omnitech.co.nz/images/logo_simple.gif> </td>
    <td width=340 rowspan=2 align=right><p class=style4>Omni Tech Ltd<br>
      Tax invoice<br>
      GST No. <span class=style3>019-388-367</span></p>
      <p class=style4>378 Great North Road<br>
        Henderson<br>
        Auckland, New Zealand</p>      <p class=style4>Ph:09-8383943<br>
        Fax:09-8383947<br>
    Email:info@omnitech.co.nz<br>
    </p></td>
  </tr>
  <tr>
    <td><p><strong>TO:</strong><br>".$row_dealer['cName']."<br>".$row_dealer['cAdd']."<br>".$row_dealer['cContact']."</p></td>
  </tr>
</table><hr align=left width=640 size=1>
<table width=640 border=0 cellspacing=0 cellpadding=5>
  <tr>
    <td width=470 class=Mgr_Heading>Credit balance </td>
    <td width=150 align=right class=Mgr_Heading>$".$credit."</td>
  </tr>
  <tr>
    <td colspan=2><table width=400 border=0 cellspacing=0 cellpadding=2>";
	
if($prevpaydate != ""){
	$mail .="
	<tr>
	  <td>&nbsp;</td>
	  <td class=style4>Prev credit </td>
	  <td>$".($credit-$prevpay)."</td>
	  </tr>
	<tr>
        <td width=61>&nbsp;</td>
        <td width=197 class=style4>payment received ".$prevpaydate."</td>
        <td width=130>$".$prevpay."</td>
      </tr>
	";
}
	
$mail .= "<tr>
        <td width=61>&nbsp;</td>
        <td width=197 class=style4>Credit balance </td>
        <td width=130>$".$credit."</td>
      </tr>
	  </table></td>
  </tr>
</table>
<hr align=left width=640 size=1>
<table width=640 border=0 cellspacing=0 cellpadding=5>
  <tr>
    <td width=470 class=Mgr_Heading>Current charges</td>
    <td width=150 align=right class=Mgr_Heading>$".($srvchg-$cmmisn-$credit)."</td>
  </tr>
  <tr>
    <td colspan=2><table width=516 border=0 cellspacing=0 cellpadding=2>
        <tr>
          <td width=61>&nbsp;</td>
          <td width=197 class=style4>Service Charges</td>
          <td width=130>$".($srvchg-$cmmisn)."</td>
		  <td width=116>&nbsp;</td>
        </tr>
        <tr>
          <td align=right>GST incl </td>
          <td class=style4>Total Amount </td>
          <td>$".($srvchg-$cmmisn-$credit)."</td>
          <td><span class=STYLE5>due ".$duedate."</span></td>
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
  </tr>";


   $col = "#FFFFFF";
   $row_RS_dtl = mysql_fetch_assoc($RS_dtl);
    do { 
		$c = ($row_RS_dtl['cIsCmmisn']!="" && $row_RS_dtl['cIsCmmisn']!=null)? "$20.00":"&nbsp;";
	$mail .="
  <tr bgcolor=".$col.">
    <td align=center>".$row_RS_dtl['cJN']."</td>
    <td align=center>".$row_RS_dtl['dtCDate']."</td>
    <td align=center>".getStatus($row_RS_dtl['cStatus'])."</td>
    <td align=right>$".$row_RS_dtl['cSrvChg']."</td>
    <td align=center>". $c ."</td>
  </tr>";
  
  		if($col == "#FFFFFF"){
			$col = "#F3F3F3";
		}else{
			$col = "#FFFFFF";
		}
  }while ($row_RS_dtl = mysql_fetch_assoc($RS_dtl));
  
	$mail .="<tr bgcolor=".$col.">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align=right>Subtotal</td>
    <td align=right>$".$srvchg."</td>
    <td align=center>$".$cmmisn."</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align=right class=style4>Total</td>
    <td align=right>$".($srvchg-$cmmisn)."</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan=3>This invoice is due on ".$duedate."</td>
    <td colspan=2 class=style4>* All price above is GST inclusive </td>
  </tr>
  <tr>
    <td colspan=5> <span class=style4>Payment Method:</span> <br>
1. By Cheque - Please make your cheque title to Omni Tech Ltd and send it to 378 Great North Road, Henderson, 0612, Auckland. <br>
2. By Internet Banking - Please transfer the total amount due to our Westpac account as follow: <br>
Account Name: Omni Tech Ltd <br>
Account Number: 03-0155-0657330-00 </td>
  </tr>
</table>
</body>
</html>
	";
	//$ret = sprintf($mailHTML, $prevpaydate, $prevpay, $credit, $srvchg, $cmmisn, $invTabHTML);
	
	return $mail;
}
?>