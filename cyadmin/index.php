<?php
// Version
define('VERSION', '1.5.4');

date_default_timezone_set('asia/shanghai');
/**
 * return string;
 */
function GetIP(){
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

$allow_ip = array('60.166.168.176');
$cur_ip = GetIP();

if(!in_array($cur_ip,$allow_ip))
{
	$allow_ip_bool = false;
	if(strpos($cur_ip,'192.168') === false)
	{
		if(preg_match('/^10\.20\.[0-9]{1,3}\.[0-9]{1,3}$/',$cur_ip) !== 0)
		{
			$allow_ip_bool = true;
		}
	}else $allow_ip_bool = true;
	
	if(!$allow_ip_bool)
	{
		echo 'Go OUT -- '.$cur_ip;
		exit;
	}
}

// Configuration
require_once('config.php');

// Install 
/* if (!defined('DIR_APPLICATION')) {
	header('Location: ../install/index.php');
	exit;
} */


// Startup
require_once(DIR_SYSTEM . 'startup.php');

// Application Classes
// require_once(DIR_SYSTEM . 'library/currency.php');
require_once(DIR_SYSTEM . 'library/user.php');
require_once(DIR_SYSTEM . 'library/weight.php');
require_once(DIR_SYSTEM . 'library/length.php');

// Registry
$registry = new Registry();

// Loader
$loader = new Loader($registry);
$registry->set('load', $loader);

// Config
$config = new Config();
$registry->set('config', $config);

// Database
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$registry->set('db', $db);
		
// Settings
$query = $db->query("SELECT * FROM " . DB_PREFIX . "setting ");
 
foreach ($query->rows as $setting) {
	if (!$setting['serialized']) {
		$config->set($setting['key'], $setting['value']);
	} else {
		$config->set($setting['key'], unserialize($setting['value']));
	}
}

// Url
$url = new Url(HTTP_SERVER, $config->get('config_use_ssl') ? HTTPS_SERVER : HTTP_SERVER);	
$registry->set('url', $url);
		
// Log 
$log = new Log($config->get('config_error_filename'));
$registry->set('log', $log);

function error_handler($errno, $errstr, $errfile, $errline) {
	global $log, $config;
	
	switch ($errno) {
		case E_NOTICE:
		case E_USER_NOTICE:
			$error = 'Notice';
			break;
		case E_WARNING:
		case E_USER_WARNING:
			$error = 'Warning';
			break;
		case E_ERROR:
		case E_USER_ERROR:
			$error = 'Fatal Error';
			break;
		default:
			$error = 'Unknown';
			break;
	}
		
	if ($config->get('config_error_display')) {
		echo '<b>' . $error . '</b>: ' . $errstr . ' in <b>' . $errfile . '</b> on line <b>' . $errline . '</b>';
	}
	
	if ($config->get('config_error_log')) {
		$log->write('PHP ' . $error . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
	}

	return true;
}

// Error Handler
set_error_handler('error_handler');
		
// Request
$request = new Request();
$registry->set('request', $request);

// Response
$response = new Response();
$response->addHeader('Content-Type: text/html; charset=utf-8');
$registry->set('response', $response); 

// Cache
$cache = new Cache();
$registry->set('cache', $cache); 

// Session
$session = new Session();
$registry->set('session', $session); 

//cookie
$cookie=new Cookie();
$registry->set('cookie',$cookie);

//memcache
if(OCPHP_ALLOW_MEMCACHED) {
    $memcached = new Memcache;
    $memcached->connect(MEMCACHEHOST, MEMCACHEPORT);

    $registry->set('memcached',$memcached);
}


// Language

$languages = array();

// Language	
$language = new Language('chinese');
$language->load('chinese');	

$registry->set('language', $language); 		 


// Document
$registry->set('document', new Document()); 		
		
// Currency
// $registry->set('currency', new Currency($registry));		
		
// Weight
$registry->set('weight', new Weight($registry));

// Length
$registry->set('length', new Length($registry));

// User
$registry->set('user', new User($registry));
						
// Front Controller
$controller = new Front($registry);

// Login
$controller->addPreAction(new Action('common/home/login'));

// Permission
$controller->addPreAction(new Action('common/home/permission'));

// Router
if (isset($request->get['route'])) {
	$action = new Action($request->get['route']);
} else {
	$action = new Action('common/home');
}


// Dispatch
$controller->dispatch($action, new Action('error/not_found'));

// Output
$response->output();
?>