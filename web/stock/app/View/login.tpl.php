<?php include(TPL_DIR.'header.tpl.php'); ?>
<div id="main">
	<form id="login" action="#" method="post" >
		<dl>
			<dt>Login Name</dt>
			<dd><input type="text" name="login" /></dd>
			<dt>Password</dt>
			<dd><input type="password" name="password" /></dd>
			
			<dd><input type="submit" name="submit" value="Login" /></dd>
		</dl>
		 <span class="err_msg"><?php echo $msg; ?></span>
	</form>
</div>
<?php include(TPL_DIR.'footer.tpl.php'); ?>

