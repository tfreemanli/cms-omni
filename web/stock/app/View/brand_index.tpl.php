<?php include(TPL_DIR.'header.tpl.php'); ?>
<div id="main">
	<div id="sidebar">
		<?php include(TPL_DIR.'sidebar.tpl.php'); ?>	
	</div>
	
	<div id="mainContent">
		<a class="right" href="<?php echo url('brand', 'add'); ?>" title="add new brand">
			<img src="./images/add.png" />
		</a>
		<h3>Brand List</h3>
		<table width="50%" border="0" cellspacing="1">
			<tr>
				<th>Brand Name</th>
				<th>Operation</th>
			</tr>
			<tbody>
				<?php foreach ($brands as $brand): ?>
					<tr>
						<td><?php echo $brand['name']; ?></td>
						<td>
							<ul class="operation">
								<li><a href="<?php echo url('brand', 'edit', array('id'=>$brand['id'])); ?>" title="Modify">
									<img src="./images/edit.png" />
								</a></li>
								<li><a href="<?php echo url('brand', 'del', array('id'=>$brand['id'])); ?>" title="delete" onclick="return delConfirm();">
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
		return confirm("Do you confirm to delete this brand?");
	}
</script>