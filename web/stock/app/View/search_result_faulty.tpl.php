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
			<ul class="operation">
				<li><a href="<?php echo url('faulty', 'edit', array('id'=>$faulty['id'])); ?>" title="modifty">
					<img src="./images/edit.png" />
				</a></li>
				<li><a href="<?php echo url('faulty', 'del', array('id'=>$faulty['id'])); ?>" title="delete" onclick="return delConfirm();">
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
		return confirm("Do you confirm to delete this faulty record?");
	}
</script>