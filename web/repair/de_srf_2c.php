<?php require_once('../Connections/localhost.php'); ?>
<?php
session_start();

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$colname_rs = "1";
if (isset($_GET['cJN'])) {
  $colname_rs = (get_magic_quotes_gpc()) ? $_GET['cJN'] : addslashes($_GET['cJN']);
}
mysql_select_db($database_localhost, $localhost);
$query_rs = sprintf("SELECT * FROM tbrepair WHERE cJN = '%s'", $colname_rs);
$rs = mysql_query($query_rs, $localhost) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);
$totalRows_rs = mysql_num_rows($rs);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html><!-- InstanceBegin template="/Templates/tpl_repair.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>Repair Center</title>
<!-- InstanceEndEditable --><link href="../manage/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../js/common.js"></script>
<!-- InstanceBeginEditable name="head" -->


<link href="css.css" rel="stylesheet" type="text/css" />

<style type="text/css">
<!--
.style2 {
	font-size: 18px;
	font-weight: bold;
}
.style3 {font-size: 12px}
.style4 {
	font-size: 12px;
	font-weight: bold;
}
.frame_normal {	border: 1px solid #000000;
}
.style5 {	font-size: 14px;
	font-weight: bold;
	line-height:16px;
}
-->
</style>
<!-- InstanceEndEditable -->
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" background="../manage/images/m_top_bg.gif">
  <tr>
    <td><img src="../images/backg-top.gif" width="61" height="24"></td>
    <td width="114" rowspan="2" valign="top"><table width="114" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="114"><img src="../manage/images/m_top_right.gif" width="114" height="71"></td>
        </tr>
        <tr>
          <td height="18" background="../manage/images/m_topright_bg.gif"><table width="108" border="0" cellspacing="0" cellpadding="0">
              <tr align="center">
                <td width="38"><a href="fb_list.php">help</a></td>
                <td width="70">contact us </td>
              </tr>
          </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><img src="../manage/images/m_logo.gif" width="261" height="65"></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="28" background="../manage/images/m_top_bar_cen.gif"><img src="../manage/images/m_top_bar_left.gif" width="28" height="22"></td>
    <td background="../manage/images/m_top_bar_cen.gif">&nbsp;</td>
    <td width="24" align="right" background="../manage/images/m_top_bar_cen.gif"><img src="../manage/images/m_top_bar_right.gif" width="24" height="22" align="right"></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="193" valign="top" background="../manage/images/m_mid_leftbg.gif"><?php include("inc_menu.php");?></td>
    <td  valign="top">	<!-- InstanceBeginEditable name="main" -->
    <table width="630" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="600" border="0" align="center" cellpadding="5" cellspacing="0">
            <tr>
              <td width="437" height="30" align="center"> <span class="style5">SERVICE REQUEST FORM </span> </td>
              <td width="143">Date:<?php echo $row_rs['dtSDate']; ?></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td bgcolor="#000000"><img src="" alt="" width="630" height="2" style="background-color: #000000"></td>
      </tr>
      <tr>
        <td align="right"><table width="610" height="20" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="426"> JOB SUBMITTED BY: <?php echo $row_rs['cSbmBy']; ?></td>
              <td width="184"> <strong>JOB NO: <span class="head_red_bold"><?php echo $row_rs['cJN']; ?></span> </strong> </td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td bgcolor="#000000"><img src="" alt="" name="" width="630" height="1" style="background-color: #000000"></td>
      </tr>
      <tr>
        <td align="right"><table width="610" border="0" cellpadding="0" cellspacing="2">
            <tr>
              <td height="20" colspan="2"> USER NAME: <?php echo $row_rs['cCName']; ?> <?php echo $row_rs['cCLastName']; ?></td>
              <td width="330"> HOME NO: <?php echo $row_rs['cCHomePhn']; ?></td>
            </tr>
            <tr>
              <td height="20" colspan="2"> ADDRESS: <?php echo $row_rs['cCAdd1']; ?> <?php echo $row_rs['cCAdd2']; ?> <?php echo $row_rs['cCAdd3']; ?></td>
              <td> WORK/MOBILE NO: <?php echo $row_rs['cCWorkPhn']; ?><span class="Mgr_Heading"> <?php echo $row_rs['cCFax']; ?></span> </td>
            </tr>
            <tr>
              <td width="138" height="20"> MAKE: <?php echo $row_rs['cMake']; ?> </td>
              <td width="134">MODEL: <?php echo $row_rs['cModel']; ?> </td>
              <td>IMEI/ESN: <?php echo $row_rs['cIMEI']; ?> </td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td bgcolor="#000000"><img src="" alt="" name="" width="630" height="1" style="background-color: #000000"></td>
      </tr>
      <tr>
        <td align="right"><table width="610" border="0" cellspacing="2" cellpadding="0">
            <tr>
              <td width="261" height="20"><p>ACCESSORIES INCLUDED: <br>
              </p></td>
              <td width="343"><p>Security Code:<?php echo $row_rs['cFUDFax']; ?></p></td>
            </tr>
            <tr>
              <td height="20" colspan="2"><input name="cA12" type="checkbox" id="cA12" value="checked"  <?php echo $row_rs['cA1']; ?> disabled>
