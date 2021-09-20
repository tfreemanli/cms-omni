<?php include(TPL_DIR.'header.tpl.php'); ?>
<div id="main">
		<div id="sidebar">
			<?php include(TPL_DIR.'sidebar.tpl.php'); ?>
		</div>
		
		<div id="mainContent">
			<h3>Dash Board</h3>
			<table border="0" cellspacing="1" cellpadding="5" width="50%">	
				<tr>
					<td>Suppliers</td>
					<td><?php echo $supplier; ?></td>
				</tr>	
				<tr>
					<td>Categories</td>
					<td><?php echo $category; ?></td>
				</tr>
				<tr>
					<td>Brands</td>
					<td><?php echo $brand; ?></td>
				</tr>
				<tr>
					<td>Products</td>
					<td><?php echo $product; ?></td>
				</tr>
				<tr>
					<td>Stockin Records</td>
					<td><?php echo $stockin; ?></td>
				</tr>	
				<tr>
					<td>Faulty Records</td>
					<td><?php echo $faulty; ?></td>
				</tr>
			</table>
		</div>
		
		<div style="clear: both"></div>
</div>
<?php include(TPL_DIR.'footer.tpl.php'); ?>