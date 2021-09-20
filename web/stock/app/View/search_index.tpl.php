<?php include(TPL_DIR.'header.tpl.php'); ?>
<div id="main">
	<div id="sidebar">
		<?php include(TPL_DIR.'sidebar.tpl.php'); ?>	
	</div>
	
	<div id="mainContent">
		<h3>Search</h3>
		<div id="search-container">
            <ul>
                <li><a href="#fragment-1"><span>Products</span></a></li>
                <li><a href="#fragment-2"><span>Stock in</span></a></li>
                <li><a href="#fragment-3"><span>Stock out</span></a></li>
                <li><a href="#fragment-4"><span>Faulty</span></a></li>
            </ul>
            <div id="fragment-1">
            	<form action="#" method="post" accept-charset="utf-8">
            		<table border="0" class="tb-noborder">
            			<tr>
            				<td>Category: </td>
            				<td>
            					<select name="category_id" id="category_id">
			            			<option value="">any</option>
			            			<?php foreach ($categories as $key => $value): ?>
			            				<option value="<?php echo $key; ?>"><?php echo $value; ?></option>	
			            			<?php endforeach ?>		
			            		</select>
            				</td>
            				<td>Brand: </td>
            				<td>
            					<select name="brand_id" id="brand_id">
			            			<option value="">any</option>
			            			<?php foreach ($brands as $key => $value): ?>
			            				<option value="<?php echo $key; ?>"><?php echo $value; ?></option>	
			            			<?php endforeach ?>	
			            		</select>
            				</td>
        				</tr>
        				<tr>
            				<td>Model: </td>
            				<td><input type="text" name="model" value="" id="model"></td>
            				<td>Product Name: </td>
            				<td><input type="text" name="product" value="" id="product"></td>
        				</tr>
        				<tr>
        				  <td>Branch:</td>
        				  <td>
            					<select name="branch" id="branch">
			            			<option value="">any</option>
			            				<option value="henderson">Henderson</option>	
			            				<option value="sylviapark">Sylvia Park</option>	
			            		</select>
                             </td>
        				  <td>&nbsp;</td>
        				  <td>&nbsp;</td>
      				  </tr>
        				<tr>
        					<td colspan="4"><input type="submit" name="product_submit" value="Search" id="product_submit"></td>	
        				</tr>
            		</table>            	
            	</form>        	
            </div>
            
            <div id="fragment-2">
              <form action="#" method="post" accept-charset="utf-8">
            		<table border="0" class="tb-noborder">
        				<tr>
            				<td>Stock in Date From:</td>
            				<td><input type="text" name="stockin_date_from" value="" id="stockin_date_from" /></td>
            				<td>Stock in Date To:</td>
            				<td><input type="text" name="stockin_date_to" value="" id="stockin_date_to" /></td>
        				</tr>
        				<tr>
        					<td colspan="4"><input type="submit" name="stockin_submit" value="Search" id="stockin_submit"></td>	
        				</tr>
            		</table>            	
            	</form> 
            </div>
            
            <div id="fragment-3">
              <form action="#" method="post" accept-charset="utf-8">
            		<table border="0" class="tb-noborder">
        				<tr>
        					<td>Product Name:</td>
        					<td><input type="text" name="product" value="" id="product" /></td>
        					<td>Job Number:</td>
        					<td><input type="text" name="job_num" value="" id="job_num"></td>
        				</tr>
            			<tr>
            				<td>Stock out Date From:</td>
            				<td><input type="text" name="stockout_date_from" value="" id="stockout_date_from" /></td>
            				<td>Stock out Date To:</td>
            				<td><input type="text" name="stockout_date_to" value="" id="stockout_date_to" /></td>
        				</tr>
        				<tr>
        					<td colspan="4"><input type="submit" name="stockout_submit" value="Search" id="stockout_submit"></td>	
        				</tr>
            		</table>            	
            	</form> 
            </div>
            
            <div id="fragment-4">
               <form action="#" method="post" accept-charset="utf-8">
            		<table border="0" class="tb-noborder">
        				<tr>
        					<td>Product Name</td>
        					<td><input type="text" name="product" value="" id="product"></td>
        					<td>Job Number</td>
        					<td><input type="text" name="job_num" value="" id="job_num"></td>
            			</tr>
            			<tr>
            				<td>Faulty Date From:</td>
            				<td><input type="text" name="faulty_date_from" value="" id="faulty_date_from" /></td>
            				<td>Faulty Date To:</td>
            				<td><input type="text" name="faulty_date_to" value="" id="faulty_date_to" /></td>
        				</tr>
        				<tr>
        					<td colspan="4"><input type="submit" name="faulty_submit" value="Search" id="faulty_submit"></td>	
        				</tr>
            		</table>            	
            	</form> 
            </div>
        </div>
        
        <div id="result_block">
        	<?php if (isset($products)): ?>
        		<h4>Result: products</h4>
        		<?php include(TPL_DIR.'search_result_product.tpl.php'); ?>
        	<?php endif ?>
        	
        	<?php if (isset($stock_list)): ?>
        		<h4>Result: stock in</h4>
        		<?php include(TPL_DIR.'search_result_stockin.tpl.php'); ?>
        	<?php endif ?>
        	
        	<?php if (isset($stockout_list)): ?>
        		<h4>Result: stock out</h4>
        		<?php include(TPL_DIR.'search_result_stockout.tpl.php'); ?>
        	<?php endif ?>
        	
        	<?php if (isset($faulties)): ?>
        		<h4>Result: Faulty</h4>
        		<?php include(TPL_DIR.'search_result_faulty.tpl.php'); ?>
        	<?php endif ?>
        	
        </div>
	</div>
	<div style="clear: both"></div>
	
</div>
<?php include(TPL_DIR.'footer.tpl.php'); ?>

<script type="text/javascript" charset="utf-8">
	$("#search-container").tabs();

	Calendar.setup({
		inputField: "stockin_date_from",
		ifFormat: "%d-%m-%Y",
		button: "stockin_date_from",
		showsTime: false
	});
	
	Calendar.setup({
		inputField: "stockin_date_to",
		ifFormat: "%d-%m-%Y",
		button: "stockin_date_to",
		showsTime: false
	});
	
	Calendar.setup({
		inputField: "stockout_date_from",
		ifFormat: "%d-%m-%Y",
		button: "stockout_date_from",
		showsTime: false
	});
	
	Calendar.setup({
		inputField: "stockout_date_to",
		ifFormat: "%d-%m-%Y",
		button: "stockout_date_to",
		showsTime: false
	});
	
	Calendar.setup({
		inputField: "faulty_date_from",
		ifFormat: "%d-%m-%Y",
		button: "faulty_date_from",
		showsTime: false
	});
	
	Calendar.setup({
		inputField: "faulty_date_to",
		ifFormat: "%d-%m-%Y",
		button: "faulty_date_to",
		showsTime: false
	});
	
</script>