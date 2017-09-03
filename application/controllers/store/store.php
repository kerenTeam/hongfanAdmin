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


    //购物中心 订单管理

    public $view_mollOrderList = "moll/mollOrderList.html";

    //商品回收站

    public $view_goodsRecycle = "store/goodsRecycle.html";

    //订单回收站

    public $view_orderRecycle = "store/orderRecycle.html";



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


    //返回商品列表

    function storeGoods_page(){

        if($_POST){

            //获取所有商品

            // $id = $this->input->post('default');

            // if($id ==2){

            //     //推荐商品

            //      $goods_list = $this->MallShop_model->get_remment_goods();

            // }else if($id == 3){

            //     //特价商品

            //      $goods_list = $this->MallShop_model->get_specials_goods();

            // }else{


            // }
            $goods_list = $this->MallShop_model->get_goodslist('4');
            


            //获取商品库存

            // foreach($goods_list as $k=>$v){

            //     //获取商品属性

            //     $parent=  $this->MallShop_model->get_goods_parent($v['goods_id']);

            //     if(!empty($parent)){

            //         $a = '0';

            //         foreach($parent as $key=>$val){

            //             $a += $val['stock'];

            //         }

            //         $goods_list[$k]['amount'] = $a;

            //     }else{

            //         $goods_list[$k]['amount'] = '0';

            //     }

            // } 

            if(empty($goods_list)){

                echo "2";

            }else{

                echo json_encode($goods_list,JSON_UNESCAPED_UNICODE);

            }

        }else{

            echo "2";

        }

    }



    //返回回收站商品列表

    function goodsRecycle(){

         $data['page'] = $this->view_goodsRecycle;

         $data['menu'] = array('store','goodsRecycle');

         $this->load->view('template.html',$data);

    }



    //返回回收站商品数据

    function goodsRecycleList(){

          //获取所有商品

            $id = $this->input->post('default');

          

            $goods_list = $this->MallShop_model->get_godosRecycle();
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
        $q= $this->uri->uri_string();
		$url = preg_replace('|[0-9]+|','',$q);
		if(substr($url,-1) == '/'){
			$url = substr($url,0,-1);
		}
			// var_dump($url);
		$user_power = json_decode($_SESSION['user_power'],TRUE);

		if(!deep_in_array($url,$user_power)){
			echo "<script>alert('您暂无权限执行此操作！请联系系统管理员。');window.history.go(-1);</script>";
					exit;
		}	

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
        $q= $this->uri->uri_string();
		$url = preg_replace('|[0-9]+|','',$q);
		if(substr($url,-1) == '/'){
			$url = substr($url,0,-1);
		}
			// var_dump($url);
		$user_power = json_decode($_SESSION['user_power'],TRUE);

		if(!deep_in_array($url,$user_power)){
			echo "<script>alert('您暂无权限执行此操作！请联系系统管理员。');window.history.go(-1);</script>";
					exit;
		}	

       $data['page'] = $this->view_storeAddGoods;

        $data['menu'] = array('store','storeGoodsList');

         $this->load->view('template.html',$data);

    }

    //编辑商品

    function storeEditGoods(){
        $q= $this->uri->uri_string();
		$url = preg_replace('|[0-9]+|','',$q);
		if(substr($url,-1) == '/'){
			$url = substr($url,0,-1);
		}
			// var_dump($url);
		$user_power = json_decode($_SESSION['user_power'],TRUE);

		if(!deep_in_array($url,$user_power)){
			echo "<script>alert('您暂无权限执行此操作！请联系系统管理员。');window.history.go(-1);</script>";
					exit;
		}	

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
        $q= $this->uri->uri_string();
		$url = preg_replace('|[0-9]+|','',$q);
		if(substr($url,-1) == '/'){
			$url = substr($url,0,-1);
		}
			// var_dump($url);
		$user_power = json_decode($_SESSION['user_power'],TRUE);

		if(!deep_in_array($url,$user_power)){
			echo "<script>alert('您暂无权限执行此操作！请联系系统管理员。');window.history.go(-1);</script>";
					exit;
		}	

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
         $q= $this->uri->uri_string();
		$url = preg_replace('|[0-9]+|','',$q);
		if(substr($url,-1) == '/'){
			$url = substr($url,0,-1);
		}
			// var_dump($url);
		$user_power = json_decode($_SESSION['user_power'],TRUE);

		if(!deep_in_array($url,$user_power)){
			echo "<script>alert('您暂无权限执行此操作！请联系系统管理员。');window.history.go(-1);</script>";
					exit;
		}	

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

            $header = array("token:".trim($token)); 

            $url_ex = APPLOGIN."/api/kdniao/getordertraces";



            //获取物流新词

            if(!empty($order['shipper_code'])){

                //获取物流新词

              

                //发货物流

                $ret = "orderCode=".$order['logistic_code'].'&shipperCode='.$order["shipper_code"].'&logisticCode='.$order['logistic_code'];

                $w = json_decode(curl_post_express($header,$url_ex,$ret),true);

            }else{

                $w['data'] = '';

            }

            //退货物流

            $refund['data'] = '';

            if(!empty($order['saleReturn_num'])){

                $a = explode(',',$order['saleReturn_num']);

                $refund_data = "orderCode=".$a['1'].'&shipperCode='.$a["0"].'&logisticCode='.$a['1'];

                $refund = json_decode(curl_post_express($header,$url_ex,$refund_data),true);

            }

            

            //获取支付信息

            $data['payData'] = $this->MallShop_model->ret_order_paydata($order['order_UUID']);





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

            $url = APPLOGIN."/api/useraccount/login";

            // var_dump($url);

            $arr = array('phone'=>"15828277232","password"=>"123456a");

            $token = curl_post_token($url,$arr);

            $header = array("token:".trim($token)); 

            $url_ex = APPLOGIN."/api/kdniao/getordertraces";

            if(!empty($order['shipper_code'])){

                //获取物流新词

            

                //发货物流

                $ret = "orderCode=".$order['logistic_code'].'&shipperCode='.$order["shipper_code"].'&logisticCode='.$order['logistic_code'];

                $w = json_decode(curl_post_express($header,$url_ex,$ret),true);

            }else{

                $w['data'] = '';

            }

            //退货物流

            $refund['data'] = '';

            if(!empty($order['saleReturn_num'])){

                $a = explode(',',$order['saleReturn_num']);

                $refund_data = "orderCode=".$a['1'].'&shipperCode='.$a["0"].'&logisticCode='.$a['1'];

                $refund = json_decode(curl_post_express($header,$url_ex,$refund_data),true);

            }

            

            $data['express_w'] = $w['data'];

            $data['order'] = $order;

              //获取支付信息

            $data['payData'] = $this->MallShop_model->ret_order_paydata($order['order_UUID']);

            $data['refund_express'] = $refund['data'];







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
        $q= $this->uri->uri_string();
		$url = preg_replace('|[0-9]+|','',$q);
		if(substr($url,-1) == '/'){
			$url = substr($url,0,-1);
		}
			// var_dump($url);
		$user_power = json_decode($_SESSION['user_power'],TRUE);

		if(!deep_in_array($url,$user_power)){
			echo "<script>alert('您暂无权限执行此操作！请联系系统管理员。');window.history.go(-1);</script>";
					exit;
		}	

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



    //删除订单进回收站

    function orderRe(){
        $q= $this->uri->uri_string();
		$url = preg_replace('|[0-9]+|','',$q);
		if(substr($url,-1) == '/'){
			$url = substr($url,0,-1);
		}
			// var_dump($url);
		$user_power = json_decode($_SESSION['user_power'],TRUE);

		if(!deep_in_array($url,$user_power)){
			echo "<script>alert('您暂无权限执行此操作！请联系系统管理员。');window.history.go(-1);</script>";
					exit;
		}	

        if($_POST){

            $id = $_POST['id'];

            $order = $this->MallShop_model->get_order_info($id);

            $data['admin_delOrder'] =  $_POST['state'];

            if($this->MallShop_model->edit_order_state($id,$data)){

                //删除预支付订单

                //$this->db->where('repay_UUID',$order['order_UUID'])->delete("hf_mall_order_repaydata");

                $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."删除了一个订单信息到回收站，订单id是：".$id.';支付订单号是：'.$order['order_UUID'],

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





    //删除订单

    function del_Order(){
        $q= $this->uri->uri_string();
		$url = preg_replace('|[0-9]+|','',$q);
		if(substr($url,-1) == '/'){
			$url = substr($url,0,-1);
		}
			// var_dump($url);
		$user_power = json_decode($_SESSION['user_power'],TRUE);

		if(!deep_in_array($url,$user_power)){
			echo "<script>alert('您暂无权限执行此操作！请联系系统管理员。');window.history.go(-1);</script>";
					exit;
		}	

        if($_POST){

            $id = $_POST['id'];

            $order = $this->MallShop_model->get_order_info($id);

            if($this->MallShop_model->del_store_order($id)){

                //删除预支付订单

                $this->db->where('repay_UUID',$order['order_UUID'])->delete("hf_mall_order_repaydata");

                $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."删除了一个订单信息到回收站，订单id是：".$id.';支付订单号是：'.$order['order_UUID'],

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

            $time = trim($_POST['start_time']).' 00:00:00';

            $endtime = trim($_POST['end_time']) . ' 23:59:59';
            
            $orderid = trim($_POST['orderid']);

            $type = $_POST['type'];

            if(!empty($buyer)){

                //获取买家id

                $query = $this->db->where('nickname',$buyer)->get('hf_user_member');

                $res = $query->row_array();

                $buyer = $res['user_id'];

            }else{

                $buyer = '';

            }

            $list = order_search($state,$buyer,$seller,$time,$endtime,$type,$orderid);

            if(empty($list)){

                echo "2";

            }else{

                echo json_encode($list);

            }



        }else{

            echo "2";

        }    

    }



    //订单回收站

    function orderRecycle(){



        $data['page'] = $this->view_orderRecycle;

        $data['menu'] = array('store','orderRecycle');

        $this->load->view('template.html',$data);

    }



    //获取回收站订单信息

    function ret_orderRecycle(){

        if($_POST){

            $type = $this->input->post('default');

            $order = $this->MallShop_model->ret_orderRe($type);

            if(!empty($order)){

                echo json_encode($order);

            }else{

                echo "3";

            }

        }else{

            echo "2";

        }

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



    //导出商品信息
    function Dow_goodsList(){
            $this->load->library('excel');

            //activate worksheet number 1

            $this->excel->setActiveSheetIndex(0);

            //name the worksheet

            $this->excel->getActiveSheet()->setTitle('ImportOrder');

            $arr_title = array(

                'A' => '商品编号',

                'B' => '商品名称',

                'C' => '商家名称',

                'D' => '所属分类',

                'E' => '售价',

                'F' => '库存',
                
                'G' => '销量',
            );

             //设置excel 表头

            foreach ($arr_title as $key => $value) {

                $this->excel->getActiveSheet()->setCellValue($key . '1', $value);

                $this->excel->getActiveSheet()->getStyle($key . '1')->getFont()->setSize(13);

                $this->excel->getActiveSheet()->getStyle($key . '1')->getFont()->setBold(true);

               $this->excel->getActiveSheet()->getDefaultColumnDimension('A')->setWidth(20);

                $this->excel->getActiveSheet()->getStyle($key . '1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            }

            $i = 1;

            //查询数据库得到要导出的内容


            $bookings = $this->MallShop_model->get_goodslist('4');

          

            if(!empty($bookings)){

            if(count($bookings) > 0)

            {

                foreach ($bookings as $booking) {

                    $i++;

                     //获取商品属性

                    $parent=  $this->MallShop_model->get_goods_parent($booking['goods_id']);

                    if(!empty($parent)){

                        $a = '0';

                        foreach($parent as $key=>$val){

                            $a += $val['stock'];

                        }

                        $booking['amount'] = $a;

                    }else{

                        $booking['amount'] = '0';

                    }

                    $this->excel->getActiveSheet()->setCellValue('A' . $i, $booking['goods_id']);

                    $this->excel->getActiveSheet()->setCellValue('B' . $i, $booking['title']);

                    $this->excel->getActiveSheet()->setCellValue('C' . $i, $booking['store_name']);

                    $this->excel->getActiveSheet()->setCellValue('D' . $i, $booking['catname']);

                    $this->excel->getActiveSheet()->setCellValue('E' . $i, $booking['price']);

                    $this->excel->getActiveSheet()->setCellValue('F' . $i, $booking['amount']);

                    $this->excel->getActiveSheet()->setCellValue('G' . $i, $booking['sales']);

                }

            }



            //日志

            $log = array(

                'userid'=>$_SESSION['users']['user_id'],  

                "content" => $_SESSION['users']['username']."导出了特色馆商品信息",

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
            echo "<script>alert('暂无商品信息！');</script>";
        }
    }











}



