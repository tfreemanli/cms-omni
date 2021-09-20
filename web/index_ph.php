<?php
session_start();
?>
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
$query_ph = "SELECT iID, iShowIndex, cBrand, cModel, cFeature, cImg FROM tbphone order by iShowIndex desc, iID desc limit 0,2";
$ph = mysql_query($query_ph, $localhost) or die(mysql_error());
$row_ph = mysql_fetch_assoc($ph);
$totalRows_ph = mysql_num_rows($ph);

mysql_select_db($database_localhost, $localhost);
$query_news = "SELECT iID, iShowIndex, cPC, cDesc, cImg FROM tbanm WHERE iAorM = 3 order by iShowIndex desc, iID desc limit 0,3";
$news = mysql_query($query_news, $localhost) or die(mysql_error());
$row_news = mysql_fetch_assoc($news);
$totalRows_news = mysql_num_rows($news);

mysql_select_db($database_localhost, $localhost);
$query_sp = "SELECT iID, iShowIndex, cPC, cDesc, cImg FROM tbanm WHERE iAorM = 4 order by iShowIndex desc, iID desc limit 0,1";
$sp = mysql_query($query_sp, $localhost) or die(mysql_error());
$row_sp = mysql_fetch_assoc($sp);
$totalRows_sp = mysql_num_rows($sp);

mysql_select_db($database_localhost, $localhost);
$query_fb = "SELECT * FROM tbfeedback WHERE type = 'index' and status = '1' ORDER BY id DESC";
$fb = mysql_query($query_fb, $localhost) or die(mysql_error());
$row_fb = mysql_fetch_assoc($fb);
$totalRows_fb = mysql_num_rows($fb);
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
<!-- InstanceBeginEditable name="head" -->
<link href="css.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style22 {
	font-size: 18px;
	font-weight: bold;
}
-->
</style>
<!-- InstanceEndEditable -->
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
        <td valign="top"><!-- InstanceBeginEditable name="Nav" -->
          
          <img src="images/pic_left.gif" width="207" height="233"><!-- InstanceEndEditable --></td>
      </tr>
      <tr>
        <td>
          <!-- InstanceBeginEditable name="left" --><table width="204" border="0" cellpadding="0" cellspacing="0">
                    <form name="form3" method="post" action="rtp.php">
                      <tr>
                        <td width="34"><img src="./images/1x1.gif" width="34" height="1">&nbsp;</td>
                        <td width="60">Job#: </td>
                        <td width="72"><input name="cJN" type="text" class="ipt_login" id="cJN" size="6" maxlength="6">                        </td>
                        <td width="22" align="right"><input name=imageField2 type=image  onClick="MM_validateForm('cJN','','R');return document.MM_returnValue" src="./images/botton_go.gif" width="14" height="17" border=0></td>
                        <td width="16">&nbsp;</td>
                      </tr>
                    </form>
                  </table>
		  <?php include('./inc_ad_left.php');?>
		<?php include('./inc_ag_left.php');?><?php include('./inc_meebo.php');?><!-- InstanceEndEditable --></td>
      </tr>
    </table></td>
    <td width="593" rowspan="2" bgcolor="#FFFFFF">
      <!-- InstanceBeginEditable name="main" -->
      <table width="593"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="18"></td>
          <td width="575"><img src="images/1x1.gif" width="1" height="20"></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><table width="575" border="0" cellspacing="0" cellpadding="0">
            <tr valign="top">
              <td width="335"><img src="images/pic_1.gif" width="335" height="223"></td>
              <td width="5">&nbsp;</td>
              <td width="235"><table width="235" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="17"><img src="images/dot_tb_left.gif" width="17" height="49"></td>
                  <td width="218" background="images/bg_tb_top.gif">&nbsp; <strong>Repair Feature Update</strong></td>
                </tr>
                <tr>
                  <td height="174">&nbsp;</td>
                  <td valign="top" background="images/bg_tb_mid.gif"><table width="100%"  border="0" cellspacing="8" cellpadding="0">
                    <tr>
                      <td><div  id="demo" style="overflow:hidden;height:155px;width:200px;border-width:0px;">
    <div id="demo1">
        <p><?php echo str_replace("\n","<br>",$row_sp['cDesc']);?></p>
    </div>
    <div id="demo2"></div>
</div>

<script language="javascript" type="text/javascript">
<!--
var demo = document.getElementById("demo");
var demo1 = document.getElementById("demo1");
var demo2 = document.getElementById("demo2");
var speed=100;    //滚动速度值，值越大速度越慢

function Marquee(){
    if(demo2.offsetTop-demo.scrollTop<=0)   //当滚动至demo1与demo2交界时
        demo.scrollTop-=demo1.offsetHeight    //demo跳到最顶端
    else{
        demo.scrollTop++
		
    }
}
demo2.innerHTML = demo1.innerHTML    //克隆demo2为demo1
var MyMar = setInterval(Marquee,speed);        //设置定时器
demo.onmouseover = function(){clearInterval(MyMar);}    //鼠标经过时清除定时器达到滚动停止的目的
demo.onmouseout = function(){MyMar = setInterval(Marquee,100); }    //鼠标移开时重设定时器
-->
</script></td>
                    </tr>
                  </table></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td></td>
          <td><img src="images/1x1.gif" width="1" height="15"></td>
        </tr>
      </table>
      <table width="593" border="0" cellspacing="0" cellpadding="0">
        <tr valign="top">
          <td colspan="2"><table width="353" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="17"><img src="images/dot_tb_left.gif" width="17" height="49"></td>
              <td width="338" background="images/bg_tb_top.gif">&nbsp; <strong>What's <script language=javascript>            
