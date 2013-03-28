<?php
/*
 * Created by ikol on 2012-9-27
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

class Cookie{

	/**
	* 采用RC4为核心算法，通过加密或者解密用户信息
	* @param $string - 加密或解密的串
	* @param $operation - DECODE 解密；ENCODE 加密
	* @param $key - 密钥 默认为OP_AUTHKEY常量
	* @return 返回字符串
	*/
	public function OCAuthCode($string, $operation = 'DECODE', $key = '', $expiry = 0) {

	    /**
	    * $ckey_length 随机密钥长度 取值 0-32;
	    * 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
	    * 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
	    * 当此值为 0 时，则不产生随机密钥
	    */
	    $ckey_length = 0;
	    $key = md5($key ? $key : md5(OC_AUTHKEY.$_SERVER['HTTP_USER_AGENT']));
	    $keya = md5(substr($key, 0, 16));
	    $keyb = md5(substr($key, 16, 16));
	    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

	    $cryptkey = $keya.md5($keya.$keyc);
	    $key_length = strlen($cryptkey);

	    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	    $string_length = strlen($string);

	    $result = '';
	    $box = range(0, 255);

	    $rndkey = array();
	    for($i = 0; $i <= 255; $i++) {
	        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
	    }

	    for($j = $i = 0; $i < 256; $i++) {
	        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
	        $tmp = $box[$i];
	        $box[$i] = $box[$j];
	        $box[$j] = $tmp;
	    }

	    for($a = $j = $i = 0; $i < $string_length; $i++) {
	        $a = ($a + 1) % 256;
	        $j = ($j + $box[$a]) % 256;
	        $tmp = $box[$a];
	        $box[$a] = $box[$j];
	        $box[$j] = $tmp;
	        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	    }
	    if($operation == 'DECODE') {
	        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
	            return substr($result, 26);
	        } else {
	            return '';
	        }
	    } else {
	        return $keyc.str_replace('=', '', base64_encode($result));
	    }

	}




	/**
	* 设置cookie
	* @param $var - 变量名
	* @param $value - 变量值
	* @param $life - 生命周期期
	* @param $prefix - 前缀
	*/
	public function OCSetCookie($var, $value, $life=0, $prefix = 1) {
	   
	   	setcookie(($prefix ? OC_COOKIE_PRE : '').$var, $value, $life?time()+$life:0, OC_COOKIE_PATH, OC_COOKIE_DOMAIN, $_SERVER['SERVER_PORT'] == 443 ? 1 : 0);
	}
	
}
?>
