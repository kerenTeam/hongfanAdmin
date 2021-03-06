<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*

 *  电子券管理

 *

 * */

require_once(APPPATH.'controllers/Default_Controller.php');

class Electronic extends Default_Controller {

    //电子劵列表

    public $view_electronicList = "electronic/electronicList.html"; 

    //电子劵新增

    public $view_addElectronic = "electronic/addElectronic.html";

    //电子卷编辑

    public $view_editElectronic = "electronic/editElectronic.html";

    //电子券核销列表

    public $view_afterSales = "electronic/afterSales.html";

    //招商信息
    public $view_attract = "electronic/attract.html";

    //县志
    public $view_annals = "electronic/annals.html";
    public $view_editAnnals = "electronic/edit_annals.html";

    //优惠卷领取数
    public $view_coupon_electronic = 'electronic/coupon_electronic.html';



    function __construct()

    {

        parent::__construct();

        $this->load->model('Activity_model');

        $this->load->model('Shop_model');
        $this->load->model('Public_model');

    }

    //electronic列表

    function electronicList(){
        //获取商家
       // $data['store'] = $this->

         $data['store']= $this->Shop_model->shop_list('1');
    
         $data['coupon'] = $this->Activity_model->get_coupons();


         $data['page']= $this->view_electronicList;

         $data['menu'] = array('moll','electronicList');

         $this->load->view('template.html',$data);

    }




    //返回所有卡卷

    function get_electr_list(){

        if($_POST){

            $list = $this->Activity_model->get_coupons();
           

            if(empty($list)){
                echo "2";
            }else{
                 foreach ($list as $key => $value) {
                     if(date('Y-m-d',time()) > $value['end_date']){
                        $arr['state'] = '0';
                        $this->Activity_model->edit_electronic($value['id'],$arr);
                     }
                     $list[$key]['he'] = count($this->Activity_model->get_WriteNum($value['id']));
                     //返回领取数
                     $list[$key]['lin'] = count($this->Activity_model->get_ReceiveNum($value['id']));

                     $list[$key]['receive'] = count($this->Activity_model->search_receive($value['id'],'0'));
                     //获取商家名字
                     $storename[$key] = '';
                     $a = json_decode($value['storeid'],true);

                     foreach ($a as $k => $v) {
                         $storename[$key] .= get_store_name($v).',';
                     }
                     $list[$key]['storename'] = $storename[$key];

                }
                echo json_encode($list);
            }

        }else{

            echo "2";

        }

    }



    //新增electronic

    function addElectronic(){

        //获取优惠劵类型

         $data['type'] = $this->Activity_model->get_coupon_type();

         //获取找点商家

         $data['store']  =  $this->Shop_model->shop_list('1');



         $data['page']= $this->view_addElectronic;

         $data['menu'] = array('moll','electronicList');

         $this->load->view('template.html',$data);

    }

    //新增优惠劵操作

