<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  商城管理
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
    //ceshio
    public $view_ceshi = "banner/ceshi.html";

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
        //model
        $this->load->model('shop_model');
    }

    //商家 列表主页
    function index()
    {  

         $data['page'] = $this->view_shopIndex;
         $data['menu'] = array('shop','shopList');
    	 $this->load->view('template.html',$data);
    }
    //返回列表信息
    function return_shop_page(){
        if($_POST){
            $list = $this->shop_model->shop_list();
            echo json_encode($list);
        }else{
            echo "2";
        }
    }

    //商家状态修改
    function edit_shop_state(){
        if($_POST){
            $id = $_POST['id'];
            $action = $_POST['state'];
            switch ($action) {
                case '1':
                    $data['state'] = '1';
                    if($this->shop_model->edit_shop_state($id,$data)){
                        echo "1";
                    }else{
                        echo "2";
                    }
                    break;
                case '2':
                    $data['state'] = '0';
                    if($this->shop_model->edit_shop_state($id,$data)){
                        echo "1";
                    }else{
                        echo "2";
                    }
                    break;
                default:
                        echo "2";
                        break;
            }
        }else{
            echo "2";
        }
    }
    //删除商家
    function del_shop_store(){
        if($_POST){
            $id = $_POST['id'];
            if($this->shop_model->del_shop_store($id)){
                echo "1";
            }else{
                echo "2";
            }
        }else{
            echo "2";
        }
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

