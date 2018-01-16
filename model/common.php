<?php

	function script_success($mgs,$url){
    
    	echo "<script>alert('".$mgs."');window.location.href='".$url."';</script>";
		exit();
}


	function script_error($mgs){
		echo "<script>alert('".$mgs."');history.back();</script>";
		exit();
}	

	function view($model,$controller,$action,$data=array()){

		extract($data);
		include VIEW.$model.'/'.$controller.'/'.$action.'.html';

	}

	function echo_sql($sql){
		echo $sql;
		exit ();
	}

	function echo_print($name,$type=1){

	    if(is_string($name)){
	        echo '<pre>';
	        echo $name;
	        echo '</pre>';
	        die;
	    }
	    elseif(is_array($name) && $type==1){
	        echo '<pre>';
	        echo '<div style="width:80%;border:2px solid #000;box-shadow:20%；border-radius:20%">';
	        print_r($name);
	        echo '</div>';
	        echo '</pre>';
	        die;
	    }
	    else if(is_array($name)){
	        echo '<pre>';
	        echo '<div style="width:80%;border:2px solid #000;box-shadow:20%">';
	        var_dump($name);
	        echo '</div>';
	        echo '</pre>';
	        die;
	    }
	}