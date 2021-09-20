<table width="100%" border="0" cellspacing="1">
<tr>
	<th>#ID</th>
	<th>Stock Date</th>
	<th>Supplier</th>
	<th>Operator</th>
	<th>Operation</th>
</tr>
<tbody>
	<?php foreach ($stock_list as $stock): ?>
		<tr>
			<td><?php echo $stock['id']; ?></td>
			<td><?php echo date('d-m-Y H:i', $stock['stock_date']); ?></td>
			<td><a href="<?php echo url('supplier', 'edit', array('id'=>$stock['supplier']['id'])); ?>"><?php echo $stock['supplier']['supplier']; ?></a></td>
			<td><?php echo $stock['operator']['cName']; ?></td>
			<td>
				<ul class="operation">
					<li><a href="<?php echo url('stockin', 'view', array('id'=>$stock['id'])); ?>" title="view">
						<img src="./images/list.png" />
					</a></li>
					<li><a href="<?php echo url('stockin', 'edit', array('id'=>$stock['id'])); ?>" title="modifty">
						<img src="./images/edit.png" />
					</a></li>
					<li><a href="<?php echo url('stockin', 'del', array('id'=>$stock['id'])); ?>" title="delete" onclick="return delConfirm();">
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
		return confirm("Do you confirm to delete this Stock in record?");
	}
</script>