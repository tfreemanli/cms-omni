<?php require_once('Connections/localhost.php'); ?>
<?php
session_start();

$currentPage = $_SERVER["PHP_SELF"];

//deal with the search functing
$where_clu = " where (cStatus = 'S25' or cStatus = 'S30' or cStatus = 'S35') ";
$today=getdate();
$cYear=$today["year"];
$cMonth=$today["mon"];
if(isset($_POST['year'])){
	$cYear=$_POST['year'];
	$cMonth=$_POST['month'];
}
$enddate = $cYear."-".$cMonth."-31";
if($cMonth == "1"){
	//$startdate = ($cYear-1)."-12-21";
}else{
	//$startdate = $cYear."-".($cMonth-1)."-21";
}
$startdate = $cYear."-".$cMonth."-1";

$where_clu .= " and dtCDate between '".$startdate."' and '". $enddate."'";

$where_clu .= " and cSbm = '". $_SESSION['DE_Username'] ."'";
	
//end of search funtion

mysql_select_db($database_localhost, $localhost);
$query_req = "SELECT iID, cJN, cStatus, dtSDate, dtCDate, cSrvChg, cIIFP, cIsWrty, cIsCmmisn FROM tbinv_dtl ".$where_clu." ORDER BY dtCDate DESC";
$req = mysql_query($query_req, $localhost) or die(mysql_error());
$row_req = mysql_fetch_assoc($req);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html><!-- InstanceBegin template="/Templates/index.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<link rel="shortcut icon" href="http://www.omnitech.co.nz/favicon.ico" />
<meta http-equiv="Content-Type" content="text/html; charset=gbk">
<META NAME="description" CONTENT="The leading repair specialist for
GSM, CDMA and 3G mobile phones. Able to unlock, unblock and fix water
damaged mobile phones (Nokia, Samsung, Sony Ercisson, Motorola, I-Mate,
Vodafone, Telecom)
378 Great North Road, Henderson
Waitakere 0612, New Zealand
Tel: (09) 838-3943, Fax: (09) 838-3947
sales@omnitech.co.nz, www.omnitech.co.nz">
<META NAME="keywords" CONTENT="mobile phone repair, gsm, unblock,
vodafone, damage, fix, telecom, unlock, reverse phone, reverse phone
number, unblock code, cingular gsm, unblock security, gsm codes,
at&t telecom, security fix, imei unlock, unblock sim, network
telecom, gsm network, motorola unlock, samsung unlock, unlock sim, gsm
sim, unlock sim card, motorola unblock, sim card phone, motorola gsm,
samsung vodafone, unblock sim card, gsm software, orange gsm, samsung
gsm, unlock codes, cell gsm, siemens unlock, imei number unlock, o2
vodafone, unlock software, vodafone orange, puk code unlock, remote
unlock, unlock code, siemens gsm, unlock security, orange unlock,
calculator unlock, simlock unlock, cellular phone fix, fix mobile
phone, gsm phone repair, t mobile, phone book, phone numbers, cell
phone, phone number, phone directory, reverse phone lookup, windows
mobile, phone lookup, phone number search, chocolate phone, phone sex,
phone number lookup, mobile homes, boost mobile, reverse phone
directory, t mobile com, t mobile dash, auto repair, phone number look
up, motorola phone tools, phone search, verizon phone, go phone, cell
phone plans, unblock codes, razor phone, computer repair, movie phone,
phone service, phone cards, cell phone numbers, cell phone reviews,
reverse phone number lookup, phone look up, reverse phone look up, free
cell phone, mobile alabama, credit repair, cell phone directory,
verizon cell phone, phone card, blackjack phone, cordless phone,
cingular phone, windows mobile 5.0, reverse phone search, my t mobile,
internet phone, cell phone accessories, windows mobile 5, free reverse
phone, appliance repair, lg phone, cell phone number, reverse phone
book, mobile al, amp d mobile, car repair, mobile phone tools, razr
phone, t mobile mda, phone listings, best cell phone, banana phone,
reverse phone number look up, ampd mobile, cell phone service, tv
repair, chocolate cell phone, prepaid phone, smart phone, reverse cell
phone, motorola phone, shoe repair, trac phone, cell phone lookup,
prepaid cell phone, secret unblock, phone companies, ipod repair, cell
phone covers, phone covers, reverse phone number search, cell phone
deals, t mobile sidekick, reverse phone numbers, samsung phone, phone
books, www t mobile com, pda phone, mobile homes for sale, free phone,
phone scoop, apple phone, motorola cell phone, mobile broadband, find
phone number, watch repair, cell phone batteries, camera repair, phone
reviews, phone services, brain damage, cricket phone, registry
repair,disney mobile, lg cell phone,phone chat, phone trace, phone
systems, phone listing, www t mobile, windshield repair, ip phone,
nextel phone, mobile phone, cell phone companies, nerve damage,
registry fix, find a phone number, cell phone battery, cell phone
games, cell phone review, cingular cell phone, video phone, exxon
mobile, samsung cell phone, mobile home, cell phone wallpaper, water
damage, free reverse phone number, mobile games, cell phone case, voip
phone, laptop repair, ipod phone, verizon mobile, cell phone plan, cell
phone charger, phone accessories, camera phone, prank phone calls,
phone tracker, damage meter, fix you,phone codes, satellite phone,
">
<META NAME="robot" CONTENT="index,follow">
<META NAME="copyright" CONTENT="Copyright ? 2007 Omni Techn Limited,
Auckland, New Zealand">
<META NAME="author" CONTENT="Omni Techn Limited, Auckland, New
Zealand">
<META NAME="generator" CONTENT="www.omnitech.co.nz">
<META NAME="revisit-after" CONTENT="4">
<!-- InstanceBeginEditable name="doctitle" -->
<title>OmniTech</title>
<!-- InstanceEndEditable --><link href="css.css" rel="stylesheet" type="text/css">
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
  } if (errors) alert('The following error(s) occurred:\n'+errors);
  document.MM_returnValue = (errors == '');
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
</head>

