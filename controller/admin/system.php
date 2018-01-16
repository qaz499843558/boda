<?php 

if($_A == 'admin-list'){


	$arr = category_tree(0,0,'&nbsp;|-','menu','*',array(),'menu','id','distinction=2');
	// var_dump($arr);die;
	foreach ($arr as $key => $value) {
		$sql = "select * from menu where distinction=2 and id={$value['category_id']}";
		$data = sql_one($mysqli,$sql);
		// var_dump($data);
		$arr[$key]['category_id'] = $value['category_id']==0?'顶级菜单':$data['menu'];

		$arr[$key]['distinction'] = $value['distinction']==2?'后台':'前台';
		$arr[$key]['display'] = $value['display']==1?'显示':'隐藏';
		$arr[$key]['controller'] = empty($value['controller'])?'NULL':$value['controller'];
		$arr[$key]['action'] = empty($value['action'])?'NULL':$value['action'];
  }

    $sql_count = "select count(id) as count from menu where distinction=2";
    $count = sql_one($mysqli,$sql_count); 
  
    

	include VIEW.$_M.'/'.$_C.'/'.$_A.'.html';
}
else if ($_A=='admin-add') {
		if ($_POST) {
			$data['menu'] = $_POST['menu'];
			$sql_select = "select menu from menu where menu='{$_POST['menu']}'";
			$name = sql_one($mysqli,$sql_select);
			if($name){
				script_error('菜单名已存在，请重新输入');
			}
			
			$place_ = intval($_POST['place']);
			$sql_select2 = "select place from menu where place=$place_";
			$place = sql_one($mysqli,$sql_select2);
			if($place) {
				script_error('位置已存在，请重新输入');
			}
      if (!empty($_POST['controller'])) {
          $data['controller'] = $_POST['controller'];
      }
      if (!empty($_POST['action'])) {
          $data['action'] = $_POST['action'];
      }

			$data['category_id'] = $_POST['category_id'];
			$data['display'] = $_POST['display'];
			$data['place'] = $_POST['place'];
			$data['create_time'] = date('Y-m-d H:i:s',time());
			
			$data['distinction'] = $_POST['distinction'];
      $data['remarks'] = $_POST['remarks'];
			// $data['icon'] = $_POST['icon'];

			$keys = '';
			$values = '';
			foreach ($data as $key => $value) {
				$keys .= $key.',';
				$values .= "'".$value."',";
			}
			$keys = rtrim($keys,',');
			$values = rtrim($values,',');

			$sql = "insert into menu($keys) values($values)";
			$result = sql_increase($mysqli,$sql);
			if ($result) {
        if ($data['distinction']==2) {
          script_success('添加成功','index.php?mot=admin&ctl=system&act=admin-list');
        }else{
          script_success('添加成功','index.php?mot=admin&ctl=system&act=home');
        }
				
			}else{
				script_error('添加失败');
			}	
		}else{
				$arr = category_tree();
       
		   		include VIEW.$_M.'/'.$_C.'/'.$_A.'.html';
			}
}
elseif ($_A=='del') {
			// echo 123;die;
			$id = $_GET['id'];
			$sql = "delete from menu where id={$id}";
			// echo $sql;die;
			$result = sql_delete($mysqli,$sql);

			if ($result) {

				echo json_encode(1);
				die;
			}else{
				echo json_encode(0);
				die;
			}
}
	
	else if ($_A=='edit') {
     if($_POST){
      // echo_print($_POST);die;
          //判断菜单名是否存在
      $id = $_POST['id'];
      // var_dump($id);die;

     /* $id = !empty($_REQUEST['id'])?intval($_REQUEST['id']):9;*/
     /* var_dump($id);die;*/

      $data['menu']   = $_POST['menu'];

      $sql_select = "select menu from menu where id != {$id} and menu='{$data['menu']}'";//判断是否存在这个名字
      // echo $sql_select;die;
      $name  =  sql_increase($mysqli,$sql_select);
    
      if($name){
         script_error('菜单名已存在，赶紧另外起一个');
      }
      /*位置**/
      $pl = empty($_POST['place']) ? script_error('排序不能为空，赶紧起一个') : intval($_POST['place']);

      $sql_select2 = "select place from menu where id != {$id} and place=$pl";//判断位置是否存在

      $place  = sql_list($mysqli,$sql_select2);
      if($place){
         script_error('位置已被占用，赶紧去找一个');
      }
      
      /**存在数据库数据*/
     
      $data['category_id'] = $_POST['category_id'];

      $data['display']     = $_POST['display'];

      $data['place']       = $_POST['place'];

      $data['controller']  = $_POST['controller'];
      
      $data['action']      = $_POST['action'];

      $data['distinction'] = $_POST['distinction']; 

      $data['remarks'] = $_POST['remarks']; 

      // empty($_POST['icon'])?'':$data['icon'] = $_POST['icon']; 
      
      $keys   = '';
     
      foreach ($data as $key => $value) {
        $keys   .= $key."='".$value."',";
      
      }
     
      $keys   = rtrim($keys,',');
   
     
      $sql = "update menu set $keys where id={$id}";

      $result = sql_modify($mysqli,$sql);//添加

      /*var_dump($sql);die;*/
      if($result){
          if ($data['distinction']==2) {
            script_success('修改成功','index.php?mot=admin&ctl=system&act=admin-list');
         }else{
            script_success('修改成功','index.php?mot=admin&ctl=system&act=home');
        }
      }else{
          script_error('修改失败');
      }
     }else{
         // echo_print($_GET);
         // die;
      //查询跳转过来当前ID数据
        $id     = $_GET['id'];
        // var_dump($id);die;

        $sql    = "select * from menu where id={$id}";
        // var_dump($sql);die;

        $result =sql_one($mysqli,$sql);
        // var_dump($result);die;
        //下拉上一级菜单
        $sql = "select * from menu where category_id=0"; //查询分类ID等于O

        $results = sql_list($mysqli,$sql); 

        $arr = array();

        foreach ($results as $key => $value) {

          $value['menu'] = '&nbsp;--'.$value['menu'];

          $arr[]= $value;

          $sql2 = "select * from menu where category_id={$value['id']}";//查询分类ID=1，2，3下一级数据

            $result2 = sql_list($mysqli,$sql2);

            foreach ($result2 as $k=> $v) {  //加点字符串,输出区分格式

              $v['menu'] = '&nbsp;&nbsp;&nbsp;<b>|-</b>'.$v['menu'];

              $arr[] = $v;

            }

        }
        // var_dump($result);die;
        include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';

  }

}elseif($_A == 'home'){
  // echo 123;die;

  $arr = category_tree(0,0,'&nbsp;|-','menu','*',array(),'menu','id','distinction=1');
  // category_tree($pid = 0,$num = 0,$str ='&nbsp;|-',$table='menu',$filed='*',$arr=array(),$file='menu',$id='id',$where='')
  // var_dump($arr);die;
  foreach ($arr as $key => $value) {
    $sql = "select * from menu where distinction=1 and id={$value['category_id']}";
    $data = sql_one($mysqli,$sql);
    // var_dump($data);
    $arr[$key]['category_id'] = $value['category_id']==0?'顶级菜单':$data['menu'];

    $arr[$key]['distinction'] = $value['distinction']==2?'后台':'前台';
    $arr[$key]['display'] = $value['display']==1?'显示':'隐藏';
    $arr[$key]['controller'] = empty($value['controller'])?'NULL':$value['controller'];
    $arr[$key]['action'] = empty($value['action'])?'NULL':$value['action'];
  }

    $sql_count = "select count(id) as count from menu where distinction=1";
    $count = sql_one($mysqli,$sql_count); 
  
    

  include VIEW.$_M.'/'.$_C.'/'.'admin-list.html';
}