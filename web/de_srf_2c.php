<?php require_once('./Connections/localhost.php'); ?>
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
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>OmniTech</title>

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
td{
	color:#000000;
	font-family: Tahoma, Verdana, Arial;
	font-size: 11px; /*11*/
	line-height: 12px; /*12*/
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
.style2 {
	font-size: 14px;
	font-weight: bold;
	line-height:16px;
}
.style3 {font-size: 12px}
.style4 {
	font-size: 12px;
	font-weight: bold;
}
.frame_normal {	border: 1px solid #000000;
}
-->
</style>
</head>

<body>
<table width="630" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="378"><img width="378" height="92" src="images/logo_simple.gif"></td>
    <td width="254" bgcolor="#FFFFFF"><?php 
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
    <p class="style4">Sylvia Park Shopping Mall<BR>
Shop N038 286 Mt Wellington Hwy<BR>
Mt   Wellington<BR>
Auckland</p>
    <p class="style4">Ph: 09-5730483<br>
      Fax:09-5731061<br>
      0800 OMNITECH (0800 666 483)</p>
    <p class="style4"> Email:enquiry@omnitech.co.nz <br>
      http://www.omnitech.co.nz</p>
    <?php
	}else if($row_rs['cSbm']=='omnitechm'){
	?>
    <p class="style4"><STRONG>Manukau Westfield Shopping Mall</STRONG><BR>
      <SPAN lang="EN-NZ">Kiosk   MANB1010 &ndash; Outside Bond and Bond</SPAN><BR>
Cnr Great South and Wiri Station Road,<BR>
Manukau City, Auckland 2104</p>
    <p class="style4"> 0800 OMNITECH (0800 666 483)<br>
      Tel: 09-9785352 <br>
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
      Level 1, 357 Great North Road,<BR>
      Henderson,   0612<BR>
      Auckland , New Zealand <br>
      <BR>
      <STRONG>Tel</STRONG>: 09-8383948<br>
0800 OMNITECH (0800 666 483) <BR>
    </p>
        <?php
	}else if($row_rs['cSbm']=='omnitechnl'){
	?>
      <p class="style4">Lynn Mall Shopping Centre <BR>
        Kiosk 12 - Outside Bond & Bond <BR>
        3058 Great North Road  <BR>
        New Lynn, Auckland <BR>
        <br>
        Tel: 09-8276473<br>
 0800 OMNITECH (0800 666 483)      </p>
        <?php
	}else if($row_rs['cSbm']=='omnitechh'){
	?>
      <p class="style4">Shop K12, TeAwa The Base Shopping Mall <BR>
        Corner of Te Rapa Road & Avalon Drive,  <BR>Hamilton<br>
        <br>
        Tel: 07-8498061<br>
      0800 OMNITECH (0800 666 483) </p>
        
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
      </p>
      <p class="style4">378 Great North Road<br>
Henderson<br>
Auckland, New Zealand</p>
    <p class="style4">Ph:09-8383943&nbsp;&nbsp;&nbsp;09-8383945<br>
      Fax:09-8383947
      <br>
      0800 OMNITECH (0800 666 483)</p>
    <p class="style4"> Email:info@omnitech.co.nz<br>
      http://www.omnitech.co.nz</p>    
    <?php
	}
	?></td>
  </tr>
  <tr>
    <td height="5" colspan="2"></td>
  </tr>