<body onLoad="MM_preloadImages('images/btn_hm_.gif')">
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="672" height="18" background="images/top_bg.gif">&nbsp;</td>
    <td width="128" align="right" background="images/top_bg.gif"><img src="images/btn_top.gif" width="128" height="18" border="0" usemap="#Map"></td>
  </tr>
</table>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="207" height="82" valign="bottom" background="images/logo_top.gif"><?php include('./inc_sch.php') ;?></td>
    <td width="593" align="right" valign="top" background="images/top_bg2.gif"><table width="575" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><img src="images/banner_top.gif" width="575" height="64"></td>
      </tr>
      <tr>
        <td><table width="575" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="96"><a href="index_ph.php"><img src="images/btn_hm.gif" width="96" height="18" border="0" id="hm" onMouseOver="MM_swapImage('hm','','images/btn_hm_.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
            <td width="96"><a href="aboutus.php"><img src="images/btn_ab.gif" width="96" height="18" border="0" id="ab" onMouseOver="MM_swapImage('ab','','images/btn_ab_.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
            <td width="96"><a href="ph_list.php"><img src="images/btn_mp.gif" width="96" height="18" border="0" id="mp" onMouseOver="MM_swapImage('mp','','images/btn_mp_.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
            <td width="96"><a href="repair.php"><img src="images/btn_rp.gif" width="96" height="18" border="0" id="rp" onMouseOver="MM_swapImage('rp','','images/btn_rp_.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
            <td width="96"><a href="unlock.php"><img src="images/btn_ul.gif" width="96" height="18" border="0" id="ul" onMouseOver="MM_swapImage('ul','','images/btn_ul_.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
            <td width="95"><a href="contact.php"><img src="images/btn_ct.gif" width="96" height="18" border="0" id="ct" onMouseOver="MM_swapImage('ct','','images/btn_ct_.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr valign="top">
    <td width="207" bgcolor="#FFFFFF"><table width="207" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top"><!-- InstanceBeginEditable name="Nav" --><!-- InstanceEndEditable --></td>
      </tr>
      <tr>
        <td>
          <!-- InstanceBeginEditable name="left" --><?php include('./inc_ad_left.php');?><!-- InstanceEndEditable --></td>
      </tr>
    </table></td>
    <td width="593" rowspan="2" bgcolor="#FFFFFF">
      <!-- InstanceBeginEditable name="main" -->
	<?php include('repair/myfunction.php');?>
<p><span class="head_black_bold">Invoice Query </span></p>
<p>&nbsp; <strong>Note</strong>: This invoice query is automatically generated by our server. And it's only an invoice query, the actual invoice will be/has been posted to you on 1st of the month.</p>
<form method="post" name="fmStat" id="fmStat" onSubmit="javascript:do_stat();return false;">
  <p>&nbsp;&nbsp;&nbsp;
  Year:
      <select name="year" id="year">
        <option value="2006">2006</option>
        <option value="2007">2007</option>
        <option value="2008">2008</option>
        <option value="2009">2009</option>
        <option value="2010">2010</option>
        <option value="2011">2011</option>
        <option value="2012">2012</option>
      </select>
