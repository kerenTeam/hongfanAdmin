<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  商家管理
 *
 * */

class moll extends CI_Controller {

    function __construct()
    {
        parent::__construct();

    }

    // //商场 基础配置
    // function index()
    // {
    // 	 $this->load->view('moll/mollBaseSet.html');
    // }
    // //商场 基础信息
    // function baseInfo()
    // {
    //      $this->load->view('moll/mollBaseInfo.html');
    // }
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
         $this->load->view('moll/mollBrief.html');
    }



}

