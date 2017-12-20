<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*  充值缴费
*/
require_once(APPPATH.'controllers/Default_Controller.php');

class Payment extends Default_Controller
{
	public $view_payment = 'module/payment/recharge_settings.html';	
	public $view_energyCharge = 'module/payment/energyCharge.html';
	function __construct()
	{
		 parent::__construct();
         $this->load->model('Payment_model');  
	}

    //充值设置
    function recharge(){
        //获取充值设置
        $data['lists'] = $this->Payment_model->ret_recharge();
        $data['page'] = $this->view_payment;
        $data['menu'] = array('payment','recharge');
        $this->load->view('template.html',$data);
    }
    //获取手机验证码
    function codeNum(){
        // if($_POST){
            $code = rand(1000,9999);
        
            $arr = array(
                'phone'=>'15828277232',
                'cxt'=>"用户".$_SESSION['users']['username']."在修改话费充值价格，验证码是".$code."。5分钟内有效！"
            );
            $url = "http://192.168.0.5:7200/api/index/sms";
            $qiuniu = json_decode(curl_post($url,$arr),true);
            




        // }
    }

    //新增手机设置
    function add_recharge(){
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
            $data = $this->input->post();
            $data['createUserid'] = $_SESSION['users']['user_id'];

            if($this->Payment_model->add_recharge($data)){
                 //日志    
                 $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."新增了话费\流量套餐，套餐额度是：".$data['name'],
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                echo "<script>alert('操作成功！');window.location.href='".site_url('/payment/Payment/recharge')."'</script>";exit;

            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/payment/Payment/recharge')."'</script>";exit;

            }

        }
    }

    //编辑充值设置
    function edit_recharge(){
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
            $data = $this->input->post();
            $data['createUserid'] = $_SESSION['users']['user_id'];
           // $rule = round($data['originalPrice'] - $data['advicePrice'],2);
          
            // $pay = array("Condition"=>$data['originalPrice'],'rule'=>'-'.$rule);
            // $data['discountsRule'] = json_encode($pay);
          
            if($this->Payment_model->edit_recharge($data['id'],$data)){
                 //日志    
                 $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."编辑了话费\流量套餐，套餐额度是：".$data['name'],
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                echo "<script>alert('操作成功！');window.location.href='".site_url('/payment/Payment/recharge')."'</script>";exit;

            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/payment/Payment/recharge')."'</script>";exit;

            }
        }else{
            $this->load->view('404.html');
        }
    }

    //删除套餐
    function del_recharge(){
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
        $id = intval($this->uri->segment('4'));
       // var_Dump($id);
        if($id == '0'){
            $this->load->view('404.html');
        }else{
            if($this->Payment_model->del_recharge($id)){
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."删除了话费\流量套餐，套餐id是：".$id,
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                echo "<script>alert('操作成功！');window.location.href='".site_url('/payment/Payment/recharge')."'</script>";exit;

            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/payment/Payment/recharge')."'</script>";exit;
            }
        }


    }




    //手机充值记录
    function energyCharge(){
        //获取充值面额

        $data['lists'] = $this->Payment_model->ret_recharge();        
        $data['page'] = $this->view_energyCharge;
        $data['menu'] = array('payment','energyCharge');
        $this->load->view('template.html',$data);
    }

    //返回充值记录
    function qianmi_order_list(){
        if($_POST){
            $type = $this->input->post('type');
            $list = $this->Payment_model->get_qianmi_order($type);
            if(!empty($list)){
                echo json_encode($list);
            }else{
                echo "2";
            }

        }else{
            echo "2";
        }

    }

    function searchCharge(){
        if($_POST){
            $phone = trim($this->input->post('phone'));
            $order = trim($this->input->post('payorder'));
            $time = $this->input->post('start_time');
            $endtime = $this->input->post('end_time');

            if(!empty($time)){
                $t= $time.' 00:00:00';
                $e= $endtime.' 23:59:59';
            }else{
                $t = '';
                $e = '';
            }
            if(!empty($phone) && empty($order) && empty($t)){

                $list = $this->Payment_model->pay_qianmi_order($phone);
            }else if(empty($phone) && !empty($order) && empty($t)){

                $list = $this->Payment_model->payorder_qianmi_order($order);
            }else if(empty($phone) && empty($order) && !empty($t)){
                $list = $this->Payment_model->time_qianmi_order($t,$e);
            }else if(!empty($phone) && !empty($order) && empty($t)){
                $this->db->select('a.*,b.nickname');
                $this->db->from('hf_qianmi_order a');
                $this->db->join('hf_user_member b', 'b.user_id = a.userid','left');
                $query = $this->db->where('type','1')->where('uuid',$order)->like('userPostData',$phone,'both')->order_by('create_time','desc')->get();
                $list = $query->result_array();
            }else if(!empty($phone) && empty($order) && !empty($t)){
                $this->db->select('a.*,b.nickname');
                $this->db->from('hf_qianmi_order a');
                $this->db->join('hf_user_member b', 'b.user_id = a.userid','left');
                $query = $this->db->where('type','1')->like('userPostData',$phone,'both')->where('a.create_time >=',$t)->where("a.create_time <=",$e)->order_by('create_time','desc')->get();
                $list = $query->result_array();
            }else if(empty($phone) && !empty($order) && !empty($t)){
                $this->db->select('a.*,b.nickname');
                $this->db->from('hf_qianmi_order a');
                $this->db->join('hf_user_member b', 'b.user_id = a.userid','left');
                $query = $this->db->where('type','1')->where('uuid',$order)->where('a.create_time >=',$t)->where("a.create_time <=",$e)->order_by('create_time','desc')->get();
                $list = $query->result_array();
            }else if(!empty($phone) && !empty($order) && !empty($t)){
                $this->db->select('a.*,b.nickname');
                $this->db->from('hf_qianmi_order a');
                $this->db->join('hf_user_member b', 'b.user_id = a.userid','left');
                $query = $this->db->where('type','1')->where('uuid',$order)->where('a.create_time >=',$t)->where("a.create_time <=",$e)->like('userPostData',$phone,'both')->order_by('create_time','desc')->get();
                $list = $query->result_array();
            }else if(empty($phone) && empty($order) && empty($t)){
                $list = $this->Payment_model->get_qianmi_order('1');
            }
            if(!empty($list)){
                echo json_encode($list);
            }else{
                echo "3";
            }



        }else{
            echo "2";
        }
    }





    //导出充值纪录
    function Dow_Charge(){
        if($_POST){
            $pay = $this->input->post('type');
            $time = $this->input->post('begin_time');
            $endtime = $this->input->post('end_time');

            $this->load->library('excel');

            //activate worksheet number 1

            $this->excel->setActiveSheetIndex(0);

            //name the worksheet

            $this->excel->getActiveSheet()->setTitle('ImportOrder');

            $arr_title = array(

                'A' => '商品编号',

                'B' => '支付单号',

                'C' => '用户名称',

                'D' => '充值手机号码',

                'E' => '面额',

                'F' => '支付金额',
                
                'G' => '支付方式',
                'H' => '支付状态',
                'I' => '充值时间',
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
            if(!empty($time)){
                $start = $time . ' 00:00:00';
                $ennd = $endtime . ' 23:59:59';
            }else{
                 $start ='';
                 $ennd = '';
            }
            if(!empty($pay) && empty($start)){
                $list = $this->Payment_model->pay_qianmi_order($pay);
            }elseif(empty($pay) && !empty($start)){

                $list = $this->Payment_model->time_qianmi_order($start,$ennd);
            }elseif(!empty($pay) && !empty($start)){
                $list = $this->Payment_model->Paytime_qianmi_order($pay,$start,$ennd);
            }elseif(empty($pay) && empty($start)){
                $list = $this->Payment_model->get_qianmi_order('1');
            }

            if(count($list) > 0)

            {

                foreach ($list as $booking) {

                    $i++;
                    $this->excel->getActiveSheet()->setCellValue('A' . $i, $booking['id']);

                    $this->excel->getActiveSheet()->setCellValue('B' . $i, $booking['uuid']);

                    $this->excel->getActiveSheet()->setCellValue('C' . $i, $booking['nickname']);
                    $data = json_decode($booking['userPostData'],true);

                    $this->excel->getActiveSheet()->setCellValue('D' . $i, $data['mobileNo']);

                    $this->excel->getActiveSheet()->setCellValue('E' . $i, $data['rechargeAmount']);
                    $paydata = json_decode($booking['payment_data'],true);

                    $this->excel->getActiveSheet()->setCellValue('F' . $i, $paydata['advicePrice']);

                    $this->excel->getActiveSheet()->setCellValue('G' . $i, $data['payType']);
                    if($booking['state'] == '1'){
                        $this->excel->getActiveSheet()->setCellValue('H' . $i, '成功');

                    }else{
                        $this->excel->getActiveSheet()->setCellValue('H' . $i, '失败');

                    }
                    $this->excel->getActiveSheet()->setCellValue('I' . $i, $booking['create_time']);

                }
                 //日志

                $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."导出了话费充值信息",

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
                echo "<script>alert('没有记录');window.location.href='".site_url('/payment/Payment/energyCharge')."'</script>";
            }

        }else{
            $this->load->view('404.html');
        }


    }




}
 