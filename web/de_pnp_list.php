<?php require_once('Connections/localhost.php'); ?>
<?php
session_start();

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_req = 30;
$pageNum_req = 0;
if (isset($_GET['pageNum_req'])) {
  $pageNum_req = $_GET['pageNum_req'];
}
$startRow_req = $pageNum_req * $maxRows_req;

//deal with the search functing
$where_clu = " where iID is not null ";
$cField="cJN";
$cOp="like";
$cVal="";
$cMJ = "0";
if(isset($_GET['cField'])){
	if($_GET['cOp']=="like"){
		$where_clu .= " and ".$_GET['cField']." like '%". $_GET['cVal']."%'";
	}else{
		$where_clu .= " and ".$_GET['cField'].$_GET['cOp']."'". $_GET['cVal']."'";
	}
	$cField=$_GET['cField'];
	$cOp=$_GET['cOp'];
	$cVal=$_GET['cVal'];
}

	$where_clu .= " and iSbmType=1 and cSbm = '". $_SESSION['DE_Username'] ."'";
	$cMJ = "1";
//end of search funtion

mysql_select_db($database_localhost, $localhost);
$query_req = "SELECT iID, cJN, cStatus, cLocation, dtSDate, iSbmType, cSbm, cSbmBy, cCName, cCLastName, cMake, cModel FROM tbrepair ".$where_clu." ORDER BY dtSDate DESC";
$query_limit_req = sprintf("%s LIMIT %d, %d", $query_req, $startRow_req, $maxRows_req);
$req = mysql_query($query_limit_req, $localhost) or die(mysql_error());
$row_req = mysql_fetch_assoc($req);

if (isset($_GET['totalRows_req'])) {
  $totalRows_req = $_GET['totalRows_req'];
} else {
  $all_req = mysql_query($query_req);
  $totalRows_req = mysql_num_rows($all_req);
}
$totalPages_req = ceil($totalRows_req/$maxRows_req)-1;

