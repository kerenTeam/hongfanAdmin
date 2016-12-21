<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  商家管理
 *
 * */
require_once(APPPATH.'controllers/default_Controller.php');

class singleShop extends default_Controller {
    //商家 列表主页
    public $view_shopAdmin = "shop/shopAdmin.html";
    //商家基础信息
    public $view_shopBaseInfo = "shop/shopBaseInfo.html";
    //商家简介
    public $view_shopInfo = "shop/shopInfo.html";
    //商品列表
    public $view_goodsList = "shop/goodsList.html"; 
    //商品详情
    public $view_goodsDetail = "shop/goodsDetail.html"; 
    //新增商品
    public $view_goodsAdd = "shop/goodsAdd.html"; 
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
    //评论
    public $view_shopComment = "shop/shopComment.html";
    function __construct()
    {
        parent::__construct();
        $this->load->model('mallShop_model');
        $this->load->model('shop_model');
    }

    //商家 列表主页
    function shopAdmin()
    {   //缓存商家id
        $id = intval($this->uri->segment(4));
        if($id == 0){
            //商家登录
            $storeid = $this->mallShop_model->get_store_list($this->session->users['user_id']);
             $this->session->set_userdata('businessId',$storeid['store_id']);
             
        }else{
            $this->session->set_userdata('businessId',$id);
        }

        $data['page'] = $this->view_shopAdmin;
    	$this->load->view('template.html',$data);
    }
    //商家基础信息
    function shopBaseInfo(){

        //获取商家信息
       $store = $this->mallShop_model->get_basess_info($this->session->businessId);
        //获取商家登录账户
         $data['user'] = $this->shop_model->get_login_store($store['business_id']);
       
          $data['busin'] = $store; 
        //返回所有一级业态
        $data['yetai'] = $this->shop_model->store_type_level();

        $data['page'] = $this->view_shopBaseInfo;
        $data['menu'] = array('shop','shopBaseInfo');       
        $this->load->view('template.html',$data);
    }
    //根据顶级业态返回
    function shop_store_type(){
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

    //商家基础信息操作
    function edit_busin_info(){
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
            $pic = array();
            $i =1;
            foreach($_FILES as $file=>$val){
                if(!empty($_FILES['img'.$i]['name'])){
                    $config['upload_path']      = 'upload/logo/';
                    $config['allowed_types']    = 'gif|jpg|png|jpeg';
                    $config['max_size']     = 2048;
                    $config['file_name'] = date('Y-m-d_His');
                    $this->load->library('upload', $config);
                    // 上传
                    if(!$this->upload->do_upload('img'.$i)) {
                       echo $this->upload->display_errors();
                    }else{
                        if($i == 1){
                            $data['logo'] = 'upload/logo/'.$this->upload->data('file_name');
                        }else{
                            $data['pic'] = 'upload/logo/'.$this->upload->data('file_name');
                        }
                       
                        unset($data['img'.$i]);
                    }
                }else{
                    if($i == 1){
                        $data['logo'] = $data['img'.$i];
                    }else{
                        $data['pic'] = $data['img'.$i];
                    }
                     
                     unset($data['img'.$i]);
                }
                $i++;
             }
            if($this->shop_model->edit_store_member($arr['user_id'],$arr)){
                 if($this->mallShop_model->edit_store_info($data['store_id'],$data)){
                   echo "<script>alert('操作成功！');window.location.href='".site_url('/shop/singleShop/shopBaseInfo')."'</script>";exit;
                   // echo "23";
                 }else{
                    echo "<script>alert('操作失败！');window.location.href='".site_url('/shop/singleShop/shopBaseInfo')."'</script>";exit;
                 }
            }
        }else{
            $this->load->view('404.html');
        }
    }
    //  //商品列表
    function goodsList(){
        //分类
        $data['cates'] = $this->mallShop_model->get_goods_cates();
        $data['page'] = $this->view_goodsList;
        $data['menu'] = array('shop','goodsList');
        $this->load->view('template.html',$data);
    }

