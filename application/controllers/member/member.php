<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  会员管理
 *
 * */

class member extends CI_Controller {

    function __construct()
    {
        parent::__construct();

    }

    //会员 列表
    function memberList()
    {
    	 $this->load->view('member/memberList.html');
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
    //会员卡管理
    function memberCard(){
        $this->load->view('member/memberCard.html');
    }


}

