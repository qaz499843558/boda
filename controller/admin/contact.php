<?php
	
	if ($_A=='index'){

		$sql = "select * from contact where 1";
		$result=sql_list($mysqli,$sql);
		// var_dump($result);die;
		$sql_count = "select count(id) as count from contact ";
		$count = sql_one($mysqli,$sql_count);


		include VIEW.$_M.'/'.$_C.'/'.$_A.'.html';
		
	}
	// elseif($_A == 'add'){
	// 	if ($_POST) {
	// 		// echo_print($_FILES);
	// 		$array = ['image/jpeg','image/png','image/gif'];
	// 		if ($_FILES['2dcode']['name']) {
	// 			if (in_array($_FILES['2dcode']['type'],$array)) {
	// 				if ($_FILES['2dcode']['size']<2097152) {
	// 					$ext = strripos($_FILES['2dcode']['name'],'.');
	// 					$exts = substr($_FILES['2dcode']['name'],$ext);
	// 					$upload = 'upload/';
	// 					if (!file_exists($upload)) {
	// 						mkdir($upload,0777);
	// 					}
	// 					$files = $upload.rand(10000,99999).date('Y-m-d',time()).$exts;
	// 					$image = move_uploaded_file($_FILES['2dcode']['tmp_name'],$files);
	// 					$data['2dcode'] = $files;
	// 				}
	// 			}
	// 		}
	// 		$array = ['image/jpeg','image/png','image/gif'];
	// 		if ($_FILES['logo']['name']) {
	// 			if (in_array($_FILES['logo']['type'],$array)) {
	// 				if ($_FILES['logo']['size']<2097152) {
	// 					$ext = strripos($_FILES['logo']['name'],'.');
	// 					$exts = substr($_FILES['logo']['name'],$ext);
	// 					$upload = 'upload/';
	// 					if (!file_exists($upload)) {
	// 						mkdir($upload,0777);
	// 					}
	// 					$files = $upload.rand(10000,99999).date('Y-m-d',time()).$exts;
	// 					$image = move_uploaded_file($_FILES['logo']['tmp_name'],$files);
	// 					$data['logo'] = $files;
	// 				}
	// 			}
	// 		}


	// 		$data['address'] = $_POST['address'];
	// 		$data['fax'] = $_POST['fax'];
	// 		$data['phone'] = $_POST['phone'];
	// 		$data['phone_number'] = $_POST['phone_number'];
	// 		$data['linkman'] = $_POST['linkman'];
	// 		$data['copyright'] = $_POST['copyright'];
	// 		$data['support'] = $_POST['support'];

	// 		$keys = '';
	// 		$values = '';
	// 		foreach ($data as $key => $value) {
	// 			$keys .= $key.',';
	// 			$values .= "'".$value."',";
	// 		}
	// 		$keys = rtrim($keys,',');
	// 		$values = rtrim($values,',');

	// 		$sql = "insert into contact($keys) values($values)";
	// 		$result = sql_increase($mysqli,$sql);
	// 		// var_dump($result);die;
	// 		if ($result) {
	// 			script_success('添加成功','index.php?mot=admin&ctl=contact&act=index');
	// 		}else{
	// 			script_error('添加失败');
	// 		}
	// 	}else{
	// 		$arr = category_tree(84,0,'$nbsp;|-','category','*',array(),'cate_name','cate_id');
	// 		// var_dump($arr);die;
	// 		include VIEW.$_M.'/'.$_C.'/'.$_A.'.html';
	// 	}



	// }
	// elseif($_A == 'del'){
	// 	$id = $_GET['id'];
	// 	// var_dump($id);die
	// 	$sql = "delete from contact where id={$id}";
	// 	$result = sql_delete($mysqli,$sql);
	// 	if ($result) {
	// 		echo json_encode(1);
	// 		die;
	// 	}else{
	// 		echo json_encode(0);
	// 		die;
	// 	}
	// 	include VIEW.$_M.'/'.$_C.'/'.$_A.'.html';

	// }
	elseif($_A == 'edit'){
		if ($_POST) {
			// echo_print($_FILES);
			$array = ['image/jpeg','image/png','image/gif'];
			if ($_FILES['2dcode']['name']) {
				if (in_array($_FILES['2dcode']['type'],$array)) {
					if ($_FILES['2dcode']['size']<2097152) {
						$ext = strripos($_FILES['2dcode']['name'],'.');
						$exts = substr($_FILES['2dcode']['name'],$ext);
						$upload = 'upload/';
						if (!file_exists($upload)) {
							mkdir($upload,0777);
						}
						$files = $upload.rand(10000,99999).date('Y-m-d',time()).$exts;
						$image = move_uploaded_file($_FILES['2dcode']['tmp_name'],$files);
						$data['2dcode'] = $files;
					}
				}
			}
			$array = ['image/jpeg','image/png','image/gif'];
			if ($_FILES['logo']['name']) {
				if (in_array($_FILES['logo']['type'],$array)) {
					if ($_FILES['logo']['size']<2097152) {
						$ext = strripos($_FILES['logo']['name'],'.');
						$exts = substr($_FILES['logo']['name'],$ext);
						$upload = 'upload/';
						if (!file_exists($upload)) {
							mkdir($upload,0777);
						}
						$files = $upload.rand(10000,99999).date('Y-m-d',time()).$exts;
						$image = move_uploaded_file($_FILES['logo']['tmp_name'],$files);
						$data['logo'] = $files;
					}
				}
			}

			$id = $_POST['id'];
			$data['address'] = $_POST['address'];
			$data['fax'] = $_POST['fax'];
			$data['phone'] = $_POST['phone'];
			$data['phone_number'] = $_POST['phone_number'];
			$data['linkman'] = $_POST['linkman'];
			$data['copyright'] = $_POST['copyright'];
			$data['support'] = $_POST['support'];
			$keys = '';

			foreach ($data as $key => $value) {
				$keys .= $key."='".$value."',";
			}
			// var_dump($data);die;
			$keys = rtrim($keys,',');

			$sql = "update contact set $keys where id={$id}";
			$result = sql_modify($mysqli,$sql);
			// var_dump($result);die;
			if ($result) {
				script_success('修改成功','index.php?mot=admin&ctl=contact&act=index');
			}else{
				script_error('修改失败');
			}
		}else{
			$id = $_GET['id'];
			// var_dump($id);
			$sql = "select * from contact where id = {$id}";
			// var_dump($sql);die;
			$result = sql_one($mysqli,$sql);
			// var_dump($result);die;
			// var_dump($id);die;			
			// $arr = category_tree(86,0,'$nbsp;|-','category','*',array(),'cate_name','cate_id');
			// var_dump($arr);die;
			include VIEW.$_M.'/'.$_C.'/'.$_A.'.html';
		}



	}