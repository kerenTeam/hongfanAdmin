<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  商城管理
 *
 * */
require_once(APPPATH.'controllers/Default_Controller.php');

class Store extends Default_Controller {
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
    //订单详情
    public $view_storeOrderDetail = "store/storeOrderDetail.html";
    //主题展销商品管理
    public $view_storeGoodsSales = "store/storeGoodsSales.html";

    function __construct()
    {
        parent::__construct();
        $this->load->model('MallShop_model');
    }
    //商品列表
    function storeGoodsList(){
        $id = intval($this->uri->segment(4));
        // var_dump($id);
        if($id == 0){
            $data['saleid'] ='';
        }else{
            $data['saleid'] = $id;
        }
        $data['cates'] = $this->MallShop_model->get_goods_cates('0');
        $data['page'] = $this->view_storeGoodsList;
        $data['menu'] = array('store','storeGoodsList');
        $this->load->view('template.html',$data);
    }
    //返回商品列表
    function storeGoods_page(){
        if($_POST){
            //获取所有商品
            $goods_list = $this->MallShop_model->get_goodslist();
            if(empty($goods_list)){
                echo "2";
            }else{
                echo json_encode($goods_list,JSON_UNESCAPED_UNICODE);
            }
        }else{
            echo "2";
        }
    }
    //搜索商品
    function goods_search(){
        if($_POST){
            $cateid = $_POST['cateid'];
            $state = $_POST['state'];
            $sear = $_POST['sear'];
            $startPrice = $_POST['startPrice'];
            $endPrice = $_POST['endPrice'];
            $startRepertory = $_POST['startRepertory'];
            $endRepertory = $_POST['endRepertory'];

            $list = search_goods($cateid,$state,$sear,$startPrice,$endPrice,$startRepertory,$endRepertory);
            if(empty($list)){
                echo "2";
            }else{
                echo json_encode($list);
            }
        }else{
            echo "2";
        }
    }

    //推荐商品到首页
    function edit_recommend(){
        if($_POST){
            $goods_id = $_POST['goodsid'];
            $recommend = $_POST['state'];
            $data['recommend'] = $recommend;
            if($this->MallShop_model->edit_goods_state($goods_id,$data)){
                echo "1";
            }else{
                echo "2";
            }
        }else{
            echo "2";
        }
    }


    //商品分类
    function storeGoodsSort(){
         $data['page'] = $this->view_storeGoodsSort;
         $data['menu'] = array('store','storeGoodsSort');
         $this->load->view('template.html',$data);
    }
    //返回商品分类列表
    function goods_cates(){
        if($_POST){
            $catelist = $this->MallShop_model->get_goods_cates_list();
            echo json_encode($catelist);
        }else{
            echo "2";
        }
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
         $id = intval($this->uri->segment(4));
         if($id == 0){
            $this->load->view('404.html');
         }else{
            //获取商品详情
            $data['goods'] = $this->MallShop_model->get_goodsInfo($id);
            $data['cates'] = $this->MallShop_model->get_goods_cates('0');
            $data['page'] = $this->view_storeEditGoods;
            $data['menu'] = array('store','storeGoodsList');
            $this->load->view('template.html',$data);
         }
    }
    //编辑商品操作
    function store_edit_goods(){
        if($_POST){
               $data = $this->input->post();
            $pic = array();
            $i =1;
            foreach($_FILES as $file=>$val){
                if(!empty($_FILES['img'.$i]['name'])){
                    $config['upload_path']      = 'Upload/goods/';
                    $config['allowed_types']    = 'gif|jpg|png|jpeg';
                    $config['max_size']     = 2048;
                    $config['file_name'] = date('Y-m-d_His');
                    $this->load->library('upload', $config);
                    // 上传
                    if(!$this->upload->do_upload('img'.$i)) {
                        echo "<script>alert('图片上传失败！');window.location.href='".site_url('/store/Store/storeEditGoods/'.$data['id'])."'</script>";exit;
                    }else{
                        if($i == '1'){
                            $data['thumb'] = '/Upload/goods/'.$this->upload->data('file_name');
                        }
                        $pic[]['bannerPic'] = '/Upload/goods/'.$this->upload->data('file_name');
                        unset($data['img'.$i]);
                    }
                }else{
                    if($i == '1'){
                            $data['thumb'] = $data['img'.$i];
                    }
                      if(!empty($data['img'.$i])){
                     $pic[]['bannerPic'] = $data['img'.$i];
                     }
                     unset($data['img'.$i]);
                }
                $i++;
             }
             $data['update_time'] = date('Y-m-d H:i:s');
             $data['good_pic'] = json_encode($pic);
             if($this->MallShop_model->edit_goods($data['goods_id'],$data)){
                 echo "<script>alert('操作成功！');window.location.href='".site_url('/store/Store/storeGoodsList')."'</script>";exit;
             }else{
                 echo "<script>alert('操作失败！');window.location.href='".site_url('/store/Store/storeEditGoods/'.$data['id'])."'</script>";exit;
             }
        }else{
            $this->load->view('404.html');
        }
    }

