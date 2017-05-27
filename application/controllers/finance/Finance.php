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
            $time = trim($_POST['start_time']);
            $endtime = trim($_POST['end_time']);
            $res= '';
            if(!empty($state) && empty($seller) && empty($time)){
                $this->db->select('a.*,b.store_name,c.username,c.nickname');
                $this->db->from('hf_mall_order as a');
                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');
                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $query = $this->db->where('order_status !=','1')->where('order_status',$state)->order_by('a.create_time','desc')->get();
                $res = $query->result_array();
            }elseif(empty($state ) && !empty($seller) && empty($time)){
                if($seller == '-1'){
                    $seller = '0';
                }
                $this->db->select('a.*,b.store_name,c.username,c.nickname');
                $this->db->from('hf_mall_order as a');
                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');
                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $query = $this->db->where('order_status !=','1')->where('seller',$seller)->order_by('a.create_time','desc')->get();
                $res = $query->result_array();
            }elseif(empty($state ) && empty($seller) && !empty($time)){
                $this->db->select('a.*,b.store_name,c.username,c.nickname');
                $this->db->from('hf_mall_order as a');
                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');
                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $query = $this->db->where('order_status !=','1')->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->order_by('a.create_time','desc')->get();
                $res = $query->result_array();
            }elseif(!empty($state ) && !empty($seller) && empty($time)){
                if($seller == '-1'){
                    $seller = '0';
                }
                $this->db->select('a.*,b.store_name,c.username,c.nickname');
                $this->db->from('hf_mall_order as a');
                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');
                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $query = $this->db->where('order_status !=','1')->where('order_status',$state)->where('seller',$seller)->order_by('a.create_time','desc')->get();
                $res = $query->result_array();
            }elseif(!empty($state ) && empty($seller) && !empty($time)){
                $this->db->select('a.*,b.store_name,c.username,c.nickname');
                $this->db->from('hf_mall_order as a');
                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');
                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $query = $this->db->where('order_status !=','1')->where('order_status',$state)->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->order_by('a.create_time','desc')->get();
                $res = $query->result_array();
            }elseif(empty($state ) && !empty($seller) && !empty($time)){
                if($seller == '-1'){
                    $seller = '0';
                }
                $this->db->select('a.*,b.store_name,c.username,c.nickname');
                $this->db->from('hf_mall_order as a');
                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');
                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $query = $this->db->where('order_status !=','1')->where('seller',$seller)->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->order_by('a.create_time','desc')->get();
                $res = $query->result_array();
            }elseif(!empty($state ) && !empty($seller) && !empty($time)){
                if($seller == '-1'){
                    $seller = '0';
                }
                $this->db->select('a.*,b.store_name,c.username,c.nickname');
                $this->db->from('hf_mall_order as a');
                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');
                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $query = $this->db->where('order_status !=','1')->where('order_status',$state)->where('seller',$seller)->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->order_by('a.create_time','desc')->get();
                $res = $query->result_array();
            }elseif(!empty($state ) && empty($seller) && empty($time)){
                $this->db->select('a.*,b.store_name,c.username,c.nickname');
                $this->db->from('hf_mall_order as a');
                $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');
                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
                $query = $this->db->where('order_status !=','1')->order_by('a.create_time','desc')->get();
                $res = $query->result_array();
            }
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
            $storeid = $this->input->post('storeid');
            $start_time = $this->input->post('begin_date');
            $end_time = $this->input->post('end_date');
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
     
            $arr_title = array(
                'A' => '订单编号',
                'B' => '成交时间',
                'C' => '商品编码',
                'D' => '商品名称',
                'E' => '单价',
                'F' => '数量',
                'G' => '总价',
                'H' => '成交价格',
                'I' => '邮资',
                'J' => '成交总额',
                'K' => '佣金比率',
                'L' => '佣金总额',
                'M' => '结算金额',
                'N' => '备注'
            );
            
                  //设置excel 表头
            foreach ($arr_title as $key => $value) {
                $this->excel->getActiveSheet()->setCellValue($key . '2', $value);
                $this->excel->getActiveSheet()->getStyle($key . '2')->getFont()->setSize(13);
                $this->excel->getActiveSheet()->getStyle($key . '2')->getFont()->setBold(true);
               $this->excel->getActiveSheet()->getDefaultColumnDimension('A')->setWidth(20);
                $this->excel->getActiveSheet()->getStyle($key . '2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }




            //        if(!empty($bookings)){
            // if(count($bookings) > 0)
            // {
            //     foreach ($bookings as $booking) {
            //         $i++;
            //         $user = json_decode($booking['goods_data'],true);
            //         //地址
            //        $address = $this->Integral_model->get_user_address($booking['buyer_address']);
            //        //省份证
            //        $id_card = $this->Integral_model->ret_user_info($booking['buyer']);
            //        //留言
            //        $notice = json_decode($booking['userPostData'],true);
                   

            //         foreach ($user['goods_Data'] as $key => $value) {
            //              $goods[$i][$key]= $value['id'].'|'.$value['nums'];
            //         }
            //         $good = implode(',',$goods[$i]);
            //      //   $this->excel->getActiveSheet()->setCellValue('A' . $i,  $i - 1);
            //         $this->excel->getActiveSheet()->setCellValue('A' . $i, $booking['order_UUID']);
            //         $this->excel->getActiveSheet()->setCellValue('B' . $i, $address['person']);
            //         $this->excel->getActiveSheet()->setCellValue('C' . $i, ' '.$id_card);
            //         $this->excel->getActiveSheet()->setCellValue('D' . $i, $address['address']);
            //         $this->excel->getActiveSheet()->setCellValue('E' . $i, $address['phone']);
            //         $this->excel->getActiveSheet()->setCellValue('F' . $i, '');
            //         $this->excel->getActiveSheet()->setCellValue('G' . $i, '');
            //         $this->excel->getActiveSheet()->setCellValue('H' . $i, '400000');
            //         $this->excel->getActiveSheet()->setCellValue('I' . $i, $address['province']);
            //         $this->excel->getActiveSheet()->setCellValue('J' . $i, $address['city']);
            //         $this->excel->getActiveSheet()->setCellValue('K' . $i, $address['area']);
            //         $this->excel->getActiveSheet()->setCellValue('L' . $i, $notice['notice']);
            //         $this->excel->getActiveSheet()->setCellValue('M' . $i, $good);
            //         $this->excel->getActiveSheet()->setCellValue('N' . $i, 'allinpay');
            //         $this->excel->getActiveSheet()->setCellValue('O' . $i, 'EMS');
                   
            //     }
            // }

            // //日志
            // $log = array(
            //     'userid'=>$_SESSION['users']['user_id'],  
            //     "content" => $_SESSION['users']['username']."导出了爱购商品订单信息",
            //     "create_time" => date('Y-m-d H:i:s'),
            //     "userip" => get_client_ip(),
            // );
            // $this->db->insert('hf_system_journal',$log);


            $filename = 'ImportOrder.xls'; //save our workbook as this file name
           /// var_dump($filename);
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

             $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
             $objWriter->save('php://output');
             exit;
            // }else{
            //     echo "<script>alert('暂无订单记录！');window.location.href='".site_url('/igo/LoveToGo/')."'</script>";
            // }

        }
     }




}