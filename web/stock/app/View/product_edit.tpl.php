<?php include(TPL_DIR.'header.tpl.php'); ?>
<div id="main">
		<div id="sidebar">
			<?php include(TPL_DIR.'sidebar.tpl.php'); ?>
		</div>
		
		<div id="mainContent">
			<h3>Update Product</h3>
			
			<form id="product_form" action="#" method="post" accept-charset="utf-8">
				<dl>
					<dt></dt>
					<dd><input type="hidden" name="id" value="<?php echo $product['id']; ?>" id="id"></dd>
					
					<dt>Category (<span class="red">*</span>)</dt>
					<dd><select name="category_id" id="category_id">
						<option value=""></option>
						<?php foreach ($categoryAry as $key => $category): ?>
							<?php if ($product['category_id'] == $key): ?>
								<option value="<?php echo $key; ?>" selected><?php echo $category; ?></option>
							<?php else: ?>
								<option value="<?php echo $key; ?>"><?php echo $category; ?></option>
							<?php endif ?>
						<?php endforeach ?>			
					</select>
					<span id="category_txt" class="red"></span>				</dd>
					
					<dt>Product Name (<span class="red">*</span>)</dt>
					<dd>
						<input type="text" name="name" id="name" value="<?php echo $product['name']; ?>" />
						<span id="product_txt" class="red"></span>					</dd>
					
					<dt>Brand (<span class="red">*</span>)</dt>
					<dd><select name="brand_id" id="brand_id">
						<option value=""></option>
						<?php foreach ($brandAry as $key => $brand): ?>
							<?php if ($product['brand_id'] == $key): ?>
								<option value="<?php echo $key; ?>" selected><?php echo $brand; ?></option>
							<?php else: ?>
								<option value="<?php echo $key; ?>"><?php echo $brand; ?></option>
							<?php endif ?>					
						<?php endforeach ?>			
					</select>
					<span id="brand_txt" class="red"></span>				</dd>
					
					<dt>Model (<span class="red">*</span>)</dt>
					<dd>
						<input type="text" name="model" id="model" value="<?php echo $product['model']; ?>" />
						<span id="model_txt" class="red"></span>					</dd>
					
					<dt>Description</dt>
					<dd><textarea name="description" id="description" rows="5" cols="30"><?php echo $product['description']; ?></textarea></dd>
					
					<dt>Quantity</dt>
					<dd>
						<?php if ($_SESSION['role'] == 'admin'): ?>
							<input type="text" name="quantity" id="quantity" size="5" value="<?php echo $product['quantity']; ?>" />
						<?php else: ?>
							<input type="text" name="quantity" id="quantity" size="5" value="<?php echo $product['quantity']; ?>" readonly />
						<?php endif ?>
						<span id="quantity_txt" class="red"></span>					</dd>
					<?php if($_SESSION['role'] == 'admin'){?>
					<dt>RRP</dt>
					<dd>
                      <input name="rrp" type="text" id="rrp" size="32" value="<?php echo $product['rrp']; ?>" />
                      <span id="quantity_txt" class="red"></span></dd>
					  <?php }else{?>
					  <input type="hidden" name="rrp" id="rrp" size="32" value="<?php echo $product['rrp']; ?>" />
					  <?php }?>
					<dt>Branch</dt>
						<?php if($_SESSION['role'] == 'admin'){?>
							<dd>
                            	<select name="branch" id="branch">
                                    <option value="henderson" <?php echo ($product['branch']=='henderson')?'selected':'';?>>Henderson</option>
                                    <option value="sylviapark" <?php echo ($product['branch']=='sylviapark')?'selected':'';?>>Sylvia Park</option>			
                                </select>
                            </dd>
                        <?php }else{?>
							<dd>
                            	<select name="branch" id="branch">
                                    <option value="sylviapark" <?php echo ($product['branch']=='sylviapark')?'selected':'';?>>Sylvia Park</option>			
                                </select>
                            </dd>
                        <?php }?>
					<dt>Modify Other Similar Products(It will NOT change product's Quantity and Branch)</dt>
                    
                    <table width="100%" border="0" cellspacing="1">
<tr>
	<th>&nbsp;</th>
	<th>Name</th>
	<th>Brand</th>
	<th>Model</th>
	<th>Branch</th>
	<th>Quantity</th>
	<th>RRP</th>
</tr>
<tbody>
	<?php foreach ($otherSimProducts as $pd): ?>
		<tr>
			<td>&nbsp;
			<?php if($pd['id'] != $product['id']){?>
            <input name="otherid[]" type="checkbox" value="<?php echo $pd['id']; ?>" checked="checked" /><?php }?>
            </td>
			<td><?php echo $pd['name']; ?></td>
			<td><?php echo $pd['brand']['name']; ?></td>
			<td><?php echo $pd['model']; ?></td>
			<td><?php echo $pd['branch']; ?></td>
			<td><?php echo $pd['quantity']; ?></td>
			<td><?php echo $pd['rrp']; ?></td>
		</tr>
	<?php endforeach ?>
</tbody>
</table>
                    
                    
                    
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