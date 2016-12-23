<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  商城管理
 *
 * */
require_once(APPPATH.'controllers/default_Controller.php');
class shop extends default_Controller {
    //商家首页
    public $view_shopIndex = "shop/shopList.html";
    //新增商家
    public $view_addShop = "shop/addShop.html";
    //编辑商家
    public $view_EditShop = "shop/editShop.html";
    //ceshio
    public $view_ceshi = "banner/ceshi.html";

    function __construct()
    {
        parent::__construct();
        $plateid = $this->user_model->group_permiss($this->session->users['gid']);
        $plateid = json_decode($plateid,true);
        if(!empty($plateid)){
            if(!in_array('0',$plateid) && !in_array('3',$plateid)){
                echo "<script>alert('您没有权限访问！');window.location.href='".site_url('/admin/index')."';</script>";exit;
            }
        }else{
             echo "<script>alert('您没有权限访问！');window.location.href='".site_url('/admin/index')."';</script>";exit;
        }
        //model
        $this->load->model('shop_model');
    }

    //商家 列表主页
    function index()
    {  
        //获取一级业态
         $data['yetai'] = $this->shop_model->store_type_level();
         $data['page'] = $this->view_shopIndex;
         $data['menu'] = array('store','shopList');
    	 $this->load->view('template.html',$data);
    }
    //返回列表信息
    function return_shop_page(){
         if($_POST){
            $list = $this->shop_model->shop_list();
            if(empty($list)){
                echo "2";
            }else{
                echo json_encode($list);
            }
         }else{
             echo "2";
         }
    }
    //搜索商家列表
    function search_store(){
        if($_POST){
            $yetai = $_POST['yetai'];
            $state = $_POST['state'];
            $floor = $_POST['floor'];
            $berth = $_POST['berth'];
            $sear = $_POST['sear'];

            $list = search_store_list($yetai,$state,$floor,$berth,$sear);
            var_dump($list);

        }else{
            echo "2";
        }
    }

    //商家状态修改
    function edit_shop_state(){
        if($_POST){
            $id = $_POST['id'];
            $action = $_POST['state'];
            switch ($action) {
                case '1':
                    $data['state'] = '1';
                    if($this->shop_model->edit_shop_state($id,$data)){
                        echo "1";
                    }else{
                        echo "2";
                    }
                    break;
                case '2':
                    $data['state'] = '0';
                    if($this->shop_model->edit_shop_state($id,$data)){
                        echo "1";
                    }else{
                        echo "2";
                    }
                    break;
                default:
                        echo "2";
                        break;
            }
        }else{
            echo "2";
        }
    }
    //删除商家
    function del_shop_store(){
        if($_POST){
            $id = $_POST['id'];
            if($this->shop_model->del_shop_store($id)){
                echo "1";
            }else{
                echo "2";
            }
        }else{
            echo "2";
        }
    }

