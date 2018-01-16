<?php

	function code(){
		$image = imagecreatetruecolor(120,40);
		$bgcolor = imagecolorallocate($image, 200, 200, 200);
		imagefill($image, 0, 0, $bgcolor);
		$captch_code="";

		for ($i=0; $i < 4; $i++) { 
			$fontsize = 6;
			$fontcolor = imagecolorallocate($image,rand(0,120),rand(0,120),rand(0,120));
			$data='qwertyuiopasdfghjklzxcvbnm1234567890';
			$captch_code.="$fontcontent";
			$x = ($i * 120/4)+rand(5,10);
			$y = rand(8,10);
			imagestring($image, $fontsize, $x, $y, $fontcontent, $fontcolor);

		}
		$_SESSION['code']=$captch_code;
		header('content-type: image/png');
		imagepng($image);
		imagedestroy($image);
	}

	code();