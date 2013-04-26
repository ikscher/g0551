<?php
class ModelTotalShipping extends Model {
	public function getTotal(&$total_data, &$total,$flag=false,$store=false) {//, &$taxes
	    $sort_order=$this->config->get('shipping_sort_order');
	    if($store==false){
			if ($this->cart->hasShipping($flag) && !empty($this->session->data['shipping_method'])) {
				
				$total_data[] = array( 
					'code'       => isset($this->session->data['shipping_method']['code'])?$this->session->data['shipping_method']['code']:'',
					'title'      => isset($this->session->data['shipping_method']['title'])?$this->session->data['shipping_method']['title']:'',
					'text'       => number_format(isset($this->session->data['shipping_method']['cost'])?$this->session->data['shipping_method']['cost']:0,2,'.',','),
					'value'      => isset($this->session->data['shipping_method']['cost'])?$this->session->data['shipping_method']['cost']:'',
					'sort_order' => isset($sort_order)?$sort_order:0
				);

				
				
				$total += $this->session->data['shipping_method']['cost'];
			}	
		}elseif($store==true){
		    if ($this->cart->hasShipping($flag) && !empty($this->session->data['shipping_method'])) {
				foreach($total_data as $k=>$v){
					$total_data[$k][] = array( 
						'code'       => isset($this->session->data['shipping_method']['code'])?$this->session->data['shipping_method']['code']:'',
						'title'      => isset($this->session->data['shipping_method']['title'])?$this->session->data['shipping_method']['title']:'',
						'text'       => number_format(isset($this->session->data['shipping_method']['cost'])?$this->session->data['shipping_method']['cost']:0,2,'.',','),
						'value'      => isset($this->session->data['shipping_method']['cost'])?$this->session->data['shipping_method']['cost']:'',
						'sort_order' => isset($sort_order)?$sort_order:0
					);

					if(!isset($total[$k])) $total[$k]=0;
					
					$total[$k] += $this->session->data['shipping_method']['cost'];
				}
			}	
		
		}
        
	}
}
?>