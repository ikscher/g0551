<?php
// HTTP
 // define('HTTP_SERVER', 'http://www.g0551.com/');
define('HTTP_SERVER', 'http://test.cy0551.com/cy/');
define('HTTP_IMAGE', HTTP_SERVER.'image/');

define('HTTP_ADMIN', HTTP_SERVER.'admin/');

// HTTPS
// define('HTTPS_SERVER', 'https://www.g0551.com/');
define('HTTPS_SERVER', 'https://test.cy0551.com/cy/');
define('HTTPS_IMAGE', HTTPS_SERVER.'/image/');

// DIR
define('DIR_APPLICATION', './catalog/');
define('DIR_SYSTEM', './system/');
define('DIR_DATABASE', './system/database/');
define('DIR_LANGUAGE', './catalog/language/');
define('DIR_TEMPLATE', './catalog/view/theme/');
define('DIR_CONFIG', './system/config/');
define('DIR_IMAGE', './image/');
define('DIR_CACHE', './system/cache/');
define('DIR_DOWNLOAD', './download/');
define('DIR_LOGS', './system/logs/');
define('DIR_DATA','./data/');//模板缓存路径

// DB
define('DB_DRIVER', 'mysql');

define('DB_HOSTNAME', '127.0.0.1');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '123456');
define('DB_DATABASE', 'g0551'); 


/* define('DB_HOSTNAME', '192.168.1.252');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_DATABASE', 'opencart'); */

define('DB_PREFIX', '');
?>
