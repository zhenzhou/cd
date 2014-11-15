<?php 
/**
* @file game.php
* @brief 
* game continuous develop  
*
* @author zhenzhou.ou 
* @version 1.0
* @date 2014-10-29
*/ 

error_reporting(E_ALL & ~E_NOTICE);
define("DR",DIRECTORY_SEPARATOR);
define('BASE_PATH',__DIR__.DR);

require(BASE_PATH.'Libs'.DR.'framework.class.php');
require(BASE_PATH.'Libs'.DR.'global.func.php');

$class    = trim($_GET['c'])? $_GET['c'] : 'test';
$function = trim($_GET['f'])? $_GET['f'] : 'index';
$version  = trim($_GET['v'])? $_GET['v'] : '';

if(!file_exists(BASE_PATH.$class.'.class.php')){
	exit($class.' NOT EXISTS');
}
require(BASE_PATH.$class.'.class.php');
//set in route
if(isset($_GET['v'])){
	
	//load version class
	$files = scandir(BASE_PATH.'version');
	printr($files);
	$res = array();
	foreach($files as $file){
		if(!in_array($file,array('.','..')) && is_dir(BASE_PATH.'version'.DR.$file.DR)){
			$res[] = $file;
		}
	}
	natsort($res);
	printr($res);
	$vclass = $class;
	foreach($res as $dir){
		if($dir > $version){
			break;
		}
		if(file_exists(BASE_PATH.'version'.DR.$dir.DR.$vclass.'_'.$dir.'.class.php')){
			_echo(BASE_PATH.'version'.DR.$dir.DR.$vclass.'_'.$dir.'.class.php');
			require(BASE_PATH.'version'.DR.$dir.DR.$vclass.'_'.$dir.'.class.php');
			$class = $vclass.'_'.str_replace('.','',$dir);
		}
	}

}

spl_autoload_register('autoload');

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




