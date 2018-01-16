<?php

    //首页公司介绍遍历
	$sql="select * from category where category_id=82";
	$about1=sql_list($mysqli,$sql);

	// var_dump($about1);die;
	$sql1="select * from about";
	$about2=sql_list($mysqli,$sql1);
	// var_dump($about2);die;
	

	//首页产品中心遍历
	$sql2 = "select * from porducts order by id desc limit 0,8";
	$por = sql_list($mysqli,$sql2);
	// var_dump($por);
	


	//首页新闻中心遍历
    $sql3="select * from news order by id desc limit 0,7";
	$news_list=sql_list($mysqli,$sql3);
	foreach ($news_list as $key => $value) {
		$news_list[$key]['create_time'] = date('Y-m-d',strtotime($value['create_time']));
	}



include "common.php";