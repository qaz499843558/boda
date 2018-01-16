<?php

	//联系我们联系方式遍历
	
	$sql = "select * from contact where 1 ";
	$result = sql_one($mysqli,$sql);

	//留言框添加
	if($_A == 'add'){
		if ($_POST) {


			$data['name'] = $_POST['name'];
			$data['phone'] = $_POST['phone'];
			$data['email'] = $_POST['email'];
			$data['content'] = $_POST['content'];
			
			$data['create_time'] = date('Y-m-d H:i:s',time());



			$keys = '';
			$values = '';
			foreach ($data as $key => $value) {
				$keys .= $key.',';
				$values .= "'".$value."',";
			}
			$keys = rtrim($keys,',');
			$values = rtrim($values,',');

			$sql = "insert into message($keys) values($values)";
			$result = sql_increase($mysqli,$sql);
			if ($result) {
				script_success('添加成功','index.php?mot=home&ctl=contact');
			}else{
				script_error('添加失败');
			}
		}else{
			include VIEW.$_M.'/'.$_C.'/'.$_A.'.html';
		}



	}



include "common.php";