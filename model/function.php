<?php
	//封装查询一个信息的函数

	function sql_one($mysqli,$sql){

		$result = mysqli_query($mysqli,$sql);
	    // var_dump($result);
	    if ($result) {
	    	return mysqli_fetch_assoc($result);
	    }else{
	    	return false;
	    }
		
	}

	//封装查询所有信息的函数

	function sql_list($mysqli,$sql){

		$result = mysqli_query($mysqli,$sql);

		// var_dump($result);die;

		$arr = [];

		if ($result) {
			while ($row = mysqli_fetch_assoc($result)){
				$arr[] = $row;
			}
		}else{
			$arr = false;
		}
		return $arr;
	}

	//封装增加一个信息的函数

	function sql_increase($mysqli,$sql){

		$result = mysqli_query($mysqli,$sql);

		// var_dump($result);

		if ($result) {
			return mysqli_insert_id($mysqli);
		}else{
			return false;
		}
	}

	//封装修改一个信息的函数

	function sql_modify($mysqli,$sql){

		$result = mysqli_query($mysqli,$sql);
		// var_dump($result);die;

		if ($result) {
			return $result;
		}else{
			return false;
		}
	}

	//封装删除一个信息的函数 

	function sql_delete($mysqli,$sql){

		$result = mysqli_query($mysqli,$sql);

		if ($result) {
			return $result;
		}else{
			return false;
		}
	}


	function category_tree($pid = 0,$num = 0,$str ='&nbsp;|-',$table='menu',$filed='*',$arr=array(),$file='menu',$id='id',$where=''){
		static $arr;
		global $mysqli;
		$sql="select {$filed} from {$table} where category_id={$pid}";
		if($where !=''){
			$sql .= " and $where";
		}
		 // var_dump($sql);die;
		$result = sql_list($mysqli,$sql);
			$num++;
				foreach ($result as $key => $value) {
					// $value['menu'] = str_repeat($str,$num).$value['menu'];
					$arr[] = $value;
						category_tree($value[$id],$num,$str,$table,$filed,$arr,$file,$id,$where);
				}
				return $arr;
	}



function insert_into($table,$data){
      global $mysqli;
      if(!is_array($data)){
          return false;
      }
      $keys = '';
      $values ='';
      foreach ($data as $key => $value) {  //key k e y  k,e,y, y,
                   $keys .= $key.',';
                   $values .= "'".$value."',";
      }
      $keys = rtrim($keys,',');
      $values = rtrim($values,',');
      $sql = "insert into $table($keys) values($values)";
              // echo $sql;
              // die;
      return sql_insert($mysqli,$sql);  //添加用用户
}

function edit_set($table,$data,$where){
      global $mysqli;
      if(!is_array($data)){
          return false;
      }
      $keys   = '';
     
      foreach ($data as $key => $value) {
        $keys   .= $key."='".$value."',";
      
      }
     
      $keys   = rtrim($keys,',');
   
     

      $sql = "update {$table} set $keys where $where";
      // echo $sql;die;
      return sql_modify($mysqli,$sql);//修改
}

function CountNum($table,$where='',$count='count',$filed='id'){
   // $where ='';
   global $mysqli;

    $sql = "select count($filed) as $count from $table";
     // echo $sql;
   if($where != ''){
    $sql .=" where $where";

   }

   $result = mysqli_query($mysqli,$sql);
   // var_dump($result);die;
   //执行sql语句
   if($result){

     return mysqli_fetch_assoc($result);
     //取出结果集一条数据  有数据会取出结果，没数据输出一个NULL值
   }else{

    return false;
   }

}



function sql_all($table,$where='',$order='',$limit='',$filed='*'){
    //查询多条
    global $mysqli;

    $sql ="select $filed from $table";
    
    if($where != ''){
       $sql .=" where $where";
    }

    $sql .= $order != ''? " order by $order"  :'';
    $sql .= $limit != ''? " limit $limit"  :'';


    $result  = mysqli_query($mysqli,$sql); //执行sql语句

    $arr = [];
    if($result){
      
      while($row =mysqli_fetch_assoc($result)){
          $arr[]= $row;
      }
    }else{
            $arr = false;
    }
    return $arr;
}