$queryString_req = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_req") == false && 
        stristr($param, "totalRows_req") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_req = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_req = sprintf("&totalRows_req=%d%s", $totalRows_req, $queryString_req);
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
function do_sch(){
	var field = MM_findObj('field');
	var op = MM_findObj('op');
	var val = MM_findObj('val');
	//var mj = MM_findObj('myjob');
	if(val.value==''){
		alert('Pls input search value');
		val.focus();
		return false;
	}
	if(field.selectedIndex < 0){
		alert('Pls select which field you are searching');
		field.focus();
		return false;
	}
	if(op.selectedIndex < 0){
		alert('Pls select the searching op');
		op.focus();
		return false;
	}
	MM_goToURL('window','de_pnp_list.php?cField='+ field.options[field.selectedIndex].value +'&cOp='+ op.options[op.selectedIndex].value +'&cVal='+ val.value);
	return;
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
	<?php include('repair/myfunction.php');?>
<form method="post" name="fmSch" id="fmSch" onSubmit="javascript:do_sch();return false;">
   &nbsp;&nbsp;&nbsp;<select name="field" id="field">
      <option value="cJN">Job No.</option>
      <option value="cSbmBy">Submitted</option>
      <option value="cCName">Customer</option>
      <option value="cMake">Make</option>
      <option value="cModel">Model</option>
  </select>      
  <select name="op" id="op">
            <option value="=">=</option>
            <option value="<>">!=</option>
            <option value="like">Like</option>
        </select>
        <input name="val" type="text" id="val">
        <input name="myjob" type="hidden" id="myjob" value="<?php echo $cMJ;?>">
        <input type="button" name="search" value="search" onClick="javascript:do_sch();">
</form>
<script language="javascript">
<!--
	var f = MM_findObj('field');
	var o = MM_findObj('op');
	var v = MM_findObj('val');
	f.value = "<?php echo $cField ;?>";
	o.value = "<?php echo $cOp ;?>";
	v.value = "<?php echo $cVal ;?>";
//-->
</script>
<br>    
<table width="539"  border="0" align="center" cellpadding="0" cellspacing="0">
      <tr class="font_white_9bold" align="center">
        <td width="11" valign="top" background="repair/images/cms_20.gif"><img src="repair/images/cms_19.gif" width="11" height="12"></td>
        <td width="68" background="repair/images/cms_22.gif" class="STYLE1">Job No.</td>
        <td width="80" background="repair/images/cms_22.gif" class="STYLE1">Submitted By</td>
        <td width="75" background="repair/images/cms_22.gif" class="STYLE1">Customer</td>
        <td width="75" background="repair/images/cms_22.gif" class="STYLE1">Make</td>
        <td width="82" background="repair/images/cms_22.gif" class="STYLE1">Model</td>
        <td width="110" background="repair/images/cms_22.gif" class="STYLE1">Status</td>
        <td width="113" background="repair/images/cms_22.gif" class="STYLE1">Location</td>
        <td width="113" background="repair/images/cms_22.gif" class="STYLE1">Submit Date</td>
        <td width="36" background="repair/images/cms_22.gif" class="STYLE1">Opr</td>
      </tr>
      <?php
   $col = "#FFFFFF";
    do { ?>
      <tr bgcolor="<?php echo $col;?>" class="font_red_12">
        <td background="repair/images/cms_20.gif">&nbsp;</td>
        <td align="center" bgcolor="<?php echo $col;?>" class="right_solid_1"><a href="de_srf.php?cJN=<?php echo $row_req['cJN']; ?>"><?php echo $row_req['cJN']; ?></a><br>
            <?php
	if(($row_req['cStatus']=='S25' || $row_req['cStatus']=='S30' || $row_req['cStatus']=='S35') && $row_req['cLocation']!='L20'){
	?>
          <a href="de_disc.php?cJN=<?php echo $row_req['cJN']; ?>" target="_blank">PAY</a>
          <?php }?></td>
        <td class="right_solid_1"><?php echo $row_req['cSbmBy']; ?></td>
        <td class="right_solid_1"><?php echo $row_req['cCName']; ?> <?php echo $row_req['cCLastName']; ?></td>
        <td class="right_solid_1"><?php echo $row_req['cMake']; ?></td>
        <td class="right_solid_1"><?php echo $row_req['cModel']; ?></td>
        <td class="right_solid_1"><?php echo getStatus($row_req['cStatus']); ?></td>
        <td class="right_solid_1"><?php echo getLocation($row_req['cLocation']); ?></td>
        <td class="right_solid_1"><?php echo $row_req['dtSDate']; ?></td>
        <td class="right_solid_1"><?php
	if(($row_req['cStatus']=='S25' || $row_req['cStatus']=='S30' || $row_req['cStatus']=='S35') && $row_req['cLocation']=='L20'){
	?>
          <a href="de_inv_prt.php?cJN=<?php echo $row_req['cJN']; ?>" target="_blank">Invoice</a>
		  <a href="sri_val.php?cJN=<?php echo $row_req['cJN']; ?>" target="_blank">Report</a>
          <?php }else{
		  ?>
		  <a href="de_srf.php?cJN=<?php echo $row_req['cJN']; ?>" target="_blank">Form</a>
		  <?php
		  }?></td>
      </tr>
      <?php
  		if($col == "#FFFFFF"){
			$col = "#E3E3E3";
		}else{
			$col = "#FFFFFF";
		}
    } while ($row_req = mysql_fetch_assoc($req)); ?>
      <tr>
        <td background="repair/images/cms_20.gif">&nbsp;</td>
        <td colspan="10" bgcolor="<?php echo $col?>">
          <table border="0" width="50%" align="center">
            <tr>
              <td width="23%" align="center">
                <?php if ($pageNum_req > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_req=%d%s", $currentPage, 0, $queryString_req); ?>">First</a>
                <?php } // Show if not first page ?>
              </td>
              <td width="31%" align="center">
                <?php if ($pageNum_req > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_req=%d%s", $currentPage, max(0, $pageNum_req - 1), $queryString_req); ?>">Previous</a>
                <?php } // Show if not first page ?>
              </td>
              <td width="23%" align="center">
                <?php if ($pageNum_req < $totalPages_req) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_req=%d%s", $currentPage, min($totalPages_req, $pageNum_req + 1), $queryString_req); ?>">Next</a>
                <?php } // Show if not last page ?>
              </td>
              <td width="23%" align="center">
                <?php if ($pageNum_req < $totalPages_req) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_req=%d%s", $currentPage, $totalPages_req, $queryString_req); ?>">Last</a>
                <?php } // Show if not last page ?>
              </td>
            </tr>
        </table></td>
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
mysql_free_result($req);
mysql_free_result($all_req);
?>
