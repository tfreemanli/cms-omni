<?php require_once('Connections/localhost.php'); ?>
<?php
session_start();
//get the current Job Number
mysql_select_db($database_localhost, $localhost);
$query_JN = "SELECT iJN FROM tbjn WHERE iID = 1";
$JN = mysql_query($query_JN, $localhost) or die(mysql_error());
$row_JN = mysql_fetch_assoc($JN);
$totalRows_JN = mysql_num_rows($JN);

?>
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


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO tbrepair (cJN, dtSDate, cStatus, cLocation, iSbmType, cSbm, cSbmBy, cStfName, cCName, cCLastName, cCHomePhn, cCAdd1, cCAdd2, cCAdd3, cCWorkPhn, cCFax, cCEmail, fCChgLmt, cFUD1, cFUD2, cFUD3, cFUD4, cFUD5, cMake, cClaim, cModel, cIMEI, cFUDFax, cA1, cA2, cA3, cAother, cFCS1, cFCS2, cFCS3, cFCS4, cFCS5, cFCS6, cFCS7, cFCS8, cFCD1, cFCD2, cFCD3, cFCM1, cFCM2, cFCM3, cFCM4, cFCM5, cFCM6, cFCM7, cFCM8, cFCP1, cFCP2, cFCP3, cFCP4, cFCG1, cFCG2, cFCG3, cFCG4, cFCG5, cFCG6, cFCG7, cFCG8, cFCG9, cFCU1, cFCU2, cFCU3, cFCDesc, cLMake, cLModel, cLDeposit, cLIMEI, cLB, cLC, cIIFP, cLother, cAgentID, cAgentName) VALUES ('%s', %s, %s, %s, %s, %s, %s, %s,%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,%s,%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s ,%s, %s, %s)",
                       $row_JN['iJN'],
					   "NOW()",
                       GetSQLValueString($_POST['cStatus'], "text"),
                       GetSQLValueString($_POST['cLocation'], "text"),
                       GetSQLValueString($_POST['iSbmType'], "int"),
                       GetSQLValueString($_POST['cSbm'], "text"),
                       GetSQLValueString($_POST['cSbmBy'], "text"),
                       GetSQLValueString($_POST['cStfName'], "text"),
                       GetSQLValueString($_POST['cCName'], "text"),
                       GetSQLValueString($_POST['cCLastName'], "text"),
                       GetSQLValueString($_POST['cCHomePhn'], "text"),
					   
					   //edit by freeman 28/12/2008, mysql not allow add=null, at lease add=''
                       //GetSQLValueString($_POST['cCAdd1'], "text"),
                       //GetSQLValueString($_POST['cCAdd2'], "text"),
                       //GetSQLValueString($_POST['cCAdd3'], "text"),
					   ("'".$_POST['cCAdd1']."'"),
					   ("'".$_POST['cCAdd2']."'"),
					   ("'".$_POST['cCAdd3']."'"),
					   
                       GetSQLValueString($_POST['cCWorkPhn'], "text"),
                       GetSQLValueString($_POST['cCFax'], "text"),
                       GetSQLValueString($_POST['cCEmail'], "text"),
                       GetSQLValueString($_POST['fCChgLmt'], "double"),
                       GetSQLValueString($_POST['cFUD1'], "text"),
                       GetSQLValueString($_POST['cFUD2'], "text"),
                       GetSQLValueString(isset($_POST['cFUD3']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString($_POST['cFUD4'], "text"),
                       GetSQLValueString(isset($_POST['cFUD5']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString($_POST['cMake'], "text"),
                       GetSQLValueString($_POST['cClaim'], "text"),
                       GetSQLValueString($_POST['cModel'], "text"),
                       GetSQLValueString($_POST['cIMEI'], "text"),
                       GetSQLValueString($_POST['cFUDFax'], "text"),
                       GetSQLValueString(isset($_POST['cA1']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cA2']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cA3']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString($_POST['cAother'], "text"),
                       GetSQLValueString(isset($_POST['cFCS1']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCS2']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCS3']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCS4']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCS5']) ? "true" : "", "defined","'(included inspection fee $45.0 paid)'","' '"),
                       GetSQLValueString(isset($_POST['cFCS6']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCS7']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCS8']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCD1']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCD2']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCD3']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCM1']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCM2']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCM3']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCM4']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCM5']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCM6']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCM7']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCM8']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCP1']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCP2']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCP3']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCP4']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCG1']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCG2']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCG3']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCG4']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCG5']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCG6']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCG7']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCG8']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCG9']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCU1']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCU2']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cFCU3']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString($_POST['cFCDesc'], "text"),
                       GetSQLValueString($_POST['cLMake'], "text"),
                       GetSQLValueString($_POST['cLModel'], "text"),
                       GetSQLValueString($_POST['cLDeposit'], "text"),
                       GetSQLValueString($_POST['cLIMEI'], "text"),
                       GetSQLValueString(isset($_POST['cLB']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cLC']) ? "true" : "", "defined","'checked'","' '"),
                       GetSQLValueString(isset($_POST['cIIFP']) ? "true" : "", "defined","'(included inspection fee paid)'","' '"),
                       GetSQLValueString($_POST['cLother'], "text"),
                       GetSQLValueString($_POST['cAgentID'], "text"),
                       GetSQLValueString($_POST['agName'], "text"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($insertSQL, $localhost) or die(mysql_error());
  
  //Increase the Job Number
  $updateSQL = "UPDATE tbjn SET iJN=iJN+1 WHERE iID='1'";
  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());
  
  //insert Job Log  
  mysql_select_db($database_localhost, $localhost);
  $logperson = $_POST['cStfName'];
  $logcontent = "Job created by Dealer ". $_POST['cSbmBy'];
  $sql_log = sprintf("insert tblog (cJN, dtDate, cPerson, cContent) values (%s,%s,%s,%s)",
  					$row_JN['iJN'],
					"NOW()",
                    GetSQLValueString($logperson, "text"),
                    GetSQLValueString($logcontent, "text"));
  $Result1 = mysql_query($sql_log, $localhost) or die(mysql_error());
  
  //Insert the Customer's info
  $insertSQL = sprintf("INSERT INTO tbcust (cName, cLastName, cHomePhn, cWorkPhn, cAdd1, cAdd2, cAdd3, cFax, cEmail) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['cCName'], "text"),
                       GetSQLValueString($_POST['cCLastName'], "text"),
                       GetSQLValueString($_POST['cCHomePhn'], "text"),
                       GetSQLValueString($_POST['cCWorkPhn'], "text"),
                       GetSQLValueString($_POST['cCAdd1'], "text"),
                       GetSQLValueString($_POST['cCAdd2'], "text"),
                       GetSQLValueString($_POST['cCAdd3'], "text"),
                       GetSQLValueString($_POST['cCFax'], "text"),
                       GetSQLValueString($_POST['cCEmail'], "text"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($insertSQL, $localhost) or die(mysql_error());

  //Jump to success page
  $insertGoTo = "de_srf_2c.php?cJN=".$row_JN['iJN'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
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
<style type="text/css">
<!--
.style2 {color: #999999}
-->
</style>
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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function ValidatePhone(){
	var homePh = MM_findObj('cCHomePhn');
	var workPh = MM_findObj('cCWorkPhn');
	var mobilePh = MM_findObj('cCFax');
	var securtyCode = MM_findObj('cFUDFax');
	if(homePh.value.length < 7){
		alert("Home Phone Number at least 7 digi");
		document.MM_returnValue = false;
	}
	if(workPh.value.length != 0 && workPh.value.length < 7){
		alert("Work Phone Number at least 7 digi");
		document.MM_returnValue = false;
	}
	if(mobilePh.value.length != 0 && mobilePh.value.length < 9){
		alert("Mobile Phone Number at least 9 digi");
		document.MM_returnValue = false;
	}
	if(securtyCode.value.length == 0){
		alert("Enter the Security Code please, or N/A only");
		document.MM_returnValue = false;
	}
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
      <form name="form1" method="POST" action="srf_d.php">
      <table width="750" border="0" align="center" cellpadding="3" cellspacing="0" class="underline">
        <tr>
          <td align="right"><span class="head_black_bold">Job No.</span>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row_JN['iJN'];?>&nbsp;</td>
        </tr>
        <tr>
          <td align="center" class="head_black_bold">SERVICE REQUEST FORM <br></td>
        </tr>
      </table>
      <table width="750" border="0" align="center" cellpadding="3" cellspacing="0" class="underline">
        <tr>
          <td colspan="4" class="head_black_bold">Job Details </td>
        </tr>
        <tr>
          <td width="91" align="right"><span class="head_red_bold">*</span>Submitted By:</td>
          <td width="254">
            <input name="cSbmBy" type="text" class="ipt_srf" id="cSbmBy" value="<?php echo $_SESSION['DE_Userrealname'];?>">
          </td>
          <td width="129" align="right"><span class="head_red_bold">*</span>Staff Name:</td>
          <td width="252"><input name="cStfName" type="text" class="ipt_srf" id="cStfName"></td>
        </tr>
      </table>
      <table width="750" border="0" align="center" cellpadding="3" cellspacing="0" class="underline">
        <tr>
          <td colspan="4" class="head_black_bold">Customer Details </td>
        </tr>
        <tr>
          <td width="71" align="right"><span class="head_red_bold">*</span>Name:</td>
          <td width="272">
            <table width="100%"  border="0" cellspacing="1" cellpadding="0">
              <tr>
                <td width="48%"><input name="cCName" type="text" class="ipt_srf" id="cCName"></td>
                <td width="52%"><input name="cCLastName" type="text" class="ipt_srf" id="cCLastName"></td>
              </tr>
              <tr align="center">
                <td><span class="style2">(first name)</span></td>
                <td><span class="style2">(last name)</span></td>
              </tr>
            </table></td>
          <td width="98" align="right"><span class="head_red_bold">*</span>Home Ph:</td>
          <td width="285"><input name="cCHomePhn" type="text" class="ipt_srf" id="cCHomePhn"></td>
        </tr>
        <tr>
          <td align="right">Address:</td>
          <td><input name="cCAdd1" type="text" class="ipt_srf" id="cCAdd1"></td>
          <td align="right">Work Ph: </td>
          <td><input name="cCWorkPhn" type="text" class="ipt_srf" id="cCWorkPhn"></td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td><input name="cCAdd2" type="text" class="ipt_srf" id="cCAdd2"></td>
          <td align="right">Mobile: </td>
          <td><input name="cCFax" type="text" class="ipt_srf" id="cCFax"></td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td><input name="cCAdd3" type="text" class="ipt_srf" id="cCAdd3"></td>
          <td align="right">Notify Exceeds: </td>
          <td>$<input name="fCChgLmt" type="text" class="ipt_srf" id="fCChgLmt" style="width:100px; "> </td>
        </tr>
        <tr>
          <td align="right">Email:</td>
          <td><input name="cCEmail" type="text" class="ipt_srf" id="cCEmail"></td>
          <td align="right">&nbsp;</td>
          <td><?php if(isset($_SESSION['DE_Username']) && ($_SESSION['DE_Username']=='omnitech' || $_SESSION['DE_Username']=='omnitechaly' || $_SESSION['DE_Username']=='omnitechsp' || $_SESSION['DE_Username']=='omnitechm' || $_SESSION['DE_Username']=='omnitechw' || $_SESSION['DE_Username']=='omnitechsl' || $_SESSION['DE_Username']=='omnitechnl' || $_SESSION['DE_Username']=='omnitechh' || $_SESSION['DE_Username']=='omnitechd')){?>
            Agent:
            <input name="agName" type="text" id="agName" class="ipt_srf" style="width:200px; " readonly onDblClick="MM_openBrWindow('repair/ag_sel.php','Select','scrollbars=yes,resizable=yes,width=600,height=400')">              <?php }?>&nbsp;
            <input name="cAgentID" type="hidden" id="cAgentID" value="" readonly></td>
        </tr>
      </table>
      <table width="750" border="0" align="center" cellpadding="3" cellspacing="0" class="underline">
        <tr>
          <td colspan="6" class="head_black_bold">Faulty Device Details 
            
            
            <input name="cFUD1" type="hidden" id="cFUD1" value="checked">
            <input name="cFUD2" type="hidden" id="cFUD2" value="checked">
            <input name="cFUD4" type="hidden" id="cFUD4" value="checked"></td>
        </tr>
        <tr>
          <td width="66"><span class="head_red_bold">*</span>Make:</td>
          <td width="227"><input name="cMake" type="text" class="ipt_srf" id="cMake"></td>
          <td width="81" align="right"><span class="head_red_bold">*</span>Model:</td>
          <td colspan="3"><input name="cModel" type="text" class="ipt_srf" id="cModel"></td>
        </tr>
        <tr>
          <td><span class="head_red_bold">*</span>IMEI/ESN:</td>
          <td><input name="cIMEI" type="text" class="ipt_srf" id="cIMEI" maxlength="17"></td>
          <td align="right"><span class="head_red_bold">*</span>Security Code:</td>
          <td width="172"><input name="cFUDFax" type="text" class="ipt_srf" id="cFUDFax"></td>
          <td width="50" align="right">Claim No. </td>
          <td width="118"><input name="cClaim" type="text" class="ipt_srf" id="cClaim"></td>
        </tr>
        <tr>
          <td>Accessories:</td>
          <td colspan="5"><input name="cA1" type="checkbox" id="cA1" value="checked">
          Battery&nbsp;&nbsp;
              <input name="cA2" type="checkbox" id="cA2" value="checked">
              Charger(send with all power-related faults)&nbsp;&nbsp;
              <input name="cA3" type="checkbox" id="cA3" value="checked">
             SIM CARD&nbsp;&nbsp;
             <input name="cFUD3" type="checkbox" id="cFUD3" value="checked">
              MEMORY CARD&nbsp;&nbsp;
		    Other:
		    <input name="cAother" type="text" class="ipt_login" id="cAother"> </td>
          </tr>
      </table>
      <table width="750" border="0" align="center" cellpadding="3" cellspacing="0" class="underline">
        <tr valign="top">
          <td colspan="5" class="head_black_bold">Fault Details:</td>
        </tr>
        <tr valign="top">
          <td>&nbsp;</td>
          <td class="head_black_bold">Timing of Fault 
            <input name="cFCU3" type="hidden" id="cFCU3" value="checked">
            <input name="cFCG1" type="hidden" id="cFCG1" value="checked">
            <input name="cFCG5" type="hidden" id="cFCG5" value="checked">
            <input name="cFCG2" type="hidden" id="cFCG2" value="checked">
            <input name="cFCG4" type="hidden" id="cFCG4" value="checked">
            <input name="cFCG7" type="hidden" id="cFCG7" value="checked">
            <input name="cFCG9" type="hidden" id="cFCG9" value="checked">
            <input name="cFCG3" type="hidden" id="cFCG33" value="checked">
            <input name="cFCG6" type="hidden" id="cFCG63" value="checked">
            <input name="cFCG8" type="hidden" id="cFCG83" value="checked">
            <input name="cFCD3" type="hidden" id="cFCD33" value="checked">
            <input name="cFCD1" type="hidden" id="cFCD14" value="checked">
            <input name="cFCD2" type="hidden" id="cFCD24" value="checked">
            <input name="cFCP3" type="hidden" id="cFCP34" value="checked">
            <input name="cFCP4" type="hidden" id="cFCP44" value="checked">
            <input name="cFCP2" type="hidden" id="cFCP24" value="checked">
            <input name="cFCP1" type="hidden" id="cFCP14" value="checked"></td>
          <td><input name="cFCU1" type="checkbox" id="cFCU12" value="checked"> 
          Continuous
</td>
          <td><input name="cFCU2" type="checkbox" id="cFCU2" value="checked"> 
          Intermittent
</td>
          <td>&nbsp;</td>
        </tr>
        <tr valign="top">
          <td>&nbsp;</td>
          <td><span class="head_black_bold">Type of Fault
            <input name="cFCS3" type="hidden" id="cFCS3" value="checked">
          </span></td>
          <td><input name="cFCM1" type="checkbox" id="cFCM1" value="checked">            
            Power Problem </td>
          <td><input name="cFCM4" type="checkbox" id="cFCM4" value="checked">
            Ring Problem </td>
          <td><input name="cFCM2" type="checkbox" id="cFCM2" value="checked">
            Earpiece Problem </td>
        </tr>
        <tr valign="top">
          <td>&nbsp;</td>
          <td><span class="head_black_bold">
            <input name="cFCS6" type="hidden" id="cFCS6" value="checked">
            <input name="cFCS7" type="hidden" id="cFCS7" value="checked">
            <input name="cFCS8" type="hidden" id="cFCS8" value="checked">
            <input name="cFCS1" type="hidden" id="cFCS13" value="checked">
            <input name="cFCS4" type="hidden" id="cFCS43" value="checked">
            <input name="cFCS2" type="hidden" id="cFCS23" value="checked">
          </span></td>
          <td><input name="cFCM5" type="checkbox" id="cFCM5" value="checked">
            Microphone Problem </td>
          <td><input name="cFCM8" type="checkbox" id="cFCM8" value="checked">
            Keypad Problem </td>
          <td><input name="cFCM6" type="checkbox" id="cFCM6" value="checked">
            Call Problem </td>
        </tr>
        <tr valign="top">
          <td width="8">&nbsp;</td>
          <td width="179" class="head_black_bold">&nbsp;</td>
          <td width="181"><input name="cFCM3" type="checkbox" id="cFCM3" value="checked"> 
            Display Problem
</td>
          <td width="185"><input name="cFCM7" type="checkbox" id="cFCM7" value="checked"> 
            Software Problem
</td>
          <td width="167">&nbsp;</td>
        </tr>
        <tr valign="top">
          <td>&nbsp;</td>
          <td>Description of Fault.<br>
            Please describe the fault in as much detail as possible</td>
          <td colspan="3"><textarea name="cFCDesc" rows="6" wrap="VIRTUAL" id="textarea" style="width:100%; "></textarea></td>
          </tr>
        <tr valign="top">
          <td>&nbsp;</td>
          <td><span class="head_black_bold">
            <input name="cFUD5" type="checkbox" id="cFUD5" value="checked">
          </span>WARRANTY CLAIM</td>
          <td colspan="3">  This only applies for the device that purchase from Omni Tech with proof of purchase retained or for re-service device under same fault occur within 50 days. </td>
        </tr>
      </table>
      <table width="750" border="0" align="center" cellpadding="3" cellspacing="0" class="underline">
        <tr>
          <td colspan="4" class="head_black_bold">Loan Equipment (if applicable) </td>
        </tr>
        <tr>
          <td width="96" align="right">Handset Make: </td>
          <td width="225"><input name="cLMake" type="text" class="ipt_srf" id="cLMake"></td>
          <td width="124" align="right">Handset Model:</td>
          <td width="281"><input name="cLModel" type="text" class="ipt_srf" id="cLModel"></td>
        </tr>
        <tr>
          <td align="right">Deposit taken: </td>
          <td><input name="cLDeposit" type="text" class="ipt_srf" id="cLDeposit"></td>
          <td align="right">IMEI</td>
          <td><input name="cLIMEI" type="text" class="ipt_srf" id="cLIMEI" maxlength="17"></td>
        </tr>
        <tr>
          <td><input name="cLB" type="checkbox" id="cLB" value="checked">
      Battery</td>
          <td><input name="cLC" type="checkbox" id="cLC" value="checked">
      Charger</td>
          <td align="right">Other:</td>
          <td><input name="cLother" type="text" class="ipt_srf" id="cLother"></td>
        </tr>
      </table>
      <table width="750" border="0" align="center" cellpadding="3" cellspacing="0">
        <tr>
          <td><?php 
			  if(in_array($_SESSION['DE_Username'], $_SESSION['DE_BranchList'])){
			  ?>
			  Inspection Fee
              <input name="cIIFP" type="checkbox" id="cIIFP" value="checked">
              &nbsp;&nbsp;Inspection Fee $45.0
              <input name="cFCS5" type="checkbox" id="cFCS5" value="checked">
			  <?php } ?>              </td>
        </tr>
        <tr>
          <td><input name="iSbmType" type="hidden" id="iSbmType" value="1">
              <input name="cStatus" type="hidden" id="cStatus" value="S05">
              <input name="cSbm" type="hidden" class="ipt_srf" id="cSbm" value="<?php echo $_SESSION['DE_Username'];?>">
              <input name="cLocation" type="hidden" id="cLocation" value="L00">
              <input type="hidden" name="MM_insert" value="form1">
              <a href="termncond.php" target="_blank">Terms &amp; Conditions &gt;&gt; </a></td>
        </tr>
        <tr>
          <td align="center"><input name="Submit" type="submit" onClick="MM_validateForm('cSbmBy','','R','cStfName','','R','cCName','','R','cCLastName','','R','cCHomePhn','','R','cMake','','R','cModel','','R','cIMEI','','R');ValidatePhone();return document.MM_returnValue" value="Submit"></td>
        </tr>
      </table>
      </form>
    <!-- InstanceEndEditable --></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($JN);
?>
