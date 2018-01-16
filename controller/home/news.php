<?php

	$sql  = "select * from category where category_id=81";
	$news = sql_list($mysqli,$sql);

	$cid = empty($_GET['cid'])?3:$_GET['cid'];
	$sql1 = "select * from news where category_id={$cid} order by id desc limit 0,6";
	// var_dump($sql1);die;
	$news1 = sql_list($mysqli,$sql1);
	// var_dump($news1);die;
	foreach ($news1 as $key => $value) {
		$news1[$key]['create_time'] = date('Y-m-d',strtotime($value['create_time']));
	}

//分页
$p = empty($_GET['p'])? 1 :$_GET['p'];

$news_list = pageData('news',$p,6,"category_id={$cid}");
//   echo "<pre>";
// var_dump($news_list);
$page  = page_home('news',$p,6,"mot=home&ctl=news&cid={$cid}",$showpage=3,"category_id={$cid}");
// var_dump($page);die;



include "common.php";