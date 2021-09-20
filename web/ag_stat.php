<?php require_once('./Connections/localhost.php'); ?>
<?php
session_start();
$currentPage = $_SERVER["PHP_SELF"];

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

mysql_select_db($database_localhost, $localhost);
$query_rs_all = "SELECT iID FROM tbcust WHERE cIsVIP = '1' and cVIPNum='".$_SESSION['AG_Username']."'";
$rs_all = mysql_query($query_rs_all, $localhost) or die(mysql_error());
$row_rs_all = mysql_fetch_assoc($rs_all);
$totalRows_rs_all = mysql_num_rows($rs_all);
$AgentID= $row_rs_all['iID'];

$today=getdate();
$Year=$today["year"];
$Month=$today["mon"];
$where = " WHERE cAgentID = '". $AgentID ."'";

if(isset($_POST['MM_Query']) && ($_POST['MM_Query']=="form1")){
	$Year = $_POST['Year'];
	$Month = $_POST['Month'];
}
$where .= " and tbrepair.dtCDate between '".$Year."-".$Month."-1' and '".$Year."-".$Month."-31'";

mysql_select_db($database_localhost, $localhost);
$query_rs = "SELECT tbrepair.iID, tbrepair.cStatus, tbrepair.cJN, tbrepair.cCName, tbrepair.dtCDate, tbrepair.cSrvChg, tbrepair.cAgentName, tbrepair.cAgentID, 
tbcust.cName, tbcust.cLastName, tbcust.cHomePhn, tbcust.cWorkPhn, tbcust.cEmail 
FROM tbrepair LEFT JOIN tbcust ON tbrepair.cAgentID = tbcust.iID ".$where." ORDER BY tbrepair.cAgentName";
$rs = mysql_query($query_rs, $localhost) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);
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
<TITLE>MobilePhone Repair, Unlcok: Omni Tech Limited, Auckland, NewZealand</TITLE>
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
          <!-- InstanceBeginEditable name="left" --><?php include('./inc_ag_left.php');?><!-- InstanceEndEditable --></td>
      </tr>
    </table></td>
    <td width="593" rowspan="2" bgcolor="#FFFFFF">
      <!-- InstanceBeginEditable name="main" --><?php include('repair/myfunction.php');?>
      <table width="100%"  border="0" align="center" cellpadding="5" cellspacing="10">
        <tr>
          <td width="74%" class="head_black_bold">Agents Stat</td>
          <td width="26%" align="center">&nbsp;</td>
        </tr>
        <form name="form1" method="post" action="">
          <tr>
            <td> Month:
              <select name="Month" id="Month">
                  <?php
	  for($i=1; $i<=12; $i++){
	  ?>
                  <option value="<?php echo $i;?>"><?php echo $i;?></option>
                  <?php
	  }
	  ?>
                </select>
              &nbsp;&nbsp;&nbsp;&nbsp;Year:
              <select name="Year" id="Year">
                <option value="2007">2007</option>
                <option value="2008">2008</option>
                <option value="2009">2009</option>
                <option value="2010">2010</option>
                <option value="2011">2011</option>
                <option value="2012">2012</option>
              </select>
              &nbsp;&nbsp;            </td>
            <td align="center"><input name="Submit" type="submit" class="btn" value="Submit">
                <input type="hidden" name="MM_Query" value="form1">
            <input name="Agent" type="hidden" id="Agent"></td>
          </tr>
        </form>
        <script language="javascript">
<!--
	var year = MM_findObj("Year");
	var month = MM_findObj("Month");
	year.value = '<?php echo $Year;?>';
	month.value = '<?php echo $Month;?>';
//-->
      </script>
          <tr>
            <td colspan="2"><table width="100%"  border="0" align="center" cellpadding="3" cellspacing="0">
              <tr class="font_white_9bold" align="center">
                <td width="123" background="./manage/images/m_tb_head.gif" class="STYLE1">AgentName</td>
                <td width="89" background="./manage/images/m_tb_head.gif" class="STYLE1">Job Num</td>
                <td width="104" background="./manage/images/m_tb_head.gif" class="STYLE1">Job Status</td>
                <td width="129" background="./manage/images/m_tb_head.gif" class="STYLE1">Comp Date</td>
                <td width="88" background="./manage/images/m_tb_head.gif" class="STYLE1">CstName</td>
                </tr>
              <?php
   $col = "#FFFFFF";
   $prevGuy = "";
    do { 
	if($prevGuy!="" && $prevGuy!=$row_rs['cAgentName']){
  		if($col == "#FFFFFF"){
			$col = "#E3E3E3";
		}else{
			$col = "#FFFFFF";
		}
		
	}
	$prevGuy = $row_rs['cAgentName'];
    ?>
              <tr bgcolor="<?php echo $col;?>" class="font_red_12">
                <td align="center" class="right_solid_2"><?php echo $row_rs['cAgentName']; ?></td>
                <td align="center" class="right_solid_2"><a href="de_srf.php?cJN=<?php echo $row_rs['cJN']; ?>"><?php echo $row_rs['cJN']; ?></a>&nbsp;</td>
                <td align="center" class="right_solid_2"><?php echo getStatus($row_rs['cStatus']); ?>&nbsp;</td>
                <td align="center" class="right_solid_2"><?php echo $row_rs['dtCDate']; ?>&nbsp;</td>
                <td align="center" class="right_solid_2"><?php echo $row_rs['cCName']; ?>&nbsp;</td>
                </tr>
              <?php

    } while ($row_rs = mysql_fetch_assoc($rs)); ?>
            </table></td>
          </tr>
	  
<?php
	mysql_select_db($database_localhost, $localhost);
	$query_rs_note = "SELECT iID, IsPaid, cNote FROM tbagentnote WHERE cYear='".$Year."' and cMonth='".$Month."' and cAgentID='".$AgentID."'";
	$rs_note = mysql_query($query_rs_note, $localhost) or die(mysql_error());
	$row_rs_note = mysql_fetch_assoc($rs_note);
	$totalRows_rs_note = mysql_num_rows($rs_note);

?>
  <tr>
    <td colspan="2"><table width="100%" border="0" cellspacing="2" cellpadding="5">
      <tr>
        <td width="12%" class="Mgr_Heading">Is Paid?</td>
        <td width="88%"><input name="IsPaid" type="checkbox" id="IsPaid" value="checkbox" <?php echo $row_rs_note['IsPaid'];?> disabled="disabled">
          <span class="Mgr_Heading">Yes</span></td>
      </tr>
      <tr>
        <td class="Mgr_Heading">Note</td>
        <td><?php echo $row_rs_note['cNote'];?></td>
      </tr>
    </table>      
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
mysql_free_result($rs);
mysql_free_result($rs_all);
mysql_free_result($rs_note);
?>
