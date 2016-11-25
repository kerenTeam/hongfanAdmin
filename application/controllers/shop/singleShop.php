<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  商铺管理
 *
 * */

class singleShop extends CI_Controller {

    function __construct()
    {
        parent::__construct();

    }

    //商铺 列表主页
    function shopAdmin()
    {
    	 $this->load->view('shop/shopAdmin.html');
    }
    //商铺基础信息
    function shop


}

