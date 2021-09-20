<?php require_once('../Connections/localhost.php'); ?>
<?php
session_start();
$colname_rs = "-1";
if (isset($_GET['cJN'])) {
  $colname_rs = (get_magic_quotes_gpc()) ? $_GET['cJN'] : addslashes($_GET['cJN']);
}
mysql_select_db($database_localhost, $localhost);
$query_rs = sprintf("SELECT * FROM tblog WHERE cJN = '%s' ORDER BY dtDate DESC", $colname_rs);
$rs = mysql_query($query_rs, $localhost) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);
$totalRows_rs = mysql_num_rows($rs);
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><!-- InstanceBegin template="/Templates/tpl_repair.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!-- InstanceBeginEditable name="doctitle" -->
<title>Repair Center</title>
<!-- InstanceEndEditable --><link href="../manage/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../js/common.js"></script>
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
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
    <td  valign="top">	<!-- InstanceBeginEditable name="main" --><table width="100%"  border="0" align="center" cellpadding="5" cellspacing="10">
  <tr>
    <td><?php include('myfunction.php');?>
Go To: <a href="srf.php?cJN=<?php echo $row_rs['cJN']; ?>">Service Request Form</a> | <a href="rtp.php?cJN=<?php echo $row_rs['cJN']; ?>">Service Tracking Pages</a> | <a href="#"  onClick="MM_openBrWindow('memo_4j.php?cJN=<?php echo $row_rs['cJN'];?>','Memo','status=yes,scrollbars=yes,resizable=yes,width=640,height=480')">Job Memo</a>
 | <a href="log.php?cJN=<?php echo $row_rs['cJN']; ?>">Job Logs</a></td>
  </tr>
</table>
<table width="100%"  border="0" align="center" cellpadding="5" cellspacing="10">
      <tr>
        <td width="82%" class="Mgr_Heading">Job Logs </td>
        <td width="18%" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td class="Mgr_Heading">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
    </table>
	<table width="785"  border="0" align="center" cellpadding="5" cellspacing="0">
      <tr background="../manage/images/m_tb_head.gif">
        <td width="62" background="../manage/images/m_tb_head.gif" class="font_white_9bold">Job Number </td>
        <td width="105" background="../manage/images/m_tb_head.gif" class="font_white_9bold">Date</td>
        <td width="69" background="../manage/images/m_tb_head.gif" class="font_white_9bold">Person</td>
        <td width="483" background="../manage/images/m_tb_head.gif" class="font_white_9bold">Logs</td>
        <td width="16" background="../manage/images/m_tb_head.gif" class="font_white_9bold">&nbsp;</td>
      </tr>
        <?php do { ?>
      <tr>
          <td class="right_solid_2"><?php echo $row_rs['cJN']; ?></td>
          <td class="right_solid_2"><?php echo $row_rs['dtDate']; ?></td>
          <td class="right_solid_2"><?php echo $row_rs['cPerson']; ?></td>
          <td class="right_solid_2"><?php echo $row_rs['cContent']; ?></td>
          <td class="right_solid_2">&nbsp;</td>
      </tr>
          <?php } while ($row_rs = mysql_fetch_assoc($rs)); ?>
    </table>
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
