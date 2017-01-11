<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('MallShop_model');
        date_default_timezone_set("Asia/Shanghai");
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

    //商家导入商品
    function impolt_goods(){
        if(!empty($_FILES["file"]["tmp_name"])){
            $name = date('Y-m-d');
            $inputFileName = "Upload/c/" .$name .'.xls';
            move_uploaded_file($_FILES["file"]["tmp_name"],$inputFileName);
             $this->load->library('excel');
            if(!file_exists($inputFileName)){
                    echo "<script>alert('文件导入失败!');window.location.href='".site_url('module/localLife/serviceList/8')."'</script>";
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
           $i = 0;   
           foreach ($PHPExcel->getActiveSheet()->getDrawingCollection() as $drawing) {
                if ($drawing instanceof PHPExcel_Worksheet_MemoryDrawing) {
                    ob_start();
                    call_user_func(
                        $drawing->getRenderingFunction(),
                        $drawing->getImageResource()
                    );
                    $imageContents = ob_get_contents();
                    ob_end_clean();
                    switch ($drawing->getMimeType()) {
                        case PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_PNG :
                                $extension = 'png'; break;
                        case PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_GIF:
                                $extension = 'gif'; break;
                        case PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_JPEG :
                                $extension = 'jpg'; break; 
                        case PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_JPEG :
                                $extension = 'jpeg'; break;
                    }
                } else {
                    $zipReader = fopen($drawing->getPath(),'r');
                    $imageContents = '';
                    while (!feof($zipReader)) {
                        $imageContents .= fread($zipReader,1024);
                    }
                    fclose($zipReader);
                    $extension = $drawing->getExtension();
                }
                $codata = $drawing->getCoordinates(); 
                $myFileName = 'Upload/c/'.date('Y-m-d_His').++$i.'.'.$extension;
                file_put_contents($myFileName,$imageContents);
                $arr[$codata][]['bannerPic'] = $myFileName;
            }
            // var_dump($arr);
           $allColumn = $currentSheet->getHighestColumn(); //取得最大的列号
           $allRow = $currentSheet->getHighestRow(); //取得一共有多少行
          
           // //获取规格
           // for ($i=2; $i < $allRow; $i++) { 
           //      //规格1
           //      $standard1[$i] = $PHPExcel->getActiveSheet()->getCell("J".$i)->getValue();//规格1
           //      $standard2 = $PHPExcel->getActiveSheet()->getCell("L".$i)->getValue();  //规格2
           //      $standard3 = $PHPExcel->getActiveSheet()->getCell("N".$i)->getValue(); //规格3
           //      $standard4 = $PHPExcel->getActiveSheet()->getCell("P".$i)->getValue(); //规格4   
           //      $standard1['value'] = $PHPExcel->getActiveSheet()->getCell("K".$i)->getValue();
           //      var_dump($standard1);

           // }
           //获取
          for($currentRow = 2;$currentRow <= $allRow;$currentRow++){
                //商品编号
                $number = $PHPExcel->getActiveSheet()->getCell("A".$currentRow)->getValue();
                //判断有多少条数据 
                if(empty($number)){
                   exit;
                }

                $data['number'] = $number;
                $data['goodsname'] = $PHPExcel->getActiveSheet()->getCell("B".$currentRow)->getValue();//获取A列的值
                $data['baendname'] = $PHPExcel->getActiveSheet()->getCell("C".$currentRow)->getValue();//获取A列的值
                $data['categroyid'] = $PHPExcel->getActiveSheet()->getCell("D".$currentRow)->getValue();//获取A列的值
                $data['soncategroyid'] = $PHPExcel->getActiveSheet()->getCell("E".$currentRow)->getValue();//获取A列的值
                $data['state'] = $PHPExcel->getActiveSheet()->getCell("F".$currentRow)->getValue();//获取A列的值
                $data['content'] = $PHPExcel->getActiveSheet()->getCell("G".$currentRow)->getValue();//获取A列的值
                
                // /$standard1 = $PHPExcel->getActiveSheet()->getCell("J".$currentRow)->getValue();//获取A列的值
                
                
                // $data['title'] = $PHPExcel->getActiveSheet()->getCell("A".$currentRow)->getValue();//获取A列的值
                // $data['brand'] = $PHPExcel->getActiveSheet()->getCell("B".$currentRow)->getValue();//获取B列的值
                // //分类
                // //$cate = $PHPExcel->getActiveSheet()->getCell("C".$currentRow)->getValue();//获取c列的值
                // //根据名称返回分类
                // // $cateid = $this->MallShop_model->get_cate_id(trim($cate));
                // // if(!empty($cateid)){
                // //     $data['categoryid'] = $cateid;
                // // }else{
                // //     $data['categoryid'] = '1';
                // // }


                // //缩略图
                // if(isset($arr['H'.$currentRow])){
                //      $data['thumb'] = '/'.$arr['H'.$currentRow][0]['bannerPic'];
                // }else{
                //     $data['thumb'] = '';
                // } 
                // //商品banner
                // if(isset($arr['I'.$currentRow])){
                //      $data['good_pic'] = json_encode($arr['I'.$currentRow]);
                // }else{
                //     $data['good_pic'] = '';
                // }
                // $data['storeid'] = $this->session->businessId;

                //新增
                // $this->MallShop_model->add_shop_goods($data);
           }
        }else{
           $this->load->view('404.html'); 
        }
    }
}