BATTERY &nbsp;&nbsp;
<input name="cA22" type="checkbox" id="cA22" value="checked"  <?php echo $row_rs['cA2']; ?> disabled>
CHARGER &nbsp;&nbsp;
<input name="cA32" type="checkbox" id="cA32" value="checked"  <?php echo $row_rs['cA3']; ?> disabled>
SIM CARD &nbsp;&nbsp;
<input name="cA5" type="checkbox" id="cA5" value="checked"  <?php echo $row_rs['cFUD3']; ?> disabled>
MEMORY CARD&nbsp;&nbsp; OTHER: <?php echo $row_rs['cAother']; ?></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td bgcolor="#000000"><img src="" alt="" name="" width="630" height="1" style="background-color: #000000"></td>
      </tr>
      <tr>
        <td height="70" align="center" valign="middle">
          <table width="630" border="1" cellpadding="2" cellspacing="0" bordercolor="#000000">
            <tr>
              <td height="55" valign="top">
                <p>FAULTY DETAILS:<br>
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
              </p></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td bgcolor="#000000"><img src="" alt="" name="" width="630" height="2" style="background-color: #000000"></td>
      </tr>
      <tr>
        <td height="27"><p class="style4">PLEASE READ CAREFULLY OUR TERMS AND CONDITIONS OF REPAIR: </p></td>
      </tr>
      <tr>
        <td bgcolor="#000000"><img src="" alt="" name="" width="630" height="1" style="background-color: #000000"></td>
      </tr>
      <tr>
        <td align="right"><table width="643" border="0" cellspacing="2" cellpadding="0">
            <tr>
              <td> *Please be aware all applications and data, including ring tones, games and other personal information may be irretrievably lost during the service repair process. It is highly recommended that you back up any data before sending your device for repair. None of the parties associated with the repair process, including Omni Tech, the service repair agent or the store shall be responsible for the loss of any data or personal information you may suffer. </td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td bgcolor="#000000"><img src="" alt="" name="" width="630" height="1" style="background-color: #000000"></td>
      </tr>
      <tr>
        <td><span class="head_black_bold">SERVICE WARRANTY: </span>
            <table width="649" cellpadding="0">
              <tr>
                <td>&nbsp;</td>
                <td>
                  <p>&#149;&nbsp; Our manufacturer warranty covers only manufacturer faults within the period specified by the manufacturer. <br>
