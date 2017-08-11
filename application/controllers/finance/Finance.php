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

            $time = trim($_POST['start_time']) .' 00:00:00';

            $endtime = trim($_POST['end_time']) . ' 23:59:59';

            $sear = trim($_POST['sear']);



            $res= '';

            if(!empty($state) && empty($seller) && empty($time) && empty($sear)){

                $this->db->select('a.*,b.store_name,c.username,c.nickname');

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');

                $query = $this->db->where('order_status !=','1')->where('order_status',$state)->order_by('a.create_time','desc')->get();

                $res = $query->result_array();

            }elseif(empty($state ) && !empty($seller) && empty($time) && empty($sear)){

                if($seller == '-1'){

                    $seller = '0';

                }

                $this->db->select('a.*,b.store_name,c.username,c.nickname');

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');

                $query = $this->db->where('order_status !=','1')->where('seller',$seller)->order_by('a.create_time','desc')->get();

                $res = $query->result_array();

            }elseif(empty($state ) && empty($seller) && !empty($time) && empty($sear)){

                $this->db->select('a.*,b.store_name,c.username,c.nickname');

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');

                $query = $this->db->where('order_status !=','1')->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->order_by('a.create_time','desc')->get();

                $res = $query->result_array();



            }elseif(empty($state ) && empty($seller) && empty($time) && !empty($sear)){

           

                $this->db->select('a.*,b.store_name,c.username,c.nickname');

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');

                $query = $this->db->where('order_status !=','1')->like('a.order_UUID',$sear,'both')->order_by('a.create_time','desc')->get();

                $res = $query->result_array();

            }

            //二个    

            elseif(!empty($state ) && !empty($seller) && empty($time) && empty($sear)){

                 if($seller == '-1'){

                    $seller = '0';

                }

                $this->db->select('a.*,b.store_name,c.username,c.nickname');

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');

                $query = $this->db->where('order_status !=','1')->where('order_status',$state)->where('seller',$seller)->order_by('a.create_time','desc')->get();

                $res = $query->result_array();

            }elseif(!empty($state ) && empty($seller) && !empty($time) && empty($sear)){

                 if($seller == '-1'){

                    $seller = '0';

                }

                $this->db->select('a.*,b.store_name,c.username,c.nickname');

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');

                $query = $this->db->where('order_status !=','1')->where('order_status',$state)->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->order_by('a.create_time','desc')->get();

                $res = $query->result_array();

            }elseif(!empty($state ) && empty($seller) && empty($time) && !empty($sear)){

                 if($seller == '-1'){

                    $seller = '0';

                }

                $this->db->select('a.*,b.store_name,c.username,c.nickname');

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');

                $query = $this->db->where('order_status !=','1')->where('order_status',$state)->like('a.order_UUID',$sear,'both')->order_by('a.create_time','desc')->get();

                $res = $query->result_array();

            }elseif(empty($state ) && !empty($seller) && !empty($time) && empty($sear)){

           

                $this->db->select('a.*,b.store_name,c.username,c.nickname');

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');

                $query = $this->db->where('order_status !=','1')->where('seller',$seller)->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->order_by('a.create_time','desc')->get();

                $res = $query->result_array();

            }elseif(empty($state ) && !empty($seller) && empty($time) && !empty($sear)){

           

                $this->db->select('a.*,b.store_name,c.username,c.nickname');

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');

                $query = $this->db->where('order_status !=','1')->where('seller',$seller)->like('a.order_UUID',$sear,'both')->order_by('a.create_time','desc')->get();

                $res = $query->result_array();

            }elseif(empty($state ) && empty($seller) && !empty($time) && !empty($sear)){

           

                $this->db->select('a.*,b.store_name,c.username,c.nickname');

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');

                $query = $this->db->where('order_status !=','1')->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->like('a.order_UUID',$sear,'both')->order_by('a.create_time','desc')->get();

                $res = $query->result_array();

            }else{   

                $this->db->select('a.*,b.store_name,c.username,c.nickname');

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');

                $query = $this->db->where('order_status !=','1')->order_by('a.create_time','desc')->get();

                $res = $query->result_array();

            }



            //三个



            //四个



    









          // var_dumP($res);

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

                    'O' => '运输方式'

                );

            }else{

                $arr_title = array(

                    'A' => '商家名称',

                    'B' => '订单编号',

                    'C' => '成交时间',

                    'D' => '商品编码',

                    'E' => '商品名称',

                    'F' => '单价',

                    'G' => '数量',

                    'H' => '总价',

                    'I' => '成交价格',

                    'J' => '邮资',

                    'K' => '成交总额',

                    'L' => '佣金比率',

                    'M' => '佣金总额',

                    'N' => '结算金额',

                    'O' => '备注'

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

            $list = moll_order_list($storeid,$start_time,$end_time);



        // exit;

            if(!empty($list)){

              if(count($list) > 0)

              {

                  $i ='2';

                 if($storeid == '-1'){

                    foreach ($list as $booking) {

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

                }else{



                    foreach($list as $book){

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

                        //佣金

                       $points=  $goods['total_goods_prices'] * ($goods['stores']['points']/100);



                        $this->excel->getActiveSheet()->setCellValue('A' . $i, $goods['stores']['store_name']);

                        $this->excel->getActiveSheet()->setCellValue('B' . $i, $book['order_id']);

                        $this->excel->getActiveSheet()->setCellValue('C' . $i, $book['create_time']);



                        $this->excel->getActiveSheet()->setCellValue('D' . $i, $good);

                        $this->excel->getActiveSheet()->setCellValue('E' . $i, $name);

                        $this->excel->getActiveSheet()->setCellValue('F' . $i, $price);

                        $this->excel->getActiveSheet()->setCellValue('G' . $i, $num);

                        $this->excel->getActiveSheet()->setCellValue('H' . $i, $book['amount']);

                        $this->excel->getActiveSheet()->setCellValue('I' . $i, $goods['total_goods_prices']- $goods['postAge']);

                        $this->excel->getActiveSheet()->setCellValue('J' . $i, $goods['postAge']);

                        $this->excel->getActiveSheet()->setCellValue('K' . $i, $goods['total_goods_prices']);

                        $this->excel->getActiveSheet()->setCellValue('L' . $i, $goods['stores']['points']);

                        $this->excel->getActiveSheet()->setCellValue('M' . $i, $points);

                        $this->excel->getActiveSheet()->setCellValue('N' . $i, $goods['total_goods_prices'] - $points);

                        $this->excel->getActiveSheet()->setCellValue('O' . $i, '');

                    }

                }

            }



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









}