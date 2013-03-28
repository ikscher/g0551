<?php
class ModelTotalShipping extends Model {
	public function getTotal(&$total_data, &$total,$flag=false,$store=false) {//, &$taxes
	    if($store==false){
			if ($this->cart->hasShipping($flag) && isset($this->session->data['shipping_method'])) {
				
				$total_data[] = array( 
					'code'       => 'shipping',
					'title'      => $this->session->data['shipping_method']['title'],
					'text'       => number_format($this->session->data['shipping_method']['cost'],2,'.',','),
					'value'      => $this->session->data['shipping_method']['cost'],
					'sort_order' => $this->config->get('shipping_sort_order')
				);

				
				
				$total += $this->session->data['shipping_method']['cost'];
			}	
		}elseif($store==true){
		    if ($this->cart->hasShipping($flag) && isset($this->session->data['shipping_method'])) {
				foreach($total_data as $k=>$v){
					$total_data[$k][] = array( 
						'code'       => 'shipping',
						'title'      => $this->session->data['shipping_method']['title'],
						'text'       => number_format($this->session->data['shipping_method']['cost'],2,'.',','),
						'value'      => $this->session->data['shipping_method']['cost'],
						'sort_order' => $this->config->get('shipping_sort_order')
					);

					if(!isset($total[$k])) $total[$k]=0;
					
					$total[$k] += $this->session->data['shipping_method']['cost'];
				}
			}	
		
		}
        
	}
}
?>