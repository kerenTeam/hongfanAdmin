<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Default_Controller.php');

/*

*   发现板块

*/

class Finance extends Default_Controller {



    public $view_finance_order = "finance/finance_order.html";

    public $view_financeOrder_info = "finance/financeOrder_info.html";

    public $view_loveTogoOrder_info = "finance/loveTogoOrder_info.html";



    function __construct()

    {

        parent::__construct();

        $this->load->model('MallShop_model');

        $this->load->model('Integral_model');

    }





    function mallOrder(){

        //获取所有商家

        $data['store'] = $this->MallShop_model->ret_mollStore();

        $data['page'] = $this->view_finance_order;

        $data['menu'] = array('finance','mallOrder');

        $this->load->view('template.html',$data);

    }



    //返回所有以支付订单订单

    function ret_moll_order(){

        if($_POST){

            $list = $this->MallShop_model->get_moll_order();

            if(!empty($list)){

                echo json_encode($list);

            }else{

                echo "3";

            }

        }else{

            echo "2";

        }

    }



    //查看详情

    function mollOrder_info(){

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

                //$url_ex = APPLOGIN."/api/kdniao/getordertraces";

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

            

             $data['menu'] = array('finance','mallOrder');

             if($order['order_type'] !='0'){

                $data['page'] = $this->view_financeOrder_info;

                $this->load->view('template.html',$data);

             }else{

                 $data['id_card'] = $this->Integral_model->ret_user_info($order['buyer']);

                $data['page'] = $this->view_loveTogoOrder_info;

                $this->load->view('template.html',$data);

             }

        }else{

            $this->load->view('404.html');

        }

    }



    //财务订单搜索

    function search_mollOrder(){

         if($_POST){

            $state = $_POST['order_status'];

            $seller = trim($_POST['seller']);

            $start_time = trim($_POST['start_time']);

            $end_time = trim($_POST['end_time']);

            $sear = trim($_POST['sear']);

            $paytype = trim($_POST['paytype']);

            if(!empty($start_time)){
                $time = $start_time .' 00:00:00';
                $endtime = $end_time . ' 23:59:59';
            }



            $res= '';

            if(!empty($state) && empty($seller) && empty($time) && empty($sear) && empty($paytype)){

                 $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');
        $this->db->from('hf_mall_order as a');
        $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');
        $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
        $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');

                $query = $this->db->where('order_status !=','1')->where('order_status',$state)->order_by('a.create_time','desc')->get();

                $res = $query->result_array();

            }elseif(empty($state ) && !empty($seller) && empty($time) && empty($sear) && empty($paytype)){

                if($seller == '-1'){

                    $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');
                    $this->db->from('hf_mall_order as a');
                    $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');
                    $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                    $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');

                    $query = $this->db->where('order_status !=','1')->where('a.order_type','0')->order_by('a.create_time','desc')->get();

                    $res = $query->result_array();

                }else{
                    $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');
                    $this->db->from('hf_mall_order as a');
                    $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');
                    $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                    $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');

                    $query = $this->db->where('order_status !=','1')->where('a.seller',$seller)->order_by('a.create_time','desc')->get();

                    $res = $query->result_array();
                }

             

            }elseif(empty($state ) && empty($seller) && !empty($time) && empty($sear) && empty($paytype)){

                 $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');
                $this->db->from('hf_mall_order as a');
                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');
                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');

                $query = $this->db->where('order_status !=','1')->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->order_by('a.create_time','desc')->get();

                $res = $query->result_array();



            }elseif(empty($state ) && empty($seller) && empty($time) && !empty($sear) && empty($paytype)){

           

                $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');
                $this->db->from('hf_mall_order as a');
                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');
                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');

                $query = $this->db->where('order_status !=','1')->like('a.order_UUID',$sear,'both')->order_by('a.create_time','desc')->get();

                $res = $query->result_array();

            }elseif(empty($state ) && empty($seller) && empty($time) && empty($sear) && !empty($paytype)){

                $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');

                $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');

                $query = $this->db->where('order_status !=','1')->where('d.payType',$paytype)->get();

                $res = $query->result_array();
            }

            //二个    

            elseif(!empty($state ) && !empty($seller) && empty($time) && empty($sear) && empty($paytype)){

                 if($seller == '-1'){

                     
                     $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');
                    $this->db->from('hf_mall_order as a');
                    $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');
                    $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                    $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');

                    $query = $this->db->where('order_status !=','1')->where('order_status',$state)->where('a.order_type','0')->order_by('a.create_time','desc')->get();

                    $res = $query->result_array();

                }else{

                     $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');
                    $this->db->from('hf_mall_order as a');
                    $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');
                    $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                    $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');

                    $query = $this->db->where('order_status !=','1')->where('order_status',$state)->where('seller',$seller)->order_by('a.create_time','desc')->get();

                    $res = $query->result_array();
                }

            }elseif(!empty($state ) && empty($seller) && !empty($time) && empty($sear) && empty($paytype)){


                $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');
                $this->db->from('hf_mall_order as a');
                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');
                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');

                $query = $this->db->where('order_status !=','1')->where('order_status',$state)->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->order_by('a.create_time','desc')->get();

                $res = $query->result_array();

            }elseif(!empty($state ) && empty($seller) && empty($time) && !empty($sear) && empty($paytype)){

             

                 $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');
                $this->db->from('hf_mall_order as a');
                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');
                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');

                $query = $this->db->where('order_status !=','1')->where('order_status',$state)->like('a.order_UUID',$sear,'both')->order_by('a.create_time','desc')->get();

                $res = $query->result_array();

            }elseif(!empty($state) && empty($seller) && empty($time) && empty($sear) && !empty($paytype)){
                $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');

                $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');

                $query = $this->db->where('order_status !=','1')->where('order_status',$state)->where('d.payType',$paytype)->order_by('a.create_time','desc')->get();

                $res = $query->result_array();

            }elseif(empty($state ) && !empty($seller) && !empty($time) && empty($sear) && empty($paytype)){
                if($seller == '-1'){

                    $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');
                    $this->db->from('hf_mall_order as a');
                    $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');
                    $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                    $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');

                    $query = $this->db->where('order_status !=','1')->where('a.order_type','0')->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->order_by('a.create_time','desc')->get();

                    $res = $query->result_array();
                }else{
                 $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');
                $this->db->from('hf_mall_order as a');
                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');
                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');

                $query = $this->db->where('order_status !=','1')->where('seller',$seller)->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->order_by('a.create_time','desc')->get();

                $res = $query->result_array();
                }

            }elseif(empty($state ) && !empty($seller) && empty($time) && !empty($sear) && empty($paytype)){
                if($seller == '-1'){

                  $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');
                $this->db->from('hf_mall_order as a');
                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');
                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');

                $query = $this->db->where('order_status !=','1')->where('a.order_type','0')->like('a.order_UUID',$sear,'both')->order_by('a.create_time','desc')->get();

                $res = $query->result_array();

                }else{
           

                 $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');
                $this->db->from('hf_mall_order as a');
                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');
                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');

                $query = $this->db->where('order_status !=','1')->where('a.seller',$seller)->like('a.order_UUID',$sear,'both')->order_by('a.create_time','desc')->get();

                $res = $query->result_array();
                }

            }elseif(empty($state ) && !empty($seller) && empty($time) && empty($sear) && !empty($paytype)){
                if($seller == '-1'){

                      $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

                    $this->db->from('hf_mall_order as a');

                    $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                    $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                    $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');

                    $query = $this->db->where('order_status !=','1')->where('a.order_type','0')->where('d.payType',$paytype)->order_by('a.create_time','desc')->get();

                    $res = $query->result_array();

                }else{
           

                $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');

                $query = $this->db->where('order_status !=','1')->where('a.seller',$seller)->where('d.payType',$paytype)->order_by('a.create_time','desc')->get();

                $res = $query->result_array();
                }

            }elseif(empty($state ) && empty($seller) && !empty($time) && !empty($sear) && empty($paytype)){

                $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');
                $this->db->from('hf_mall_order as a');
                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');
                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');

                $query = $this->db->where('order_status !=','1')->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->like('a.order_UUID',$sear,'both')->order_by('a.create_time','desc')->get();

                $res = $query->result_array();

            }elseif(empty($state ) && empty($seller) && !empty($time) && empty($sear) && !empty($paytype)){

           

                $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');

                $query = $this->db->where('order_status !=','1')->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->where('d.payType',$paytype)->order_by('a.create_time','desc')->get();

                $res = $query->result_array();  

            }elseif(empty($state ) && empty($seller) && empty($time) && !empty($sear) && !empty($paytype)){

           

                $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');

                $query = $this->db->where('order_status !=','1')->like('a.order_UUID',$sear,'both')->where('d.payType',$paytype)->order_by('a.create_time','desc')->get();

                $res = $query->result_array();
            //三个
            }else if(!empty($state ) && !empty($seller) && !empty($time) && empty($sear) && empty($paytype)){
                if($seller == '-1'){

                    $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

                    $this->db->from('hf_mall_order as a');

                    $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                    $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                    $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
                   
                    $query = $this->db->where('order_status !=','1')->where('a.order_status',$state)->where('a.order_type','0')->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->order_by('a.create_time','desc')->get();
                    $res = $query->result_array();

                }else{
                $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
               
                $query = $this->db->where('order_status !=','1')->where('a.order_status',$state)->where('a.seller',$seller)->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->order_by('a.create_time','desc')->get();
                $res = $query->result_array();
                }
            }else if(!empty($state ) && !empty($seller) && empty($time) && !empty($sear) && empty($paytype)){
                if($seller == '-1'){

                   $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

                    $this->db->from('hf_mall_order as a');

                    $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                    $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                    $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
                   
                    $query = $this->db->where('order_status !=','1')->where('a.order_status',$state)->where('a.order_type','0')->like('a.order_UUID',$sear,"both")->order_by('a.create_time','desc')->get();
                    $res = $query->result_array();

                }else{
                $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
               
                $query = $this->db->where('order_status !=','1')->where('a.order_status',$state)->where('a.seller',$seller)->like('a.order_UUID',$sear,"both")->order_by('a.create_time','desc')->get();
                $res = $query->result_array();
                }
            }else if(!empty($state ) && !empty($seller) && empty($time) && empty($sear) && !empty($paytype)){
                if($seller == '-1'){

                   $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

                     $this->db->from('hf_mall_order as a');

                    $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                    $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                    $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
                   
                    $query = $this->db->where('order_status !=','1')->where('a.order_status',$state)->where('a.order_type','0')->where('d.payType',$paytype)->order_by('a.create_time','desc')->get();
                    $res = $query->result_array();  

                }else{
                $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
               
                $query = $this->db->where('order_status !=','1')->where('a.order_status',$state)->where('a.seller',$seller)->where('d.payType',$paytype)->order_by('a.create_time','desc')->get();
                $res = $query->result_array();
                }
            }else if(!empty($state ) && empty($seller) && !empty($time) && !empty($sear) && empty($paytype)){
                $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
               
                $query = $this->db->where('order_status !=','1')->where('a.order_status',$state)->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->like('a.order_UUID',$sear,'both')->order_by('a.create_time','desc')->get();
                $res = $query->result_array();
                
            }else if(!empty($state ) && empty($seller) && !empty($time) && empty($sear) && !empty($paytype)){
                 $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
               
                $query = $this->db->where('order_status !=','1')->where('a.order_status',$state)->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->where('d.payType',$paytype)->order_by('a.create_time','desc')->get();
                $res = $query->result_array();
                
            }else if(!empty($state ) && empty($seller) && empty($time) && !empty($sear) && !empty($paytype)){
                $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
               
                $query = $this->db->where('order_status !=','1')->where('a.order_status',$state)->where('d.payType',$paytype)->like('a.order_UUID',$sear,'both')->order_by('a.create_time','desc')->get();
                $res = $query->result_array();
                
            }else if(empty($state ) && !empty($seller) && !empty($time) && !empty($sear) && empty($paytype)){
                if($seller == '-1'){

                      $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');
               
                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
               
                $query = $this->db->where('order_status !=','1')->where('a.order_type','0')->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->like('a.order_UUID',$sear,'both')->order_by('a.create_time','desc')->get();
                $res = $query->result_array();

                }else{
                 $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');
               
                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
               
                $query = $this->db->where('order_status !=','1')->where('a.seller',$seller)->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->like('a.order_UUID',$sear,'both')->order_by('a.create_time','desc')->get();
                $res = $query->result_array();
                 }

            }else if(empty($state ) && !empty($seller) && !empty($time) && empty($sear) && !empty($paytype)){
                if($seller == '-1'){

                    $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
               
                $query = $this->db->where('order_status !=','1')->where('a.order_type','0')->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->where('d.payType',$paytype)->order_by('a.create_time','desc')->get();
                $res = $query->result_array();

                }else{
                $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
               
                $query = $this->db->where('order_status !=','1')->where('a.seller',$seller)->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->where('d.payType',$paytype)->order_by('a.create_time','desc')->get();
                $res = $query->result_array();
                }
            }else if(empty($state ) && empty($seller) && !empty($time) && !empty($sear) && !empty($paytype)){
                 $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
               
                $query = $this->db->where('order_status !=','1')->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->where('d.payType',$paytype)->like('a.order_UUID',$sear,'both')->order_by('a.create_time','desc')->get();
                $res = $query->result_array();

             //四个   
            }else if(!empty($state ) && !empty($seller) && !empty($time) && !empty($sear) && empty($paytype)){
                if($seller == '-1'){

                   $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');
               
                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
               
                $query = $this->db->where('order_status !=','1')->where('a.order_status',$state)->where('a.order_type','0')->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->like('a.order_UUID',$sear,'both')->order_by('a.create_time','desc')->get();
                $res = $query->result_array();

                }else{
                 $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');
               
                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
               
                $query = $this->db->where('order_status !=','1')->where('a.order_status',$state)->where('a.seller',$seller)->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->like('a.order_UUID',$sear,'both')->order_by('a.create_time','desc')->get();
                $res = $query->result_array();
                 }

            }else if(!empty($state ) && !empty($seller) && !empty($time) && empty($sear) && !empty($paytype)){
                if($seller == '-1'){

                  $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
               
                $query = $this->db->where('order_status !=','1')->where('a.order_status',$state)->where('a.order_type','0')->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->where('d.payType',$paytype)->order_by('a.create_time','desc')->get();
                $res = $query->result_array();

                }else{
                $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
               
                $query = $this->db->where('order_status !=','1')->where('a.order_status',$state)->where('a.seller',$seller)->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->where('d.payType',$paytype)->order_by('a.create_time','desc')->get();
                $res = $query->result_array();
                }
            }else if(!empty($state ) && empty($seller) && !empty($time) && !empty($sear) && !empty($paytype)){
                $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
               
                $query = $this->db->where('order_status !=','1')->where('a.order_status',$state)->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->where('d.payType',$paytype)->order_by('a.create_time','desc')->get();
                $res = $query->result_array();
            }else if(!empty($state ) && !empty($seller) && empty($time) && !empty($sear) && !empty($paytype)){
                if($seller == '-1'){

                    $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');
           

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
               
                $query = $this->db->where('order_status !=','1')->where('a.order_status',$state)->where('a.order_type','0')->where('d.payType',$paytype)->like('a.order_UUID',$sear,'both')->order_by('a.create_time','desc')->get();
                $res = $query->result_array();
                }else{
                 $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');
           
                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
               
                $query = $this->db->where('order_status !=','1')->where('a.order_status',$state)->where('a.seller',$seller)->where('d.payType',$paytype)->like('a.order_UUID',$sear,'both')->order_by('a.create_time','desc')->get();
                $res = $query->result_array();
                     }
            }else if(empty($state ) && !empty($seller) && !empty($time) && !empty($sear) && !empty($paytype)){
                if($seller == '-1'){

                   $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');
                

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
               
                $query = $this->db->where('order_status !=','1')->where('a.order_type','0')->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->where('d.payType',$paytype)->like('a.order_UUID',$sear,'both')->order_by('a.create_time','desc')->get();
                $res = $query->result_array();

                }else{
                 $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');
                

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
               
                $query = $this->db->where('order_status !=','1')->where('a.seller',$seller)->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->where('d.payType',$paytype)->like('a.order_UUID',$sear,'both')->order_by('a.create_time','desc')->get();
                $res = $query->result_array();
                }
                
            //五个
            }else if(!empty($state ) && !empty($seller) && !empty($time) && !empty($sear) && !empty($paytype)){
                if($seller == '-1'){

                    $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');
                

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
               
                $query = $this->db->where('order_status !=','1')->where('a.order_status',$state)->where('a.order_type','0')->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->where('d.payType',$paytype)->like('a.order_UUID',$sear,'both')->order_by('a.create_time','desc')->get();
                $res = $query->result_array();

                }else{
                 $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');
                

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
               
                $query = $this->db->where('order_status !=','1')->where('a.order_status',$state)->where('a.seller',$seller)->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->where('d.payType',$paytype)->like('a.order_UUID',$sear,'both')->order_by('a.create_time','desc')->get();
                $res = $query->result_array();
                }
            }else if(empty($state ) && empty($seller) && empty($time) && empty($sear) && empty($paytype)){
                 $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
               
                $query = $this->db->where('order_status !=','1')->order_by('a.create_time','desc')->get();
                $res = $query->result_array();
            }


            //四个


            if(!empty($res)){

                echo json_encode($res);

            }else{

                echo "3";

            }



        }else{

            echo "2";

        }    

    }











    function Import_mollOrder(){

        if($_POST){

            $storeid = $this->input->post('mollseller');

            $state = $this->input->post('state');

            $start_time = $this->input->post('begin_time');

            $end_time = $this->input->post('end_time');



            $this->load->library('excel');

            //activate worksheet number 1

            $this->excel->setActiveSheetIndex(0);

            //name the worksheet

            $this->excel->getActiveSheet()->setTitle('ImportOrder');



           

            $this->excel->getActiveSheet()->mergeCells('A1:N1');  

            $this->excel->getActiveSheet()->setCellValue('A1','销售明细'); 

            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(13);

            

            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

            $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);      

            $this->excel->getActiveSheet()->getDefaultColumnDimension('A1')->setWidth(20);



            $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  

            if($storeid == '-1'){

                $arr_title = array(

                    'A' => '自定义编号',

                    'B' => '收件人姓名',

                    'C' => '收件人身份证号',

                    'D' => '收件人地址',

                    'E' => '手机号码',

                    'F' => '固话',

                    'G' => 'Email',

                    'H' => '邮编',

                    'I' => '省份',

                    'J' => '市',

                    'K' => '区',

                    'L' => '买家留言',

                    'M' => '产品信息(产品id_产品属性ID|数量,产品id|数量)，产品属性ID在前台商家中心-商品列表中点击商品编号查看属性ID',

                    'N' => '支付方式',

                    'O' => '运输方式',
                    'P' => '销售金额',
                    'Q' => '支付金额',
                    'R' => '积分抵用金额',
                    'S' => '优惠卷抵用金额',
                    'T' => '成交时间',
                    'U' => '订单状态',
                    'V' => '改价金额',
                    'W' => '改价原因',
                    'X' => '支付方式',
                    'Y' => '优惠劵id',
                    'Z' => '优惠劵名称',

                );

            }else{

                $arr_title = array(

                    'A' => '商家名称',

                    'B' => '订单编号',

                    'C' => '支付订单号',
                    'D' => '订单状态',

                    'E' => '成交时间',

                    'F' => '商品编码',

                    'G' => '商品名称',

                    'H' => '单价',

                    'I' => '数量',

                    'J' => '总价',

                    'K' => '成交价格',

                    'L' => '邮资',

                    'M' => '积分抵用金额',
                    'N' => '优惠卷抵用金额',
                    'O' => '商家修改价格',
                    'P' => '商家修改价格原因',

                    'Q' => '佣金比率',
                    'R' => '佣金总额',
                    'S' => '结算金额',
                    'T' => '备注',
                    'U' => '支付方式',
                    'V' => '优惠劵id',
                    'W' => '优惠劵名称',

                );

            }

            //设置excel 表头

            foreach ($arr_title as $key => $value) {

                $this->excel->getActiveSheet()->setCellValue($key . '2', $value);

                $this->excel->getActiveSheet()->getStyle($key . '2')->getFont()->setSize(13);

                $this->excel->getActiveSheet()->getStyle($key . '2')->getFont()->setBold(true);

                $this->excel->getActiveSheet()->getDefaultColumnDimension('A')->setWidth(20);

                $this->excel->getActiveSheet()->getStyle($key . '2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            }

           // var_dump($start_time,$end_time);

            //获取要导出的订单

            if(!empty($start_time)){
                $time = $start_time . ' 00:00:00';
                $endtime = $end_time . ' 23:59:59';
            }else{
                $time = '';
                $endtime = '';
            }


            $list = moll_order_list($storeid,$time,$endtime,$state);




            if(!empty($list)){

              if(count($list) > 0)

              {

                  $i ='2';

                 if($storeid == '-1'){

                    foreach ($list as $booking) {

                        $i++;

                        $user = json_decode($booking['goods_data'],true);

                        //地址

                        $address = json_decode($booking['buyer_address'],true);

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

                            $this->excel->getActiveSheet()->setCellValue('N' . $i, $booking['payType']);

                            $this->excel->getActiveSheet()->setCellValue('O' . $i, 'EMS');
                            $coupon = json_decode($booking['PriceCalculation'],true);

                            $zong = round($user['total_goods_prices'],2);

                            if(isset($user['boxa'])){
                                $lu = $user['boxa']['value'];
                            }else{
                                $lu = '1';
                            }

                            // var_dump($booking['order_id']);
                            if(isset($coupon['Params']['couponData']['coupon_amount'])){
                                 $coupon_id = retCouponId($coupon['coupon']);
                                $coupon_name = ret_coupon_name($coupon_id);
                                if($coupon['Params']['couponData']['typeid'] == '3'){
                                    $p = explode(',',$coupon['Params']['couponData']['coupon_amount']);
                                   // var_dump($p);
                                   // var_dump($lu);
                                    if(isset($p['1'])){
                                        $coupon_amount = round($p['1'] * $lu,'2');
                                    }
                                }elseif($coupon['Params']['couponData']['typeid'] == '2'){
                                    if(isset($p['1'])){
                                        $coupon_amount = round($zong * $p['1'],'2');
                                    }
                                }elseif($coupon['Params']['couponData']['typeid'] == '1'){
                                    $coupon_amount = $coupon['Params']['couponData']['coupon_amount'];
                                }else{
                                    $coupon_amount = '0';
                                }
                            }else{
                                 $coupon_id ='';
                            $coupon_name = '';
                                $coupon_amount = '0';
                            }   
                            // var_dump($coupon_amount);


                            if(isset($coupon['nowIntergal']['storenowIntergal'])){
                                $nowIntergal = round($coupon['nowIntergal']['storenowIntergal'],2);
                            }else{
                                $nowIntergal = '0';
                            }


                            $zhi = $zong - $coupon_amount - $nowIntergal + $booking['fee'];
                            // $zhi = $booking['amount'];
                            if($zhi < '0'){
                                $zhi = '0.01';
                            }


                            $this->excel->getActiveSheet()->setCellValue('P' . $i, round($user['total_goods_prices'],2));


                            $this->excel->getActiveSheet()->setCellValue('Q' . $i, $zhi);


                            $this->excel->getActiveSheet()->setCellValue('R' . $i,$nowIntergal);
                       
                            $this->excel->getActiveSheet()->setCellValue('S' . $i,$coupon_amount);
                            $this->excel->getActiveSheet()->setCellValue('T' . $i, $booking['create_time']);
                            switch ($booking['order_status']) {
                                   case '2':
                                        $state = '已支付';
                                       break;
                                       case '3':
                                        $state = '已发货';
                                       break;
                                       case '4':
                                        $state = '已收货';
                                       break;
                                       case '5':
                                        $state = '已评价';
                                       break;
                                       case '6':
                                        $state = '求退货';
                                       break;
                                       case '7':
                                        $state = '退货中';
                                       break;
                                       case '8':
                                        $state = '退款成功';
                                       break;
                                       case '9':
                                        $state = '其他';
                                       break;  
                                    case '10':
                                        $state = '等待退款';
                                       break;
                               }
                               $this->excel->getActiveSheet()->setCellValue('U' . $i, $state);
                               $this->excel->getActiveSheet()->setCellValue('V' . $i, $booking['fee']);
                               $this->excel->getActiveSheet()->setCellValue('W' . $i, $booking['fee_name']);

                               //获取支付方式
                               $paytype = $this->MallShop_model->ret_order_paydata($booking['order_UUID']);




                               $this->excel->getActiveSheet()->setCellValue('X' . $i, $paytype['payType']);
                               $this->excel->getActiveSheet()->setCellValue('Y' . $i, $coupon_id);
                               $this->excel->getActiveSheet()->setCellValue('Z' . $i, $coupon_name);


                    }

                }else{



                    foreach($list as $book){

                        $i++;
                        $goods = json_decode($book['goods_data'],true);

                         // $user = json_decode($booking['goods_data'],true);

                        foreach ($goods['goods_Data'] as $key => $value) {

                            $k[$i][$key]= $value['goods_id'];

                            $c[$i][$key]= $value['title'];

                            $n[$i][$key]= $value['nums'];

                            $p[$i][$key]= $value['price'];

                        }

                        $good = implode('|',$k[$i]);

                        $name = implode('|',$c[$i]);

                        $num = implode('|',$n[$i]);

                        $price = implode('|',$p[$i]);

                        //佣金

                       $points=  $goods['total_goods_prices'] * ($goods['stores']['points']/100);



                        $this->excel->getActiveSheet()->setCellValue('A' . $i, $goods['stores']['store_name']);

                        $this->excel->getActiveSheet()->setCellValue('B' . $i, $book['order_id']);
                        $this->excel->getActiveSheet()->setCellValue('C' . $i, $book['order_UUID']);
                       switch ($book['order_status']) {
                           case '2':
                                $state = '已支付';
                               break;
                               case '3':
                                $state = '已发货';
                               break;
                               case '4':
                                $state = '已收货';
                               break;
                               case '5':
                                $state = '已评价';
                               break;
                               case '6':
                                $state = '求退货';
                               break;
                               case '7':
                                $state = '退货中';
                               break;
                               case '8':
                                $state = '退款成功';
                               break;
                               case '9':
                                $state = '其他';
                               break;  
                            case '10':
                                $state = '等待退款';
                               break;
                       }

                        $this->excel->getActiveSheet()->setCellValue('D' . $i, $state);
                        $this->excel->getActiveSheet()->setCellValue('E' . $i, $book['create_time']);
                        $this->excel->getActiveSheet()->setCellValue('F' . $i, $good);
                        $this->excel->getActiveSheet()->setCellValue('G' . $i, $name);
                        $this->excel->getActiveSheet()->setCellValue('H' . $i, $price);
                        $this->excel->getActiveSheet()->setCellValue('I' . $i, $num);

                        $coupon = json_decode($book['PriceCalculation'],true);

                        $zong = round($goods['total_goods_prices'],2);

                        if(isset($goods['boxa'])){
                            $lu = $goods['boxa']['value'];
                        }else{
                            $lu = '1';
                        }

                       
                        if(isset($coupon['Params']['couponData']['coupon_amount'])){
                            $coupon_id = retCouponId($coupon['coupon']);
                            $coupon_name = ret_coupon_name($coupon_id);
                           
                            if($coupon['Params']['couponData']['typeid'] == '3'){
                                $p = explode(',',$coupon['Params']['couponData']['coupon_amount']);
               
                                if(isset($p['1'])){
                                    $coupon_amount = round($p['1'] * $lu,'2');
                                } 
                            }elseif($coupon['Params']['couponData']['typeid'] == '2'){
                                if(isset($p['1'])){
                                    $coupon_amount = $zong * $p['1'];
                                }
                            }elseif($coupon['Params']['couponData']['typeid'] == '1'){
                                $coupon_amount = $coupon['Params']['couponData']['coupon_amount'];
                            }else{
                                $coupon_amount = '0';
                            }
                        }else{
                            $coupon_id = '';
                            $coupon_name = '';
                            $coupon_amount = '0';
                        }   

                        if(isset($coupon['nowIntergal']['storenowIntergal'])){

                        $nowIntergal = round($coupon['nowIntergal']['storenowIntergal'],2);
                        }else{
                            $nowIntergal = '0';
                        }
                        $zhi = $zong - $coupon_amount - $nowIntergal + $book['fee'];

                        if($zhi < '0'){
                            $zhi = '0.01';
                        }
                        $this->excel->getActiveSheet()->setCellValue('J' . $i, $zong);
                        $this->excel->getActiveSheet()->setCellValue('K' . $i, $zhi);
                        if(isset($goods['postAge']['postage'])){
                            $this->excel->getActiveSheet()->setCellValue('L' . $i, $goods['postAge']['postage']);
                        }else{
                            $this->excel->getActiveSheet()->setCellValue('L' . $i, '0');

                        }
                        $this->excel->getActiveSheet()->setCellValue('M' . $i, $nowIntergal);
                        $this->excel->getActiveSheet()->setCellValue('N' . $i, $coupon_amount);
                        $this->excel->getActiveSheet()->setCellValue('O' . $i, $book['fee']);
                        $this->excel->getActiveSheet()->setCellValue('P' . $i, $book['fee_name']);
                        $this->excel->getActiveSheet()->setCellValue('Q' . $i, $goods['stores']['points']/100);
                        $this->excel->getActiveSheet()->setCellValue('R' . $i, $points);
                        $this->excel->getActiveSheet()->setCellValue('S' . $i, $zong - $points);
                        $this->excel->getActiveSheet()->setCellValue('T' . $i, '');
                        //获取支付方式
                        $paytype = $this->MallShop_model->ret_order_paydata($book['order_UUID']);

                        $this->excel->getActiveSheet()->setCellValue('U' . $i, $paytype['payType']);
                        $this->excel->getActiveSheet()->setCellValue('V' . $i, $coupon_id);
                        $this->excel->getActiveSheet()->setCellValue('W' . $i, $coupon_name);

                    }

                }

            }
            // exit;

            //日志

            $log = array(

                'userid'=>$_SESSION['users']['user_id'],  

                "content" => $_SESSION['users']['username']."导出了订单信息",

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

             echo "<script>alert('导出成功！');window.location.href='".site_url('/finance/Finance/mallOrder')."'</script>";

             exit;

            }else{

                echo "<script>alert('暂无订单记录！');window.location.href='".site_url('/finance/Finance/mallOrder')."'</script>";

            }



        }

     }


     //对账管理
     function contrast(){

        $data['page'] = 'finance/contrast.html';
        $data['menu'] = array('finance','contrast');
        $this->load->view('template.html',$data);
     }

     //导入支付平台订单
     function importPayOrder(){
        if($_POST){
            $paytype = $this->input->post('paytype');
            $begin_time = $this->input->post('begin_time');
            $end_time = $this->input->post('end_time');
            if(empty($begin_time)){
                echo "<script>alert('请选择时间段!');window.location.href='".site_url('/finance/finance/contrast')."'</script>";
                exit;
            }else{
                $t = strtotime($begin_time .' 00:00:00')*1000;
                $e = strtotime($end_time .' 23:59:59')*1000;
            }

            $name = date('Y-m-d');

            $inputFileName = "Upload/xls/" .$name .'.xls';

            move_uploaded_file($_FILES["file"]["tmp_name"],$inputFileName);

            $this->load->library('excel');

            if(!file_exists($inputFileName)){

                    echo "<script>alert('文件导入失败!');window.location.href='".site_url('/finance/finance/contrast')."'</script>";

                    exit;

            }
            $PHPReader = new PHPExcel_Reader_Excel2007();
            if(!$PHPReader->canRead($inputFileName)){
              $PHPReader = new PHPExcel_Reader_Excel5();
              if(!$PHPReader->canRead($inputFileName)){
                echo "<script>alert('文件格式错误，需要xls或xlsx文件后缀!');window.location.href='".site_url('/finance/finance/contrast')."'</script>";
                return;
              }
            }
            $PHPExcel = $PHPReader->load($inputFileName);
            $currentSheet = $PHPExcel->getSheet(0);  //读取excel文件中的第一个工作表
            $allColumn = $currentSheet->getHighestColumn(); //取得最大的列号
            $allRow = $currentSheet->getHighestRow(); //取得一共有多少行
            $erp_orders_id = array();  //声明数组
            //判断支付方式
            if($paytype == 'alipay'){
                $sql = "truncate table hf_mall_payOrder";
                $res = $this->db->query($sql);
                for($currentRow = 5;$currentRow <= $allRow;$currentRow++){

                    $data['orderUUID'] = $PHPExcel->getActiveSheet()->getCell("D".$currentRow)->getValue();//获取c列的值
                    $data['createTime'] = $PHPExcel->getActiveSheet()->getCell("B".$currentRow)->getValue();//获取c列的值
                    $data['payId'] = $PHPExcel->getActiveSheet()->getCell("E".$currentRow)->getValue();//获取c列的值
                    $data['orderPrice'] = $PHPExcel->getActiveSheet()->getCell("H".$currentRow)->getValue();//获取c列的值

                    if($data['orderUUID'] == NULL){
                        unlink($inputFileName);
                         //删除临时文件
                        break;
                    }
                    $this->db->insert("hf_mall_payOrder",$data);

                 }
            //微信
            }else{
                $sql = "truncate table hf_mall_payOrder";
                $res = $this->db->query($sql);
                for($currentRow = 7;$currentRow <= $allRow;$currentRow++){

                    $data['orderUUID'] = substr($PHPExcel->getActiveSheet()->getCell("C".$currentRow)->getValue(),'1');//获取c列的值
                    $data['createTime'] = $PHPExcel->getActiveSheet()->getCell("A".$currentRow)->getValue();//获取c列的值
                    $data['payId'] = substr($PHPExcel->getActiveSheet()->getCell("B".$currentRow)->getValue(),'1');//获取c列的值
                    $data['orderPrice'] = $PHPExcel->getActiveSheet()->getCell("F".$currentRow)->getValue();//获取c列的值

                    if($data['orderUUID'] == NULL){
                        unlink($inputFileName);
                         //删除临时文件
                        break;
                    }
                    $this->db->insert("hf_mall_payOrder",$data);

                 }
            }


            //导出对比报表
            $this->excel->setActiveSheetIndex(0);


            $this->excel->getActiveSheet()->setTitle('contrastOrder');

            $this->excel->getActiveSheet()->mergeCells('A1:Q1');  
            $this->excel->getActiveSheet()->mergeCells('A2:Q2');  

            $this->excel->getActiveSheet()->setCellValue('A1','对账信息'); 
            $this->excel->getActiveSheet()->setCellValue('A2','红色代表没有支付平台没有。绿色代表金额有差异'); 

            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(13);

            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

            $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);      

            $this->excel->getActiveSheet()->getDefaultColumnDimension('A1')->setWidth(20);



            $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  

            $arr_title = array(
                    'A' => '订单编号',
                    'B' => '支付订单号',
                    'C' => '支付平台单号',
                    'D' => '成交时间',
                    'E' => '商品编码',
                    'F' => '商品名称',
                    'G' => '单价',
                    'H' => '数量',
                    'I' => '总价',
                  
                    'J' => '邮资',
                    'K' => '积分抵用金额',
                    'L' => '优惠卷抵用金额',
                    'M' => '商家修改价格',
                    'N' => '商家修改价格原因',
                    'O' => '支付金额',
                    'P' => '收款金额',
                    'Q' => '支付方式',
            );
            //12
            foreach ($arr_title as $key => $value) {

                $this->excel->getActiveSheet()->setCellValue($key . '3', $value);

                $this->excel->getActiveSheet()->getStyle($key . '3')->getFont()->setSize(13);

                $this->excel->getActiveSheet()->getStyle($key . '3')->getFont()->setBold(true);

                $this->excel->getActiveSheet()->getDefaultColumnDimension('A')->setWidth(20);

                $this->excel->getActiveSheet()->getStyle($key . '3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            }
           

            $this->db->select('a.*,b.store_name,c.nickname,e.payType');
            $this->db->from('hf_shop_store as b');
            $this->db->join('hf_mall_order as a','a.seller = b.store_id','inner');
            $this->db->join('hf_user_member as c','a.buyer = c.user_id','inner');
            $this->db->join('hf_mall_order_repaydata as e','a.order_UUID = e.repay_UUID','inner');
            $query = $this->db->where('a.pay_time >=',$t)->where('a.pay_time <=',$e)->where('order_status !=','1')->where('e.payType',$paytype)->order_by('a.pay_time','desc')->get();
            $lists = $query->result_array();

            $i='3';
            if(!empty($lists)){
                foreach($lists as $book){
                     $i++;
                    $goods = json_decode($book['goods_data'],true);
                    foreach ($goods['goods_Data'] as $key => $value) {
                        $k[$i][$key]= $value['goods_id'];
                        $c[$i][$key]= $value['title'];
                        $n[$i][$key]= $value['nums'];
                        $p[$i][$key]= $value['price'];
                    }
                    $good = implode('|',$k[$i]);

                    $name = implode('|',$c[$i]);

                    $num = implode('|',$n[$i]);

                    $price = implode('|',$p[$i]);
                    //支付平台数据
                    $query2 = $this->db->where('orderUUID',$book['order_UUID'])->get('hf_mall_payOrder');
                    $or= $query2->row_array();
                  
                    $this->excel->getActiveSheet()->setCellValue('A' . $i, $book['order_id']);
                    $this->excel->getActiveSheet()->setCellValue('B' . $i, $book['order_UUID']);
                    $this->excel->getActiveSheet()->setCellValue('C' . $i, $or['payId']);

                    $this->excel->getActiveSheet()->setCellValue('D' . $i, $or['createTime']);
                    $this->excel->getActiveSheet()->setCellValue('E' . $i, $good);
                    $this->excel->getActiveSheet()->setCellValue('F' . $i, $name);
                    $this->excel->getActiveSheet()->setCellValue('G' . $i, $price);
                    $this->excel->getActiveSheet()->setCellValue('H' . $i, $num);

                    $coupon = json_decode($book['PriceCalculation'],true);

                    $zong = round($goods['total_goods_prices'],2);

                    if(isset($goods['boxa'])){
                        $lu = $goods['boxa']['value'];
                    }else{
                        $lu = '1';
                    }

                       
                    if(isset($coupon['Params']['couponData']['coupon_amount'])){
                        $coupon_id = retCouponId($coupon['coupon']);
                        $coupon_name = ret_coupon_name($coupon_id);
                       
                        if($coupon['Params']['couponData']['typeid'] == '3'){
                            $p = explode(',',$coupon['Params']['couponData']['coupon_amount']);
           
                            if(isset($p['1'])){
                                $coupon_amount = round($p['1'] * $lu,'2');
                            } 
                        }elseif($coupon['Params']['couponData']['typeid'] == '2'){
                            if(isset($p['1'])){
                                $coupon_amount = $zong * $p['1'];
                            }
                        }elseif($coupon['Params']['couponData']['typeid'] == '1'){
                            $coupon_amount = $coupon['Params']['couponData']['coupon_amount'];
                        }else{
                            $coupon_amount = '0';
                        }
                    }else{
                        $coupon_id = '';
                        $coupon_name = '';
                        $coupon_amount = '0';
                    }   

                    if(isset($coupon['nowIntergal']['storenowIntergal'])){

                    $nowIntergal = round($coupon['nowIntergal']['storenowIntergal'],2);
                    }else{
                        $nowIntergal = '0';
                    }
                    $zhi = $zong - $coupon_amount - $nowIntergal + $book['fee'];
                    $this->excel->getActiveSheet()->setCellValue('I' . $i, $zong);
                    if(isset($goods['postAge']['postage'])){
                        $this->excel->getActiveSheet()->setCellValue('J' . $i, $goods['postAge']['postage']);
                    }else{
                        $this->excel->getActiveSheet()->setCellValue('J' . $i, '0');

                    }
                    $this->excel->getActiveSheet()->setCellValue('K' . $i, $nowIntergal);
                    $this->excel->getActiveSheet()->setCellValue('L' . $i, $coupon_amount);
                    $this->excel->getActiveSheet()->setCellValue('M' . $i, $book['fee']);
                    $this->excel->getActiveSheet()->setCellValue('N' . $i, $book['fee_name']);
                    if($zhi < '0'){
                        $this->excel->getActiveSheet()->setCellValue('O' . $i, '0.01');

                    }else{
                         $this->excel->getActiveSheet()->setCellValue('O' . $i, round($zhi,2));

                    }
                    
                    $this->excel->getActiveSheet()->setCellValue('P' . $i, $or['orderPrice']);
                    $this->excel->getActiveSheet()->setCellValue('Q' . $i, $book['payType']);
                  
                    if(!empty($or)){
                        if($zhi < '0'){
                            $a = '0.01';
                        }else{
                            $a = round($zhi,2);
                        }

                        if($or['orderPrice'] != (string)$a){
                           

                            // $this->excel->getActiveSheet()->getStyle( 'A3:R3')->getFill()->getStartColor()->setARGB('FF8C69');
                            $this->excel->getActiveSheet()->getStyle('A'.$i.':R'.$i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('98FB98');
                        }
                    }else{
                        // $this->excel->getActiveSheet()->getStyle( 'A5:R5')->getFill()->getStartColor()->setARGB('FF3030');
                         $this->excel->getActiveSheet()->getStyle('A'.$i.':R'.$i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FF3030');
                    }
                   

                }
                // exit;

                $fileName = $paytype.$begin_time.'至'.$end_time.'对账信息.xls'; //save our workbook as this file name

               /// var_dump($filename);

                header('Content-Type: application/vnd.ms-excel'); //mime type

                header('Content-Disposition: attachment;filename="' . $fileName . '"'); //tell browser what's the file name

                header('Cache-Control: max-age=0'); //no cache



                 $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

                 $objWriter->save('php://output');

                 // echo "<script>alert('导出成功！');window.location.href='".site_url('/finance/Finance/contrast')."'</script>";

                 exit;
            }else{
                echo "<script>alert('没有订单数据！');window.location.href='".site_url('/finance/Finance/contrast')."'</script>";
                exit;

            }



        }
     }


     








}