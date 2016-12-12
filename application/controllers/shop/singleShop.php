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

    function __construct()
    {
        parent::__construct();
        $this->load->model('mallShop_model');
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
        //分类
        $data['cates'] = $this->mallShop_model->get_goods_cates();

        $data['page'] = $this->view_goodsList;
        $data['menu'] = array('shop','goodsList');
        $this->load->view('template.html',$data);
    }

    //返回商家商品列表
    function store_goods_list(){
        if($_POST){
            //查询出商家有几个店铺
           $store = $this->mallShop_model->get_store_list($this->session->businessId);
           
           $arr = $this->mallShop_model->get_goods_list($store_id['store_id']);
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
                        }
                }
                $i++;
             }
             $data['good_pic'] = json_encode($pic);
             $data['storeid'] = '2';
             if($this->mallShop_model->add_shop_goods($data)){
                echo "<script>alert('操作成功！');window.location.href='".site_url('/shop/singleShop/goodsList')."'</script>";exit;
             }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/shop/singleShop/goodsAdd')."'</script>";exit;
             }
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
            $storeid = $_POST['storeid'];
            
        }else{

        }
    }


    //商家订单编辑
    function shopEditOrder(){
        $this->load->view('shop/shopEditOrder.html');
    }
    //订单管理 确认订单
    function sureOrder(){
        $this->load->view('shop/sureOrder.html');
    }
}

