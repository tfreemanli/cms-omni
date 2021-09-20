<?php include(TPL_DIR.'header.tpl.php'); ?>
<div id="main">
		<div id="sidebar">
			<?php include(TPL_DIR.'sidebar.tpl.php'); ?>
		</div>
		
		<div id="mainContent">
			<a class="right" href="<?php echo url('stockin', 'add'); ?>" title="add new stock in record">
				<img src="./images/add.png" />
			</a>
			<h3>Stock In List</h3>
			<table width="100%" border="0" cellspacing="1">
			<tr>
				<th width="8%">#ID</th>
				<th width="24%">Stock Date</th>
				<th width="20%">Supplier</th>
				<th width="20%">Operator</th>
				<th width="9%">Branch</th>
				<th width="19%">Operation</th>
			</tr>
			<tbody>
				<?php foreach ($stock_list as $stock): ?>
					<tr>
						<td><?php echo $stock['id']; ?></td>
						<td><?php echo date('d-m-Y H:i', $stock['stock_date']); ?></td>
						<td><a href="<?php echo url('supplier', 'edit', array('id'=>$stock['supplier']['id'])); ?>"><?php echo $stock['supplier']['supplier']; ?></a></td>
						<td><?php echo $stock['operator']['cName']; ?></td>
						<td><?php echo $stock['branch']; ?>&nbsp;</td>
						<td>
							<ul class="operation">
								<li><a href="<?php echo url('stockin', 'view', array('id'=>$stock['id'])); ?>" title="view">
									<img src="./images/list.png" />
								</a></li>
                        <?php if($_SESSION['role'] == 'admin' || ($_SESSION['role'] == 'spadmin' && $stock['branch']=='sylviapark')){?>
								<li><a href="<?php echo url('stockin', 'edit', array('id'=>$stock['id'])); ?>" title="modifty">
									<img src="./images/edit.png" />
								</a></li>
								<li><a href="<?php echo url('stockin', 'del', array('id'=>$stock['id'])); ?>" title="delete" onclick="return delConfirm();">
									<img src="./images/bin.png" />
								</a></li>
                            <?php }?>
							</ul>
						 </td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
		
		<div class="pageNav">		
			<?php if ($pageinfo['pageCount'] != 0): ?>
				<?php if ($pageinfo['currentPageNumber'] != 1): ?>
					<span><a href="<?php echo url("stockin", "index", array('page'=>$pageinfo['prevPage'])); ?>">&lt;&lt;</a></span>
				<?php endif ?>
				
				<span><?php echo "page " . $pageinfo['currentPageNumber'] . " of " . $pageinfo['pageCount']; ?></span>
				
				<?php if ($pageinfo['currentPageNumber'] != $pageinfo['pageCount']): ?>
					<span><a href="<?php echo url("stockin", "index", array('page'=>$pageinfo['nextPage'])); ?>">&gt;&gt;</a></span>
				<?php endif ?>
			<?php endif ?>	
		</div>
		</div>
		
		<div style="clear: both"></div>
</div>
<?php include(TPL_DIR.'footer.tpl.php'); ?>
<script type="text/javascript" charset="utf-8">
	function delConfirm() {
		return confirm("Do you confirm to delete this Stock in record?");
	}
</script>