<?php

	define('DEBUG',true);

	if(DEBUG == true){

		error_reporting(E_ALL);

	}else{

		error_reporting(0);

	}
//开启session
if(empty($_SESSION)){

	session_start();

};

	header('Content-type:text/html;charset=utf-8');
	define('DBHOST','127.0.0.1');
	define('DBUSER','root');
	define('DBPASSWORD','root');
	define('DBNAME','ddk');
	define('CHARSET','utf8');

	define('CONTROLLER','controller/');
	define('TYPE',1);
	define('COMMON','common/admin/');
	define('VIEW','view/');
	define('H_COMMON','common/home/');
	define('INDEX','index.php?mot=home&ctl=index&act=index');
	define('ABOUT','index.php?mot=home&ctl=about&act=index');
	define('NEWS','index.php?mot=home&ctl=news&act=index');
	define('PORDUCTS','index.php?mot=home&ctl=porducts&act=index');
	define('POR_DETAILS','index.php?mot=home&ctl=por_details&act=index');
	define('CONTACT','index.php?mot=home&ctl=contact&act=index');
	define('NEWS_DETAILS','index.php?mot=home&ctl=news_details&act=index');
	define('MAP','index.php?mot=home&ctl=map&act=index');

	include "config.php";
	include "function.php";
	include "common.php";
	include "upload.php";
	include "page.php";

	db();

?>