<?php include(TPL_DIR.'header.tpl.php'); ?>
<div id="main">
		<div id="sidebar">
			<?php include(TPL_DIR.'sidebar.tpl.php'); ?>
		</div>
		
		<div id="mainContent">
			<h3>Add a New Product</h3>
			
			<form id="product_form" action="#" method="post" accept-charset="utf-8">
				<dl>
					<dt>Category (<span class="red">*</span>)</dt>
					<dd>
						<select name="category_id" id="category_id">
							<option value=""></option>
							<?php foreach ($categoryAry as $key => $category): ?>
								<option value="<?php echo $key; ?>"><?php echo $category; ?></option>
							<?php endforeach ?>			
						</select>
						<input type="button" name="add_category" value="Add New Category" id="add_category" onclick="javascript: window.location.href='<?php echo url('category', 'add'); ?>'" />
						<span id="category_txt" class="red"></span>					</dd>
					
					<dt>Product Name (<span class="red">*</span>)</dt>
					<dd>
						<input type="text" name="name" id="name" />
						<span id="product_txt" class="red"></span>					</dd>
					
					<dt>Brand (<span class="red">*</span>)</dt>
					<dd>
						<select name="brand_id" id="brand_id">
						<option value=""></option>
						<?php foreach ($brandAry as $key => $brand): ?>
							<option value="<?php echo $key; ?>"><?php echo $brand; ?></option>
						<?php endforeach ?>			
						</select>
						<span id="brand_txt" class="red"></span>					</dd>
					
					<dt>Model (<span class="red">*</span>)</dt>
					<dd>
						<input type="text" name="model" id="model" />
						<span id="model_txt" class="red"></span>					</dd>
					
					<dt>Description</dt>
					<dd><textarea name="description" id="description" rows="5" cols="30"></textarea></dd>
					
					<dt>Quantity</dt>
					<dd>
						<input type="text" name="quantity" id="quantity" size="5" />
						<span id="quantity_txt" class="red"></span>					</dd>
					<?php if($_SESSION['role'] == 'admin'){?>
					<dt>RRP</dt>
					<dd>
                      <input type="text" name="rrp" id="rrp" size="32" />
                      <span id="quantity_txt" class="red"></span></dd>
					  <?php }else{?>
					  <input type="hidden" name="rrp" id="rrp" size="32" />
					  <?php }?>
					<dt>Branch</dt>
						<?php if($_SESSION['role'] == 'admin'){?>
							<dd>
                            	<select name="branch" id="branch">
                                    <option value="all">Both</option>
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