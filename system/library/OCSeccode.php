<?php
/*
	more & original php framwork
	copyright (c) 2007 - 2008 ismole inc.

	$id: mooseccode.class.php 38 2008-03-19 07:39:17z aming $
*/

// !defined('IN_OCPHP') && exit('Access Denied');

class OCSeccode {
	//note:生成的验证码
	var $cecCode = '';
	//note:生成的图片
	var $codeImage = '';
	//note:干扰素
	var $disturColor = '';
	//note:验证码的图片宽度
	var $codeImageWidth = 80;
	//note:验证码的图片高度
	var $codeImageHeight  = 20;
	//note:验证码位数
	var $cecCodeNum = 4;
	
	/**
	 * 输出头部
	 *
	 * @return void
	 */
	function outHeader() {
		header("content-type: image/png");
	}
	
	/**
	 * 生成验证码
	 *
	 * @return void
	 */
	function createCode($num = '') {
		$this->cecCodeNum = (intval($num) > 0 ) ? $num : $this->cecCodeNum;
		$code='';
		$len = $this->cecCodeNum;
		for($i=0;$i<$len;$i++){
			$k=rand(1,8);
			switch($k){
				case 1:
					$code.=chr(rand(97,104));
					break;
				case 2:
					$code.=rand(2,9);
					break;
				case 3:
					$code.=chr(rand(109,110));
					break;
				case 4:
					$code.=rand(2,9);
					break;
				case 5:
					$code.=chr(rand(112,122));	
					break;
				case 6:
					$code.=rand(2,9);
					break;
				case 7:
					$code.=chr(rand(106,107));
					break;
				case 8:
					$code.=rand(2,9);
					break;
			}
		}
		$this->cecCode = strtoupper($code);
		//$this->cecCode = strtoupper(substr(md5(rand()), 0, $this->cecCodeNum));
		return $this->cecCode;
	}

	/**
	 * 生成验证码图片
	 *
	 * @return void
	 */
	function createImage() {
		$this->codeImage = @imagecreate($this->codeImageWidth, $this->codeImageHeight);
		imagecolorallocate($this->codeImage, 200, 200, 200);
		return $this->codeImage;
	}
	
	/**
	 * 加入图片干拢素
	 *
	 * @return void
	 */
	function setDisturbColor() {
		for ($i = 0; $i <= 128; $i++) {
			$this->disturColor = imagecolorallocate($this->codeImage, rand(0, 255), rand(0, 255), rand(0, 255));
			imagesetpixel($this->codeImage, rand(2, 128),rand(2, 38), $this->disturColor);
		}
	}

	/**
	 * 设置验证码图片的大小
	 *
	 * @param integer $width：
	 * @param integer $height：
	 * @return boolean;
	 */
	function setCodeImage($width, $height) {
		if($width == '' || $height == '') {
			return false;
		}
		$this->codeImageWidth = $width;
		$this->codeImageHeight = $height;
		return true;
	}

	/**
	 * 在图片上写入验证码
	 *
	 * @param integer $num
	 */
	function writeCodeToImage($num = '') {
		for($i = 0; $i < $this->cecCodeNum; $i++) {
			$bgColor = imagecolorallocate ($this->codeImage, rand(0, 255), rand(0, 128), rand(0, 255));
			$x = floor($this->codeImageWidth / $this->cecCodeNum) * $i;
			$y = rand(0, $this->codeImageHeight - 15);
			imagechar($this->codeImage, 5, $x, $y, $this->cecCode[$i], $bgColor);
		}
	}
	
	/**
	 * 把验证码的值写入session
	 *
	 * @param string $sessionName
	 */
	function writeSession($sessionName) {
		//session_start();
//		session_register($sessionName);
//		$_SESSION[$sessionName] = md5($this->cecCode);
		global $memcached;
		//$seccode=$this->cookie->OCAuthCode($this->request->cookie['oc_seccode'],'DECODE');
		// $seccode = MooGetGPC('seccode','string','C');
		
		$memcached->set('codeyzm',$this->cecCode);
		 // $memcached->replace('codeyzm',strtolower($this->cecCode),0,60);//注册码存cookie
	}

	/**
	 * 输出验证码图片
	 *
	 * @param integer $width
	 * @param integer $height
	 * @param integer $num
	 * @param string $sessionName
	 */
	function outCodeImage($width = '', $height = '' ,$num = '', $sessionName = 'OCCode') {
		if($width != '' || $height != '') {
			$this->setCodeImage($width, $height);
		}
		if($num != '') {
			$this->cecCodeNum = $num;
		}
		ob_clean();
		$this->outHeader();
		$this->createCode($num);
		$this->createImage();
		$this->setDisturbColor();
		$this->writeCodeToImage($num);
		$this->writeSession($sessionName);
		imagepng($this->codeImage);
		imagedestroy($this->codeImage);
	}
}