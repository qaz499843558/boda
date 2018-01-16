<?php
//图片上传
function uploads($name='image',$upload = 'upload/'){
       	     $array = ['image/jpeg','image/png','image/gif']; 
		       if($_FILES[$name]['name']){ //判断是否存在文件名
		          if(in_array($_FILES[$name]['type'],$array)){ //判断是否为图片文件
		          	   if($_FILES[$name]['size']<2097152){//判断大小范图
		          	   	     // echo_print($_FILES['image']['name']);
		          	   	     $ext = strripos($_FILES[$name]['name'],'.');
		          	   	     $exts = substr($_FILES[$name]['name'],$ext);
		          	   	     // var_dump($exts);die;
		          	   	     
		          	   	     if(!file_exists($upload)){
		          	   	     	mkdir($upload,0777); //生成目录 0777最高权限 可读 可写
		          	   	     }
		          	   	     $files = $upload.rand(10000,99999).date('Ymd',time()).$exts;
		          	   	     $image = move_uploaded_file($_FILES[$name]['tmp_name'],$files);
		                    
		          	   	     // var_dump($image);die;
		          	   }
		          }
		       }
		       return $files;
}