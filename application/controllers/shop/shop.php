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
         $data['menu'] = array('store','shopList');
    	 $this->load->view('template.html',$data);
    }
    //返回列表信息
    function return_shop_page(){
         if($_POST){
            $list = $this->shop_model->shop_list();
            if(empty($list)){
                echo "2";
            }else{
                echo json_encode($list);
            }
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
        //获取所有业态
        $data['yetai'] = $this->shop_model->store_type_level(); 

        $data['page'] = $this->view_addShop;
        $data['menu'] = array('store','shopList');
        $this->load->view('template.html',$data);
       
    }
    //新增商家操作
    function add_shop_store(){
        if($_POST){
            $data = $this->input->post();
            $arr['username'] = trim($this->input->post('username'));
            $arr['gid'] = '2';
            $arr['password'] = md5(trim($this->input->post('password')));
            if(!empty($this->shop_model->get_user_info($arr['username']))){
                echo "<script>alert('账户已被注册！');window.location.href='".site_url('/shop/shop/addShop')."'</script>";exit;
            }
            //新增商家用户账号
           $userid = $this->shop_model->add_store_member($arr);
           if(!empty($userid)){
                $data['business_id'] = $userid;
                unset($data['password'],$data['username']);
                if($this->shop_model->add_store_info($data)){
                     echo "<script>alert('操作成功！');window.location.href='".site_url('/shop/shop/index')."'</script>";exit;
                }else{
                    echo "<script>alert('操作失败！');window.location.href='".site_url('/shop/shop/addShop')."'</script>";exit;
                }
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/shop/shop/addShop')."'</script>";exit;
            }
        }else{
            $this->load->view('404.html');
        }
    }
    //编辑商家信息
    function editShop(){
        $id = intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
            //获取一级业态
            $data['yetai'] = $this->shop_model->store_type_level();
            //获取商家信息
            $store = $this->shop_model->get_store_Info($id);
            //获取账户
            $data['user'] = $this->shop_model->get_login_store($store['business_id']);
            $data['store'] = $store;
            $data['page'] = $this->view_EditShop;
            $data['menu'] = array('store','shopList');
            $this->load->view('template.html',$data);
        }
    }
    //编辑商家操作
    function edit_shop_store(){
        if($_POST){
            $data = $this->input->post();
            $arr['username'] = $this->input->post('username');
            $arr['password'] = $this->input->post('password');
            $arr['user_id'] = $this->input->post('user_id');
            unset($data['username'],$data['password'],$data['user_id']);
            if($this->shop_model->get_member_info($arr['user_id'],$arr['username'])){
                 echo "<script>alert('账户已被注册！');window.location.href='".site_url('/shop/shop/addShop')."'</script>";exit;
            }
            //修改登录账户
            if($this->shop_model->edit_store_member($arr['user_id'],$arr)){
                if($this->shop_model->edit_store_info($data['store_id'],$data)){
                     echo "<script>alert('操作成功！');window.location.href='".site_url('/shop/shop/index')."'</script>";exit;
                }else{
                    echo "<script>alert('操作失败！');window.location.href='".site_url('/shop/shop/editShop/').$data['store_id']."'</script>";exit;
                }
            }

        }else{
            $this->load->view('404.html');
        }
    }
    //返回二级业态
    function return_store_type(){
        if($_POST){
            $gid = $_POST['gid'];
            //根据gid返回
            $type = $this->shop_model->store_type_tow($gid);
            if(empty($type)){
                echo "2";
            }else{
                echo json_encode($type);
            }
        }else{
            echo "2";
        }
    }

    //导入商家信息
    function impolt_store(){

    }


}

