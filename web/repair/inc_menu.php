<?php require_once('../Connections/localhost.php'); ?>
<table width="95%" border="0" align="center" cellpadding="5" cellspacing="8">
  <tr>
    <td>I AM
      <select name="whoami" id="whoami" onchange="javascript:setWhoami(this);">
      <option value=""></option>
      <?php 
	if(isset($_SESSION['RP_WAIARR'])){
		$arr = $_SESSION['RP_WAIARR'];
	  
	  foreach ($arr as $value) {?>
      <option value="<?php echo $value;?>"><?php echo $value;?></option>
      <?php
	  }
	 }?>
    </select></td>
  </tr>
  <script language="javascript">
  <!--  
  var WHOAMI = MM_findObj('whoami');
  <?php if(isset($_SESSION['RP_WHOAMI']) && $_SESSION['RP_WHOAMI']!= ''){?>
  WHOAMI.value = '<?php echo $_SESSION['RP_WHOAMI'];?>';
  <?php }else{ ?>
  alert('Please select WHO-I-AM first.');
  WHOAMI.focus();
  <?php }?>
  //-->
  </script>
  <script id="scrptWhoami"></script>
  <tr>
    <td class="td_block"><a href="index.php" class="Mgr_Heading">Home</a></td>
  </tr>
  <?php
	  if(isset($_SESSION['RP_UserGroup']) && $_SESSION['RP_UserGroup']=="tbopr"){
	  		if(isset($_SESSION['RP_Username']) && $_SESSION['RP_Username']=="admin"){
	  ?>
  <tr>
    <td class="td_block"><a href="op_list.php" class="Mgr_Heading">Operator</a></td>
  </tr>
  <tr>
    <td class="td_block"><a href="tip_list.php" class="Mgr_Heading">Type In Person</a></td>
  </tr>
  <tr>
    <td class="td_block"><a href="crr_list.php" class="Mgr_Heading">Couriers</a></td>
  </tr>
  <!--
  <tr>
    <td class="td_block"><a href="dp_list.php" class="Mgr_Heading">Discount Passwd</a></td>
  </tr>
  //-->
  <?php 
			  }//end if username==admin
			  ?>
  <tr>
    <td class="td_block"><a href="stat_drft.php" class="Mgr_Heading">Draft Invoice</a></td>
  </tr>
  <tr>
    <td class="td_block"><a href="te_list.php" class="Mgr_Heading">Technician</a></td>
  </tr>
  <tr>
    <td class="td_block"><a href="de_list.php" class="Mgr_Heading">Dealer</a> / <a href="de_stat.php" class="Mgr_Heading">Stat</a></td>
  </tr>
  <tr>
    <td class="td_block"><a href="ag_list.php" class="Mgr_Heading">Agent</a> / <a href="ag_stat.php" class="Mgr_Heading">Stat</a></td>
  </tr>
  <tr>
    <td class="td_block"><a href="ct_list.php" class="Mgr_Heading">Customer</a></td>
  </tr>
  <!--
  <tr>
    <td class="td_block"><a href="srf_manual_add.php" class="Mgr_Heading">Add SRF(Manual)</a></td>
  </tr>
  //-->
  <?php
	  }//end if usergroup==tbopr
	  ?>
  <tr>
    <td class="td_block"><a href="req_list_all.php" class="Mgr_Heading">Repair Request</a></td>
  </tr>
  <tr>
    <td class="td_block"><a href="do_list.php" class="Mgr_Heading">Delivery Order</a></td>
  </tr>
  <?php
	  if(isset($_SESSION['RP_UserGroup']) && $_SESSION['RP_UserGroup']=="tbtech"){
	  ?>
  <tr>
    <td class="td_block"><a href="req_list_all.php?myjob=1" class="Mgr_Heading">My Job</a></td>
  </tr>
  <?php
	  }//end if usergroup==tbtech
	  ?>
  <tr>
    <td class="td_block"><a href="myinfo_edit.php" class="Mgr_Heading">My Info</a></td>
  </tr>
  <?php if($_SESSION['RP_ROLE']=="admin" || $_SESSION['RP_ROLE']=="spadmin" ){?>
  <tr>
    <td class="td_block"><a href="../stock/index.php?option=index&task=bridge&uid=<?php echo $_SESSION['RP_UID'];?>&name=<?php echo $_SESSION['RP_Userrealname'];?>&role=<?php echo $_SESSION['RP_ROLE'];?>&key=<?php echo $_SESSION['RP_KEY'];?>" class="Mgr_Heading">Stock Manage</a></td>
  </tr>
  <?php }?>
  <tr>
    <td class="td_block"><a href="product_sch.php" class="Mgr_Heading">Part Search</a> </td>
  </tr>
  <tr>
    <td class="td_block"><a href="logout.php" class="Mgr_Heading">Logout</a></td>
  </tr>
</table>