<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Default_Controller extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		//用户表
		$this->load->model('Member_model','user_model');

		date_default_timezone_set("Asia/Shanghai");
        $this->load->helper('Default_helper');
		$this->load->helper('Search_helper');
        //验证是否登陆
		if(!isset($_SESSION['users'])){
			echo "<script>alert('您还没有登陆！');window.location.href='".site_url('/Login/index')."';</script>";
			exit;
		}
        //获取所有模块
        $query = $this->db->get('hf_system_modular');
        $mokuai = $query->result_array();
       

        // $plateid = $this->user_model->group_permiss($this->session->users['gid']);
        // $plateid = json_decode($plateid,true);
        
        // if(!empty($plateid)){
        //     if(!in_array('0',$plateid) && !in_array('7',$plateid)){
        //         echo "<script>alert('您没有权限访问！');window.location.href='".site_url('/Admin/index')."';</script>";exit;
        //     }
        // }else{
        //      echo "<script>alert('您没有权限访问！');window.location.href='".site_url('/Admin/index')."';</script>";exit;
        // }
	}
}






 ?>