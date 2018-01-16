<?php


	if ($_A == 'index') {

		$sql = "select * from message where 1";
		$result=sql_list($mysqli,$sql);

		$sql_count = "select count(id) as count from message ";
		$count = sql_one($mysqli,$sql_count);


		include VIEW.$_M.'/'.$_C.'/'.$_A.'.html';
		
	}elseif($_A == 'del'){
		$id = $_GET['id'];
		// var_dump($id);die
		$sql = "delete from message where id={$id}";
		$result = sql_delete($mysqli,$sql);
		if ($result) {
			echo json_encode(1);
			die;
		}else{
			echo json_encode(0);
			die;
		}
		include VIEW.$_M.'/'.$_C.'/'.$_A.'.html';

	}


	else{
			$id = $_GET['id'];
			// var_dump($id);
			$sql = "select * from message where id = {$id}";
			// var_dump($sql);die;
			$result = sql_one($mysqli,$sql);
			// var_dump($id);die;

			include VIEW.$_M.'/'.$_C.'/'.$_A.'.html';
		}
			