    //审核商品
    function storeGoodsCheck(){
        $data['page'] = $this->view_storeGoodsCheck;
        $data['menu'] = array('store','storeGoodsCheck');
         $this->load->view('template.html',$data);
    }
    //添加分类
    function storeAddSort(){
        //获取顶级分类
         $data['cates'] = $this->MallShop_model->get_cate_level();

         $data['page'] = $this->view_storeAddSort;
         $data['menu'] = array('store','storeGoodsSort');
         $this->load->view('template.html',$data);
    }
    //添加分类操作
    function add_store_cate(){
        if($_POST){
            $data = $this->input->post();

            if(!empty($_FILES['icon']['tmp_name'])){
                $config['upload_path']      = 'Upload/icon';
                $config['allowed_types']    = 'jpg|png|jpeg';
                $config['max_size']     = 2048;
                $config['file_name'] = date('Y-m-d_His');
                $this->load->library('upload', $config);
                //上传
                if ( ! $this->upload->do_upload('icon')) {
                    echo "<script>alert('图片上传失败！');window.location.href='".site_url('/store/Store/storeAddSort/')."'</script>";
                    exit;
                } else{
                    $data['icon'] =  '/Upload/icon/'.$this->upload->data('file_name');
                }
            }
            if($this->MallShop_model->add_store_cate($data)){
                echo  "<script>alert('操作成功！');window.location.href='".site_url('/store/Store/storeGoodsSort')."'</script>";
            }else{
                echo  "<script>alert('操作失败！');window.location.href='".site_url('/store/Store/storeAddSort')."'</script>";
            }
        }else{
            $this->load->view('404.html');
        }
    }
    //编辑分类
    function storeEditSort(){
         $id = intval($this->uri->segment(4));
         if($id == 0){
            $this->load->view('404.html');
         }else{
             //获取顶级分类
             $data['cates'] = $this->MallShop_model->get_cate_level();
             $data['cateinfo'] = $this->MallShop_model->get_cateInfo($id);
             $data['page'] = $this->view_storeEditSort;
             $data['menu'] = array('store','storeGoodsSort');
            $this->load->view('template.html',$data);
         }
    }
    //编辑分类操作
    function edit_store_cate(){
        if($_POST){
            $data = $this->input->post();
            if(!empty($_FILES['icon']['tmp_name'])){
                $config['upload_path']      = 'Upload/icon';
                $config['allowed_types']    = 'jpg|png|jpeg';
                $config['max_size']     = 2048;
                $config['file_name'] = date('Y-m-d_His');
                $this->load->library('upload', $config);
                //上传
                if ( ! $this->upload->do_upload('icon')) {
                    echo "<script>alert('图片上传失败！');window.location.href='".site_url('/store/Store/storeEditSort/'.$data['catid'])."'</script>";
                    exit;
                } else{
                    $data['icon'] =  '/Upload/icon/'.$this->upload->data('file_name');
                }
            }
            if($this->MallShop_model->edit_store_cate($data['catid'],$data)){
                 echo "<script>alert('操作成功！');window.location.href='".site_url('/store/Store/storeGoodsSort')."'</script>";
             }else{
                 echo "<script>alert('操作失败！');window.location.href='".site_url('/store/Store/storeEditSort/'.$data['catid'])."'</script>";
             }
        }else{
            $this->load->view('404.html');
        }
    }

    //删除分类
    function del_store_cate(){
        if($_POST){
            $id = $_POST['id'];
            if($this->MallShop_model->del_store_cate($id)){
                echo "1";
            }else{
                echo "2";
            }
        }else{
            echo "2";
        }
    }
    //分类搜索
    function search_cate(){
        if($_POST){
            $sear = $_POST['sear'];
            $cates = $this->MallShop_model->search_cates($sear);
            echo json_encode($cates);
        }else{
            echo "2";
        }
    }

    //订单管理
    function storeOrderList(){
        $data['page'] = $this->view_storeOrderList;
        $data['menu'] = array('store','storeOrderList');
         $this->load->view('template.html',$data);
    }

    //获取所有订单
    function Order_page(){
        if($_POST){
            $order = $this->MallShop_model->get_order_list();
            if(empty($order)){
                echo "2";
            }else{
                echo json_encode($order);
            }
        }else{
            echo "2";
        }
    }


    //订单管理 订单详情
    function storeOrderDetail(){
        $id = intval($this->uri->segment(4));
        if($id != 0){
            //获取订单详情
             $data['order'] = $this->MallShop_model->get_order_info($id);

             $data['page'] = $this->view_storeOrderDetail;
             $data['menu'] = array('store','storeOrderList');
             $this->load->view('template.html',$data);
        }else{
            $this->load->view('404.html');
        }
    }

