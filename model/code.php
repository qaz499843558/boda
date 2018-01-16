<?php
	

/**验证码**/

function verify($size=20,$number=4,$ttf=array('common/fonts/FZZQJW.TTF'),$str='0123456789jkKLOPUYTREWQ')
{
    	$w = $size*10;
    	$h = $size*5;
    	$image = imagecreatetruecolor($w,$h);
   
	    $color = imagecolorallocate($image,mt_rand(160,200),mt_rand(160,200),mt_rand(100,200));

	    
	    $png = imagefilledrectangle($image,0,0,200,100,$color);
	    // var_dump($png);die;

	    $vcode ='';
	    // var_dump($length);die;
	    for ($i=0; $i < $number; $i++) { 
	        
	    	$wit = $size*($i+0.5); //设置文字的X轴定位
	    	$hei = mt_rand($size*($i+0.5),$size*3);//随机获取文字的Y轴定位
	        // $wit = 30;
	        // $hei = 50;
	    	$length = strlen($str);
	    	$le_one = $str[mt_rand(0,$length-1)];
	    	// var_dump($le_one);die;
	    	$vcode .=$le_one;
	    	// var_dump($vcode);die;
	    	$color1 = imagecolorallocate($im,rand(0,40),rand(0,40),rand(0,40));
	    	$font = count($ttf)-1;
	    	// echo $font;die;
	    	// $name = imagettftext($image,$size,0,$wit,$hei,$color1,$ttf[mt_rand(0,$font)],$le_one);
	    	imagettftext($image,20,90,100,50,$color1,$ttf,$le_one);
	    	// var_dump($name);die;
	    }

	    // imagettftext($size,20,90,100,50,$color1,$ttf,$le_one);
		if(empty($_SESSION)){
        	session_start();
        }

        $_SESSION['vcode'] = $vcode;
        ob_clean();
	    header("Cache-Control: max-age=1, s-maxage=1, no-cache, must-revalidate");
	    header("Content-type: image/png;charset=utf8");
        
        


	    imagepng($image);
	    imagedestroy($image);//通常与生成图片连用
    }



    /**
 * [vcode 生成验证码图片]
 * @param  [自然数] $number [验证码字符个数]
 * @param  [自然数] $size   [验证码字体大小]
 * @param  [自然数] $width  [验证码图片宽度]
 * @param  [自然数] $height [验证码图片高度]
 * @param  [字符串]  $str    [验证码字符串源]
 * @param  [数组]   $font   [字体文件路径数组]
 */
function vcode($number=2,$size=20,$width=0,$height=0,$str="qwertyuioplkjhgfdsazxcvbnm1234567890",$font=array('common/fonts/FZZQJW.TTF','common/fonts/STHUPO.TTF')){
	if($width==0) //如果没有传验证码图片宽度参数
	{
		$width=($number+1.5)*$size; //自动生成验证码图片的宽度
	}
	if($height==0) //如果没有传验证码图片高度参数
	{
		$height=$size*2; //自动生成验证码图片的高度
	}
	$im=imagecreatetruecolor($width,$height);//生成画布,参数(画布宽,画布高)
	//$red=imagecolorallocate($im,255,0,0);//生成颜色资源,参数(画布资源,R,G,B)
	$randTintColor=imagecolorallocate($im,rand(160,255),rand(160,255),rand(160,255));//生成随机浅颜色资源,参数(画布资源,R,G,B)
	// $randColor=imagecolorallocate($im,rand(0,80),rand(0,80),rand(0,80));//生成随机深颜色资源,参数(画布资源,R,G,B)
	imagefilledrectangle($im, 0, 0, $width, $height, $randTintColor);//给画布添加背景颜色,参数(画布资源,起点X,起点Y,终点X,终点Y,颜色资源)
	//imagerectangle($im, 1, 1, 499, 299,$randColor);//画矩形,参数(画布资源,起点X,起点Y,终点X,终点Y,颜色资源)
	
	$vcode='';//声明保存验证码字符串的变量

	//$font=array('FZZQJW.TTF','STHUPO.TTF');//字体数组

	$fontMaxIndex=count($font)-1;//获取字体数组最大索引
	for ($i=0; $i <$number ; $i++) { //循环添加文字到画布
		$wx=$size*0.5+$size*$i; //设置文字的X轴定位
		//$width=50+50*$i*1.2;//设置中文文字的X轴定位
		$wy=rand($size*1.5,$size*2); //随机获取文字的Y轴定位
		$strMaxIndex=strlen($str)-1;//获取验证码源最大索引 20 0 ~19
		$code=$str[rand(0,$strMaxIndex)];//获取随机验证码
		//$rand=rand(0,11);//获取随机数
		//$code=mb_substr($strC,$rand,1,'utf-8');//通过截取字符串方式获取验证码
		$vcode.=$code;//将验证码拼接到验证码字符串 1. 0 空+第一个字 2. 1 空+第一字 +第二字
		$randColor1=imagecolorallocate($im,rand(0,40),rand(0,40),rand(0,40));//生成随机颜色资源
		imagettftext($im, $size , rand(-40,10), $wx, $wy, $randColor1, $font[rand(0,$fontMaxIndex)], $code);//将文字添加进画布,参数(画布资源,文字大小,文字倾斜角度,起点X,起点Y,颜色资源,字体,文字);
	}
	$pn=$size*5;
	for ($i=0; $i < $pn; $i++) { //循环添加像素干扰点
		$randColor=imagecolorallocate($im,rand(10,50),rand(10,50),rand(10,50));//生成随机颜色资源
		$wwx= rand(0,$width);//设置干扰像素的X轴定位
		$wwy= rand(0,$height);//设置干扰像素的y轴定位
		// for ($j=0; $j <5 ; $j++) { 
		// 	for ($K=0; $K <5 ; $K++) { 
				//imagesetpixel($im, $wwx+$j, $wwy+$K, $randColor);
				imagesetpixel($im, $wwx, $wwy, $randColor);//在画布上画一个点,参数(画布资源,位置X,位置Y,颜色资源)
		// 	}
		// }
	}

	if(!isset($_SESSION)){//通过判断变量$_SESSION是否设置来确认session是否开启
		session_start();//开始服务器session功能
	}
	$_SESSION['vcode']=strtolower($vcode);//将验证码字符串保存到$_SESSION中
	header("Content-type: image/png;charset=utf-8");//设置浏览器头信息,内容为png格式的图片
	ob_clean();
	imagepng($im);//输出图片

	imagedestroy($im);//销毁图片资源
}
