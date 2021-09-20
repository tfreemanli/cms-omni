<?php include(TPL_DIR.'header.tpl.php'); ?>
<div id="main">
	<div id="sidebar">
		<?php include(TPL_DIR.'sidebar.tpl.php'); ?>	
	</div>
	
	<div id="mainContent">
		<h3>Add New Faulty Record</h3>
		<?php if ($msg): ?>
			<span class="red"><?php echo $msg; ?></span>
		<?php endif ?>
		<form id="faulty_form" action="#" method="post" accept-charset="utf-8">
			<dl>
				<dt>Product Name  (<span class="red">*</span>)</dt>
				<dd><select name="product_id" id="product_id">
					<option value=""></option>
					<?php foreach ($products as $key => $name): ?>
						<option value="<?php echo $key; ?>"><?php echo $name; ?></option>
					<?php endforeach ?>			
					</select>
					<span id="product_txt" class="red"></span>
				</dd>
				
				<dt>Job Number</dt>
				<dd><input type="text" name="job_num" id="job_num" /></dd>
				
				
				<dt>Quantity (<span class="red">*</span>)</dt>
				<dd>
					<input type="text" name="quantity" id="quantity" size="5" value="1" />
					<span id="quantity_txt" class="red"></span>
				</dd>
				
				<dt>Supplier Name  (<span class="red">*</span>)</dt>
				<dd><select name="supplier_id" id="supplier_id">
					<option value=""></option>
					<?php foreach ($suppliers as $key => $name): ?>
						<option value="<?php echo $key; ?>"><?php echo $name; ?></option>
					<?php endforeach ?>			
					</select>
					<span id="supplier_txt" class="red"></span>
				</dd>
				
				<dt></dt>
				<dd>
					<input type="submit" name="submit" id="submit" value="Save" />
					<input type="button" name="cancel" value="Cancel" onclick="javascript:history.go(-1);" />
				</dd>
			</dl>			
		</form>
	</div>
	
	<div style="clear: both"></div>
</div>
<?php include(TPL_DIR.'footer.tpl.php'); ?>