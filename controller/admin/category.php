<?php

	if ($_A == 'index') {

		$sql = "select * from category where 1";

		$result = sql_list($mysqli,$sql);

		foreach ($result as $key => $value) {
			
			$sql = "select * from menu where id={$value['category_id']}";

			// var_dump($sql);die;

			$data = sql_one($mysqli,$sql);

			// var_dump($data);

			$result[$key]['static'] = $value['static'] == 0?'显示':'隐藏';

			$result[$key]['category_id'] = $data['menu'];


		}

		$sql_count = "select count(id) as count from category";

		$count = sql_one($mysqli,$sql_count);

		include VIEW.$_M.'/'.$_C.'/'.$_A.'.html';

	}elseif ($_A == 'add') {

		if ($_POST) {
			
			$data['cate_name'] = $_POST['cate_name'];

			$sql_select = "select cate_name from category where cate_name='{$_POST['cate_name']}'";

			$name = sql_one($mysqli,$sql_select);

			if ($name) {
				
				script_error('分类名已存在，请重新输入');

			}

			$place_ = intval($_POST['place']);

			$sql_select2 = "select place from category where place=$place_";

			$place = sql_one($mysqli,$sql_select2);

			if ($place) {
				
				script_error('位置已存在，请重新输入');

			}

			$data['category_id'] = $_POST['category_id'];

			$data['create_time'] = date('Y-m-d',time());

			$data['static']      = $_POST['static'];

			$data['place']		 = $_POST['place'];

			$data['remarks']     = $_POST['remarks'];

			$data = $_POST;

			if (!empty($data['cate_id'])) {
				
				$data['category_id'] = $data['cate_id'];

			}

			unset($data['cate_id']);

			$keys = '';

			$values = '';

			foreach ($data as $key => $value) {
				
				$keys .= $key.',';

				$values .= "'".$value."',";

			}

			$keys = rtrim($keys,',');

			$values = rtrim($values,',');

			$sql = "insert into category($keys) values($values)";

			// var_dump($sql);

			$result =sql_increase($mysqli,$sql);

			// var_dump($result);die;

			if ($result) {
				
				script_success('添加成功','index.php?mot=admin&ctl=category&act=index');

			}else{

				script_error('添加失败');

			}

		}else{

			$sql = "select * from menu where category_id=0 and distinction=1";

			$arr = sql_list($mysqli,$sql);

			// var_dump($arr);die;

			include VIEW.$_M.'/'.$_C.'/'.$_A.'.html';

		}

	}elseif ($_A == 'del') {

		$id = $_GET['cate_id'];

		// var_dump($id);

		$sql = "delete from category where cate_id={$id}";

		// var_dump($sql);die;

		$result = sql_delete($mysqli,$sql);

		if ($result) {

			echo json_encode(1);

			die;

		}else{

			echo json_encode(0);

			die;

		}
		
		include VIEW.$_M.'/'.$_C.'/'.$_A.'.html';

	}elseif ($_A == 'edit') {

		if ($_POST) {

			$id = $_POST['cate_id'];
			
			$data['cate_name'] = $_POST['cate_name'];

		    $sql_select = "select cate_name from category where cate_id != {$id} and cate_name='{$data['cate_name']}'";//判断是否存在这个名字

		    $name  =  sql_one($mysqli,$sql_select);
		    
		    if($name){

		       script_error('菜单名已存在，赶紧另外起一个');

		    }
		    /*位置**/
		    $pl = empty($_POST['place']) ? script_error('排序不能为空，赶紧起一个') : intval($_POST['place']);

		    $sql_select2 = "select place from category where cate_id != {$id} and place=$pl";//判断位置是否存在

		    $place  = sql_list($mysqli,$sql_select2);

		    if($place){

		       script_error('位置已被占用，赶紧去找一个');

		    }     

			$data['category_id'] = $_POST['category_id'];

			$data['static']      = $_POST['static'];

			$data['place']		 = $_POST['place'];

			$data['remarks']     = $_POST['remarks'];

			$keys = '';

			$values = '';

			foreach ($data as $key => $value) {
				$keys .= $key."='".$value."',";
			}

			$keys = rtrim($keys,',');

			$values = rtrim($values,',');

			$sql = "update category set $keys where cate_id={$id}";

			// var_dump($sql);

			$result =sql_modify($mysqli,$sql);		

			// var_dump($result);die;

			if ($result) {
				
				script_success('修改成功','index.php?mot=admin&ctl=category&act=index');

			}else{

				script_error('修改失败');

			}

		}else{

			$id = $_GET['cate_id'];

			$sql = "select * from category where cate_id = {$id}";

			$result = sql_one($mysqli,$sql);	

			$sql = "select * from menu where category_id=0 and distinction=1";

			$arr = sql_list($mysqli,$sql);

			include VIEW.$_M.'/'.$_C.'/'.$_A.'.html';		

		}

	}