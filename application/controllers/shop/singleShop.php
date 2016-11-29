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

}

