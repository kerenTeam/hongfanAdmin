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
         for ($i=1; $i < 4; $i++) { 
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