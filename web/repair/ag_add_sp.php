<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk">
<link href="../manage/css.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../js/common.js"></script>
<script language="javascript">
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

function add_usr(){
	MM_validateForm('cName','','R','cVIPNum','','R');
	if(document.MM_returnValue){
		var frm = MM_findObj('form1');
		frm.submit();
	}
	return true;
}
//-->
</script>
<title>Add</title>
</head>

<body>
<table width="100%"  border="0" cellspacing="14" cellpadding="2">
  <tr>
    <td class="Mgr_Heading">Add An Agent&nbsp;</td>
  </tr>
</table>
<hr size="1" >
<table width="100%"  border="0" align="center" cellpadding="3" cellspacing="5">
  <form name="form1" method="POST" action="ag_sel.php">
    <tr>
      <td width="25%" align="right" class="td_block">*First Name:</td>
      <td width="75%">
        <input name="cName" type="text" class="ipt_normal" id="cName"></td>
    </tr>
    <tr>
      <td align="right" class="td_block">Last Name: </td>
      <td><input name="cLastName" type="text" class="ipt_normal" id="cLastName">
          <input name="cIsVIP" type="hidden" value="1"></td>
    </tr>
    <tr id="DIVVIP1">
      <td align="right" class="td_block">*Agent Num </td>
      <td><input name="cVIPNum" type="text" class="ipt_normal" id="cVIPNum"></td>
    </tr>
    <tr>
      <td align="right" class="td_block">Email:</td>
      <td><input name="cEmail" type="text" class="ipt_normal" id="cEmail"></td>
    </tr>
    <tr>
      <td align="right" class="td_block">Home Phone:</td>
      <td><input name="cHomePhn" type="text" class="ipt_normal" id="cHomePhn"></td>
    </tr>
    <tr>
      <td align="right" class="td_block">Work/Other Phone: </td>
      <td><input name="cWorkPhn" type="text" class="ipt_normal" id="cWorkPhn"></td>
    </tr>
    <tr>
      <td align="right" class="td_block">Address:</td>
      <td><input name="cAdd1" type="text" class="ipt_normal" id="cAdd1"></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td><input name="cAdd2" type="text" class="ipt_normal" id="cAdd2"></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td><input name="cAdd3" type="text" class="ipt_normal" id="cAdd3"></td>
    </tr>
    <tr>
      <td align="right" class="td_block">Note: </td>
      <td><textarea name="cFax" wrap="VIRTUAL" class="ipt_normal" id="cFax" style="width:250px;height:150px; "></textarea></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input name="Submit" type="button" class="btn" value=" Submit " onClick="add_usr()">
          <input name="cMake" type="hidden" class="ipt_normal" id="cMake">
          <input name="cModel" type="hidden" class="ipt_normal" id="cModel">
          <input name="cIMEI" type="hidden" class="ipt_normal" id="cIMEI">
          <input name="cVIPVDate" type="hidden" class="ipt_normal" id="cVIPVDate">
          <input name="cVIPEDate" type="hidden" class="ipt_normal" id="cVIPEDate"></td>
    </tr>
    <input type="hidden" name="MM_insert" value="form1">
  </form>
</table>
</body>
</html>
