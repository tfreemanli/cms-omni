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

$cJN="";
$cCName="";
$cCLastName="";
$cAddr="";
$cPhn="";
$cMake="";
$cModel="";
$cIMEI="";
$cSbmBy="";

$cMJ = "0";

if(isset($_GET['cJN'])){
	$cJN=$_GET['cJN'];
	$where_clu .= " and cJN like '%". $cJN."%'";
}
if(isset($_GET['cCName'])){
	$cCName=$_GET['cCName'];
	$where_clu .= " and cCName like '%". $cCName."%'";
}
if(isset($_GET['cCLastName'])){
	$cCLastName=$_GET['cCLastName'];
	$where_clu .= " and cCLastName like '%". $cCLastName."%'";
}
if(isset($_GET['cAddr'])){
	$cAddr=$_GET['cAddr'];
	$where_clu .= " and CONCAT(cCAdd1,' ',cCAdd2,' ',cCAdd3) like '%". str_replace(" ","%",$cAddr) ."%'";
}
if(isset($_GET['cPhn'])){
	$cPhn=$_GET['cPhn'];
	$where_clu .= " and (cCHomePhn like '%". $cPhn."%' or cCWorkPhn like '%". $cPhn."%' or cCFax like '%". $cPhn."%')";
}
if(isset($_GET['cMake'])){
	$cMake=$_GET['cMake'];
	$where_clu .= " and cMake like '%". $cMake."%'";
}
if(isset($_GET['cModel'])){
	$cModel=$_GET['cModel'];
	$where_clu .= " and cModel like '%". $cModel."%'";
}
if(isset($_GET['cIMEI'])){
	$cIMEI=$_GET['cIMEI'];
	$where_clu .= " and cIMEI like '%". $cIMEI."%'";
}
if(isset($_GET['cSbmBy'])){
	$cSbmBy=$_GET['cSbmBy'];
	$where_clu .= " and cSbmBy like '%". $cSbmBy."%'";
}

	$where_clu .= " and iSbmType=1 and cSbm = '". $_SESSION['DE_Username'] ."'";
	$cMJ = "1";
	
//end of search funtion

//iso function, to list the job to be confirmed only
//8-1-2008
if(isset($_GET['2bc']) && $_GET['2bc']=="1"){
	$where_clu = " where iSbmType=1 and cSbm = '". $_SESSION['DE_Username'] ."' and 
	((cMemo='yes' and (cStatus='S10' or cStatus='S15' or cStatus='S20')) or (cMemo='yes' and cIsReplyRead2=''))";
}
//end iso function(list the job to be confirmed only)


mysql_select_db($database_localhost, $localhost);
$query_req = "SELECT *,DATE_FORMAT(dtSDate,'%d %b %Y <br> %p %h:%i') AS dtSDate , tbcourier.name, tbcourier.url FROM tbrepair left join tbcourier on tbrepair.iCrrID=tbcourier.id  ".$where_clu." ORDER BY iID DESC";
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
	var JN = MM_findObj('cJN');
	var FN = MM_findObj('cCName');
	var LN = MM_findObj('cCLastName');
	var ADDR = MM_findObj('cCAdd');
	var PHN = MM_findObj('cPhn');
	var MK = MM_findObj('cMake');
	var MDL = MM_findObj('cModel');
	var IMEI = MM_findObj('cIMEI');
	var SBM = MM_findObj('cSbm');
	var mj = MM_findObj('myjob');
	
	var query="?";
	if(JN.value!="") query+=("cJN="+ JN.value +"&");
	if(FN.value!="") query+=("cCName="+ FN.value +"&");
	if(LN.value!="") query+=("cCLastName="+ LN.value +"&");
	if(ADDR.value!="") query+=("cAddr="+ ADDR.value +"&");
	if(PHN.value!="") query+=("cPhn="+ PHN.value +"&");
	if(MK.value!="") query+=("cMake="+ MK.value +"&");
	if(MDL.value!="") query+=("cModel="+ MDL.value +"&");
	if(IMEI.value!="") query+=("cIMEI="+ IMEI.value +"&");
	if(SBM.value!="") query+=("cSbmBy="+ SBM.value +"&");
	if(SBM.value!="") query+=("cSbmBy="+ SBM.value +"&");
	
	//alert(query);
	MM_goToURL('window','de_req_list.php'+ query);
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
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <form method="post" name="fmSch" id="fmSch" onSubmit="javascript:do_sch();return false;">
    <tr>
      <td width="2%">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">Job Number :
        <input name="cJN" type="text" id="cJN" size="8">
        &nbsp;First Name:
        <input name="cCName" type="text" id="cCName" size="10">
        &nbsp;Last Name:
        <input name="cCLastName" type="text" id="cCLastName" size="10"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">Address:
        <input name="cCAdd" type="text" id="cCAdd" size="25">
        &nbsp;
        &nbsp;
        &nbsp;Ph Number:
        <input name="cPhn" type="text" id="cPhn" size="15"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="76%">Make:
        <input name="cMake" type="text" id="cMake" size="10">
        &nbsp;
        &nbsp;
        &nbsp;
        &nbsp;
        &nbsp;
        &nbsp;Model:
        <input name="cModel" type="text" id="cModel" size="6">
&nbsp;
&nbsp;
        &nbsp;
        &nbsp;
        &nbsp;&nbsp;IMEI:
        <input name="cIMEI" type="text" id="cIMEI" size="15">
        <input name="cSbm" type="hidden" id="cSbm" size="8">
        <input name="myjob" type="hidden" id="myjob" value="<?php echo $cMJ;?>"></td>
      <td width="22%"><input type="submit" name="Submit" value="Search">
        <input type="reset" name="Submit2" value="Clear"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;* <strong>F</strong>=Service Request Form; <strong>C</strong>=Customers Notices; <strong>T</strong>=Service Tracking Pages; <strong>R</strong>=Service Report</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
  </form>
