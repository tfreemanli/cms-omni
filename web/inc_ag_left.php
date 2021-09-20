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
//-->
</script>


<table width="204" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="34" valign="top"><img src="./images/1x1.gif" width="34" height="1"></td>
            <td width="161" valign="top">
<?php
if(isset($_SESSION['AG_UserGroup']) && $_SESSION['AG_UserGroup']=="agent"){
?>
<table width="160" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
      <table width="160" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td valign="top"> &nbsp;<br>
              <strong>Welcome <?php echo $_SESSION['AG_Userrealname'];?></strong>          <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="4">
            <tr>
              <td align="left" bgcolor="#FFFFFF"><img src="" width="1" height="5" alt=""></td>
            </tr>
            <tr>
              <td align="left"><a href="ag_memo_list.php">Memo</a></td>
            </tr>
            <tr>
              <td align="left" bgcolor="#FFFFFF"><img src="" width="1" height="5" alt=""></td>
            </tr>
            <tr>
              <td align="left"><a href="ag_edit.php">My Info</a></td>
            </tr>
            <tr>
              <td align="left" bgcolor="#FFFFFF"><img src="" width="1" height="5" alt=""></td>
            </tr>
            <tr>
              <td align="left"><a href="ag_stat.php">Stat</a></td>
            </tr>
            <tr>
              <td align="left" bgcolor="#FFFFFF"><img src="" width="1" height="5" alt=""></td>
            </tr>
            <tr>
              <td align="left"><a href="ag_logout.php?doLogout=true">Logout</a></td>
            </tr>
          </table>          </td>
        </tr>
    </table></td>
  </tr>
</table>
<?php
}else{
?>
			<table width="161" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><strong>Agent Login</strong> </td>
              </tr>
              <tr>
                <td><table width="155" border="0" cellspacing="0" cellpadding="2">
                  <form name="frmDLogin" method="post" action="./ag_login.php">
                    <tr>
                      <td width="63" align="left">AgentNum </td>
                      <td width="62" align="right">
                        <input name="cLogin" type="text" class="ipt_login" id="cLogin3" size="6"></td>
                      <td width="18" align="right">&nbsp;</td>
                    </tr>
                    <tr>
                      <td align="left">Password</td>
                      <td align="right"><input name="cPsw" type="password" class="ipt_login" id="cPsw3" size="6"></td>
                      <td align="right"><input border=0 name=imageField src="images/botton_go.gif" align="middle" width="14" height="17" type=image></td>
                    </tr>
                    <tr>
                      <td align="center">&nbsp;</td>
                      <td colspan="2"><a href="ag_fgt_psw.php">Forget Pwd</a></td>
                    </tr>
                  </form>
                </table>                </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table>
<?php
}
?><p>&nbsp;</p>
<!-- Begin Volusion Live Chat //--><!-- End Volusion Live Chat //--></td>
            <td width="9"><img src="./images/1x1.gif" width="9" height="1" hspace="0"></td>
          </tr>
</table>
		
		