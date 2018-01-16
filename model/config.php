<?php
	
	function db(){

		global $mysqli;

		$mysqli = @mysqli_connect(DBHOST,DBUSER,DBPASSWORD,DBNAME);

		mysqli_set_charset($mysqli,CHARSET);

		if(mysqli_connect_errno()){ 

		echo '数据库连接不上：'. mysqli_connect_error();
		
	}

}