<?php
class ControllerModuleGeneral extends Controller {

  /**
	*  footer 文章  ****************购物流程
	*/
	public function shoppingProcess(){
		
	    $this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->data['heading_title'] = $this->config->get('config_title');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/shoppingProcess.html')) {
		$this->template = $this->config->get('config_template') . '/template/common/shoppingProcess.html';
		} else {
			$this->template = 'default/template/module/general/shoppingProcess.html';
		}

		 $this->children = array(
			'common/footer',
			'common/header',
			'module/left'
		); 
		
	
	    $this->response->setOutput($this->render());
	}


    /**
	*  footer 文章  ****************上门自提
	*/
		public function diy(){

	    $this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->data['heading_title'] = $this->config->get('config_title');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/diy.html')) {
		$this->template = $this->config->get('config_template') . '/template/common/diy.html';
		} else {
			$this->template = 'default/template/module/general/diy.html';
		}

		 $this->children = array(
			'common/footer',
			'common/header',
			'module/left'
		); 
		
	
	    $this->response->setOutput($this->render());
	}

    /**
	*  footer 文章  ****************快速运输
	*/

		public function transport(){

	    $this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->data['heading_title'] = $this->config->get('config_title');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/transport.html')) {
		$this->template = $this->config->get('config_template') . '/template/common/transport.html';
		} else {
			$this->template = 'default/template/module/general/transport.html';
		}

		 $this->children = array(
			'common/footer',
			'common/header',
			'module/left'
		); 
	    $this->response->setOutput($this->render());
	}
	
	
	/**
	*  footer 文章  ****************图片上传
	*/

		public function imageUpload(){

	    $this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->data['heading_title'] = $this->config->get('config_title');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/imageUpload.html')) {
		$this->template = $this->config->get('config_template') . '/template/common/imageUpload.html';
		} else {
			$this->template = 'default/template/module/general/imageUpload.html';
		}

		 $this->children = array(
			'common/footer',
			'common/header',
			'module/left'
		); 
	    $this->response->setOutput($this->render());
	}

    /**
	*  footer 文章  ****************限时到达
	*/

		public function arrivedIntime(){

	    $this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->data['heading_title'] = $this->config->get('config_title');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/arrivedIntime.html')) {
		$this->template = $this->config->get('config_template') . '/template/common/arrivedIntime.html';
		} else {
			$this->template = 'default/template/module/general/arrivedIntime.html';
		}

		 $this->children = array(
			'common/footer',
			'common/header',
			'module/left'
		); 
	    $this->response->setOutput($this->render());
	}

    /**
	*  footer 文章  ****************货到付款
	*/

		public function payment(){

	    $this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->data['heading_title'] = $this->config->get('config_title');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/payment.html')) {
		$this->template = $this->config->get('config_template') . '/template/common/payment.html';
		} else {
			$this->template = 'default/template/module/general/payment.html';
		}

		 $this->children = array(
			'common/footer',
			'common/header',
			'module/left'
		); 
	    $this->response->setOutput($this->render());
	}

    /**
	*  footer 文章  ****************在线支付
	*/

		public function onlinePay(){

	    $this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->data['heading_title'] = $this->config->get('config_title');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/onlinePay.html')) {
		$this->template = $this->config->get('config_template') . '/template/common/onlinePay.html';
		} else {
			$this->template = 'default/template/module/general/onlinePay.html';
		}

		 $this->children = array(
			'common/footer',
			'common/header',
			'module/left'
		); 
	    $this->response->setOutput($this->render());
	}


    /**
	*  footer 文章  ****************分期付款
	*/

		public function installments(){

	    $this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->data['heading_title'] = $this->config->get('config_title');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/installments.html')) {
		$this->template = $this->config->get('config_template') . '/template/common/installments.html';
		} else {
			$this->template = 'default/template/module/general/installments.html';
		}

		 $this->children = array(
			'common/footer',
			'common/header',
			'module/left'
		); 
	    $this->response->setOutput($this->render());
	}

    /**
	*  footer 文章  ****************7天退换
	*/

		public function exchange(){

	    $this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->data['heading_title'] = $this->config->get('config_title');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/exchange.html')) {
		$this->template = $this->config->get('config_template') . '/template/common/exchange.html';
		} else {
			$this->template = 'default/template/module/general/exchange.html';
		}

		 $this->children = array(
			'common/footer',
			'common/header',
			'module/left'
		); 
	    $this->response->setOutput($this->render());
	}

    /**
	*  footer 文章  ****************假一罚三
	*/

		public function warrant(){

	    $this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->data['heading_title'] = $this->config->get('config_title');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/warrant.html')) {
		$this->template = $this->config->get('config_template') . '/template/common/warrant.html';
		} else {
			$this->template = 'default/template/module/general/warrant.html';
		}

		 $this->children = array(
			'common/footer',
			'common/header',
			'module/left'
		); 
	    $this->response->setOutput($this->render());
	}

    /**
	*  footer 文章  ****************常见问题
	*/

		public function faq(){

	    $this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->data['heading_title'] = $this->config->get('config_title');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/faq.html')) {
		$this->template = $this->config->get('config_template') . '/template/common/faq.html';
		} else {
			$this->template = 'default/template/module/general/faq.html';
		}

		 $this->children = array(
			'common/footer',
			'common/header',
			'module/left'
		); 
	    $this->response->setOutput($this->render());
	}

    /**
	*  footer 文章  ****************意见反馈
	*/

		public function feedback(){

	    $this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->data['heading_title'] = $this->config->get('config_title');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/feedback.html')) {
		$this->template = $this->config->get('config_template') . '/template/common/feedback.html';
		} else {
			$this->template = 'default/template/module/general/feedback.html';
		}

		 $this->children = array(
			'common/footer',
			'common/header',
			'module/left'
		); 
	    $this->response->setOutput($this->render());
	}

    /**
	*  footer 文章  ****************联系我们
	*/

		public function contact(){

	    $this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->data['heading_title'] = $this->config->get('config_title');
		
		$this->data['address']=$this->language->get('address');
		$this->data['telphone']=$this->language->get('telphone');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/contact.html')) {
		$this->template = $this->config->get('config_template') . '/template/common/contact.html';
		} else {
			$this->template = 'default/template/module/general/contact.html';
		}

		 $this->children = array(
			'common/footer',
			'common/header',
			'module/left'
		); 
	    $this->response->setOutput($this->render());
	}


    /**
	*  footer 文章  ****************公司简介
	*/

		public function company(){

	    $this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->data['heading_title'] = $this->config->get('config_title');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/company.html')) {
		$this->template = $this->config->get('config_template') . '/template/common/company.html';
		} else {
			$this->template = 'default/template/module/general/company.html';
		}

		 $this->children = array(
			'common/footer',
			'common/header',
			'module/left'
		); 
	    $this->response->setOutput($this->render());
	}

}

?>