<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  商家管理
 *
 * */
require_once(APPPATH.'controllers/default_Controller.php');
class shop extends default_Controller {
    //商家首页
    public $view_shopIndex = "shop/shopList.html";
    //新增商家
    public $view_addShop = "shop/addShop.html";
    //编辑商家
    public $view_EditShop = "shop/editShop.html";

    function __construct()
    {
        parent::__construct();
        $plateid = $this->user_model->group_permiss($this->session->users['gid']);
        $plateid = json_decode($plateid,true);
        if(!empty($plateid)){
            if(!in_array('0',$plateid) && !in_array('3',$plateid)){
                echo "<script>alert('您没有权限访问！');window.location.href='".site_url('/admin/index')."';</script>";exit;
            }
        }else{
             echo "<script>alert('您没有权限访问！');window.location.href='".site_url('/admin/index')."';</script>";exit;
        }
    }

    //商家 列表主页
    function index()
    {  

         $data['page'] = $this->view_shopIndex;
         $data['menu'] = array('shop','shopList');
    	 $this->load->view('template.html',$data);
    }
    //商家管理
    function shop_admin(){

    	 $this->load->view('shop/shopInfo.html');
    }
    //新增商家
    function addShop(){
        $data['page'] = $this->view_addShop;
        $data['menu'] = array('shop','addShop');
        $this->load->view('template.html',$data);
       
    }
    //编辑商家信息
    function editShop(){
        $data['page'] = $this->view_EditShop;
        $data['menu'] = array('shop','shopList');
        $this->load->view('template.html',$data);
    }


}