&nbsp;&nbsp;&nbsp;Month
  <select name="month" id="month">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
    </select>
    <input name="cSbm" type="hidden" id="cSbm" value="<?php echo $_SESSION['DE_Username'];?>">
    <input type="submit" name="GO" value="GO">
</p>
</form>
<script language="javascript">
<!--
	var f = MM_findObj('year');
	var o = MM_findObj('month');
	f.value = "<?php echo $cYear ;?>";
	o.value = "<?php echo $cMonth ;?>";
//-->
</script>
<table width="539"  border="0" align="center" cellpadding="0" cellspacing="0">
      <tr class="font_white_9bold" align="center">
        <td width="11" valign="top" background="repair/images/cms_20.gif"><img src="repair/images/cms_19.gif" width="11" height="12"></td>
        <td width="68" background="repair/images/cms_22.gif" class="STYLE1">Job No.</td>
        <td width="113" background="repair/images/cms_22.gif" class="STYLE1">Cmplt Date</td>
        <td width="113" background="repair/images/cms_22.gif" class="STYLE1">Sbmt Date</td>
        <td width="110" background="repair/images/cms_22.gif" class="STYLE1">Status</td>
        <td width="82" background="repair/images/cms_22.gif" class="STYLE1">Srv Chg</td>
        <td width="75" background="repair/images/cms_22.gif" class="STYLE1">Commision</td>
        <td width="75" background="repair/images/cms_22.gif" class="STYLE1">Warranty</td>
      </tr>
      <?php
   $col = "#FFFFFF";
   $commision = 0.0;
    do { ?>
      <tr bgcolor="<?php echo $col;?>" class="font_red_12">
        <td background="repair/images/cms_20.gif">&nbsp;</td>
        <td bgcolor="<?php echo $col;?>" class="right_solid_1"><a href="de_srf.php?cJN=<?php echo $row_req['cJN']; ?>"><?php echo $row_req['cJN']; ?></a></td>
        <td class="right_solid_1"><?php echo $row_req['dtCDate']; ?></td>
        <td class="right_solid_1"><?php echo $row_req['dtSDate']; ?></td>
        <td class="right_solid_1"><?php echo getStatus($row_req['cStatus']); ?></td>
        <td class="right_solid_1"><?php echo $row_req['cSrvChg']; ?></td>
        <td class="right_solid_1">
		<?php
		if($row_req['cIsCmmisn']!="" && $row_req['cIsCmmisn']!=null){
			echo "25.00";
			$commision += 25.0;
		}
		 ?>&nbsp;</td>
        <td class="right_solid_1"><?php echo $row_req['cIsWrty']; ?>&nbsp;</td>
      </tr>
      <?php
  		if($col == "#FFFFFF"){
			$col = "#E3E3E3";
		}else{
			$col = "#FFFFFF";
		}
    } while ($row_req = mysql_fetch_assoc($req)); ?>
      <tr class="font_red_12">
        <td background="repair/images/cms_20.gif"></td>
        <td colspan="7" align="right" bgcolor="#EFEFEF" class="right_solid_1"><img src="images/1x1.gif" width="1" height="1"></td>
        </tr>
      <tr class="font_red_12">
	  <?php 
	  $query_req = "select sum(cSrvChg) as cSrvChg  from tbinv_dtl ". $where_clu;
	  $req = mysql_query($query_req, $localhost) or die(mysql_error());
	  $row_req = mysql_fetch_assoc($req);
	  ?>
        <td background="repair/images/cms_20.gif">&nbsp;</td>
        <td colspan="4" align="right" class="right_solid_1"><strong>Subtotal</strong>:</td>
        <td class="right_solid_1"><?php echo $row_req['cSrvChg'];?>&nbsp;</td>
        <td colspan="2" class="right_solid_1">
		<?php
		echo $commision;
		?>&nbsp;</td>
        </tr>
      <tr class="font_red_12">
        <td background="repair/images/cms_20.gif">&nbsp;</td>
        <td colspan="4" align="right" class="right_solid_1"><strong>Total</strong>:</td>
        <td colspan="3" class="right_solid_1"><?php echo $row_req['cSrvChg'] - $commision;?>&nbsp;</td>
        </tr>
    </table>
<p>&nbsp;</p>
    <!-- InstanceEndEditable -->    </td>
  </tr>
  <tr valign="top">
    <td valign="bottom" bgcolor="#FFFFFF"><?php include('./inc_footer.php');?></td>
  </tr>
</table>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#F68F1E"><?php include('./inc_footer2.php');?></td>
  </tr>
</table>
<br>
<map name="Map">
  <area shape="rect" coords="77,2,125,14" href="feedback.php">
</map>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($req);
?>
