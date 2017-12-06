<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    function __construct()
    {
        parent::__construct();
    }



    /**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	function asd(){

        $this->load->view('welcome_message.html');
    }

    
    function inset_app(){
    	if($_POST){
    		$type = $this->input->post('id');
    		$query = $this->db->get('hf_system_version');
    		$res = $query->row_array();
    		//var_dump($res);
    		if($type == 1){
	    		$arr['dowAndroid']= $res['dowAndroid'] + 1;
	    	}else{
	    		$arr['dowIso']= $res['dowIso'] + 1;
	    	}
    		$this->db->where('id',$res['id'])->update('hf_system_version',$arr);
    		echo "1";
    	}else{
    		echo "2";
    	}
    }

    //
    function coupon(){
        $query = $this->db->where('shop_coupon_id','165')->get('hf_shop_couponverify');
        $res = $query->result_array();
        $a =array();
        foreach ($res as $key => $value) {
            $query1 = $this->db->where('user_coupon_id',$value['user_coupon_id'])->get('hf_user_coupon');
            $res1 = $query1->row_array();
            if(!empty($res1)){
                var_dump($value['user_coupon_id']);

                $a[$key] = $res;
            }
            
        }
        echo "<pre>";
        var_dump($a);
    }




    function member(){
        $time = '2017-11-27 00:00:00';
        $end = '2017-12-03 23:59:59';
        $query = $this->db->where('create_time >=',$time)->where('create_time <=',$end)->get('hf_user_member');
        // $query = $this->db->query();
        $res = $query->result_array();
        $a ='0';
        foreach ($res as $key => $value) {
            // $query1 = $this->db->where('newsId',$value['id'])->get('hf_friends_news_commont');
            // // $query = $this->db->query();
            // $res1 = $query1->result_array();
            $a += $value['intergral'];
            // var_dump($a);
        }
        // echo "<pre>";
        var_dump($a);
        var_dump(count($res));
    }

    //问答数
    function question(){
        $time = '2017-11-27 00:00:00';
        $end = '2017-12-03 23:59:59';
        $query = $this->db->where('create_time >=',$time)->where('create_time <=',$end)->where('typeId','2')->get('hf_friends_news');
        // $query = $this->db->query();
        $res = $query->result_array();
        $a ='0';
        foreach ($res as $key => $value) {
            $query1 = $this->db->where('newsId',$value['id'])->get('hf_friends_news_commont');
            // // $query = $this->db->query();
            $res1 = $query1->result_array();
            $a += count($res1);
            // var_dump($a);
        }
        // echo "<pre>";
        var_dump($a);
        var_dump(count($res));
    }

    //发帖数1交友动态 2问答动态  3圈子动态 4二手信息 5举报动态
    function findest(){
        $time = '2017-11-27 00:00:00';
        $end = '2017-12-03 23:59:59';
        $query = $this->db->where('create_time >=',$time)->where('create_time <=',$end)->where('typeId','1')->get('hf_friends_news');
        // $query = $this->db->query();
        $res = $query->result_array();
        $a ='0';
        foreach ($res as $key => $value) {
            $query1 = $this->db->where('newsId',$value['id'])->get('hf_friends_news_commont');
            // // $query = $this->db->query();
            $res1 = $query1->result_array();
            $a += count($res1);
            // var_dump($a);
        }
        // echo "<pre>";
        var_dump($a);
        var_dump(count($res));
    }



    function order(){
        $sql = "select* from hf_mall_order where order_type='0' and order_status !='1' and `PriceCalculation` like '%\"coupon_amount\":\"199,100\"%' order by order_id desc";
        $query = $this->db->query($sql);
         $res = $query->result_array();
         $a = array();
         foreach ($res as $key => $value) {
             $pay = json_decode($value['PriceCalculation'],true);
             $couponid = $pay['coupon'];
            
            $sql1 = "select * from hf_user_coupon where user_coupon_id = $couponid and user_coupon_state = 1";
            $query1 = $this->db->query($sql1);
            $res1 = $query1->row_array();
            // var_dump($res1);
            if(!empty($res1)){
                $a[] = $res1['user_coupon_id'];

            }

         }
         echo "<pre>";
         var_dump(count($a));
         var_dump(array_unique($a));
    }

    function aabcd(){
        echo "3434";
    }


}
