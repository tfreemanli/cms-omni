<?php
define('DEPLOY_MODE', true); 

define('ROOT_PATH', dirname(__FILE__));
define('TPL_DIR', ROOT_PATH . '/app/View/');

require (ROOT_PATH.'/libs/FLEA/FLEA.php');

$setting = ROOT_PATH.'/app/config/setting.php';

FLEA::import(ROOT_PATH.'/app');
FLEA::loadAppInf($setting);

FLEA::runMVC();
?>