<?php include(TPL_DIR.'header.tpl.php'); ?>
<div id="main">
	<div id="sidebar">
		<?php include(TPL_DIR.'sidebar.tpl.php'); ?>	
	</div>
	
	<div id="mainContent">
		<h3>Add New Brand</h3>
		
		<form id="brand_form" action="#" method="post" accept-charset="utf-8">
			<dl>
				<dt></dt>
				<dd><input type="hidden" name="id" id="id" value="<?php echo $brand['id']; ?>" /></dd>
				
				<dt>Brand Name (<span class="red">*</span>)</dt>
				<dd>
					<input type="text" name="name" id="name" value="<?php echo $brand['name']; ?>" />
					<span id="brand_txt" class ="red"></span>
				</dd>
				
				<dt>Description</dt>
				<dd><textarea name="description" id="description" rows="5" cols="30"><?php echo $brand['description']; ?></textarea></dd>
				
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