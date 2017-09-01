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

    //订单详情

    public $view_loveOrderinfo = "loveToGo/loveOrderinfo.html";

    //爱购分类

    public $view_loveToGoCates = "loveToGo/loveToGoCates.html";

    function __construct()

	{

		 parent::__construct();

         $this->load->model('Integral_model');

         $this->load->model('MallShop_model');



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

        $data = array(

            'appkey' => IGOAPPKEY,  

            'appsecret' => IGOAPPSECRET,

        );

        $post = curl_post(IGOCATEAPIURL, $data);  

        $goods = json_decode($post,true);

        $cate = json_decode($goods['data'],true);



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



    //编辑爱购分类

    function edit_igo_cates(){
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

            $data['catname'] = $this->input->post('name');

            $data['catid'] = $this->input->post('catid');

            if(!empty($_FILES['img']['tmp_name'])){

                $config['upload_path']      = 'Upload/icon';

                $config['allowed_types']    = 'svg|jpg|png|jpeg';

                $config['max_size']     = 2048;

                $config['file_name'] = date('Y-m-d_His');

                $this->load->library('upload', $config);

                //上传

                if ( ! $this->upload->do_upload('img')) {

                    echo "<script>alert('图片上传失败！');window.location.href='".site_url('/igo/LoveToGo/loveToGoCates/')."'</script>";

                    exit;

                } else{

                     $data['icon'] = '/Upload/icon/'.$this->upload->data('file_name');

                }

            }

            if($this->db->where('catid',$data['catid'])->update('hf_mall_category_igo',$data)){

                    //日志

                    $log = array(

                        'userid'=>$_SESSION['users']['user_id'],  

                        "content" => $_SESSION['users']['username']."编辑了爱购分类，分类id是".$data['catid'],

                        "create_time" => date('Y-m-d H:i:s'),

                        "userip" => get_client_ip(),

                    );

                    $this->db->insert('hf_system_journal',$log);

                 echo "<script>alert('操作成功！');window.location.href='".site_url('/igo/LoveToGo/loveToGoCates')."'</script>";

                    exit;

            }else{

                 echo "<script>alert('操作失败！');window.location.href='".site_url('/igo/LoveToGo/loveToGoCates')."'</script>";

                    exit;

            }

        }else{

            $this->load->view('404.html');

        }

    }





    //爱购分类

    function loveToGoCates(){



        $cates = $this->Integral_model->ret_igo_cates();

        $data['cates'] = igo_cate_list($cates);

        $data['page'] = $this->view_loveToGoCates;

        $data['menu'] = array('loveToGo','loveToGoCates');

        $this->load->view('template.html',$data);

    }



    //推荐爱购分类首页显示

    function loveToGoCates_recommend(){
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

            $id = $this->input->post('catid');

            $data['recommend_state'] = $this->input->post('recommend_state');

            $arr['recommend_state']  =  '0';

            $this->db->where('recommend_state','1')->update('hf_mall_category_igo',$arr);

            if($this->db->where('catid',$id)->update('hf_mall_category_igo',$data)){

                if($data['recommend_state'] == '1'){

                    $title  = "推荐了爱购分类到首页";

                }else{

                    $title = "取消了推荐爱购分类到首页";

                }

                 //日志

                $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username'].$title.',爱购分类id是：'.$id,

                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );

                $this->db->insert('hf_system_journal',$log);

                echo "1";

            }else{

                echo "3";

            }

        }else{

            echo "2";

        }

    }





    //删除爱购分类

    function del_igo_cate(){
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

            //获取用户信息

            foreach($list as $key=>$val){

                $address = $this->Integral_model->get_user_address($val['buyer_address']);

                if(empty($address)){

                    $list[$key]['adddress'] = '';

                }else{

                   $list[$key]['adddress'] = $address;

                }

                $list[$key]['id_card'] = $this->Integral_model->ret_user_info($val['buyer']);



                if($val['order_status'] == '3'){



                }

                $endtime = strtotime($val['updatetime'])+3600*24*15;

                //获取当前时间

                $newdata = time();

                //var_dump($newdata);

                if($newdata > $endtime && $val['order_status'] == '3'){

                    $data['order_status'] = '4';

                    $this->MallShop_model->edit_order_state($val['order_id'],$data);

                }

            }

            if(empty($list)){

                echo "2";

            }else{

                echo json_encode($list);

            }

        }else{

            echo "2";

        }

    }



    //返回爱购订单详情

    function loveToGo_order_info(){

        $id = intval($this->uri->segment(4));

        if($id == 0){

            $this->load->view('404.html');

        }else{

            $order = $this->Integral_model->ret_loveOrder_info($id);

            $data['address'] = $this->MallShop_model->ret_user_address($order['buyer_address']);

            $data['id_card'] = $this->Integral_model->ret_user_info($order['buyer']);



            //获取收货地址

            $data['address'] = $this->MallShop_model->ret_user_address($order['buyer_address']);

            //后去运费模板

          //  $express = json_decode($order['userPostData'],true);

           // $data['express'] = $this->MallShop_model->ret_store_express($express['express_id']);

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

            $data['page'] = $this->view_loveOrderinfo;

            $data['menu'] = array('loveToGo','loveToGoOrderList');

            $this->load->view('template.html',$data);

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

        $begin_date = $this->uri->segment(4);

        $endtime = $this->uri->segment(5);

            // $bookings = $this->Integral_model->get_love_newOrder('2017-05-06','2017-07-22');

            // var_dump($endtime);

            // exit;

        if($begin_date != '0'){



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

            $begin_date = $begin_date . ' 00:00:00';

             $endtime = $endtime . ' 23:59:59';

            $bookings = $this->Integral_model->get_love_newOrder($begin_date,$endtime);

          

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

        }else{

            $this->load->view('404.html');

        }

    }





    //爱购订单搜索

    function search_love_order(){

        if($_POST){

            $order_status = $this->input->post('order_status');

            $username = $this->input->post('buyer');

            $start_time = $this->input->post('start_time');

            $endtime = $this->input->post('end_time');



             if(!empty($username)){

                //获取买家id

                $query = $this->db->where('username',$username)->get('hf_user_member');

                $res = $query->row_array();

                $buyer = $res['user_id'];

            }else{

                $buyer = '';

            }

            $res ='';

            if(!empty($order_status) && empty($buyer) && empty($start_time)){

                $where['order_type'] = '0';

                $this->db->select('a.*,b.username,b.nickname');

                $this->db->from('hf_mall_order a');

                $this->db->join('hf_user_member b','b.user_id = a.buyer','left');

                $query = $this->db->where($where)->where('a.order_status',$order_status)->order_by('create_time','asc')->get();  

                $res = $query->result_array();              

            }else if(empty($order_status) && !empty($buyer) && empty($start_time)){

                $where['order_type'] = '0';

                $this->db->select('a.*,b.username,b.nickname');

                $this->db->from('hf_mall_order a');

                $this->db->join('hf_user_member b','b.user_id = a.buyer','left');

                $query = $this->db->where($where)->where('a.buyer',$buyer)->order_by('a.create_time','asc')->get();  

                $res = $query->result_array();    

            }else if(empty($order_status) && empty($buyer) && !empty($start_time)){

                $where['order_type'] = '0';

                $this->db->select('a.*,b.username,b.nickname');

                $this->db->from('hf_mall_order a');

                $this->db->join('hf_user_member b','b.user_id = a.buyer','left');

                $query = $this->db->where($where)->where('a.create_time >=',$start_time)->where('a.create_time <=',$endtime)->order_by('create_time','asc')->get();  

                $res = $query->result_array(); 

            }else if(!empty($order_status) && !empty($buyer) && empty($start_time)){

                $where['order_type'] = '0';

                $this->db->select('a.*,b.username,b.nickname');

                $this->db->from('hf_mall_order a');

                $this->db->join('hf_user_member b','b.user_id = a.buyer','left');

                $query = $this->db->where($where)->where('a.order_status',$order_status)->where('a.buyer <=',$buyer)->order_by('create_time','asc')->get();  

                $res = $query->result_array(); 

            }else if(empty($order_status) && !empty($buyer) && !empty($start_time)){

                $where['order_type'] = '0';

                $this->db->select('a.*,b.username,b.nickname');

                $this->db->from('hf_mall_order a');

                $this->db->join('hf_user_member b','b.user_id = a.buyer','left');

                $query = $this->db->where($where)->where('a.create_time >=',$start_time)->where('a.create_time <=',$endtime)->where('a.buyer',$buyer)->order_by('create_time','asc')->get();  

                $res = $query->result_array(); 



            }else if(!empty($order_status) && empty($buyer) && !empty($start_time)){

                 $where['order_type'] = '0';

                $this->db->select('a.*,b.username,b.nickname');

                $this->db->from('hf_mall_order a');

                $this->db->join('hf_user_member b','b.user_id = a.buyer','left');

                $query = $this->db->where($where)->where('a.create_time >=',$start_time)->where('a.create_time <=',$endtime)->where('a.order_status',$order_status)->order_by('create_time','asc')->get();  

                $res = $query->result_array(); 

            }else if(!empty($order_status) && !empty($buyer) && !empty($start_time)){

                $where['order_type'] = '0';

                $this->db->select('a.*,b.username,b.nickname');

                $this->db->from('hf_mall_order a');

                $this->db->join('hf_user_member b','b.user_id = a.buyer','left');

                $query = $this->db->where($where)->where('a.order_status',$order_status)-where('buyer',$buyer)->where('a.create_time >=',$start_time)->where('a.create_time <=',$endtime)->order_by('create_time','asc')->get();  

                $res = $query->result_array(); 

            }else if(empty($order_status) && empty($buyer) && empty($start_time)){

                $where['order_type'] = '0';

                $this->db->select('a.*,b.username,b.nickname');

                $this->db->from('hf_mall_order a');

                $this->db->join('hf_user_member b','b.user_id = a.buyer','left');

                $query = $this->db->where($where)->order_by('create_time','asc')->get();  

                $res = $query->result_array(); 

            }

            if(!empty($res)){

                //获取用户信息

            foreach($res as $key=>$val){

                $res[$key]['adddress'] = $this->Integral_model->get_user_address($val['buyer_address']);

                $res[$key]['id_card'] = $this->Integral_model->ret_user_info($val['buyer']);

            }

                echo json_encode($res);

            }else{

                echo "3";

            }

        }else{

            echo "2";

        }

    }





    // //爱购订单退款

    // function refund_loveTogo_Order(){

    //     if($_POST){

            

    //     }else{

    //         echo "3";

    //     }

    // }









}















