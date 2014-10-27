<?php 
/**
* @file index.php
* @brief 
* web continuous develop  
*
* @author zhenzhou.ou 
* @version 1.0
* @date 2014-10-27
*/ 

error_reporting(E_ALL & ~E_NOTICE);
define("DR",DIRECTORY_SEPARATOR);
define('BASE_PATH',__DIR__.DR);

require(BASE_PATH.'Libs'.DR.'framework.class.php');
require(BASE_PATH.'Libs'.DR.'global.func.php');

$class    = trim($_GET['c'])? $_GET['c'] : 'test';
$function = trim($_GET['f'])? $_GET['f'] : 'index';

$path  = BASE_PATH.$class.'.class.php';
//set in route
if(isset($_GET['platform']) && $_GET['platform'] == 'test'){
	//check ip
	$internal_ip = array('192.168.1.1','127.0.0.1');
	if(!in_array(get_ip(),$internal_ip)){
		exit('IP ACCESS DENYID');
	}
	//check user
	$username         = 'test';
	$allowed_username = array('test','test1');
	if(!in_array($username,$allowed_username)){
		exit('User ACCESS DENYID');
	}
	//check class
	$allowed_class = array('test','ClassTest');
	if(!in_array($class,$allowed_class)){
		exit('Class ACCESS DENYID');
	}
	//verify request class file
	if(file_exists(BASE_PATH.'cdClass'.DR.'test_'.$class.'.class.php')){
		$class = 'test_'.$class;
		$path  = BASE_PATH.'cdClass'.DR.$class.'.class.php';
	}
}

spl_autoload_register('autoload');

//load class and instance
//echo $path;
if(!file_exists($path)){
	exit('CLASS NOT EXISTS');
}

require($path);

try{
	$params            = array();
	$organized_params  = array();
	$params            = array_merge($_GET,$_POST);
	$reflection        = new ReflectionClass($class);
	$reflection_params = $reflection->getMethod($function)->getParameters();
	foreach($reflection_params as &$param){
		if(array_key_exists($param->name,$params)){
			$organized_params[$param->name] = $params[$param->name];
		}else{
			$organized_params[$param->name] = '';
		}
	}
	$service = $reflection->newInstanceArgs();
	call_user_func_array(array($service,$function),$organized_params);
}catch(Exception $e){
	echo $e->getMessage();
}


die;//over 



