<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  商城管理
 *
 * */

class store extends CI_Controller {

    function __construct()
    {
        parent::__construct();

    }
    //商品列表
    function storeGoodsList(){

    	 $this->load->view('store/storeGoodsList.html');
    }
    //商品分类
    function storeGoodsSort(){
        $this->load->view('store/storeGoodsSort.html');
    }
    //商品的模块设置
    function storeModuleSet(){
        $this->load->view('store/storeModuleSet.html');
    }
    //添加商品
    function storeAddGoods(){
        $this->load->view('store/storeAddGoods.html');
    }
    //编辑商品
    function storeEditGoods(){
        $this->load->view('store/storeEditGoods.html');
    }

}
