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
    function impolt_good(){
        header('content-type:text/html;charset=utf8');
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
           $currentSheet = $PHPExcel->getSheet(0); 
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
                $arr[$codata][]['bannerPic'] = '/'.$myFileName;
            }
           $allColumn = $currentSheet->getHighestColumn(); //取得最大的列号
           $allRow = $currentSheet->getHighestRow(); //取得一共有多少行
          
            for($currentRow = 2;$currentRow <= $allRow;$currentRow++){
                //商品编号
                $goods[$currentRow]['goods_code'] = $PHPExcel->getActiveSheet()->getCell("A".$currentRow)->getValue();
                $goods[$currentRow]['title'] = $PHPExcel->getActiveSheet()->getCell("B".$currentRow)->getValue();//获取A列的值
                $goods[$currentRow]['brand'] = $PHPExcel->getActiveSheet()->getCell("C".$currentRow)->getValue();//获取A列的值
                $cate = $PHPExcel->getActiveSheet()->getCell("D".$currentRow)->getValue();//获取A列的值
                $soncate = $PHPExcel->getActiveSheet()->getCell("E".$currentRow)->getValue();//获取A列的值
                $goods[$currentRow]['goods_state'] = $PHPExcel->getActiveSheet()->getCell("F".$currentRow)->getValue();//获取A列的值
                $goods[$currentRow]['content'] = $PHPExcel->getActiveSheet()->getCell("G".$currentRow)->getValue();//获取A列的值
                
                //获取规格项1
                $standard1 = $PHPExcel->getActiveSheet()->getCell("J".$currentRow)->getValue();//获取A列的值
                //获取规格值1
                $standardval1 = $PHPExcel->getActiveSheet()->getCell("K".$currentRow)->getValue();
                if(!empty($standard1)){
                  $num = $currentRow;
                  if(!empty($standardval1)){
                    $data[$num]['check'][$currentRow]['stend1'] = $standardval1;
                    //价格
                    $data[$num]['check'][$currentRow]['price'] = $PHPExcel->getActiveSheet()->getCell("R".$currentRow)->getValue();
                    //库存
                    $data[$num]['check'][$currentRow]['stock'] = $PHPExcel->getActiveSheet()->getCell("S".$currentRow)->getValue(); 
                    //库存
                    $data[$num]['check'][$currentRow]['postage'] = $PHPExcel->getActiveSheet()->getCell("T".$currentRow)->getValue();
                  }

                }else{
                  if(!empty($standardval1)){
                    $data[$num]['check'][$currentRow]['stend1'] = $standardval1;
                    //价格
                    $data[$num]['check'][$currentRow]['price'] = $PHPExcel->getActiveSheet()->getCell("R".$currentRow)->getValue();
                    //库存
                    $data[$num]['check'][$currentRow]['stock'] = $PHPExcel->getActiveSheet()->getCell("S".$currentRow)->getValue(); 
                    //库存
                    $data[$num]['check'][$currentRow]['postage'] = $PHPExcel->getActiveSheet()->getCell("T".$currentRow)->getValue();
                  }
                }
                //获取规格项2
                $standard2 = $PHPExcel->getActiveSheet()->getCell("L".$currentRow)->getValue();//获取A列的值
                $standardval2 = $PHPExcel->getActiveSheet()->getCell("M".$currentRow)->getValue();
                if(!empty($standard2)){
                  $num = $currentRow;
                  if(!empty($standardval1)){
                    $data[$num]['check'][$currentRow]['stend2'] = $standardval2;
                  }
                }else{
                  if(!empty($standardval2)){
                     $data[$num]['check'][$currentRow]['stend2'] = $standardval2;
                  }
                }
                //获取规格项3
                 $standard3 = $PHPExcel->getActiveSheet()->getCell("N".$currentRow)->getValue();//获取A列的值
                 $standardval3 = $PHPExcel->getActiveSheet()->getCell("O".$currentRow)->getValue();
                if(!empty($standard3)){
                   $num = $currentRow;
                    if(!empty($standardval1)){
                    $data[$num]['check'][$currentRow]['stend3'] = $standardval3;
                    }
                }else{
                  if(!empty($standardval3)){
                      $data[$num]['check'][$currentRow]['stend3'] = $standardval3;
                  }
                } 
                //获取规格项4
                $standard4 = $PHPExcel->getActiveSheet()->getCell("P".$currentRow)->getValue();//获取A列的值
                $standardval4= $PHPExcel->getActiveSheet()->getCell("Q".$currentRow)->getValue();
                if(!empty($standard4)){
                  $num = $currentRow;
                  if(!empty($standardval1)){
                    $data[$num]['check'][$currentRow]['stend4'] = $standardval4;
                  }
                }else{
                  if(!empty($standardval4)){
                    $data[$num]['check'][$currentRow]['stend4'] = $standardval4;
                  }
                }
                //根据名称返回分类
                $cateid = $this->MallShop_model->get_cate_id(trim($cate));
                if(!empty($cateid)){
                    $goods[$currentRow]['categoryid'] = $cateid;
                }
                // //缩略图
                if(isset($arr['H'.$currentRow])){
                     $goods[$currentRow]['thumb'] = $arr['H'.$currentRow][0]['bannerPic'];
                }else{
                    $goods[$currentRow]['thumb'] = '';
                } 
                //商品banner
                if(isset($arr['I'.$currentRow])){
                     $goods[$currentRow]['good_pic'] = json_encode($arr['I'.$currentRow]);
                }else{
                    $goods[$currentRow]['good_pic'] = '';
                }
                // $data[$currentRow]['storeid'] = $this->session->businessId;
           }
           //去掉空数组
           foreach($goods as $key=>$val){
              if(empty($val['title'])){
                unset($goods[$key]);
              }
           }
           //新增到数据库
           foreach ($goods as $k => $v) {
              $this->db->insert("hf_mall_goods",$v);
              $goodsid =  $this->db->insert_id();
              var_dump($goodsid);
              if(empty($goodsid)){
                  $error[] = $k;
              }else{
                foreach ($data as $key => $value) {
                  if($k == $key){ 
                    foreach ($value['check'] as $j => $val) {
                        $val['g_id'] = $goodsid;
                        $this->db->insert('hf_mall_goods_property',$val); 
                    }
                  }
                }
              }
           }
        } 
    }





    //商家导入商品
    function impolt_goods(){
        header('content-type:text/html;charset=utf8');
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
           //上传图片文件
         //  $i = 0;   
           // foreach ($PHPExcel->getActiveSheet()->getDrawingCollection() as $drawing) {
           //      if ($drawing instanceof PHPExcel_Worksheet_MemoryDrawing) {
           //          ob_start();
           //          call_user_func(
           //              $drawing->getRenderingFunction(),
           //              $drawing->getImageResource()
           //          );
           //          $imageContents = ob_get_contents();
           //          ob_end_clean();
           //          switch ($drawing->getMimeType()) {
           //              case PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_PNG :
           //                      $extension = 'png'; break;
           //              case PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_GIF:
           //                      $extension = 'gif'; break;
           //              case PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_JPEG :
           //                      $extension = 'jpg'; break; 
           //              case PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_JPEG :
           //                      $extension = 'jpeg'; break;
           //          }
           //      } else {
           //          $zipReader = fopen($drawing->getPath(),'r');
           //          $imageContents = '';
           //          while (!feof($zipReader)) {
           //              $imageContents .= fread($zipReader,1024);
           //          }
           //          fclose($zipReader);
           //          $extension = $drawing->getExtension();
           //      }
           //      $codata = $drawing->getCoordinates(); 
           //      $myFileName = 'Upload/c/'.date('Y-m-d_His').++$i.'.'.$extension;
           //      file_put_contents($myFileName,$imageContents);
           //      $arr[$codata][]['bannerPic'] = $myFileName;
           //  }
            // var_dump($arr);
           $allColumn = $currentSheet->getHighestColumn(); //取得最大的列号
           $allRow = $currentSheet->getHighestRow(); //取得一共有多少行
          
         
           //获取
          for($currentRow = 2;$currentRow <= $allRow;$currentRow++){
                //商品编号
                $goods[$currentRow]['goods_code'] = $PHPExcel->getActiveSheet()->getCell("A".$currentRow)->getValue();
                $goods[$currentRow]['goodsname'] = $PHPExcel->getActiveSheet()->getCell("B".$currentRow)->getValue();//获取A列的值
                $goods[$currentRow]['baendname'] = $PHPExcel->getActiveSheet()->getCell("C".$currentRow)->getValue();//获取A列的值
                $cate = $PHPExcel->getActiveSheet()->getCell("D".$currentRow)->getValue();//获取A列的值
                $soncate = $PHPExcel->getActiveSheet()->getCell("E".$currentRow)->getValue();//获取A列的值
                $goods[$currentRow]['state'] = $PHPExcel->getActiveSheet()->getCell("F".$currentRow)->getValue();//获取A列的值
                $goods[$currentRow]['content'] = $PHPExcel->getActiveSheet()->getCell("G".$currentRow)->getValue();//获取A列的值
                
                //获取规格项1
                $standard1 = $PHPExcel->getActiveSheet()->getCell("J".$currentRow)->getValue();//获取A列的值
                //获取规格值1
                $standardval1 = $PHPExcel->getActiveSheet()->getCell("K".$currentRow)->getValue();
                if(!empty($standard1)){
                  $num = $currentRow;
                  $data[$num]['stend']['0']['name']  = $standard1;

                  if(!empty($standardval1)){
                    $data[$num]['stend']['0']['value'][]  = $standardval1;
                    $data[$num]['check'][$currentRow]['stend1'] = $standardval1;
                    //价格
                    $data[$num]['check'][$currentRow]['price'] = $PHPExcel->getActiveSheet()->getCell("R".$currentRow)->getValue();
                    //库存
                    $data[$num]['check'][$currentRow]['stock'] = $PHPExcel->getActiveSheet()->getCell("S".$currentRow)->getValue(); 
                    //库存
                    $data[$num]['check'][$currentRow]['postage'] = $PHPExcel->getActiveSheet()->getCell("T".$currentRow)->getValue();
                  }

                }else{
                  if(!empty($standardval1)){
                    $data[$num]['stend']['0']['value'][]  = $standardval1;
                    $data[$num]['check'][$currentRow]['stend1'] = $standardval1;
                    //价格
                    $data[$num]['check'][$currentRow]['price'] = $PHPExcel->getActiveSheet()->getCell("R".$currentRow)->getValue();
                    //库存
                    $data[$num]['check'][$currentRow]['stock'] = $PHPExcel->getActiveSheet()->getCell("S".$currentRow)->getValue(); 
                    //库存
                    $data[$num]['check'][$currentRow]['postage'] = $PHPExcel->getActiveSheet()->getCell("T".$currentRow)->getValue();
                  }
                }
                //获取规格项2
                $standard2 = $PHPExcel->getActiveSheet()->getCell("L".$currentRow)->getValue();//获取A列的值
                $standardval2 = $PHPExcel->getActiveSheet()->getCell("M".$currentRow)->getValue();
                if(!empty($standard2)){
                  $num = $currentRow;
                  $data[$num]['stend']['1']['name']  = $standard2;

                  if(!empty($standardval1)){
                    $data[$num]['stend']['1']['value'][]  = $standardval2;
                    $data[$num]['check'][$currentRow]['stend2'] = $standardval2;
                  }
                }else{
                  if(!empty($standardval2)){
                     $data[$num]['stend']['1']['value'][]  = $standardval2;
                     $data[$num]['check'][$currentRow]['stend2'] = $standardval2;
                  }
                }
                //获取规格项3
                 $standard3 = $PHPExcel->getActiveSheet()->getCell("N".$currentRow)->getValue();//获取A列的值
                 $standardval3 = $PHPExcel->getActiveSheet()->getCell("O".$currentRow)->getValue();
                if(!empty($standard3)){
                   $num = $currentRow;
                   $data[$num]['stend']['2']['name']  = $standard3;
                    if(!empty($standardval1)){
                         $data[$num]['stend']['2']['value'][]  = $standardval3;
                    $data[$num]['check'][$currentRow]['stend3'] = $standardval3;
                    }
                }else{
                  if(!empty($standardval3)){
                           $data[$num]['stend']['2']['value'][]  = $standardval3;
                      $data[$num]['check'][$currentRow]['stend3'] = $standardval3;
                  }
                } 
                //获取规格项4
                $standard4 = $PHPExcel->getActiveSheet()->getCell("P".$currentRow)->getValue();//获取A列的值
                $standardval4= $PHPExcel->getActiveSheet()->getCell("Q".$currentRow)->getValue();
                if(!empty($standard4)){
                  $num = $currentRow;
                  $data[$num]['stend']['3']['name']  = $standard4;
                  if(!empty($standardval1)){
                        $data[$num]['stend']['3']['value'][]  = $standardval4;
                    $data[$num]['check'][$currentRow]['stend4'] = $standardval4;
                  }
                }else{
                  if(!empty($standardval4)){
                    $data[$num]['stend']['3']['value'][]  = $standardval4;
                    $data[$num]['check'][$currentRow]['stend4'] = $standardval4;
                  }
                }

                
                // $data['title'] = $PHPExcel->getActiveSheet()->getCell("A".$currentRow)->getValue();//获取A列的值
                // $data['brand'] = $PHPExcel->getActiveSheet()->getCell("B".$currentRow)->getValue();//获取B列的值
                // //分类
                $cate = $PHPExcel->getActiveSheet()->getCell("C".$currentRow)->getValue();//获取c列的值
                //根据名称返回分类
                $cateid = $this->MallShop_model->get_cate_id(trim($cate));
                if(!empty($cateid)){
                    $data[$currentRow]['categoryid'] = $cateid;
                }
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
           foreach($goods as $key=>$val){
              if(empty($val['goodsname'])){
                unset($goods[$key]);
              }
           }
           foreach ($data as $k => $v) {
             foreach ($v['stend'] as $key => $value) {
                $data[$k]['parent']['stend'][$key]['name'] = $value['name'];
                $data[$k]['parent']['stend'][$key]['value'] = array_values(array_unique($value['value']));
             }
              $data[$k]['parent']['check'] = array_values($v['check']);
              $goods[$k]['parent'] = json_encode($data[$k]['parent'],JSON_UNESCAPED_UNICODE);
           }
var_dump($goods);


        }else{
           $this->load->view('404.html'); 
        }
    }
}
