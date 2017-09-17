<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*

 *  商家管理

 *

 * */

require_once(APPPATH.'controllers/Default_Controller.php');



class SingleShop extends CI_Controller {

    //商家 列表主页

    public $view_shopAdmin = "shop/shopAdmin.html";

    //商家基础信息

    public $view_shopBaseInfo = "shop/shopBaseInfo.html";

    //商家简介

    public $view_shopInfo = "shop/shopInfo.html";

    //商品列表

    public $view_goodsList = "shop/goodsList.html"; 

    //商品列表 副本

    public $view_goodsList1 = "shop/goodsList1.html"; 

    //商品详情

    public $view_goodsDetail = "shop/goodsDetail.html"; 

    //商品详情 副本

    public $view_goodsDetail1 = "shop/goodsDetail1.html"; 

    //新增商品

    public $view_goodsAdd = "shop/goodsAdd.html"; 

    //新增商品 副本

    public $view_goodsAdd1 = "shop/goodsAdd1.html"; 

    //商家楼层关系

    public $view_shopFloorRelation = "shop/shopFloorRelation.html";

    //订单列表

    public $view_shopOrder = "shop/shopOrder.html";

    //修改订单

    public $view_sureOrder = "shop/sureOrder.html";  

    //订单详情

    public $view_shopEditOrder = "shop/shopEditOrder.html";

    //促销劵列表

    public $view_shopSalesList = 'shop/shopSalesList.html';

    //优惠劵新增编辑

    public $view_shopEditSales = "shop/shopEditSales.html";

    public $view_shopAddSales = "shop/shopAddSales.html";

    //优惠劵验证

    public $view_shopCheckSales = 'shop/shopCheckSales.html';

    //活动

    public $view_shopEditActivity = 'shop/shopEditActivity.html';

    public $view_shopActivityList = 'shop/shopActivityList.html';

    public $view_shopAddActivity = 'shop/shopAddActivity.html';

    public $view_shopEdityouhui = 'shop/shopEdityouhui.html';

    public $view_shopActivityApplyList = 'shop/shopActivityApplyList.html';

    //评论

    public $view_shopComment = "shop/shopComment.html";

    function __construct()

    {

        parent::__construct();

        $this->load->model('MallShop_model');

        $this->load->model('Shop_model');
        date_default_timezone_set("Asia/Shanghai");
        $this->load->helper('Default_helper');
		$this->load->helper('Search_helper');
        session_start();
        
        if(!isset($_SESSION['users'])){
            echo "<script>alert('您还没有登陆！');window.location.href='".site_url('/Login/index')."';</script>";
            exit;
        }
       

    }



    //商家 列表主页

    function shopAdmin()

    {   //缓存商家id

        
        // var_dump($_SESSION['users']);
        // exit;
        $id = intval($this->uri->segment(4));

        if($id == 0){

            //商家登录

             $storeid = $this->MallShop_model->get_store_list($_SESSION['users']['user_id']);

             if(!empty($storeid)){

                $_SESSION['businessId'] = $storeid['store_id'];

                $_SESSION['businesstype'] = $storeid['store_type'];

                //$_SESSION['set_userda']ta('businessId',$storeid['store_id']);

                //$_SESSION['set_userda']ta('businesstype',$storeid['store_type']);

             }else{

                redirect('admin/index');

             }

        }else{

             $storeid = $this->MallShop_model->get_basess_info($id);

             //$_SESSION['set_userda']ta('businessId',$id);

             //$_SESSION['set_userda']ta('businesstype',$storeid['store_type']);

             $_SESSION['businessId'] = $id;

             $_SESSION['businesstype'] = $storeid['store_type'];



        }



        $store_id =$_SESSION['businessId'];

        if(empty($store_id)){

            echo "<script>alert('登录信息过时！请重新登录！');window.location.href='".site_url('/login/index')."'</script>";exit;

        }

       // var_dump($_SESSION['businessId']);

        $data['page'] = $this->view_shopAdmin;

    	$this->load->view('template.html',$data);

    }

    //商家基础信息

    function shopBaseInfo(){

        $store_id =$_SESSION['businessId'];

         if(empty($store_id)){

            echo "<script>alert('登录信息过时！请重新登录！');window.location.href='".site_url('/login/index')."'</script>";exit;

        }

        //获取商家信息

        $store = $this->MallShop_model->get_basess_info($_SESSION['businessId']);

        //获取商家登录账户

        $data['user'] = $this->Shop_model->get_login_store($store['business_id']);

       

        $data['busin'] = $store; 

        //返回所有一级业态

        $data['yetai'] = $this->Shop_model->store_type_level();



        $data['page'] = $this->view_shopBaseInfo;

        $data['menu'] = array('shop','shopBaseInfo');       

        $this->load->view('template.html',$data);

    }

    //根据顶级业态返回

    function shop_store_type(){

        if($_POST){

            $gid = $_POST['gid'];

            //根据gid返回

            $type = $this->Shop_model->store_type_tow($gid);

            if(empty($type)){

                echo "2";

            }else{

                echo json_encode($type);

            }

        }else{

            echo "2";

        }

    }



    //商家基础信息操作

