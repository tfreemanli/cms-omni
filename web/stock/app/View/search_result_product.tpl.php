<table width="100%" border="0" cellspacing="1">
<tr>
	<th>Name</th>
	<th>Brand</th>
	<th>Model</th>
	<th>Branch</th>
	<th>Quantity</th>
	<th>Operation</th>
</tr>
<tbody>
	<?php foreach ($products as $product): ?>
		<tr>
			<td><?php echo $product['name']; ?></td>
			<td><?php echo $product['brand']['name']; ?></td>
			<td><?php echo $product['model']; ?></td>
			<td><?php echo $product['branch']; ?></td>
			<td><?php echo $product['quantity']; ?></td>
			<td>
				<ul class="operation">
					<li><a href="<?php echo url('product', 'edit', array('id'=>$product['id'])); ?>" title="modify">
						<img src="./images/edit.png" />
					</a></li>
					<li><a href="<?php echo url('product', 'del', array('id'=>$product['id'])); ?>" onclick="return delConfirm();" title="delete">
						<img src="./images/bin.png" />
					</a></li>
				</ul>
			 </td>
		</tr>
	<?php endforeach ?>
</tbody>
</table>

<script type="text/javascript" charset="utf-8">
	function delConfirm() {
		return confirm("Do you confirm to delete this Product?");
	}
</script>