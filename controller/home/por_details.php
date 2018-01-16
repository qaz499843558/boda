<?php

	
	$sql = "select * from category where category_id= 84";
	$por = sql_list($mysqli,$sql);

	$cid = empty($_GET['cid'])?11:$_GET['cid'];

	$pid = empty($_GET['pid'])?59:$_GET['pid'];	
	
	$sql1 = "select * from porducts where id={$pid}";

	$por1 = sql_one($mysqli,$sql1);





include "common.php";