<?php include(TPL_DIR.'header.tpl.php'); ?>
<div id="main">
		<div id="sidebar">
			<?php include(TPL_DIR.'sidebar.tpl.php'); ?>
		</div>
		
		<div id="mainContent">
			<h3>Add Product for Stock</h3>
			
			<form id="stock_product_form" action="#" method="post" accept-charset="utf-8">
				<dl>
					<dt></dt>
					<dd><input type="hidden" name="id" value="<?php echo $stockinProduct['id']; ?>" id="id" /></dd>
					
					<dt>Stock #ID</dt>
					<dd><input type="text" name="stockin_id" id="stockin_id" value="<?php echo $stockinProduct['stockin_id']; ?>" size="5" readonly /></dd>
					
					<dt>Product (<span class="red">*</span>)</dt>
					<dd><select name="product_id" id="product_id">
						<option value=""></option>
						<?php foreach ($productAry as $key => $product): ?>
							<?php if ($key == $stockinProduct['product_id']): ?>
								<option value="<?php echo $key; ?>" selected><?php echo $product; ?></option>
							<?php else: ?>
								<option value="<?php echo $key; ?>"><?php echo $product; ?></option>
							<?php endif ?>	
						<?php endforeach ?>		
					</select>
						<span id="product_txt" class="red"></span>
				</dd>
					
					<dt>Price (<span class="red">*</span>)</dt>
					<dd>
						<input type="text" name="price" id="price" value="<?php echo $stockinProduct['price']; ?>" />
						<span id="price_txt" class="red"></span>
					</dd>
					
					<dt>Quantity (<span class="red">*</span>)</dt>
					<dd>
						<input type="text" name="quantity" id="quantity" value="<?php echo $stockinProduct['quantity']; ?>" />
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