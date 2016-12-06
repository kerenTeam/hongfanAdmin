<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  banner管理
 *
 * */

class banner extends CI_Controller {

    function __construct()
    {
        parent::__construct();

    }
    //banner列表
    function index(){

    	 $this->load->view('banner/bannerList.html');
    }
    //新增banner
    function addBanner(){
        $this->load->view('banner/addBanner.html');
    }
    //编辑banner
    function editBanner(){
        $this->load->view('banner/editBanner.html');
    }
   
}

