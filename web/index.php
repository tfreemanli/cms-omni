<?php
session_start();
?>
<?php require_once('Connections/localhost.php'); ?>

<?php
mysql_select_db($database_localhost, $localhost);
$query_fb = "SELECT * FROM tbfeedback WHERE type = 'index' and status = '1' ORDER BY id DESC";
$fb = mysql_query($query_fb, $localhost) or die(mysql_error());
$row_fb = mysql_fetch_assoc($fb);
$totalRows_fb = mysql_num_rows($fb);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome To OMNITech, Your Repair Specialist! Mobile Phone Repairs iPhone Repair IPad Repair Computer Repair Nokia Sony ericsson HTC LG Samsung Sharp Motorola PSP XBox Playstation Wii</title>
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
<META NAME="Description" CONTENT="iPhone repair & Mobile Phone Repair & Computer Repair & XBox Repair & PSP Repair & Playstation Repair etc. Omni Tech Limited, a local New Zealand technology company was started with a vision to provide the New Zealand with leading edge mobile phone repairing and unlocking solutions.  Our repair team has over 15 years of cumulative mobile phone repair experience.

As the leading mobile phone repair and unlocking specialist to meet the demand of Apple iPhone, PDA, GSM mobile phone end-users, major corporations, construction industries, engineering sectors, transportation companies, food industries, tourism sectors and more; we are committed to provide an unwavering commitment to new mobile phone repair, unlocking solution with reasonable turn-around-time, realistic and affordable pricing.

Quality customer service is our Number One Priority; thus we are a customer-focus organisation.  No efforts or resources are spared to ensure the highest level of customer service and support to our customers.

Through the deployment of advanced communications, integrated systems, latest hardware and flexibility, we are able to be responsive to our customers’ individual need and ever-changing requirements.

Omni Tech Limited is 100% locally-owned company and it is committed to stay current with the advancement of mobile phone repair and unlocking.  Besides that, we constantly keep our knowledge, software and hardware with the ever expanding growth telecommunication sector.">
<META NAME="author" CONTENT="Omni Techn Limited, Auckland, New
Zealand">
<META NAME="generator" CONTENT="www.omnitech.co.nz">
<META NAME="revisit-after" CONTENT="4">
<link href="css.css" rel="stylesheet" type="text/css" />
</head>

<body class="welcome_body">
<table width="100%" border="0" cellpadding="10" cellspacing="0" class="welcome_topbar">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="1029" height="473" border="0" align="center" cellpadding="0" cellspacing="0"  id="Table_01">
	<tr>
		<td colspan="4">
			<img src="images/Untitled-1_01.jpg" width="1029" height="99" alt=""></td>
	</tr>
	<tr>
		<td colspan="4">
			<img src="images/Untitled-1_02.jpg" width="1029" height="115" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="images/Untitled-1_03.jpg" width="677" height="259" alt=""></td>
		<td><a href="index_com.php"><img src="images/Untitled-1_04.jpg" width="153" height="259" alt="" border="0"></a></td>
		<td><a href="index_ph.php"><img src="images/Untitled-1_05.jpg" width="153" height="259" alt="" border="0"></a></td>
		<td>
			<img src="images/Untitled-1_06.jpg" width="46" height="259" alt=""></td>
	</tr>
</table>
<table width="1025" border="0" align="center" cellpadding="0" cellspacing="20">
  <tr>
      <td><div  id="fb_demo" style="overflow:hidden;height:80px;width:980px;border-width:0px;">
    <div id="fb_demo1">
        <?php do { ?>
              <table width="942" border="0" cellspacing="4" cellpadding="0">
                <tr>
                  <td width="155" valign="top"><strong><?php echo $row_fb['name']; ?></strong> said, </td>
                  <td width="775" valign="top"><?php echo $row_fb['desc']; ?></td>
                </tr>
                <tr>
                  <td colspan="2" bgcolor="#999999"><img src="images/1x1.gif" width="1" height="1"></td>
                </tr>
              </table>
          <?php } while ($row_fb = mysql_fetch_assoc($fb)); ?>
    </div>
    <div id="fb_demo2"></div>
</div>

<script language="javascript" type="text/javascript">
<!--
var fb_demo = document.getElementById("fb_demo");
var fb_demo1 = document.getElementById("fb_demo1");
var fb_demo2 = document.getElementById("fb_demo2");
var speed=100;    //滚动速度值，值越大速度越慢

function Marquee(){
    if(fb_demo2.offsetTop-fb_demo.scrollTop<=0)   //当滚动至demo1与demo2交界时
        fb_demo.scrollTop-=fb_demo1.offsetHeight    //demo跳到最顶端
    else{
        fb_demo.scrollTop++
		
    }
}
fb_demo2.innerHTML = fb_demo1.innerHTML    //克隆demo2为demo1
var MyMar = setInterval(Marquee,speed);        //设置定时器
fb_demo.onmouseover = function(){clearInterval(MyMar);}    //鼠标经过时清除定时器达到滚动停止的目的
fb_demo.onmouseout = function(){MyMar = setInterval(Marquee,100); }    //鼠标移开时重设定时器
-->
</script></td>
  </tr>
</table>
<?php include('./inc_com_footer.php');?>
</body>
</html>
<?php
mysql_free_result($fb);
?>