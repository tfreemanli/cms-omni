<?php 
//
session_start();
if(isset($_GET['cJN'])){
	$cJN = $_GET['cJN'];
	if(!isset($_SESSION['JNs'])){
		$GLOBALS['JNs'] = "";
		session_register("JNs");
	}
	$str=$_SESSION['JNs'];
	//$array = explode(" ", $_SESSION['JNs']);
	//tell if param is in the array
	if($_GET['set']==1){
		//set it in
		$str = $str." ".$cJN;
	}else{
		//take it off
		$str = str_replace(" ".$cJN, "", $str);
	}
	$GLOBALS['JNs'] = $str;
	session_register("JNs");
}//end if $_GET[]
$iq = substr_count($str, " ");
?>
//alert("<?php echo $_SESSION['JNs'];?>");
var itemqty = MM_findObj("qty");
if(itemqty!=null){
	itemqty.innerHTML = <?php echo $iq;?>;
}