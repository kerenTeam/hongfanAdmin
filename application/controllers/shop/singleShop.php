<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  商家管理
 *
 * */
require_once(APPPATH.'controllers/default_Controller.php');

class singleShop extends default_Controller {
    //商家 列表主页
    public $view_shopAdmin = "shop/shopAdmin.html";
    //商家基础信息
    public $view_shopBaseInfo = "shop/shopBaseInfo.html";
    //商家简介
    public $view_shopInfo = "shop/shopInfo.html";
    //商品列表
    public $view_goodsList = "shop/goodsList.html"; 
    //商品详情
    public $view_goodsDetail = "shop/goodsDetail.html"; 
    //新增商品
    public $view_goodsAdd = "shop/goodsAdd.html"; 
    //商家楼层关系
    public $view_shopFloorRelation = "shop/shopFloorRelation.html";

    function __construct()
    {
        parent::__construct();
    }

    //商家 列表主页
    function shopAdmin()
    {   //缓存商家id
        $this->session->set_userdata('businessId',$this->session->users['user_id']);
        $data['page'] = $this->view_shopAdmin;
    	$this->load->view('template.html',$data);
    }
    //商家基础信息
    function shopBaseInfo(){
        $data['page'] = $this->view_shopBaseInfo;
        $data['menu'] = array('shop','shopBaseInfo');       
        $this->load->view('template.html',$data);
    }
    //商家简介
    function shopInfo(){
         $data['page'] = $this->view_shopInfo;
        $data['menu'] = array('shop','shopInfo');       
        $this->load->view('template.html',$data);
    }
     //商品列表
    function goodsList(){
         $data['page'] = $this->view_goodsList;
        $data['menu'] = array('shop','goodsList');       
        $this->load->view('template.html',$data);
    }
     //商品详情
    function goodsDetail(){
         $data['page'] = $this->view_goodsDetail;
        $data['menu'] = array('shop','goodsList');       
        $this->load->view('template.html',$data);
    }
     //新增商品
    function goodsAdd(){
         $data['page'] = $this->view_goodsAdd;
        $data['menu'] = array('shop','goodsList');       
        $this->load->view('template.html',$data);
    }
    //商家楼层关系
    function shopFloorRelation(){
         $data['page'] = $this->view_shopFloorRelation;
        $data['menu'] = array('shop','shopFloorRelation');       
        $this->load->view('template.html',$data);
    }
    //商家评论管理
    function shopComment(){
        $this->load->view('shop/shopComment.html');
    }
     //商家订单管理
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

