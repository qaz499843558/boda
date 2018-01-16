<?php

	$sql="select * from category where category_id=82";
	$about=sql_list($mysqli,$sql);
    $cid = empty($_GET['cid'])?7:$_GET['cid'];
    $sql1 ="select * from about where category_id={$cid}";
    $about1 = sql_one($mysqli,$sql1);
    // var_dump($about1);die;
    $sql2="select * from category where cate_id={$cid}";
    $about2 = sql_one($mysqli,$sql2);

include "common.php";