<?php include(TPL_DIR.'header.tpl.php'); ?>
<div id="main">
		<div id="sidebar">
			<?php include(TPL_DIR.'sidebar.tpl.php'); ?>
		</div>
		
		<div id="mainContent">
			<h3>Add New Stock In List</h3>
			
			<form id="stockin_form" action="#" method="post" accept-charset="utf-8">
			<dl>
				<dt>Stock In Date (<span class="red">*</span>)</dt>
				<dd>
					<input type="text" name="stock_date" id="stock_date" readonly />
					<img id="date_btn" src="./images/calendar.png" />
					<span id="date_txt" class="red"></span>
				</dd>
				
				<dt>Supplier (<span class="red">*</span>)</dt>
				<dd><select name="supplier_id" id="supplier_id">
					<option value=""></option>
					<?php foreach ($supplierAry as $key => $supplier): ?>
						<option value="<?php echo $key; ?>"><?php echo $supplier; ?></option>
					<?php endforeach ?>	
				</select>
				<span id="supplier_txt" class="red"></span>
			</dd>
				
				<dt>Operator (<span class="red">*</span>)</dt>
				<dd><select name="user_id" id="user_id">
					<option value=""></option>
					<?php foreach ($userAry as $key => $user): ?>
						<option value="<?php echo $key; ?>"><?php echo $user; ?></option>
					<?php endforeach ?>	
				</select>
				<span id="user_txt" class="red"></span>
			</dd>
					<dt>Branch</dt>
						<?php if($_SESSION['role'] == 'admin'){?>
							<dd>
                            	<select name="branch" id="branch">
                                    <option value="henderson">Henderson</option>
                                    <option value="sylviapark">Sylvia Park</option>			
                                </select>
                            </dd>
                        <?php }else{?>
							<dd>
                            	<select name="branch" id="branch">
                                    <option value="sylviapark">Sylvia Park</option>			
                                </select>
                            </dd>
                        <?php }?>
				
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

<script type="text/javascript" charset="utf-8">
	Calendar.setup({
		inputField: "stock_date",
		ifFormat: "%d-%m-%Y %H:%M",
		button: "date_btn",
		showsTime: true,
		timeFormat: "24"
	});
</script>