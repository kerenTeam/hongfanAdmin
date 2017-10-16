<?php 
        session_start();

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


		

		


	}
}






 ?>