    function add_electronic(){
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
            switch ($_SESSION['city']) {
                case '0':
                    $data['city'] = $this->input->post('city');
                    break;
                case '1':
                     $data['city'] = '1';
                    break;
                case '2':
                     $data['city'] = '2';
                    break;
                case '3':
                     $data['city'] = '3';
                    break;
                case '4':
                     $data['city'] = '4';
                    break;
            }

            if($data['typeid'] == 2){
                $arr = array($data['overflow'],$data['cut']);
                $data['coupon_amount'] = implode(',',$arr);
                unset($data['meetMoney'],$data['reduceMoney'],$data['overflow'],$data['cut']);
            }else if($data['typeid'] == 3){
                $arr = array($data['meetMoney'],$data['reduceMoney']);
                $data['coupon_amount'] = implode(',',$arr);
                unset($data['meetMoney'],$data['reduceMoney'],$data['overflow'],$data['cut']);
            }else{
                unset($data['meetMoney'],$data['reduceMoney'],$data['overflow'],$data['cut']);
            }

            if(!empty($data['store'])){
                $data['storeid'] = json_encode($data['store']);

            }
             unset($data['store']);
            
      
   
            $header = array("token:".$_SESSION['token'],'city:'.'1');    
            if(!empty($_FILES['img']['name'])){
                    $tmpfile = new CURLFile(realpath($_FILES['img']['tmp_name']));
                
                    $pics = array(
                        'pics' =>$tmpfile,
                        'porfix'=>'shop/coupon',
                        'bucket'=>"ebus",
                    );
                
                    $qiuniu = json_decode(curl_post_express($header,QINIUUPLOAD,$pics),true);

                    if($qiuniu['errno'] == '0'){
                        $img = json_decode($qiuniu['data']['img'],true);
                        $icon[]['picImg'] =$img[0]['picImg'];
                        $data['pic'] = json_encode($icon);
                    }else{
                      echo "<script>alert('图片上传失败！');window.location.href='".site_url('/electronic/Electronic/addElectronic')."'</script>";exit;
                    }
            }


            if($this->Activity_model->add_electronic($data)){

                 //日志

                $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."新增了一个优惠卷。优惠卷名称是".$data['name'],

                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );

                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/electronic/Electronic/electronicList')."'</script>";exit;

            }else{

                echo "<script>alert('操作失败！');window.location.href='".site_url('/electronic/Electronic/addElectronic')."'</script>";exit;

            }

        }else{

            $this->load->view('404.html');

        }

    }



    //编辑electronic

    function editElectronic(){

        $id = intval($this->uri->segment(4));

        if($id == 0){

            $this->load->view('404.html');

        }else{

            $data['type'] = $this->Activity_model->get_coupon_type();

            //获取卡卷信息

            $data['coupon'] = $this->Activity_model->get_electr_info($id);
            //获取找点商家
            $data['store']  =  $this->Shop_model->shop_list('1');




             $data['page']= $this->view_editElectronic;

             $data['menu'] = array('moll','electronicList');

             $this->load->view('template.html',$data);

        }

    }



    //卡卷编辑操作

    function edit_Electronic(){
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
            switch ($_SESSION['city']) {
                case '0':
                    $data['city'] = $this->input->post('city');
                    break;
                case '1':
                     $data['city'] = '1';
                    break;
                case '2':
                     $data['city'] = '2';
                    break;
                case '3':
                     $data['city'] = '3';
                    break;
                case '4':
                     $data['city'] = '4';
                    break;
            }

            if($data['typeid'] == 2){
                $arr = array($data['overflow'],$data['cut']);
                $data['coupon_amount'] = implode(',',$arr);
                unset($data['meetMoney'],$data['reduceMoney'],$data['overflow'],$data['cut']);
            }else if($data['typeid'] == 3){
                $arr = array($data['meetMoney'],$data['reduceMoney']);
                $data['coupon_amount'] = implode(',',$arr);
                unset($data['meetMoney'],$data['reduceMoney'],$data['overflow'],$data['cut']);
            }else{
                unset($data['meetMoney'],$data['reduceMoney'],$data['overflow'],$data['cut']);
            }

            if(!empty($data['store'])){
                $data['storeid'] = json_encode($data['store']);

            }
            unset($data['store']);
            $header = array("token:".$_SESSION['token'],'city:1');    
            if(!empty($_FILES['img']['name'])){
                    $tmpfile = new CURLFile(realpath($_FILES['img']['tmp_name']));
                
                    $pics = array(
                        'pics' =>$tmpfile,
                        'porfix'=>'shop/coupon',
                        'bucket'=>"ebus",
                    );
                
                    $qiuniu = json_decode(curl_post_express($header,QINIUUPLOAD,$pics),true);

                    if($qiuniu['errno'] == '0'){
                        $img = json_decode($qiuniu['data']['img'],true);
                        $icon[]['picImg'] =$img[0]['picImg'];
                        $data['pic'] = json_encode($icon);
                    }else{
                      echo "<script>alert('图片上传失败！');window.location.href='".site_url('/electronic/Electronic/addElectronic')."'</script>";exit;
                    }
            }

            //日志
            if($this->Activity_model->edit_electronic($data['id'],$data)){
                  $log = array(

                        'userid'=>$_SESSION['users']['user_id'],  

                        "content" => $_SESSION['users']['username']."编辑了一个优惠卷。优惠卷id是".$data['id'].',优惠卷名称是'.$data['name'],

                        "create_time" => date('Y-m-d H:i:s'),

                        "userip" => get_client_ip(),

                    );
                $this->db->insert('hf_system_journal',$log);


                echo "<script>alert('操作成功！');window.location.href='".site_url('/electronic/Electronic/electronicList')."'</script>";

            }else{

                echo "<script>alert('操作失败！');window.location.href='".site_url('/electronic/Electronic/editElectronic/'.$data['id'])."'</script>";

            }

        }else{

            $this->load->view('404.html');

        }

    }


    //电商优惠劵使用纪录
    function mallSales(){
        // $id = intval($this->uri->segment('4'));
        // if($id == '0'){
        //     $this->load->view('404.html');
        // }else{
        //      $data['id'] = $id;
            
             // //获取卡卷信息
             // $data['coupon'] = $this->Activity_model->get_electr_info($id);
             // //获取所有优惠劵

             $data['coupons'] = $this->Activity_model->get_coupons();

        
             $data['page']= 'electronic/mallShopSales.html';

             $data['menu'] = array('moll','electronicList');

             $this->load->view('template.html',$data);
        // }

    }
    //返回电商使用纪录
    function retMallSales(){
        if($_POST){
            $time = $this->input->post('begin_time');
            $end = $this->input->post('end_time');
            $start = $this->input->post('start');
            $couponId = $this->input->post('couponId');
            $size = $this->input->post('count');
            // if($start != '0'){
                $_SESSION['mallSales'] = $start;
            // }
            if(!empty($time)){
                $t = $time . ' 00:00:00';
                $e = $end . ' 23:59:59';
            }else{
                $t = '';
                $e = '';
            }
            //列表
            if(!empty($t) && empty($couponId)){
                $this->db->select('a.*,b.title,b.name,b.id,c.nickname,e.order_id,e.seller,f.store_name');
                $this->db->from('hf_shop_coupon as b');
                $this->db->join('hf_user_coupon as a','a.store_coupon_id = b.id','INNER');
                $this->db->join('hf_user_member as c','a.userid = c.user_id','INNER');
                $this->db->join('hf_mall_order as e','a.user_coupon_id = e.userCouponId','INNER');
                $this->db->join('hf_shop_store as f','e.seller = f.store_id','INNER');
                $query = $this->db->where('a.standardTime >=',$t)->where('a.standardTime <=',$e)->where('a.user_coupon_state','0')->get();

                $list = $query->result_array();
$this->db->select('a.*,b.title,b.name,b.id,c.nickname,e.order_id,e.seller,f.store_name');
                $this->db->from('hf_shop_coupon as b');
                $this->db->join('hf_user_coupon as a','a.store_coupon_id = b.id','INNER');
                $this->db->join('hf_user_member as c','a.userid = c.user_id','INNER');
                $this->db->join('hf_mall_order as e','a.user_coupon_id = e.userCouponId','INNER');
                $this->db->join('hf_shop_store as f','e.seller = f.store_id','INNER');
                $query1 =  $this->db->where('a.standardTime >=',$t)->where('a.standardTime <=',$e)->where('a.user_coupon_state','0')->order_by('a.user_coupon_id','desc')->limit($size,$start)->get();
                $listpage = $query1->result_array();

            }else if(empty($t) && !empty($couponId)){$this->db->select('a.*,b.title,b.name,b.id,c.nickname,e.order_id,e.seller,f.store_name');
                $this->db->from('hf_shop_coupon as b');
                $this->db->join('hf_user_coupon as a','a.store_coupon_id = b.id','INNER');
                $this->db->join('hf_user_member as c','a.userid = c.user_id','INNER');
                $this->db->join('hf_mall_order as e','a.user_coupon_id = e.userCouponId','INNER');
                $this->db->join('hf_shop_store as f','e.seller = f.store_id','INNER');
                $query = $this->db->where('a.store_coupon_id',$couponId)->where('a.user_coupon_state','0')->get();

                $list = $query->result_array();
$this->db->select('a.*,b.title,b.name,b.id,c.nickname,e.order_id,e.seller,f.store_name');
                $this->db->from('hf_shop_coupon as b');
                $this->db->join('hf_user_coupon as a','a.store_coupon_id = b.id','INNER');
                $this->db->join('hf_user_member as c','a.userid = c.user_id','INNER');
                $this->db->join('hf_mall_order as e','a.user_coupon_id = e.userCouponId','INNER');
                $this->db->join('hf_shop_store as f','e.seller = f.store_id','INNER');
                $query1 =  $this->db->where('a.store_coupon_id',$couponId)->where('a.user_coupon_state','0')->order_by('a.user_coupon_id','desc')->limit($size,$start)->get();
                $listpage = $query1->result_array();

            }else if(!empty($t) && !empty($couponId)){$this->db->select('a.*,b.title,b.name,b.id,c.nickname,e.order_id,e.seller,f.store_name');
                $this->db->from('hf_shop_coupon as b');
                $this->db->join('hf_user_coupon as a','a.store_coupon_id = b.id','INNER');
                $this->db->join('hf_user_member as c','a.userid = c.user_id','INNER');
                $this->db->join('hf_mall_order as e','a.user_coupon_id = e.userCouponId','INNER');
                $this->db->join('hf_shop_store as f','e.seller = f.store_id','INNER');
                $query = $this->db->where('a.standardTime >=',$t)->where('a.standardTime <=',$e)->where('a.store_coupon_id',$couponId)->where('a.user_coupon_state','0')->get();

                $list = $query->result_array();
$this->db->select('a.*,b.title,b.name,b.id,c.nickname,e.order_id,e.seller,f.store_name');
                $this->db->from('hf_shop_coupon as b');
                $this->db->join('hf_user_coupon as a','a.store_coupon_id = b.id','INNER');
                $this->db->join('hf_user_member as c','a.userid = c.user_id','INNER');
                $this->db->join('hf_mall_order as e','a.user_coupon_id = e.userCouponId','INNER');
                $this->db->join('hf_shop_store as f','e.seller = f.store_id','INNER');
                $query1 =  $this->db->where('a.standardTime >=',$t)->where('a.standardTime <=',$e)->where('a.store_coupon_id',$couponId)->where('a.user_coupon_state','0')->order_by('a.user_coupon_id','desc')->limit($size,$start)->get();
                $listpage = $query1->result_array();

            }else if(empty($t) && empty($couponId)){$this->db->select('a.*,b.title,b.name,b.id,c.nickname,e.order_id,e.seller,f.store_name');
                $this->db->from('hf_shop_coupon as b');
                $this->db->join('hf_user_coupon as a','a.store_coupon_id = b.id','INNER');
                $this->db->join('hf_user_member as c','a.userid = c.user_id','INNER');
                $this->db->join('hf_mall_order as e','a.user_coupon_id = e.userCouponId','INNER');
                $this->db->join('hf_shop_store as f','e.seller = f.store_id','INNER');
                $query = $this->db->where('a.user_coupon_state','0')->get();

                $list = $query->result_array();
$this->db->select('a.*,b.title,b.name,b.id,c.nickname,e.order_id,e.seller,f.store_name');
                $this->db->from('hf_shop_coupon as b');
                $this->db->join('hf_user_coupon as a','a.store_coupon_id = b.id','INNER');
                $this->db->join('hf_user_member as c','a.userid = c.user_id','INNER');
                $this->db->join('hf_mall_order as e','a.user_coupon_id = e.userCouponId','INNER');
                $this->db->join('hf_shop_store as f','e.seller = f.store_id','INNER');
                $query1 =  $this->db->where('a.user_coupon_state','0')->order_by('a.user_coupon_id','desc')->limit($size,$start)->get();
                $listpage = $query1->result_array();
            }
           
            if(!empty($listpage)){
                echo json_encode(['total'=>count($list),'subjects'=>$listpage]);
            }else{
                echo "2";
            }


        }else{
            echo "1";
        }
    }

    //导出使用纪录
    function dowMallSales(){
       if($_POST){
            $couponId = $this->input->post('couponId');
            if(empty($couponId)){
                $this->db->select('a.*,b.title,b.name,b.id,c.nickname,c.phone,e.order_id,e.seller,f.store_name');
                $this->db->from('hf_shop_coupon as b');
                $this->db->join('hf_user_coupon as a','a.store_coupon_id = b.id','INNER');
                $this->db->join('hf_user_member as c','a.userid = c.user_id','INNER');
                $this->db->join('hf_mall_order as e','a.user_coupon_id = e.userCouponId','INNER');
                $this->db->join('hf_shop_store as f','e.seller = f.store_id','INNER');
                $query = $this->db->where('a.user_coupon_state','0')->order_by('a.user_coupon_id','desc')->get();

                $list = $query->result_array();
            }else{
                $this->db->select('a.*,b.title,b.name,b.id,c.nickname,c.phone,e.order_id,e.seller,f.store_name');
                $this->db->from('hf_shop_coupon as b');
                $this->db->join('hf_user_coupon as a','a.store_coupon_id = b.id','INNER');
                $this->db->join('hf_user_member as c','a.userid = c.user_id','INNER');
                $this->db->join('hf_mall_order as e','a.user_coupon_id = e.userCouponId','INNER');
                $this->db->join('hf_shop_store as f','e.seller = f.store_id','INNER');
                $query = $this->db->where('a.store_coupon_id',$couponId)->where('a.user_coupon_state','0')->order_by('a.user_coupon_id','desc')->get();

                $list = $query->result_array();
            }

            if(!empty($list)){
                    $this->load->library('excel');

                    $this->excel->setActiveSheetIndex(0);

                    //name the worksheet

                    $this->excel->getActiveSheet()->setTitle('Stores');

                    $arr_title = array(

                        'A' => '编号',

                        'B' => '领取用户',
                        'C' => '用户电话',
                        'D' => '用户购买单号',
                        'E' => '优惠卷名称',
                        'F' => '优惠卷编号',
                        'G' => '电商订单号',
                        'H' => '电商商家名称',
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


                    foreach ($list as $booking) {
                        $i++;
                       
                        $this->excel->getActiveSheet()->setCellValue('A' . $i, $booking['user_coupon_id']);
                        $this->excel->getActiveSheet()->setCellValue('B' . $i, $booking['nickname']);
                        $this->excel->getActiveSheet()->setCellValue('C' . $i, $booking['phone']);
                        $this->excel->getActiveSheet()->setCellValue('D' . $i, $booking['orderUUID']);
                        $this->excel->getActiveSheet()->setCellValue('E' . $i, $booking['title'].'-'.$booking['name']);
                        $this->excel->getActiveSheet()->setCellValue('F' . $i, $booking['id']);
                        $this->excel->getActiveSheet()->setCellValue('G' . $i, $booking['order_id']);
                        $this->excel->getActiveSheet()->setCellValue('H' . $i, $booking['store_name']);


                    }

                

                    $filename = '优惠劵电商使用纪录.xls'; //save our workbook as this file name



                    header('Content-Type: application/vnd.ms-excel'); //mime type

                    header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name

                    header('Cache-Control: max-age=0'); //no cache



                     $log = array(

                        'userid'=>$_SESSION['users']['user_id'],  

                        "content" => $_SESSION['users']['username']."导出了优惠劵电商使用纪录",

                        "create_time" => date('Y-m-d H:i:s'),

                        "userip" => get_client_ip(),

                    );

                    $this->db->insert('hf_system_journal',$log);





                    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

                    $objWriter->save('php://output');

            }else{
                echo "<script>alert('暂无信息！');window.history.go(-1);</script>";
            }
       }
    }


    // function retCouponRecord(){
    //     if($_POST){
    //         $start = $this->input->post('start');
    //         if($start != '0'){
    //             $_SESSION['couRec'] = $start;
    //         }
    //         $size = $this->input->post('count');
    //         $uuid = $this->input->post('uuid');
    //         $couponId = $this->input->post('couponId');

    //         if(!empty($uuid) && empty($couponId)){
    //             $this->db->select('a.*,b.title,b.name,b.id,c.nickname,d.payType,e.order_id');
    //             $this->db->from('hf_shop_coupon as b');
    //             $this->db->join('hf_user_coupon as a','a.store_coupon_id = b.id','left');
    //             $this->db->join('hf_user_member as c','a.userid = c.user_id','left');
    //             $this->db->join('hf_mall_order_repaydata as d','a.orderUUID = d.repay_UUID','left');
    //             $this->db->join('hf_mall_order as e','a.user_coupon_id = e.userCouponId','left');

    //             $query = $this->db->like('a.orderUUID',$uuid,'both')->order_by('a.user_coupon_id','desc')->get();
    //             $listpage = $query->result_array();
    //             $list = $listpage;
    //         }elseif(empty($uuid) && !empty($couponId)){
    //             $this->db->select('a.*,b.title,b.name,b.id,c.nickname,d.payType,e.order_id');
    //             $this->db->from('hf_shop_coupon as b');
    //             $this->db->join('hf_user_coupon as a','a.store_coupon_id = b.id','left');
    //             $this->db->join('hf_user_member as c','a.userid = c.user_id','left');
    //             $this->db->join('hf_mall_order_repaydata as d','a.orderUUID = d.repay_UUID','left');
    //             $this->db->join('hf_mall_order as e','a.user_coupon_id = e.userCouponId','left');

    //             $query = $this->db->where('a.store_coupon_id',$couponId)->order_by('a.user_coupon_id','desc')->get();
    //             $query1 = $this->db->where('a.store_coupon_id',$couponId)->order_by('a.user_coupon_id','desc')->limit($size,$start)->get();
    //             $list = $query->result_array();
    //             $listpage = $query1->result_array();


    //         }else{
    //             $this->db->select('a.*,b.title,b.name,b.id,c.nickname,d.payType,e.order_id');
    //             $this->db->from('hf_shop_coupon as b');
    //             $this->db->join('hf_user_coupon as a','a.store_coupon_id = b.id','left');
    //             $this->db->join('hf_user_member as c','a.userid = c.user_id','left');
    //             $this->db->join('hf_mall_order_repaydata as d','a.orderUUID = d.repay_UUID','left');
    //             // $this->db->join('hf_mall_order as e','a.user_coupon_id = e.userCouponId','left');
    //             $query = $this->db->order_by('a.user_coupon_id','desc')->get();
    //             $query1 = $this->db->order_by('a.user_coupon_id','desc')->limit($size,$start)->get();
    //             $list = $query->result_array();
    //             $listpage = $query1->result_array();
    //         }
          
    //         // var_dump(count($list));
    //         if(!empty($listpage)){
    //             echo json_encode(['total'=>count($list),'subjects'=>$listpage]);
    //         }else{
    //             echo "2";
    //         }

    //     }
    // }




    //删除优惠劵

    function del_coupon(){
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

            if(empty($id)){ 

                echo "2";exit;

            }

            //日志

            $log = array(

                'userid'=>$_SESSION['users']['user_id'],  

                "content" => $_SESSION['users']['username']."删除了一个优惠卷。优惠卷id是".$id,

                "create_time" => date('Y-m-d H:i:s'),

                "userip" => get_client_ip(),

            );

            $this->db->insert('hf_system_journal',$log);

            if($this->Activity_model->del_coupon($id)){
               // $this->Activity_model-
                echo "1";

            }else{

                echo "2";

            }

        }else{ 

            echo "2";

        }

    }



    //搜索优惠劵

    function search_electronic(){

        if($_POST){

            $store_id = $_POST['store_id'];
            $city = $_POST['city'];

            if(!empty($store_id) && empty($city)){

                // $list = $this->Activity_model->select_where('hf_shop_coupon','storeid',$store_id);

                $query = $this->db->like('storeid',$store_id,'both')->order_by('id','desc')->get('hf_shop_coupon');
                $list = $query->result_array();

            }else if(empty($store_id) && !empty($city)){
                if($city == '5'){
                    $city ='0';
                }
                $list = $this->Activity_model->select_where('hf_shop_coupon','city',$city);

            }else if(!empty($store_id) && !empty($city)){
                if($city == '5'){
                    $city ='0';
                }
                $list = $this->Activity_model->select_where_may('hf_shop_coupon','storeid',$store_id,'city',$city);
            }else if(empty($store_id) && empty($city)){
                $list = $this->Activity_model->get_coupons();
            }
            foreach ($list as $key => $value) {
                 $list[$key]['he'] = count($this->Activity_model->get_WriteNum($value['id']));
                 //返回领取数
                 $list[$key]['lin'] = count($this->Activity_model->get_ReceiveNum($value['id']));
            }

            if(!empty($list)){
                echo json_encode($list);
            }else{
                echo "2";
            }



        }else{

            echo "2";

        }

    }

    //核销列表

    function afterSales(){
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

        //查看核销情况列表

        $id = intval($this->uri->segment('4'));

        if($id == 0){

            $this->load->view('404.html');

        }else{

         $data['id'] = $id;
         //返回核销数
         $data['he'] = $this->Activity_model->get_WriteNum($id);
         //返回领取数
         $data['lin'] = $this->Activity_model->get_ReceiveNum($id);
         //获取卡卷信息
         $data['coupon'] = $this->Activity_model->get_electr_info($id);
      

         //返回所有商家
         $data['store']= $this->Shop_model->shop_list('1');

         $data['page']= $this->view_afterSales;

         $data['menu'] = array('moll','electronicList');

         $this->load->view('template.html',$data);

        }

    }


    



    //返回核销信息

    function ret_after_list(){

        if($_POST){

            $id = $this->input->post('id');

            $list = $this->Activity_model->ret_after_list($id);

            foreach($list as $key=>$val){
                $list[$key]['store_name'] = $this->Activity_model->get_store_name($val['store_id']);
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

    //删除核销记录
    function del_afterSales(){
        if($_POST){
            $id = $this->input->post('id');
            if($this->Activity_model->del_afterSales($id)){
                echo "1";
            }else{
                echo "2";
            }
        }else{
            echo "2";
        }
      
    }


    //根据日期返回核销记录

    function search_after(){

        if($_POST){

            $time = $this->input->post('time');

            $entime = $this->input->post('endtime');

            $id = $this->input->post('id');
            $store_id = $this->input->post('store_id');

            if(!empty($time) && empty($store_id)){
                $start_time = $time.' 00:00:00';
                $end_time = $entime.' 23:59:59';
                $list = $this->Activity_model->get_search_after($id,$start_time,$end_time);

            }else if(empty($time) && !empty($store_id)){
                $list = $this->Activity_model->select_where_may('hf_shop_couponverify','store_id',$store_id,'shop_coupon_id',$id);
            }else if(!empty($time) && !empty($store_id)){
                $start_time = $time.' 00:00:00';
                $end_time = $entime.' 23:59:59';
                $query = $this->db->where('shop_coupon_id',$id)->where('store_id',$store_id)->where('create_time >=',$start_time)->where("create_time <=",$end_time)->get('hf_shop_couponverify');
                $list = $query->result_array();
            }else if(empty($time) && empty($store_id)){
                $list = $this->Activity_model->ret_after_list($id);
            }

            if(!empty($list)){

                foreach($list as $key=>$val){
                   $list[$key]['store_name'] = $this->Activity_model->get_store_name($val['store_id']);
                   $list[$key]['nickname'] =nick_name($val['userid']);
                }

                echo json_encode($list);
            }else{

                echo "3";

            }

        }else{

            echo "2";

        }

    }

    //导出
    function DoW_after(){
        if($_POST){
            $store_id = $this->input->post('store_id');
            $time = $this->input->post('begin_time');
            $entime = $this->input->post('end_time');
            $id = $this->input->post('id');
            //var_dump($_POST);
             if(!empty($time) && empty($store_id)){
                $start_time = $time.' 00:00:00';
                $end_time = $entime.' 23:59:59';
                $list = $this->Activity_model->get_search_after($id,$start_time,$end_time);

            }else if(empty($time) && !empty($store_id)){
                $list = $this->Activity_model->select_where_may('hf_shop_couponverify','store_id',$store_id,'shop_coupon_id',$id);
            }else if(!empty($time) && !empty($store_id)){
                $start_time = $time.' 00:00:00';
                $end_time = $entime.' 23:59:59';

                $query = $this->db->where('shop_coupon_id',$id)->where('store_id',$store_id)->where('create_time >=',$start_time)->where("create_time <=",$end_time)->get('hf_shop_couponverify');
                $list = $query->result_array();
            }else if(empty($time) && empty($store_id)){
                $list = $this->Activity_model->ret_after_list($id);
            }
         
            if(!empty($list)){
            $this->load->library('excel');

            //activate worksheet number 1

            $this->excel->setActiveSheetIndex(0);

            //name the worksheet

            $this->excel->getActiveSheet()->setTitle('Stores');

            $arr_title = array(

                'A' => '编号',

                'B' => '核销用户',

                'C' => '用户电话',
                'D' => '用户购买单号',

                'E' => '核销商家名称',

                'F' => '优惠卷名称',

                'G' => '优惠卷价格',

                'H'=>'核销时间',

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

           // $bookings = $this->Shop_model->shop_list($id);


            foreach ($list as $booking) {


                $i++;
                $storename = $this->Activity_model->get_store_name($booking['store_id']);
                $coupon = $this->Activity_model->select_where_one('hf_shop_coupon','id',$booking['shop_coupon_id']);
                $user = $this->Activity_model->select_where_one('hf_user_member','user_id',$booking['userid']);
                $usercoupon = $this->Activity_model->select_where_one('hf_user_coupon','user_coupon_id',$booking['user_coupon_id']);
        

                $this->excel->getActiveSheet()->setCellValue('A' . $i, $booking['id']);
                $this->excel->getActiveSheet()->setCellValue('B' . $i, $user['nickname']);
                $this->excel->getActiveSheet()->setCellValue('C' . $i, $user['phone']);
                $this->excel->getActiveSheet()->setCellValue('D' . $i, $usercoupon['orderUUID']);
                $this->excel->getActiveSheet()->setCellValue('E' . $i, $storename);
                $this->excel->getActiveSheet()->setCellValue('F' . $i, $coupon['name']);
                $this->excel->getActiveSheet()->setCellValue('G' . $i, $coupon['price']);
                $this->excel->getActiveSheet()->setCellValue('H' . $i, $booking['create_time']);


            }

            



            $filename = '核销列表.xls'; //save our workbook as this file name



            header('Content-Type: application/vnd.ms-excel'); //mime type

            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name

            header('Cache-Control: max-age=0'); //no cache



             $log = array(

                'userid'=>$_SESSION['users']['user_id'],  

                "content" => $_SESSION['users']['username']."导出了商家核销信息",

                "create_time" => date('Y-m-d H:i:s'),

                "userip" => get_client_ip(),

            );

            $this->db->insert('hf_system_journal',$log);





            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

            $objWriter->save('php://output');

            }else{
                echo "<script>alert('暂无核销信息！');window.history.go(-1);</script>";
            }




        }else{
            echo "2";
        }
    }



    //招商信息
    function attract(){

       

        $config['per_page'] = 10;

        //获取页码

        $current_page=intval($this->uri->segment(4));//index.php 后数第4个/

        //var_dump($current_page);

            //配置

        $config['base_url'] = site_url('/module/LocalLife/Hi_Carpooling');

        //分页配置

        $config['full_tag_open'] = '<ul class="am-pagination tpl-pagination">';

        $config['full_tag_close'] = '</ul>';

        $config['first_tag_open'] = '<li>';

        $config['first_tag_close'] = '</li>';

        $config['prev_tag_open'] = '<li>';

        $config['prev_tag_close'] = '</li>';

        $config['next_tag_open'] = '<li>';

        $config['next_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="am-active"><a>';

        $config['cur_tag_close'] = '</a></li>';

        $config['last_tag_open'] = '<li>';

        $config['last_tag_close'] = '</li>';

        $config['num_tag_open'] = '<li>';

        $config['num_tag_close'] = '</li>';



        $config['first_link']= '首页';

        $config['next_link']= '下一页';

        $config['prev_link']= '上一页';

        $config['last_link']= '末页';



        

        switch ($_SESSION['city']) {
            case '0':
                $list = $this->Activity_model->select_attract('');
                $config['total_rows'] = count($list);
                // //分页数据
                $listpage = $this->Activity_model->select_attract_page($config['per_page'],$current_page);  
                break;
            case '1':
                 $list = $this->Activity_model->select_attract('1');
                $config['total_rows'] = count($list);
                // //分页数据
                $listpage = $this->Activity_model->select_attract_where_page('1',$config['per_page'],$current_page);  
                break;
            case '2':
                 $list = $this->Activity_model->select_attract('2');
                $config['total_rows'] = count($list);
                // //分页数据
                $listpage = $this->Activity_model->select_attract_where_page('2',$config['per_page'],$current_page);  
                break;
            case '3':
                 $list = $this->Activity_model->select_attract('3');
                $config['total_rows'] = count($list);
                // //分页数据
                $listpage = $this->Activity_model->select_attract_where_page('3',$config['per_page'],$current_page);  
                break;
            case '4':
                $list = $this->Activity_model->select_attract('4');
                $config['total_rows'] = count($list);
                // //分页数据
                $listpage = $this->Activity_model->select_attract_where_page('4',$config['per_page'],$current_page);  
                break;
            
        }

        
        $this->load->library('pagination');//加载ci pagination类

        $this->pagination->initialize($config);

        $data = array('lists'=>$listpage,'pages' => $this->pagination->create_links());

        $data['page'] = $this->view_attract;
        $data['menu'] = array('moll','attract');
        $this->load->view('template.html',$data);
    }

    //联系
    function edit_attract_state(){
        $id = intval($this->uri->segment('4'));
        if($id == '0'){
            $this->load->view('404.html');
        }else{
            $data['state'] = '1';
            if($this->Activity_model->updata_attract($id,$data)){
             echo "<script>alert('操作成功');window.history.go(-1);</script>";

            }else{
                echo "<script>alert('操作失败');window.history.go(-1);</script>";
            }
        }
    }


    //县志
    function annals(){
         switch ($_SESSION['city']) {
            case '0':
                $list = $this->Activity_model->select_annals('');
         
                break;
            case '1':
                 $list = $this->Activity_model->select_where_annals('1');
       
                break;
            case '2':
                 $list = $this->Activity_model->select_where_annals('2');
 
                break;
            case '3':
                 $list = $this->Activity_model->select_where_annals('3');
          
                break;
            case '4':
                $list = $this->Activity_model->select_where_annals('4');
          
                break;
            
        }
        $data['lists'] = $list;
        $data['page'] = $this->view_annals;
        $data['menu'] = array('moll','annals');
        $this->load->view('template.html',$data);
    }

    //编辑县志
    function edit_annals(){

        $id = intval($this->uri->segment('4'));
        if($id == '0'){
            $this->load->view('404.html');
        }else{
            $_SESSION['buket'] = "cqclocal";
            $_SESSION['host'] = "http://cqclocal.zlzmm.com/";
            $news = $this->Activity_model->select_annals_info($id);
            $data['annals'] = $news;
            $data['page'] = $this->view_editAnnals;
            $data['menu'] = array('moll','annals');
            $this->load->view('template.html',$data);
        }

    }
        
    function editAnnals(){
        if($_POST){
            $data = $this->input->post();

            $header = array("token:".$_SESSION['token'],'city:'.'1');    
            if(!empty($_FILES['img']['name'])){
                    $tmpfile = new CURLFile(realpath($_FILES['img']['tmp_name']));
                
                    $pics = array(
                        'pics' =>$tmpfile,
                        'porfix'=>'shop/annals',
                        'bucket'=>"cqclocal",
                    );
                
                    $qiuniu = json_decode(curl_post_express($header,QINIUUPLOAD,$pics),true);

                    if($qiuniu['errno'] == '0'){
                        $img = json_decode($qiuniu['data']['img'],true);
                        $icon[]['picImg'] =$img[0]['picImg'];
                        $data['pic'] = json_encode($icon);
                    }else{
                      echo "<script>alert('图片上传失败！');window.location.href='".site_url('/electronic/Electronic/edit_annals/'.$data['id'])."'</script>";exit;
                    }
            }

            if($this->Activity_model->edit_annals($data['id'],$data)){

                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."编辑了县志信息，县志id是：".$data['id'],
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                $this->db->insert('hf_system_journal',$log);
                echo "<script>alert('操作成功');window.location.href='".site_url('/electronic/Electronic/annals/')."'</script>";exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/electronic/Electronic/edit_annals/'.$data['id'])."'</script>";exit;
            }


        }else{
            $this->load->view('404.html');
        }
    }



    //导出
    function Dow_electronicAfterSales(){
        if($_POST){
            $store_id = $this->input->post('store_id');
            $couponid = $this->input->post('couponid');
            $time = $this->input->post('begin_time');
            $endtime = $this->input->post('end_time');


            $this->load->library('excel');

            $this->excel->setActiveSheetIndex(0);

            //name the worksheet

            $this->excel->getActiveSheet()->setTitle('Stores');

            $arr_title = array(

                'A' => '编号',

                'B' => '核销商家名称',

                'C' => '优惠卷名称',

                'D' => '优惠卷价格',
                'E' => '核销数量',
                'F' => '销售金额',


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


            if(!empty($store_id) && empty($couponid) && empty($time)){
                //所有卷
               $storename = $this->Activity_model->get_store_name($store_id);
               $coupon = $this->Activity_model->get_coupons();
               // var_dump($coupon);


                foreach ($coupon as $key => $value) {
                    $i++;
                    $num = count($this->Activity_model->select_where_may('hf_shop_couponverify','shop_coupon_id',$value['id'],'store_id',$store_id));
                 
                    $this->excel->getActiveSheet()->setCellValue('A' . $i, $value['id']);
                    $this->excel->getActiveSheet()->setCellValue('B' . $i, $storename);
                    $this->excel->getActiveSheet()->setCellValue('C' . $i, $value['title'].'-'.$value['name']);
                    $this->excel->getActiveSheet()->setCellValue('D' . $i, $value['price']);
                    $this->excel->getActiveSheet()->setCellValue('E' . $i, $num);
                    $this->excel->getActiveSheet()->setCellValue('F' . $i, $value['price']*$num);
                }

            }else if(empty($store_id) && !empty($couponid) && empty($time)){
                //获取所有商家
                $coupon = $this->Activity_model->get_electr_info($couponid);
                $store = $this->Shop_model->shop_list('1');

                foreach ($store as $key => $value) {
                    $i++;
                    $num = count($this->Activity_model->select_where_may('hf_shop_couponverify','shop_coupon_id',$couponid,'store_id',$value['business_id']));
                 
                    $this->excel->getActiveSheet()->setCellValue('A' . $i, $value['store_id']);
                    $this->excel->getActiveSheet()->setCellValue('B' . $i, $value['store_name']);
                    $this->excel->getActiveSheet()->setCellValue('C' . $i, $coupon['title'].'-'.$coupon['name']);
                    $this->excel->getActiveSheet()->setCellValue('D' . $i, $coupon['price']);
                    $this->excel->getActiveSheet()->setCellValue('E' . $i, $num);
                    $this->excel->getActiveSheet()->setCellValue('F' . $i, $coupon['price']*$num);
                }

            }else if(empty($store_id) && empty($couponid) && !empty($time)){
                 $this->load->view('404.html');

                // //获取所有商家    
                // set_time_limit(300);

                // $coupon =  $this->Activity_model->get_coupons();
                // $store = $this->Shop_model->shop_list('1');
                // $start_time = $time.' 00:00:00';
                // $end_time = $endtime.' 23:59:59';
                // foreach ($coupon as $key => $value) {
                   
                //     foreach ($store as $k => $v) {
                //        $i++;
                //         $num = count($this->Activity_model->select_where_three('hf_shop_couponverify','shop_coupon_id',$value['id'],'store_id',$v['business_id'],$start_time,$end_time));
                //         $this->excel->getActiveSheet()->setCellValue('A' . $i, $i-1);
                //         $this->excel->getActiveSheet()->setCellValue('B' . $i, $v['store_name']);
                //         $this->excel->getActiveSheet()->setCellValue('C' . $i, $value['title'].'-'.$value['name']);
                //         $this->excel->getActiveSheet()->setCellValue('D' . $i, $value['price']);
                //         $this->excel->getActiveSheet()->setCellValue('E' . $i, $num);
                //         $this->excel->getActiveSheet()->setCellValue('F' . $i, $value['price']*$num);
                //     }
                 
                // }
            }else if(!empty($store_id) && !empty($couponid) && empty($time)){
                //获取所有商家
                $coupon = $this->Activity_model->get_electr_info($couponid);
                $storename = $this->Activity_model->get_store_name($store_id);

                $i++;
                $num = count($this->Activity_model->select_where_may('hf_shop_couponverify','shop_coupon_id',$couponid,'store_id',$store_id));
             
                $this->excel->getActiveSheet()->setCellValue('A' . $i, $i-1);
                $this->excel->getActiveSheet()->setCellValue('B' . $i, $storename);
                $this->excel->getActiveSheet()->setCellValue('C' . $i, $coupon['title'].'-'.$coupon['name']);
                $this->excel->getActiveSheet()->setCellValue('D' . $i, $coupon['price']);
                $this->excel->getActiveSheet()->setCellValue('E' . $i, $num);
                $this->excel->getActiveSheet()->setCellValue('F' . $i, $coupon['price']*$num);
              
            }else if(!empty($store_id) && empty($couponid) && !empty($time)){
                //获取所有商家
                $storename = $this->Activity_model->get_store_name($store_id);
                $coupon = $this->Activity_model->get_coupons();
               // var_dump($coupon);
                $start_time = $time.' 00:00:00';
                $end_time = $endtime.' 23:59:59';

                foreach ($coupon as $key => $value) {
                    $i++;
                    $num = count($this->Activity_model->select_where_three('hf_shop_couponverify','shop_coupon_id',$value['id'],'store_id',$store_id,$start_time,$end_time));
                 
                    $this->excel->getActiveSheet()->setCellValue('A' . $i, $value['id']);
                    $this->excel->getActiveSheet()->setCellValue('B' . $i, $storename);
                    $this->excel->getActiveSheet()->setCellValue('C' . $i, $value['title'].'-'.$value['name']);
                    $this->excel->getActiveSheet()->setCellValue('D' . $i, $value['price']);
                    $this->excel->getActiveSheet()->setCellValue('E' . $i, $num);
                    $this->excel->getActiveSheet()->setCellValue('F' . $i, $value['price']*$num);
                }
              
            }else if(empty($store_id) && !empty($couponid) && !empty($time)){
                //获取所有商家
                $coupon = $this->Activity_model->get_electr_info($couponid);
                $store = $this->Shop_model->shop_list('1');
                $start_time = $time.' 00:00:00';
                $end_time = $endtime.' 23:59:59';

                foreach ($store as $key => $value) {
                    $i++;
                    $num = count($this->Activity_model->select_where_three('hf_shop_couponverify','shop_coupon_id',$couponid,'store_id',$value['business_id'],$start_time,$end_time));
                 
                    $this->excel->getActiveSheet()->setCellValue('A' . $i, $value['store_id']);
                    $this->excel->getActiveSheet()->setCellValue('B' . $i, $value['store_name']);
                    $this->excel->getActiveSheet()->setCellValue('C' . $i, $coupon['title'].'-'.$coupon['name']);
                    $this->excel->getActiveSheet()->setCellValue('D' . $i, $coupon['price']);
                    $this->excel->getActiveSheet()->setCellValue('E' . $i, $num);
                    $this->excel->getActiveSheet()->setCellValue('F' . $i, $coupon['price']*$num);
                }
            }else if(empty($store_id) && empty($couponid) && empty($time)){
                  echo "<script>alert('请选择你要筛选的条件');window.location.href='".site_url('/electronic/Electronic/electronicList/')."'</script>";exit;

            }

                // exit;

            $filename = '核销列表.xls'; //save our workbook as this file name



            header('Content-Type: application/vnd.ms-excel'); //mime type

            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name

            header('Cache-Control: max-age=0'); //no cache

            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

            $objWriter->save('php://output');
        }else{
            $this->load->view('404.html');
        }
    }


    //优惠卷领取信息
    function coupon_electronic(){
        //
        $id = intval($this->uri->segment('4'));
        if( $id == '0'){
            $this->load->view('404.html');
        }else{
            $data['id'] = $id;
            //获取领取数
            $data['lin'] = $this->Activity_model->receive_coupon($id);
            //获取已使用
            $data['receive'] =  $this->Activity_model->search_receive($id,'0');
            //获取卷信息
            $data['couponInfo'] = $this->Public_model->select_where_info('hf_shop_coupon','id',$id);


            $data['page']= $this->view_coupon_electronic;

            $data['menu'] = array('moll','electronicList');

            $this->load->view('template.html',$data);
        }        
    }

    //返回领取信息列表
    function receive_coupon(){
        if($_POST){
            $id = $this->input->post('id');
            $list = $this->Activity_model->receive_coupon($id);
            if(!empty($list)){
                echo json_encode($list);
            }else{
                echo "2";
            }


        }else{
            echo "2";
        }
    }

    //搜索优惠卷领取信息
    function search_receive(){
        if($_POST){
            $id = $this->input->post('id');
            $state = $this->input->post('state');

            $list = $this->Activity_model->search_receive($id,$state);
            if(!empty($list)){
                echo json_encode($list);
            }else{
                echo "2";
            }

        }else{
            echo "2";
        }
    }
    //修改领取信息状态
    function editCouponState(){
        $id = intval($this->uri->segment(4));
        $state = intval($this->uri->segment(5));
        if($id == '0' || $state == '0'){
            $this->load->view('404.html');
        }else{
            if($state == '3'){
                $data['user_coupon_state'] = '0';
            }else{
                $data['user_coupon_state'] = $state;

            }
            if($this->Activity_model->updataCoupon($id,$data)){
                echo "<script>alert('操作成功！');window.history.go(-1);</script>";exit;
            }else{
                echo "<script>alert('操作失败！');window.history.go(-1);</script>";exit;
            }
        }
    }


    //删除领取信息
    function del_receive(){
        if($_POST){
            $id = $this->input->post('id');
            if($this->Activity_model->del_receive($id)){
               $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."删除了一个优惠卷领取信息，编号是：".$id,

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


    //导出领取信息
    function dow_receive_coupom(){
        if($_POST){
            $id = $this->input->post('id');
            $state = $this->input->post('state');
            if(!empty($state)){
                $list = $this->Activity_model->search_receive($id,$state);
            }else{
                $list = $this->Activity_model->receive_coupon($id);
            }

        
            if(!empty($list)){
                    $this->load->library('excel');

                    $this->excel->setActiveSheetIndex(0);

                    //name the worksheet

                    $this->excel->getActiveSheet()->setTitle('coupon');

                    $arr_title = array(

                        'A' => '编号',

                        'B' => '领取用户',

                        'C' => '用户电话',

                        'D' => '领取时间',
                        'E' => '购买单号',
                        'F' => '支付金额',
                        'G' => '支付方式',

                        'H' => '使用状态'
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

                   // $bookings = $this->Shop_model->shop_list($id);


                    foreach ($list as $booking) {

                        $i++;
                       
                        $this->excel->getActiveSheet()->setCellValue('A' . $i, $booking['user_coupon_id']);
                        $this->excel->getActiveSheet()->setCellValue('B' . $i, $booking['nickname']);
                        $this->excel->getActiveSheet()->setCellValue('C' . $i, $booking['phone']);
                        $this->excel->getActiveSheet()->setCellValue('D' . $i, date('Y-m-d H:i:s',$booking['createTime']/1000));
                        $this->excel->getActiveSheet()->setCellValue('E' . $i, $booking['orderUUID']);
                          //获取支付方式
                        $query = $this->db->where("repay_UUID",$booking['orderUUID'])->get('hf_mall_order_repaydata');
                        $res = $query->row_array();
                        if(!empty($res)){
                            $this->excel->getActiveSheet()->setCellValue('F' . $i, $booking['price']);
                            $this->excel->getActiveSheet()->setCellValue('G' . $i, $res['payType']);
                        }else{
                            $this->excel->getActiveSheet()->setCellValue('F' . $i, '');
                            $this->excel->getActiveSheet()->setCellValue('G' . $i, '');

                        }
                        if($booking['user_coupon_state'] == '1'){
                            $this->excel->getActiveSheet()->setCellValue('H' . $i, '未使用');
                        }else{
                            $this->excel->getActiveSheet()->setCellValue('H' . $i, '已使用');
                        }
                    }

                    
                    //获取卷信息
                    $coupon = $this->Activity_model->get_electr_info($id);


                    $filename = $coupon['title'].'-'.$coupon['name'].'.xls'; //save our workbook as this file name



                    header('Content-Type: application/vnd.ms-excel'); //mime type

                    header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name

                    header('Cache-Control: max-age=0'); //no cache



                     $log = array(

                        'userid'=>$_SESSION['users']['user_id'],  

                        "content" => $_SESSION['users']['username']."导出了优惠卷领取信息",

                        "create_time" => date('Y-m-d H:i:s'),

                        "userip" => get_client_ip(),

                    );

                    $this->db->insert('hf_system_journal',$log);





                    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

                    $objWriter->save('php://output');
            }else{
                echo "<script>alert('暂无领取信息！');window.history.go(-1);</script>";
            }


        }else{
            $this->load->view('404.html');
        }
    }


    //导出所有卷的领取纪录
    function Dow_AllReceive(){
        if($_POST){
            $id = $this->input->post('couponid');
            $state = $this->input->post('state');
            $time = $this->input->post('starttime');
            $end_time = $this->input->post('endtime');  
            if(!empty($time)){
                $t = strtotime($time .' 00:00:00')*1000;
                $e = strtotime($end_time .' 23:59:59')*1000;
            }else{
                $t = '';
                $e = '';
            }

            $list = AllReceive($id,$state,$t,$e);

            if(!empty($list)){
                    $this->load->library('excel');

                    $this->excel->setActiveSheetIndex(0);

                    //name the worksheet
                    $this->excel->getActiveSheet()->setTitle('coupon');

                    $arr_title = array(

                        'A' => '编号',

                        'B' => '领取用户',

                        'C' => '用户电话',

                        'D' => '领取时间',
                        'E' => '购买单号',
                        'F' => '支付金额',
                        'G' => '支付方式',

                        'H' => '使用状态',
                        'I' => '优惠卷名称',
                        'J' => '优惠劵编号'
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
                    foreach ($list as $booking) {
                        //  echo "<pre>";
                        // var_dump($list);
                        // exit;
                        $i++;
                        $this->excel->getActiveSheet()->setCellValue('A' . $i, $booking['user_coupon_id']);
                        $this->excel->getActiveSheet()->setCellValue('B' . $i, $booking['nickname']);
                        $this->excel->getActiveSheet()->setCellValue('C' . $i, $booking['phone']);
                        $this->excel->getActiveSheet()->setCellValue('D' . $i, $booking['standardTime']);
                        $this->excel->getActiveSheet()->setCellValue('E' . $i, $booking['orderUUID']);
                        //获取支付方式
                        $query = $this->db->where("repay_UUID",$booking['orderUUID'])->get('hf_mall_order_repaydata');
                        $res = $query->row_array();
                        if(!empty($res)){
                            $this->excel->getActiveSheet()->setCellValue('F' . $i, $booking['price']);
                            $this->excel->getActiveSheet()->setCellValue('G' . $i, $res['payType']);
                        }else{
                            $this->excel->getActiveSheet()->setCellValue('F' . $i, '');
                            $this->excel->getActiveSheet()->setCellValue('G' . $i, '');

                        }
                        

                        if($booking['user_coupon_state'] == '1'){
                            $this->excel->getActiveSheet()->setCellValue('H' . $i, '未使用');
                        }else{
                            $this->excel->getActiveSheet()->setCellValue('H' . $i, '已使用');
                        }
                        $this->excel->getActiveSheet()->setCellValue('I' . $i, $booking['name'].'-'.$booking['title']);
                        $this->excel->getActiveSheet()->setCellValue('J' . $i, $booking['id']);

                    }

                    $filename = 'ReceiveRecords.xls'; //save our workbook as this file name

                    header('Content-Type: application/vnd.ms-excel'); //mime type

                    header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
                    header('Cache-Control: max-age=0'); //no cache

                     $log = array(

                        'userid'=>$_SESSION['users']['user_id'],  

                        "content" => $_SESSION['users']['username']."导出了优惠卷领取信息",

                        "create_time" => date('Y-m-d H:i:s'),

                        "userip" => get_client_ip(),

                    );

                    $this->db->insert('hf_system_journal',$log);

                    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

                    $objWriter->save('php://output');
            }else{
                echo "<script>alert('暂无核销信息！');window.history.go(-1);</script>";
            }


        }else{
            $this->load->view('404.html');
        }
    }

    //领取总纪录
    function couponRecord(){
        //获取所有优惠劵
        $data['coupon'] = $this->Activity_model->get_coupons();
        // var_dump($coupon);

        $data['page']= 'electronic/couponRecord.html';

        $data['menu'] = array('moll','electronicList');

        $this->load->view('template.html',$data);      
    }

    //返回优惠劵领取总纪录
    function retCouponRecord(){
        if($_POST){
            $start = $this->input->post('start');
            if($start != '0'){
                $_SESSION['couRec'] = $start;
            }
            $size = $this->input->post('count');
            $uuid = $this->input->post('uuid');

            if(!empty($uuid)){
                $this->db->select('a.*,b.title,b.name,b.id,c.nickname,d.payType');
                $this->db->from('hf_shop_coupon as b');
                $this->db->join('hf_user_coupon as a','a.store_coupon_id = b.id','left');
                $this->db->join('hf_user_member as c','a.userid = c.user_id','left');
                $this->db->join('hf_mall_order_repaydata as d','a.orderUUID = d.repay_UUID','left');

                $query = $this->db->like('a.orderUUID',$uuid,'both')->order_by('a.user_coupon_id','desc')->get();
                $listpage = $query->result_array();
                $list = $listpage;
            }else{
                $sql = "select user_coupon_id from hf_user_coupon";
                $query = $this->db->query($sql);
                $list = $query->result_array();
                $listpage = $this->Activity_model->selCouponReceive($size,$start);
            }
          

            if(!empty($listpage)){
                echo json_encode(['total'=>count($list),'subjects'=>$listpage]);
            }else{
                echo "2";
            }

        }
    }

    //导出优惠劵信息
    function dowElectronic(){
        if($_POST){
            $coupon = $this->input->post('couponid');
            $state = $this->input->post('state');
            $time = $this->input->post('begin_time');
            $endtime = $this->input->post('end_time');

            if(!empty($time)){
                $t = $time.' 00:00:00';
                $e = $endtime.' 23:59:59';
            }else{
                $t = '';
                $e = '';
            }

            if(!empty($coupon) && empty($state)){
                //获取卡卷信息
                $query = $this->db->where('id',$coupon)->get('hf_shop_coupon');
                $res = $query->result_array();
            }else if(empty($coupon) && !empty($state)){
                if($state == '2'){
                    $state = '0';
                }
                $query = $this->db->where('state',$state)->order_by('id','desc')->get('hf_shop_coupon');
                $res = $query->result_array();
            }else if(!empty($coupon) && !empty($state)){
                if($state == '2'){
                    $state = '0';
                }
                $query = $this->db->where('state',$state)->where('id',$coupon)->get('hf_shop_coupon');
                $res = $query->result_array();
            }else if(empty($coupon) && empty($state)){

                $query = $this->db->order_by('id','desc')->get('hf_shop_coupon');
                $res = $query->result_array();
            }

            if(!empty($res)){
                    $this->load->library('excel');

                    $this->excel->setActiveSheetIndex(0);

                    //name the worksheet
                    $this->excel->getActiveSheet()->setTitle('coupon');

                    $arr_title = array(

                        'A' => '编号',
                        'B' => '所属城市',
                        'C' => '名称',
                        'D' => '标题',
                        'E' => '所属商家',
                        'F' => '类型',
                        'G' => '使用类型',
                        'H' => '使用期限',
                        'I' => '次数限制',
                        'J' => '购买价格',
                        'K' => '优惠券面额',
                        'L' => '领取数',
                        'M' => '核销数',
                        'N' => '使用数',
                        'O' => '未使用数',
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
                    foreach ($res as $booking) {
                        $i++;
                        $this->excel->getActiveSheet()->setCellValue('A' . $i, $booking['id']);
                        // 所属城市 1重庆 2南江 3宣汉
                        switch ($booking['city']) {
                            case '1':
                               $this->excel->getActiveSheet()->setCellValue('B' . $i, '重庆');
                                break; 
                            case '2':
                               $this->excel->getActiveSheet()->setCellValue('B' . $i, '南江');
                                break; 
                            case '3':
                               $this->excel->getActiveSheet()->setCellValue('B' . $i, '宣汉');
                                break;
                            case '4':
                               $this->excel->getActiveSheet()->setCellValue('B' . $i, '邻水');
                                break;
                            default:
                               $this->excel->getActiveSheet()->setCellValue('B' . $i, '');
                                break;
                        }
                        $this->excel->getActiveSheet()->setCellValue('C' . $i, $booking['name']);
                        $this->excel->getActiveSheet()->setCellValue('D' . $i, $booking['title']);
                        //
                        $storeid = json_decode($booking['storeid'],true);
                        if($storeid[0] == '0'){
                            $this->excel->getActiveSheet()->setCellValue('E' . $i, '所有商家');
                        }else{
        
                            if(count($storeid) > '1'){
                                foreach ($storeid as $key => $v) {
                                    // var_dump($v);echo '<br>';
                                    $storename[$key] = get_store_name($v);
                                }
                                $name = implode(',',$storename);

                            }else{
                                $name = get_store_name($storeid[0]);
                            }
                          
                            $this->excel->getActiveSheet()->setCellValue('E' . $i, $name);
                        }
                       
                        //类型
                        switch ($booking['typeid']) {
                            case '1':
                                $this->excel->getActiveSheet()->setCellValue('F' . $i, '电商抵用券');
                                break; 
                            case '2':
                                $this->excel->getActiveSheet()->setCellValue('F' . $i, '电商折扣券');
                                break; 
                            case '3':
                                $this->excel->getActiveSheet()->setCellValue('F' . $i, '电商满减卷');
                                break; 
                            case '5':
                                $this->excel->getActiveSheet()->setCellValue('F' . $i, '线下团购劵');
                                break;
                            
                        }
                        //使用类型 使用类型 1爱购商品 2HI货榜 3HI土货 4HI洋货 5HI特色 6HI推荐 7HI邀请有礼
                        switch ($booking['applicableType']) {
                            case '1':
                               $this->excel->getActiveSheet()->setCellValue('G' . $i, '爱购商品');
                                break;
                            case '2':
                               $this->excel->getActiveSheet()->setCellValue('G' . $i, 'HI货榜');
                                break;
                            case '3':
                               $this->excel->getActiveSheet()->setCellValue('G' . $i, 'HI土货');
                                break;
                            case '4':
                               $this->excel->getActiveSheet()->setCellValue('G' . $i, 'HI洋货');
                                break;
                            case '5':
                               $this->excel->getActiveSheet()->setCellValue('G' . $i, 'HI特色');
                                break;  
                            case '6':
                               $this->excel->getActiveSheet()->setCellValue('G' . $i, 'HI推荐');
                                break;  
                            case '7':
                               $this->excel->getActiveSheet()->setCellValue('G' . $i, 'HI邀请有礼');
                                break;
                            
                            default:
                               $this->excel->getActiveSheet()->setCellValue('G' . $i, '通用');
                                break;
                        }
                        $this->excel->getActiveSheet()->setCellValue('H' . $i, $booking['begin_date'].'至'.$booking['end_date']);
                        // 领取限制。1只能领取1次。0无限制
                        if($booking['receiveNum'] == '0'){
                            $this->excel->getActiveSheet()->setCellValue('I' . $i, '不限制');
                        }else{
                            $this->excel->getActiveSheet()->setCellValue('I' . $i, $booking['receiveNum'].'天一次');
                        }
                        $this->excel->getActiveSheet()->setCellValue('J' . $i, $booking['price']);
                        $this->excel->getActiveSheet()->setCellValue('K' . $i, $booking['denomination']);

                        //时间返回
                        if(!empty($t)){
                               //领取
                            $ling = count($this->Activity_model->receiveDatecoupon($booking['id'],$t,$e));
                            $this->excel->getActiveSheet()->setCellValue('L' . $i, $ling);

                            //获取已使用
                            $receive =  count($this->Activity_model->receiveDate($booking['id'],'0',$t,$e));
                            $this->excel->getActiveSheet()->setCellValue('N' . $i, $receive);
                            //核销
                            $he = count($this->Activity_model->get_search_after($booking['id'],$t,$e));
                            $this->excel->getActiveSheet()->setCellValue('M' . $i, $he);

                        }else{
                            //领取
                            $ling = count($this->Activity_model->receive_coupon($booking['id']));
                            $this->excel->getActiveSheet()->setCellValue('L' . $i, $ling);

                            //获取已使用
                            $receive =  count($this->Activity_model->search_receive($booking['id'],'0'));
                            $this->excel->getActiveSheet()->setCellValue('N' . $i, $receive);
                            //核销
                            $he = count($this->Activity_model->ret_after_list($booking['id']));
                            $this->excel->getActiveSheet()->setCellValue('M' . $i, $he);
                        }
                       
                        // 为使用
                        $this->excel->getActiveSheet()->setCellValue('O' . $i, $ling-$receive);
                    }
                    // exit;

                    $filename = '优惠劵报表.xls'; //save our workbook as this file name

                    header('Content-Type: application/vnd.ms-excel'); //mime type

                    header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
                    header('Cache-Control: max-age=0'); //no cache

                     $log = array(

                        'userid'=>$_SESSION['users']['user_id'],  

                        "content" => $_SESSION['users']['username']."导出了优惠劵报表",

                        "create_time" => date('Y-m-d H:i:s'),

                        "userip" => get_client_ip(),

                    );

                    $this->db->insert('hf_system_journal',$log);

                    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

                    $objWriter->save('php://output');
            }else{
                echo "<script>alert('没有适合条件的优惠劵！');window.history.go(-1);</script>";

            }

          
        }
    }





}



