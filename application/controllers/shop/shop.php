<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  商家管理
 *
 * */

class shop extends CI_Controller {

    function __construct()
    {
        parent::__construct();

    }

    //商家 列表主页
    function index()
    {
    	 $this->load->view('shop/shopList.html');
    }
    //商家管理
    function shop_admin(){

    	 $this->load->view('shop/shopInfo.html');
    }
    //新增商家
    function addShop(){
        $this->load->view('shop/addShop.html');
    }
    //编辑商家信息
    function editShop(){
        $this->load->view('shop/editShop.html');
    }


}

