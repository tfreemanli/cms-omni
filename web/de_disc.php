<?php require_once('Connections/localhost.php'); ?>
<?php
session_start();

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
	
	if($_POST['cDiscType']>0){
		$colname_rs = "1";
		if(isset($_POST['cDP']) && $_POST['cDP']!=""){
			$colname_rs = (get_magic_quotes_gpc()) ? $_POST['cDP'] : addslashes($_POST['cDP']);
		}else{
			die("Enter Your Discount Password Pls");
		}
		mysql_select_db($database_localhost, $localhost);
		$query_rs = sprintf("SELECT * FROM tbdiscpsw WHERE cPsw = '%s'", $colname_rs);
		$rs = mysql_query($query_rs, $localhost) or die(mysql_error());
		$row_rs = mysql_fetch_assoc($rs);
		$totalRows_rs = mysql_num_rows($rs);
		if($totalRows_rs){
			$DP = $row_rs['cPsw'];
			$DPDesc = $row_rs['cDesc'];
		}else{
			die("Discount Password Error.");
		}
	}//end if it not NO DISCOUNT
	
	$updateSQL = sprintf("update tbrepair set cDiscType=%s, prc=%s, amt=%s, cCost=%s, cDP=%s, cLocation='L20', dtPDate=NOW(), cDPDesc=%s WHERE cJN=%s",
                       GetSQLValueString($_POST['cDiscType'], "int"),
                       GetSQLValueString($_POST['prc'], "text"),
                       GetSQLValueString($_POST['amt'], "text"),
                       GetSQLValueString($_POST['cCost'], "text"),
                       GetSQLValueString($DP, "text"),
                       GetSQLValueString($DPDesc, "text"),
                       GetSQLValueString($_POST['cJN'], "text"));

	  mysql_select_db($database_localhost, $localhost);
	  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());
	
	  $insertGoTo = "de_inv_prt.php";
	  if (isset($_SERVER['QUERY_STRING'])) {
		$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
		$insertGoTo .= $_SERVER['QUERY_STRING'];
	  }
	  header(sprintf("Location: %s", $insertGoTo));
}

//Inspection Fee
$IF = 25.0;

