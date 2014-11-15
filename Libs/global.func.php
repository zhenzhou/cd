<?php 



/**
* @brief autoload 
* load class/func
*
* @param $class
*
* @return true/null
*/ 
function autoload($class){
	if(file_exists(BASE_PATH.$class)){
		include(BASE_PATH.$class);
		return true;
	}
	if(file_exists(BASE_PATH.'cdClass'.DR.$class)){
		include(BASE_PATH.'cdClass'.DR.$class);
		return true;
	}
}

/**
 * @brief get_ip 
 * get user ip
 *
 * @return string
 */ 
function get_ip() {
	static $ip = false;
	if ($ip !== false) return $ip;
	foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $aah) {
		if (!isset($_SERVER[$aah])) continue;
		$cur2ip = $_SERVER[$aah];
		$curip = explode('.', $cur2ip);
		if (count($curip) !== 4)  break; // If they've sent at least one invalid IP, break out
		foreach ($curip as $sup)
			if (($sup = intval($sup)) < 0 or $sup > 255)
				break 2;
		$curip_bin = $curip[0] << 24 | $curip[1] << 16 | $curip[2] << 8 | $curip[3];
		foreach (array(
			//    hexadecimal ip  ip mask
			array(0x7F000001,     0xFFFF0000), // 127.0.*.*
			array(0x0A000000,     0xFFFF0000), // 10.0.*.*
			array(0xC0A80000,     0xFFFF0000), // 192.168.*.*
		) as $ipmask) {
			if (($curip_bin & $ipmask[1]) === ($ipmask[0] & $ipmask[1])) break 2;
		}
		return $ip = $cur2ip;
	}
	return $ip = $_SERVER['REMOTE_ADDR'];
}


/**
 * 测试输出print_r
 * @param mixed $value 测试对象或数组等
 * return mixed
 */
function printr($value) {
	echo "<pre>";
	print_r ( $value );
	echo "</pre>";
}

/**
 * 测试输出
 * @param mixed  $value 测试变量等
 * @param string $key   测试变量名
 * return mixed
 */
function _echo($value,$key='') {

	echo '<hr>', $key . " : " . $value, '<hr>';

}




