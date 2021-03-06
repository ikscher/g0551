<?php
/*
	More & Original PHP Framwork
	Copyright (c) 2007 - 2008 IsMole Inc.

	$Id: MooTemplate.class.php 386 2008-09-09 07:21:21Z kimi $
*/

// !defined('IN_OCPHP') && exit('Access Denied');

class OCTemplate {
	var $var_regexp = "\@?\\\$[a-zA-Z_][\\\$\w]*(?:\[[\w\-\.\"\'\[\]\$]+\])*";
	var $vtag_regexp = "\<\?php echo (\@?\\\$[a-zA-Z_][\\\$\w]*(?:\[[\w\-\.\"\'\[\]\$]+\])*)\;\?\>";
	var $const_regexp = "\{([\w]+)\}";
    static $output='';
	/**
	 *  读模板页进行替换后写入到cache页里
	 *
	 * @param string $tplfile ：模板源文件地址
	 * @param string $objfile ：模板cache文件地址
	 * @return string
	 */
	function complie($tplfile, $objfile) {

		$template = file_get_contents($tplfile);
		$template = $this->parse($template);
		$this->OCMakeDir(dirname($objfile));
		$this->OCWriteFile($objfile, $template, $mod = 'w', TRUE);

	}
	
	
	
	/**
	* PHP下递归创建目录的函数，使用示例MooMakeDir('D:\web\web/a/b/c/d/f');
	* @param string $dir - 需要创建的目录路径，可以是绝对路径或者相对路径
	* @return boolean 返回是否写入成功
	*/
	function OCMakeDir($dir) {
		return is_dir($dir) or ($this->OCMakeDir(dirname($dir)) and mkdir($dir, 0777)); 
	}
	
	/**
	* 写文件
	* @param string $file - 需要写入的文件，系统的绝对路径加文件名
	* @param string $content - 需要写入的内容
	* @param string $mod - 写入模式，默认为w
	* @param boolean $exit - 不能写入是否中断程序，默认为中断
	* @return boolean 返回是否写入成功
	*/
	function OCWriteFile($file, $content, $mod = 'w', $exit = TRUE) {
		 global $memcached;
		
		if(!$fp = fopen($file, $mod)) {
			if($exit) {
				exit('OCPHP File :<br>'.$file.'<br>Have no access to write!');
			} else {
				return false;
			}
		}else{
			$key = 'oc_wirte_file_'.md5($file);
			if ($memcached->get($key)){
				$i =0;
				while($i<60 && $memcached->get($key)){
					usleep(100);
					$i++;
				}
			}else{
				$memcached->set($key, true,0,5);
				flock($fp, 2);
				fwrite($fp, $content);
				fclose($fp);
				$memcached->delete($key);
			}
			return true;
		}
	}


	/**
	 *  解析模板标签
	 *
	 * @param string $template ：模板源文件内容
	 * @return string
	 */
	function parse($template) {

		$template = preg_replace("/\<\!\-\-\{(.+?)\}\-\-\>/s", "{\\1}", $template);//去除html注释符号<!---->
		$template = preg_replace("/\{($this->var_regexp)\}/", "<?php echo \\1;?>", $template);//替换带{}的变量
		$template = preg_replace("/\{($this->const_regexp)\}/", "<?php echo \\1;?>", $template);//替换带{}的常量
		$template = preg_replace("/(?<!\<\?php echo |\\\\)$this->var_regexp/", "<?php echo \\0;?>", $template);//替换重复的<?php echo
		$template = preg_replace("/\{php (.*?)\}/ies", "\$this->stripvTag('<?php \\1?>')", $template);//替换php标签
		$template = preg_replace("/\{for (.*?)\}/ies", "\$this->stripvTag('<?php for(\\1) {?>')", $template);//替换for标签
		$template = preg_replace("/\{elseif\s+(.+?)\}/ies", "\$this->stripvTag('<?php } elseif (\\1) { ?>')", $template);//替换elseif标签
		for($i=0; $i<3; $i++) {
			$template = preg_replace("/\{loop\s+$this->vtag_regexp\s+$this->vtag_regexp\s+$this->vtag_regexp\}(.+?)\{\/loop\}/ies", "\$this->loopSection('\\1', '\\2', '\\3', '\\4')", $template);
			$template = preg_replace("/\{loop\s+$this->vtag_regexp\s+$this->vtag_regexp\}(.+?)\{\/loop\}/ies", "\$this->loopSection('\\1', '', '\\2', '\\3')", $template);
		}
		$template = preg_replace("/\{if\s+(.+?)\}/ies", "\$this->stripvTag('<?php if(\\1) { ?>')", $template);//替换if标签
		$template = preg_replace("/\{include\s+(.*?)\}/is", "<?php include \\1; ?>", $template);//替换include标签
		$template = preg_replace("/\{template\s+([\w\/\.]+?)\s*}/is", "<?php include OCTemplate::template('\\1'); ?>", $template);//替换template标签
		//$template = preg_replace("/\{block (.*?)\}/ies", "\$this->stripBlock('\\1')", $template);//替换block标签
		$template = preg_replace("/\{else\}/is", "<?php } else { ?>", $template);//替换else标签
		$template = preg_replace("/\{\/if\}/is", "<?php } ?>", $template);//替换/if标签
		$template = preg_replace("/\{\/for\}/is", "<?php } ?>", $template);//替换/for标签
		$template = preg_replace("/$this->const_regexp/", "<?php echo \\1;?>", $template);//note {else} 也符合常量格式，此处要注意先后顺??
		$template = preg_replace("/(\\\$[a-zA-Z_]\w+\[)([a-zA-Z_]\w+)\]/i", "\\1'\\2']", $template);//将二维数组替换成带单引号的标准模式
		/* $template = "<?php if(!defined('IN_MOOPHP')) exit('Access Denied');?>\r\n$template"; */

		return $template;
	}
	
	


	/**
	 * 正则表达式匹配替换
	 *
	 * @param string $s ：
	 * @return string
	 */
	function stripvTag($s) {
		return preg_replace("/$this->vtag_regexp/is", "\\1", str_replace("\\\"", '"', $s));
	}

	function stripTagQuotes($expr) {
		$expr = preg_replace("/\<\?php echo (\\\$.+?);\?\>/s", "{\\1}", $expr);
		$expr = str_replace("\\\"", "\"", preg_replace("/\[\'([a-zA-Z0-9_\-\.\x7f-\xff]+)\'\]/s", "[\\1]", $expr));
		return $expr;
	}
	/**
	 * 将模板中的块替换成BLOCK函数
	 *
	 * @param string $blockname ：
	 * @param string $parameter ：
	 * @return string
	 */
	function stripBlock($parameter) {
		return $this->stripTagQuotes("<?php Mooblock(\"$parameter\"); ?>");
	}

	/**
	 * 替换模板中的LOOP循环
	 *
	 * @param string $arr ：
	 * @param string $k ：
	 * @param string $v ：
	 * @param string $statement ：
	 * @return string
	 */
	function loopSection($arr, $k, $v, $statement) {
		$arr = $this->stripvTag($arr);
		$k = $this->stripvTag($k);
		$v = $this->stripvTag($v);
		$statement = str_replace("\\\"", '"', $statement);
		return $k ? "<?php foreach((array)$arr as $k=>$v) {?>$statement<?php }?>" : "<?php foreach((array)$arr as $v) {?>$statement<?php } ?>";
	}
}