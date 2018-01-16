<?php 

//头部导航栏遍历

$sql = "select * from menu where category_id=0 and distinction=1 and display=1 order by place asc";

$menu_list = sql_list($mysqli,$sql);
// var_dump($menu_list);die;


foreach ($menu_list as $key => $value) {
	// var_dump($value['action']);
	if (isset($value['controller']) or isset($value['action'])){
		$menu_list[$key]['urls'] = "index.php?mot={$_M}&ctl={$value['controller']}&act={$value['action']}";
	}
	// var_dump($menu);
	
}
// var_dump(count($menu));
// var_dump($menu);die;

//banner图遍历
	switch ($_C) {
		case 'index':
			$cate_id = 79;
			break;
		
		case 'about':
			$cate_id = 82;
			break;
		
		case 'news':
			$cate_id = 81;
			break;
		
		case 'news_details':
			$cate_id = 83;
			break;
		
		case 'porducts':
			$cate_id = 84;
			break;
		
		case 'por_details':
			$cate_id = 85;
			break;
		
		case 'contact':
			$cate_id = 86;
			break;
		
	}


	$sql= "select * from banner where cate_id={$cate_id}";
	$banner = sql_list($mysqli,$sql);
	// var_dump($banner);


//头部logo遍历


	$sql = "select logo from contact where 1 ";
	// var_dump($sql);
	$logo = sql_one($mysqli,$sql);
	// var_dump($logo);

//微信二维码遍历

	$sql = "select 2dcode from contact where 1";
	$code = sql_one($mysqli,$sql);

//底部版权备案号遍历

	$sql = "select * from contact where 1 ";
	$bq = sql_one($mysqli,$sql);

include VIEW.$_M.'/header.html';
include VIEW.$_M.'/'.$_C.'.html';
include VIEW.$_M.'/footer.html';

