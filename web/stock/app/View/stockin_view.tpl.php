<?php include(TPL_DIR.'header.tpl.php'); ?>
<div id="main">
		<div id="sidebar">
			<?php include(TPL_DIR.'sidebar.tpl.php'); ?>
		</div>
		
		<div id="mainContent">
			<a class="right" href="<?php echo url('stockin', 'index'); ?>">back</a>
			<h3>Stock Detail View - (#ID: <?php echo $stock['id']; ?>)</h3>
			<div class="view_block">
				<h4>Basic Information</h4>
				<table width="100%" border="0" cellspacing="1">
					<tr>
						<td width="13%" class="tb_title">Stock In Date:</td>
						<td width="18%"><?php echo date('d-m-Y H:i', $stock['stock_date']); ?></td>
						<td width="10%" class="tb_title">Supplier:</td>
						<td width="19%"><?php echo $stock['supplier']['supplier']; ?></td>
						<td width="11%" class="tb_title">Branch:</td>
						<td width="13%"><?php echo $stock['branch']; ?></td>
						<td width="10%" class="tb_title">Operator:</td>
						<td width="6%"><?php echo $stock['operator']['cName']; ?></td>
					</tr>
				</table>
			</div>
			
			<div class="view_block">
				<h4>Product List</h4>
				<?php if($_SESSION['role'] == 'admin' || ($_SESSION['role'] == 'spadmin' && $stock['branch']=='sylviapark')){?>
				<input type="button" name="add" value="Add" id="add" onclick="addNew();" />
				<?php }?>
				<table width="100%" border="0" cellspacing="1">
					<tr>
						<th width="62%">Product Name</th>
						<th width="10%">Price (NZD)</th>
						<th width="8%">Quantity</th>
						<th width="8%">Total</th>
						<th width="12%">Operation</th>
					</tr>
					<tbody>
						<?php foreach ($stockinProducts as $row): ?>
						<tr>
							<td><?php echo $row['product']['name']; ?>&nbsp;(<?php echo $row['product']['branch']; ?>)</td>
							<td>$<?php echo $row['price']; ?></td>
							<td><?php echo $row['quantity']; ?></td>
							<td>$<?php echo number_format($row['quantity'] * $row['price'], 2, '.', ','); ?></td>
							<td>
                            <?php if($_SESSION['role'] == 'admin' || ($_SESSION['role'] == 'spadmin' && $stock['branch']=='sylviapark')){?>
								<a href="<?php echo url('stockinproduct', 'edit', array('id'=>$row['id'])); ?>">Modify</a>
								<a href="<?php echo url('stockinproduct', 'del', array('id'=>$row['id'], 'stockin_id' => $row['stockin_id'])); ?>" onclick="return delConfirm();">Delete</a>
                                <?php }?>&nbsp;
							</td>
						</tr>	
						<?php endforeach ?>		
					</tbody>
				</table>
			</div>
			
			<div id="remarks" class="view_block">
				<h4>Remarks</h4>
				
				<?php foreach ($remarks as $row): ?>
				<div class="remark_row">
					<div class="remark_name">
						<span class="right"><?php echo date("d-m-Y H:i", $row['remark_date']); ?></span>
						By: <?php echo $row['operator']['cName']; ?> 
						<?php if ($row['operator']['cName'] == $_SESSION['name']): ?>&nbsp;&nbsp;&nbsp;
							<a href="<?php echo url("remark", "edit", array('id' => $row['id'])); ?>">Edit</a>
							<a href="<?php echo url("remark", "del", array('id' => $row['id'], 'stockin_id'=>$stock['id'])); ?>">Delete</a>
						<?php endif ?>
					</div>
					<div class="remark_content">
						<?php echo $row['content']; ?>
					</div>
				</div>
				<?php endforeach ?>
				
				
				<form id="remark_form" action="<?php echo url('remark', 'add'); ?>" method="post" accept-charset="utf-8">
				<h5>Add New Remark</h5>
				<dl>
					<dt></dt>
					<dd><input type="hidden" name="stockin_id" value="<?php echo $stock['id']; ?>" id="stockin_id"></dd>
					
					<dt>Operator</dt>
					<dd><select name="operator_id" id="operator_id">
						<?php foreach ($users as $key => $name): ?>
							<?php if ($key == $_SESSION['uid']): ?>
								<option value="<?php echo $key; ?>" selected><?php echo $name; ?></option>
							<?php else: ?>
								<option value="<?php echo $key; ?>"><?php echo $name; ?></option>
							<?php endif ?>
						<?php endforeach ?>
					</select></dd>
					
					<dt>Content</dt>
					<dd><textarea name="content" rows="8" cols="40"></textarea></dd>
					
					<dt></dt>
					<dd><input type="submit" name="submit" value="Submit" id="submit"></dd>
				</dl>
				</form>
			</div>
			
		</div>
		
		<div style="clear: both"></div>
</div>
<?php include(TPL_DIR.'footer.tpl.php'); ?>

<script type="text/javascript" charset="utf-8">
	function addNew() {
		window.location.href="<?php echo url('stockinproduct', 'add', array('stockin_id'=>$stock['id'])); ?>";
	}
	
	function delConfirm() {
		return confirm("Do you confirm to delete this record?");
	}

</script>