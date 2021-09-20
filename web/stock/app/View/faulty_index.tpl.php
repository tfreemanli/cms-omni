<?php include(TPL_DIR.'header.tpl.php'); ?>
<div id="main">
	<div id="sidebar">
		<?php include(TPL_DIR.'sidebar.tpl.php'); ?>	
	</div>
	
	<div id="mainContent">
		<a class="right" href="<?php echo url('faulty', 'add'); ?>" title="add new faulty">
			<img src="./images/add.png" />
		</a>
		<h3>Faulty List</h3>
		
		<table width="100%" border="0" cellspacing="1">
			<tr>
				<th>Product</th>
				<th>Job Number</th>
				<th>Quantity</th>
				<th>Operator</th>
				<th>Supplier</th>
				<th>Create Date</th>
				<th>Operation</th>
			</tr>
			<tbody>
				<?php foreach ($faulties as $faulty): ?>
					<tr>
						<td><?php echo $faulty['product']['name']; ?></td>
						<td><?php echo $faulty['job_num']; ?></td>
						<td><?php echo $faulty['quantity']; ?></td>
						<td><?php echo $faulty['operator']['cName']; ?></td>
						<td><?php echo $faulty['supplier']['supplier']; ?></td>
						<td><?php echo date("d-m-Y H:i", $faulty['faulty_date']); ?></td>				
						<td>
                        <?php if($_SESSION['role'] == 'admin' || ($_SESSION['role'] == 'spadmin' && $faulty['product']['branch']=='sylviapark')){?>
							<ul class="operation">
								<li><a href="<?php echo url('faulty', 'edit', array('id'=>$faulty['id'])); ?>" title="modifty">
									<img src="./images/edit.png" />
								</a></li>
								<li><a href="<?php echo url('faulty', 'del', array('id'=>$faulty['id'])); ?>" title="delete" onclick="return delConfirm();">
									<img src="./images/bin.png" />
								</a></li>
							</ul><?php }?>&nbsp;
						 </td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
		<div class="pageNav">		
			<?php if ($pageinfo['pageCount'] != 0): ?>
				<?php if ($pageinfo['currentPageNumber'] != 1): ?>
					<span><a href="<?php echo url("faulty", "index", array('page'=>$pageinfo['prevPage'])); ?>">&lt;&lt;</a></span>
				<?php endif ?>
				
				<span><?php echo "page " . $pageinfo['currentPageNumber'] . " of " . $pageinfo['pageCount']; ?></span>
				
				<?php if ($pageinfo['currentPageNumber'] != $pageinfo['pageCount']): ?>
					<span><a href="<?php echo url("faulty", "index", array('page'=>$pageinfo['nextPage'])); ?>">&gt;&gt;</a></span>
				<?php endif ?>
			<?php endif ?>	
		</div>
	</div>
	
	<div style="clear: both"></div>
</div>
<?php include(TPL_DIR.'footer.tpl.php'); ?>

<script type="text/javascript" charset="utf-8">
	function delConfirm() {
		return confirm("Do you confirm to delete this faulty record?");
	}
</script>