<?php
class ModelTotalTotal extends Model {
	public function getTotal(&$total_data, &$total,$flag=false,$store=false) {//, &$taxes
		$this->load->language('total/total');
        $sort_order=$this->config->get('total_sort_order');
		if($store==false){
			$total_data[] = array(
				'code'       => 'total',
				'title'      => $this->language->get('text_total'),
				'text'       => number_format(max(0, $total),2,'.',','),
				'value'      => max(0, $total),
				'sort_order' => isset($sort_order)?$sort_order:0
			);
		}elseif ($store==true){
		    foreach($total as $k=>$v){
			
				$total_data[$k][] = array(
					'code'       => 'total',
					'title'      => $this->language->get('text_total'),
					'text'       => number_format(max(0, $v,2,'.',',')),
					'value'      => max(0, $v),
					'sort_order' => isset($sort_order)?$sort_order:0
				);
		    }
		}
	}
}
?>