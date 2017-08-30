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
        session_start();

		if(!isset($_SESSION['users'])){
			echo "<script>alert('您还没有登陆！');window.location.href='".site_url('/Login/index')."';</script>";
			exit;
		}


		$q= $this->uri->uri_string();
		$url = preg_replace('|[0-9]+|','',$q);
		if(substr($url,-1) == '/'){
			$url = substr($url,0,-1);
		}
			// var_dump($url);
		//$user_power = json_decode($_SESSION['user_power'],TRUE);

	// if(!deep_in_array($url,$user_power)){
	//     echo "<script>alert('您暂无权限执行此操作！请联系系统管理员。');window.history.go(-1);</script>";
	//             exit;
	// }

		


	}
}






 ?>