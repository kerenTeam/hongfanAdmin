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

    //商场 基础配置
    function index()
    {
    	 $this->load->view('moll/baseSet.html');
    }
    //商场 基础信息
    function baseInfo()
    {
         $this->load->view('moll/baseInfo.html');
    }
    //业态配置
    function yetai(){

    	 $this->load->view('moll/yetai.html');
    }
    //楼层信息
    function floorInfo(){
        $this->load->view('moll/floorInfo.html');
    }
    //商场简介
    function mollBrief(){
         $this->load->view('moll/mollBrief.html');
    }



}