    function edit_busin_info(){
      
        $store_id =$_SESSION['businessId'];

        if(empty($store_id)){

            echo "<script>alert('登录信息过时！请重新登录！');window.location.href='".site_url('/login/index')."'</script>";exit;

        }

        if($_POST){

            $data = $this->input->post();

       

            $arr['username'] = trim($this->input->post('username'));

            $arr['password'] =trim($this->input->post('password'));

            if(!empty($arr['password'])){

                $arr['password'] = md5($arr['password']);

            }else{

              unset($arr['password']);  

            }

            $arr['user_id'] = $this->input->post('user_id');

            unset($data['username'],$data['password'],$data['user_id']);

            if($this->Shop_model->get_member_info($arr['user_id'],$arr['username'])){

                 echo "<script>alert('账户已被注册！');window.location.href='".site_url('/shop/SingleShop/shopBaseInfo')."'</script>";exit;

            }

            if(empty(json_decode($data['store_reduction']))){

                $data['store_reduction'] = NULL;

            }



            $pic = array();

            $header = array("token:".$_SESSION['token'],'city:'.'1');     
            if(!empty($_FILES['img1']['name'])){
                    unset($data['img1']);
                    $tmpfile = new CURLFile(realpath($_FILES['img1']['tmp_name']));
                
                    $pics = array(
                        'pics' =>$tmpfile,
                        'porfix'=>'moll/store/'.$store_id.'/logo',
                        'bucket'=>BUCKET,
                    );
                
                    $a = json_decode(curl_post_express($header,QINIUUPLOAD,$pics),true);
                    $img = json_decode($a['data']['img'],true);
                    $data['logo'] = $img[0]['picImg'];

            }else{

                if(isset($data['img1'])){
                    $data['logo'] = $data['img1'];
                    unset($data['img1']);

                }
            }

                if(!empty($_FILES['img2']['name'])){
                        unset($data['img2']);
                        $tmpfile = new CURLFile(realpath($_FILES['img2']['tmp_name']));
                        $pics = array(
                            'pics' =>$tmpfile,
                            'porfix'=>'moll/store/'.$store_id.'/logo',
                            'bucket'=>BUCKET,
                        );
                    
                        $a = json_decode(curl_post_express($header,QINIUUPLOAD,$pics),true);
                        $img = json_decode($a['data']['img'],true);
                        $data['pic'] = $img[0]['picImg'];
                }else{

                    if(isset($data['img2'])){
                        $data['pic'] = $data['img2'];
                        unset($data['img2']);

                    }

                }

            if($this->Shop_model->edit_store_member($arr['user_id'],$arr)){

                 if($this->MallShop_model->edit_store_info($data['store_id'],$data)){

                    //日志    

                     $log = array(

                        'userid'=>$_SESSION['users']['user_id'],  

                        "content" => $_SESSION['users']['username']."修改了商家基础信息，商家名称是：".$data['store_name'].",商家id是：".$data['store_id'],

                        "create_time" => date('Y-m-d H:i:s'),

                        "userip" => get_client_ip(),

                    );

                    $this->db->insert('hf_system_journal',$log);

                     echo "<script>alert('操作成功！');window.location.href='".site_url('/shop/SingleShop/shopBaseInfo')."'</script>";exit;

                   // echo "23";

                 }else{

                    echo "<script>alert('操作失败！');window.location.href='".site_url('/shop/SingleShop/shopBaseInfo')."'</script>";exit;

                 }

            }

        }else{

            $this->load->view('404.html');

        }

    }

    //  //商品列表

    function goodsList(){

        $store_id =$_SESSION['businessId'];

        $store_type =$_SESSION['businesstype'];

           if(empty($store_id)){

            echo "<script>alert('登录信息过时！请重新登录！');window.location.href='".site_url('/login/index')."'</script>";exit;

        }

        //分类

        if($store_type == '2'){

            $data['cates'] = $this->MallShop_model->get_goods_cates('0','2');

        }else{

            $data['cates'] = $this->MallShop_model->get_goods_cates('0','1');

        }

       

        $data['page'] = $this->view_goodsList;

        $data['menu'] = array('shop','goodsList');

        $this->load->view('template.html',$data);

    }



    //返回商家商品列表

    function store_goods_list(){

        if($_POST){

           //获取商家信息

          

               $arr = $this->MallShop_model->get_goods_list($_SESSION['businessId']);

           
            //获取商品库存
            foreach($arr as $k=>$v){
                //获取商品属性
                $parent=  $this->MallShop_model->get_goods_parent($v['goods_id']);

                if(!empty($parent)){

                    $a = '0';

                    foreach($parent as $key=>$val){

                        $a += $val['stock'];

                    }

                    $arr[$k]['amount'] = $a;

                }else{

                    $arr[$k]['amount'] = '0';

                }

            } 



           if(empty($arr)){

                echo "2";

           }else{

                echo json_encode($arr);

           }

        }else{

            echo "2";

        }

    }


    //修改商品上下架状态

