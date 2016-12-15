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
    //订单列表
    public $view_shopOrder = "shop/shopOrder.html";
    //修改订单
    public $view_sureOrder = "shop/sureOrder.html";  
    //订单详情
    public $view_shopEditOrder = "shop/shopEditOrder.html";
    //促销劵列表
    public $view_shopSalesList = 'shop/shopSalesList.html';

    function __construct()
    {
        parent::__construct();
        $this->load->model('mallShop_model');
        $this->load->model('shop_model');
    }

    //商家 列表主页
    function shopAdmin()
    {   //缓存商家id
        $id = intval($this->uri->segment(4));
        if($id == 0){
            //商家登录
            $storeid = $this->mallShop_model->get_store_list($this->session->users['user_id']);
             $this->session->set_userdata('businessId',$storeid['store_id']);
        }else{
            $this->session->set_userdata('businessId',$id);
        }

        $data['page'] = $this->view_shopAdmin;
    	$this->load->view('template.html',$data);
    }
    //商家基础信息
    function shopBaseInfo(){

        //获取商家信息
       $store = $this->mallShop_model->get_basess_info($this->session->businessId);
        //获取商家登录账户
         $data['user'] = $this->shop_model->get_login_store($store['business_id']);
       
          $data['busin'] = $store; 
        //返回所有一级业态
        $data['yetai'] = $this->shop_model->store_type_level();

        $data['page'] = $this->view_shopBaseInfo;
        $data['menu'] = array('shop','shopBaseInfo');       
        $this->load->view('template.html',$data);
    }
    //根据顶级业态返回
    function shop_store_type(){
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

    //商家基础信息操作
    function edit_busin_info(){
        if($_POST){
            $data = $this->input->post();
            $arr['username'] = trim($this->input->post('username'));
            $arr['password'] =trim($this->input->post('password'));
            if(strlen($arr['password']) != 32){
                $arr['password'] = md5($arr['password']);
            }
            $arr['user_id'] = $this->input->post('user_id');
            unset($data['username'],$data['password'],$data['user_id']);
            if($this->shop_model->get_member_info($arr['user_id'],$arr['username'])){
                 echo "<script>alert('账户已被注册！');window.location.href='".site_url('/shop/shop/addShop')."'</script>";exit;
            }
            $pic = array();
            $i =1;
            foreach($_FILES as $file=>$val){
                if(!empty($_FILES['img'.$i]['name'])){
                    $config['upload_path']      = 'upload/logo/';
                    $config['allowed_types']    = 'gif|jpg|png|jpeg';
                    $config['max_size']     = 2048;
                    $config['file_name'] = date('Y-m-d_His');
                    $this->load->library('upload', $config);
                    // 上传
                    if(!$this->upload->do_upload('img'.$i)) {
                       echo $this->upload->display_errors();
                    }else{
                        if($i == 1){
                            $data['logo'] = 'upload/logo/'.$this->upload->data('file_name');
                        }else{
                            $data['pic'] = 'upload/logo/'.$this->upload->data('file_name');
                        }
                       
                        unset($data['img'.$i]);
                    }
                }else{
                    if($i == 1){
                        $data['logo'] = $data['img'.$i];
                    }else{
                        $data['pic'] = $data['img'.$i];
                    }
                     
                     unset($data['img'.$i]);
                }
                $i++;
             }
            if($this->shop_model->edit_store_member($arr['user_id'],$arr)){
                 if($this->mallShop_model->edit_store_info($data['store_id'],$data)){
                   echo "<script>alert('操作成功！');window.location.href='".site_url('/shop/singleShop/shopBaseInfo')."'</script>";exit;
                   // echo "23";
                 }else{
                    echo "<script>alert('操作失败！');window.location.href='".site_url('/shop/singleShop/shopBaseInfo')."'</script>";exit;
                 }
            }
        }else{
            $this->load->view('404.html');
        }
    }
    //  //商品列表
    function goodsList(){
        //分类
        $data['cates'] = $this->mallShop_model->get_goods_cates();
       // var_dump($this->session->businessId);exit;
        $data['page'] = $this->view_goodsList;
        $data['menu'] = array('shop','goodsList');
        $this->load->view('template.html',$data);
    }

    //返回商家商品列表
    function store_goods_list(){
        if($_POST){
            //查询出商家店铺
           $arr = $this->mallShop_model->get_goods_list($this->session->businessId);
           if(empty($arr)){
                echo "2";
           }else{
                echo json_encode($arr);
           }
        }else{
            echo "2";
        }
    }
    //修改商品上下架状态
    function edit_goods_state(){
         if($_POST){
            $data['goods_state'] = $_POST['state'];
            $goods_id = $_POST['goodsid'];
            if($this->mallShop_model->edit_goods_state($goods_id,$data)){
                echo "1";
            }else{
                echo "2";
            }
         }else{
            echo "2";
         }
    }
    //商品详情
    function goodsDetail(){
        $id = intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
            $data['goods'] = $this->mallShop_model->get_goodsInfo($id);
            //所有商品分类
            $data['cates'] = $this->mallShop_model->get_goods_cates();
            $data['page'] = $this->view_goodsDetail;
            $data['menu'] = array('shop','goodsList');       
            $this->load->view('template.html',$data);
        }
    }
    //编辑商品操作
    function edit_goods(){
        if($_POST){
            $data = $this->input->post();
            $pic = array();
            $i =1;
            foreach($_FILES as $file=>$val){
                if(!empty($_FILES['img'.$i]['name'])){
                    $config['upload_path']      = 'upload/goods/';
                    $config['allowed_types']    = 'gif|jpg|png|jpeg';
                    $config['max_size']     = 2048;
                    $config['file_name'] = date('Y-m-d_His');
                    $this->load->library('upload', $config);
                    // 上传
                    if(!$this->upload->do_upload('img'.$i)) {
                       echo $this->upload->display_errors();
                    }else{
                        $pic[]['bannerPic'] = 'upload/goods/'.$this->upload->data('file_name');
                        unset($data['img'.$i]);
                    }
                }else{
                     $pic[]['bannerPic'] = $data['img'.$i];
                     unset($data['img'.$i]);
                }
                $i++;
             }
             $data['good_pic'] = json_encode($pic);
             if($this->mallShop_model->edit_goods($data['goods_id'],$data)){
                 echo "<script>alert('操作成功！');window.location.href='".site_url('/shop/singleShop/goodsList')."'</script>";exit;
             }else{
                 echo "<script>alert('操作失败！');window.location.href='".site_url('/shop/singleShop/goodsDetail').$data['id']."'</script>";exit;
             }
        }else{
            $this->load->view('404.html');
        }
    }

     //新增商品
    function goodsAdd(){
        //所有商品分类
        $data['cates'] = $this->mallShop_model->get_goods_cates();

        $data['page'] = $this->view_goodsAdd;
        $data['menu'] = array('shop','goodsList');       
        $this->load->view('template.html',$data);
    }
    //新增商品操作
    function add_goods(){
        if($_POST){
            $data= $this->input->post();
            $pic = array();
            $i =1;
            echo "<pre>";
            var_dump($data);
            // foreach($_FILES as $file=>$val){
            //     if(!empty($_FILES['img'.$i]['name'])){
            //         $config['upload_path']      = 'upload/goods/';
            //         $config['allowed_types']    = 'gif|jpg|png|jpeg';
            //         $config['max_size']     = 2048;
            //         $config['file_name'] = date('Y-m-d_His');
            //         $this->load->library('upload', $config);
            //         // 上传
            //         if(!$this->upload->do_upload('img'.$i)) {
            //            echo $this->upload->display_errors();
            //         }else{
            //             $pic[]['bannerPic'] = 'upload/goods/'.$this->upload->data('file_name');
            //             }
            //     }
            //     $i++;
            //  }
            //  $data['good_pic'] = json_encode($pic);
            //  $data['storeid'] = '2';
            //  if($this->mallShop_model->add_shop_goods($data)){
            //     echo "<script>alert('操作成功！');window.location.href='".site_url('/shop/singleShop/goodsList')."'</script>";exit;
            //  }else{
            //     echo "<script>alert('操作失败！');window.location.href='".site_url('/shop/singleShop/goodsAdd')."'</script>";exit;
            //  }
        }else{
            $this->load->view('404.html');
        }
    }
    //商品删除
    function del_goods(){
        if($_POST){
            $id = $_POST['goodsid'];
            if($this->mallShop_model->del_goods($id)){
                echo "1";
            }else{
                echo "2";
            }
        }else{
            echo "2";
        }
    }

    //商品搜索
    function search_goods(){
        if($_POST){
            $cate = $_POST['cateid'];
            //单价起价格
            $startPrice = $_POST['startPrice'];
            //单价结束价格
            $endPrice = $_POST['endPrice'];
            //kucun
            $startRepertory = $_POST['startRepertory'];
            $endRepertory = $_POST['endRepertory'];
            //关键字
            $sear = $_POST['sear'];
            if(empty($startPrice) && !empty($endPrice)){
                echo "2";
            }
            if(!empty($startPrice) && empty($endPrice)){
                echo "2"; 
            }
        }else{
            echo "2";
        }
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
   
    //商家促销管理 促销列表
    function shopSalesList(){

        $data['page'] = $this->view_shopSalesList;
        $data['menu'] = array('sales','shopSalesList');
        $this->load->view('template.html',$data);
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


    //商家订单管理
    function shopOrder(){
        $data['storeid'] = $this->session->businessId;
        $data['page'] = $this->view_shopOrder;
        $data['menu'] = array('shop','shopOrder');
        $this->load->view('template.html',$data);
    }

    //获取商家订单列表
    function store_order(){
        if($_POST){
            //获取卖家id
            $storeid = $_POST['storeid'];
            //h获取订单
            $orders = $this->mallShop_model->get_store_orders($storeid);
          
            if(empty($orders)){
                echo "2";
            }else{
                echo json_encode($orders);
            }
        }else{
            echo "2";
        }
    }
    //修改订单状态
    function edit_goods_order(){
        if($_POST){
            $data['order_status'] = $_POST['state'];
            $orderid = $_POST['orderid'];
            if($this->mallShop_model->edit_order_state($orderid,$data)){
                echo "1";
            }else{
                echo "2";
            }

        }else{
            echo "2";
        }
    }
    //提交物流信息
    function send_express(){
        if($_POST){
            $data['logistic_code'] = $_POST['send_no'];
            $data['shipper_code'] = $_POST['send_type'];
            $data['order_status'] = '3';
            $orderid= $_POST['orderid'];
            if($this->mallShop_model->edit_order_state($orderid,$data)){
                echo "1";
            }else{
                echo "2";
            }
        }else{
            echo "2";
        }
    }
    //商家订单编辑
    function shopEditOrder(){
        $id = intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
            $data['order'] = $this->mallShop_model->get_order_info($id);

            $data['page'] = $this->view_sureOrder;
            $data['menu'] = array('shop','shopOrder');
            $this->load->view('template.html',$data);
        }
    }
    //订单管理 详情
    function sureOrder(){

        $id = intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
            $data['order'] = $this->mallShop_model->get_order_info($id);
            $data['page'] = $this->view_shopEditOrder;
            $data['menu'] = array('shop','shopOrder');
            $this->load->view('template.html',$data);
        }
      
    }
}

