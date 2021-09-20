<?php include(TPL_DIR.'header.tpl.php'); ?>
<div id="main">
	<div id="sidebar">
		<?php include(TPL_DIR.'sidebar.tpl.php'); ?>	
	</div>
	
	<div id="mainContent">
		<a class="right" href="<?php echo url('category', 'add'); ?>" title="add new category">
			<img src="./images/add.png" />
		</a>
		<h3>Category List</h3>
		<table width="50%" border="0" cellspacing="1">
			<tr>
				<th>Name</th>
				<th>Operation</th>
			</tr>
			<tbody>
				<?php foreach ($categories as $category): ?>
					<tr>
						<td><?php echo $category['name']; ?></td>
						<td>
							<ul class="operation">
								<li><a href="<?php echo url('product', 'index', array('cid'=>$category['id'])); ?>" title="product list">
									<img src="./images/list.png" />
								</a></li>
								<li><a href="<?php echo url('category', 'edit', array('id'=>$category['id'])); ?>" title="modifty">
									<img src="./images/edit.png" />
								</a></li>
								<li><a href="<?php echo url('category', 'del', array('id'=>$category['id'])); ?>" title="delete" onclick="return delConfirm();">
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
		return confirm("Do you confirm to delete this Category?");
	}
</script>