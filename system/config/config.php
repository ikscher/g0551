<?php
/*
 * Created by ikol on 2012-9-27
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

    DEFINE("OC_AUTHKEY","CY0551"); //COOKIE AUTH KEY

    //note 定义cookie前缀
	define('OC_COOKIE_PRE', 'oc_');
	//note 定义cookie作用域
	define('OC_COOKIE_PATH', '/');
	//note 定义cookie作用路径
	//define('OC_COOKIE_DOMAIN', 'g0551.com');
	define('OC_COOKIE_DOMAIN', 'cy0551.com');
	
	
	//是否允许开启缓存
	define('OCPHP_ALLOW_MEMCACHED',true);

	//note memcached 主机名
	define('MEMCACHEHOST', '127.0.0.1');
	//note memcached 端口
	define('MEMCACHEPORT', '11211');
	//note  memcached  生命周期
	define('MEMCACHELIFE', '60');
	
	
	//订单状态：
	DEFINE('ORDER_CREATED',1);
	define('ORDER_WAITING',2);
	define('ORDER_DETACHING',3);
	DEFINE('ORDER_OVER',4);
	DEFINE('ORDER_SUCCESS',5);
	DEFINE('ORDER_CLOSE',6);
	DEFINE('ORDER_REFUND',7);
	DEFINE('ORDER_ERROR',9);
	

?>