    //商家管理
    function shop_admin(){

    	 $this->load->view('shop/shopInfo.html');
    }
    //新增商家
    function addShop(){
        //获取所有业态
        $data['yetai'] = $this->shop_model->store_type_level(); 

        $data['page'] = $this->view_addShop;
        $data['menu'] = array('store','shopList');
        $this->load->view('template.html',$data);
       
    }
    //新增商家操作
    function add_shop_store(){
        if($_POST){
            $data = $this->input->post();
            $arr['username'] = trim($this->input->post('username'));
            $arr['gid'] = '2';
            $arr['password'] = md5(trim($this->input->post('password')));
            if(!empty($this->shop_model->get_user_info($arr['username']))){
                echo "<script>alert('账户已被注册！');window.location.href='".site_url('/shop/shop/addShop')."'</script>";exit;
            }
            //新增商家用户账号
           $userid = $this->shop_model->add_store_member($arr);
           if(!empty($userid)){
                $data['business_id'] = $userid;
                $data['send_userid'] = $this->session->users['user_id'];
                $data['create_time'] = date('Y-m-d');
                unset($data['password'],$data['username']);
                if($this->shop_model->add_store_info($data)){
                     echo "<script>alert('操作成功！');window.location.href='".site_url('/shop/shop/index')."'</script>";exit;
                }else{
                    echo "<script>alert('操作失败！');window.location.href='".site_url('/shop/shop/addShop')."'</script>";exit;
                }
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/shop/shop/addShop')."'</script>";exit;
            }
        }else{
            $this->load->view('404.html');
        }
    }
    //编辑商家信息
    function editShop(){
        $id = intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
            //获取一级业态
            $data['yetai'] = $this->shop_model->store_type_level();
            //获取商家信息
            $store = $this->shop_model->get_store_Info($id);
            //获取账户
            $data['user'] = $this->shop_model->get_login_store($store['business_id']);
            $data['store'] = $store;
            $data['page'] = $this->view_EditShop;
            $data['menu'] = array('store','shopList');
            $this->load->view('template.html',$data);
        }
    }
    //编辑商家操作
    function edit_shop_store(){
        if($_POST){
            $data = $this->input->post();
            $arr['username'] = trim($this->input->post('username'));
            $arr['password'] =trim($this->input->post('password'));
            if(strlen($arr['password']) != 32){
                $arr['password'] = md5($arr['password']);
            }
            $arr['user_id'] = $this->input->post('user_id');
            unset($data['username'],$data['password'],$data['user_id']);
            if($this->shop_model->get_member_info($arr['user_id'],$arr['username'])){
                 echo "<script>alert('账户已被注册！');window.location.href='".site_url('/shop/shop/addShop')."'</script>";exit;
            }
            //修改登录账户
            if($this->shop_model->edit_store_member($arr['user_id'],$arr)){
                if($this->shop_model->edit_store_info($data['store_id'],$data)){
                     echo "<script>alert('操作成功！');window.location.href='".site_url('/shop/shop/index')."'</script>";exit;
                }else{
                    echo "<script>alert('操作失败！');window.location.href='".site_url('/shop/shop/editShop/').$data['store_id']."'</script>";exit;
                }
            }

        }else{
            $this->load->view('404.html');
        }
    }
    //返回二级业态
    function return_store_type(){
        if($_POST){
            $gid = $_POST['gid'];
            //根据gid返回
            $type = $this->shop_model->store_type_tow($gid);
            if(empty($type)){
                echo "2";
            }else{
                echo json_encode($type);
            }
        }else{
            echo "2";
        }
    }

    //导入商家信息
    function impolt_store(){
          $name = date('Y-m-d');
          $inputFileName = "./upload/xls/" .$name .'.xls';
          move_uploaded_file($_FILES["file"]["tmp_name"],$inputFileName);

             //引入类库
          $this->load->library('excel');
            if(!file_exists($inputFileName)){
                    echo "<script>alert('文件导入失败!');window.location.href='".site_url('/shop/shop/index')."'</script>";
                    exit;
            }
            //导入excel文件类型 excel2007 or excel5
            $PHPReader = new PHPExcel_Reader_Excel2007();
            if(!$PHPReader->canRead($inputFileName)){
              $PHPReader = new PHPExcel_Reader_Excel5();
              if(!$PHPReader->canRead($inputFileName)){
                echo 'no Excel';
                return;
              }
            }
              
              $PHPExcel = $PHPReader->load($inputFileName);
              $currentSheet = $PHPExcel->getSheet(0);  //读取excel文件中的第一个工作表
              $allColumn = $currentSheet->getHighestColumn(); //取得最大的列号
              $allRow = $currentSheet->getHighestRow(); //取得一共有多少行
              $erp_orders_id = array();  //声明数组
              for($currentRow = 2;$currentRow <= $allRow;$currentRow++){
               
                $data['barnd_name'] = $PHPExcel->getActiveSheet()->getCell("A".$currentRow)->getValue();//获取c列的值
                $data['store_name'] = $PHPExcel->getActiveSheet()->getCell("B".$currentRow)->getValue();//获取d列的值
                $data['en_name'] = $PHPExcel->getActiveSheet()->getCell("C".$currentRow)->getValue();//获取d列的值
                $data['open_busin'] = $PHPExcel->getActiveSheet()->getCell("D".$currentRow)->getValue();//获取d列的值
                $data['store_type'] = $PHPExcel->getActiveSheet()->getCell("E".$currentRow)->getValue();//获取d列的值
                $data['op_status'] = $PHPExcel->getActiveSheet()->getCell("F".$currentRow)->getValue();//获取d列的值
                $data['floor_name'] = $PHPExcel->getActiveSheet()->getCell("G".$currentRow)->getValue();//获取d列的值
                $data['door_no'] = $PHPExcel->getActiveSheet()->getCell("H".$currentRow)->getValue();//获取d列的值
                $data['business_hours'] = $PHPExcel->getActiveSheet()->getCell("I".$currentRow)->getValue();//获取d列的值
                $data['area'] = trim($PHPExcel->getActiveSheet()->getCell("J".$currentRow)->getValue());//获取d列的值
                $type_name = $PHPExcel->getActiveSheet()->getCell("K".$currentRow)->getValue();//获取d列的值
                $type_tow_name = $PHPExcel->getActiveSheet()->getCell("L".$currentRow)->getValue();//获取d列的值 
                $data['phone'] = trim($PHPExcel->getActiveSheet()->getCell("M".$currentRow)->getValue());//获取d列的值
                $data['create_time'] = date('Y-m-d');
                $data['send_userid'] = $this->session->users['user_id'];
                if($data['barnd_name'] == NULL){
                     //删除临时文件
                     unlink($inputFileName);
                    exit;
                }
                
                //判断一级业态是否存在
                $commercial_type_name = $this->shop_model->get_store_type_id(trim($type_name),'0');
                if($commercial_type_name == NULL){
                    $type = array('type_name'=>$type_name);
                    $commercial_type_name = $this->shop_model->add_store_type($type);
                }
                //判断二级业态是否存在
                $subcommercial_type_name = $this->shop_model->get_store_type_id(trim($type_tow_name),$commercial_type_name);
                if($subcommercial_type_name == NULL){
                    $comm = array('type_name'=>$type_tow_name,'gid'=>$commercial_type_name);
                    $subcommercial_type_name = $this->shop_model->add_store_type($comm);
                }
                //新增商家用户账号
                $arr['username'] = trim($data['phone']).trim($data['floor_name']);
                $arr['password'] = md5('123456');
                $arr['gid'] = '2';
                //获取用户id
                if(empty($this->shop_model->get_user_info($arr['username']))){
                    $userid = $this->shop_model->add_store_member($arr);
                     //插入数据库
                    $data['business_id'] = $userid;
                    $data['subcommercial_type_name'] = $subcommercial_type_name;
                    $data['commercial_type_name'] = $commercial_type_name;
                    $import =  $this->db->insert('hf_shop_store',$data); 
                }

             }
    }

    //导出商家
    function dowload_store(){
        $id = intval($this->uri->segment(4));
        if($id == 1){
        $this->load->library('excel');
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Stores');
        $arr_title = array(
            'A' => '品牌名称',
            'B' => '商家名称',
            'C' => '英文名称',
            'D' => '开业时间',
            'E' => '商家类型',
            'F' => '营业状态',
            'G' => '所在楼层',
            'H' => '店铺编号',
            'I' => '营业时间',
            'J' => '面积',
            'K' => '商家一级业态',
            'L' => '商家二级业态',
            'M' => '联系电话',
            'N' => '创建时间'
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
        $bookings = $this->shop_model->shop_list();
        if(count($bookings) > 0)
        {
            foreach ($bookings as $booking) {
                $i++;
                $type_name_one = $this->shop_model->get_store_type_name($booking['commercial_type_name']);
                $type_name_tow = $this->shop_model->get_store_type_name($booking['subcommercial_type_name']);
             //   $this->excel->getActiveSheet()->setCellValue('A' . $i,  $i - 1);
                $this->excel->getActiveSheet()->setCellValue('A' . $i, $booking['barnd_name']);
                $this->excel->getActiveSheet()->setCellValue('B' . $i, $booking['store_name']);
                $this->excel->getActiveSheet()->setCellValue('C' . $i, $booking['en_name']);
                $this->excel->getActiveSheet()->setCellValue('D' . $i, $booking['open_busin']);
                $this->excel->getActiveSheet()->setCellValue('E' . $i, $booking['store_type']);
                $this->excel->getActiveSheet()->setCellValue('F' . $i, $booking['op_status']);
                $this->excel->getActiveSheet()->setCellValue('G' . $i, $booking['floor_name']);
                $this->excel->getActiveSheet()->setCellValue('H' . $i, $booking['door_no']);
                $this->excel->getActiveSheet()->setCellValue('I' . $i, $booking['business_hours']);
                $this->excel->getActiveSheet()->setCellValue('J' . $i, $booking['area']);
                $this->excel->getActiveSheet()->setCellValue('K' . $i, $type_name_one);
                $this->excel->getActiveSheet()->setCellValue('L' . $i, $type_name_tow);
                $this->excel->getActiveSheet()->setCellValue('M' . $i, $booking['phone']); 
                $this->excel->getActiveSheet()->setCellValue('N' . $i, $booking['create_time']);
            }
        }

        $filename = '商户列表.xls'; //save our workbook as this file name

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

