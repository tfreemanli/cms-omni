<?php include(TPL_DIR.'header.tpl.php'); ?>
<div id="main">
		<div id="sidebar">
			<?php include(TPL_DIR.'sidebar.tpl.php'); ?>
		</div>
		
		<div id="mainContent">
			<h3>Add a New Supplier</h3>
			
			<form id="supplier_form" action="#" method="post" accept-charset="utf-8">
				<dl>
					<dt>Supplier Name (<span class="red">*</span>)</dt>
					<dd>
						<input type="text" name="supplier" id="supplier" />
						<span id="supplier_txt" class ="red"></span>
					</dd>
					
					<dt>Contact Person</dt>
					<dd><input type="text" name="contact" id="contact" /></dd>
					
					<dt>Contact Phone</dt>
					<dd><input type="text" name="phone" id="phone" /></dd>
					
					<dt>Email Address</dt>
					<dd>
						<input type="text" name="email" id="email" />
						<span id="email_txt" class ="red"></span>
					</dd>
					
					<dt>Physical Address</dt>
					<dd><input type="text" name="address" id="address" size="50" /></dd>
					
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