<?php

	$sql = "select * from category where category_id= 84";
	$por = sql_list($mysqli,$sql);

	$cid = empty($_GET['cid'])?11:$_GET['cid'];
	
	// var_dump($por1);

//分页
$p = empty($_GET['p'])? 1 :$_GET['p'];

$por_list = pageData('porducts',$p,16,"category_id={$cid}");
  
// var_dump($news_list);
$page  = page_home('porducts',$p,16,"mot=home&ctl=porducts&cid={$cid}",3,"category_id={$cid}");
// var_dump($page);die;



include "common.php";