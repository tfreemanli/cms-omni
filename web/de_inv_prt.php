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
$query_rs = sprintf("SELECT *,DATE_FORMAT(dtSDate,'%s') as dtSDate2,DATE_FORMAT(dtCDate,'%s') as dtCDate2 FROM tbrepair WHERE cJN = '%s'",$dt_fm,$dt_fm, $colname_rs);
$rs = mysql_query($query_rs, $localhost) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);
$totalRows_rs = mysql_num_rows($rs);
if($row_rs['cStatus']!='S25' && $row_rs['cStatus']!='S30' && $row_rs['cStatus']!='S35'){
	header("Location: ". "error.php?info=There is not service report for an unfinished job.");
}
if (!((isset($_SESSION['DE_Username'])) && ($_SESSION['DE_Username']==$row_rs['cSbm']||$_SESSION['DE_Userrealname']==$row_rs['cSbmBy']))) {   
  //if the viewer is not the submiting dealer
	header("Location: ". "error.php?info=You are not authorised.");
}

//Inspection Fee
$IF = 25.0;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>OmniTech Invoice/Receipt</title>
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
.style1 {
	font-size: 16px;
	font-weight: bold;
}
.style4 {	font-size: 12px;
	font-weight: bold;
}
-->
</style>

</head>

<body  onLoad="javascript:prt(true)">
<table width="643" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="378"> <img width="378" height="92" src="images/logo_simple.gif"> </td>
    <td width="265">
      <p class="style4">378 Great North Road<br>
  Henderson<br>
  Auckland, New Zealand</p>
      <p class="style4">Ph:09-8383943&nbsp;&nbsp;&nbsp;09-8383945<br>
  Fax:09-8383947<br>
  Email:info@omnitech.co.nz</p></td>
  </tr>
  <tr>
    <td align="center"><span class="style3">GST No. 091 388 367 </span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="642" border="0" cellspacing="10" cellpadding="0">
  <tr>
    <td width="357" height="22" align="center" class="Mgr_Heading"> Invoice/Receipt</td>
    <td width="34">Date: </td>
    <td width="108" align="center" class="frame_normal"><?php echo $row_rs['dtCDate2'];?>&nbsp;</td>
  </tr>
</table>
  <table width="642" border="0" cellspacing="10" cellpadding="0">
    <tr>
      <td height="22"><strong>Charge To</strong> : 
	  <?php
	  if($row_rs['cIsWrty'] == 'Warranty'){
	  	echo $row_rs['cSbmBy']." - WARRANTY CLAIM";
	  }else{
	  	echo $row_rs['cCName']." ".$row_rs['cCLastName'];
	  }
	  ?></td>
    </tr>
  </table>
  <table width="642" border="0" cellspacing="5" cellpadding="2">
    <tr valign="top">
      <td width="286"><strong>Job Details<br>
        </strong>Submitted Date £º <?php echo $row_rs['dtSDate2']; ?><br>
        Submitted By £º <?php echo $row_rs['cSbmBy']; ?><br>
        Job No.: <?php echo $row_rs['cJN']; ?><br>
        Service Charge £º $<?php echo $row_rs['cSrvChg']; ?><br>
        Job Completion Date £º <?php echo $row_rs['dtCDate2']; ?></td>
      <td width="245"><strong>Customer Details</strong><br>
Name £º <?php echo $row_rs['cCName']; ?> <?php echo $row_rs['cCLastName']; ?><br>
Contact Phone No.£º <?php echo $row_rs['cCHomePhn']; ?><br>
Address £º <?php echo $row_rs['cCAdd1']; ?>, <?php echo $row_rs['cCAdd2']; ?>, <?php echo $row_rs['cCAdd3']; ?></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><table width="88%"  border="0" align="center" cellpadding="2" cellspacing="2">
          <tr align="center">
            <td width="30%">Service Charge </td>
            <td width="6%">&nbsp;</td>
            <td width="29%">Inspection Fee</td>
            <td width="6%">&nbsp;</td>
            <td width="29%">&nbsp;</td>
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
            <td>$<?php echo ($row_rs['cSrvChg'] - $IF); ?></td>
          </tr>
          <tr>
            <td colspan="5">&nbsp;</td>
          </tr>
          <tr>
            <td><strong>Discount Option:</strong></td>
            <td><?php echo ($row_rs['cDiscType']==0)?"¡Ì":"&nbsp;";?></td>
            <td>No Discount </td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><?php echo ($row_rs['cDiscType']==1)?"¡Ì":"&nbsp;";?></td>
            <td>Percentage</td>
            <td colspan="2">
			<?php
			if($row_rs['cDiscType']==1){
				$prc = 100*(1-$row_rs['prc']);
				echo $prc."% OFF";
			}else{
				echo "&nbsp;";
			}
			?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><?php echo ($row_rs['cDiscType']==2)?"¡Ì":"&nbsp;";?></td>
            <td>Amount</td>
            <td colspan="2"><?php echo ($row_rs['cDiscType']==2)?"$".$row_rs['amt']." OFF":"&nbsp;";?></td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <td colspan="4">&nbsp;</td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <td colspan="4">Total Amount Due After Discount:<strong> $<?php echo $row_rs['cCost'];?></strong></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><p class="style1">This is to confirm that I have received the mobile/equipment from OmniTech Repair Center . </p>
        <p class="style1"><br>
        <strong>Name: ¡­¡­¡­¡­¡­¡­¡­¡­¡­¡­¡­¡­¡­¡­¡­</strong></p>
        <p class="style1"><strong> <br>
      Signature: ¡­¡­¡­¡­¡­¡­¡­¡­¡­¡­¡­¡­¡­<br>
      <br>
      <br>
        </strong></p>      
        <p><strong><em>Proof of Collection: </em></strong></p>
        <p><font size="12">¡õ</font> Photo ID/NZ Driving License&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <font size="12">¡õ</font> Service Request Form </p>
        <p>ID Number: </p>
        <hr align="left" width="150" size="1">
        <br>
        <em>*If you do not provide any prove for your collection then we are sorry to inform you that you are not allowing for this collection. </em>
        <p class="style1"><strong>        </strong></p></td>
    </tr>
  </table>
</body>
</html>
<?php
mysql_free_result($rs);
?>
