<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  商家管理
 *
 * */
require_once(APPPATH.'controllers/default_Controller.php');

class moll extends default_Controller {
    //业态列表
    public $view_mollyetaiList = "moll/mollyetaiList.html";
    //新增业态
    public $view_mollAddYetai = "moll/mollAddYetai.html";
    //编辑业态
    public $view_mollEditYetai = "moll/mollEditYetai.html";
    //楼层信息
    public $view_mollFloorInfo = "moll/mollFloorInfo.html";
    //商场简介
    public $view_mollBrief = "moll/mollBrief.html";
    function __construct()
    {
        parent::__construct();
        $this->load->model('moll_model');
        $plateid = $this->user_model->group_permiss($this->session->users['gid']);
        $plateid = json_decode($plateid,true);
        if(!empty($plateid)){
            if(!in_array('0',$plateid) && !in_array('1',$plateid)){
                echo "<script>alert('您没有权限访问！');window.location.href='".site_url('/admin/index')."';</script>";exit;
            }
        }
    }
    
    //业态列表
    function mollyetaiList(){
         //获取所有业态
         $data['page'] = $this->view_mollyetaiList;
         $data['menu'] = array('moll','mollyetaiList');
    	 $this->load->view('template.html',$data);
    }
    //新增业态
    function mollAddYetai(){

        $data['page'] = $this->view_mollAddYetai;
         $data['menu'] = array('moll','mollyetaiList');
         $this->load->view('template.html',$data);
    }
     //编辑业态
    function mollEditYetai(){

        $data['page'] = $this->view_mollEditYetai;
         $data['menu'] = array('moll','mollyetaiList');
         $this->load->view('template.html',$data);
    }
    //楼层信息
    function mollFloorInfo(){
         $data['page'] = $this->view_mollFloorInfo;
         $data['menu'] = array('moll','mollFloorInfo');
         $this->load->view('template.html',$data);
    }
    //商场简介
    function mollBrief(){
         $data['market'] = $this->moll_model->get_marketinfo();
 
         $data['page'] = $this->view_mollBrief;
         $data['menu'] = array('moll','mollBrief');
         $this->load->view('template.html',$data);
    }



}

