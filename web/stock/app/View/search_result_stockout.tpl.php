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