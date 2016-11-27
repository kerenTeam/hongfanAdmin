<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  本地生活
 *
 * */

class module extends CI_Controller {

    function __construct()
    {
        parent::__construct();

    }

    //本地生活 列表主页
    function localLifeList()
    {
         $this->load->view('module/localLife/localLifeList.html');
    }
	//本地生活 本地服务 列表主页
    function serviceList()
    {
         $this->load->view('module/localLife/serviceList.html');
    }
    //本地生活 本地服务 列表详情
    function serviceInfo()
    {
         $this->load->view('module/localLife/serviceInfo.html');
    }



}
