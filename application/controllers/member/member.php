<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  会员管理
 *
 * */
require_once(APPPATH.'controllers/default_Controller.php');

class member extends default_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('member_model','user_model');

    }

    //会员 列表
    function memberList()
    {
         //获取会员列表
        $data['users'] = $this->user_model->get_users();

    	 $this->load->view('member/memberList.html',$data);
    }
    //会员组
    function memberGroup()
    {
         $this->load->view('member/memberGroup.html');
    }
    //新增会员
    function addMember(){

    	 $this->load->view('member/addMember.html');
    }
    //编辑会员
    function editMember(){

         $this->load->view('member/editMember.html');
    }
    //会员卡管理
    function memberCard(){
        $this->load->view('member/memberCard.html');
    }
    //会员详情管理
    function memberInfo(){
        $this->load->view('member/memberInfo.html');
    }


}

