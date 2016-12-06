<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  系统设置
 *
 * */

class systemSet extends CI_Controller {

    function __construct()
    {
        parent::__construct();

    }

    //系统设置 后台管理员账号管理
    function index()
    {
    	 $this->load->view('systemSet/accountManage.html');
    }
    //系统设置 支付账号管理
    function apliyManage(){

    	 $this->load->view('systemSet/apliyManage.html');
    }
    //系统设置 其他管理
    function other(){
        $this->load->view('systemSet/other.html');
    }
    //系统设置 网站信息管理
    function webMessage(){
        $this->load->view('systemSet/webMessage.html');
    }


}

