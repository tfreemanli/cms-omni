<?php include(TPL_DIR.'header.tpl.php'); ?>
<div id="main">
		<div id="sidebar">
			<?php include(TPL_DIR.'sidebar.tpl.php'); ?>
		</div>
		
		<div id="mainContent">
			<form id="remark_form" action="#" method="post" accept-charset="utf-8">
				<h3>Remark Edit</h3>
				<dl>
					<dt></dt>
					<dd><input type="hidden" name="id" value="<?php echo $remark['id']; ?>" id="id"></dd>
					
					<dt></dt>
					<dd><input type="hidden" name="stockin_id" value="<?php echo $remark['stockin_id']; ?>" id="stockin_id"></dd>
					
					<dt>Content</dt>
					<dd><textarea name="content" rows="8" cols="40"><?php echo ereg_replace("<br>","\r\n",$remark['content']); ?></textarea></dd>
					
					<dt></dt>
					<dd>
						<input type="submit" name="submit" value="Submit" id="submit" />
						<input type="button" name="cancel" value="Cancel" id="cancel" onclick="javascript: history.go(-1);" />
					</dd>
				</dl>
			</form>
				
		</div>
		<div style="clear: both"></div>
</div>
<?php include(TPL_DIR.'footer.tpl.php'); ?>