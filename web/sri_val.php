<?php require_once('Connections/localhost.php'); ?>
<?php
$colname_rs = "1";
if (isset($_POST['cJN'])) {
  $colname_rs = (get_magic_quotes_gpc()) ? $_POST['cJN'] : addslashes($_POST['cJN']);
}else if(isset($_GET['cJN'])) {
  $colname_rs = (get_magic_quotes_gpc()) ? $_GET['cJN'] : addslashes($_GET['cJN']);
}
mysql_select_db($database_localhost, $localhost);
$dt_fm = "%d %b %Y";
$query_rs = sprintf("SELECT *,DATE_FORMAT(dtSDate,'%s') as dtSDate2,DATE_FORMAT(dtCDate,'%s') as dtCDate2, cLMake, cLModel, cLDeposit, cIMEI, cLB, cLC, cLother FROM tbrepair WHERE cJN = '%s'",$dt_fm,$dt_fm, $colname_rs);
$rs = mysql_query($query_rs, $localhost) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);
$totalRows_rs = mysql_num_rows($rs);
if($row_rs['cStatus']!='S25' && $row_rs['cStatus']!='S30' && $row_rs['cStatus']!='S35'){
	header("Location: ". "error.php?info=There is not service report for an unfinished job.");
}
?>
<?php
session_start();
if (isset($_POST['cCName'])) {
    $GLOBALS['CT_Name'] = $_POST['cCName'];
    $GLOBALS['CT_LastName'] = $_POST['cCLastName'];
    session_register("CT_Name");
    session_register("CT_LastName");
}
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
<style type="text/css">
<!--
.Mgr_Heading {	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 18px;
	font-weight: bold;
	color: #3e3e3e;
	line-height: 18px;
}
.frame_normal {	border: 1px solid #000000;
}
.style2 {color: #FF0000}
.STYLE3 {
	color: #990000;
	font-weight: bold;
}
-->
</style>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
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
<?php

if (!((isset($_SESSION['DE_Username'])) && ($_SESSION['DE_Username']==$row_rs['cSbm']||$_SESSION['DE_Userrealname']==$row_rs['cSbmBy']))) {   
  //if the viewer is not the submiting dealer, then check the customer's name
  if(isset($_SESSION['CT_Name'])){
  	//if has input the customer's name
	if(strtolower($_SESSION['CT_Name'])!=strtolower($row_rs['cCName']) || strtolower($_SESSION['CT_LastName'])!=strtolower($row_rs['cCLastName'])){
		//if the customer's name is not correct.
		//show the input box and stop
?>
      <p>&nbsp;</p>
      <table width="528" border="0" align="center" cellpadding="0" cellspacing="5">
        <tr>
          <td colspan="3" class="head_black_bold">&nbsp;Oop! Sorry your name does not match! Please re-enter your name according to as follow &amp; <span class="style2">make sure your name is the same as the name your enter at your service request form:</span> </td>
        </tr><form name="form1" method="post" action="sri_val.php">
        <tr>
          <td align="right">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td width="172" align="right">Please enter your name here:</td>
          <td width="168" align="center">
            <input name="cCName" type="text" id="cCName" value="<?php echo $_SESSION['CT_Name'];?>"></td>
          <td width="168" align="center"><input name="cCLastName" type="text" id="cCLastName" value="<?php echo $_SESSION['CT_LastName'];?>"></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="center">(first name)</td>
          <td align="center">(last name)</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="2"><input type="submit" name="Submit" value="Submit">
            <input name="cJN" type="hidden" id="cJN" value="<?php echo $_POST['cJN']; ?>"></td>
        </tr>
        <tr>
          <td colspan="3">&nbsp;</td>
          </tr>
        </form>
      </table>
      <p>&nbsp;</p>
<?php
	}else{
		//if the customer's name is correct.
		//show the sri
		?>
      <table width="100%" border="0" cellspacing="10" cellpadding="0">
        <tr>
          <td width="357" height="22" align="center" class="Mgr_Heading"> Services Report</td>
          <td width="34">Date: </td>
          <td width="108" align="center" class="frame_normal"><?php echo $row_rs['dtCDate2'];?>&nbsp;</td>
        </tr>
      </table>
      <div align="right">
      <table width="95%" border="0" align="center" cellpadding="2" cellspacing="0">
        <tr>
          <td align="left"><strong>Job Details<br>
            </strong>Submitted Date £º <?php echo $row_rs['dtSDate2']; ?><br>
      Submitted By £º <?php echo $row_rs['cSbmBy']; ?><br>
      Job No.: <span class="frame_normal"><?php echo $row_rs['cJN']; ?></span><br>
	  <?php
	$fontcolor = "#000000";
	if($row_rs['cIsWrty']!="") {$fontcolor = "#FF0000"; }
	  ?>
      Service Charge £º <span style="color:<?php echo $fontcolor;?>; ">$<?php echo $row_rs['cSrvChg']; ?></span> <?php echo $row_rs['cIIFP']; ?> <?php echo $row_rs['cIsWrty']; ?><br>
      Job Completion Date £º <?php echo $row_rs['dtCDate2']; ?></td>
        </tr>
		<?php if($row_rs['cLMake']!= null && $row_rs['cLMake']!= ""){?>
        <tr>
          <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td align="left"><span class="STYLE3">Loan Equipment</span><br>
            <table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
              <tr>
                <td width="19%" align="right">Handset Make: </td>
                <td width="24%"><?php echo $row_rs['cLMake']; ?></td>
                <td width="17%" align="right">Handset Model:</td>
                <td width="40%"><?php echo $row_rs['cLModel']; ?></td>
              </tr>
              <tr>
                <td align="right">Deposit taken: </td>
                <td><?php echo $row_rs['cLDeposit']; ?></td>
                <td align="right">IMEI</td>
                <td><?php echo $row_rs['cLIMEI']; ?></td>
              </tr>
              <tr>
                <td><input name="cLB" type="checkbox" id="cLB" value="checked" <?php echo $row_rs['cLB']; ?> disabled>
                  Battery</td>
                <td><input name="cLC" type="checkbox" id="cLC" value="checked" <?php echo $row_rs['cLC']; ?> disabled>
                  Charger</td>
                <td align="right">Other:</td>
                <td><?php echo $row_rs['cLother']; ?></td>
              </tr>
            </table></td>
        </tr>
		<?php }?>
        <tr>
          <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td align="left"><strong>Customer Details</strong><br>
      Name £º <?php echo $row_rs['cCName']; ?> <?php echo $row_rs['cCLastName']; ?><br>
      Contact Phone No.£º <?php echo $row_rs['cCHomePhn']; ?> <?php echo $row_rs['cCWorkPhn']; ?> <?php echo $row_rs['cCFax']; ?><br>
      Address £º <?php echo $row_rs['cCAdd1']; ?>, <?php echo $row_rs['cCAdd2']; ?>, <?php echo $row_rs['cCAdd3']; ?></td>
        </tr>
        <tr>
          <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td align="left"><strong>Faulty Unit Details </strong>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td width="47%">Make £º <?php echo $row_rs['cMake']; ?></td>
                <td width="53%">IMEI£º<?php echo $row_rs['cIMEI']; ?></td>
              </tr>
              <tr>
                <td>Model £º <?php echo $row_rs['cModel']; ?></td>
                <td>Claim Num £º<?php echo $row_rs['cClaim']; ?> </td>
              </tr>
            </table>
            Accessories:
              <?php if($row_rs['cA1']=="checked"){ ?>
              Battery&nbsp;
                <?php }?>
                <?php if($row_rs['cA2']=="checked"){ ?>
  &nbsp; Charger&nbsp;
  <?php }?>
  <?php if($row_rs['cA3']=="checked"){ ?>
  &nbsp; SIM CARD&nbsp;
  <?php }?>
  <?php if($row_rs['cFUD3']=="checked"){ ?>
  &nbsp; MEMORY CARD
  <?php }?>
              <?php if($row_rs['cAother']){ echo $row_rs['cAother'];}?>
              </td>
        </tr>
        <tr>
          <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td align="left"><p><strong>Faulty Information <br>
          </strong></p></td>
        </tr>
        <tr>
          <td height="80" align="left" valign="top" class="frame_normal">
            Timing of Faulty:
              <?php 
	if($row_rs['cFCU1']=="checked"){echo "Continuous. &nbsp;";}  
	if($row_rs['cFCU2']=="checked"){echo "Intermittent.&nbsp;";} ?>
              <br>
Type of Faulty:
<?php  
	if($row_rs['cFCM1']=="checked"){echo "Power Problem. &nbsp;";}    
	if($row_rs['cFCM4']=="checked"){echo "Ring Problem. &nbsp;";} 
	if($row_rs['cFCM2']=="checked"){echo "Earpiece Problem. &nbsp;";} 
	if($row_rs['cFCM5']=="checked"){echo "Microphone Problem. &nbsp;";}  
	if($row_rs['cFCM8']=="checked"){echo "Keypad Problem. &nbsp;";}  
	if($row_rs['cFCM6']=="checked"){echo "Call Problem. &nbsp;";}    
	if($row_rs['cFCM3']=="checked"){echo "Display Problem. &nbsp;";} 
	if($row_rs['cFCM7']=="checked"){echo "Software Problem. &nbsp;";}
	if($row_rs['cFCDesc']){echo "<br>".$row_rs['cFCDesc'];} 	 
	?></td>
        </tr>
        <tr>
          <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td align="left"><p><strong>Job Information / Technician Comment </strong></p></td>
        </tr>
        <tr>
          <td height="80" align="left" valign="top" class="frame_normal"><?php echo $row_rs['cSrvReport']; ?>&nbsp;</td>
        </tr>
        <tr>
          <td align="left">&nbsp;</td>
        </tr>
      </table>
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr align="left">
          <td width="110" height="20"> <strong><em>Phone Status </em></strong>£º </td>
          <td width="530" class="frame_normal">&nbsp;<?php echo $row_rs['cStsOnReport']; ?></td>
        </tr>
        <tr align="left">
          <td colspan="2"><p><em><img src="../manage/images/1x1.gif" width="1" height="7"></em></p></td>
        </tr>
        <tr align="left">
          <td height="20"><em>Service by </em><em>£º</em></td>
          <td class="frame_normal">&nbsp;<?php echo $row_rs['cAssign']; ?></td>
        </tr>
      </table>
      <br>
      <table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr align="center">
          <td width="640" valign="top"><p>&nbsp;</p>
            <p>
              <input type="submit" name="Submit3" value="Print Service Report/Invoice"onClick="MM_openBrWindow('sri_prt.php?cJN=<?php echo $row_rs['cJN']; ?>','','')">
            </p></td>
        </tr>
      </table>
      </div>
      <p>&nbsp;</p>
		<?php
	}//end if ct name correct
  }else{
  	//if no ct name in session
?>
      <p>&nbsp;</p>
      <table width="528" border="0" align="center" cellpadding="0" cellspacing="5">
        <tr>
          <td colspan="3" class="head_black_bold">&nbsp;* For security reason our company have to protect all customers details by not allowing others to enter and view your report. We apologize for any inconvenience that cause by us. </td>
        </tr><form name="form1" method="post" action="sri_val.php">
        <tr>
          <td align="right">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td width="172" align="right">Please enter your name here:</td>
          <td width="168" align="center">
            <input name="cCName" type="text" id="cCName" value=""></td>
          <td width="168" align="center"><input name="cCLastName" type="text" id="cCLastName" value=""></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="center">(first name)</td>
          <td align="center">(last name)</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="2"><input type="submit" name="Submit" value="Submit">
            <input name="cJN" type="hidden" id="cJN" value="<?php echo $_POST['cJN']; ?>"></td>
        </tr>
        <tr>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3"><span class="style2">(The name you enter above must be the same as the name you enter at your service request form)</span></td>
          </tr>
        </form>
      </table>
      <p>&nbsp;</p>
<?php
  }
}else{
	//show the sri
		?>
      <table width="539" border="0" align="center" cellpadding="0" cellspacing="10">
        <tr>
          <td width="357" height="22" align="center" class="Mgr_Heading"> Services Report</td>
          <td width="34">Date: </td>
          <td width="108" align="center" class="frame_normal"><?php echo $row_rs['dtCDate2'];?>&nbsp;</td>
        </tr>
      </table>
      <div align="right">
      <table width="95%" border="0" align="center" cellpadding="2" cellspacing="0">
        <tr>
          <td align="left"><strong>Job Details<br>
            </strong>Submitted Date £º <?php echo $row_rs['dtSDate2']; ?><br>
      Submitted By £º <?php echo $row_rs['cSbmBy']; ?><br>
      Job No.: <span class="frame_normal"><?php echo $row_rs['cJN']; ?></span><br>
      Service Charge £º $<?php echo $row_rs['cSrvChg']; ?> <?php echo $row_rs['cIIFP']; ?> <?php echo $row_rs['cIsWrty']; ?><br>
      Job Completion Date £º <?php echo $row_rs['dtCDate2']; ?></td>
        </tr>
		<?php if($row_rs['cLMake']!= null && $row_rs['cLMake']!= ""){?>
        <tr>
          <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td align="left"><span class="STYLE3">Loan Equipment</span><br>
            <table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
              <tr>
                <td width="19%" align="right">Handset Make: </td>
                <td width="24%"><?php echo $row_rs['cLMake']; ?></td>
                <td width="17%" align="right">Handset Model:</td>
                <td width="40%"><?php echo $row_rs['cLModel']; ?></td>
              </tr>
              <tr>
                <td align="right">Deposit taken: </td>
                <td><?php echo $row_rs['cLDeposit']; ?></td>
                <td align="right">IMEI</td>
                <td><?php echo $row_rs['cLIMEI']; ?></td>
              </tr>
              <tr>
                <td><input name="cLB" type="checkbox" id="cLB" value="checked" <?php echo $row_rs['cLB']; ?> disabled>
                  Battery</td>
                <td><input name="cLC" type="checkbox" id="cLC" value="checked" <?php echo $row_rs['cLC']; ?> disabled>
                  Charger</td>
                <td align="right">Other:</td>
                <td><?php echo $row_rs['cLother']; ?></td>
              </tr>
            </table></td>
        </tr>
		<?php }?>
        <tr>
          <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td align="left"><strong>Customer Details</strong><br>
      Name £º <?php echo $row_rs['cCName']; ?> <?php echo $row_rs['cCLastName']; ?><br>
      Contact Phone No.£º <?php echo $row_rs['cCHomePhn']; ?> <?php echo $row_rs['cCWorkPhn']; ?> <?php echo $row_rs['cCFax']; ?><br>
      Address £º <?php echo $row_rs['cCAdd1']; ?>, <?php echo $row_rs['cCAdd2']; ?>, <?php echo $row_rs['cCAdd3']; ?></td>
        </tr>
        <tr>
          <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td align="left"><strong>Faulty Unit Details</strong>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td width="47%">Make £º <?php echo $row_rs['cMake']; ?></td>
                <td width="53%">IMEI£º<?php echo $row_rs['cIMEI']; ?></td>
              </tr>
              <tr>
                <td>Model £º <?php echo $row_rs['cModel']; ?></td>
                <td>Claim Num £º<?php echo $row_rs['cClaim']; ?> </td>
              </tr>
            </table>
              Accessories:
              <?php if($row_rs['cA1']=="checked"){ ?>
              Battery&nbsp;
    <?php }?>
    <?php if($row_rs['cA2']=="checked"){ ?>
  &nbsp; Charger&nbsp;
  <?php }?>
  <?php if($row_rs['cA3']=="checked"){ ?>
  &nbsp; SIM CARD&nbsp;
  <?php }?>
  <?php if($row_rs['cFUD3']=="checked"){ ?>
  &nbsp; MEMORY CARD
  <?php }?>
  <?php if($row_rs['cAother']){ echo $row_rs['cAother'];}?>
              </td>
        </tr>
        <tr>
          <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td align="left"><p><strong>Faulty Information <br>
          </strong></p></td>
        </tr>
        <tr>
          <td height="80" align="left" valign="top" class="frame_normal">
            Timing of Faulty:
              <?php 
	if($row_rs['cFCU1']=="checked"){echo "Continuous. &nbsp;";}  
	if($row_rs['cFCU2']=="checked"){echo "Intermittent.&nbsp;";} ?>
              <br>
Type of Faulty:
<?php  
	if($row_rs['cFCM1']=="checked"){echo "Power Problem. &nbsp;";}    
	if($row_rs['cFCM4']=="checked"){echo "Ring Problem. &nbsp;";} 
	if($row_rs['cFCM2']=="checked"){echo "Earpiece Problem. &nbsp;";} 
	if($row_rs['cFCM5']=="checked"){echo "Microphone Problem. &nbsp;";}  
	if($row_rs['cFCM8']=="checked"){echo "Keypad Problem. &nbsp;";}  
	if($row_rs['cFCM6']=="checked"){echo "Call Problem. &nbsp;";}    
	if($row_rs['cFCM3']=="checked"){echo "Display Problem. &nbsp;";} 
	if($row_rs['cFCM7']=="checked"){echo "Software Problem. &nbsp;";}
	if($row_rs['cFCDesc']){echo "<br>".$row_rs['cFCDesc'];} 	 
	?>
</td>
        </tr>
        <tr>
          <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td align="left"><p><strong>Job Information / Technician Comments </strong></p></td>
        </tr>
        <tr>
          <td height="80" align="left" valign="top" class="frame_normal"><?php echo $row_rs['cSrvReport']; ?>&nbsp;</td>
        </tr>
        <tr>
          <td align="left">&nbsp;</td>
        </tr>
      </table>
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr align="left">
          <td width="110" height="20"> <strong><em>Phone Status </em></strong>£º </td>
          <td width="530" class="frame_normal">&nbsp;<?php echo $row_rs['cStsOnReport']; ?></td>
        </tr>
        <tr align="left">
          <td colspan="2"><p><em><img src="../manage/images/1x1.gif" width="1" height="7"></em></p></td>
        </tr>
        <tr align="left">
          <td height="20"><em>Service by </em><em>£º</em></td>
          <td class="frame_normal">&nbsp;<?php echo $row_rs['cAssign']; ?></td>
        </tr>
      </table>
      <br>
      <table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td width="640" align="center" valign="top"><p>&nbsp;</p>
            <p>
              <input type="submit" name="Submit32" value="Print Service Report/Invoice"onClick="MM_openBrWindow('sri_prt.php?cJN=<?php echo $row_rs['cJN']; ?>','','')">
            </p></td>
          </tr>
      </table>
      <?php
}
?>
    </div>
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
