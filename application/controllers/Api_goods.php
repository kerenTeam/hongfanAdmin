<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
*  APP  接口
*/
class Api_goods extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('MallShop_model');
	}

	function get_goods_property(){
		if($_POST){
            
			$goodsid = $_POST['goods_id'];
			  $parent = $this->MallShop_model->get_goods_parent($goodsid);
              if(!empty($parent)){
                foreach ($parent as $key => $value) {
                    $stend['0']['name'][] = $value['stend1'];
                    $stend['0']['value'][] = $value['value1'];
                    $stend['1']['name'][]= $value['stend2'];
                    $stend['1']['value'][]= $value['value2'];
                    $stend['2']['name'][]= $value['stend3'];
                    $stend['2']['value'][]= $value['value3'];
                    $stend['3']['name'][] = $value['stend4'];
                    $stend['3']['value'][] = $value['value4'];
                }
                foreach ($stend as $k => $v) {
                    if($v['name'][0] == ''){
                        unset($v);
                    }else{
                    	
	                     $arr[$k]['name'] = array_merge(array_unique($v['name']));
	                     $arr[$k]['value'] = array_merge(array_unique($v['value']));
            
                    }
                }
                $data[]['parent'] =$arr;
             }else{
                $parent = '';
                $data[]['parent'] = '';
             }
             $data[]['parentlist'] = $parent;
            echo json_encode($data);
            // var_dump($data);
    

		}else{
			echo "2";
		}
	}





}



?>