    //订单搜索
    function order_search(){
        if($_POST){
            $state = $_POST['order_status'];
            $startPrice = trim($_POST['startPrice']);
            $endPrice = trim($_POST['endPrice']);
            $buyer = trim($_POST['buyer']);
            $seller = trim($_POST['seller']);
            $time = trim($_POST['create_time']);
            if(!empty($buyer)){
                //获取买家id
                $query = $this->db->where('username',$buyer)->get('hf_user_member');
                $res = $query->row_array();
                $buyer = $res['user_id'];
            }else{
                $buyer = '';
            }
            if(!empty($seller)){
                //获取卖家商铺id
                $query1 = $this->db->where('store_name',$seller)->get('hf_shop_store');
                $res1 = $query1->row_array();
                $seller = $res1['store_id'];
            }else{
                $seller = '';
            }
            $list = order_search($state,$startPrice,$endPrice,$buyer,$seller,$time);
            if(empty($list)){
                echo "2";
            }else{
                echo json_encode($list);
            }

        }else{
            echo "2";
        }    
    }
    //主题展销商品管理
    function storeGoodsSales(){
        //获取所有展销商品
        $sales = $this->MallShop_model->get_active_sales('1');
        foreach ($sales as $key => $value) {
            $goods = explode(',', $value['goods_list']);
            foreach ($goods as $k => $v) {
                 $sales[$key]['goods'][] = $this->MallShop_model->get_goods_title($v);
            }
           
        }
         $data['sales'] = $sales;
         $data['page'] = $this->view_storeGoodsSales;
         $data['menu'] = array('store','storeGoodsSales');
         $this->load->view('template.html',$data);
     }
     // 删除展销某个活动的产品
     function del_sales_goods(){
        if($_POST){
            $id = $_POST['id'];
            $goodsid = $_POST['goodsid'];
            if(empty($id) || empty($goodsid)){
                echo "2";
            }else{
                $sale = $this->MallShop_model->get_sales_info($id);
                $goods = explode(',',$sale['goods_list']);
                foreach ($goods as $key => $value) {
                   if($value == $goodsid){
                     unset($goods[$key]);
                   }
                }
                $data['goods_list'] = implode(',',$goods);
                if($this->MallShop_model->edit_salse($id,$data)){
                    echo "1";
                }else{
                    echo "2";
                }
            }
        }else{  
            echo "2";
        }
     }

     //新增某个展销商品
     function add_sales_goods(){
        if($_POST){
            $id = $_POST['id'];
            $goodsid = json_decode($_POST['goodsid'],true);
            $sale = $this->MallShop_model->get_sales_info($id);
            $goods = explode(',',$sale['goods_list']);
            $arr = array_unique(array_merge($goodsid,$goods));
            $data['goods_list'] = implode(',',$arr);
            if($this->MallShop_model->edit_salse($id,$data)){
                echo "1";
            }else{
                echo "2";
            }
        }else{
            echo "2";
        }
     }

     //新增展销
     function add_sales(){
        if($_POST){
            $data = $this->input->post();
            if(!empty($_FILES['img']['tmp_name'])){
                $config['upload_path']      = 'Upload/adver';
                $config['allowed_types']    = 'jpg|png|jpeg';
                $config['max_size']     = 2048;
                $config['file_name'] = date('Y-m-d_His');
                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload('img')) {
                    echo "<script>alert('图片上传失败！');window.location.href='".site_url('/store/Store/storeGoodsList')."'</script>";
                    exit;
                } else{
                    $img[]['picImg'] =  '/Upload/adver/'.$this->upload->data('file_name');
                }
            }
            $data['goods_list'] = implode(',',json_decode($data['goodsid'],true));
            unset($data['goodsid']);
            $data['picImg'] = json_encode($img);
            $data['type'] = '1';
            if($this->MallShop_model->add_sales($data)){
                echo "<script>alert('操作成功！');window.location.href='".site_url('/store/Store/storeGoodsSales')."'</script>";exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/store/Store/storeGoodsList')."'</script>";exit;
            }
        }else{
            echo '2';
        }
     }

    //展销图片修改
    function edit_sales_img(){
        $id = $_POST['id'];
        if(!empty($_FILES['file']['tmp_name'])){
            $config['upload_path']      = 'Upload/adver';
            $config['allowed_types']    = 'jpg|png|jpeg';
            $config['max_size']     = 2048;
            $config['file_name'] = date('Y-m-d_His');
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('file')) {
                echo "<script>alert('图片上传失败！');window.location.href='".site_url('/store/Store/storeGoodsList')."'</script>";
                exit;
            } else{
                $img[]['picImg'] =  '/Upload/adver/'.$this->upload->data('file_name');
            }
        }
        $data['picImg'] = json_encode($img);
        if($this->MallShop_model->edit_salse($id,$data)){
            echo "1";exit;
        }else{
            echo "2";exit;
        }
     }

    //快递管理
    function storeDeliveryList(){
         $data['page'] = $this->view_storeDeliveryList;
         $data['menu'] = array('store','storeDeliveryList');
         $this->load->view('template.html',$data);
     }
}