</table>
<table width="620" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="620" bgcolor="#000000"><img src="" alt="" width="630" height="2" style="background-color: #000000"></td>
  </tr>
  <tr>
    <td><table width="600" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td width="437" height="20" align="center"> <span class="style2">SERVICE REQUEST FORM </span> </td>
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
    <td align="right" bgcolor="#000000"><img src="" alt="" name="" width="630" height="1" style="background-color: #000000"></td>
  </tr>
  <tr>
    <td align="right"><table width="610" border="0" cellpadding="0" cellspacing="1">
      <tr>
        <td height="20" colspan="2"> USER NAME: <?php echo $row_rs['cCName']; ?> <?php echo $row_rs['cCLastName']; ?></td>
        <td colspan="2"> HOME NO: <?php echo $row_rs['cCHomePhn']; ?></td>
      </tr>
      <tr>
        <td height="20" colspan="2"> ADDRESS: <?php echo $row_rs['cCAdd1']; ?> <?php echo $row_rs['cCAdd2']; ?> <?php echo $row_rs['cCAdd3']; ?></td>
        <td colspan="2"> WORK/MOBILE NO: <?php echo $row_rs['cCWorkPhn']; ?> <?php echo $row_rs['cCFax']; ?></td>
      </tr>
      <tr>
        <td width="138" height="20"> MAKE: <?php echo $row_rs['cMake']; ?> </td>
        <td width="134">MODEL: <?php echo $row_rs['cModel']; ?> </td>
        <td width="197">IMEI/ESN: <?php echo $row_rs['cIMEI']; ?> </td>
        <td width="136">CLAIM NO:  <?php echo $row_rs['cClaim'];?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#000000"><img src="" alt="" name="" width="630" height="1" style="background-color: #000000"></td>
  </tr>
  <tr>
    <td align="right"><table width="610" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td width="271" height="17"><p>ACCESSORIES INCLUDED: 
            </p></td>
        <td width="333">Security Code:<?php echo $row_rs['cFUDFax']; ?></td>
      </tr>
      <tr>
        <td colspan="2">
            <input name="cA12" type="checkbox" id="cA12" value="checked"  <?php echo $row_rs['cA1']; ?> readonly> 
          BATTERY
