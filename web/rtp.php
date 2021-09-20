<?php require_once('Connections/localhost.php'); ?>
<?php
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

//update the location of those have been left for 50 days
$updateSQL = "update tbrepair set cLocation='L25' where dtCDate is not null and cLocation='L15' and (TO_DAYS(now()) - TO_DAYS(dtCDate))>50";
mysql_select_db($database_localhost, $localhost);
$Result1 = mysql_query($updateSQL, $localhost);

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE tbrepair SET cFBScale=%s, cFBTell=%s, cFBDesc=%s WHERE cJN='".$_POST['cJN']."'",
                       GetSQLValueString($_POST['cFBScale'], "int"),
                       GetSQLValueString($_POST['cFBTell'], "int"),
                       GetSQLValueString($_POST['cFBDesc'], "text"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());
}

$colname_rs = "1";
if (isset($_POST['cJN'])) {
  $colname_rs = (get_magic_quotes_gpc()) ? $_POST['cJN'] : addslashes($_POST['cJN']);
}
if (isset($_GET['cJN'])) {
  $colname_rs = (get_magic_quotes_gpc()) ? $_GET['cJN'] : addslashes($_GET['cJN']);
}
mysql_select_db($database_localhost, $localhost);
$dt_fm = "%d %b %Y";
$query_rs = sprintf("SELECT *, (TO_DAYS(now()) - TO_DAYS(dtCDate)) as iDayLmt,DATE_FORMAT(dtECDate,'%s') as dtECDate2,DATE_FORMAT(dtCDate,'%s') as dtCDate2 FROM tbrepair WHERE cJN = '%s'",$dt_fm,$dt_fm, $colname_rs);
$rs = mysql_query($query_rs, $localhost) or die(mysql_error());
$row_rs = mysql_fetch_assoc($rs);
$totalRows_rs = mysql_num_rows($rs);
?>
<html><!-- InstanceBegin template="/Templates/index_simple.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>OmniTech</title>
<!-- InstanceEndEditable --><link href="css.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" type="text/JavaScript">
<!--



function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
<!-- InstanceBeginEditable name="head" -->
<script language="JavaScript" type="text/JavaScript">
<!--
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

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}
//-->
</script>
<!-- InstanceEndEditable -->
</head>

<body>
<table width="780" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="378"><img src="images/logo_simple.gif" width="378" height="92"></td>
    <td width="402" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
</table>
<table width="780" border="0" align="center" cellpadding="0" cellspacing="0" background="images/menu_btm.gif">
  <tr>
    <td><img src="images/1x1.gif" width="1" height="8"></td>
  </tr>
</table>
<table width="780" height="44" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="236" align="center"><?php include('./inc_sch.php');?>
    </td>
    <td width="544" align="center">&nbsp;</td>
  </tr>
</table>
<table width="780" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#CCCCCC">
    <td valign="top"><img src="images/1x1.gif" width="1" height="5"></td>
  </tr>
  <tr>
    <td valign="top"><!-- InstanceBeginEditable name="main" -->
	<?php
