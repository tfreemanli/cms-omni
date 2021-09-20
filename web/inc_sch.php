<style type="text/css">
<!--
.STYLE1 {color: #666666; font-size:12px}
-->
</style>
<table width="100%"  border="0" cellspacing="1" cellpadding="0">
  <form name="frm_sch" method="post" action="sch_res.php">
      <tr>
        <td width="64%" align="right" valign="bottom">
        <?php 
		$sch_val="";
		if(isset($_POST['sch_val'])) $sch_val=$_POST['sch_val'];
		?>
        <input name="sch_val" type="text" class="ipt_sch" value="<?php echo $sch_val;?>" size="10">
        <input type="image" src="images/botton_go.gif" align="top" width="14" height="17">&nbsp;
		</td>
        <td width="36%" valign="bottom"><a href="sch_adv.php"><span class="STYLE1">Adv Search </span></a></td>
      </tr>
  </form></table>