<!-- 
function initArray() {
	this.length = initArray.arguments.length;
	for (var i = 0; i < this.length; i++) {
		this[i] = initArray.arguments[i];
   	}
}
var ctext = "HOT";
var speed = 300;
var x = 0;
var color = new initArray(
	"#000099", 
	"#33CC00", 
	"#FF0000",
	"#000000",
	"#FF00FF",
	"#FF6600");
if (navigator.appVersion.indexOf("MSIE") != -1)
{
	document.write('<span id="c" class="style2">'+ctext+'</span>');
}
function chcolor()
{ 
	 if (navigator.appVersion.indexOf("MSIE") != -1)
	 {
		document.all.c.style.color = color[x];
	 }
	(x < color.length-1) ? x++ : x = 0;
}
setInterval("chcolor()",300);
-->
</script>
                ?
              </strong></td>
            </tr>
          </table></td>
          <td width="4">&nbsp;</td>
          <td colspan="2"><table width="235" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="17"><img src="images/dot_tb_left.gif" width="17" height="49"></td>
                <td width="218" background="images/bg_tb_top.gif">&nbsp; <strong>News</strong></td>
              </tr>
          </table></td>
        </tr>
        <tr valign="top">
          <td>&nbsp;</td>
          <td bgcolor="#C7C9CB" background="images/bg_tb_mid.gif"  style="background-repeat:repeat-x"><table width="100%"  border="0" cellspacing="8" cellpadding="0">
            <?php do { ?>
            <tr>
              <td width="26%" height="132" valign="top"><a href="./ph_detail.php?id=<?php echo $row_ph['iID']; ?>"><img src="productimg/<?php echo $row_ph['cImg']; ?>" alt="" width="70" height="93" border="0" class="PhImg"></a></td>
              <td width="74%" valign="top"><p><a href="./ph_detail.php?id=<?php echo $row_ph['iID']; ?>"><span class="head_black_bold"><?php echo $row_ph['cBrand']; ?> <?php echo $row_ph['cModel']; ?></span></a><br>
                <br>
                <span class="sm_black">
                  <?php
		   $tmp = str_replace("\n","<br>",$row_ph['cFeature']);
		   		if(strlen($tmp)>131){
					echo substr($tmp, 0, strpos($tmp, ' ', 130))."...";
				}else{
					echo $tmp;
				} 
		   ?>
                </span></p></td>
            </tr>
            <?php } while ($row_ph = mysql_fetch_assoc($ph)); ?>
          </table></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td background="images/bg_tb_mid.gif"  bgcolor="#C7C9CB" style="background-repeat:repeat-x"><table width="100%"  border="0" cellspacing="4" cellpadding="0">
            <?php do { ?>
            <tr>
              <td width="27%" height="87" valign="top"><a href="event_detail.php?iID=<?php echo $row_news['iID']; ?>"><img src="productimg/<?php echo $row_news['cImg']; ?>" alt="" width="47" height="61" border="0" class="PhImg"></a></td>
              <td width="73%" valign="top"><p><a href="event_detail.php?iID=<?php echo $row_news['iID']; ?>"><span class="head_black_bold"><?php echo $row_news['cPC']; ?></span></a><br>
                <span class="sm_black">
                  <?php
		   $tmp = str_replace("\n","<br>",$row_news['cDesc']);
		   		if(strlen($tmp)>51){
					echo substr($tmp, 0, strpos($tmp, ' ', 50))."...";
				}else{
					echo $tmp;
				} 
		   ?>
                </span></p></td>
            </tr>
            <?php } while ($row_news = mysql_fetch_assoc($news)); ?>
          </table></td>
        </tr>
        <tr valign="top">
          <td width="17">&nbsp;</td>
          <td width="336" bgcolor="#C7C9CB"><table width="100%" border="0" cellspacing="20" cellpadding="0">
            <tr>
              <td height="16" align="right"><a href="./ph_list.php">More Mobiles &gt;&gt;</a></td>
            </tr>
          </table></td>
          <td>&nbsp;</td>
          <td width="18">&nbsp;</td>
          <td width="218" bgcolor="#C7C9CB"><table width="100%" border="0" cellspacing="20" cellpadding="0">
            <tr>
              <td align="right"><a href="event_list.php">More News &gt;&gt; </a></td>
            </tr>
          </table></td>
        </tr>
      </table>
      <table width="593" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td width="18" height="27">&nbsp;</td>
          <td width="575"><span class="head_red_bold">Testimonial</span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><div  id="fb_demo" style="overflow:hidden;height:100px;width:550px;border-width:0px;">
    <div id="fb_demo1">
        <?php do { ?>
              <table width="550" border="0" cellspacing="4" cellpadding="0">
                <tr>
                  <td width="93" valign="top"><strong><?php echo $row_fb['name']; ?></strong> said, </td>
                  <td width="443" valign="top"><?php echo $row_fb['desc']; ?></td>
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
</script>
		  </td>
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
mysql_free_result($ph);
mysql_free_result($news);
mysql_free_result($sp);

mysql_free_result($fb);
?>