if($totalRows_rs == 0){
?>
	<table width="100%" border="0" align="center" cellpadding="7" cellspacing="0">
          <form name="form2" method="post" action="rtp.php">
            <tr>
              <td height="313" align="center" bgcolor="#e4e4e4"><p>No Such Job Number.</p>
                <p>Job No: 
                  <input name="cJN" type="text" class="ipt_rtp" id="cJN" size="6" maxlength="6">
                  <input name="Submit3" type="submit" class="btn_sch" onClick="MM_validateForm('cJN','','R');return document.MM_returnValue" value="GO">              
                </p></td>
            </tr>
          </form>
	  </table>
<?php
}else{
?>
        <?php require_once('repair/myfunction.php'); ?>
		<table width="750" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
        <tr>
          <td colspan="2" align="center" class="head_black_bold">Repair Tracking Pages<br>
      &nbsp;</td>
        </tr>
        <tr>
          <td width="191" align="right">Job No.&nbsp;</td>
          <td width="547" align="left"><span class="Mgr_Heading"><?php echo $row_rs['cJN']; ?></span></td>
        </tr>
        <tr>
          <td align="right">Make:</td>
          <td align="left"><?php echo $row_rs['cMake']; ?></td>
        </tr>
        <tr>
          <td align="right">Model:</td>
          <td align="left"><?php echo $row_rs['cModel']; ?></td>
        </tr>
        <tr>
          <td align="right">Repair Status:</td>
          <td align="left"><?php echo getStatus($row_rs['cStatus']); ?></td>
        </tr>
        <tr>
          <td align="right">Phone Current Location:</td>
          <td align="left"><?php echo getLocation($row_rs['cLocation']); ?></td>
        </tr>
        <tr>
          <td align="right">Estimate completion date :</td>
          <td align="left"><?php echo $row_rs['dtECDate2']; ?></td>
        </tr>
        <tr>
          <td align="right">Completion date :</td>
          <td align="left"><?php echo $row_rs['dtCDate2']; ?></td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td align="left">&nbsp;</td>
        </tr>
        <tr align="center">
          <td colspan="2"><table width="80%"  border="0" cellspacing="0" cellpadding="5">
              <?php
			  if(($row_rs['cStatus']=='S25' || $row_rs['cStatus']=='S30') && $row_rs['cLocation']=='L15'){
			  //if 'repaired or unservisable' and 'ready 2b picked up from RC'
			  ?>
			  <tr valign="top">
                <td width="3%">*</td>
                <td width="97%" align="left">You Have <span class="btn_sch"> <?php echo 50 - $row_rs['iDayLmt'];?> Days </span> remained from the service complete date to collect your device. If you can not be contacted or may not occur to collect your phone after services completion, your device maybe kept in lieu of payment. </td>
              </tr>
			  <?php
			  }
			  if($row_rs['cStatus']=='S25' || $row_rs['cStatus']=='S30' || $row_rs['cStatus']=='S35'){
			  ?>
              <tr>
                <td>&nbsp;</td>
                <td align="right"><form name="form3" method="post" action="sri_val.php">
                  <input type="submit" name="Submit4" value="View Technical Report &gt;&gt; ">
                  <input name="cJN" type="hidden" id="cJN" value="<?php echo $row_rs['cJN'];?>">
                </form>
                </td>
              </tr>
			  <?php
			  }
			  ?>
              <tr>
                <td>&nbsp;</td>
                <td align="left">&nbsp;</td>
              </tr>
			</table>
			<?php
			if(false && ($row_rs['cLocation']=='L10' || $row_rs['cLocation']=='L15' || $row_rs['cLocation']=='L20' ||$row_rs['cLocation']=='L30')){
			?>			<table width="80%"  border="0" cellspacing="0" cellpadding="5">
			<form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
              <tr>
                <td>&nbsp;</td>
                <td align="left" class="head_black_bold">Customer Satisfaction Survey </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left">&gt; Please indicate the level of service you received on the following sacale:
<select name="cFBScale" id="cFBScale">
                      <option value="7">Excellent</option>
                      <option value="6">Very Good</option>
                      <option value="5">Good</option>
                      <option value="4">Satisfaction</option>
                      <option value="3">Unsatisfactory</option>
                    </select>
		  <script language="javascript">
		  <!--
		  var objSclLst = MM_findObj('cFBScale');
		  objSclLst.value = "<?php echo $row_rs['cFBScale']; ?>";
		  //-->
		  </script>
                </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left">&gt; If you have any brief comments you would like to make about our service or to improve our service in the future, please ener them below: </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left"><input name="cFBDesc" type="text" id="cFBDesc" value="<?php echo $row_rs['cFBDesc']; ?>" size="60"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left">&gt;Thinking about buy low mobile phone &amp; buy low repair as a whole, how likely is if that you would recommend us to your friends &amp; colleague?
                  <select name="cFBTell" id="cFBTell">
                    <option value="7">Definitely yes</option>
                    <option value="6">Probably</option>
                    <option value="5">Not Sure</option>
                    <option value="4">Probably not</option>
                    <option value="3">Definitely not</option>
                  </select>
		  <script language="javascript">
		  <!--
		  var objTellLst = MM_findObj('cFBTell');
		  objTellLst.value = "<?php echo $row_rs['cFBTell']; ?>";
		  //-->
		  </script>                  </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left">Your feedback allows us to measure if we are providing effective and professional service. Thank you. </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="center"><input type="submit" name="Submit" value="Submit">
                  <input name="cJN" type="hidden" id="cJN" value="<?php echo substr($row_rs['cJN'],2,6); ?>"></td>
              </tr>
              <input type="hidden" name="MM_update" value="form1">
          </form>
		  </table>
		  <?php } ?>
		  </td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td align="left">&nbsp;</td>
        </tr>
      </table>
  <?php
  }//end if row=0
  ?>
    <!-- InstanceEndEditable --></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($rs);
?>
