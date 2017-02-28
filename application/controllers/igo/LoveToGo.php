<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
require_once(APPPATH.'controllers/Default_Controller.php');

class LoveToGo extends Default_Controller
{
	public $view_loveToGoList = 'loveToGo/loveToGoList.html';	
	public $view_loveToGogoodDetail = 'loveToGo/loveToGogoodDetail.html';
	public $view_loveToGoOrderList = 'loveToGo/loveToGoOrderList.html';
    //爱购分类
    public $view_loveToGoCates = "loveToGo/loveToGoCates.html";
    function __construct()
	{
		 parent::__construct();
         $this->load->model('Integral_model');

	}   
    //爱购 商品列表
    function loveToGoList(){

        $data['page'] = $this->view_loveToGoList;
        $data['menu'] = array('loveToGo','loveToGoList');
        $this->load->view('template.html',$data);
    }
    //获取爱购商品列表
    function get_remote_goods(){
        if($_POST){
            $page = $_POST['page'];
            $goods_list = $this->Integral_model->get_igo_goods();
            if(empty($goods_list)){
                echo "2";
            }else{
                echo json_encode($goods_list);
            }
        }else{
            echo "2";
        }
    }

    //更新爱购分裂
    function up_igo_cates(){
        $data = array(
            'appkey' => IGOAPPKEY,  
            'appsecret' => IGOAPPSECRET,
        );
        $post = curl_post(IGOCATEAPIURL, $data);  
        $goods = json_decode($post,true);
        $cate = json_decode($goods['data'],true);
         $this->db->where('type','2')->delete('hf_mall_category');
       
        $y = igoCate($cate);
        if($y == 1){
             //日志
            $log = array(
                'userid'=>$_SESSION['users']['user_id'],  
                "content" => $_SESSION['users']['username']."更新了爱购商品分类",
                "create_time" => date('Y-m-d H:i:s'),
                "userip" => get_client_ip(),
            );
            $this->db->insert('hf_system_journal',$log);
            echo "<script>alert('更新成功！');window.location.href='".site_url('/igo/LoveToGo/loveToGoCates')."'</script>";exit;
        }else{
            echo "<script>alert('更新失败！');window.location.href='".site_url('/igo/LoveToGo/loveToGoCates')."'</script>";exit;
 
        }

    }

    //爱购分类
    function loveToGoCates(){

        $cates = $this->Integral_model->get_goods_cates('2');
        $data['cates'] = igo_cate_list($cates);
        $data['page'] = $this->view_loveToGoCates;
        $data['menu'] = array('loveToGo','loveToGoCates');
        $this->load->view('template.html',$data);
    }

    //删除爱购分类
    function del_igo_cate(){
        if($_POST){
            $id = $this->input->post('id');
            if($this->db->where('catid',$id)->delete('hf_mall_category')){
                    //日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."删除了一个爱购分类，分类id是：".$id,
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


    //爱购 订单列表
    function loveToGoOrderList(){

        $data['page'] = $this->view_loveToGoOrderList;
        $data['menu'] = array('loveToGo','loveToGoOrderList');
        $this->load->view('template.html',$data);
    }

    //f返回爱购 订单列表
    function ret_loveTogo_order(){
        if($_POST){

            $list = $this->Integral_model->get_love_order();
            if(empty($list)){
                echo "2";
            }else{
                echo json_encode($list);
            }
        }else{
            echo "2";
        }
    }


    //爱购 本地商品详情
    function loveToGogoodLocalDetail(){
        if(!$_GET){
            $this->load->view('404.html');
        }else{
            $post_data = array(  
              'appkey' => IGOAPPKEY,  
              'appsecret' => IGOAPPSECRET,
              'open_iid' => $_GET['openid']
            ); 
            $post = curl_post(IGOINFOAPIURL, $post_data);  
            $goods = json_decode($post,true);
            $data['goods'] = $goods['data'];
          
            $data['page'] = $this->view_loveToGogoodDetail;
            $data['menu'] = array('loveToGo','loveToGoList');
            $this->load->view('template.html',$data);
        }
    }

    //删除 爱购商品
    function del_love_goods(){
            if($_POST){
                $id = $_POST['goodsid'];    
                //日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."删除了一个爱购商品。商品id是".$id,
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);
                if($this->Integral_model->del_love_goods($id)){
                    echo "1";
                }else{
                    echo "2";
                }
            }else{
                echo '2';
            }
    }


    //爱g购订单导出
    function dowload_love_order(){
        $id = $this->uri->segment(4);
        if($id == '1' || $id == '2'){

            $this->load->library('excel');
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('ImportOrder');
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
            switch ($id) {
                //导出今天订单
                case '1':
                    $data = date('Y-m-d');
                    $bookings = $this->Integral_model->get_love_newOrder($data);
                    break;
                //导出所有订单
                case '2':
                    $bookings = $this->Integral_model->get_love_order();  
                    break;
            }
            if(count($bookings) > 0)
            {
                foreach ($bookings as $booking) {
                    $i++;
                    $user = json_decode($booking['goods_data'],true);
                    $address = explode(' ',$user['sendAddress']['addressNow']);
                    foreach ($user['goodsData'] as $key => $value) {
                         $goods[$i][$key]= $value['goodsId'].'|'.$value['goodsnum'];
                    }
                    $good = implode(',',$goods[$i]);
                 //   $this->excel->getActiveSheet()->setCellValue('A' . $i,  $i - 1);
                    $this->excel->getActiveSheet()->setCellValue('A' . $i, $booking['order_UUID']);
                    $this->excel->getActiveSheet()->setCellValue('B' . $i, $user['sendAddress']['people']);
                    $this->excel->getActiveSheet()->setCellValue('C' . $i, $booking['id_card']);
                    $this->excel->getActiveSheet()->setCellValue('D' . $i, $user['sendAddress']['addressNow']);
                    $this->excel->getActiveSheet()->setCellValue('E' . $i, $user['sendAddress']['phoneNow']);
                    $this->excel->getActiveSheet()->setCellValue('F' . $i, '');
                    $this->excel->getActiveSheet()->setCellValue('G' . $i, '');
                    $this->excel->getActiveSheet()->setCellValue('H' . $i, '400000');
                    $this->excel->getActiveSheet()->setCellValue('I' . $i, $address['0']);
                    $this->excel->getActiveSheet()->setCellValue('J' . $i, $address['1']);
                    $this->excel->getActiveSheet()->setCellValue('K' . $i, $address['2']);
                    $this->excel->getActiveSheet()->setCellValue('L' . $i, $user['notice']);
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

            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            $objWriter->save('php://output');
        }else{
            $this->load->view('404.html');
        }
    }




}







