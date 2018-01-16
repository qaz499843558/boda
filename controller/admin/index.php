<?php

if (empty($_SESSION['name'])) {
	echo "<script>alert('非法登录，请到登录页');window.location.href='index.php?mot=admin&ctl=login';</script>";
}

	if ($_A == 'index') {
		$sql = "select * from menu where display=1 and distinction=2 and category_id=0 order by place asc";
		$result = sql_list($mysqli,$sql);
		// var_dump($resule);die;
		foreach ($result as $key => $value) {
			$sql2 = "select * from menu where display=1 and distinction=2 and category_id={$value['id']} order by place asc";
			$r = sql_list($mysqli,$sql2);
			$arr='';
			if (is_array($value)) {
				foreach ($r as $k => $v) {
					$r[$k]['urls'] = "index.php?mot=admin&ctl={$v['controller']}&act={$v['action']}";
				}
			}
			$result[$key]['next'] = $r;
		}
		// print_r($result);die;
		include VIEW.$_M.'/'.$_C.'/'.$_A.'.html';
		
	}elseif($_A== 'logout') {
			$_SESSION = array();
			session_destroy($_SESSION['name']);
			echo "<script>alert('退出成功');window.location.href='index.php?mot=admin&ctl=login';</script>";
			exit;

	}elseif ($_A == 'welcome') {

		include VIEW.$_M.'/'.$_C.'/'.$_A.'.html';
	
	}elseif ($_A == 'selects') {
		
		$id = $_POST['id'];

		if ($id) {

			$sql = "select * from category where category_id = {$id}";

			$result = sql_list($mysqli,$sql);

			$selects = '';

			if ($result) {
				
				$selects .= '<div class = "formControls col-xs-8 col-sm-2"><sqan class = "select-box"><select class = "select" size="1" name = "cate_id" ><option value = "">请选择分类</option>';

				for ($i = 0; $i < count($result); $i++){

					$selects .= '<option value="'.$result[$i]['cid'].'">'.$result[$i]['caie_name'].'</option>';

				}

				for ($i=0; $i < count($result); $i++) { 
					
					$selects .= '<option value="'.$result[$i]['cid'] .'">'.$result[$i]['cate_name'].'</option>';

				}

				$selects .='</select></span></div>';

				echo $selects;

				exit();

			}

		}

	}