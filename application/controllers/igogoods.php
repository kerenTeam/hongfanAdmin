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
        //
      echo "1";
        set_time_limit(0);
        $query = $this->db->where('differentiate','3')->get('hf_mall_goods');
        $list = $query->result_array();
        if(!empty($list)){
          $this->db->where('differentiate','3')->delete('hf_mall_goods');
        }
        //获取本地的列表
         $num = '10';
         for ($i=1; $i <50; $i++) { 
           $post_data = array(  
            'appkey' => IGOAPPKEY,  
            'appsecret' => IGOAPPSECRET,
            'page_no' => $i,
            'page_size' => $num
           );

           $post = curl_post(IGOLISTAPIURL, $post_data);  
           $goods = json_decode($post,true);
           $goods_list = array_values($goods['data']['lists']);
           foreach($goods_list as $k=>$val){
                $pic = explode(',',$val['pic_url']['pic_url']);
                $val['thumb'] = str_replace('./','/',$pic[0]);
                $val['differentiate'] = '3';
                unset($val['commission_start_time'],$val['commission_end_time'],$val['pic_url']);
                $this->db->insert('hf_mall_goods',$val);
                sleep(2);
           }  
        }
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