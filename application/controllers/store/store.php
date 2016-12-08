<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  商城管理
 *
 * */
require_once(APPPATH.'controllers/default_Controller.php');

class store extends default_Controller {
    //商品列表
    public $view_storeGoodsList = "store/storeGoodsList.html";
    //商品分类
    public $view_storeGoodsSort = 'store/storeGoodsSort.html';
    //模块设置
    public $view_storeModuleSet = "store/storeModuleSet.html";
    //添加商品
    public $view_storeAddGoods = "store/storeAddGoods.html";
    //编辑商品
    public $view_storeEditGoods = "store/storeEditGoods.html";
    //添加分类
    public $view_storeAddSort = "store/storeAddSort.html";
    //编辑分类
    public $view_storeEditSort = "store/storeEditSort.html";
    //订单管理
    public $view_storeOrderList = "store/storeOrderList.html";
    //快递管理
    public $view_storeDeliveryList = 'store/storeDeliveryList.html';

    function __construct()
    {
        parent::__construct();
        $this->load->model('moll_model');
        $plateid = $this->user_model->group_permiss($this->session->users['gid']);
        $plateid = json_decode($plateid,true);
        if(!empty($plateid)){
            if(!in_array('0',$plateid) && !in_array('4',$plateid)){
                echo "<script>alert('您没有权限访问！');window.location.href='".site_url('/admin/index')."';</script>";exit;
            }
        }
    }
    //商品列表
    function storeGoodsList(){
        $data['page'] = $this->view_storeGoodsList;
        $data['menu'] = array('store','storeGoodsList');
    	 $this->load->view('template.html',$data);
    }
    //商品分类
    function storeGoodsSort(){
        $data['page'] = $this->view_storeGoodsSort;
        $data['menu'] = array('store','storeGoodsSort');
         $this->load->view('template.html',$data);
    }
    //商品的模块设置
    function storeModuleSet(){
        $data['page'] = $this->view_storeModuleSet;
        $data['menu'] = array('store','storeModuleSet');
         $this->load->view('template.html',$data);
    }
    //添加商品
    function storeAddGoods(){
       $data['page'] = $this->view_storeAddGoods;
        $data['menu'] = array('store','storeGoodsList');
         $this->load->view('template.html',$data);
    }
    //编辑商品
    function storeEditGoods(){
        $data['page'] = $this->view_storeEditGoods;
        $data['menu'] = array('store','storeGoodsList');
         $this->load->view('template.html',$data);
    }

    //添加分类
    function storeAddSort(){
        $data['page'] = $this->view_storeAddSort;
        $data['menu'] = array('store','storeGoodsSort');
         $this->load->view('template.html',$data);
    }
    //编辑分类
    function storeEditSort(){
         $data['page'] = $this->view_storeEditSort;
        $data['menu'] = array('store','storeGoodsSort');
         $this->load->view('template.html',$data);
    }
    //订单管理
    function storeOrderList(){
        $data['page'] = $this->view_storeOrderList;
        $data['menu'] = array('store','storeOrderList');
         $this->load->view('template.html',$data);
    }
    //快递管理
    function storeDeliveryList(){
         $data['page'] = $this->view_storeDeliveryList;
         $data['menu'] = array('store','storeDeliveryList');
         $this->load->view('template.html',$data);
     }
}

