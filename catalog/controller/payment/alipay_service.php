<?php
require_once("alipay_function.php");

class alipay_service {

    var $gateway;			
    var $_key;				
    var $mysign;			
    var $sign_type;			
    var $parameter;			
    var $_input_charset;   

  
    function alipay_service($parameter,$key,$sign_type) {
        $this->gateway		= "https://www.alipay.com/cooperate/gateway.do?";
		// $this->getway       ='https://mapi.alipay.com/gateway.do?';
        $this->_key			= $key;
        $this->sign_type	= $sign_type;
        $preParameter		= para_filter($parameter);

        if($parameter['_input_charset'] == '')
            $this->parameter['_input_charset'] = 'GBK';

        $this->_input_charset   = $this->parameter['_input_charset'];

       
        $this->parameter = arg_sort($preParameter);    
        $this->mysign = build_mysign($this->parameter,$this->_key,$this->sign_type);
    }


	function build_url() {
		$url        = $this->gateway;
		$sort_array = array();
		$arg        = "";
		$sort_array = arg_sort($this->parameter);
		while (list ($key, $val) = each ($sort_array)) {
			$arg.=$key."=".urlencode(charset_encode($val,$this->parameter['_input_charset']))."&";
		}
		$url.= $arg."sign=" .$this->mysign ."&sign_type=".$this->sign_type;
		return $url;

	}
}
?>