    //返回商家商品列表
    function store_goods_list(){
        if($_POST){
            //查询出商家店铺
           $arr = $this->mallShop_model->get_goods_list($this->session->businessId);
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
            if($this->mallShop_model->edit_goods_state($goods_id,$data)){
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
        $id = intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
            $data['goods'] = $this->mallShop_model->get_goodsInfo($id);
            //所有商品分类
            $data['cates'] = $this->mallShop_model->get_goods_cates();
            $data['page'] = $this->view_goodsDetail;
            $data['menu'] = array('shop','goodsList');       
            $this->load->view('template.html',$data);
        }
    }
    //获取商品评价
    function get_goods_comment(){
        if($_POST){
            $goodsid = $_POST['goodsid'];
            $comment = $this->mallShop_model->get_goods_comment($goodsid);
            if(empty($comment)){
                echo '2';
            }else{
                foreach ($comment as $key => $value) {
                   $comment[$key]['reply'] = $this->mallShop_model->gte_store_reply($value['id']);
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
            $pic = array();
            $i =1;
            foreach($_FILES as $file=>$val){
                if(!empty($_FILES['img'.$i]['name'])){
                    $config['upload_path']      = 'upload/goods/';
                    $config['allowed_types']    = 'gif|jpg|png|jpeg';
                    $config['max_size']     = 2048;
                    $config['file_name'] = date('Y-m-d_His');
                    $this->load->library('upload', $config);
                    // 上传
                    if(!$this->upload->do_upload('img'.$i)) {
                       echo $this->upload->display_errors();
                    }else{
                        if($i == '1'){
                            $data['thumb'] = 'upload/goods/'.$this->upload->data('file_name');
                        }
                        $pic[]['bannerPic'] = 'upload/goods/'.$this->upload->data('file_name');
                        unset($data['img'.$i]);
                    }
                }else{
                    if($i == '1'){
                            $data['thumb'] = $data['img'.$i];
                    }
                     $pic[]['bannerPic'] = $data['img'.$i];
                     unset($data['img'.$i]);
                }
                $i++;
             }
             $data['good_pic'] = json_encode($pic);
             if($this->mallShop_model->edit_goods($data['goods_id'],$data)){
                 echo "<script>alert('操作成功！');window.location.href='".site_url('/shop/singleShop/goodsList')."'</script>";exit;
             }else{
                 echo "<script>alert('操作失败！');window.location.href='".site_url('/shop/singleShop/goodsDetail').$data['id']."'</script>";exit;
             }
        }else{
            $this->load->view('404.html');
        }
    }

     //新增商品
    function goodsAdd(){
        //所有商品分类
        $data['cates'] = $this->mallShop_model->get_goods_cates();

        $data['page'] = $this->view_goodsAdd;
        $data['menu'] = array('shop','goodsList');       
        $this->load->view('template.html',$data);
    }
    //新增商品操作
    function add_goods(){
        if($_POST){
            $data= $this->input->post();
            $pic = array();
            $i =1;
            foreach($_FILES as $file=>$val){
                if(!empty($_FILES['img'.$i]['name'])){
                    $config['upload_path']      = 'upload/goods/';
                    $config['allowed_types']    = 'gif|jpg|png|jpeg';
                    $config['max_size']     = 2048;
                    $config['file_name'] = date('Y-m-d_His');
                    $this->load->library('upload', $config);
                    // 上传
                    if(!$this->upload->do_upload('img'.$i)) {
                       echo $this->upload->display_errors();
                    }else{
                        if($i == '1'){
                            $data['thumb'] = 'upload/goods/'.$this->upload->data('file_name');
                        }
                        $pic[]['bannerPic'] = 'upload/goods/'.$this->upload->data('file_name');
                        }
                }
                $i++;
             }
             $data['good_pic'] = json_encode($pic);
             $data['storeid'] = $this->session->businessId;
             $data['differentiate'] = '1';
             if($this->mallShop_model->add_shop_goods($data)){
                echo "<script>alert('操作成功！');window.location.href='".site_url('/shop/singleShop/goodsList')."'</script>";exit;
             }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/shop/singleShop/goodsAdd')."'</script>";exit;
             }
        }else{
            $this->load->view('404.html');
        }
    }

    //商家导入商品
    function impolt_goods(){
        if(!empty($_FILES["file"]["tmp_name"])){
            $name = date('Y-m-d');
            $inputFileName = "./upload/xls/" .$name .'.xls';
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
                $myFileName = 'upload/goods/'.date('His').++$i.'.'.$extension;
                file_put_contents($myFileName,$imageContents);
                $arr[$codata][]['bannerPic'] = $myFileName;
            }
           $allColumn = $currentSheet->getHighestColumn(); //取得最大的列号
           $allRow = $currentSheet->getHighestRow(); //取得一共有多少行
           $erp_orders_id = array();  //声明数组
          for($currentRow = 2;$currentRow <= $allRow;$currentRow++){
            $data['title'] = $PHPExcel->getActiveSheet()->getCell("A".$currentRow)->getValue();//获取A列的值
            if($data['title'] == NULL){
                unlink($inputFileName);
                exit;
            }
            $data['brand'] = $PHPExcel->getActiveSheet()->getCell("B".$currentRow)->getValue();//获取B列的值
            //分类
            $cate = $PHPExcel->getActiveSheet()->getCell("C".$currentRow)->getValue();//获取c列的值
            //根据名称返回分类
            $cateid = $this->mallShop_model->get_cate_id($cate);
            if(empty($cateid)){
                //新增分类
                $cates = array('catname'=>$cate);
                $cateid = $this->mallShop_model->add_cate($cates);
            }
            $data['categoryid'] = $cateid;
            $data['price'] = $PHPExcel->getActiveSheet()->getCell("D".$currentRow)->getValue();//获取c列的值 
            $data['amount'] = $PHPExcel->getActiveSheet()->getCell("E".$currentRow)->getValue();//获取c列的值 
            $data['goods_state'] = $PHPExcel->getActiveSheet()->getCell("F".$currentRow)->getValue();//获取c列的值
            $shuxing = $PHPExcel->getActiveSheet()->getCell("G".$currentRow)->getValue();//获取c列的值
            //商品属性
            if(!empty($shuxing)){
                $abc = explode(".",trim($shuxing));
                foreach ($abc as $key => $value) {
                  $parameter_name =  explode(":",trim($value));
                  $parameterName[$key] = $parameter_name[0];
                  $check = explode(",",trim($parameter_name[1]));
                  foreach ($check as $k => $v) {
                      $val[$k] = explode("|",trim($v));
                      $checkvalue[$key][$k]['child_parameter_name'] = $val[$k][0];
                      $checkvalue[$key][$k]['equivalence'] = $val[$k][1];
                      $checkvalue[$key][$k]['Inventory'] = $val[$k][2];
                  }
                }
                foreach ($parameterName as $key => $value) {
                   $property[$key]['parameter_name'] = $value;
                   $property[$key]['child_value'] = $checkvalue[$key];
                }
                $data['parameter'] = json_encode($property,JSON_UNESCAPED_UNICODE);
            }else{
                $data['parameter'] = '';
            }
            //缩略图
            if(isset($arr['H'.$currentRow])){
                 $data['thumb'] = $arr['H'.$currentRow][0]['bannerPic'];
            }else{
                $data['thumb'] = '';
            } 
            //商品banner
            if(isset($arr['I'.$currentRow])){
                 $data['good_pic'] = json_encode($arr['I'.$currentRow]);
            }else{
                $data['good_pic'] = '';
            }
           
            $data['content'] =$PHPExcel->getActiveSheet()->getCell("J".$currentRow)->getValue(); 
            $data['storeid'] = $this->session->businessId;
          
            //新增
            $this->mallShop_model->add_shop_goods($data);

            echo "1";
           }
        }else{
           $this->load->view('404.html'); 
        }
    }


    //商品删除
    function del_goods(){
        if($_POST){
            $id = $_POST['goodsid'];
            if($this->mallShop_model->del_goods($id)){
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
        if($_POST){
            $cate = $_POST['cateid'];
            $storeid = $this->session->businessId;
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
            $sear = $_POST['sear'];
            $differentiate = '1';
            $res = search_store_goods($storeid,$cate,$startPrice,$endPrice,$startRepertory,$endRepertory,$state,$sear,$differentiate);
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
            $comment = $this->mallShop_model->get_store_comment($storeid);
            if(empty($comment)){
                echo "2";
            }else{
            //回复
            foreach ($comment as $key => $value) {
               $comment[$key]['reply'] = $this->mallShop_model->gte_store_reply($value['id']);
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
            if($this->mallShop_model->edit_comment_state($id,$data)){
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
                $a = $this->mallShop_model->del_store_comment($v);
            }

            if($a){
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
            $a = $this->mallShop_model->del_store_comment($commentid);
            if($a){
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
            $data = $this->mallShop_model->get_store_coupon($storeid);
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
            $code = implode(guid('1','','8'));
            //erweima 
            $data['qrcode'] = generate_promotion_code($code);
            //优惠码
            $data['codeNumber'] = $code;
            $data['storeid'] = $this->session->businessId;
            if($this->mallShop_model->add_coupon($data)){
                echo "<script>alert('操作成功！');window.location.href='".site_url('/shop/singleShop/shopSalesList')."'</script>";
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/shop/singleShop/shopAddSales')."'</script>";
            }
        }else{
            $this->load->view('404.html');
        }
    }
    //商家优惠劵管理 新增优惠劵
    function shopAddSales(){
        //获取优惠劵类型
        $data['coupon'] = $this->mallShop_model->get_coupon_type();
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
            if($this->mallShop_model->edit_coupon($data['id'],$data)){
                echo "<script>alert('操作成功！');window.location.href='".site_url('/shop/singleShop/shopSalesList')."'</script>";
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/shop/singleShop/shopEditSales/').$data['id']."'</script>";
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
            $data['coupon'] = $this->mallShop_model->get_conpon_info($id);
            $data['page'] = $this->view_shopEditSales;
            $data['menu'] = array('sales','shopSalesList');
            $this->load->view('template.html',$data);
        }
    }
    //删除优惠劵
    function delshopSales(){
        if($_POST){
            $id = $_POST['id'];
            if($this->mallShop_model->del_coupon($id)){
                echo "1";
            }else{
                echo "2";
            }
        }else{
            echo "2";
        }
    }


    //商家活动管理 活动列表
    function shopActivityList(){
        $data['page'] = $this->view_shopActivityList;
        $data['menu'] = array('activity','shopActivityList');
        $this->load->view('template.html',$data);
    }
     //商家活动管理 添加活动
    function shopAddActivity(){
         $data['page'] = $this->view_shopAddActivity;
        $data['menu'] = array('activity','shopAddActivity');
        $this->load->view('template.html',$data);
    }
     //商家活动管理 编辑活动
    function shopEditActivity(){
         $data['page'] = $this->view_shopEditActivity;
        $data['menu'] = array('activity','shopActivityList');
        $this->load->view('template.html',$data);
    }


    //商家订单管理
    function shopOrder(){
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
            $orders = $this->mallShop_model->get_store_orders($storeid);
          
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
            $orderid = $_POST['orderid'];
            if($this->mallShop_model->edit_order_state($orderid,$data)){
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
            $orderid= $_POST['orderid'];
            if($this->mallShop_model->edit_order_state($orderid,$data)){
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
        $id = intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
            $data['order'] = $this->mallShop_model->get_order_info($id);

            $data['page'] = $this->view_sureOrder;
            $data['menu'] = array('shop','shopOrder');
            $this->load->view('template.html',$data);
        }
    }
    //订单管理 详情
    function sureOrder(){

        $id = intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
            $data['order'] = $this->mallShop_model->get_order_info($id);
            $data['page'] = $this->view_shopEditOrder;
            $data['menu'] = array('shop','shopOrder');
            $this->load->view('template.html',$data);
        }
      
    }
    //订单搜索
    function order_search(){     
        if($_POST){
            $storeid = $_POST['storeid'];
            $state = $_POST['state'];
            $startMoney = $_POST['startPrice'];
            $endMoney = $_POST['endPrice'];
            $date = $_POST['date'];
            // $orderid = $_POST['orderid'];
            $username = $_POST['username'];
            // $sear = $_POST['sear'];
            $result = '';
            if(!empty($state) && empty($startMoney) && empty($date) && empty($username)){
                $where = array('seller'=>$storeid,"order_status"=>$state);
                $query = $this->db->where($where)->order_by('create_time','desc')->get('hf_mall_order');
                 $result = $query->result_array();
            }else 
            if(empty($state) && !empty($startMoney) && empty($date) && empty($username)){
                echo "23";
                $query = $this->db->where('seller',$storeid)->where('amount>=',$startMoney)->where('amount<=',$endMoney)->order_by('create_time','desc')->get('hf_mall_order');
                 $result = $query->result_array();
            }else 
            if(empty($state) && empty($startMoney) && !empty($date) && empty($username)){
                $where = array('seller'=>$storeid,'create_time'=>$date);
                $query = $this->db->where($where)->order_by('create_time','desc')->get('hf_mall_order');
                 $result = $query->result_array();
            }else
            // if(empty($state) && empty($startMoney) && empty($date) &&  empty($username)){
            //     $where = array('seller'=>$storeid,'order_id'=>$orderid);
            //     $query = $this->db->where($where)->order_by('create_time','desc')->get('hf_mall_order');
             //$result = $query->result_array();
            // }else
            if(empty($state) && empty($startMoney) && empty($date) && !empty($username)){
                $user = $this->shop_model->get_user_id($username);
                $where = array('seller'=>$storeid,'buyer'=>$user['user_id']);
                $query = $this->db->where($where)->order_by('create_time','desc')->get('hf_mall_order');
                 $result = $query->result_array();
            }else
            if(!empty($state) && !empty($startMoney) && empty($date) && empty($username)){
                $query = $this->db->where('seller',$storeid)->where('order_status',$state)->where('amount>=',$startMoney)->where('amount<=',$endMoney)->order_by('create_time','desc')->get('hf_mall_order');
                 $result = $query->result_array();
            }else
            if(!empty($state) && empty($startMoney) && !empty($date) && empty($username)){
                $query = $this->db->where('seller',$storeid)->where('order_status',$state)->where('create_time',$date)->order_by('create_time','desc')->get('hf_mall_order');
                 $result = $query->result_array();
            }else
            if (!empty($state) && empty($startMoney) && empty($date) && !empty($username)) {
                 $user = $this->shop_model->get_user_id($username);
                $query = $this->db->where('seller',$storeid)->where('order_status',$state)->where('buyer',$user['user_id'])->order_by('create_time','desc')->get('hf_mall_order');
                 $result = $query->result_array();
            }else
            if(empty($state) && !empty($startMoney) && !empty($date) && empty($username)){
                 $query = $this->db->where('seller',$storeid)->where('create_time',$date)->where('amount>=',$startMoney)->where('amount<=',$endMoney)->order_by('create_time','desc')->get('hf_mall_order');
                  $result = $query->result_array();
            }else
            if(empty($state) && !empty($startMoney) && empty($date) && !empty($username)){
                  $user = $this->shop_model->get_user_id($username);
                $query = $this->db->where('seller',$storeid)->where('buyer',$user['user_id'])->where('amount>=',$startMoney)->where('amount<=',$endMoney)->order_by('create_time','desc')->get('hf_mall_order');
                 $result = $query->result_array();
            }else
            if(empty($state) && empty($startMoney) && !empty($date) && !empty($username)){
                $user = $this->shop_model->get_user_id($username);
                  $query = $this->db->where('seller',$storeid)->where('buyer',$user['user_id'])->where('create_time',$date)->order_by('create_time','desc')->get('hf_mall_order');
                   $result = $query->result_array();
            }else
            if(!empty($state) && !empty($startMoney) && !empty($date) && empty($username)){
                $query = $this->db->where('seller',$storeid)->where('order_status',$state)->where('create_time',$date)->where('amount>=',$startMoney)->where('amount<=',$endMoney)->order_by('create_time','desc')->get('hf_mall_order');
                 $result = $query->result_array();
            }else
            if(!empty($state) && !empty($startMoney) && empty($date) && !empty($username)){
                 $user = $this->shop_model->get_user_id($username);
                  $query = $this->db->where('seller',$storeid)->where('buyer',$user['user_id'])->where('order_status',$state)->where('amount>=',$startMoney)->where('amount<=',$endMoney)->order_by('create_time','desc')->get('hf_mall_order');
                   $result = $query->result_array();
            }else
            if(empty($state) && !empty($startMoney) && !empty($date) && !empty($username)){
                 $user = $this->shop_model->get_user_id($username);
                  $query = $this->db->where('seller',$storeid)->where('buyer',$user['user_id'])->where('amount>=',$startMoney)->where('amount<=',$endMoney)->where('create_time',$date)->order_by('create_time','desc')->get('hf_mall_order');
                   $result = $query->result_array();
            }else 
            if(!empty($state) && !empty($startMoney) && !empty($date) && !empty($username)){
                $user = $this->shop_model->get_user_id($username);
                $query = $this->db->where('seller',$storeid)->where('order_status',$state)->where('buyer',$user['user_id'])->where('amount>=',$startMoney)->where('amount<=',$endMoney)->where('create_time',$date)->order_by('create_time','desc')->get('hf_mall_order');
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
}

