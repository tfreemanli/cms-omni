<?php include(TPL_DIR.'header.tpl.php'); ?>
<div id="main">
	<div id="sidebar">
		<?php include(TPL_DIR.'sidebar.tpl.php'); ?>	
	</div>
	
	<div id="mainContent">
		<a class="right" href="<?php echo url('supplier', 'add'); ?>" title="add new supplier">
			<img src="./images/add.png" />
		</a>
		<h3>Supplier List</h3>
		<table width="100%" border="0" cellspacing="1">
			<tr>
				<th>Supplier</th>
				<th>Contact</th>
				<th>Phone</th>
				<th>Email</th>
				<th>Address</th>
				<th>Operation</th>
			</tr>
			<tbody>
				<?php foreach ($suppliers as $supplier): ?>
					<tr>
						<td><?php echo $supplier['supplier']; ?></td>
						<td><?php echo $supplier['contact']; ?></td>
						<td><?php echo $supplier['phone']; ?></td>
						<td><a href="mailto:<?php echo $supplier['email']; ?>"><?php echo $supplier['email']; ?></a></td>
						<td><?php echo $supplier['address']; ?></td>
						<td>
							<ul class="operation">
								<li><a href="<?php echo url('supplier', 'edit', array('id'=>$supplier['id'])); ?>">
									<img src="./images/edit.png" />
								</a></li>
								<li><a href="<?php echo url('supplier', 'del', array('id'=>$supplier['id'])); ?>" onclick="return delConfirm();">
									<img src="./images/bin.png" />
								</a></li>
							</ul>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
	
	<div style="clear: both"></div>
</div>
<?php include(TPL_DIR.'footer.tpl.php'); ?>

<script type="text/javascript" charset="utf-8">
	function delConfirm() {
		return confirm("do you confirm to delete this supplier?");
	}
</script>