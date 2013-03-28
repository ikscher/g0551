<?php 
class ControllerMerchantsMerchants extends Controller { 
	public function index() {
    	if (!$this->customer->isLogged()) {
	  		$this->session->data['redirect'] = $this->url->link('account/address', '', 'SSL');

	  		$this->redirect($this->url->link('account/login', '', 'SSL')); 
    	} 
		
		
		
		$this->load->model('merchants/merchants');
		$result=$this->model_merchants_merchants->getInfo();
		
		
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = HTTPS_IMAGE;
		} else {
			$server = HTTP_IMAGE;
		}

		if(empty($result['logo'])){
			$this->data["logo_url"]="catalog/view/theme/default/image/store_sample.jpg";
		}else{
			$this->data["logo_url"]=$server.$result["logo"];
		}
		
		$this->data["info"]=$result;
		
		$this->children = array(
			'merchants/left',
			'merchants/footer',
			'merchants/header'		
		);
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/merchants/merchants.html')) {
			$this->template = $this->config->get('config_template') . '/template/merchants/merchants.html';
		} else {
			$this->template = 'default/template/merchants/merchants.html';
		}
		
		$this->response->setOutput($this->render());
  	}
	
	/**
	*  保存店铺信息
	*/
  	public function insert() {
    	if (!$this->customer->isLogged()) {
	  		$this->session->data['redirect'] = $this->url->link('merchants/merchants', '', 'SSL');
	  		$this->redirect($this->url->link('account/login', '', 'SSL')); 
    	} 
		
		//服务器端验证
		$name   =isset($this->request->post["name"])?$this->request->post["name"]:"";
		$province   =isset($this->request->post["province"])?$this->request->post["province"]:"";
		$city   =isset($this->request->post["city"])?$this->request->post["city"]:"";
		$address    =isset($this->request->post["address"])?$this->request->post["address"]:"";
		/* $zone  =isset($this->request->post["zone"])?$this->request->post["zone"]:""; */
		$tel  =isset($this->request->post["tel"])?$this->request->post["tel"]:"";
		$mobile  =isset($this->request->post["mobile"])?$this->request->post["mobile"]:"";
		$fax    =isset($this->request->post["fax"])?$this->request->post["fax"]:"";
		$owner   =isset($this->request->post["owner"])?$this->request->post["owner"]:"";
		$introduce   =isset($this->request->post["introduce"])?$this->request->post["introduce"]:"";
	    $map_x   =isset($this->request->post["map_x"])?$this->request->post["map_x"]:117.294630;
	    $map_y   =isset($this->request->post["map_y"])?$this->request->post["map_y"]:31.866819;
		$logo_url     =isset($this->request->post["logo_url"])?$this->request->post["logo_url"]:"";
		$createtime=strtotime("now");
		
		if($name=="")$this->showMessage("对不起，店铺名称必须填写！");
		if($province=="")$this->showMessage("对不起，请选择所在省份！");
		if($city=="")$this->showMessage("对不起，请选择所在城市！");
		if($address=="")$this->showMessage("对不起，店铺地址必须填写！");
		if($tel=="")$this->showMessage("对不起，联系电话必须填写！");
		if($mobile=="")$this->showMessage("对不起，手机号码必须填写！");
		if($owner=="")$this->showMessage("对不起，店主姓名必须填写！");
		if($introduce=="")$this->showMessage("对不起，店铺介绍必须填写！");

		if($logo_url!="") $logo_url=preg_replace("/(\w*)(\/?)image\//","",$logo_url);
		
		$data=array(
			"name"=>$name,
			"province"=>$province,
			"city"=>$city,
			"address"=>$address,

			"tel"=>$tel,
			"mobile"=>$mobile,
			"fax"=>$fax,
			"owner"=>$owner,
			"introduce"=>$introduce,
			"map_x"=>$map_x,
			"map_y"=>$map_y,
			"logo_url"=>$logo_url,
			"createtime"=>$createtime
		);

		$this->document->setTitle('店铺信息提交');
		
		$this->load->model('merchants/merchants');
			
		$result=$this->model_merchants_merchants->saveInfo($data);
		
		if($result=="no"){
			$this->showMessage("对不起，店铺信息保存失败！");
		}else{
			$this->showMessage("店铺信息保存成功！",$this->url->link('merchants/merchants', '', 'SSL'));
		}
		//$this->response->setOutPut(json_encode($result));
		
		//$this->session->data['success'] = $this->language->get('text_insert');

		//$this->redirect($this->url->link('merchants/store', '', 'SSL'));
  	}
}
?>