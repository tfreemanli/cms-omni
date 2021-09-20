<?php include(TPL_DIR.'header.tpl.php'); ?>
<div id="main">
	<div id="sidebar">
		<?php include(TPL_DIR.'sidebar.tpl.php'); ?>	
	</div>
	
	<div id="mainContent">
		<h3>Add New Caegory</h3>
		
		<form id="category_form" action="#" method="post" accept-charset="utf-8">
			<dl>
				<dt>Category Name (<span class="red">*</span>)</dt>
				<dd>
					<input type="text" name="name" id="name" />
					<span id="category_txt" class ="red"></span>
				</dd>
				
				<dt>Description</dt>
				<dd><textarea name="description" id="description" rows="5" cols="30"></textarea></dd>
				
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