$colname_rs = "1";
if (isset($_POST['cJN'])) {
  $colname_rs = (get_magic_quotes_gpc()) ? $_POST['cJN'] : addslashes($_POST['cJN']);
}else if(isset($_GET['cJN'])) {
  $colname_rs = (get_magic_quotes_gpc()) ? $_GET['cJN'] : addslashes($_GET['cJN']);
}
mysql_select_db($database_localhost, $localhost);
$dt_fm = "%d %b %Y";
$query_rs = sprintf("SELECT *,DATE_FORMAT(dtSDate,'%s') as dtSDate2,DATE_FORMAT(dtCDate,'%s') as dtCDate2 FROM tbrepair WHERE cJN = '%s'",$dt_fm,$dt_fm, $colname_rs);
$rs = mysql_query($query_rs, $localhost) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);
$totalRows_rs = mysql_num_rows($rs);
if($row_rs['cStatus']!='S25' && $row_rs['cStatus']!='S30' && $row_rs['cStatus']!='S35'){
	header("Location: ". "error.php?info=There's not any discount options for an unfinished job.");
}
if (!((isset($_SESSION['DE_Username'])) && ($_SESSION['DE_Username']==$row_rs['cSbm']||$_SESSION['DE_Userrealname']==$row_rs['cSbmBy']))) {   
  //if the viewer is not the submiting dealer
	header("Location: ". "error.php?info=You are not authorised.");
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
<script language="JavaScript" type="text/JavaScript">
<!--
function sbm(){
	var disctype = MM_findObj('cDiscType');
	var dp = MM_findObj('cDP');
	if(!disctype[0].checked && dp.value==''){
		alert('Pls Enter Your Discount Password');
		dp.focus();
		return false;
	}
	var cc = cntCost();
	if(cc && confirm("Totally Cost:$"+ cc + ", Are you sure?")){
		var fm = MM_findObj('form1');
		fm.submit();
		return true;
	}else{
		return false;
	}
}

function hide(){
	var btm = MM_findObj('btm');
	btm.style.display = "none";
}
function show(){
	var btm = MM_findObj('btm');
	var disctype = MM_findObj('cDiscType');
	var dp = MM_findObj('cDP');
	if(disctype[0].checked){
		//dp.style.display = "none";
	}else{
		//dp.style.display = "block";
	}
	btm.style.display = "block";
}

function cntCost(){
	var cost = MM_findObj('cCost');
	var b4disc = MM_findObj('cB4Disc');
	var discType = MM_findObj('cDiscType');
	if(b4disc.value < 0){
		alert('Service Charge or Inspection Fee error.');
		return false;
	}
	if(discType[0].checked){
		//no disc
		cost.value = b4disc.value;
		return cost.value;
	}
	if(discType[1].checked){
		//percentage
		var prc = MM_findObj('prc');
		if(!prc.selectedIndex){
			//alert('Select your discount percentage pls.');
			//return false;
		}
		cost.value = eval(b4disc.value * prc.options[prc.selectedIndex].value).toFixed(2);
		return cost.value;
	}
	if(discType[2].checked){
		//percentage
		var amt = MM_findObj('amt');
		//alert(isNaN(amt.value));
		if(isNaN(amt.value) || amt.value < 0.0 || amt.value==""){
			alert('Enter correct discount amount pls.');
			amt.value = 0.0;
			amt.focus();
			return false;
		}
		cost.value = eval(b4disc.value - amt.value).toFixed(2);
		if(cost.value<0.0){
			alert("Error Discount Amount.");
			amt.focus();
			return false;
		}
		return cost.value;
	}
}

Number.prototype.toFixed=function(len)
{
    var add = 0;
    var s,temp;
    var s1 = this + "";
    var start = s1.indexOf(".");
    var tmp2 = s1.substr(start+len+1,3);
    //alert(s1 +".substr(start+len+1,3) = tmp2=" + tmp2);
    
    //add by freeman, 2004-9-14
    if(tmp2.length==0) return s1;
    
    for(var i=0;tmp2.length<3;i++){
		tmp2 = tmp2 + "0";
		//if(!confirm(tmp2)) break;
    }
    if( tmp2 >=499){//判断小数点后第3位
    	//alert("进1，小数点后第3位后为：" + s1.substr(start+len+1,3));
    	add=1;
    }
    s1 = s1.substr(0,13);
    var temp = Math.pow(10,len);
    //alert("s1=" + s1 + "s1*temp=" + (s1*temp) + "  floor(s1*temp)=" + Math.floor(s1 * temp));
    s = Math.floor(s1 * temp) + add;
    //alert("s=" + s + " add=" + add);
    return s/temp;
}
//-->
</script>
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

if (  isset($_SESSION['DE_Username']) && ($_SESSION['DE_Username']==$row_rs['cSbm']||$_SESSION['DE_Userrealname']==$row_rs['cSbmBy'])) {   
  //if the viewer is the submiting dealer, then show the sri
		?>
      <table width="539" border="0" cellspacing="10" cellpadding="0">
        <tr>
          <td width="357" height="22" align="center" class="Mgr_Heading"> Services Discount Option </td>
          <td width="34">Date: </td>
          <td width="108" align="center" class="frame_normal"><?php echo $row_rs['dtCDate2'];?>&nbsp;</td>
        </tr>
      </table>
      <div align="right">
        <table width="95%" border="0" align="center" cellpadding="2" cellspacing="0">
        <tr>
          <td width="301" valign="top"><strong>Job Details<br>
            </strong>Submitted Date ： <?php echo $row_rs['dtSDate2']; ?><br>
      Submitted By ： <?php echo $row_rs['cSbmBy']; ?><br>
      Job No.: <span class="frame_normal"><?php echo $row_rs['cJN']; ?></span><br>
      Service Charge ： 
      $<?php echo $row_rs['cSrvChg']; ?> <?php echo $row_rs['cIIFP']; ?><br>
      Job Completion Date ： <?php echo $row_rs['dtCDate2']; ?></td>
          <td width="211" valign="top"><strong>Customer Details</strong><br>
Name ：<?php echo $row_rs['cCName']; ?> <?php echo $row_rs['cCLastName']; ?><br>
Contact Phone No.： <?php echo $row_rs['cCHomePhn']; ?><br>
Address ：<br><?php echo $row_rs['cCAdd1']; ?>, <?php echo $row_rs['cCAdd2']; ?>, <?php echo $row_rs['cCAdd3']; ?></td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2">
		  <table width="79%"  border="0" align="center" cellpadding="2" cellspacing="2">
            <form name="form1" method="post" action="<?php echo $editFormAction; ?>">
			<tr align="center">
              <td width="30%">Service Charge </td>
              <td width="7%">&nbsp;</td>
              <td width="22%">Inspection Fee</td>
              <td width="5%">&nbsp;</td>
              <td width="36%">&nbsp;</td>
            </tr>
            <tr align="center">
              <td>$<?php echo $row_rs['cSrvChg']; ?></td>
              <td>-</td>
			  <?php
			  //tell how much is the Inspection fee acturally
			  if($row_rs['cIsWrty'] == 'Warranty'){
			  //if it's warranty, Inspection fee = 0
			  	$IF = 0.0;
			  }else{
			  //if it's not warranty
			  	if(strlen($row_rs['cIIFP']) < 5){
				//if it's not IIFP(Is Inspection Fee Paid), Inspection Fee = 0
					//echo "<!--//-->";
					$IF = 0.0;
				}
			  }
			  ?>
              <td>$<?php echo $IF;?></td>
              <td>=</td>
              <td>$<?php echo ($row_rs['cSrvChg'] - $IF); ?>
                <input name="cB4Disc" type="hidden" id="cB4Disc" value="<?php echo ($row_rs['cSrvChg'] - $IF); ?>"></td>
            </tr>
            <tr>
              <td colspan="5"><img src="" alt="" width="100%" height="1" style="background-color: #990000"></td>
              </tr>
            <tr>
              <td>Discount Option:</td>
              <td><input name="cDiscType" type="radio" value="0"></td>
              <td>No Discount </td>
              <td colspan="2">* password not need</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><input name="cDiscType" type="radio" value="1"></td>
              <td>Percentage</td>
              <td colspan="2"><select name="prc">
                <option value="0.99">1</option>
                <option value="0.98">2</option>
                <option value="0.97">3</option>
                <option value="0.96">4</option>
                <option value="0.95">5</option>
                <option value="0.94">6</option>
                <option value="0.93">7</option>
                <option value="0.92">8</option>
                <option value="0.91">9</option>
                <option value="0.90">10</option>
                <option value="0.89">11</option>
                <option value="0.88">12</option>
                <option value="0.87">13</option>
                <option value="0.86">14</option>
                <option value="0.85">15</option>
                <option value="0.84">16</option>
                <option value="0.83">17</option>
                <option value="0.82">18</option>
                <option value="0.81">19</option>
                <option value="0.80">20</option>
              </select>
                % OFF </td>
              </tr>
            <tr>
              <td align="right">&nbsp;</td>
              <td><input type="radio" name="cDiscType" value="2"></td>
              <td>Amount</td>
              <td colspan="2">$
                <input name="amt" type="text" size="10"> 
                OFF </td>
              </tr>
            <tr>
              <td align="right">&nbsp;</td>
              <td colspan="4">
                <input type="button" name="Submit2" value="After Discount =" onClick="javascript:cntCost();"> 
                &nbsp; $
                <input name="cCost" type="text" id="cCost" size="10"></td>
            </tr>
            <tr>
              <td colspan="5"><img src="" alt="" width="100%" height="1" style="background-color: #990000"></td>
              </tr>
            <tr id="btm" name="btm">
              <td>Discount Password: </td>
              <td colspan="4"><input name="cDP" type="password" id="cDP" size="15">
                (apply if required)</td>
            </tr>
            <tr>
              <td colspan="5"><img src="" alt="" width="100%" height="1" style="background-color: #990000"></td>
              </tr>
            <tr>
              <td>&nbsp;</td>
              <td colspan="4">                <input type="button" name="Submit" value="Submit & Print Invoice" onClick="javascript:sbm();">                
                <input name="cJN" type="hidden" id="cJN" value="<?php echo $colname_rs;?>">
                <input type="hidden" name="MM_update" value="form1"></td>
              </tr>
			</form>
          </table></td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
      </table>
      </div>
	  <script language="javascript">
	  <!--
		var cost = MM_findObj('cCost');
		var discType = MM_findObj('cDiscType');
		var prc = MM_findObj('prc');
		var amt = MM_findObj('amt');
	  	cost.value = '<?php echo $row_rs['cCost']; ?>';
		discType[<?php echo $row_rs['cDiscType']; ?>].checked = true;
		<?php
		if($row_rs['cDiscType']==1){
			echo "prc.value = '". $row_rs['prc'] ."'";
		}else if($row_rs['cDiscType']==2){
			echo "amt.value = '". $row_rs['amt'] ."'";
		}
		?>
	  //-->
	  </script>
		<?php
}
?>
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
