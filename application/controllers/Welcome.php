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



}
