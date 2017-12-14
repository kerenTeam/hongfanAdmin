<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  获取爱购保税商品
*/
class Igogoods extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('Default_helper');
    }



    function goods_list(){

        set_time_limit(0);
        $query = $this->db->get('hf_mall_goods_igo');
        $list = $query->result_array();
     
        if(!empty($list)){
          $this->db->where('differentiate','3')->delete('hf_mall_goods_igo');
        }
        //获取本地的列表
         $num = '100';
         $goods_list = array();
         for ($i=1; $i < 5; $i++) { 
           $post_data = array(  
            'appkey' => IGOAPPKEY,  
            'appsecret' => IGOAPPSECRET,
            'page_no' => $i,
            'page_size' => $num,
            'isdown' => '1',
            'shop_status' => '1',
           );

           $post = curl_post(IGOLISTAPIURL, $post_data);  
         
           $goods = json_decode($post,true);
           $goods_list =  array_values($goods['data']['lists']);
           $a =  insert_db($goods_list);
           // echo "<pre>";
           // var_dump($a);
        }
    
       echo "1";
    }

    //
    function asd(){

        set_time_limit(0);
        $query = $this->db->get('hf_mall_goods_igo_copy');
        $list = $query->result_array();
        if(!empty($list)){
          $this->db->where('differentiate','3')->delete('hf_mall_goods_igo_copy');
        }
       
        //获取本地的列表
         $num = '50';
         $goods_list = array();
         $a = array();
         for ($i=1; $i < 3; $i++) { 
           $post_data = array(  
            'appkey' => IGOAPPKEY,  
            'appsecret' => IGOAPPSECRET,
            'page_no' => $i,
            'page_size' => $num,
            'isdown' => '1',
            'shop_status' => '1',
           );

           $post = curl_post(IGOLISTAPIURL, $post_data);  
         
           $goods = json_decode($post,true);
           $goods_list =  array_values($goods['data']['lists']);
           foreach($goods_list as $k=>$val){
             if($val['isdown'] =='1'){
                  $pic = explode(',',$val['pic_url']['pic_url']);
                  $val['thumb'] = str_replace('./','/',$pic[0]);
                  $val['differentiate'] = '3';
                  $val['categoryid'] = $val['category_id'];
                  $val['originalprice'] = $val['original_price']+$val['price']*0.1;
                  $val['price'] = $val['price']+$val['price']*0.1;
                  $val['content'] = $val['remark'];
                  $val['tax_rate'] = $val['tax_rate']/100;
                  unset($val['remark'],$val['pic_url'],$val['category_id'],$val['original_price'],$val['isdown'],$val['shop_status']);
                
                 $this->db->insert('hf_mall_goods_igo_copy',$val);
                 sleep(2);
              } 
           }
          // $a[] =$i;
           
        }
        var_dump($a);
    }



    // function goods_info(){
    //   $post_data = array(  
    //         'appkey' => IGOAPPKEY,  
    //         'appsecret' => IGOAPPSECRET,
    //         'open_iid' => '3540088125'
    //        );
    //   $post = curl_post(IGOINFOAPIURL, $post_data);  
    //   $goods = json_decode($post,true);
    //   var_dump(count($goods['data']));
    // }
}

 ?>