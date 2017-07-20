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
        $this->load->helper('Default_helper');
		$this->load->model('MallShop_model');
	}
    function index(){
            $order_uuid = 'hfczSZ5sJ6_5qd5_L1DatwBJr9pLftTy';
          $type = substr($order_uuid,0,4);
          var_dump($type);
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


    function notify_wxPay(){
           //file_put_contents('text.log','254578');
            //模拟登陆APP
            // $url = APPLOGIN."/api/useraccount/login";
            // // var_dump($url);
            // $arr = array('phone'=>"15828277232","password"=>"123456a");
            // $token = curl_post_token($url,$arr);
           $arr = array('return_code'=>"SUCCESS",'return_msg'=>"OK");
           $xml  ='<!--l version="1.0" encoding="'."utf8".'-->'; 
           header("Content-type: text/xml");
           $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
           $xml = arrayToXml($arr);  
           echo $xml;
           //返回数据
           $arguments = file_get_contents('php://input');  
          // file_put_contents('text.log',json_encode($arr));
            $a = xmlToArray($arguments);
            $order_uuid = $a['out_trade_no'];

            $pay_data = json_encode($a);
            //截取回调是那个接口
            $type = substr($order_uuid,0,4);
            if($type == "hfcz"){
                $sjczurl = APPLOGIN."/api/banma/rechargemobilepaybillpost";
                $data = array('UUID'=>$order_uuid,'rebackData'=>$pay_data);
               // file_put_contents("text.log", var_export($data,TRUE),FILE_APPEND);
                $ret = curl_post($sjczurl,$data);
            }else if($type == 'llcz'){
                $llcz = APPLOGIN."/api/banma/mobileflowpaybillpost";
                $data = array('UUID'=>$order_uuid,'rebackData'=>$pay_data);
                $ret = curl_post($llcz,$data);

            }else if($type == 'sdqc'){
                $sdqc = APPLOGIN."/api/banma/liferechargepaybillpost";
                $data = array('UUID'=>$order_uuid,'rebackData'=>$pay_data);
                $ret = curl_post($sdqc,$data);
            }else{
                
                if($a['result_code'] == "SUCCESS"){
                    $data['wechatReturn'] = $pay_data;
                    $data['pay_state'] = '2';
                    $data['payType'] = 'wxpay';
                    $this->db->where('repay_UUID', $order_uuid)->update('hf_mall_order_repaydata',$data);
                    // //更改订单号
                    $order['order_status'] = '2';
                    $this->db->where('order_UUID',$order_uuid)->update('hf_mall_order',$order);
                    //file_put_contents('text.log',json_encode($a));
                }
            }

            //判断
            

            // $pay_data = json_encode($a);
            //file_put_contents("text.log", var_export($a,TRUE),FILE_APPEND);
         

            // // $pay_url = APPLOGIN.'api/index/validatewxpay';
            // // $header = array("token:".trim($token)); 
            // // $w = curl_post_express($header,$pay_url,$pay_data);

            // //更改预支付订单
         
            
    }


}



?>