</table>
<script language="javascript">
<!--
	var JN = MM_findObj('cJN');
	var FN = MM_findObj('cCName');
	var LN = MM_findObj('cCLastName');
	var ADDR = MM_findObj('cCAdd');
	var PHN = MM_findObj('cPhn');
	var MK = MM_findObj('cMake');
	var MDL = MM_findObj('cModel');
	var IMEI = MM_findObj('cIMEI');
	var SBM = MM_findObj('cSbm');
	
	JN.value = '<?php echo $cJN;?>';
	FN.value = '<?php echo $cCName;?>';
	LN.value = '<?php echo $cCLastName;?>';
	ADDR.value = '<?php echo $cAddr;?>';
	PHN.value = '<?php echo $cPhn;?>';
	MK.value = '<?php echo $cMake;?>';
	MDL.value = '<?php echo $cModel;?>';
	IMEI.value = '<?php echo $cIMEI;?>';
	SBM.value = '<?php echo $cSbmBy;?>';
//-->
</script>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
      <tr class="font_white_9bold" align="center">
        <td width="11" background="repair/images/cms_22.gif" class="STYLE1" valign="top">&nbsp;</td>
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
        <td>&nbsp;</td>
        <td bgcolor="<?php echo $col;?>" class="right_solid_1"><a href="de_srf.php?cJN=<?php echo $row_req['cJN']; ?>"><?php echo $row_req['cJN']; ?></a></td>
        <td class="right_solid_1"><?php echo $row_req['cSbmBy']; ?></td>
        <td class="right_solid_1"><?php echo $row_req['cCName']; ?> <?php echo $row_req['cCLastName']; ?></td>
        <td class="right_solid_1"><?php echo $row_req['cMake']; ?></td>
        <td class="right_solid_1"><?php echo $row_req['cModel']; ?></td>
        <td class="right_solid_1"><?php echo getStatus($row_req['cStatus']); ?>
	<?php
	if($row_req['cMemo']!= null && $row_req['cMemo']!= ""){
		//如果cMemo有内容,则显示静止的图标;如果isRead2不等于"checked",表示有新的memo,那就显示闪动的图标
		$pic = "button_edit.gif";
		if($row_req['cIsReplyRead2']!="checked"){$pic="button_edit_new.gif";}
	?>
		<a href="#"><img src="images/<?php echo $pic;?>" alt="Click for Detail" width="12" height="13" border="0" onClick="MM_openBrWindow('de_req_memo.php?cJN=<?php echo $row_req['cJN'];?>','Memo','status=yes,scrollbars=yes,resizable=yes,width=640,height=480')"></a>
	<?php
	}
	?>	</td>
        <td class="right_solid_1"><?php echo getLocation($row_req['cLocation']); ?>
		<?php
		if($row_req['iCrrID'] != null && strlen($row_req['cCrrTrk']) > 0){
		?>
		<br><a href="http://<?php echo $row_req['url'];?>" target="_blank" title="<?php echo $row_req['name'];?>">Trk #: <?php echo $row_req['cCrrTrk'];?></a><?php }?></td>
        <td class="right_solid_1"><?php echo $row_req['dtSDate']; ?></td>
        <td class="right_solid_1"><a href="de_srf.php?cJN=<?php echo $row_req['cJN']; ?>">F</a> <a href="de_srf_2c.php?cJN=<?php echo $row_req['cJN']; ?>">C</a>
		<!--//<a href="rtp.php?cJN=<?php echo substr($row_req['cJN'],2,6); ?>">T</a>//-->
		<a href="rtp.php?cJN=<?php echo $row_req['cJN']; ?>">T</a>
		 <?php
	if($row_req['cStatus']=='S25' || $row_req['cStatus']=='S30' || $row_req['cStatus']=='S35'){
	?>
          <a href="sri_val.php?cJN=<?php echo $row_req['cJN']; ?>" target="_blank">R</a>
          <?php }?></td>
      </tr>
      <?php
  		if($col == "#FFFFFF"){
			$col = "#E3E3E3";
		}else{
			$col = "#FFFFFF";
		}
    } while ($row_req = mysql_fetch_assoc($req)); ?>
      <tr>
        <td>&nbsp;</td>
        <td colspan="10" bgcolor="<?php echo $col?>">
          <table border="0" width="50%" align="center">
            <tr>
              <td width="23%" align="center">
                <?php if ($pageNum_req > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_req=%d%s", $currentPage, 0, $queryString_req); ?>">First</a>
                <?php } // Show if not first page ?>              </td>
              <td width="31%" align="center">
                <?php if ($pageNum_req > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_req=%d%s", $currentPage, max(0, $pageNum_req - 1), $queryString_req); ?>">Previous</a>
                <?php } // Show if not first page ?>              </td>
              <td width="23%" align="center">
                <?php if ($pageNum_req < $totalPages_req) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_req=%d%s", $currentPage, min($totalPages_req, $pageNum_req + 1), $queryString_req); ?>">Next</a>
                <?php } // Show if not last page ?>              </td>
              <td width="23%" align="center">
                <?php if ($pageNum_req < $totalPages_req) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_req=%d%s", $currentPage, $totalPages_req, $queryString_req); ?>">Last</a>
                <?php } // Show if not last page ?>              </td>
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
?>
