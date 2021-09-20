<?php include(TPL_DIR.'header.tpl.php'); ?>
<div id="main">
		<div id="sidebar">
			<?php include(TPL_DIR.'sidebar.tpl.php'); ?>
		</div>
		
		<div id="mainContent">
			<h3>Add Product for Stock</h3>
			
			<form id="stock_product_form" action="#" method="post" accept-charset="utf-8">
				<dl>
					<dt>Stock #ID</dt>
					<dd><input type="text" name="stockin_id" id="stockin_id" value="<?php echo $stockin_id; ?>" size="5" readonly /></dd>
					
					<dt>Product (<span class="red">*</span>)</dt>
					<dd><select name="product_id" id="product_id">
						<option value=""></option>
						<?php foreach ($productAry as $key => $product): ?>
							<option value="<?php echo $key; ?>"><?php echo $product; ?></option>
						<?php endforeach ?>
					</select>
					<span id="product_txt" class="red"></span>
				</dd>
					
					<dt>Price (<span class="red">*</span>)</dt>
					<dd>
						<input type="text" name="price" id="price" value="0.00" />
						<span id="price_txt" class="red"></span>
					</dd>
					
					<dt>Quantity (<span class="red">*</span>)</dt>
					<dd>
						<input type="text" name="quantity" id="quantity" value="0" />
						<span id="quantity_txt" class="red"></span>
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