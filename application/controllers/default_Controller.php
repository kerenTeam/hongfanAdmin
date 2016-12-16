<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class default_Controller extends CI_Controller
{
	public $mokuai = array(
                '0'=>array('id'=>'0','name'=>'所有模块'),
                '1'=>array('id'=>'1','name'=>'系统设置'),
                '2'=>array('id'=>'2','name'=>'商场设置'),
                '3'=>array('id'=>'3','name'=>'店铺管理'),
                '4'=>array('id'=>'4','name'=>'电商管理'),
                '5'=>array('id'=>'5','name'=>'卡卷管理'),
                '6'=>array('id'=>'6','name'=>'主页模块'),
                '7'=>array('id'=>'7','name'=>'会员管理'),
    );
	function __construct()
	{
		parent::__construct();
		//用户表
		$this->load->model('member_model','user_model');


		date_default_timezone_set("Asia/Shanghai");
		$this->load->helper('default_helper');
        //验证是否登陆
		// if(!isset($_SESSION['users'])){
		// 	echo "<script>alert('您还没有登陆！');window.location.href='".site_url('/login/index')."';</script>";
		// 	exit;
		// }
	}
}






 ?>