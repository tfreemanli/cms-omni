<?php require_once('Connections/localhost.php'); ?>
<?php
session_start();
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
if (!((isset($_SESSION['DE_Username'])) && ($_SESSION['DE_Username']==$row_rs['cSbm']||$_SESSION['DE_Userrealname']==$row_rs['cSbmBy']))) {   
  //if the viewer is not the submiting dealer, then check the customer's name
  if(isset($_SESSION['CT_Name'])){
  	//if has input the customer's name
	if($_SESSION['CT_Name']!=$row_rs['cCName'] || $_SESSION['CT_LastName']!=$row_rs['cCLastName']){
		//if the customer's name is not correct.
		//show the input box and stop
	header("Location: ". "sri_val.php?cJN=".$colname_rs);
	}else{
		//if the customer's name is correct.
		//show the sri
		
	}//end if ct name correct
  }else{
  	//if no ct name in session
	header("Location: ". "sri_val.php?cJN=".$colname_rs);
  }
}else{
	//show the sri
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>OmniTech Service Report/Invoice</title>
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
.style4 {font-size: 12px;
	font-weight: bold;
}
.STYLE5 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>

</head>

<body  onLoad="javascript:prt(true)">
<table width="640" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="378"><img width="378" height="92" src="images/logo_simple.gif"></td>
    <td width="262">
      <p class="style4">378 Great North Road<br>
  Henderson<br>
  Auckland, New Zealand</p>
      <p class="style4">Ph:09-8383943&nbsp;&nbsp;&nbsp;09-8383945<br>
  Fax:09-8383947<br>
  Email:info@omnitech.co.nz</p></td>
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
          <td width="76%"><span class="style3">GST No. 091 388 367 </span></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><strong>Job Details<br>
        </strong>Submitted Date £º <?php echo $row_rs['dtSDate2']; ?><br>
        Submitted By £º <?php echo $row_rs['cSbmBy']; ?><br>
        Job No.: <span class="frame_normal"><?php echo $row_rs['cJN']; ?></span><br>
	  <?php
	$fontcolor = "#000000";
	if($row_rs['cIsWrty']!="") {$fontcolor = "#FF0000"; }
	  ?>
        Service Charge £º <span style="color:<?php echo $fontcolor;?>; ">$<?php echo $row_rs['cSrvChg']; ?></span> <?php echo $row_rs['cIIFP']; ?> <!--<?php echo $row_rs['cIsWrty']; ?>--><br>
        Job Completion Date £º <?php echo $row_rs['dtCDate2']; ?></td>
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
                <td><input name="cLB" type="checkbox" id="cLB" value="checked" <?php echo $row_rs['cLB']; ?>>
                  Battery</td>
                <td><input name="cLC" type="checkbox" id="cLC" value="checked" <?php echo $row_rs['cLC']; ?>>
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
        Name £º <?php echo $row_rs['cCName']; ?> <?php echo $row_rs['cCLastName']; ?><br>
        Contact Phone No.£º <?php echo $row_rs['cCHomePhn']; ?> <?php echo $row_rs['cCWorkPhn']; ?> <?php echo $row_rs['cCFax']; ?><br>
        Address £º <?php echo $row_rs['cCAdd1']; ?>, <?php echo $row_rs['cCAdd2']; ?>, <?php echo $row_rs['cCAdd3']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Faulty Unit Details</strong>
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
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><p><strong>Faulty Information <br>
      </strong></p></td>
    </tr>
    <tr>
      <td height="80" valign="top" class="frame_normal">Timing of Faulty:
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
      <td><p><strong>Job Information / Technician Comments </strong></p></td>
    </tr>
    <tr>
      <td height="80" valign="top" class="frame_normal"><?php echo $row_rs['cSrvReport']; ?>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
</table>
  <table width="640" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="106" height="20"> <strong><em> Status </em></strong>£º </td>
      <td width="414" class="frame_normal">&nbsp;<?php echo $row_rs['cStsOnReport']; ?></td>
    </tr>
    <tr>
      <td colspan="2"><p><em><img src="../manage/images/1x1.gif" width="1" height="7"></em></p></td>
    </tr>
    <tr>
      <td height="20"><em>Service by </em><em>£º</em></td>
      <td class="frame_normal">&nbsp;<?php echo $row_rs['cAssign']; ?></td>
    </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rs);
?>
