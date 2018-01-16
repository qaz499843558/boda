<?php
	if ($_A == 'index') {
		$sql = "select * from user where 1";
		$result = sql_list($mysqli,$sql);	
		$sql_count = "select count(id) as count from user ";
		$count = sql_one($mysqli,$sql_count);
		include VIEW.$_M.'/'.$_C.'/'.$_A.'.html';
	}
	elseif ($_A == 'add') {
		if ($_POST) {
			$data['name'] = trim($_POST['name']);
			$data['password'] = md5(trim($_POST['password']));
			$repassword = trim($_POST['repassword']);
			$data['remarks'] = $_POST['remarks'];
			$data['time'] = date("Y-m-d H:i:s",time());
			$sql = "select name from user where name='".$data['name']."'";
			$name = sql_one($mysqli,$sql);
			if ($name) {
				script_error('用户已存在，请另起名');
			}
			if ($data['password']!= md5($repassword)){
				script_error('密码不一致');
			}
				$keys= '';
				$values ='';
				foreach ($data as $key => $value) {
					$keys .= $key.',';
					$values .= "'".$value."',";
			}
			$keys = rtrim($keys,',');
			$values = rtrim($values,',');
			$sql = "insert into user($keys) values($values)";
			$result = sql_increase($mysqli,$sql);
			if ($result) {
				script_success('添加成功','index.php?mot=admin&ctl=user&act=index');
			}else{
				script_success('添加失败');
			}
		}else{
			
			include VIEW.$_M.'/'.$_C.'/'.$_A.'.html';
		}
		
	}
	elseif ($_A == 'del') {
			$id = $_GET['id'];
			if($id==1){
				script_error('超级用户不能删除');
			}
			$sql = "delete from user where id={$id}";
			// var_dump($sql);die;
			$result = sql_delete($mysqli,$sql);

			if ($result) {

				echo json_encode(1);
				die;
			}else{
				echo json_encode(0);
				die;
			}
		
	}
	elseif ($_A == 'edit') {
		if ($_POST) {
			$id = $_POST['id'];
			// var_dump($id);die;
			$data['name'] = trim($_POST['name']);
			$data['password'] = md5(trim($_POST['password']));
			$repassword = trim($_POST['repassword']);
			// $data['remarks'] = $_POST['remarks'];
			// $data['time'] = time();
			$pass = md5($_POST['password_old']);
			$sql = "select * from user where name='{$data['name']}' and id !={$id}";
			$name = sql_one($mysqli,$sql);
			if ($name) {
				script_error('用户已存在，请另起名');
			}
			$sql = "select * from user where name='{$data['name']}' and password='{$pass}'";
			// var_dump($sql);
			$user = sql_one($mysqli,$sql);
			// var_dump($user);die;
			if (!$user) {
				script_error('初始密码错误');
			}
			if ($data['password'] !=md5($repassword)) {
				script_error('密码不一致');
			}
			$keys = '';
			foreach ($data as $key => $value) {
				$keys .= $key."='".$value."',";
			}
			$keys = rtrim($keys,',');
			$sql = "update user set $keys where id={$id}";
			// var_dump($sql);
			$result = sql_modify($mysqli,$sql);
			// var_dump($result);die;
			if ($result) {
				script_success('修改成功','index.php?mot=admin&ctl=user&act=index');
			}else{
				script_error('修改失败');
			}

		}else{
			$id = $_GET['id'];
			$sql = "select * from user where id = {$id}";
			$result = sql_one($mysqli,$sql);

			include VIEW.$_M.'/'.$_C.'/'.$_A.'.html';
		}
		
	}