<?php include(TPL_DIR.'header.tpl.php'); ?>
<div id="main">
	<div id="sidebar">
		<?php include(TPL_DIR.'sidebar.tpl.php'); ?>	
	</div>
	
	<div id="mainContent">
		<a class="right" href="<?php echo url('product', 'add'); ?>" title="Add new product">
			<img src="./images/add.png" />
		</a>
		<h3>Product List</h3>
		
		<select name="category" id="category" onchange="doSelect(this)">
			<option value="">ALL</option>
			<?php foreach ($categoryAry as $key => $category): ?>
				<?php if ($cid == $key): ?>
					<option value="<?php echo $key; ?>" selected><?php echo $category; ?></option>
				<?php else: ?>
					<option value="<?php echo $key; ?>"><?php echo $category; ?></option>
				<?php endif ?>		
			<?php endforeach ?>	
		</select>
		
		<div class="pageNav">		
			<?php if ($pageinfo['pageCount'] != 0): ?>
				<?php if ($pageinfo['currentPageNumber'] != 1): ?>
					<span><a href="<?php echo url("product", "index", array('cid'=>$cid, 'page'=>$pageinfo['prevPage'])); ?>">&lt;&lt;</a></span>
				<?php endif ?>
				
				<span><?php echo "page " . $pageinfo['currentPageNumber'] . " of " . $pageinfo['pageCount']; ?></span>
				
				<select id="pageSelection" name="pageSelection" onchange="pageSelect(this)">
        <?php for($i = 1; $i<= $pageinfo['pageCount']; $i++): ?>
          <?php if($i == $pageinfo['currentPageNumber']): ?>
            <option value="<?php echo $i - 1; ?>" selected><?php echo $i; ?></option>
          <?php else: ?>
            <option value="<?php echo $i - 1; ?>"><?php echo $i; ?></option>
          <?php endif; ?>
        <?php endfor; ?>
				</select>
				
				<?php if ($pageinfo['currentPageNumber'] != $pageinfo['pageCount']): ?>
					<span><a href="<?php echo url("product", "index", array('cid'=>$cid, 'page'=>$pageinfo['nextPage'])); ?>">&gt;&gt;</a></span>
				<?php endif ?>
			<?php endif ?>	
		</div>
		
		<table width="100%" border="0" cellspacing="1">
			<tr>
				<th width="19%">Name</th>
				<th width="4%">Brand</th>
				<th width="19%">Model</th>
				<th width="15%">Quantity</th>
				<th width="10%">RRP</th>
				<?php if ($_SESSION['role'] == 'admin'): ?>
					<th width="12%">StockInPrice</th>
				<?php endif ?>
					<th width="10%">Branch</th>
				<th width="11%">Operation</th>
			</tr>
			<tbody>
				<?php foreach ($products as $product): ?>
					<tr>
						<td style="color:<?php echo ($product['branch']=='henderson')?'#06F':'#F60'?>"><?php echo $product['name']; ?></td>
						<td><?php echo $product['brand']['name']; ?></td>
						<td><?php echo $product['model']; ?></td>
						<td><?php echo $product['quantity']; ?></td>
						<td><?php echo $product['rrp']; ?>&nbsp;</td>
						<?php if ($_SESSION['role'] == 'admin'): ?>
							<td><?php echo $product['stockinprice']; ?>&nbsp;</td>
						<?php endif ?>
							<td><?php echo $product['branch']; ?>&nbsp;</td>
						<td>
                        <?php if($_SESSION['role'] == 'admin' || ($_SESSION['role'] == 'spadmin' && $product['branch']=='sylviapark')){?>
							<a href="<?php echo url('product', 'edit', array('id'=>$product['id'])); ?>" title="modify">
								<img src="./images/edit.png" width="20" height="20" /></a>
                                <a href="<?php echo url('product', 'del', array('id'=>$product['id'])); ?>" onclick="return delConfirm();" title="delete">
								<img src="./images/bin.png" width="20" height="20" />
                               <?php }?>&nbsp;</a>
					  </td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
		<div class="pageNav">		
			<?php if ($pageinfo['pageCount'] != 0): ?>
				<?php if ($pageinfo['currentPageNumber'] != 1): ?>
					<span><a href="<?php echo url("product", "index", array('cid'=>$cid, 'page'=>$pageinfo['prevPage'])); ?>">&lt;&lt;</a></span>
				<?php endif ?>
				
				<span><?php echo "page " . $pageinfo['currentPageNumber'] . " of " . $pageinfo['pageCount']; ?></span>
				
				<select id="pageSelection" name="pageSelection" onchange="pageSelect(this)">
        <?php for($i = 1; $i<= $pageinfo['pageCount']; $i++): ?>
          <?php if($i == $pageinfo['currentPageNumber']): ?>
            <option value="<?php echo $i - 1; ?>" selected><?php echo $i; ?></option>
          <?php else: ?>
            <option value="<?php echo $i - 1; ?>"><?php echo $i; ?></option>
          <?php endif; ?>
        <?php endfor; ?>
				</select>
				
				<?php if ($pageinfo['currentPageNumber'] != $pageinfo['pageCount']): ?>
					<span><a href="<?php echo url("product", "index", array('cid'=>$cid, 'page'=>$pageinfo['nextPage'])); ?>">&gt;&gt;</a></span>
				<?php endif ?>
			<?php endif ?>	
		</div>
	</div>
	
	<div style="clear: both"></div>
</div>
<?php include(TPL_DIR.'footer.tpl.php'); ?>

<script type="text/javascript" charset="utf-8">
	function delConfirm() {
		return confirm("Do you confirm to delete this Product?");
	}
	
	function doSelect(obj) {
		var category = obj.value;
		window.location.href = "<?php echo url('product', 'index'); ?>&cid=" + category;
	}
	
	function pageSelect(obj) {
    var page = obj.value;
    var category = document.getElementById('category').value;
    window.location.href = "<?php echo url('product', 'index'); ?>&cid=" + category + "&page=" + page;
	
	}
</script>