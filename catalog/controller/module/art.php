<?php
class ControllerModuleArt extends Controller {

  /**
	*  footer 文章  ****************购物流程
	*/
	public function procedure(){
		
	    $this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->data['heading_title'] = $this->config->get('config_title');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/procedure.html')) {
		$this->template = $this->config->get('config_template') . '/template/common/procedure.html';
		} else {
			$this->template = 'default/template/common/procedure.html';
		}

		 $this->children = array(
			'common/footer',
			'common/header'
		); 
		
	
	    $this->response->setOutput($this->render());
	}


    /**
	*  footer 文章  ****************上门自提
	*/
		public function smzt(){

	    $this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->data['heading_title'] = $this->config->get('config_title');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/smzt.html')) {
		$this->template = $this->config->get('config_template') . '/template/common/smzt.html';
		} else {
			$this->template = 'default/template/common/smzt.html';
		}

		 $this->children = array(
			'common/footer',
			'common/header'
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
			$this->template = 'default/template/common/transport.html';
		}

		 $this->children = array(
			'common/footer',
			'common/header'
		); 
	    $this->response->setOutput($this->render());
	}

    /**
	*  footer 文章  ****************限时到达
	*/

		public function limited_reach(){

	    $this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->data['heading_title'] = $this->config->get('config_title');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/limited_reach.html')) {
		$this->template = $this->config->get('config_template') . '/template/common/limited_reach.html';
		} else {
			$this->template = 'default/template/common/limited_reach.html';
		}

		 $this->children = array(
			'common/footer',
			'common/header'
		); 
	    $this->response->setOutput($this->render());
	}

    /**
	*  footer 文章  ****************货到付款
	*/

		public function cod(){

	    $this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->data['heading_title'] = $this->config->get('config_title');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/cod.html')) {
		$this->template = $this->config->get('config_template') . '/template/common/cod.html';
		} else {
			$this->template = 'default/template/common/cod.html';
		}

		 $this->children = array(
			'common/footer',
			'common/header'
		); 
	    $this->response->setOutput($this->render());
	}

    /**
	*  footer 文章  ****************在线支付
	*/

		public function online_pay(){

	    $this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->data['heading_title'] = $this->config->get('config_title');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/online_pay.html')) {
		$this->template = $this->config->get('config_template') . '/template/common/online_pay.html';
		} else {
			$this->template = 'default/template/common/online_pay.html';
		}

		 $this->children = array(
			'common/footer',
			'common/header'
		); 
	    $this->response->setOutput($this->render());
	}


    /**
	*  footer 文章  ****************分期付款
	*/

		public function instalment_pay(){

	    $this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->data['heading_title'] = $this->config->get('config_title');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/instalment_pay.html')) {
		$this->template = $this->config->get('config_template') . '/template/common/instalment_pay.html';
		} else {
			$this->template = 'default/template/common/instalment_pay.html';
		}

		 $this->children = array(
			'common/footer',
			'common/header'
		); 
	    $this->response->setOutput($this->render());
	}

    /**
	*  footer 文章  ****************7天退换
	*/

		public function replace(){

	    $this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->data['heading_title'] = $this->config->get('config_title');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/replace.html')) {
		$this->template = $this->config->get('config_template') . '/template/common/replace.html';
		} else {
			$this->template = 'default/template/common/replace.html';
		}

		 $this->children = array(
			'common/footer',
			'common/header'
		); 
	    $this->response->setOutput($this->render());
	}

    /**
	*  footer 文章  ****************假一罚三
	*/

		public function false_penalty(){

	    $this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->data['heading_title'] = $this->config->get('config_title');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/false_penalty.html')) {
		$this->template = $this->config->get('config_template') . '/template/common/false_penalty.html';
		} else {
			$this->template = 'default/template/common/false_penalty.html';
		}

		 $this->children = array(
			'common/footer',
			'common/header'
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
			$this->template = 'default/template/common/faq.html';
		}

		 $this->children = array(
			'common/footer',
			'common/header'
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
			$this->template = 'default/template/common/feedback.html';
		}

		 $this->children = array(
			'common/footer',
			'common/header'
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
			$this->template = 'default/template/common/contact.html';
		}

		 $this->children = array(
			'common/footer',
			'common/header'
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
			$this->template = 'default/template/common/company.html';
		}

		 $this->children = array(
			'common/footer',
			'common/header'
		); 
	    $this->response->setOutput($this->render());
	}

}

?>