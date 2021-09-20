<?php require_once('Connections/localhost.php'); ?>
<?php session_start();?>
<?php 

$MM_authorizedUsers = "dealer";

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
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "error.php?info=Dealers need to login.";
if (!((isset($_SESSION['DE_UserGroup'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['DE_Username'], $_SESSION['DE_UserGroup'])))) {   
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
mysql_select_db($database_localhost, $localhost);
$query_rs_ph = "SELECT * FROM tbphone WHERE cInStk = 'AVAILABLE' ORDER BY cBrand ASC";
$rs_ph = mysql_query($query_rs_ph, $localhost) or die(mysql_error());
$row_rs_ph = mysql_fetch_assoc($rs_ph);
$totalRows_rs_ph = mysql_num_rows($rs_ph);

mysql_select_db($database_localhost, $localhost);
$query_rs_ac = "SELECT * FROM tbanm WHERE iAorM = 2 and cInStk = 'AVAILABLE'  ORDER BY cType ASC, cBrand ASC";
$rs_ac = mysql_query($query_rs_ac, $localhost) or die(mysql_error());
$row_rs_ac = mysql_fetch_assoc($rs_ac);
$totalRows_rs_ac = mysql_num_rows($rs_ac);
mysql_select_db($database_localhost, $localhost);

$query_rs_mp = "SELECT * FROM tbanm WHERE iAorM = 1 and cInStk = 'AVAILABLE'  ORDER BY cType ASC, cBrand ASC";
$rs_mp = mysql_query($query_rs_mp, $localhost) or die(mysql_error());
$row_rs_mp = mysql_fetch_assoc($rs_mp);
$totalRows_rs_mp = mysql_num_rows($rs_mp);
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
<!-- InstanceBeginEditable name="head" -->

	  <script language="javascript">
	  <!--
	  
	  function showA(){
		var da = MM_findObj('a');
	  	var db = MM_findObj('b');
		var dc = MM_findObj('c');
	    da.style.display = "block";
	    db.style.display = "none";
	    dc.style.display = "none";
	  }
	  
	  function showB(){
		var da = MM_findObj('a');
	  	var db = MM_findObj('b');
		var dc = MM_findObj('c');
	    da.style.display = "none";
	    db.style.display = "block";
	    dc.style.display = "none";
	  }
	  
	  function showC(){
		var da = MM_findObj('a');
	  	var db = MM_findObj('b');
		var dc = MM_findObj('c');
	    da.style.display = "none";
	    db.style.display = "none";
	    dc.style.display = "block";
	  }
	  
	  function showAll(){
		var da = MM_findObj('a');
	  	var db = MM_findObj('b');
		var dc = MM_findObj('c');
	    da.style.display = "block";
	    db.style.display = "block";
	    dc.style.display = "block";
	  }
	  //-->
	  
	  </script>
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
        <td valign="top"><!-- InstanceBeginEditable name="Nav" --><!-- InstanceEndEditable --></td>
      </tr>
      <tr>
        <td>
          <!-- InstanceBeginEditable name="left" --><?php include('./inc_ad_left.php');?><!-- InstanceEndEditable --></td>
      </tr>
    </table></td>
    <td width="593" rowspan="2" bgcolor="#FFFFFF">
      <!-- InstanceBeginEditable name="main" -->
      <table width="530" border="0" align="center" cellpadding="2" cellspacing="5">
        <tr>
          <td><a href="#" onClick="javascript:showA();">Mobile Phone</a>&nbsp;&nbsp;&nbsp;<a href="#" onClick="javascript:showB();">Accessories</a>&nbsp;&nbsp;&nbsp;<a href="#" onClick="javascript:showC();">MP3/MP4</a>&nbsp;&nbsp;&nbsp;<a href="#" onClick="javascript:showAll();">SHOW All</a> </td>
        </tr>
        <tr>
          <td><form name="form1" method="post" action="de_cart.php">
		  <p>
		    <input type="submit" name="Submit2" value="Add to my order">
            <input name="from" type="hidden" id="from" value="pdlist">
</p>
		  <div id="a" style="display: block">
		  	  <table width="530" border="0" cellspacing="1" cellpadding="2">
                <tr>
                  <td colspan="5" class="head_black_bold">Mobile Phone </td>
                  </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td width="162" align="center" bgcolor="#CCCCCC"><strong>Model</strong></td>
                  <td width="88" align="center" bgcolor="#CCCCCC"><strong>Product Code </strong></td>
                  <td width="130" align="center" bgcolor="#CCCCCC"><strong>Price</strong></td>
                  <td width="104" align="center" bgcolor="#CCCCCC"><strong>Pic</strong></td>
                </tr>
                <?php do { ?>
                <tr>
                  <td><input type="checkbox" name="ph[]" value="<?php echo $row_rs_ph['iID']; ?>"></td>
                  <td align="center"><?php echo $row_rs_ph['cModel']; ?></td>
                  <td align="center"><?php echo $row_rs_ph['cPC']; ?></td>
                  <td align="center"><?php echo $row_rs_ph['cPrice2']; ?></td>
                  <td align="center"><img src="./productimg/<?php echo $row_rs_ph['cImg']; ?>" width="50" height="50" border="0"></td>
                </tr>
                <?php } while ($row_rs_ph = mysql_fetch_assoc($rs_ph)); ?>
              </table>
		  </div>
		  <div id="b" style="display: block">
		  <table width="530" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td colspan="7" class="head_black_bold">Accessories</td>
    </tr>
  <tr>
    <td width="20">&nbsp;</td>
    <td width="94" align="center" bgcolor="#CCCCCC"><strong>Type</strong></td>
    <td width="82" align="center" bgcolor="#CCCCCC"><strong>Brand</strong></td>
    <td width="68" align="center" bgcolor="#CCCCCC"><strong>Model</strong></td>
    <td width="92" align="center" bgcolor="#CCCCCC"><strong>Prod Code </strong></td>
    <td width="65" align="center" bgcolor="#CCCCCC"><strong>Price</strong></td>
    <td width="73" align="center" bgcolor="#CCCCCC"><strong>Pic</strong></td>
  </tr>
  <?php do { ?>
  <tr>
      <td><input type="checkbox" name="ac[]" value="<?php echo $row_rs_ac['iID']; ?>"></td>
      <td align="center"><?php echo $row_rs_ac['cType']; ?></td>
      <td align="center"><?php echo $row_rs_ac['cBrand']; ?></td>
      <td align="center"><?php echo $row_rs_ac['cModel']; ?></td>
      <td align="center"><?php echo $row_rs_ac['cPC']; ?></td>
      <td align="center"><?php echo $row_rs_ac['cPrice2']; ?></td>
      <td align="center"><img src="./productimg/<?php echo $row_rs_ac['cImg']; ?>" width="50" height="50" border="0"></td>
  </tr>
  <?php } while ($row_rs_ac = mysql_fetch_assoc($rs_ac)); ?>
</table>

		  
		  </div>
		  <div id="c" style="display: block">
		  <table width="530" border="0" cellspacing="1" cellpadding="2">
            <tr>
              <td colspan="6" class="head_black_bold">MP3/MP4</td>
            </tr>
            <tr>
              <td width="23">&nbsp;</td>
              <td width="82" align="center" bgcolor="#CCCCCC"><strong>Brand</strong></td>
              <td width="112" align="center" bgcolor="#CCCCCC"><strong>Model</strong></td>
              <td width="90" align="center" bgcolor="#CCCCCC"><strong>Product Code </strong></td>
              <td width="90" align="center" bgcolor="#CCCCCC"><strong>Price</strong></td>
              <td width="102" align="center" bgcolor="#CCCCCC"><strong>Pic</strong></td>
            </tr>
            <?php do { ?>
            <tr>
              <td><input type="checkbox" name="mp[]" value="<?php echo $row_rs_mp['iID']; ?>"></td>
              <td align="center"><?php echo $row_rs_mp['cBrand']; ?></td>
              <td align="center"><?php echo $row_rs_mp['cModel']; ?></td>
              <td align="center"><?php echo $row_rs_mp['cPC']; ?></td>
              <td align="center"><?php echo $row_rs_mp['cPrice2']; ?></td>
              <td align="center"><img src="./productimg/<?php echo $row_rs_mp['cImg']; ?>" width="50" height="50" border="0"></td>
            </tr>
            <?php } while ($row_rs_mp = mysql_fetch_assoc($rs_mp)); ?>
          </table>
		  </div>
          <p>
            <input type="submit" name="Submit" value="Add to my order">
          </p>
          </form></td>
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
mysql_free_result($rs_mp);
mysql_free_result($rs_ac);
mysql_free_result($rs_ph);
?>
