<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  商家管理
 *
 * */
require_once(APPPATH.'controllers/default_Controller.php');

class moll extends default_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('moll_model');

    }
    
    //业态列表
    function mollyetaiList(){

    	 $this->load->view('moll/mollyetaiList.html');
    }
    //新增业态
    function mollAddYetai(){

         $this->load->view('moll/mollAddYetai.html');
    }
     //编辑业态
    function mollEditYetai(){

         $this->load->view('moll/mollEditYetai.html');
    }
    //楼层信息
    function mollFloorInfo(){
        $this->load->view('moll/mollFloorInfo.html');
    }
    //商场简介
    function mollBrief(){
         $data['market'] = $this->moll_model->get_marketinfo();
         // var_dump($data);
         // exit;
         $this->load->view('moll/mollBrief.html',$data);
    }



}

