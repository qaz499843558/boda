<?php
	
	if ($_A == 'index') {
		$sql = "select * from roles where 1";
		$result = sql_list($mysqli,$sql);
		$sql_count = "select count(id) as count from roles ";
		$count = sql_one($mysqli,$sql_count);			
		include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';
	}
	elseif ($_A =='add') {
		if ($_POST) {
			$data['name'] = $_POST['name'];
			$data['remarks'] = $_POST['remarks'];
			$data['time'] = date("Y-m-d H:i:s",time());
			$keys = '';
			$values = '';
			foreach ($data as $key => $value) {
				$keys .= $key.',';
				$values .= "'".$value."',";
			}
			$keys = rtrim($keys,',');
			$values = rtrim($values,',');
			$sql = "insert into roles($keys) values($values)";
			$result = sql_increase($mysqli,$sql);

			if ($result) {
				script_success('添加成功','index.php?mot=admin&ctl=roles&act=index');
			}else{
				script_error('添加失败');
			}
		}else{
			include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';
		}
		
	}
	elseif ($_A =='del') {
		$id = $_GET['id'];
			
			$sql = "delete from roles where id={$id}";

			$result = sql_delete($mysqli,$sql);

			if ($result) {

				echo json_encode(1);
				die;
			}else{
				echo json_encode(0);
				die;
			}
	}
	elseif ($_A =='edit') {
		if ($_POST) {
			$id = $_POST['id'];
			$data['name'] = $_POST['name'];
			$data['remarks'] = $_POST['remarks'];
			$data['time'] = date("Y-m-d H:i:s",time());

			$keys = '';
			foreach ($data as $key => $value) {
				$keys .= $key."='".$value."',";
			}
			$keys = rtrim($keys,',');
			$sql = "update roles set $keys where id={$id}";

			// var_dump($sql);die;
			$result = sql_modify($mysqli,$sql);

			if ($result) {
				script_success('修改成功','index.php?mot=admin&ctl=roles&act=index');
			}else{
				script_error('修改失败');
			}		
		
	}else{
		$id = $_GET['id'];
		// var_dump($id);
		$sql = "select * from roles where id = {$id}";
		// var_dump($sql);die;
		$result = sql_one($mysqli,$sql);
		// var_dump($id);die;

		include VIEW.$_M.'/'.$_C.'/'.$_A.'.html';
	}
}