&#149;&nbsp;Our service warranty only applies when the replacement part fails due to the   manufacturer fault within 50 days from the date of repair. <br>
&#149;&nbsp; This service warranty does not cover any other failure or fault excluding what had been repaired.<br>
&#149;&nbsp; Equipment that found to be liquid or physically damaged may at discretion of the repairer, is excluded from all warranty.<br>
&#149;&nbsp; Our limited warranty does not cover failure or defects caused by misuse, abuse, accident, physical damage, abnormal operation, improper handling or storage, modification, neglect, alternation, removal/repair of parts, exposure of fire, water, food, liquid and failure to follow instructions of proper device usage.<br>
&#149; We do not have to provide refund for repaired jobs done, unless three attempts had been carried out to repair the specific fault. If these situations occur, we will meet our obligation under the Fair Trading Act and Consumer Guarantees Act to provide a remedy or provide refund for the cost of repair. Please note that the inspection fee is not refundable under any circumstances as actual inspection had been conducted..</p></td>
              </tr>
          </table></td>
      </tr>
      <tr>
        <td bgcolor="#000000"><img src="" alt="" name="" width="630" height="1" style="background-color: #000000"></td>
      </tr>
      <tr>
        <td align="right"><table width="650" border="0" cellspacing="2" cellpadding="5">
            <tr>
              <td width="29"><input type="checkbox" name="checkbox" value="checkbox" <?php echo $row_rs['cFUD5']; ?> disabled></td>
              <td width="595"> WARRANTY CLAIM ~ This only applies for the device that purchase from Omni Tech with proof of purchase retained or for re-service device under same fault occur within 90 days.</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td bgcolor="#000000"><img src="" alt="" name="" width="630" height="2" style="background-color: #000000"></td>
      </tr>
      <tr>
        <td bgcolor="#000000"><img src="" alt="" name="" width="630" height="1" style="background-color: #000000"></td>
      </tr>
      <tr>
        <td align="right"><table width="610" border="0" cellspacing="2" cellpadding="0">
            <tr>
              <td>
                <p> I/We authorize repairs up to the value of:</p>
                <table width="180" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
                  <tr>
                    <td height="30" align="center" bgcolor="#FFFFFF"><p>$<?php echo $row_rs['fCChgLmt'];?> </p></td>
                  </tr>
                </table>
                <p>If you cannot be contacted after 50 days of assessment or you never reply within 50 days after the quotation is provided and if you not collected your device within 50 days from the date of service completion you agree that your device will be deemed unwanted and will be disposed of or will be keep in lieu of payment and I/we will have no claim against Omni Tech Ltd for said once retained or disposed.</p></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td bgcolor="#000000"><img src="" alt="" name="" width="630" height="2" style="background-color: #000000"></td>
      </tr>
      <tr>
        <td align="right"><table width="610" border="0" cellspacing="2" cellpadding="2">
            <tr>
              <td colspan="3"> LOAN DEVICE: Customer must return loan device in good order within 7 days upon verbal/written notification period. Failing to do so, your deposit will be forfeited. Customer will be liable for any damage, loss or missing parts of the loan device.</td>
            </tr>
            <tr>
              <td width="183" height="20"> <strong>Make</strong>: <?php echo $row_rs['cLMake']; ?></td>
              <td width="210"> <strong>Model</strong>: <?php echo $row_rs['cLModel']; ?></td>
              <td width="217"> <strong>IMEI</strong>: <?php echo $row_rs['cLIMEI']; ?></td>
            </tr>
            <tr>
              <td height="20"> <strong>Deposit Taken</strong>: <?php echo $row_rs['cLDeposit']; ?> </td>
              <td colspan="2"> <strong>Accessories</strong>:
                  <input name="cLB" type="checkbox" id="cLB" value="checked"  <?php echo $row_rs['cLB']; ?> disabled>
            Battery
            <input name="cLC" type="checkbox" id="cLC" value="checked"  <?php echo $row_rs['cLC']; ?> disabled>
            Charger Other:<?php echo $row_rs['cLother']; ?></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td bgcolor="#000000"><img src="" alt="" name="" width="630" height="2" style="background-color: #000000"></td>
      </tr>
      <tr>
        <td align="right"><table width="610" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="28" colspan="4"><strong> By signing this form you accept all terms and conditions above and agree that all of the information on this form is complete and correct. </strong></td>
            </tr>
            <tr>
              <td width="137" height="30" align="right"> Customer Signature: </td>
              <td width="233" class="underline">&nbsp;</td>
              <td width="67" align="right"> Date: </td>
              <td width="173" class="underline">&nbsp;</td>
            <tr>
              <td height="31" colspan="4"><p>
		<?php 
		if(in_array($row_rs['cSbm'], $_SESSION['RP_BranchList'])){
		if($row_rs['cFCS5']==""){
		?>
                  <input name="cIIFP" type="checkbox" id="cIIFP" value="checked"  <?php echo ($row_rs['cIIFP']!="")?"checked":""?> disabled>
              Inspection Paid (The amount of $25.00 will be deducted at the end of repair cost) 
		<?php
		}else{
		?>
		<input name="cFCS5" type="checkbox" id="cFCS5" value="checked"  <?php echo ($row_rs['cFCS5']!="")?"checked":""?> disabled>
Inspection Paid (The amount of $45.00 will be deducted at the end of repair cost) 
		<?php
		}
		}
		?></p></td>
            </tr>
            <tr valign="bottom">
              <td height="26" colspan="4"><p><strong>Please visit our website at <a href="http://www.omnitech.co.nz/">www.omnitech.co.nz </a> for more products and service information</strong></p>
                  </td>
            </tr>
        </table></td>
      </tr>
    </table>
    <p>&nbsp;</p>
    <!-- InstanceEndEditable -->
	</td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="191" background="../manage/images/m_btm.gif">&nbsp;</td>
  <td align="right" background="../manage/images/m_btm_bg.gif"><img src="../manage/images/m_btm_right.gif" width="667" height="52"></td>
  </tr>
</table>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($rs);
?>
