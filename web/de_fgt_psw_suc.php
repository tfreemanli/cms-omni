<?php require_once('Connections/localhost.php'); ?>
<?php
session_start();
if ((isset($_POST["MM_query"])) && ($_POST["MM_query"] == "form1")) {
	//check whether there is such dealer
	mysql_select_db($database_localhost, $localhost);
	$query_d = "SELECT count(*) as cnt FROM tbdeal WHERE cLogin = '".$_POST["login"]."' and cEmail='".$_POST["email"]."' and cStatus='normal'";
	$d = mysql_query($query_d, $localhost) or die(mysql_error());
	$row_d = mysql_fetch_assoc($d);
	if($row_d['cnt']!=1){
		//error
		$insertGoTo = "error.php?info=Sorry, there is not such a dealer and email registered.";
		//header("Location: ".$insertGoTo);
		die("Sorry, there is not such a dealer and email registered.");
	}

	$updateSQL = "update tbdeal set cPasswd=right(Concat(RAND(second(now())),''),6) where cLogin = '".$_POST["login"]."' and cEmail='".$_POST["email"]."' and cStatus='normal'";
	mysql_select_db($database_localhost, $localhost);
	$Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());
	
	//Send Email to the candidate
	$querySQL = "select cLogin, cPasswd, cEmail from tbdeal where cLogin = '".$_POST["login"]."' and cEmail='".$_POST["email"]."' and cStatus='normal'";
	mysql_select_db($database_localhost, $localhost);
	$RS = mysql_query($querySQL, $localhost);
	$row_RS = mysql_fetch_assoc($RS);
	$login = $row_RS['cLogin'];
	$psw = $row_RS['cPasswd'];
	$email = $row_RS['cEmail'];
	sendPsw($email, $login, $psw);
	//End Send Email
	
}else{
	//error
	$insertGoTo = "de_fgt_psw.php";
	header(sprintf("Location: %s", $insertGoTo));
}

function sendPsw($to, $login, $psw){
	/* recipients */
	//$to  = "mary@example.com" . ", " ; // note the comma
	//$to .= "kelly@example.com";
	
	/* subject */
	$subject = "Welcome to OmniTech";
	
	/* message */
	$message = '<html>
<head>
<title>Welcome</title>
</head>
<body>
<p>Thank you for registering as our dealer/member at www.OmniTech.co.nz</p>
<p>Your credentials are:</p>
<p> Login: '. $login .' <br>
  Password: '. $psw .'
</p>
<p><strong><em>Our sincerity is your service! The customers is highest, Reputation the first </em></strong><strong><em>??? </em></strong></p>
<p>------------------------------------------------------------------- </p>
<p>Regards,<br>
<strong>OmniTech Phones Repair <br>
</strong>378 Great North Road<br>
        Henderson<br>
      Auckland, New Zealand<br>Ph:09-8383943<br>
        Fax:09-8383947<br>
<a href=mailto:info@omnitech.co.nz>info@omnitech.co.nz </a><br>
www.omnitech.co.nz </p>
</body>
</html>
	';
	
	/* To send HTML mail, you can set the Content-type header. */
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	
	/* additional headers */
	$headers .= "To: ".$login." <".$to.">\r\n";
	$headers .= "From: OmniTech <info@omnitech.co.nz>\r\n";
	//$headers .= "Cc: birthdayarchive@example.com\r\n";
	//$headers .= "Bcc: birthdaycheck@example.com\r\n";
	
	/* and now mail it */
	mail($to, $subject, $message, $headers);
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><!-- InstanceBegin template="/Templates/index.dwt" codeOutsideHTMLIsLocked="false" -->
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
      <table width="100%"  border="0" cellspacing="14" cellpadding="0">
        <tr>
          <td height="35" class="head_red_bold">Forgot  Password? </td>
        </tr>
        <tr>
          <td valign="top"><table width="90%"  border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#999999">
            <tr>
              <td align="center" bgcolor="#FFFFFF"><p>&nbsp;</p>
                <p class="head_black_bold">Congratulation</p>
                <p>Your information has been proof, and your new password has been sent to </p>
                <p class="head_red_bold"><?php echo $email;?></p>
                <p>&nbsp;</p></td>
            </tr>
          </table>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
        </tr>
      </table>
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
mysql_free_result($d);
mysql_free_result($RS);
?>
