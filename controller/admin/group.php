<?php

	if ($_A =='index') {
		$sql = "select * from level where 1";
		$result = sql_list($mysqli,$sql);
		$sql_count = "select count(id) as count from level ";
		$count = sql_one($mysqli,$sql_count);
		include VIEW.$_M.'/'.$_C.'/'.$_A.'.html';
	
}elseif ($_A =='add') {
		if($_POST){
			$data['name'] = $_POST['roleName'];
			$data['remarks'] = $_POST['remarks'];
			$data['level_arr'] = $_POST['level_arr'];
			$data['level_arr'] = json_encode($data['level_arr']);

			$keys = '';
			$values = '';
			foreach ($data as $key => $value) {
				$keys .= $key.',';
				$values .= "'".$value."',";
			}
			$keys = rtrim($keys,',');
			$values = rtrim($values,',');

			$sql = "insert into level($keys) values($values)";
			// var_dump($sql);die;
			$result = sql_increase($mysqli,$sql);
			if($result){
				script_success('添加成功','index.php?mot=admin&ctl=group&act=index');
			}else{
				script_error('添加失败');
			}
		}else{
			$sql = "select * from menu where category_id=0 and distinction=2";

			$result = sql_list($mysqli,$sql);
			// var_dump($result);die;

			foreach ($result as $key => $value) {
				$sql2 = "select * from menu where category_id={$value['id']} and distinction=2";
				$r = sql_list($mysqli,$sql2);
				$result[$key]['children'] = $r;
				// var_dump($result[$key]['children']);die;
			}

			include VIEW.$_M.'/'.$_C.'/'.$_A.'.html';
		}
}

	elseif ($_A == 'del') {
			$id = $_GET['id'];
			
			$sql = "delete from level where id={$id}";

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
			$data['name'] = trim($_POST['roleName']);
			$data['level_arr'] = $_POST['level_arr'];
			$data['level_arr'] = json_encode($data['level_arr']);

			$keys = '';
			foreach ($data as $key => $value) {
				$keys .= $key."='".$value."',";
			}
			$keys = rtrim($keys,',');
			$sql = "update level set $keys where id={$id}";
			// var_dump($sql);
			$result = sql_modify($mysqli,$sql);
			// var_dump($result);die;
			if ($result) {
				script_success('修改成功','index.php?mot=admin&ctl=group&act=index');
			}else{
				script_error('修改失败');
			}

		}else{
			$id = $_GET['id'];
			$sql = "select * from level where id = {$id}";
			$result = sql_one($mysqli,$sql);


			$sql2 = "select * from menu where category_id=0 and distinction=2";

			$result3 = sql_list($mysqli,$sql2);
			// var_dump($result);die;

			foreach ($result3 as $key => $value) {
				$sql3 = "select * from menu where category_id={$value['id']} and distinction=2";
				$r = sql_list($mysqli,$sql3);
				$result3[$key]['children'] = $r;
				// var_dump($result3[$key]['children']);die;
				}

			include VIEW.$_M.'/'.$_C.'/'.$_A.'.html';
		}
	}
