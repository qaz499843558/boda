<?php


	if ($_A == 'index') {

		$sql = "select * from about where 1";
		$result=sql_list($mysqli,$sql);
		// var_dump($result);die;
		foreach ($result as $key => $value) {
		$sql = "select * from category where cate_id={$value['category_id']}";
		// var_dump($sql);die;
		$data = sql_one($mysqli,$sql);

		
		$result[$key]['category_id'] = $data['cate_name'];
  } 
		// var_dump($result);
		$sql_count = "select count(id) as count from about ";
		$count = sql_one($mysqli,$sql_count);


		include VIEW.$_M.'/'.$_C.'/'.$_A.'.html';
		
	}elseif($_A == 'add'){
		if ($_POST) {
			// echo_print($_FILES);
			$array = ['image/jpeg','image/png','image/gif'];
			if ($_FILES['image']['name']) {
				if (in_array($_FILES['image']['type'],$array)) {
					if ($_FILES['image']['size']<2097152) {
						$ext = strripos($_FILES['image']['name'],'.');
						$exts = substr($_FILES['image']['name'],$ext);
						$upload = 'upload/';
						if (!file_exists($upload)) {
							mkdir($upload,0777);
						}
						$files = $upload.rand(10000,99999).date('Y-m-d',time()).$exts;
						$image = move_uploaded_file($_FILES['image']['tmp_name'],$files);
						$data['image'] = $files;
					}
				}
			}


			$data['category_id'] = $_POST['category_id'];

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

			$sql = "insert into about($keys) values($values)";
			// var_dump($sql);die;
			$result = sql_increase($mysqli,$sql);
			// var_dump($result);die;
			if ($result) {
				script_success('添加成功','index.php?mot=admin&ctl=about&act=index');
			}else{
				script_error('添加失败');
			}
		}else{
			$arr = category_tree(82,0,'$nbsp;|-','category','*',array(),'cate_name','cate_id');
			include VIEW.$_M.'/'.$_C.'/'.$_A.'.html';
		}



	}elseif($_A == 'del'){
		$id = $_GET['id'];
		// var_dump($id);die
		$sql = "delete from about where id={$id}";
		$result = sql_delete($mysqli,$sql);
		if ($result) {
			echo json_encode(1);
			die;
		}else{
			echo json_encode(0);
			die;
		}
		include VIEW.$_M.'/'.$_C.'/'.$_A.'.html';

	}elseif($_A == 'edit'){
		if ($_POST) {
			$array = ['image/jpeg','image/png','image/gif'];
			if ($_FILES['image']['name']) {
				if (in_array($_FILES['image']['type'],$array)) {
					if ($_FILES['image']['size']<2097152) {
						$ext = strripos($_FILES['image']['name'],'.');
						$exts = substr($_FILES['image']['name'],$ext);
						$upload = 'upload/';
						if (!file_exists($upload)) {
							mkdir($upload,0777);
						}
						$files = $upload.rand(10000,99999).date('Y-m-d',time()).$exts;
						$image = move_uploaded_file($_FILES['image']['tmp_name'],$files);
						$data['image'] = $files;
					}
				}
			}
			// var_dump($);die;			
			$id = $_POST['id'];
			// var_dump($id);die;
			$data['category_id'] = $_POST['category_id'];
			$data['content'] = $_POST['content'];
			// $data['image'] = $files;
			$data['create_time'] =date('Y-m-d H:i:s',time());


			$keys = '';
			foreach ($data as $key => $value) {
				$keys .= $key."='".$value."',";
			}
			$keys = rtrim($keys,',');
			$sql = "update about set $keys where id={$id}";
			// var_dump($sql);
			$result = sql_modify($mysqli,$sql);
			// var_dump($result);die;
			if ($result) {
				script_success('修改成功','index.php?mot=admin&ctl=about&act=index');
			}else{
				script_error('修改失败');
			}
		}else{
			$id = $_GET['id'];
			// var_dump($id);
			$sql = "select * from about where id = {$id}";
			// var_dump($sql);die;
			$result = sql_one($mysqli,$sql);
			// var_dump($id);die;
			$arr = category_tree(82,0,'$nbsp;|-','category','*',array(),'cate_name','cate_id'); 
			// var_dump($arr);
			include VIEW.$_M.'/'.$_C.'/'.$_A.'.html';
		}
			
}