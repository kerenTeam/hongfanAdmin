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
    //自营商品列表
    public $view_sinceGoods = "moll/sinceGoods.html";
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
    //特色馆 HOT推荐管理
    public $view_storeHotRecommand = "store/storeHotRecommand.html";
    //购物中心 订单管理
    public $view_mollOrderList = "moll/mollOrderList.html";

    function __construct()
    {
        parent::__construct();
        $this->load->model('MallShop_model');
        $this->load->model('Shop_model');
        // $this->load->helper('search_helper');
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
        $data['cates'] = $this->MallShop_model->get_goods_cates('0','2');
        $data['page'] = $this->view_storeGoodsList;
        $data['menu'] = array('store','storeGoodsList');
        $this->load->view('template.html',$data);
    }
     ////特色馆  HOT推荐管理
    function storeHotRecommand(){
         $data['page'] = $this->view_storeHotRecommand;
         $data['menu'] = array('moll','storeHotRecommand');
         $this->load->view('template.html',$data);
    }
    //返回商品列表
    function storeGoods_page(){
        if($_POST){
            //获取所有商品
            $id = $this->input->post('default');
            if($id ==2){
                //推荐商品
                 $goods_list = $this->MallShop_model->get_remment_goods();
            }else if($id == 3){
                //特价商品
                 $goods_list = $this->MallShop_model->get_specials_goods();
            }else{
                $goods_list = $this->MallShop_model->get_goodslist('4');
            }

            //获取商品库存
            foreach($goods_list as $k=>$v){
                //获取商品属性
                $parent=  $this->MallShop_model->get_goods_parent($v['goods_id']);
                if(!empty($parent)){
                    $a = '0';
                    foreach($parent as $key=>$val){
                        $a += $val['stock'];
                    }
                    $goods_list[$k]['amount'] = $a;
                }else{
                    $goods_list[$k]['amount'] = '0';
                }
            } 
            if(empty($goods_list)){
                echo "2";
            }else{
                echo json_encode($goods_list,JSON_UNESCAPED_UNICODE);
            }
        }else{
            echo "2";
        }
    }
    //根据分页返回商品数据
    function store_goods_page(){
        if($_POST){
            $page = $this->input->post('page');//页码
            $off = $this->input->post('number');//条数
            $goods_list = $this->MallShop_model->get_goodslist_page($page,$off);
            $data = array(
                'total' => count($this->MallShop_model->get_goodslist()),
                'goods' => $goods_list,
                );
            if(empty($goods_list)){
                echo "2";
            }else{
                echo json_encode($data,JSON_UNESCAPED_UNICODE);
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
            $diff = $_POST['diff'];

            $list = search_goods($diff,$cateid,$state,$sear,$startPrice,$endPrice,$startRepertory,$endRepertory);
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
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."推荐了一个商品信息到首页，商品id是：".$goods_id,
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);
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
         $data['menu'] = array('moll','storeGoodsSort');
         $this->load->view('template.html',$data);
    }
    //返回商品分类列表
    function goods_cates(){
        if($_POST){
            $catelist = $this->MallShop_model->get_goods_cates_list('1');
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
            $goods = $this->MallShop_model->get_goodsInfo($id);
            if($goods['differentiate'] == 1){
                $data['cates'] = $this->MallShop_model->get_goods_cates_list('1');
            }else{
                $data['cates'] = $this->MallShop_model->get_goods_cates_list('2');
            }
            
            //获取商品属性
            $parent = $this->MallShop_model->get_goods_parent($id);
            if(!empty($parent)){
                foreach ($parent as $key => $value) {
                    $stend['0']['name'][] = $value['stend1'];
                    $stend['0']['value'][] = $value['value1'];
                    $stend['1']['name'][]= $value['stend2'];
                    $stend['1']['value'][]= $value['value2'];
                    $stend['2']['name'][]= $value['stend3'];
                    $stend['2']['value'][]= $value['value3'];
                    $stend['3']['name'][] = $value['stend4'];
                    $stend['3']['value'][] = $value['value4'];
                }
                foreach ($stend as $k => $v) {
                    if($v['name'][0] == ''){
                        unset($v);
                    }else{
                        $arr[$k]['name'] = array_unique($v['name']);
                        $arr[$k]['value'] = array_unique($v['value']);
                    }
                }
                $data['parent'] =$arr;
            }else{
                $parent = '';
                $data['parent'] = '';
            }

             $data['shuxing'] = $parent;

             $data['goods'] = $goods;

            $data['page'] = $this->view_storeEditGoods;
            $data['menu'] = array('store','storeGoodsList');
            $this->load->view('template.html',$data);
         }
    }

    //编辑商品
    function mollEditGoods(){
         $id = intval($this->uri->segment(4));
         if($id == 0){
            $this->load->view('404.html');
         }else{
            //获取商品详情
            $goods = $this->MallShop_model->get_goodsInfo($id);
            if($goods['differentiate'] == 1){
                $data['cates'] = $this->MallShop_model->get_goods_cates_list('1');
            }else{
                $data['cates'] = $this->MallShop_model->get_goods_cates_list('2');
            }
            
            //获取商品属性
            $parent = $this->MallShop_model->get_goods_parent($id);
            if(!empty($parent)){
                foreach ($parent as $key => $value) {
                    $stend['0']['name'][] = $value['stend1'];
                    $stend['0']['value'][] = $value['value1'];
                    $stend['1']['name'][]= $value['stend2'];
                    $stend['1']['value'][]= $value['value2'];
                    $stend['2']['name'][]= $value['stend3'];
                    $stend['2']['value'][]= $value['value3'];
                    $stend['3']['name'][] = $value['stend4'];
                    $stend['3']['value'][] = $value['value4'];
                }
                foreach ($stend as $k => $v) {
                    if($v['name'][0] == ''){
                        unset($v);
                    }else{
                        $arr[$k]['name'] = array_unique($v['name']);
                        $arr[$k]['value'] = array_unique($v['value']);
                    }
                }
                $data['parent'] =$arr;
            }else{
                $parent = '';
                $data['parent'] = '';
            }

             $data['shuxing'] = $parent;

             $data['goods'] = $goods;

            $data['page'] = $this->view_storeEditGoods;
            $data['menu'] = array('moll','sinceGoods');
            $this->load->view('template.html',$data);
         }
    }



    //编辑商品操作
    function store_edit_goods(){
        if($_POST){
            $data = $this->input->post();
            $parent = json_decode($data['parameter'],true);
            unset($data['parameter'],$data['ruleSelect'],$data['addNewPropertValue']);
            $pic = array();
 
            for ($i=1; $i < 4; $i++) {
                if(!empty($_FILES['img'.$i]['name'])){
                    $config['upload_path']      = 'Upload/goods/';
                    $config['allowed_types']    = 'gif|jpg|png|jpeg';
                    $config['max_size']     = 2048;
                    $config['file_name'] = date('Y-m-d_His');
                    $this->load->library('upload', $config);
                    // 上传
                    if(!$this->upload->do_upload('img'.$i)) {
                        echo "<script>alert('图片上传失败！');window.location.href='".site_url('/store/store/storeEditGoods/'.$data['id'])."'</script>";exit;
                    }else{
                        unset($data['img'.$i]);
                        if($i == '1'){
                            $data['thumb'] = '/Upload/goods/'.$this->upload->data('file_name');
                        }
                        $pic[]['bannerPic'] = '/Upload/goods/'.$this->upload->data('file_name');
                    }
                }else{
                     if(!empty($data['img'.$i])){
                         if($i == '1'){
                                $data['thumb'] = $data['img'.$i];
                         }
                         $pic[]['bannerPic'] = $data['img'.$i];
                     }
                     unset($data['img'.$i]);
                }
             }
            if(empty(json_decode($data['reduction_rule']))){
                $data['reduction_rule'] = NULL;
            }

             $data['update_time'] = date('Y-m-d H:i:s');
             $data['good_pic'] = json_encode($pic);
             if($this->MallShop_model->edit_goods($data['goods_id'],$data)){
                //刪除商品所有屬性
                $this->MallShop_model->del_goods_prop($data['goods_id']);
                foreach ($parent as $key => $value) {
                    $value['g_id'] = $data['goods_id'];
                    $this->db->insert('hf_mall_goods_property',$value);
                }
                  //日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."编辑了商品信息，商品id是：".$data['goods_id'],
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);
                echo "<script>alert('操作成功！');window.location.href='".site_url('/store/Store/storeGoodsList')."'</script>";exit;
             }else{
                 echo "<script>alert('操作失败！');window.location.href='".site_url('/store/store/storeEditGoods/'.$data['id'])."'</script>";exit;
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
         $data['cates'] = $this->MallShop_model->get_cate_level('1');

         $data['page'] = $this->view_storeAddSort;
         $data['menu'] = array('store','storeGoodsSort');
         $this->load->view('template.html',$data);
    }
    //添加分类操作
    function add_store_cate(){
        if($_POST){
            $data = $this->input->post();
            $data['type'] = '1';
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
                 $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."添加了一个商品分类，分类名称是：".$data['catname'],
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);
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
             $data['cates'] = $this->MallShop_model->get_cate_level('1');
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
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."编辑了一个商品分类，分类名称是：".$data['catname'].",分类id是：".$data['catid'],
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);
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
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."删除了一个商品分类，分类id是：".$id,
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);
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
            $cates = $this->MallShop_model->search_cates($sear,'1');
            echo json_encode($cates);
        }else{
            echo "2";
        }
    }

    //特色馆订单管理
    function storeOrderList(){
        //获取所有商家
        $data['store'] = $this->MallShop_model->ret_store_type('2','2');
        $data['page'] = $this->view_storeOrderList;
        $data['menu'] = array('store','storeOrderList');
        $this->load->view('template.html',$data);
    }

    //获取所有订单
    function Order_page(){
        if($_POST){
            $type =  $this->input->post('default');
            $order = $this->MallShop_model->get_order_list($type);
          
            if(empty($order)){
                echo "2";
            }else{
                echo json_encode($order);
            }
        }else{
            echo "4";
        }
    }

    //购物中心 订单
    function mollOrder(){
        
        $data['page'] = $this->view_mollOrderList;
        $data['menu'] = array('moll','mollOrder');
        $this->load->view('template.html',$data);
    }
    function order_info(){
        $id= intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
            $order = $this->MallShop_model->get_order_info($id);
            if(!empty($order)){
                echo json_encode($order);
            }else{
                echo "3";
            }
        }
    }

    //订单管理 订单详情
    function storeOrderDetail(){
        $id = intval($this->uri->segment(4));
        if($id != 0){
            //获取订单详情
            $order = $this->MallShop_model->get_order_info($id);

          //获取收货地址
            $data['address'] = $this->MallShop_model->ret_user_address($order['buyer_address']);
            //后去运费模板
            $express = json_decode($order['userPostData'],true);
            $data['express'] = $this->MallShop_model->ret_store_express($express['express_id']);
            //模拟登陆APP
            $url = APPLOGIN."/api/useraccount/login";
            // var_dump($url);
            $arr = array('phone'=>"15828277232","password"=>"123456a");
            $token = curl_post_token($url,$arr);
            //获取物流新词
            $url_ex = APPLOGIN."/api/kdniao/getordertraces";
            //发货物流
            $ret = "orderCode=".$order['logistic_code'].'&shipperCode='.$order["shipper_code"].'&logisticCode='.$order['logistic_code'];
            $header = array("token:".trim($token)); 
            $w = json_decode(curl_post_express($header,$url_ex,$ret),true);
            //退货物流
            $refund['data'] = '';
            if(!empty($order['saleReturn_num'])){
                $a = explode(',',$order['saleReturn_num']);
                $refund_data = "orderCode=".$a['1'].'&shipperCode='.$a["0"].'&logisticCode='.$a['1'];
                $refund = json_decode(curl_post_express($header,$url_ex,$refund_data),true);
                
            }
            
            $data['express_w'] = $w['data'];
            $data['refund_express'] = $refund['data'];
            $data['order'] = $order;

            
             $data['page'] = $this->view_storeOrderDetail;
             $data['menu'] = array('store','storeOrderList');
             $this->load->view('template.html',$data);
        }else{
            $this->load->view('404.html');
        }
    }

    //购物中心 订单详情
    function moll_order_info(){
        $id = intval($this->uri->segment(4));
        if($id != 0){
            //获取订单详情
            $order = $this->MallShop_model->get_order_info($id);

                        //获取收货地址
            $data['address'] = $this->MallShop_model->ret_user_address($order['buyer_address']);
            //后去运费模板
            $express = json_decode($order['userPostData'],true);
            $data['express'] = $this->MallShop_model->ret_store_express($express['express_id']);
            //模拟登陆APP
        //     $url = APPLOGIN."/api/useraccount/login";
        //     // var_dump($url);
        //     $arr = array('phone'=>"15828277232","password"=>"123456a");
        //     $token = curl_post_token($url,$arr);
        //     //获取物流新词
        //     $url_ex = APPLOGIN."/api/kdniao/getordertraces";
        //  //   $ret = array("orderCode"=>$order['logistic_code'],"shipperCode"=>$order["shipper_code"],"logisticCode"=>$order['logistic_code']);
        //     $ret = "orderCode=".$order['logistic_code'].'&shipperCode='.$order["shipper_code"].'&logisticCode='.$order['logistic_code'];
        //     $header = array("token:".trim($token)); 
        //     $w = json_decode(curl_post_express($header,$url_ex,$ret),true);
            
        //     $data['express_w'] = $w['data'];
            $data['order'] = $order;



            $data['id'] = $id;
             $data['page'] = $this->view_storeOrderDetail;
             $data['menu'] = array('moll','mollOrder');
             $this->load->view('template.html',$data);
        }else{
            $this->load->view('404.html');
        }
    }
    //订单退款成功
    function refund_price(){
        if($_POST){
            $orderid = $this->input->post('order_id');
            $arr['order_status'] = '8'; 
            if($this->MallShop_model->edit_order_state($orderid,$arr)){
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."修改了一个订单为退款成功状态，订单id 是：".$orderid,
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);

                 //获取用户id
                $order = $this->MallShop_model->get_order_info($orderid);
                //获取用户电话
                $user = $this->user_model->get_user_info($order['buyer']);
                //模拟登陆APP
                $url = APPLOGIN."/api/useraccount/login";
                // var_dump($url);
                $arr = array('phone'=>"15828277232","password"=>"123456a");
                $token = curl_post_token($url,$arr);
                $header = array("token:".trim($token)); 
                $post_url = APPLOGIN."/api/index/sendsms";
                $ret = 'phoneNum='.$user['phone'].'&SMScontent='."hi，小主，感谢您惠顾HI集，您所购买的宝贝HI集已为您办理退款，退款将原路返回您支付账户，请注意查收。祝您生活愉快！【HI集】";
                $a = curl_post_express($header,$post_url,$ret);

                echo "1";
            }else{
                echo "2";
            }
        }else{
            echo "3";
        }
    }




    //删除订单
    function del_Order(){
        if($_POST){
            $id = $_POST['id'];
            if($this->MallShop_model->del_store_order($id)){
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."删除了一个订单信息，订单id是：".$id,
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);
                echo "1";
            }else{
                echo "2";
            }
        }else{
            echo "2";
        }
    }

    //订单搜索
    function order_search(){
        if($_POST){
            $state = $_POST['order_status'];
            $buyer = trim($_POST['buyer']);
            $seller = trim($_POST['seller']);
            $time = trim($_POST['start_time']);
            $endtime = trim($_POST['end_time']);
            $type = $_POST['type'];
            if(!empty($buyer)){
                //获取买家id
                $query = $this->db->where('username',$buyer)->get('hf_user_member');
                $res = $query->row_array();
                $buyer = $res['user_id'];
            }else{
                $buyer = '';
            }
            $list = order_search($state,$buyer,$seller,$time,$endtime,$type);
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
         $data['menu'] = array('moll','storeGoodsSales');
         $this->load->view('template.html',$data);
     }
     //删除展销
     function del_Sales(){
        $id = intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
            if($this->MallShop_model->del_Sales($id)){
                echo "<script>alert('操作成功！');window.location.href='".site_url('/store/Store/storeGoodsSales')."'</script>";exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/store/Store/storeGoodsSales')."'</script>";exit;
            }
        }
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
                           $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  
                        "content" => $_SESSION['users']['username']."删除了id为".$id."的展销商品，商品id是".$goodsid,
                        "create_time" => date('Y-m-d H:i:s'),
                        "userip" => get_client_ip(),
                    );
                    $this->db->insert('hf_system_journal',$log);
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
                  if($this->MallShop_model->edit_salse($id,$data)){
                           $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  
                        "content" => $_SESSION['users']['username']."新增了id为".$id."的展销商品，商品id是".$data['goods_list'],
                        "create_time" => date('Y-m-d H:i:s'),
                        "userip" => get_client_ip(),
                    );
                    $this->db->insert('hf_system_journal',$log);
                echo "1";
            }else{
                echo "2"; 
            }
        }else{
            echo "2";
        }
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
                    $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  
                        "content" => $_SESSION['users']['username']."新增了一个展销信息，展销名称是：".$data['title'],
                        "create_time" => date('Y-m-d H:i:s'),
                        "userip" => get_client_ip(),
                    );
                    $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/store/Store/storeGoodsSales')."'</script>";exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/store/Store/storeGoodsList')."'</script>";exit;
            }
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
             $log = array(
                'userid'=>$_SESSION['users']['user_id'],  
                "content" => $_SESSION['users']['username']."修改了一个商品展销信息图片，展销id是：".$id,
                "create_time" => date('Y-m-d H:i:s'),
                "userip" => get_client_ip(),
            );
            $this->db->insert('hf_system_journal',$log);
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


     //返回排序后的商品信息
     function get_sort_goods(){
        if($_POST){
            $sort = $_POST['sort'];
            $list = '';
            switch ($sort) {
                //按最近时间排序
                case '1':
                    $list = $this->MallShop_model->get_goods_time("desc");
                    break;   
                //按时间倒叙排序
                case '2':
                    $list = $this->MallShop_model->get_goods_time("asc");
                    break;   
                 //按库存多到少排序
                case '3':
                    $list = $this->MallShop_model->get_goods_amout("desc");
                    break;
                 //按库存少到多排序
                case '4':
                     $list = $this->MallShop_model->get_goods_amout("asc");
                    break;
                 //按价格从高到低排序
                case '5':
                    $list = $this->MallShop_model->get_goods_price("desc");
                    break;
                 //按价格从低到高排序
                case '6':
                    $list = $this->MallShop_model->get_goods_price("asc");
                    break;
            }
            if(empty($list)){
                echo "3";
            }else{
                echo json_encode($list);
            }
        }else{
            echo "2";
        }
     }
     //自营商品列表
     function sinceGoods(){
        //获取商品分类
           $id = intval($this->uri->segment(4));
        // var_dump($id);
        if($id == 0){
            $data['saleid'] ='';
        }else{
            $data['saleid'] = $id;
        }
         $data['cates'] = $this->MallShop_model->get_goods_cates('0','1');
         $data['page'] = $this->view_sinceGoods;
         $data['menu'] = array('moll','sinceGoods');
         $this->load->view('template.html',$data);
     }

     //返回自用商品列表
     function get_since_goods(){
         if($_POST){
            $type = $this->input->post('default');
            $goods_list  = $this->MallShop_model->get_since_goodslist($type);            
            //获取商品库存
            foreach($goods_list as $k=>$v){
                //获取商品属性
                $parent=  $this->MallShop_model->get_goods_parent($v['goods_id']);
                if(!empty($parent)){
                    $a = '0';
                    foreach($parent as $key=>$val){
                        $a += $val['stock'];
                    }
                    $goods_list[$k]['amount'] = $a;
                }else{
                    $goods_list[$k]['amount'] = '0';
                }
            } 
            

            if(!empty($goods_list)){
                echo json_encode($goods_list);
            }else{
                echo "3";
            }
         }else{
             echo "2";
         }
     }


     //导出特色管订单
     function Import_mollOrder(){
         if($_POST){
            $storeid = $this->input->post('storeid');
            $start_time = $this->input->post('begin_date');
            $end_time = $this->input->post('end_date');
            
            $this->load->library('excel');
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('ImportOrder');
            $arr_title = array(
                'A' => '订单号',
                'B' => '支付订单号',
                'C' => '支付方式',
                'D' => '商品名称和数量',
                'E' => '单价',
                'F' => '运费',
                'G' => '支付金额',
                'H' => '积分使用情况',
                'I' => '',
                'J' => '市',
                'K' => '区',
                'L' => '买家留言',
                'M' => '产品信息(产品id_产品属性ID|数量,产品id|数量)，产品属性ID在前台商家中心-商品列表中点击商品编号查看属性ID',
                'N' => '支付方式',
                'O' => '运输方式'
            );
                  //设置excel 表头
            foreach ($arr_title as $key => $value) {
                $this->excel->getActiveSheet()->setCellValue($key . '1', $value);
                $this->excel->getActiveSheet()->getStyle($key . '1')->getFont()->setSize(13);
                $this->excel->getActiveSheet()->getStyle($key . '1')->getFont()->setBold(true);
               $this->excel->getActiveSheet()->getDefaultColumnDimension('A')->setWidth(20);
                $this->excel->getActiveSheet()->getStyle($key . '1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }




                   if(!empty($bookings)){
            if(count($bookings) > 0)
            {
                foreach ($bookings as $booking) {
                    $i++;
                    $user = json_decode($booking['goods_data'],true);
                    //地址
                   $address = $this->Integral_model->get_user_address($booking['buyer_address']);
                   //省份证
                   $id_card = $this->Integral_model->ret_user_info($booking['buyer']);
                   //留言
                   $notice = json_decode($booking['userPostData'],true);
                   

                    foreach ($user['goods_Data'] as $key => $value) {
                         $goods[$i][$key]= $value['id'].'|'.$value['nums'];
                    }
                    $good = implode(',',$goods[$i]);
                 //   $this->excel->getActiveSheet()->setCellValue('A' . $i,  $i - 1);
                    $this->excel->getActiveSheet()->setCellValue('A' . $i, $booking['order_UUID']);
                    $this->excel->getActiveSheet()->setCellValue('B' . $i, $address['person']);
                    $this->excel->getActiveSheet()->setCellValue('C' . $i, ' '.$id_card);
                    $this->excel->getActiveSheet()->setCellValue('D' . $i, $address['address']);
                    $this->excel->getActiveSheet()->setCellValue('E' . $i, $address['phone']);
                    $this->excel->getActiveSheet()->setCellValue('F' . $i, '');
                    $this->excel->getActiveSheet()->setCellValue('G' . $i, '');
                    $this->excel->getActiveSheet()->setCellValue('H' . $i, '400000');
                    $this->excel->getActiveSheet()->setCellValue('I' . $i, $address['province']);
                    $this->excel->getActiveSheet()->setCellValue('J' . $i, $address['city']);
                    $this->excel->getActiveSheet()->setCellValue('K' . $i, $address['area']);
                    $this->excel->getActiveSheet()->setCellValue('L' . $i, $notice['notice']);
                    $this->excel->getActiveSheet()->setCellValue('M' . $i, $good);
                    $this->excel->getActiveSheet()->setCellValue('N' . $i, 'allinpay');
                    $this->excel->getActiveSheet()->setCellValue('O' . $i, 'EMS');
                   
                }
            }

            //日志
            $log = array(
                'userid'=>$_SESSION['users']['user_id'],  
                "content" => $_SESSION['users']['username']."导出了爱购商品订单信息",
                "create_time" => date('Y-m-d H:i:s'),
                "userip" => get_client_ip(),
            );
            $this->db->insert('hf_system_journal',$log);


            $filename = 'ImportOrder.xls'; //save our workbook as this file name
           /// var_dump($filename);
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

             $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
             $objWriter->save('php://output');
             exit;
            }else{
                echo "<script>alert('暂无订单记录！');window.location.href='".site_url('/igo/LoveToGo/')."'</script>";
            }


         }
     }




}

