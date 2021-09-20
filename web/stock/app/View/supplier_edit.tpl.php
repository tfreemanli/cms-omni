<?php include(TPL_DIR.'header.tpl.php'); ?>
<div id="main">
		<div id="sidebar">
			<?php include(TPL_DIR.'sidebar.tpl.php'); ?>
		</div>
		
		<div id="mainContent">
			<h3>Add a New Supplier</h3>
			
			<form id="supplier_form" action="#" method="post" accept-charset="utf-8">
				<dl>
					<dt></dt>
					<dd><input type="hidden" name="id" id="id" value="<?php echo $supplier['id']; ?>" /></dd>
					
					<dt>Supplier Name (<span class="red">*</span>)</dt>
					<dd>
						<input type="text" name="supplier" id="supplier" value="<?php echo $supplier['supplier']; ?>" />
						<span id="supplier_txt" class ="red"></span>
					</dd>
					
					<dt>Contact Person</dt>
					<dd><input type="text" name="contact" id="contact" value="<?php echo $supplier['contact']; ?>" /></dd>
					
					<dt>Contact Phone</dt>
					<dd><input type="text" name="phone" id="phone" value="<?php echo $supplier['phone']; ?>" /></dd>
					
					<dt>Email Address</dt>
					<dd>
						<input type="text" name="email" id="email" value="<?php echo $supplier['email']; ?>" />
						<span id="email_txt" class ="red"></span>
					</dd>
					
					<dt>Physical Address</dt>
					<dd><input type="text" name="address" id="address" size="50" value="<?php echo $supplier['address']; ?>" /></dd>
					
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