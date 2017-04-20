<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  商家管理
 *
 * */
require_once(APPPATH.'controllers/Default_Controller.php');

class SingleShop extends Default_Controller {
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
       
    }

    //商家 列表主页
    function shopAdmin()
    {   //缓存商家id
        
        $id = intval($this->uri->segment(4));
        if($id == 0){
            //商家登录
             $storeid = $this->MallShop_model->get_store_list($this->session->users['user_id']);
             if(!empty($storeid)){
                $this->session->set_userdata('businessId',$storeid['store_id']);
                $this->session->set_userdata('businesstype',$storeid['store_type']);
             }else{
                redirect('admin/index');
             }
        }else{
             $storeid = $this->MallShop_model->get_basess_info($id);
             $this->session->set_userdata('businessId',$id);
             $this->session->set_userdata('businesstype',$storeid['store_type']);

        }

        $store_id = $this->session->businessId;
        if(empty($store_id)){
            echo "<script>alert('登录信息过时！请重新登录！');window.location.href='".site_url('/login/index')."'</script>";exit;
        }
       // var_dump($this->session->businessId);
        $data['page'] = $this->view_shopAdmin;
    	$this->load->view('template.html',$data);
    }
    //商家基础信息
    function shopBaseInfo(){
        $store_id = $this->session->businessId;
         if(empty($store_id)){
            echo "<script>alert('登录信息过时！请重新登录！');window.location.href='".site_url('/login/index')."'</script>";exit;
        }
        //获取商家信息
        $store = $this->MallShop_model->get_basess_info($this->session->businessId);
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
        $store_id = $this->session->businessId;
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
            $pic = array();
         
                if(!empty($_FILES['img1']['name'])){
                    $config['upload_path']      = 'Upload/logo/';
                    $config['allowed_types']    = 'gif|jpg|png|jpeg';
                    $config['max_size']     = 2048;
                    $config['file_name'] = date('Y-m-d_His');
                    $this->load->library('upload', $config);
                    // 上传
                    if(!$this->upload->do_upload('img1')) {
                        echo "<script>alert('图片上传失败！');window.location.href='".site_url('/shop/SingleShop/shopBaseInfo')."'</script>";exit;
                    }else{
                        unset($data['img1']);
                        $data['logo'] = '/Upload/logo/'.$this->upload->data('file_name');
                   
                    }
                }else{
                    if(isset($data['img1'])){
                      
                            $data['logo'] = $data['img1'];
                      
                        unset($data['img1']);
                    }
                }
                if(!empty($_FILES['img2']['name'])){
                    $config['upload_path']      = 'Upload/logo/';
                    $config['allowed_types']    = 'gif|jpg|png|jpeg';
                    $config['max_size']     = 2048;
                    $config['file_name'] = date('Y-m-d_His');
                    $this->load->library('upload', $config);
                    // 上传
                    if(!$this->upload->do_upload('img2')) {
                        echo "<script>alert('图片上传失败！');window.location.href='".site_url('/shop/SingleShop/shopBaseInfo')."'</script>";exit;
                    }else{
                        unset($data['img2']);
                        $data['pic'] = '/Upload/logo/'.$this->upload->data('file_name');
                   
                    }
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
        $store_id = $this->session->businessId;
        $store_type = $this->session->businesstype;
           if(empty($store_id)){
            echo "<script>alert('登录信息过时！请重新登录！');window.location.href='".site_url('/login/index')."'</script>";exit;
        }
        //分类
        var_dump($store_type);
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
           $store = $this->MallShop_model->get_basess_info($this->session->businessId);
           if($store['store_type'] == 1){
               $arr = $this->MallShop_model->get_goods_list($this->session->businessId,'1');
           }else{
               $arr = $this->MallShop_model->get_goods_list($this->session->businessId,'4');
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
        $store_id = $this->session->businessId;
        $store_type = $this->session->businesstype;
        if(empty($store_id)){
            echo "<script>alert('登录信息过时！请重新登录！');window.location.href='".site_url('/login/index')."'</script>";exit;
        }
        $id = intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{

            $data['goods'] = $this->MallShop_model->get_goodsInfo($id);
            //所有商品分类
              if($store_type == '2'){
                    $data['cates'] = $this->MallShop_model->get_goods_cates('0','2');
                }else{
                    $data['cates'] = $this->MallShop_model->get_goods_cates('0','1');
                }

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
              //返回快递模板
            //$data['express'] = $this->MallShop_model->get_express_temp();

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
 
            for ($i=1; $i < 4; $i++) {
                if(!empty($_FILES['img'.$i]['name'])){
                    $config['upload_path']      = 'Upload/goods/';
                    $config['allowed_types']    = 'gif|jpg|png|jpeg';
                    $config['max_size']     = 2048;
                    $config['file_name'] = date('Y-m-d_His');
                    $this->load->library('upload', $config);
                    // 上传
                    if(!$this->upload->do_upload('img'.$i)) {
                        echo "<script>alert('图片上传失败！');window.location.href='".site_url('/shop/SingleShop/goodsDetail/'.$data['id'])."'</script>";exit;
                    }else{
                        unset($data['img'.$i]);
                        if($i == '1'){
                            $data['thumb'] = '/Upload/goods/'.$this->upload->data('file_name');
                        }
                        $pic[]['bannerPic'] = '/Upload/goods/'.$this->upload->data('file_name');
                    }
                }else{
                     if(!empty($data['img'.$i])){
                         if($i == '1'){
                                $data['thumb'] = $data['img'.$i];
                         }
                         $pic[]['bannerPic'] = $data['img'.$i];
                     }
                     unset($data['img'.$i]);
                }
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
        $store_id = $this->session->businessId;
        $store_type = $this->session->businesstype;
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

        $data['page'] = $this->view_goodsAdd;
        $data['menu'] = array('shop','goodsList');       
        $this->load->view('template.html',$data);
    }

    //返回二级分类
    function return_godos_cate(){
        if($_POST){
            $c_id = $_POST['catid'];
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

            $pic = array();
            $i =1;
            foreach($_FILES as $file=>$val){
                if(!empty($_FILES['img'.$i]['name'])){
                    $config['upload_path']      = 'Upload/goods/';
                    $config['allowed_types']    = 'gif|jpg|png|jpeg';
                    $config['max_size']     = 2048;
                    $config['file_name'] = date('Y-m-d_His');
                    $this->load->library('upload', $config);
                    // 上传
                    if(!$this->upload->do_upload('img'.$i)) {
                       echo $this->upload->display_errors();
                    }else{
                        if($i == '1'){
                            $data['thumb'] = '/Upload/goods/'.$this->upload->data('file_name');
                        }
                        $pic[]['bannerPic'] = '/Upload/goods/'.$this->upload->data('file_name');
                        }
                }
                $i++;
             }
             $data['good_pic'] = json_encode($pic);
             $data['storeid'] = $this->session->businessId;
            
            $store = $this->MallShop_model->get_basess_info($this->session->businessId);
            if($store['store_type'] == 1){
                $data['differentiate'] = '1';
            }else{
                $data['differentiate'] = '4';
            }
            
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
          $store_id = $this->session->businessId;
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
                $goods[$currentRow]['storeid'] = $this->session->businessId;
                $store = $this->MallShop_model->get_basess_info($this->session->businessId);
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
    function del_goods(){
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
 
    //商品搜索
    function search_goods(){
        $store_id = $this->session->businessId;
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
            $storeid = $this->session->businessId;
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
            $storeid = $this->session->businessId;
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
          
            $data['storeid'] = $this->session->businessId;
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
        $data['coupon'] = $this->MallShop_model->get_store_coupon($this->session->businessId);
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
            $data['storeid'] = $this->session->businessId;
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
            $coupon = $this->MallShop_model->get_store_coupon($this->session->businessId);
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
            $activity = $this->MallShop_model->get_activity_list($this->session->businessId);
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
        $store_id = $this->session->businessId;
        if(empty($store_id)){
            echo "<script>alert('登录信息过时！请重新登录！');window.location.href='".site_url('/login/index')."'</script>";exit;
        }
        $data['storeid'] = $this->session->businessId;
        $data['page'] = $this->view_shopOrder;
        $data['menu'] = array('shop','shopOrder');
        $this->load->view('template.html',$data);
    }

    //获取商家订单列表
    function store_order(){
        if($_POST){
            //获取卖家id
            $storeid = $_POST['storeid'];
            //h获取订单
            $orders = $this->MallShop_model->get_store_orders($storeid);
          
            if(empty($orders)){
                echo "2";
            }else{
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
        $store_id = $this->session->businessId;
        if(empty($store_id)){
            echo "<script>alert('登录信息过时！请重新登录！');window.location.href='".site_url('/login/index')."'</script>";exit;
        }
        $id = intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
            $data['order'] = $this->MallShop_model->get_order_info($id);
            $data['page'] = $this->view_sureOrder;
            $data['menu'] = array('shop','shopOrder');
            $this->load->view('template.html',$data);
        }
    }
    //订单管理 详情
    function sureOrder(){
        $store_id = $this->session->businessId;
        if(empty($store_id)){
            echo "<script>alert('登录信息过时！请重新登录！');window.location.href='".site_url('/login/index')."'</script>";exit;
        }
        $id = intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
            $data['order'] = $this->MallShop_model->get_order_info($id);
            $data['page'] = $this->view_shopEditOrder;
            $data['menu'] = array('shop','shopOrder');
            $this->load->view('template.html',$data);
        }
    }

    //修改订单细腻
    function edit_store_order(){
        if($_POST){
            $data = $this->input->post();
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
                echo "<script>alert('操作成功！');window.location.href='".site_url('/shop/SingleShop/sureOrder'.$data['order_id'])."'</script>";exit;
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
            // $startMoney = $_POST['startPrice'];
            // $endMoney = $_POST['endPrice'];
            $date = $_POST['date'];
            // $orderid = $_POST['orderid'];
            $username = $_POST['username'];
            // $sear = $_POST['sear'];
            $result = '';
            if(!empty($state) &&  empty($date) && empty($username)){
                // $where = array('seller'=>$storeid,"order_status"=>$state);
                $sql = "SELECT a.order_id,a.order_UUID,a.buyer,a.goods_data,a.seller,a.amount,a.create_time,a.updatetime,a.order_status,b.user_id,b.username,b.nickname from hf_mall_order as a,hf_user_member as b where  order_type = '1' and  a.buyer = b.user_id and seller = '$storeid' and order_status = '$state' order by create_time desc";
                $query = $this->db->query($sql);
                 $result = $query->result_array();
            }else   if(empty($state) &&  !empty($date) && empty($username)){
                     $sql = "SELECT a.order_id,a.order_UUID,a.buyer,a.goods_data,a.seller,a.amount,a.create_time,a.updatetime,a.order_status,b.user_id,b.username,b.nickname from hf_mall_order as a,hf_user_member as b where  order_type = '1' and  a.buyer = b.user_id and seller = '$storeid'  and a.create_time  like '%$date%'  order by create_time desc";
                $query = $this->db->query($sql);
                 $result = $query->result_array();
            }else 
            if(empty($state) && empty($date) && !empty($username)){
                $user = $this->Shop_model->get_user_id($username);
                $userid = $user['user_id'];
                $sql = "SELECT a.order_id,a.order_UUID,a.buyer,a.goods_data,a.seller,a.amount,a.create_time,a.updatetime,a.order_status,b.user_id,b.username,b.nickname from hf_mall_order as a,hf_user_member as b where  order_type = '1' and  a.buyer = b.user_id and seller = '$storeid' and  buyer = '$userid' order by create_time desc";
                $query = $this->db->query($sql);
                 $result = $query->result_array();
            }else if(!empty($state) && empty($date) && !empty($username)){
                    $user = $this->Shop_model->get_user_id($username);
                   $userid = $user['user_id'];
                   $sql = "SELECT a.order_id,a.order_UUID,a.buyer,a.goods_data,a.seller,a.amount,a.create_time,a.updatetime,a.order_status,b.user_id,b.username,b.nickname from hf_mall_order as a,hf_user_member as b where  order_type = '1' and  a.buyer = b.user_id and seller = '$storeid' and order_status = '$state' and  buyer = '$userid' order by create_time desc";
                  $query = $this->db->query($sql);
                   $result = $query->result_array();
            }else if(!empty($state) && !empty($date) && empty($username)){
                   $sql = "SELECT a.order_id,a.order_UUID,a.buyer,a.goods_data,a.seller,a.amount,a.create_time,a.updatetime,a.order_status,b.user_id,b.username,b.nickname from hf_mall_order as a,hf_user_member as b where  order_type = '1' and  a.buyer = b.user_id and seller = '$storeid' and order_status = '$state'   and a.create_time  like '%$date%'   order by create_time desc";
                   $query = $this->db->query($sql);
                   $result = $query->result_array();
            }else if(empty($state) && !empty($date) && !empty($username)){
                   $user = $this->Shop_model->get_user_id($username);
                   $userid = $user['user_id'];
                   $sql = "SELECT a.order_id,a.order_UUID,a.buyer,a.goods_data,a.seller,a.amount,a.create_time,a.updatetime,a.order_status,b.user_id,b.username,b.nickname from hf_mall_order as a,hf_user_member as b where  order_type = '1' and  a.buyer = b.user_id and seller = '$storeid' and a.create_time like '%$date%' and  buyer = '$userid' order by create_time desc";
                   $query = $this->db->query($sql);
                   $result = $query->result_array();
            }else if(!empty($state) && !empty($date) && !empty($username)){
                   $user = $this->Shop_model->get_user_id($username);
                   $userid = $user['user_id'];
                   $sql = "SELECT a.order_id,a.order_UUID,a.buyer,a.goods_data,a.seller,a.amount,a.create_time,a.updatetime,a.order_status,b.user_id,b.username,b.nickname from hf_mall_order as a,hf_user_member as b where  order_type = '1' and  a.buyer = b.user_id and seller = '$storeid' and order_status = '$state' and a.create_time like '%$date%' and  buyer = '$userid' order by create_time desc";
                   $query = $this->db->query($sql);
                   $result = $query->result_array();
            }else{
                    $sql = "SELECT a.order_id,a.order_UUID,a.buyer,a.goods_data,a.seller,a.amount,a.create_time,a.updatetime,a.order_status,b.user_id,b.username,b.nickname from hf_mall_order as a,hf_user_member as b where  order_type = '1' and  a.buyer = b.user_id and seller = '$storeid' order by create_time desc";
                   $query = $this->db->query($sql);
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

   