    function edit_goods_state(){

         if($_POST){

            $data['goods_state'] = $_POST['state'];

            $goods_id = $_POST['goodsid'];

            if($this->MallShop_model->edit_goods_state($goods_id,$data)){

               //日志

                 $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."修改了商品上下架状态，商品id是：".$goods_id,

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

    //商品详情

    function goodsDetail(){

        $store_id =$_SESSION['businessId'];

        $store_type =$_SESSION['businesstype'];

        if(empty($store_id)){

            echo "<script>alert('登录信息过时！请重新登录！');window.location.href='".site_url('/login/index')."'</script>";exit;

        }

        $id = intval($this->uri->segment(4));

        if($id == 0){

            $this->load->view('404.html');

        }else{



            $goods = $this->MallShop_model->get_goodsInfo($id);

            if($goods['differentiate'] == '4'){
                $type = '2';
            }else{
                $type = '1';
            }
            //获取商品分类
            $data['cates'] = $this->MallShop_model->get_cates_parent($type);
           //  var_Dump($data);

            $data['goods'] = $goods;


            //获取商品属性

            $parent = $this->MallShop_model->get_goods_parent($id);

            if(!empty($parent)){

                foreach ($parent as $key => $value) {

                    $stend['0']['name'][] = $value['stend1'];

                    $stend['0']['value'][] = $value['value1'];

                    $stend['1']['name'][]= $value['stend2'];

                    $stend['1']['value'][]= $value['value2'];

                    $stend['2']['name'][]= $value['stend3'];

                    $stend['2']['value'][]= $value['value3'];

                    $stend['3']['name'][] = $value['stend4'];

                    $stend['3']['value'][] = $value['value4'];

                }

                foreach ($stend as $k => $v) {

                    if($v['name'][0] == ''){

                        unset($v);

                    }else{

                        $arr[$k]['name'] = array_unique($v['name']);

                        $arr[$k]['value'] = array_unique($v['value']);

                    }

                }

                $data['parent'] =$arr;

            }else{

                $parent = '';

                $data['parent'] = '';

            }

            $data['shuxing'] = $parent;

            $data['page'] = $this->view_goodsDetail;

            $data['menu'] = array('shop','goodsList');       

            $this->load->view('template.html',$data);

        }

    }

    //获取商品评价

    function get_goods_comment(){

        if($_POST){

            $goodsid = $_POST['goodsid'];

            $comment = $this->MallShop_model->get_goods_comment($goodsid);

            if(empty($comment)){

                echo '2';

            }else{

                foreach ($comment as $key => $value) {

                   $comment[$key]['reply'] = $this->MallShop_model->gte_store_reply($value['id']);

                }

                echo json_encode($comment);

            }

        }else{

            echo "2";

        }

    }

    //编辑商品操作

    function edit_goods(){

        if($_POST){

            $data = $this->input->post();

            $parent = json_decode($data['parameter'],true);

            unset($data['parameter'],$data['ruleSelect'],$data['addNewPropertValue']);

            $pic = array();
            if($data['differentiate'] == '2'){
                $data['differentiate'] = '4';
            }

 
            $header = array("token:".$_SESSION['token'],'city:'.'1');     
            for ($i=1; $i < 4; $i++) {

                if(!empty($_FILES['img'.$i]['name'])){
                    


                    $tmpfile = new CURLFile(realpath($_FILES['img'.$i]['tmp_name']));
                
                    $pics = array(
                        'pics' =>$tmpfile,
                        'porfix'=>'moll/goods/'.$data['goods_id'].'/thumb',
                        'bucket'=>BUCKET,
                    );
                
                    $a = json_decode(curl_post_express($header,QINIUUPLOAD,$pics),true);
                
                    if($a['errno'] == '0'){
                        unset($data['img'.$i]);
                        $img = json_decode($a['data']['img'],true);
                        if($i == '1'){
                            $data['thumb'] = $img[0]['picImg'];
                        }
                        $pic[]['bannerPic'] =$img[0]['picImg'];
                        // $data['logo'] = 
                    }
                }else{

                     if(!empty($data['img'.$i])){

                         if($i == '1'){

                                $data['thumb'] = $data['img'.$i];
                         }
                         $pic[]['bannerPic'] = $data['img'.$i];
                         unset($data['img'.$i]);

                     }

                   

                }

             }

            if(empty(json_decode($data['reduction_rule']))){

                $data['reduction_rule'] = NULL;

            }

            if(empty($data['maxTorder'])){

                $data['maxTorder'] = NULL;

            }



             $data['update_time'] = date('Y-m-d H:i:s');

             $data['good_pic'] = json_encode($pic);

             if($this->MallShop_model->edit_goods($data['goods_id'],$data)){

                //刪除商品所有屬性

                $this->MallShop_model->del_goods_prop($data['goods_id']);

                foreach ($parent as $key => $value) {

                    $value['g_id'] = $data['goods_id'];

                    $this->db->insert('hf_mall_goods_property',$value);

                }

                  //日志

                $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."编辑了商品信息，商品id是：".$data['goods_id'],

                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );

                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/shop/SingleShop/goodsList')."'</script>";exit;

             }else{

                 echo "<script>alert('操作失败！');window.location.href='".site_url('/shop/SingleShop/goodsDetail/'.$data['id'])."'</script>";exit;

             }

        }else{

            $this->load->view('404.html');

        }

    }



     //新增商品

    function goodsAdd(){

        $store_id =$_SESSION['businessId'];

        $store_type =$_SESSION['businesstype'];

           if(empty($store_id)){

            echo "<script>alert('登录信息过时！请重新登录！');window.location.href='".site_url('/login/index')."'</script>";exit;

        }

        //所有商品分类

        if($store_type == '2'){

            $data['cates'] = $this->MallShop_model->get_goods_cates('0','2');

        }else{

            $data['cates'] = $this->MallShop_model->get_goods_cates('0','1');

        }

        //返回快递模板

        //$data['express'] = $this->MallShop_model->get_express_temp();

        $data['store_type'] = $store_type;

        $data['page'] = $this->view_goodsAdd;

        $data['menu'] = array('shop','goodsList');       

        $this->load->view('template.html',$data);

    }



    //返回二级分类

    function return_godos_cate(){

        if($_POST){

            $c_id = $_POST['type'];

            if(empty($c_id)){

                echo "2";

            }else{

                $date = $this->MallShop_model->get_cates_parent($c_id);

                if(empty($date)){

                    echo "2";

                }else{

                    echo json_encode($date);

                }

            }

        }else{

            echo "2";

        }

    }

    

    //新增商品操作

    function add_goods(){

        if($_POST){

            $data= $this->input->post();

            $parent = json_decode($data['parameter'],true);

            unset($data['parameter'],$data['ruleSelect'],$data['addNewPropertValue']);

            if($data['differentiate'] == "2"){
                $data['differentiate']  == '4';
            }

            $pic = array();

            $i =1;
            $header = array("token:".$_SESSION['token'],'city:'.'1');     
            
            foreach($_FILES as $file=>$val){

                if(!empty($_FILES['img'.$i]['name'])){

                    $tmpfile = new CURLFile(realpath($_FILES['img'.$i]['tmp_name']));
                    
                        $pics = array(
                            'pics' =>$tmpfile,
                            'porfix'=>'moll/goods/thumb',
                            'bucket'=>BUCKET,
                        );
                    
                        $a = json_decode(curl_post_express($header,QINIUUPLOAD,$pics),true);
                    
                        if($a['errno'] == '0'){
                            $img = json_decode($a['data']['img'],true);
                            if($i == '1'){
                                $data['thumb'] = $img[0]['picImg'];
                            }
                            $pic[]['bannerPic'] =$img[0]['picImg'];
                        }
                }
                $i++;

             }



            if(empty(json_decode($data['reduction_rule']))){

                $data['reduction_rule'] = NULL;

            }

             if(empty($data['maxTorder'])){

                $data['maxTorder'] = NULL;

            }

   

             $data['good_pic'] = json_encode($pic);

             $data['storeid'] =$_SESSION['businessId'];

            

            // $store = $this->MallShop_model->get_basess_info($_SESSION['businessId']);

            // if($store['store_type'] == 1){

            //     $data['differentiate'] = '1';

            // }else{

            //     $data['differentiate'] = '4';

            // }

//             var_Dump($data);
// exit;
             $goodsid = $this->MallShop_model->add_shop_goods($data);

             if(!empty($goodsid)){

                foreach ($parent as $key => $value) {

                    $value['g_id'] = $goodsid;

                    $this->db->insert('hf_mall_goods_property',$value);

                }

                    //日志

                $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."新增了商品信息，商品名称是：".$data['title'],

                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );

                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/shop/SingleShop/goodsList')."'</script>";exit;

             }else{

                echo "<script>alert('操作失败！');window.location.href='".site_url('/shop/SingleShop/goodsAdd')."'</script>";exit;

             }

        }else{

            $this->load->view('404.html');

        }

    }



    //

    function impolt_goods(){

          $store_id =$_SESSION['businessId'];

           if(empty($store_id)){

            echo "<script>alert('登录信息过时！请重新登录！');window.location.href='".site_url('/login/index')."'</script>";exit;

        }

        $error = array();

        $yes = array();

        header('content-type:text/html;charset=utf8');

        if(!empty($_FILES["file"]["tmp_name"])){

            $name = date('Y-m-d');

            $inputFileName = "Upload/xls/" .$name .'.xls';

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

                $myFileName = 'Upload/goods/'.date('Y-m-d_His').++$i.'.'.$extension;

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

                 $goodsstate = $PHPExcel->getActiveSheet()->getCell("F".$currentRow)->getValue();//获取A列的值

                 if(empty($goodsstate)){

                    $goods[$currentRow]['goods_state'] = '0';

                 }else{

                     $goods[$currentRow]['goods_state'] = $goodsstate;

                 }

                

                $goods[$currentRow]['content'] = $PHPExcel->getActiveSheet()->getCell("G".$currentRow)->getValue();//获取A列的值



                //获取规格项1

                $standard1 = $PHPExcel->getActiveSheet()->getCell("J".$currentRow)->getValue();//获取A列的值

                //获取规格值1

                $standardval1 = $PHPExcel->getActiveSheet()->getCell("K".$currentRow)->getValue();



                if(!empty($standard1)){

                  $num = $currentRow;

                  $data[$num]['check'][$currentRow]['stend1'] = $standard1;

                  if(!empty($standardval1)){

                    $data[$num]['check'][$currentRow]['value1'] = $standardval1;

                    //价格

                    $data[$num]['check'][$currentRow]['price'] = $PHPExcel->getActiveSheet()->getCell("R".$currentRow)->getValue();

                    //库存

                    $data[$num]['check'][$currentRow]['stock'] = $PHPExcel->getActiveSheet()->getCell("S".$currentRow)->getValue(); 

                    //库存

                    $data[$num]['check'][$currentRow]['postage'] = $PHPExcel->getActiveSheet()->getCell("T".$currentRow)->getValue();

                  }



                }else{

                  if(!empty($standardval1)){

                    $data[$num]['check'][$currentRow]['value1'] = $standardval1;

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

                  $data[$num]['check'][$currentRow]['stend2'] = $standard2;

                  if(!empty($standardval1)){

                    $data[$num]['check'][$currentRow]['value2'] = $standardval2;

                  }

                }else{

                  if(!empty($standardval2)){

                     $data[$num]['check'][$currentRow]['value2'] = $standardval2;

                  }

                }

                //获取规格项3

                 $standard3 = $PHPExcel->getActiveSheet()->getCell("N".$currentRow)->getValue();//获取A列的值

                 $standardval3 = $PHPExcel->getActiveSheet()->getCell("O".$currentRow)->getValue();

                if(!empty($standard3)){

                   $num = $currentRow;

                    $data[$num]['check'][$currentRow]['stend3'] = $standard3;

                    if(!empty($standardval1)){

                    $data[$num]['check'][$currentRow]['value3'] = $standardval3;

                    }

                }else{

                  if(!empty($standardval3)){

                      $data[$num]['check'][$currentRow]['value3'] = $standardval3;

                  }

                } 

                //获取规格项4

                $standard4 = $PHPExcel->getActiveSheet()->getCell("P".$currentRow)->getValue();//获取A列的值

                $standardval4= $PHPExcel->getActiveSheet()->getCell("Q".$currentRow)->getValue();

                if(!empty($standard4)){

                  $num = $currentRow;

                   $data[$num]['check'][$currentRow]['stend4'] = $standard4;

                  if(!empty($standardval1)){

                    $data[$num]['check'][$currentRow]['value4'] = $standardval4;

                  }

                }else{

                  if(!empty($standardval4)){

                    $data[$num]['check'][$currentRow]['value4'] = $standardval4;

                  }

                }



                $price =  $PHPExcel->getActiveSheet()->getCell("R".$currentRow)->getValue();

                $amount= $PHPExcel->getActiveSheet()->getCell("S".$currentRow)->getValue();

                 if(!empty($amount)){

                       $goods[$currentRow]['amount']  = $amount;

                 }else{

                    if(!empty($standard1)){

                      $error[] = $currentRow;

                       unset($goods[$currentRow]);

                      continue;

                    }

                 }  

                 if(!empty($price)){

                       $goods[$currentRow]['price']  = $price;

                 }else{

                    if(!empty($standard1)){

                      $error[] = $currentRow;

                       unset($goods[$currentRow]);

                      continue;

                    }

                 }

              

                //根据名称返回一级分类

                $cateid = $this->MallShop_model->get_cate_id(trim($cate));

                if(!empty($cateid)){

                    $goods[$currentRow]['categoryid'] = $cateid;

                }else{

                    if(!empty($standard1)){

                      $error[] = $currentRow;

                      unset($goods[$currentRow]);

                      continue;

                    }

                }

                //

                $soncateid = $this->MallShop_model->get_cate_id(trim($soncate));

                if(!empty($cateid)){

                    $goods[$currentRow]['soncategoryid'] = $soncateid;

                }else{

                    $goods[$currentRow]['soncategoryid'] = '';

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

                $goods[$currentRow]['storeid'] =$_SESSION['businessId'];

                $store = $this->MallShop_model->get_basess_info($_SESSION['businessId']);

                if($store['store_type'] == 1){

                     $goods[$currentRow]['differentiate'] = '1';

                }else{

                     $goods[$currentRow]['differentiate'] = '4';

                }

           }



           //去掉空数组

           foreach($goods as $key=>$val){

              if(empty($val['title'])){

                unset($goods[$key]);

              }

           }

           //新增到数据

           foreach ($goods as $k => $v) {

              $goodsid =  $this->MallShop_model->add_goods_id($v);

              if(empty($goodsid)){

                  $error[] = $k;

              }else{

                $yes[] = $k;

                if(!empty($data)){

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

           $ret = array('yes'=>count($yes),'error'=>count($error),'yeslist'=>$yes,'errorlist'=>$error);

           //日志

            $log = array(

                'userid'=>$_SESSION['users']['user_id'],  

                "content" => $_SESSION['users']['username']."导入了商品信息，导入成功".$ret['yes']."条，失败".$ret['error']."条，失败条目：".implode(',',$ret['errorlist']),

                "create_time" => date('Y-m-d H:i:s'),

                "userip" => get_client_ip(),

            );

            $this->db->insert('hf_system_journal',$log);

           echo json_encode($ret);

           unlink($inputFileName);

        } 

    }

    //获取商品属性

    // function get_goods_parent(){

    //     $goodsid = '702';

    //     $query = $this->db->where('g_id',$goodsid)->get('hf_mall_goods_property');

    //     $res = $query->result_array();

    //     var_dump(json_encode($res,JSON_UNESCAPED_UNICODE));

    // }





    //商品删除

    function del_y_goods(){

        if($_POST){

            $id = $_POST['goodsid'];

            if($this->MallShop_model->del_goods($id)){

                  $log = array(

                'userid'=>$_SESSION['users']['user_id'],  

                "content" => $_SESSION['users']['username']."删除一个商品，商品id是：".$id,

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



    //移动回收站

    function del_goods(){

        if($_POST){

            $id = $_POST['goodsid'];

            $data['goods_state'] = '2';

            

            if($this->MallShop_model->edit_goods($id,$data)){

                $log = array(

                'userid'=>$_SESSION['users']['user_id'],  

                "content" => $_SESSION['users']['username']."删除一个商品到回收站，商品id是：".$id,

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

    //恢复商品

     function recovery_goods(){

        if($_POST){

            $id = $_POST['goodsid'];

            $data['goods_state'] = $_POST['state'];

            

            if($this->MallShop_model->edit_goods($id,$data)){

                $log = array(

                'userid'=>$_SESSION['users']['user_id'],  

                "content" => $_SESSION['users']['username']."恢复一个回收站商品到商品列表，商品id是：".$id,

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

 

    //商品搜索

    function search_goods(){

        $store_id =$_SESSION['businessId'];

        if(empty($store_id)){

            echo "2";exit;

        }



        if($_POST){

            $cate = $_POST['cateid'];

           

           // echo $storeid;

            //单价起价格

            $startPrice = $_POST['startPrice'];

            //单价结束价格

            $endPrice = $_POST['endPrice'];

            //kucun

            $startRepertory = $_POST['startRepertory'];

            $endRepertory = $_POST['endRepertory'];

            //商品状态

            $state = $_POST['state']; 

            //关键字

            $sear = trim($_POST['sear']);

            

            $store = $this->MallShop_model->get_basess_info($store_id);

            if($store['store_type'] == 1){

                    $differentiate = '1';

            }else{

                    $differentiate = '4';

            }

            $res = search_store_goods($store_id,$cate,$startPrice,$endPrice,$startRepertory,$endRepertory,$state,$sear,$differentiate);

            if(empty($res)){

                echo '2';

            }else{

                echo json_encode($res);

            }

        }else{

            echo "2";

        }

    }





    //商家楼层关系

    function shopFloorRelation(){

         $data['page'] = $this->view_shopFloorRelation;  

        $data['menu'] = array('shop','shopFloorRelation');       

        $this->load->view('template.html',$data);

    }

    //商家评论管理

    function shopComment(){

        $data['page'] = $this->view_shopComment;  

        $data['menu'] = array('shop','shopComment');   

        $this->load->view('template.html',$data);

    }

    //获取评论列表

    function comment_list(){

        if($_POST){

            $storeid =$_SESSION['businessId'];

            //所有评论

            $comment = $this->MallShop_model->get_store_comment($storeid);

            if(empty($comment)){

                echo "2";

            }else{

            //回复

            foreach ($comment as $key => $value) {

               $comment[$key]['reply'] = $this->MallShop_model->gte_store_reply($value['id']);

            }

            echo json_encode($comment);

            }

        }else{

            echo "2";

        }

    }

    //评论状态修改

    function edit_comment_state(){

        if($_POST){

            $id = $_POST['commentid'];

            $data['state'] = $_POST['state'];

            if($this->MallShop_model->edit_comment_state($id,$data)){

                $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."修改了一个评论，评论id是：".$id,

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

    //回复评论

    function replay_comment(){

        if($_POST){

            $id = $_POST['commentid'];

            $data['seller_reply'] = $_POST['seller_reply'];



            if($this->MallShop_model->edit_comment_state($id,$data)){

                $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."回复了一个评论，评论id是：".$id.';回复内容是：'.$data['seller_reply'],

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

    //批量删除评论

    function del_comment(){

        if($_POST){

            // $a = '';

            $commentid = $_POST["commentid"];



            $comment = json_decode($commentid,true);

            // echo $commentid;

            foreach ($comment as $key => $v) {

                $a = $this->MallShop_model->del_store_comment($v);

            }



            if($a){

                $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."批量删除了评论，评论id是：".implode(',', $comment),

                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );

                $this->db->insert('hf_system_journal',$log);

                echo '1';

            }else{

                echo '2';

            }

        }else{

            echo "2";

        }

    }

    //删除评论

    function del_comment_single(){

         if($_POST){

            $commentid = $_POST["commentid"];

            $a = $this->MallShop_model->del_store_comment($commentid);

            if($a){

                  $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."删除了一个评论，评论id是：".$commentid,

                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );

                $this->db->insert('hf_system_journal',$log);

                echo '1';

            }else{

                echo '2';

            }

        }else{

            echo "2";

        }

    }







    //商家促销管理 优惠劵列表

    function shopSalesList(){

        $data['page'] = $this->view_shopSalesList;

        $data['menu'] = array('sales','shopSalesList');

        $this->load->view('template.html',$data);

    }

    //获取店铺优惠券

    function get_sales_list(){

        if($_POST){

            $storeid =$_SESSION['businessId'];

            $data = $this->MallShop_model->get_store_coupon($storeid);

            if(empty($data)){

                echo "2";

            }else{

                echo json_encode($data);

            }

        }else{

            echo "2";

        }

    }

    //新增优惠劵操作

    function salesAdd(){

        if($_POST){

            $data = $this->input->post();

            if(isset($data['overflowValue'])){

                if(empty($data['overflowValue'])){

                    unset($data['overflowValue'],$data['cutValue']);

                }else{

                    $arr = array('overflowValue'=>$data['overflowValue'],'cutValue'=>$data['cutValue']);

                    $data['salerule'] = json_encode($arr);

                    $data['coupon_amount'] = $data['cutValue'];

                    unset($data['overflowValue'],$data['cutValue']);

                }

            }

          

            $data['storeid'] =$_SESSION['businessId'];

            if($this->MallShop_model->add_coupon($data)){

                $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."新增了一个商家优惠卷，优惠卷名称是：".$data['title'],

                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );

                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/shop/SingleShop/shopSalesList')."'</script>";

            }else{

                echo "<script>alert('操作失败！');window.location.href='".site_url('/shop/SingleShop/shopAddSales')."'</script>";

            }

        }else{

            $this->load->view('404.html');

        }

    }

    //商家优惠劵管理 新增优惠劵

    function shopAddSales(){

        //获取优惠劵类型

        $data['coupon'] = $this->MallShop_model->get_coupon_type();

        $data['page'] = $this->view_shopAddSales;

        $data['menu'] = array('sales','shopAddSales');

        $this->load->view('template.html',$data);

    }

     //商家优惠劵管理 优惠劵验证

    function shopCheckSales(){

        $data['page'] = $this->view_shopCheckSales;

        $data['menu'] = array('sales','shopCheckSales');

        $this->load->view('template.html',$data);

    }

    //编辑优惠劵操作

    function edit_coupon(){

        if($_POST){

            $data = $this->input->post();

            if(isset($data['overflowValue'])){

                if(empty($data['overflowValue'])){

                    unset($data['overflowValue'],$data['cutValue']);

                }else{

                    $arr = array('overflowValue'=>$data['overflowValue'],'cutValue'=>$data['cutValue']);

                    $data['salerule'] = json_encode($arr);

                    $data['coupon_amount'] = $data['cutValue'];

                    unset($data['overflowValue'],$data['cutValue']);

                }

            }

            if($this->MallShop_model->edit_coupon($data['id'],$data)){

                  $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."编辑了一个商家优惠卷，优惠卷名称是：".$data['title'].",优惠卷id是：".$data['id'],

                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );

                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/shop/SingleShop/shopSalesList')."'</script>";

            }else{

                echo "<script>alert('操作失败！');window.location.href='".site_url('/shop/SingleShop/shopEditSales/').$data['id']."'</script>";

            }

        }else{

            $this->load->view('404.html');

        }

    }





     //商家优惠劵管理 编辑优惠劵

    function shopEditSales(){

        $id = intval($this->uri->segment(4));

        if($id == 0){

            $this->load->view('404.html');

        }else{

            //获取优惠劵详情

            $data['coupon'] = $this->MallShop_model->get_conpon_info($id);

            $data['page'] = $this->view_shopEditSales;

            $data['menu'] = array('sales','shopSalesList');

            $this->load->view('template.html',$data);

        }

    }

    //删除优惠劵

    function delshopSales(){

        if($_POST){

            $id = $_POST['id'];

            if($this->MallShop_model->del_coupon($id)){

                  $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."删除了一个商家优惠卷，优惠卷id是：".$id,

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





    //商家活动 & 优惠 活动列表

    function shopActivityList(){

        $data['page'] = $this->view_shopActivityList;

        $data['menu'] = array('activity','shopActivityList');

        $this->load->view('template.html',$data);

    }

     //商家活动 & 优惠 添加活动

    function shopAddActivity(){

        //获取所有优惠劵

        $data['coupon'] = $this->MallShop_model->get_store_coupon($_SESSION['businessId']);

        $data['page'] = $this->view_shopAddActivity;

        $data['menu'] = array('activity','shopActivityList');

        $this->load->view('template.html',$data);

    }

    //新增活动操作

    function add_activity(){

        if($_POST){

            $data = $this->input->post();

            if(empty($data['type'])){

                echo "<script>alert('活动类型不能为空！');window.location.href='".site_url('/shop/SingleShop/shopAddActivity')."'</script>";

                exit;

            }

            if(!empty($_FILES['img']['name'])){

                    $config['upload_path']      = 'Upload/image/activity';

                    $config['allowed_types']    = 'gif|jpg|png|jpeg';

                    $config['max_size']     = 2048;

                    $config['file_name'] = date('Y-m-d_His');

                    $this->load->library('upload', $config);

                    // 上传

                    if(!$this->upload->do_upload('img')) {

                        echo "<script>alert('图片上传失败！');window.location.href='".site_url('/shop/SingleShop/shopAddActivity')."'</script>";exit;

                    }else{

                        $data['picImg'] = '/Upload/image/activity/'.$this->upload->data('file_name');

                    }

            }

            if($data['type'] == 2){

                $cou = array_filter($data['couponid']);

                if(!empty($cou)){

                    $data['couponid'] = implode(',',$cou);

                }else{

                    $data['couponid'] = '';

                 }

             }else{

                $data['couponid'] = '';

             }

            $data['storeid'] =$_SESSION['businessId'];

            if($this->MallShop_model->add_activity($data)){

                $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."新增了一个活动，活动名称是：".$data['title'],

                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );

                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/shop/SingleShop/shopActivityList')."'</script>";exit;

            }else{

                echo "<script>alert('操作失败！');window.location.href='".site_url('/shop/SingleShop/shopAddActivity')."'</script>";exit;

            }

        }else{

            $this->load->view('404.html');

        }

    }

     //商家活动 & 优惠 编辑活动

    function shopEditActivity(){

        $id = intval($this->uri->segment(4));

        if($id == 0){

            $this->load->view('404.html');

        }else{

            $info = $this->MallShop_model->get_activity_info($id);

            //获取所有优惠劵            

            $coupon = $this->MallShop_model->get_store_coupon($_SESSION['businessId']);

            if(!empty($info['couponid'])){

                $couponid = explode(',',$info['couponid']);

                foreach ($coupon as $key => $value) {

                   if(in_array($value['id'],$couponid)){

                        $coupon[$key]['check'] = '1'; 

                   }else{

                        $coupon[$key]['check'] = '0';  

                   }

                }

            }

            $data['coupon'] = $coupon;

            $data['info'] = $info;



            $data['page'] = $this->view_shopEditActivity;

            $data['menu'] = array('activity','shopActivityList');

            $this->load->view('template.html',$data);

        }

    }



    //编辑活动操作

    function edit_activity_info(){

        if($_POST){

            $data = $this->input->post();

            if(empty($data['type'])){

                echo "<script>alert('活动类型不能为空！');window.location.href='".site_url('/shop/SingleShop/shopAddActivity')."'</script>";

                exit;

            }

            if(!empty($_FILES['img']['name'])){

                    $config['upload_path']      = 'Upload/image/activity';

                    $config['allowed_types']    = 'gif|jpg|png|jpeg';

                    $config['max_size']     = 2048;

                    $config['file_name'] = date('Y-m-d_His');

                    $this->load->library('upload', $config);

                    // 上传

                    if(!$this->upload->do_upload('img')) {

                        echo "<script>alert('图片上传失败！');window.location.href='".site_url('/shop/SingleShop/shopEditActivity/'.$data['id'])."'</script>";exit;

                    }else{

                        $data['picImg'] = '/Upload/image/activity/'.$this->upload->data('file_name');

                    }

            }

          

            if($data['type'] == 2){

                $cou = array_unique(array_filter($data['couponid']));

                if(!empty($cou)){

                    $data['couponid'] = implode(',',$cou);

                }else{

                    $data['couponid'] = '';

                }

            }else{

                $data['couponid'] = '';

            }

            if($this->MallShop_model->edit_activity_info($data['id'],$data)){

                $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."编辑了一个活动，活动名称是：".$data['title'],

                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );

                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/shop/SingleShop/shopActivityList')."'</script>";exit;

            }else{

                echo "<script>alert('操作失败！');window.location.herf='".site_url('/shop/SingleShop/shopEditActivity/'.$data['id'])."'</script>";exit;

            }

        }else{

            $this->load->view('404.html');

        }

    }

    //删除活动

    function del_shopActivity(){

        if($_POST){

            $id = $_POST['id'];

            if(empty($id)){

                echo "2";exit;

            }

            if($this->MallShop_model->del_Activity($id)){

                $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."删除了一个活动，活动id是：".$id,

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



    //获取商家活动列表

    function activity_list(){

        if($_POST){

            //活动列表

            $activity = $this->MallShop_model->get_activity_list($_SESSION['businessId']);

            if(empty($activity)){

                echo "2";

            }else{

                echo json_encode($activity);

            }

        }else{

            echo "2";

        }

    }



    //商家活动 & 优惠 编辑优惠

    // function shopEdityouhui(){

    //     $data['page'] = $this->view_shopEdityouhui;

    //     $data['menu'] = array('activity','shopEdityouhui');

    //     $this->load->view('template.html',$data);

    // }



    //商家订单管理

    function shopOrder(){

        $store_id =$_SESSION['businessId'];

        if(empty($store_id)){

            echo "<script>alert('登录信息过时！请重新登录！');window.location.href='".site_url('/login/index')."'</script>";exit;

        }



        $data['storeid'] =$_SESSION['businessId'];

       

        $data['page'] = $this->view_shopOrder;

        $data['menu'] = array('shop','shopOrder');

        $this->load->view('template.html',$data);

    }



    //获取商家订单列表

    function store_order(){

        if($_POST){

            //获取卖家id

            $storeid = $_POST['storeid'];

             $storetype =$_SESSION['businesstype'];

             if($storetype == 2){

                 $type = '4';

             }else{

                 $type = '1';

             }

            //h获取订单

            $orders = $this->MallShop_model->get_store_orders($storeid,$type);



            if(empty($orders)){

                echo "2";

            }else{

                //判断订单是否收货

                foreach($orders as $val){

                    if(!empty($val['updatetime'])){

                        //获取过期时间

                        $endtime = strtotime($val['updatetime'])+3600*24*$val['automatic_confirmation'];

                        //获取当前时间

                        $newdata = time();

                        //var_dump($newdata);

                        if($newdata > $endtime && $val['order_status'] == '3'){

                            $data['order_status'] = '4';

                            $this->MallShop_model->edit_order_state($val['order_id'],$data);

                        }

                    }

                }

                 echo json_encode($orders);

            }

        }else{

            echo "2";

        }

    }

    //修改订单状态

    function edit_goods_order(){

        if($_POST){

            $data['order_status'] = $_POST['state'];

            $data['updatetime'] = date('Y-m-d His');

            $orderid = $_POST['orderid'];

      

            if($this->MallShop_model->edit_order_state($orderid,$data)){

                $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."修改了一个订单状态，订单id是：".$orderid,

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



    //同意仅退款订单并通知管理员

    function order_refund(){

        if($_POST){

            $data = $this->input->post();

            

            if($data['isAgree'] == 1){

                $arr['admin_orderState'] = '1';

            }else{

                $order = $this->MallShop_model->get_order_info($data['order_id']);

                $arr['refuse_refund'] = $data['refund_reason'];

                if(!empty($order['shipper_code'])){

                    $arr['order_status'] = '3';

                }else{

                     $arr['order_status'] = '2';

                }

            }

            if($this->MallShop_model->edit_order_state($data['order_id'],$arr)){

                $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."修改了一个退款订单状态,订单id是：".$data['order_id'],

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



    //商家同意退货退款订单

    function order_refund_goods(){

        if($_POST){

            $data = $this->input->post();

            $order = $this->MallShop_model->get_order_info($data['order_id']);

            if($data['isAgree'] == 1){

                $arr['order_status'] = '7';

                $arr['return_address'] = $data['return_address'];

            }else{

                $arr['refuse_refund'] = $data['refund_reason'];

                if(!empty($order['shipper_code'])){

                    $arr['order_status'] = '3';

                }else{

                     $arr['order_status'] = '2';

                }

            }

             if($this->MallShop_model->edit_order_state($data['order_id'],$arr)){

                $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."修改了一个退款订单状态,订单id是：".$data['order_id'],

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







    //提交物流信息

    function send_express(){

        if($_POST){

            $data['logistic_code'] = $_POST['send_no'];

            $data['shipper_code'] = $_POST['send_type'];

            $data['order_status'] = '3';

            $data['updatetime'] = date("Y-m-d His");

            $orderid= $_POST['orderid'];

            if($this->MallShop_model->edit_order_state($orderid,$data)){

                $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."提交了一个物流信息，订单id是：".$orderid,

                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );

                $this->db->insert('hf_system_journal',$log);

                if($data['shipper_code'] != "ZT"){

                    //获取用户id

                    $order = $this->MallShop_model->get_order_info($orderid);

                    //获取用户电话

                    $user = $this->user_model->get_user_info($order['buyer']);

                    //模拟登陆APP

                    $url = APPLOGIN."/api/useraccount/login";

                    // var_dump($url);

                    $arr = array('phone'=>"15828277232","password"=>"123456a");

                    $token = curl_post_token($url,$arr);

                    $header = array("token:".trim($token)); 

                    if($data['shipper_code'] == "EMS"){

                        $exporess  = "中国邮政";

                    }else if($data['shipper_code'] == "SF"){

                        $exporess  = "顺丰";

                    }else if($data['shipper_code'] == "STO"){

                        $exporess  = "申通";

                    }else if($data['shipper_code'] == "YTO"){

                        $exporess  = "圆通";

                    }else if($data['shipper_code'] == "ZTO"){

                        $exporess  = "中通";

                    }else if($data['shipper_code'] == "YD"){

                        $exporess  = "韵达";

                    }else if($data['shipper_code'] == "HTKY"){

                        $exporess  = "百世汇通";

                    }else if($data['shipper_code'] == "PJ"){

                        $exporess  = "品骏";

                    }else if($data['shipper_code'] == "UAPEX"){

                        $exporess  = "全一";

                    }else if($data['shipper_code'] == "HHTT"){

                        $exporess  = "天天快递";

                    }

                    $post_url = APPLOGIN."/api/index/sendsms";

                    $ret = 'phoneNum='.$user['phone'].'&SMScontent='."hi，小主，感谢您惠顾HI集，您所购买的宝贝已穿戴整齐，向您飞奔而来，请注意查收。".$exporess."快递:".$data['logistic_code'].'【HI集】';

                     $a = curl_post_express($header,$post_url,$ret);

                }

                echo "1";

            }else{

                echo "2";

            }

        }else{

            echo "2";

        }

    }

    //商家订单编辑

    function shopEditOrder(){

        $store_id =$_SESSION['businessId'];

        if(empty($store_id)){

            echo "<script>alert('登录信息过时！请重新登录！');window.location.href='".site_url('/login/index')."'</script>";exit;

        }

        $id = intval($this->uri->segment(4));

        if($id == 0){

            $this->load->view('404.html');

        }else{

            //订单

            $order = $this->MallShop_model->get_order_info($id);

                

            $data['order'] = $order;

            $data['page'] = $this->view_sureOrder;

            $data['menu'] = array('shop','shopOrder');

            $this->load->view('template.html',$data);

        }

    }

    //订单管理 详情

    function sureOrder(){

        $store_id =$_SESSION['businessId'];

        if(empty($store_id)){

            echo "<script>alert('登录信息过时！请重新登录！');window.location.href='".site_url('/login/index')."'</script>";exit;

        }

        $id = intval($this->uri->segment(4));

        if($id == 0){

            $this->load->view('404.html');

        }else{

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





         //    var_dump($data);

            $data['order'] = $order;

            $data['page'] = $this->view_shopEditOrder;

            $data['menu'] = array('shop','shopOrder');

            $this->load->view('template.html',$data);

        }

    }



    //修改订单细腻

    function edit_store_order(){

        if($_POST){

            $data = $this->input->post();

            $order = $this->MallShop_model->get_order_info($data['order_id']);

            if($order['amount'] + $data['fee'] < 0.01){

                echo "<script>alert('改价后价格不能少于0.01元！');window.location.href='".site_url('/shop/SingleShop/shopEditOrder/'.$data['order_id'])."';</script>";exit;

            }else{

            // $price = json_decode($order['PriceCalculation'],true);

            // $price['PriceCalculValue'] = $this->input->post('amount');

            // $price['PriceCalculValue'] = $this->input->post('amount');

                if($this->MallShop_model->edit_order_state($data['order_id'],$data)){

                    $log = array(

                        'userid'=>$_SESSION['users']['user_id'],  

                        "content" => $_SESSION['users']['username']."修改了一个订单信息，订单id是：".$data['order_id'],

                        "create_time" => date('Y-m-d H:i:s'),

                        "userip" => get_client_ip(),

                    );

                    $this->db->insert('hf_system_journal',$log);

                    echo "<script>alert('操作成功！');window.location.href='".site_url('/shop/SingleShop/shopOrder')."';</script>";exit;

                }else{

                    echo "<script>alert('操作成功！');window.location.href='".site_url('/shop/SingleShop/shopEditOrder/'.$data['order_id'])."'</script>";exit;

                }

            }

        }else{

            $this->load->view('404.html');

        }

    }



    //删除订单

    function del_store_order(){

        $id = intval($this->uri->segment(4));

        if($id == 0){

            $this->load->view('404.html');

        }else{



            if($this->MallShop_model->del_store_order($id)){

                $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."删除了一个订单信息，订单id是：".$id,

                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );

                $this->db->insert('hf_system_journal',$log);

                echo "1";

            }else{

                echo "2";

            }

        }

    }



    //订单搜索

    function order_search(){     

        if($_POST){

            $storeid = $_POST['storeid'];

            $state = $_POST['state'];

           

            $time = $_POST['start_time'] . ' 00:00:00';

            $endtime = $_POST['end_time'] .' 23:59:59';

            $username = trim($_POST['username']);



            if(!empty($username)){

                //获取买家id

                $query = $this->db->where('nickname',$username)->get('hf_user_member');

                $res = $query->row_array();

                $buyer = $res['user_id'];

            }else{

                $buyer = '';

            }

            $result = '';

            

            if(!empty($state) && empty($time) && empty($buyer)){

                $this->db->select('a.*,c.nickname');

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');

                $query = $this->db->where('seller',$storeid)->where('order_status',$state)->order_by('a.create_time','desc')->get();

                $result = $query->result_array();

            }else if(empty($state) && !empty($time) && empty($buyer)){

                $this->db->select('a.*,c.nickname');

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');

                $query = $this->db->where('seller',$storeid)->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->order_by('a.create_time','desc')->get();

                 $result = $query->result_array();

            }else if(empty($state) && empty($time) && !empty($buyer)){

                $this->db->select('a.*,c.nickname');

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');

                $query = $this->db->where('a.seller',$storeid)->where('a.buyer',$buyer)->order_by('a.create_time','desc')->get();

                 $result = $query->result_array();

            //两种

            }else if(!empty($state) && !empty($time) && empty($buyer)){

                $this->db->select('a.*,c.nickname');

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');

                $query = $this->db->where('seller',$storeid)->where('order_status',$state)->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->order_by('a.create_time','desc')->get();

                 $result = $query->result_array();

            }else if(!empty($state) && empty($time) && !empty($buyer)){

                $this->db->select('a.*,c.nickname');

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');

                $query = $this->db->where('seller',$storeid)->where('order_status',$state)->where('buyer',$buyer)->order_by('a.create_time','desc')->get();

                 $result = $query->result_array();

            }else if(empty($state) && !empty($time) && !empty($buyer)){

                 $this->db->select('a.*,c.nickname');

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');

                $query = $this->db->where('seller',$storeid)->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->where('buyer',$buyer)->order_by('a.create_time','desc')->get();

                 $result = $query->result_array();

            //三种

            }else if(!empty($state) && !empty($time) && !empty($buyer)){

                $this->db->select('a.*,c.nickname');

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');

                $query = $this->db->where('seller',$storeid)->where('order_status',$state)->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->where('buyer',$buyer)->order_by('a.create_time','desc')->get();

                 $result = $query->result_array();

            }else if(empty($state) && empty($time) && empty($buyer)){

                $this->db->select('a.*,c.nickname');

                $this->db->from('hf_mall_order as a');

                $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');

                $query = $this->db->where('seller',$storeid)->order_by('a.create_time','desc')->get();

                 $result = $query->result_array();

            }

          



            if(empty($result)){

                echo '2';

            }else{

                echo json_encode($result);

            }

        }else{

            echo "2";

        }

    }



    //设置商品特价

    function specials_goods(){

        if($_POST){

            $goodsid = $this->input->post('goodsid');

            $data['specials_state'] = $this->input->post('specials_state');

            if($this->MallShop_model->edit_goods($goodsid,$data)){

                if($data['specials_state'] == 1){

                    $title = "修改了一个商品为特价商品";

                }else{

                    $title = "取消了一个商品为特价商品";

                }

                //日志

                $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username'].$title."，商品id是".$goodsid,

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









     //新增商品的副本

    function goodsAdd1(){

         $data['page'] = $this->view_goodsAdd1;  

        $data['menu'] = array('shop','goodsAdd1');       

        $this->load->view('template.html',$data);

    }



     //编辑商品详情的副本

    function goodsDetail1(){

         $data['page'] = $this->view_goodsDetail1;  

        $data['menu'] = array('shop','goodsDetail1');       

        $this->load->view('template.html',$data);

    }



     //商品列表 的副本

    function goodsList1(){

         $data['page'] = $this->view_goodsList1;  

        $data['menu'] = array('shop','goodsList1');       

        $this->load->view('template.html',$data);

    }

}



   

