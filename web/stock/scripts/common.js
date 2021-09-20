$(document).ready(function() {
	$("tr:odd").css('background', '#eee');
	
	//brand form validation
	$("#brand_form").submit(function(){
		if($("#name").val() == "") {
			$("#brand_txt").html("brand name can not be empty");
			return false;
		}	
		return true;
	});
	
	//supplier form validation
	$("#supplier_form").submit(function(){
		var rs = true;
		
		if($("#supplier").val() == "") {
			$("#supplier_txt").html("supplier name can not be empty");
			rs = false;
		}
		
		var email = $("#email").val();	
		if(email != "") {
			var pattern = /^([a-zA-Z0-9._-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+/; 
			flag = pattern.test(email); 
			if(!flag) {
				$("#email_txt").html("invalid email address");
				rs = false;
			}
		}
		return rs;
	});
	
	//category form validation
	$("#category_form").submit(function(){
		if($("#name").val() == "") {
			$("#category_txt").html("category name can not be empty");
			return false;
		}	
		return true;
	});
	
	//product form validation
	$("#product_form").submit(function(){
		var rs =  true;
		
		if($("#category_id").val() == "") {
			$("#category_txt").html("please choose a category");
			rs = false;
		}	
		
		if($("#name").val() == "") {
			$("#product_txt").html("product name can not be empty");
			rs = false;
		}
		
		if($("#brand_id").val() == "") {
			$("#brand_txt").html("please choose a brand");
			rs = false;
		}
		
		if($("#model").val() == "") {
			$("#model_txt").html("model name can not be empty");
			rs = false;
		}
		
		var quantity = $("#quantity").val();
		if(quantity != "") {
			flag = isInteger(quantity);
			if(!flag) {
				$("#quantity_txt").html("quantity must be a integer number");
				rs = false;
			}
		}	
		
		return rs;
	});
	
	//stockin form validation
	$("#stockin_form").submit(function(){
		
		var rs = true;
		
		if($("#stock_date").val() == "") {
			$("#date_txt").html("date can not be empty");
			rs = false;
		}	
		
		if($("#supplier_id").val() == "") {
			$("#supplier_txt").html("please choose a supplier");
			rs = false;
		}
		
		if($("#user_id").val() == "") {
			$("#user_txt").html("please choose an operator");
			rs = false;
		}
		return rs;
	});
	
	//stock product form validation
	$("#stock_product_form").submit(function(){
		var rs = true;
		
		if($("#product_id").val() == "") {
			$("#product_txt").html("please choose a product");
			rs = false;
		}	
		
		var price = $("#price").val();
		if(price != "") {
			flag = isUnsignedNumeric(price);
			if(!flag) {
				$("#price_txt").html("invalid number");
				rs = false;
			}
		}	
		
		var quantity = $("#quantity").val();
		if(quantity != "") {
			flag = isInteger(quantity);
			if(!flag) {
				$("#quantity_txt").html("quantity must be a integer number");
				rs = false;
			}
		}	
		
		return rs;
	});
	
	
	$("#faulty_form").submit(function(){
		var rs = true;
		
		if($("#product_id").val() == "") {
			$("#product_txt").html("please choose a product");
			rs = false;
		}	
		
		var quantity = $("#quantity").val();
		if(quantity != "") {
			flag = isInteger(quantity);
			if(!flag) {
				$("#quantity_txt").html("quantity must be a integer number");
				rs = false;
			}
		} else {
			$("#quantity_txt").html("quantity can not be empty");
			rs = false;
		}
		
		if($("#supplier_id").val() == "") {
			$("#supplier_txt").html("please choose a supplier");
			rs = false;
		}	
		
		return rs;
		
	});
});

function isInteger(str) {
	var regu = /^[-]{0,1}[0-9]{1,}$/;
	return regu.test(str);
}

function isUnsignedNumeric(strNumber) {
	var  newPar = /^\d+(\.\d+)?$/;
	return  newPar.test(strNumber);  
}   