&nbsp;&nbsp;
<input name="cA22" type="checkbox" id="cA22" value="checked"  <?php echo $row_rs['cA2']; ?> readonly> 
CHARGER 
&nbsp;&nbsp;
<input name="cA32" type="checkbox" id="cA32" value="checked"  <?php echo $row_rs['cA3']; ?> readonly> 
SIM CARD 
&nbsp;&nbsp;
<input name="cA5" type="checkbox" id="cA5" value="checked"  <?php echo $row_rs['cFUD3']; ?> readonly>
MEMORY CARD&nbsp;&nbsp; OTHER: <?php echo $row_rs['cAother']; ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#000000"><img src="" alt="" name="" width="630" height="1" style="background-color: #000000"></td>
  </tr>
  <tr>
    <td height="70" align="right" valign="middle">
	<table width="603" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#000000">
      <tr>
        <td height="55" valign="top">
          <p>FAULTY DETAILS:<br>
            Timing of Faulty:<?php 
	if($row_rs['cFCU1']=="checked"){echo "Continuous. &nbsp;";}  
	if($row_rs['cFCU2']=="checked"){echo "Intermittent.&nbsp;";} ?><br>
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
          </p>          </td>
      </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#000000"><img src="" alt="" name="" width="630" height="2" style="background-color: #000000"></td>
  </tr>
  <tr>
    <td height="20" align="left"><p class="style4">PLEASE READ CAREFULLY OUR TERMS AND CONDITIONS OF REPAIR: </p>    </td>
  </tr>
  <tr>
    <td align="right" bgcolor="#000000"><img src="" alt="" name="" width="630" height="1" style="background-color: #000000"></td>
  </tr>
  <tr>
    <td align="right"><table width="610" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td> *Please be aware all applications and data, including ring tones, games and other personal information may be irretrievably lost during the service repair process.  It is highly recommended that you back up any data before sending your device for repair.  None of the parties associated with the repair process, including Omni Tech, the service repair agent or the store shall be responsible for the loss of any data or personal information you may suffer. </td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td align="right" bgcolor="#000000"><img src="" alt="" name="" width="630" height="1" style="background-color: #000000"></td>
  </tr>
  <tr>
    <td align="left"><span class="head_black_bold">SERVICE WARRANTY: </span>      <table width="610" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td>&nbsp;</td>
        <td>
            <p>&#149;&nbsp; Our manufacturer warranty covers only manufacturer faults within the period specified by the manufacturer. <br>
            &#149;&nbsp;Our service warranty only applies when the replacement part fails due to the   manufacturer fault within 90 days from the date of repair.
            <br>
            &#149;&nbsp; This service warranty does not cover any other failure or fault excluding what had been repaired.<br>
            &#149;&nbsp; Equipment that found to be liquid or physically damaged may at discretion of the repairer, is excluded from all warranty.<br>
            &#149;&nbsp; Our limited warranty does not cover failure or defects caused by misuse, abuse, accident, physical damage, abnormal operation, improper handling or storage, modification, neglect, alternation, removal/repair of parts, exposure of fire, water, food, liquid and failure to follow instructions of proper device usage.<br>
          &#149;&nbsp;We do not have to provide refund for repaired jobs done, unless three attempts had been carried out to repair the specific fault. If these situations occur, we will meet our obligation under the Fair Trading Act and Consumer Guarantees Act to provide a remedy or provide refund for the cost of repair. Please note that the inspection fee  is not refundable under any circumstances as actual inspection had been conducted.</p> </td>
      </tr>
  </table></td></tr>
  <tr>
    <td align="right" bgcolor="#000000"><img src="" alt="" name="" width="630" height="1" style="background-color: #000000"></td>
  </tr>
  <tr>
    <td align="right"><table width="610" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td width="26"><input type="checkbox" name="checkbox" value="checkbox" <?php echo $row_rs['cFUD5']; ?> ></td>
        <td width="578"> WARRANTY CLAIM ~ 


 This only applies for the device that purchase from Omni Tech with proof of purchase retained or for re-service device under same fault occur within 90 days.</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#000000"><img src="" alt="" name="" width="630" height="2" style="background-color: #000000"></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#000000"><img src="" alt="" name="" width="630" height="1" style="background-color: #000000"></td>
  </tr>
  <tr>
    <td align="right"><table width="610" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
          <p> I/We authorize repairs up to the value of:</p>
          </td>
      </tr>
      <tr>
        <td><table width="180" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
          <tr>
            <td height="30" align="center" bgcolor="#FFFFFF"><p>$<?php echo $row_rs['fCChgLmt'];?> </p></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>If you cannot be contacted after 50 days of assessment or you never reply within 50 days after the quotation is provided and if you not collected your device within 50 days from the date of service completion you agree that your device will be deemed unwanted and will be disposed of or will be keep in lieu of payment and I/we will have no claim against Omni Tech Ltd for said once retained or disposed.</td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td align="right" bgcolor="#000000"><img src="" alt="" name="" width="630" height="2" style="background-color: #000000"></td>
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
        <td colspan="2"> <strong>Accessories</strong>: <input name="cLB" type="checkbox" id="cLB" value="checked"  <?php echo $row_rs['cLB']; ?> readonly>
        Battery
          <input name="cLC" type="checkbox" id="cLC" value="checked"  <?php echo $row_rs['cLC']; ?> readonly>Charger Other:<?php echo $row_rs['cLother']; ?></td>
        </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td align="right" bgcolor="#000000"><img src="" alt="" name="" width="630" height="2" style="background-color: #000000"></td>
  </tr>
  <tr>
    <td align="right"><table width="610" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="20" colspan="4"><strong> By signing this form you accept all terms and conditions above and agree that all of the information on this form is complete and correct. </strong></td>
        </tr>
      <tr>
        <td width="137" height="30" align="right"> Customer Signature: </td>
        <td width="233" class="underline">&nbsp;</td>
        <td width="67" align="right"> Date: </td>
        <td width="173" class="underline">&nbsp;</td>
      </By signing this form you accept all terms and conditions above and agree that all of the information on this form is complete and correct.tr>
      <tr>
        <td height="20" colspan="4"><p>
		<?php 
		if(in_array($_SESSION['DE_Username'], $_SESSION['DE_BranchList'])){
			if($row_rs['cIIFP']!=""){
			?>
			<input name="cIIFP" type="checkbox" id="cIIFP" value="checked" checked>
			  Inspection Paid (The amount of $25.00 will be deducted at the end of repair cost)
			<?php
			}else if($row_rs['cFCS5']!=""){
			?>
			<input name="cFCS5" type="checkbox" id="cFCS5" value="checked"  checked >
	Inspection Paid (The amount of $45.00 will be deducted at the end of repair cost)
			<?php
			}else{
			?>
			<input name="cFCS5" type="checkbox" id="cFCS5" value="checked" disable>
	Inspection Paid
			<?php
			}
			?>
			<br>
            <strong>Our inspection fee of $25 apply for all standard phones and $45 for all PDA, Smart   Phone, PSP, Apple iPhone &amp; iPod, PlayStation, XBox, Wii,  Computer & Laptop, $70 for Apple iPad (all version) &amp; all Tablet   PC. This inspection fee will be deducted from the repair cost if you pay in advance. In case of your phone and device is not repairable or you cancel the job you will still liable to pay for our inspection fee.</strong></p>
			<?php
		}
		?></td>
      </tr>
      <tr valign="bottom">
        <td colspan="4"><p><strong>*Please visit our website at <a href="http://www.omnitech.co.nz/">www.omnitech.co.nz </a> for more products and service information</strong></p>          </td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rs);
?>
