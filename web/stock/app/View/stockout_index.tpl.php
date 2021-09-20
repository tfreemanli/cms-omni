<?php include(TPL_DIR.'header.tpl.php'); ?>
<div id="main">
		<div id="sidebar">
			<?php include(TPL_DIR.'sidebar.tpl.php'); ?>
		</div>
		
		<div id="mainContent">
			<h3>Stock Out List</h3>
			<table width="100%" border="0" cellspacing="1">
			<tr>
				<th>#ID</th>
				<th>Product</th>
				<th>Job Number</th>
				<th>Quantity</th>
				<th>Operator</th>
				<th>Date</th>
			</tr>
			<tbody>
				<?php foreach ($stockout_list as $stockout): ?>
					<tr>
						<td><?php echo $stockout['id']; ?></td>
						<td><?php echo $stockout['product']['name']; ?></td>
						<td><?php echo $stockout['job_num']; ?></td>
						<td><?php echo $stockout['quantity']; ?></td>
						<td><?php echo $stockout['operator']['cName']; ?></td>
						<td><?php echo date('d-m-Y H:i', $stockout['stockout_date']); ?></td>
					</tr>
				<?php endforeach ?>
			</tbody>
			</table>
			
			<div class="pageNav">		
				<?php if ($pageinfo['pageCount'] != 0): ?>
					<?php if ($pageinfo['currentPageNumber'] != 1): ?>
						<span><a href="<?php echo url("stockout", "index", array('page'=>$pageinfo['prevPage'])); ?>">&lt;&lt;</a></span>
					<?php endif ?>
					
					<span><?php echo "page " . $pageinfo['currentPageNumber'] . " of " . $pageinfo['pageCount']; ?></span>
					
					<?php if ($pageinfo['currentPageNumber'] != $pageinfo['pageCount']): ?>
						<span><a href="<?php echo url("stockout", "index", array('page'=>$pageinfo['nextPage'])); ?>">&gt;&gt;</a></span>
					<?php endif ?>
				<?php endif ?>	
			</div>
		</div>
		
		<div style="clear: both"></div>
</div>
<?php include(TPL_DIR.'footer.tpl.php'); ?>