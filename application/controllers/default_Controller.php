<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class default_Controller extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('default_helper');
        //验证是否登陆
		if(!isset($_SESSION['users'])){
			echo "<script>alert('您还没有登陆！');window.location.href='".site_url('/login/index')."';</script>";
			exit;
		}

	}



}






 ?>