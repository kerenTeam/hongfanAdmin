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
    function shopBaseInfo(){
    	$this->load->view('shop/shopBaseInfo.html');
    }
    //商铺简介
    function shopInfo(){
        $this->load->view('shop/shopInfo.html');
    }
     //商品列表
    function goodsList(){
        $this->load->view('shop/goodsList.html');
    }
     //商品详情
    function goodsDetail(){
        $this->load->view('shop/goodsDetail.html');
    }
     //新增商品
    function goodsAdd(){
        $this->load->view('shop/goodsAdd.html');
    }
    //商铺楼层关系
    function shopFloorRelation(){
        $this->load->view('shop/shopFloorRelation.html');
    }
    //商铺评论管理
    function shopComment(){
        $this->load->view('shop/shopComment.html');
    }
     //商铺订单管理
    function shopOrder(){
        $this->load->view('shop/shopOrder.html');
    }


    //商家促销管理 促销列表
    function shopSalesList(){
        $this->load->view('shop/shopSalesList.html');
    }
    //商家促销管理 新增促销
    function shopAddSales(){
        $this->load->view('shop/shopAddSales.html');
    }
     //商家促销管理 促销验证
    function shopCheckSales(){
        $this->load->view('shop/shopCheckSales.html');
    }
     //商家促销管理 编辑促销
    function shopEditSales(){
        $this->load->view('shop/shopEditSales.html');
    }
    //商家活动管理 活动列表
    function shopActivityList(){
        $this->load->view('shop/shopActivityList.html');
    }
     //商家活动管理 添加活动
    function shopAddActivity(){
        $this->load->view('shop/shopAddActivity.html');
    }
     //商家活动管理 编辑活动
    function shopEditActivity(){
        $this->load->view('shop/shopEditActivity.html');
    }
}

