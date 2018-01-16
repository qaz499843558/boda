<?php

	$sql  = "select * from category where category_id=81";
	$news = sql_list($mysqli,$sql);


	$cid = empty($_GET['cid'])?3:$_GET['cid'];
	// echo $cid;die;
	$pid = empty($_GET['pid'])?36:$_GET['pid'];

	//点击量
	if($f=@fopen("num.txt" ,"r")){
		//第一种方法
	   	$num=fgets($f,10);
		//第二种方法
     	// $num = fread($f, filesize("num.txt"));
	}else{
	   $num=0;		
	}
	$num++;
	$ff=fopen("num.txt" ,"w");
	fwrite($ff,$num);
	fclose($ff);
	// var_dump($num);die;




	$sql1 = "select * from news where id={$pid}";
	// var_dump($sql1);
	$news1 = sql_one($mysqli,$sql1);
	// var_dump($news1);die;
	
		$news1['create_time'] = date('Y-m-d',strtotime($news1['create_time']));
	


include "common.php";