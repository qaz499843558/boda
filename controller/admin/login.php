<?php


	// if ($_A=='code') {
	// 	code();
	// }

	if ($_A=='index') {
		if ($_POST) {



			$name = $_POST['username'];

			$password = MD5($_POST['password']);

			$check  = empty($_POST['online'])?'':$_POST['online'];

			// var_dump($_SESSION['vcode']);die;

	    	if($_POST['code']==''){
	    		 script_error('验证码不能为空');
	    	}elseif(strtolower($_POST['code']) !=$_SESSION['vcode']){
	              script_error('验证码不正确');
	    	}


			$sql = "select * from ddc where name = '{$name}' and password = '{$password}'";

			// var_dump($sql);die;

			$result = sql_one($mysqli,$sql);

			if ($result) {
				$_SESSION['name'] = $_POST['username'];
				script_success('欢迎来到多迪江湖','index.php?mot=admin&ctl=index');
			}else{
				script_error('你的信息不正确，请重新登录');
			}
		}else{
			include VIEW.$_M.'/'.$_C.'/'.$_A.'.html';
		}
	}else if($_A == 'code'){


    include "model/code.php";

    vcode();
}