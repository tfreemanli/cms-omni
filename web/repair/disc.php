<?php require_once('../Connections/localhost.php'); ?>
<?php
session_start();
//Inspection Fee
$IF = 25.0;

$colname_rs = "1";
if (isset($_GET['cJN'])) {
  $colname_rs = (get_magic_quotes_gpc()) ? $_GET['cJN'] : addslashes($_GET['cJN']);
}
mysql_select_db($database_localhost, $localhost);
$query_rs = sprintf("SELECT *, DATE_FORMAT(dtPDate,'%s') as dtPDate2 FROM tbrepair WHERE cJN = '%s'", '%d %b %Y', $colname_rs);
$rs = mysql_query($query_rs, $localhost) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);
$totalRows_rs = mysql_num_rows($rs);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><!-- InstanceBegin template="/Templates/tpl_repair.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>Repair Center</title>
<!-- InstanceEndEditable --><link href="../manage/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../js/common.js"></script>
<!-- InstanceBeginEditable name="head" -->
<style type="text/css">
<!--
.frame_normal {	border: 1px solid #000000;
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
<table width="95%" border="0" align="center" cellpadding="2" cellspacing="10" bgcolor="#FFFFFF">
  <tr valign="top">
    <td width="335"><strong>Job Details<br>
      </strong>Submitted Date ： <?php echo $row_rs['dtSDate2']; ?><br>
      Submitted By ： <?php echo $row_rs['cSbmBy']; ?><br>
      Job No.: <span class="frame_normal"><?php echo $row_rs['cJN']; ?></span><br>
      <?php
	$fontcolor = "#000000";
	if($row_rs['cIsWrty']!="") {$fontcolor = "#FF0000"; }
	  ?>
      Service Charge ： <span style="color:<?php echo $fontcolor;?>; ">$<?php echo $row_rs['cSrvChg']; ?></span> <?php echo $row_rs['cIIFP']; ?> <?php echo $row_rs['cIsWrty']; ?><br>
      Job Completion Date ： <?php echo $row_rs['dtCDate2']; ?><br>
      Payment Date: <?php echo $row_rs['dtPDate2']; ?></td>
  <td width="297"><strong>Customer Details</strong><br>
Name ： <?php echo $row_rs['cCName']; ?> <?php echo $row_rs['cCLastName']; ?><br>
Contact Phone No.： <?php echo $row_rs['cCHomePhn']; ?> <?php echo $row_rs['cCWorkPhn']; ?><br>
Address ： <?php echo $row_rs['cCAdd1']; ?>, <?php echo $row_rs['cCAdd2']; ?>, <?php echo $row_rs['cCAdd3']; ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><table width="79%"  border="0" align="center" cellpadding="2" cellspacing="2">
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
			  }else if($row_rs['cStatus']=='S25'){
			  	//when it's UNSERVICABLE
				if(strlen($row_rs['cIIFP']) > 5){
				//if it's not IIFP(Is Inspection Fee Paid), Inspection Fee = 0
					$IF = 25.0;
				}else{
					$IF = 0.0;
				}
			  }else{
			  //if it's not warranty
			  	if(strlen($row_rs['cIIFP']) > 5){
				//if it's not IIFP(Is Inspection Fee Paid), Inspection Fee = 0
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
          <td><input name="cDiscType" type="radio" value="0"  disabled></td>
          <td>No Discount </td>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input name="cDiscType" type="radio" value="1" disabled></td>
          <td>Percentage</td>
          <td colspan="2"><select name="prc" disabled>
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
          <td><input type="radio" name="cDiscType" value="2" disabled></td>
          <td>Amount</td>
          <td colspan="2">$<?php echo ($row_rs['cDiscType']!=2)?"0":$row_rs['amt'];?>
        OFF </td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td colspan="4">
            After Discount = &nbsp; $<?php echo $row_rs['cCost'];?></td>
        </tr>
        <tr>
          <td colspan="5"><img src="" alt="" width="100%" height="1" style="background-color: #990000"></td>
        </tr>
        <tr>
          <td>Passwd Desc: </td>
          <td colspan="4"><?php echo $row_rs['cDPDesc'];?>
              </td>
        </tr>
    </table>
      <p>&nbsp;</p></td>
  </tr>
</table>
	  <script language="javascript">
	  <!--
		var discType = MM_findObj('cDiscType');
		var prc = MM_findObj('prc');
		discType[<?php echo $row_rs['cDiscType']; ?>].checked = true;
		<?php
		if($row_rs['cDiscType']==1){
			echo "prc.value = ". $row_rs['prc'];
		}
		?>
	  //-->
	  </script>
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
