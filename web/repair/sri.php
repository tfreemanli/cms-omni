<?php require_once('../Connections/localhost.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "admin";
$MM_authorizedGroups = "tbtech,tbopr";
$MM_donotCheckaccess = "false";

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
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "error.php?info=Sorry, you are not authorised for this operation.";
if (!((isset($_SESSION['RP_Username'])) && (isAuthorized($MM_authorizedUsers, $MM_authorizedGroups, $_SESSION['RP_Username'], $_SESSION['RP_UserGroup'])))) {   
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
$colname_rs = "1";
if (isset($_GET['cJN'])) {
  $colname_rs = (get_magic_quotes_gpc()) ? $_GET['cJN'] : addslashes($_GET['cJN']);
}
mysql_select_db($database_localhost, $localhost);
$dt_fm = "%d %b %Y";
$query_rs = sprintf("SELECT *,DATE_FORMAT(dtSDate,'%s') as dtSDate2,DATE_FORMAT(dtCDate,'%s') as dtCDate2 FROM tbrepair WHERE cJN = '%s'",$dt_fm,$dt_fm, $colname_rs);
$rs = mysql_query($query_rs, $localhost) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);
$totalRows_rs = mysql_num_rows($rs);
if($row_rs['cStatus']!='S25' && $row_rs['cStatus']!='S30' && $row_rs['cStatus']!='S35'){
header("Location: ". "error.php?info=There is not service report for an unfinished job.");
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Repair Center</title>
<link href="../manage/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../js/common.js"></script>

<script language="JavaScript" type="text/JavaScript">
<!--


function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function prt(isClose){
	window.print();
	
	if(isClose){
		self.close();
	}
}
//-->
</script>
<style type="text/css">
<!--
body{
	color:#333333;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	line-height: 14px;
	margin: 0px;
	background-color: #FFFFFF;
}
table{
	color:#333333;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	line-height: 14px;
}
.style1 {font-size: 14px;line-height: 16px;}

.frame_normal {
	border: 1px solid #000000;
}
.Mgr_Heading{
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 18px;
	font-weight: bold;
	color: #3e3e3e;
	line-height: 18px;
}
.style4 {	font-size: 12px;
	font-weight: bold;
}
.STYLE5 {
	color: #FF0000;
	font-weight: bold;
}
td{
	color:#000000;
	font-family: Tahoma, Verdana, Arial;
	font-size: 11px; /*11*/
	line-height: 12px; /*12*/
}
-->
</style>
</head>

<body   onLoad="javascript:prt(false)">
<table width="640" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="300"> <img width="378" height="92" src="../images/logo_simple.gif"> </td>
    <td width="340">
    <?php 
	if($row_rs['cSbm']=='omnitechaly'){
	?>
    <p class="style4"><STRONG>Albany   Westfield Shopping Mall</STRONG><BR>
      Kiosk ALBB1010 -   Outside JB Hi-Fi <BR>
      Level 1, 219 Don McKinnon Drive,<BR>
      Albany,   0632<BR>
      Auckland, New Zealand </p>
      <p class="style4">Ph:09-9259230<br>
0800 OMNITECH (0800 666 483)</p>
      <p class="style4">Email:info@omnitech.co.nz<br>
        http://www.omnitech.co.nz</p>
    <?php
	}else if($row_rs['cSbm']=='omnitechsp'){
	?>
    <p class="style4"> Sylvia Park Shopping Mall<BR>
      Shop N038 286 Mt Wellington Hwy<BR>
      Mt   Wellington<BR>
      Auckland</p>
      <p class="style4">Ph: 09-5730483<br>
  Fax:09-5731061<br>
   0800 OMNITECH (0800 666 483)</p>
      <p class="style4">        Email:enquiry@omnitech.co.nz <br>
        http://www.omnitech.co.nz</p>
    <?php
	}else if($row_rs['cSbm']=='omnitechm'){
	?>
    <p class="style4"><STRONG>Manukau Westfield Shopping Mall</STRONG><BR>
      <SPAN lang="EN-NZ">Kiosk   MANB1010 – Outside Bond and Bond</SPAN><BR>
      Cnr Great South and Wiri Station Road,<BR>
      Manukau City, Auckland 2104</p>
    <p class="style4"> 0800 OMNITECH (0800 666 483)<br>
      Tel: 09-9785352      <br>
      Email:info@omnitech.co.nz<br>
      http://www.omnitech.co.nz</p>
      <?php
	}else if($row_rs['cSbm']=='omnitechsl'){
	?>
    <p class="style4">Omni Tech - St Lukes<BR>
      Kiosk STLC2020 Level 2, St Lukes Westfield Shopping   Mall<BR>
      80 St Lukes Road, Auckland 1025<br>
      <BR>
      Tel: 09-9786122<br>
0800 OMNITECH (0800 666 483)<BR>
      </p>
      <?php
	}else if($row_rs['cSbm']=='omnitechw'){
	?>
    <p class="style4">Omni Tech - Warehouse<BR>
      Level 1, 357 Great North Road,<BR>
      Henderson,   0612<BR>
      Auckland , New Zealand <br>
      <BR>
      <STRONG>Tel</STRONG>: 09-8383948<br>
0800 OMNITECH (0800 666 483)<BR>
    </p>
        <?php
	}else if($row_rs['cSbm']=='omnitechnl'){
	?>
      <p class="style4">Lynn Mall Shopping Centre <BR>
        Kiosk 12 - Outside Bond & Bond <BR>
        3058 Great North Road  <BR>
        New Lynn, Auckland <BR>
        Tel: 09-8276473<br>
        <br>
0800 OMNITECH (0800 666 483)</p>
        <?php
	}else if($row_rs['cSbm']=='omnitechh'){
	?>
      <p class="style4">Shop K12, TeAwa The Base Shopping Mall <BR>
        Corner of Te Rapa Road & Avalon Drive,  <BR>Hamilton<br>
        <br>
        Tel: 07-8498061<br>
0800 OMNITECH (0800 666 483)      </p>
        
        <?php
	}else if($row_rs['cSbm']=='omnitechd'){
	?>
      <p class="style4">Shop 4A, Dress-Smart Outlet Shopping Centre <BR>
        151 Arthur Street, <BR>Onehunga, <BR>Auckland<br>
        <br>
0800 OMNITECH (0800 666 483)        </p>
      <?php
	}else{
	?>
    <p class="style4">378 Great North Road<br>
  Henderson<br>
  Auckland, New Zealand</p>
      <p class="style4">Ph:09-8383943&nbsp;&nbsp;&nbsp;09-8383945<br>
  Fax:09-8383947<br>
0800 OMNITECH (0800 666 483)</p>
      <p class="style4">        Email:info@omnitech.co.nz<br>
        http://www.omnitech.co.nz</p>    
    <?php
	}
	?>    <br></td>
  </tr>
</table>
<table width="640" border="0" cellspacing="10" cellpadding="0">
  <tr>
    <td width="426" height="22" align="center" class="Mgr_Heading"> Services Report</td>
    <td width="40">Date: </td>
  <td width="134" align="center" class="frame_normal"><?php echo $row_rs['dtCDate2'];?>&nbsp;</td>
  </tr>
</table>
<table width="640" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="24%">&nbsp;</td>
        <td width="76%"><span class="style3">GST No.  
    <?php 
	if($row_rs['cSbm']=='omnitechsp'){
	?>105-648-006
     <?php }else{?>
        091 388 367
     <?php }?></span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><strong>Job Details<br>
    </strong>Submitted Date ： <?php echo $row_rs['dtSDate2']; ?><br>
Submitted By ： <?php echo $row_rs['cSbmBy']; ?><br>
    Job No.: <span class="frame_normal"><?php echo $row_rs['cJN']; ?></span><br>
	  <?php
	$fontcolor = "#000000";
	if($row_rs['cIsWrty']!="") {$fontcolor = "#FF0000"; }
	  ?>
Service Charge ： <span style="color:<?php echo $fontcolor;?>; ">$<?php echo $row_rs['cSrvChg']; ?></span>
<?php
if($row_rs['cFCS5']!="" || $row_rs['cIIFP']!=""){
	$iifp = 0;
	if($row_rs['cIIFP']!="") $iifp += "25.0";
	if($row_rs['cFCS5']!="") $iifp += "45.0";
	echo " - $". $iifp . " = $" . ($row_rs['cSrvChg']-$iifp);
} 
//echo $row_rs['cIIFP'];
?>
<?php echo $row_rs['cIsWrty']; ?><br>
Job Completion Date ： <?php echo $row_rs['dtCDate2']; ?></td>
  </tr>
		<?php if($row_rs['cLMake']!= null && $row_rs['cLMake']!= ""){?>
        <tr>
          <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td align="left"><span class="STYLE5">Loan Equipment</span><br>
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
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Customer Details</strong><br>
Name ： <?php echo $row_rs['cCName']; ?> <?php echo $row_rs['cCLastName']; ?><br>
Contact Phone No.： <?php echo $row_rs['cCHomePhn']; ?> <?php echo $row_rs['cCWorkPhn']; ?> <?php echo $row_rs['cCFax']; ?><br>
    Address ： <?php echo $row_rs['cCAdd1']; ?>, <?php echo $row_rs['cCAdd2']; ?>, <?php echo $row_rs['cCAdd3']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Faulty Unit Details </strong>    
      <table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td width="47%">Make ： <?php echo $row_rs['cMake']; ?></td>
          <td width="53%">IMEI：<?php echo $row_rs['cIMEI']; ?></td>
        </tr>
        <tr>
          <td>Model ： <?php echo $row_rs['cModel']; ?></td>
          <td>Claim Num ：<?php echo $row_rs['cClaim']; ?> </td>
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
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><p><strong>Faulty Information <br>
    </strong></p>    </td>
  </tr>
  <tr>
    <td height="70" valign="top" class="frame_normal">Timing of Faulty:
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
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><p><strong>Job Information / Technician Comment </strong></p></td>
  </tr>
  <tr>
    <td height="70" valign="top" class="frame_normal"><?php echo $row_rs['cSrvReport']; ?>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="640" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="110" height="20"> <strong><em>Phone Status </em></strong>： </td>
    <td width="530" class="frame_normal">&nbsp;<?php echo $row_rs['cStsOnReport']; ?></td>
  </tr>
  <tr>
    <td colspan="2"><p><em><img src="../manage/images/1x1.gif" width="1" height="7"></em></p></td>
  </tr>
  <tr>
    <td height="20"><em>Service by </em><em>：</em></td>
    <td class="frame_normal">&nbsp;<?php echo $row_rs['cAssign']; ?></td>
  </tr>
  <tr>
    <td colspan="2"><p><em><img src="../manage/images/1x1.gif" width="1" height="7"></em></p></td>
  </tr>
  <tr>
    <td height="20" colspan="2">•  Our service   warranty only applies when the same fault occurs or the replacement part fails   within 90 days from the date of repair completion.<BR>
      •  This service warranty   does not cover any other failure or fault excluding what had been   repaired.<BR>
      •  Equipment that found to be liquid or physically damaged may at   discretion of the repairer, is excluded from all warranty.<BR>
    •  Our limited   warranty does not cover failure or defects caused by misuse, abuse, accident,   physical damage, abnormal operation, improper handling or storage, modification,   neglect, alternation, removal/repair of parts, exposure of fire, water, food,   liquid and failure to follow instructions of proper device usage.</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rs);
?>
