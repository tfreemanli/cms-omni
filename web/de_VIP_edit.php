<?php require_once('./Connections/localhost.php'); ?>
<?php
session_start();
if(!(isset($_SESSION['DE_UserGroup']) && $_SESSION['DE_UserGroup']=='dealer')){
	die("Unauth opr!");
}
?>
<?php
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE tbcust SET cName=%s, cLastName=%s, cVIPNum=%s, cVIPVDate=%s, cVIPEDate=%s, cEmail=%s, cHomePhn=%s, cWorkPhn=%s, cAdd1=%s, cAdd2=%s, cAdd3=%s, cFax=%s, cMake=%s, cModel=%s, cIMEI=%s WHERE iID=%s",
                       GetSQLValueString($_POST['cName'], "text"),
                       GetSQLValueString($_POST['cLastName'], "text"),
                       GetSQLValueString($_POST['cVIPNum'], "text"),
                       GetSQLValueString($_POST['cVIPVDate'], "text"),
                       GetSQLValueString($_POST['cVIPEDate'], "text"),
                       GetSQLValueString($_POST['cEmail'], "text"),
                       GetSQLValueString($_POST['cHomePhn'], "text"),
                       GetSQLValueString($_POST['cWorkPhn'], "text"),
                       GetSQLValueString($_POST['cAdd1'], "text"),
                       GetSQLValueString($_POST['cAdd2'], "text"),
                       GetSQLValueString($_POST['cAdd3'], "text"),
                       GetSQLValueString($_POST['cFax'], "text"),
						   GetSQLValueString($_POST['cMake'], "text"),
						   GetSQLValueString($_POST['cModel'], "text"),
						   GetSQLValueString($_POST['cIMEI'], "text"),
                       GetSQLValueString($_POST['iID'], "int"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());

  $updateGoTo = "de_VIP_list.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form3")) {
  $updateSQL = sprintf("UPDATE tbcust SET cStatus='deleted' WHERE iID=%s",
                       GetSQLValueString($_POST['iID3'], "int"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());

  $updateGoTo = "de_VIP_list.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rs = "1";
if (isset($_GET['iID'])) {
  $colname_rs = (get_magic_quotes_gpc()) ? $_GET['iID'] : addslashes($_GET['iID']);
}
mysql_select_db($database_localhost, $localhost);
$query_rs = sprintf("SELECT * FROM tbcust WHERE iID = %s", $colname_rs);
$rs = mysql_query($query_rs, $localhost) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);
$totalRows_rs = mysql_num_rows($rs);
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
<script language="JavaScript" type="text/JavaScript">
<!--
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
function usr_del(){
	if(confirm("Are you sure to delete this VIP Customer?")){
		var fm = MM_findObj('form3');
		fm.submit();
		//alert('yes ticked.');
		return true;
	}
	return false;
}
//-->
</script>
<script language="javascript" src="./js/common.js"></script>
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
          <td class="head_red_bold">Add VIP Members</td>
        </tr>
        <tr>
          <td><table width="95%"  border="0" align="center" cellpadding="3" cellspacing="1">
              <form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
                <tr>
                  <td width="20%" align="right" class="font_white_9bold">*First Name:</td>
                  <td width="80%">
                    <input name="cName" type="text" class="ipt_normal" id="cName" value="<?php echo $row_rs['cName']; ?>"></td>
                </tr>
                <tr>
                  <td align="right" class="font_white_9bold">Last Name: </td>
                  <td><input name="cLastName" type="text" class="ipt_normal" id="cLastName" value="<?php echo $row_rs['cLastName']; ?>"></td>
                </tr>
                <tr>
                  <td align="right">VIP Num: </td>
                  <td><input name="cVIPNum" type="text" class="ipt_normal" id="cVIPNum" value="<?php echo $row_rs['cVIPNum']; ?>"></td>
                </tr>
                <tr>
                  <td align="right">*Start Date: </td>
                  <td><input name="cVIPVDate" type="text" class="ipt_normal" id="cVIPVDate" value="<?php echo $row_rs['cVIPVDate']; ?>"></td>
                </tr>
                <tr>
                  <td align="right">*Expire Date: </td>
                  <td><input name="cVIPEDate" type="text" class="ipt_normal" id="cVIPEDate" value="<?php echo $row_rs['cVIPEDate']; ?>"></td>
                </tr>
                <tr>
                  <td align="right" class="font_white_9bold">Email:</td>
                  <td><input name="cEmail" type="text" class="ipt_normal" id="cEmail" value="<?php echo $row_rs['cEmail']; ?>"></td>
                </tr>
                <tr>
                  <td align="right" class="font_white_9bold">Home Phone:</td>
                  <td><input name="cHomePhn" type="text" class="ipt_normal" id="cHomePhn" value="<?php echo $row_rs['cHomePhn']; ?>"></td>
                </tr>
                <tr>
                  <td align="right" class="font_white_9bold">Work/Other Phone: </td>
                  <td><input name="cWorkPhn" type="text" class="ipt_normal" id="cWorkPhn" value="<?php echo $row_rs['cWorkPhn']; ?>"></td>
                </tr>
                <tr>
                  <td align="right" class="font_white_9bold">Address:</td>
                  <td><input name="cAdd1" type="text" class="ipt_normal" id="cAdd1" value="<?php echo $row_rs['cAdd1']; ?>"></td>
                </tr>
                <tr>
                  <td align="right" class="font_white_9bold">&nbsp;</td>
                  <td><input name="cAdd2" type="text" class="ipt_normal" id="cAdd2" value="<?php echo $row_rs['cAdd2']; ?>"></td>
                </tr>
                <tr>
                  <td align="right" class="font_white_9bold">&nbsp;</td>
                  <td><input name="cAdd3" type="text" class="ipt_normal" id="cAdd3" value="<?php echo $row_rs['cAdd3']; ?>"></td>
                </tr>
                <tr>
                  <td align="right" class="font_white_9bold">Home Fax: </td>
                  <td><input name="cFax" type="text" class="ipt_normal" id="cFax" value="<?php echo $row_rs['cFax']; ?>"></td>
                </tr>
  <tr>
    <td colspan="2" class="font_white_9bold"><blockquote>
      <p class="Mgr_Heading">Product Purchases</p>
    </blockquote></td>
    </tr>
  <tr>
    <td align="right" class="font_white_9bold">Make:</td>
    <td><input name="cMake" type="text" class="ipt_normal" id="cMake" value="<?php echo $row_rs['cMake']; ?>"></td>
  </tr>
  <tr>
    <td align="right" class="font_white_9bold">Model:</td>
    <td><input name="cModel" type="text" class="ipt_normal" id="cModel" value="<?php echo $row_rs['cModel']; ?>"></td>
  </tr>
  <tr>
    <td align="right" class="font_white_9bold">IMEI No:</td>
    <td><input name="cIMEI" type="text" class="ipt_normal" id="cIMEI" value="<?php echo $row_rs['cIMEI']; ?>"></td>
  </tr>
				<?
				if($row_rs['cSbmBy']==$_SESSION['DE_Username']){
				?>
                <tr>
                  <td>&nbsp;</td>
                  <td><input name="Submit" type="submit" class="btn" value=" Submit " onClick="MM_validateForm('cName','','R','cVIPVDate','','R','cVIPEDate','','R');return document.MM_returnValue" >
				   <input name="iID" type="hidden" id="iID" value="<?php echo $row_rs['iID']; ?>"></td>
                </tr>
                <input type="hidden" name="MM_update" value="form1">
				<?php }?>
              </form>
          </table>
				<?
				if($row_rs['cSbmBy']==$_SESSION['DE_Username']){
				?>
            <table width="95%"  border="0" align="center" cellpadding="3" cellspacing="1">
              <form name="form3" enctype="multipart/form-data" method="POST" action="<?php echo $editFormAction; ?>">
                <tr>
                  <td width="20%" height="31">&nbsp;</td>
                  <td width="80%">                      <input type="button" name="Submit32" value="Delete" onClick="javascript:usr_del();">
                  <input name="iID3" type="hidden" id="iID3" value="<?php echo $row_rs['iID']; ?>"></td>
                </tr>
                <input type="hidden" name="MM_update" value="form3">
              </form>
          </table>
				<?php }?></td>
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
mysql_free_result($rs);
?>
