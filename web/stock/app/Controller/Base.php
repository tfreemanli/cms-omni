<?php
class Controller_Base extends FLEA_Controller_Action {
	
	function Controller_Base() {
		if (!isset($_SESSION['uid']) || !isset($_SESSION['name'])) {
			redirect(url('index', 'index'));
		}
	}
}
?>