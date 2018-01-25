<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    function __construct()
    {
        parent::__construct();
    }



    /**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	function asd(){

        $this->load->view('welcome_message.html');
    }

    
    function inset_app(){
    	if($_POST){
    		$type = $this->input->post('id');
    		$query = $this->db->get('hf_system_version');
    		$res = $query->row_array();
    		//var_dump($res);
    		if($type == 1){
	    		$arr['dowAndroid']= $res['dowAndroid'] + 1;
	    	}else{
	    		$arr['dowIso']= $res['dowIso'] + 1;
	    	}
    		$this->db->where('id',$res['id'])->update('hf_system_version',$arr);
    		echo "1";
    	}else{
    		echo "2";
    	}
    }

    //
    function coupon(){
        $query = $this->db->where('shop_coupon_id','165')->get('hf_shop_couponverify');
        $res = $query->result_array();
        $a =array();
        foreach ($res as $key => $value) {
            $query1 = $this->db->where('user_coupon_id',$value['user_coupon_id'])->get('hf_user_coupon');
            $res1 = $query1->row_array();
            if(!empty($res1)){
                var_dump($value['user_coupon_id']);

                $a[$key] = $res;
            }
            
        }
        echo "<pre>";
        var_dump($a);
    }




    function member(){
        $time = '2017-12-28 00:00:00';
        $end = '2018-01-01 23:59:59';
        $query = $this->db->where('create_time >=',$time)->where('create_time <=',$end)->where('gid','5')->get('hf_user_member');
        // $query = $this->db->query();
        $res = $query->result_array();
        $a ='0';
        foreach ($res as $key => $value) {
            // $query1 = $this->db->where('newsId',$value['id'])->get('hf_friends_news_commont');
            // // $query = $this->db->query();
            // $res1 = $query1->result_array();
            $a += $value['intergral'];
            // var_dump($a);
        }
        // echo "<pre>";
        var_dump($a);
        var_dump(count($res));
    }

    //问答数
    function question(){
        $time = '2017-11-27 00:00:00';
        $end = '2017-12-03 23:59:59';
        $query = $this->db->where('create_time >=',$time)->where('create_time <=',$end)->where('typeId','2')->get('hf_friends_news');
        // $query = $this->db->query();
        $res = $query->result_array();
        $a ='0';
        foreach ($res as $key => $value) {
            $query1 = $this->db->where('newsId',$value['id'])->get('hf_friends_news_commont');
            // // $query = $this->db->query();
            $res1 = $query1->result_array();
            $a += count($res1);
            // var_dump($a);
        }
        // echo "<pre>";
        var_dump($a);
        var_dump(count($res));
    }

    //发帖数1交友动态 2问答动态  3圈子动态 4二手信息 5举报动态
    function findest(){
        $time = '2017-11-27 00:00:00';
        $end = '2017-12-03 23:59:59';
        $query = $this->db->where('create_time >=',$time)->where('create_time <=',$end)->where('typeId','1')->get('hf_friends_news');
        // $query = $this->db->query();
        $res = $query->result_array();
        $a ='0';
        foreach ($res as $key => $value) {
            $query1 = $this->db->where('newsId',$value['id'])->get('hf_friends_news_commont');
            // // $query = $this->db->query();
            $res1 = $query1->result_array();
            $a += count($res1);
            // var_dump($a);
        }
        // echo "<pre>";
        var_dump($a);
        var_dump(count($res));
    }



    function order(){
        $sql = "select* from hf_mall_order where order_type='0' and order_status !='1' and `PriceCalculation` like '%\"coupon_amount\":\"199,100\"%' order by order_id desc";
        $query = $this->db->query($sql);
         $res = $query->result_array();
         $a = array();
         foreach ($res as $key => $value) {
             $pay = json_decode($value['PriceCalculation'],true);
             $couponid = $pay['coupon'];
            
            $sql1 = "select * from hf_user_coupon where user_coupon_id = $couponid and user_coupon_state = 1";
            $query1 = $this->db->query($sql1);
            $res1 = $query1->row_array();
            // var_dump($res1);
            if(!empty($res1)){
                $a[] = $res1['user_coupon_id'];

            }

         }
         echo "<pre>";
         var_dump(count($a));
         var_dump(array_unique($a));
    }

    function aabcd(){
        $mobile = "15828277232";  //要查询的电话号码
        $content = $this->get_mobile_area($mobile);
        print_r($content['carrier']);
    }


    function get_mobile_area($mobile)
    {
        $sms = array('province' => '', 'supplier' => '');    //初始化变量
    //根据淘宝的数据库调用返回值
        $url = "http://tcc.taobao.com/cc/json/mobile_tel_segment.htm?tel=" . $mobile . "&t=" . time();

        $res = file_get_contents($url);
        $res = trim(explode('=', $res)[1]);
        $res = iconv('gbk', 'utf-8', $res);
        $res = str_replace("'", '"', $res);
        $res = preg_replace('/(\w+):/is', '"$1":', $res);
    
        return json_decode($res,true);
    }
    function DowUserMember(){
            set_time_limit(0);
            $time = '2017-12-29 00:00:00';
            $end = '2017-12-31 23:59:59';
            $query = $this->db->where('create_time >=',$time)->where('create_time <=',$end)->where('gid','5')->order_by('create_time','desc')->get('hf_user_member');
            // $query = $this->db->query();
            $res1 = $query->result_array();
            // $res1 = $query1->result_array();

            
            if(!empty($res1)){
                $this->load->library('excel');

                //activate worksheet number 1

                $this->excel->setActiveSheetIndex(0);

                //name the worksheet

                $this->excel->getActiveSheet()->setTitle('Stores');

                $arr_title = array(

                    'A' => '用户编号',
                    'B' => '用户手机号',
                    'C' => '用户昵称',
                    'D' => '注册时间',
                    // 'E' => '城市',
                    
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


                foreach ($res1 as $booking) {
                    $i++;
                   
                    $this->excel->getActiveSheet()->setCellValue('A' . $i, $booking['user_id']);
                    $this->excel->getActiveSheet()->setCellValue('B' . $i, $booking['phone']);
                    $this->excel->getActiveSheet()->setCellValue('C' . $i, $booking['nickname']);
                    // switch ($booking['city']) {
                    //     case '1':
                    //          $this->excel->getActiveSheet()->setCellValue('D' . $i, '重庆');

                    //         break;    
                    //     case '2':
                    //         $this->excel->getActiveSheet()->setCellValue('D' . $i, '南江');

                    //         break;    
                    //     case '3':
                    //          $this->excel->getActiveSheet()->setCellValue('D' . $i, '宣汉');

                    //         break; 
                    //     case '4':
                    //          $this->excel->getActiveSheet()->setCellValue('D' . $i, '邻水');

                    //         break;
                        
                    //     default:
                    //         $this->excel->getActiveSheet()->setCellValue('D' . $i, '');
                    //         break;
                    // }
                    $this->excel->getActiveSheet()->setCellValue('D' . $i, $booking['create_time']);
                  
                }

                



                $filename = '注册用户.xls'; //save our workbook as this file name



                header('Content-Type: application/vnd.ms-excel'); //mime type

                header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name

                header('Cache-Control: max-age=0'); //no cache



                $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

                $objWriter->save('php://output');


            }
    }

    function impolt_initavtion(){

          $name = date('Y-m-d');

          $inputFileName = "Upload/xls/" .$name .'.xls';

          move_uploaded_file($_FILES["file"]["tmp_name"],$inputFileName);

           //引入类库

            $this->load->library('excel');

            if(!file_exists($inputFileName)){

                    echo "<script>alert('文件导入失败!');window.location.href='".site_url('/shop/Shop/index')."'</script>";

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

              for($currentRow = 3;$currentRow <= $allRow;$currentRow++){
                    $data['address'] = $PHPExcel->getActiveSheet()->getCell("B".$currentRow)->getValue();//获取c列的值
                    $data['name'] = $PHPExcel->getActiveSheet()->getCell("C".$currentRow)->getValue();//获取c列的值
                    $data['code'] = $PHPExcel->getActiveSheet()->getCell("D".$currentRow)->getValue();//获取c列的值
                    $data['phone'] = $PHPExcel->getActiveSheet()->getCell("D".$currentRow)->getValue();//获取c列的值
                    $import =  $this->db->insert('hf_system_invitation',$data); 
             }
    }

}
