<?php

	include 'model/int.php';

	if (TYPE == 1) {
		$_M = isset($_GET['mot'])?$_GET['mot']:'home';
		$_C = isset($_GET['ctl'])?$_GET['ctl']:'index';
		$_A = isset($_GET['act'])?$_GET['act']:'index';
	}

	$url = CONTROLLER.$_M.'/'.$_C.'.php';
	       // 'controller/admin/systems.php.php';

	if (file_exists($url)) {
		
		include $url;

	}else{
		return false;
	}
?>