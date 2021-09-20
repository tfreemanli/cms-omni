<?php
if(isset($_GET['wai']) && $_GET['wai']!=''){
	
    session_register("RP_WHOAMI");
    $GLOBALS['RP_WHOAMI'] = $_GET['wai'];
    session_register("RP_WHOAMI");
}
?>
//alert("WHO-I-AM is set to " + <?php echo $_SESSION['RP_WHOAMI'];?>);