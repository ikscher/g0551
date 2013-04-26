<?php
abstract class Controller {
	protected $registry;
	protected $id;
	protected $layout;
	protected $template;
	protected $children = array();
	protected $data = array();
	protected $output;

	public function __construct($registry) {
		$this->registry = $registry;
	}

	public function __get($key) {
		return $this->registry->get($key);
	}

	public function __set($key, $value) {
		$this->registry->set($key, $value);
	}

	protected function forward($route, $args = array()) {
		return new Action($route, $args);
	}

	protected function redirect($url, $status = 302) {
		header('Status: ' . $status);
		header('Location: ' . str_replace('&amp;', '&', $url));
		exit();
	}

	protected function showMessage($info, $url = '') {
		header('Content-Type: text/html; charset=utf-8');
		if($url==''){
			echo '<script type="text/javascript">alert("'. $info .'");history.back();</script>';
		}else{
			echo '<script type="text/javascript">alert("'. $info .'");location.href="'. $url .'";</script>';
		}
		exit();
	}
	
	
	

	protected function getChild($child, $args = array()) {
		$action = new Action($child, $args);
		$file = $action->getFile();
		$class = $action->getClass();
		$method = $action->getMethod();

		if (file_exists($file)) {
			require_once($file);

			$controller = new $class($this->registry);

			$controller->$method($args);

			return $controller->output;
		} else {
			trigger_error('Error: Could not load controller ' . $child . '!');
			exit();
		}
	}
	
	

	protected function render() {
	    if(!empty($this->children)){
			foreach ($this->children as $child) {
				$this->data[basename($child)] = $this->getChild($child);
			}
        }
        extract($this->data);
		
	    $path=preg_replace("/\.html|\.htm/ui","",$this->template);
		$tpl_path=DIR_TEMPLATE . $this->template;
        $php_path = DIR_DATA.$path.'.tpl.php';
		
		
		if(!file_exists($php_path) || filemtime($tpl_path) > filemtime($php_path)) {
   
			//template
			$T=new OCTemplate();
			$T->complie($tpl_path, $php_path);

    	} 
	
		ob_start();
 
		require($php_path);

		$this->output = ob_get_contents();

		ob_end_clean();

		return $this->output;
		
		
		/* if (file_exists(DIR_TEMPLATE . $this->template)) {
			extract($this->data);

      		ob_start();

	  		require(DIR_TEMPLATE . $this->template);

	  		$this->output = ob_get_contents();

      		ob_end_clean();

			return $this->output;
    	} else {
			trigger_error('Error: Could not load template ' . DIR_TEMPLATE . $this->template . '!');
			exit();
    	} */
	}
}
?>