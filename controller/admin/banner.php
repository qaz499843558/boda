<?php

if($_A=='index'){
    $sql = "select * from banner where 1";
    $result = sql_list($mysqli,$sql);
    foreach ($result as $key => $value) {
    	$sql = "select menu from menu where id={$value['cate_id']}";
    	$name = sql_one($mysqli,$sql);
    	$result[$key]['cate_id'] = $name['menu'];
    	$result[$key]['create_time'] = $value['create_time'];
    }
    // var_dump($result);die;
    $sql_count = "select count(id) as count from category";

    $count = sql_one($mysqli,$sql_count);

    include  VIEW.$_M.'/'.$_C.'/'.$_A.'.html';
}


else if($_A =='add'){
    if($_POST){
       // echo_print($_POST);
       

       if(!is_numeric($_POST['place'])){
             script_error('位置必须是数字');
   	   }

       // $value = array_values($data);
   	   $data = $_POST;
   	    
       $data['create_time'] = time();
       // echo_print($_FILES);
       //图片上传
       if($_FILES['image']['name']){
         $data['image']  =	uploads('image');
       
       }

       
    
       // var_dump($data);die;
       $result  = insert_into('banner',$data);
       // var_dump($result);die;
       if($result){
       	  script_success('添加成功','index.php?mot=admin&ctl=banner&act=index');
       }else{
       	  script_error('添加失败');
       }
    }else{
        $sql = "select * from menu where category_id =0 and distinction=1";
        $arr = sql_list($mysqli,$sql);
    	include  VIEW.$_M.'/'.$_C.'/'.'edit.html';

    }

}

elseif($_A == 'edit'){

    if($_POST){
       echo_print($_POST);
       

       if(!is_numeric($_POST['place'])){
             script_error('位置必须是数字');
   	   }

       // $value = array_values($data);
   	   $data = $_POST;
   	   $id = $data['id'];
       unset($data['id']) ; 

       $data['create_time'] = date('Y-m-d',time())  ;
       // echo_print($_FILES);
       //图片上传
       if($_FILES['image']['name']){
         $data['image']  =	uploads('image');
       
       }

       
    
       // var_dump($data);die;
       $result  = edit_set('banner',$data,'id='.$id);
       // var_dump($result);die;
       if($result){
       	  script_success('修改成功','index.php?mot=admin&ctl=banner&act=index');
       }else{
       	  script_error('修改失败');
       }
    }else{
    	//查询要修改的数据
    	$id = $_GET['id'];
      // var_dump($id);die;
        $sql = "select * from banner where id ={$id}";
        $result = sql_one($mysqli,$sql);
        //banner分类
         $sql = "select * from menu where category_id =0 and distinction=1";
        $arr = sql_list($mysqli,$sql);
    	include  VIEW.$_M.'/'.$_C.'/'.'edit.html';

    }


}