<?php
  /**
   * 公共函数库
   */
class Func{
	/**
	* 根据中文裁减字符串
	* @param string $string - 待截取的字符串
	* @param integer $length - 截取字符串的长度
	* @param string $dot - 缩略后缀
	* @return string 返回带省略号被裁减好的字符串
	*/
	public function OcCutstr($string, $length, $dot = ' ...', $charset = 'utf-8') {
		//global $charset;

		if(strlen($string) <= $length) {
			return $string;
		}
		$string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;','。'), array('&', '"', '<', '>',''), $string);
		$strcut = '';
		if(strtolower($charset) == 'utf-8') {
			$n = $tn = $noc = 0;
			while($n < strlen($string)) {
				$t = ord($string[$n]);
				if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
					$tn = 1; $n++; $noc++;
				} elseif (194 <= $t && $t <= 223) {
					$tn = 2; $n += 2; $noc += 2;
				} elseif (224 <= $t && $t < 239) {
					$tn = 3; $n += 3; $noc += 2;
				} elseif (240 <= $t && $t <= 247) {
					$tn = 4; $n += 4; $noc += 2;
				} elseif (248 <= $t && $t <= 251) {
					$tn = 5; $n += 5; $noc += 2;
				} elseif ($t == 252 || $t == 253) {
					$tn = 6; $n += 6; $noc += 2;
				} else {
					$n++;
				}
				if($noc >= $length) {
					break;
				}
			}
			if($noc > $length) {
				$n -= $tn;
			}
			$strcut = substr($string, 0, $n);
		} else {
			for($i = 0; $i < $length; $i++) {
				$strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
			}
		}
		$strcut = str_replace(array('&', '"', '<', '>','。'), array('&amp;', '&quot;', '&lt;', '&gt;',''), $strcut);

		return $strcut.$dot;
	}
	
	
	/*属性组对应的类别*/
    function getCategoryType($type){
        $str='';
		switch($type){
		    case 1:
		        $str="衣";
			    break;
			case "2":
			    $str="食";
			    break;
		    case "3":
			    $str="住";
			    break;
		    case "4":
			    $str="行";
			    break;
		    case "5":
			    $str="爽";
			    break;
		}

        return $str;
    }	
	
	
	/**
	 * 获得IP
	 * return string;
	 */
	public function GetIP(){
		if(empty($_SERVER["HTTP_CDN_SRC_IP"])){
			if(!empty($_SERVER["HTTP_CLIENT_IP"])) { $cip = $_SERVER["HTTP_CLIENT_IP"]; }
			else if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) { $cip = $_SERVER["HTTP_X_FORWARDED_FOR"]; }
			else if(!empty($_SERVER["REMOTE_ADDR"])) { $cip = $_SERVER["REMOTE_ADDR"]; }
			else $cip = "";
		}else{
			$cip = $_SERVER["HTTP_CDN_SRC_IP"];
		}
		preg_match("/[\d\.]{7,15}/", $cip, $cips);
		$cip = $cips[0] ? $cips[0] : 'unknown';
		unset($cips);
		return $cip;
	} 
	


}






?>