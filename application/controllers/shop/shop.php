<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  商城管理
 *
 * */
require_once(APPPATH.'controllers/Default_Controller.php');
class Shop extends Default_Controller {
    //场外商家首页
    public $view_shopIndex = "shop/shopList.html";
    //场内商家首页
    public $view_market_shop = "moll/marketList.html";
    //新增商家
    public $view_addShop = "shop/addShop.html";
    //编辑商家
    public $view_EditShop = "shop/editShop.html";
    //达人探店
    public $view_findshop = "moll/findshop.html";
    //新增商场商家
    public $view_add_store = "moll/addstore.html";
    //编辑商场商家
    public $view_edit_store = "moll/editstore.html";

    function __construct()
    {
        parent::__construct();
        //model
        $this->load->model('Shop_model');
        $this->load->model('MallShop_model');
    }

    //商家 列表主页
    function index()
    {  
        $id = intval($this->uri->segment(4));
        if($id == 0){
            $find = '';
        }else{
            $find = $id;
        }
        $data['find'] = $find;
        //获取一级业态
         $data['yetai'] = $this->Shop_model->store_type_level();
         $data['page'] = $this->view_shopIndex;
         $data['menu'] = array('store','shopList');
    	 $this->load->view('template.html',$data);
    }

    //返回场内商家列表信息
    function marketBusiness(){
        $id = intval($this->uri->segment(4));
        if($id == 0){
            $find = '';
        }else{
            $find = $id;
        }
        $data['find'] = $find;
        $data['yetai'] = $this->Shop_model->store_type_level();
        $data['page'] = $this->view_market_shop;
        $data['menu'] = array('moll','marketBusiness');
        $this->load->view('template.html',$data);
    }

    //返回场外商家列表信息
    function return_shop_page(){
         if($_POST){
            $type = $_POST['typeid'];
            $list = $this->Shop_model->shop_list($type);
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
            if(empty($list)){
                echo "2";
            }else{
                echo json_encode($list);
            }

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
                    $arr['goods_state'] = '1';
                    //修改商家商品信息
                    if($this->Shop_model->edit_goods_state($id,$arr)){
                        if($this->Shop_model->edit_shop_state($id,$data)){
                            //日志
                            $log = array(
                                'userid'=>$_SESSION['users']['user_id'],  
                                "content" => $_SESSION['users']['username']."修改了一个商家状态为正常,商家id是".$id,
                                "create_time" => date('Y-m-d H:i:s'),
                                "userip" => get_client_ip(),
                            );
                            $this->db->insert('hf_system_journal',$log);
                            echo "1";
                        }else{
                            echo "2";
                        }
                    }
                    break;
                case '2':
                    $data['state'] = '0';
                         $arr['goods_state'] = '1';
                    //修改商家商品信息
                    if($this->Shop_model->edit_goods_state($id,$arr)){
                        if($this->Shop_model->edit_shop_state($id,$data)){
                             //日志
                            $log = array(
                                'userid'=>$_SESSION['users']['user_id'],  
                                "content" => $_SESSION['users']['username']."修改了一个商家状态为冻结，包括该商家下所有商品,商家id是".$id,
                                "create_time" => date('Y-m-d H:i:s'),
                                "userip" => get_client_ip(),
                            );
                            $this->db->insert('hf_system_journal',$log);
                            echo "1";
                        }else{
                            echo "2";
                        }
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
              $store = $this->Shop_model->get_store_Info($id);
            //删除商品
            if($this->Shop_model->del_store_goods($id)){
                //删除商家
                if($this->Shop_model->del_shop_store($id)){
                     //日志
                    $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  
                        "content" => $_SESSION['users']['username']."删除了一个商家,商家id是".$id,
                        "create_time" => date('Y-m-d H:i:s'),
                        "userip" => get_client_ip(),
                    );
                    $this->db->insert('hf_system_journal',$log);
                    //删除登陆账户
                    $this->Shop_model->del_shop_member($store['business_id']);
                    echo "1";
                }else{
                    echo "2";
                }
            }
        }else{
            echo "2";
        }
    }

    //商家管理
    function shop_admin(){

    	 $this->load->view('shop/shopInfo.html');
    }

    //新增场内商家
    function add_market_shop(){
        $data['type'] = '1';
        $data['yetai'] = $this->Shop_model->store_type_level(); 
        $data['page'] = $this->view_add_store;
        $data['menu'] = array('moll','marketBusiness');
        $this->load->view('template.html',$data);
    }

    //新增场外商家
    function addShop(){
        //获取所有业态
        $data['type'] = '2';
        $data['yetai'] = $this->Shop_model->store_type_level(); 
        $data['page'] = $this->view_addShop;
        $data['menu'] = array('store','shopList');
        $this->load->view('template.html',$data);
       
    }

    //编辑商场商家
    function edit_store(){
        $id = intval($this->uri->segment(4));
        if($id  == '0'){
            $this->db->view('404,html');
        }else{
             $store = $this->MallShop_model->get_basess_info($id);
             //获取商家登录账户
             $data['user'] = $this->Shop_model->get_login_store($store['business_id']);
          
             $data['busin'] = $store; 
             //返回所有一级业态
             $data['yetai'] = $this->Shop_model->store_type_level();

             $data['page'] = $this->view_edit_store;
             $data['menu'] = array('moll','marketBusiness');       
             $this->load->view('template.html',$data);
         }
    }
    // 编辑商场商家
    function edit_store_info(){
        if($_POST){
            $data = $this->input->post();
            $arr['username'] = trim($this->input->post('username'));
            $arr['phone'] = trim($this->input->post('username'));
            $arr['password'] =trim($this->input->post('password'));
            $arr['user_id'] = $this->input->post('user_id');
            if(!empty($arr['password'])){
                $arr['password'] = md5($arr['password']);
            }else{
                unset($arr['password']);
            }
            unset($data['username'],$data['password'],$data['user_id']);
            if($this->Shop_model->get_member_info($arr['user_id'],$arr['username'])){
                echo "<script>alert('账户已被注册！');window.location.href='".site_url('/shop/Shop/edit_store/'.$data['store_id'])."'</script>";exit;
            }
                //修改登录账户
            if($this->Shop_model->edit_store_member($arr['user_id'],$arr)){
                unset($data['password'],$data['username']);

                if(!empty($_FILES['img1']['name'])){
                    $config['upload_path']      = 'Upload/logo/';
                    $config['allowed_types']    = 'gif|jpg|png|jpeg';
                    $config['max_size']     = 2048;
                    $config['file_name'] = date('Y-m-d_His');
                    $this->load->library('upload', $config);
                    // 上传
                    if(!$this->upload->do_upload('img1')) {
                        echo "<script>alert('图片上传失败！');window.location.href='".site_url('/shop/Shop/edit_store/'.$data['store_id'])."'</script>";exit;
                    }else{
                            $data['logo'] = '/Upload/logo/'.$this->upload->data('file_name');
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
                        echo "<script>alert('图片上传失败！');window.location.href='".site_url('/shop/Shop/edit_store/'.$data['store_id'])."'</script>";exit;
                    }else{
                        $data['pic'] = '/Upload/logo/'.$this->upload->data('file_name');
                    }
                }
     
                if($this->MallShop_model->edit_store_info($data['store_id'],$data)){
                     //日志
                    $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  
                        "content" => $_SESSION['users']['username']."编辑了一个商家,商家id是".$data['store_id'].",商家名称是：".$data['store_name'],
                        "create_time" => date('Y-m-d H:i:s'),
                        "userip" => get_client_ip(),
                    );
                    $this->db->insert('hf_system_journal',$log);
                   echo "<script>alert('操作成功！');window.location.href='".site_url('/shop/Shop/marketBusiness')."'</script>";exit;
                   // echo "23";
                }else{
                        echo "<script>alert('操作失败！');window.location.href='".site_url('/shop/Shop/edit_store/'.$data['store_id'])."'</script>";exit;
                
                }
            }
        }else{
            $this->load->view('404.html');
        }
    }
 


    //新增场内商家
    function add_storeInfo(){
        if($_POST){
            $data = $this->input->post();
            $arr['username'] = trim($this->input->post('username'));
            $arr['phone'] = trim($this->input->post('username'));
            $arr['gid'] = '2';
            $arr['password'] = md5(trim($this->input->post('password')));
            $username = $this->Shop_model->get_user_info($arr['username']);
            if(!empty($username)){
                    echo "<script>alert('账户已被注册！');window.location.href='".site_url('/shop/Shop/add_market_shop')."'</script>";exit; 
            }
            //新增商家用户账号
           $userid = $this->Shop_model->add_store_member($arr);
           if(!empty($userid)){
                $data['business_id'] = $userid;
                $data['send_userid'] = $_SESSION['users']['user_id'];
                $data['create_time'] = date('Y-m-d');
                unset($data['password'],$data['username']);

                if(!empty($_FILES['img1']['name'])){
                    $config['upload_path']      = 'Upload/logo/';
                    $config['allowed_types']    = 'gif|jpg|png|jpeg';
                    $config['max_size']     = 2048;
                    $config['file_name'] = date('Y-m-d_His');
                    $this->load->library('upload', $config);
                    // 上传
                    if(!$this->upload->do_upload('img1')) {
                        echo "<script>alert('图片上传失败！');window.location.href='".site_url('/shop/Shop/add_market_shop')."'</script>";exit;
                    }else{
                            $data['logo'] = '/Upload/logo/'.$this->upload->data('file_name');
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
                        echo "<script>alert('图片上传失败！');window.location.href='".site_url('/shop/Shop/add_market_shop')."'</script>";exit;
                    }else{
                        $data['pic'] = '/Upload/logo/'.$this->upload->data('file_name');
                    }
                }
                 if($this->Shop_model->add_store($data)){
                   //日志
                    $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  
                        "content" => $_SESSION['users']['username']."新增了一个场内商家,商家名称是：".$data['store_name'],
                        "create_time" => date('Y-m-d H:i:s'),
                        "userip" => get_client_ip(),
                    );
                    $this->db->insert('hf_system_journal',$log);
                   echo "<script>alert('操作成功！');window.location.href='".site_url('/shop/Shop/marketBusiness')."'</script>";exit;
               // echo "23";
             }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/shop/Shop/add_market_shop')."'</script>";exit;
             }
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/shop/Shop/add_market_shop')."'</script>";exit;
            }
           
        }else{
            $this->db->view('404.html');
        }
    }


    //新增商家操作
    function add_shop_store(){
        if($_POST){
            $data = $this->input->post();
            $arr['username'] = trim($this->input->post('username'));
            $arr['gid'] = '2';
            $arr['password'] = md5(trim($this->input->post('password')));
            $username = $this->Shop_model->get_user_info($arr['username']);
            if(!empty($username)){
                if($data['store_distinction'] == '2'){
                    echo "<script>alert('账户已被注册！');window.location.href='".site_url('/shop/Shop/addShop')."'</script>";exit;
                }else{
                    echo "<script>alert('账户已被注册！');window.location.href='".site_url('/shop/Shop/add_market_shop')."'</script>";exit; 
                }
            }
            //新增商家用户账号
           $userid = $this->Shop_model->add_store_member($arr);
           if(!empty($userid)){
                $data['business_id'] = $userid;
                $data['send_userid'] = $_SESSION['users']['user_id'];
                $data['create_time'] = date('Y-m-d');
                unset($data['password'],$data['username']);
                if($data['store_distinction'] == '2'){
                    if($this->Shop_model->add_store_info($data)){
                            //日志
                            $log = array(
                                'userid'=>$_SESSION['users']['user_id'],  
                                "content" => $_SESSION['users']['username']."新增了一个电商商家,商家名称是：".$data['store_name'],
                                "create_time" => date('Y-m-d H:i:s'),
                                "userip" => get_client_ip(),
                            );
                            $this->db->insert('hf_system_journal',$log);
                         echo "<script>alert('操作成功！');window.location.href='".site_url('/shop/Shop/index')."'</script>";exit;
                    }else{
                        echo "<script>alert('操作失败！');window.location.href='".site_url('/shop/Shop/addShop')."'</script>";exit;
                    }
                }else{
                    if($this->Shop_model->add_store_info($data)){
                         //日志
                            $log = array(
                                'userid'=>$_SESSION['users']['user_id'],  
                                "content" => $_SESSION['users']['username']."新增了一个电商商家,商家名称是：".$data['store_name'],
                                "create_time" => date('Y-m-d H:i:s'),
                                "userip" => get_client_ip(),
                            );
                            $this->db->insert('hf_system_journal',$log);
                         echo "<script>alert('操作成功！');window.location.href='".site_url('/shop/Shop/marketBusiness')."'</script>";exit;
                    }else{
                        echo "<script>alert('操作失败！');window.location.href='".site_url('/shop/Shop/add_market_shop')."'</script>";exit;
                    } 
                }
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/shop/Shop/addShop')."'</script>";exit;
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
            $data['yetai'] = $this->Shop_model->store_type_level();
            //获取商家信息
            $store = $this->Shop_model->get_store_Info($id);
            //获取账户
            $data['user'] = $this->Shop_model->get_login_store($store['business_id']);
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
            $arr['user_id'] = $this->input->post('user_id');
            if(!empty($arr['password'])){
                $arr['password'] = md5($arr['password']);
            }else{
                unset($arr['password']);
            }
            unset($data['username'],$data['password'],$data['user_id']);
            if($this->Shop_model->get_member_info($arr['user_id'],$arr['username'])){
                echo "<script>alert('账户已被注册！');window.location.href='".site_url('/shop/Shop/editShop/'.$data['store_id'])."'</script>";exit;
            }
                //修改登录账户
            if($this->Shop_model->edit_store_member($arr['user_id'],$arr)){
                if($this->Shop_model->edit_store_info($data['store_id'],$data)){
                     //日志
                    $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  
                        "content" => $_SESSION['users']['username']."编辑了一个电商商家,商家id是：".$data['store_id'],
                        "create_time" => date('Y-m-d H:i:s'),
                        "userip" => get_client_ip(),
                    );
                    $this->db->insert('hf_system_journal',$log);
                    if($data['store_distinction'] == '2'){
                     echo "<script>alert('操作成功！');window.location.href='".site_url('/shop/Shop/index')."'</script>";exit;
                    }else{
                        echo "<script>alert('操作成功！');window.location.href='".site_url('/shop/Shop/marketBusiness')."'</script>";exit;
                    }
                }else{
                    echo "<script>alert('操作失败！');window.location.href='".site_url('/shop/Shop/editShop/'.$data['store_id'])."'</script>";exit;
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

    //达人探店
    function findshop(){
        $list = $this->Shop_model->get_find_shop();
        foreach ($list as $key => $value) {
            $store_list = explode(',',$value['store_list']);
            foreach ($store_list as $k => $v) {
                $list[$key]['store'][] = $this->Shop_model->get_store_find($v);
            }
        }
        $data['find'] = $list;
        $data['page'] = $this->view_findshop;
        $data['menu']= array('store','findshop');
        $this->load->view('template.html',$data);
     }

     //新增推荐商家
     function add_find_store(){
        if($_POST){
            $id = $_POST['id'];
            $store_id = json_decode($_POST['storeid'],true);
            $sale = $this->Shop_model->get_sales_info($id);
            $stores = explode(',',$sale['store_list']);
            $arr = array_unique(array_merge($store_id,$stores));
            $data['store_list'] = implode(',',$arr);
            if($this->Shop_model->edit_salse($id,$data)){
                   $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  
                        "content" => $_SESSION['users']['username']."新增了一个推荐商家,id是：".$id,
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

     //删除某个推荐商家
     function del_find_store(){
        if($_POST){
            $id = $_POST['id'];
            $storeid = $_POST['storeid'];
            if(empty($id) || empty($storeid)){
                echo "2";
            }else{
                $sale = $this->Shop_model->get_sales_info($id);
                $store = explode(',',$sale['store_list']);
                foreach ($store as $key => $value) {
                   if($value == $storeid){
                     unset($store[$key]);
                   }
                }
                $data['store_list'] = implode(',',$store);
                if($this->Shop_model->edit_salse($id,$data)){
                    $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  
                        "content" => $_SESSION['users']['username']."删除了一个推荐商家,id是：".$storeid,
                        "create_time" => date('Y-m-d H:i:s'),
                        "userip" => get_client_ip(),
                    );
                    $this->db->insert('hf_system_journal',$log);
                    echo "1";
                }else{
                    echo "2";
                }
            }
        }else{
            echo "2";
        }
     }

     //修改推荐详情
     function edit_find_info(){
        if($_POST){
            $data= $this->input->post();
            if(!empty($_FILES['img']['tmp_name'])){
                $config['upload_path']      = 'Upload/adver/';
                $config['allowed_types']    = 'gif|jpg|png|jpeg';
                $config['max_size']     = 2048;
                $config['file_name'] = date('Y-m-d_His');
                $this->load->library('upload', $config);
                // 上传
                if(!$this->upload->do_upload('img')) {
                    echo "<script>alert('图片上传失败！');window.location.href='".site_url('/shop/Shop/findshop')."';</script>";exit;
                }else{
                    $img[]['picImg'] = '/Upload/adver/'.$this->upload->data('file_name');
                    $data['picImg'] = json_encode($img);
                }
            }
           
            if($this->Shop_model->edit_salse($data['id'],$data)){
                  $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  
                        "content" => $_SESSION['users']['username']."修改了一个推荐商家详情,id是：".$data['id'],
                        "create_time" => date('Y-m-d H:i:s'),
                        "userip" => get_client_ip(),
                    );
                    $this->db->insert('hf_system_journal',$log);
                echo "<script>alert('操作成功！');window.location.href='".site_url('/shop/Shop/findshop')."';</script>";exit;
            }else{
                 echo "<script>alert('操作失败！');window.location.href='".site_url('/shop/Shop/findshop')."';</script>";exit;
            }
        }else{
            $this->load->view('404.html');
        }
     }
    //导入商家信息
    function impolt_store(){

          $typeid = $_POST['typeid'];

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
              for($currentRow = 2;$currentRow <= $allRow;$currentRow++){
                $data['barnd_name'] = $PHPExcel->getActiveSheet()->getCell("A".$currentRow)->getValue();//获取c列的值
                $username = $PHPExcel->getActiveSheet()->getCell("B".$currentRow)->getValue();//获取c列的值
                $data['en_name'] = $PHPExcel->getActiveSheet()->getCell("C".$currentRow)->getValue();//获取d列的值
                $data['open_busin'] = $PHPExcel->getActiveSheet()->getCell("D".$currentRow)->getValue();//获取d列的值
                $data['store_type'] = $PHPExcel->getActiveSheet()->getCell("E".$currentRow)->getValue();//获取d列的值
                $data['op_status'] = $PHPExcel->getActiveSheet()->getCell("F".$currentRow)->getValue();//获取d列的值
                $data['floor_name'] = $PHPExcel->getActiveSheet()->getCell("G".$currentRow)->getValue();//获取d列的值
                $data['door_no'] = $PHPExcel->getActiveSheet()->getCell("H".$currentRow)->getValue();//获取d列的值
                $data['area'] = $PHPExcel->getActiveSheet()->getCell("I".$currentRow)->getValue();//获取d列的值
                $data['business_hours'] = $PHPExcel->getActiveSheet()->getCell("J".$currentRow)->getValue();//获取d列的值
             
                $type_name = $PHPExcel->getActiveSheet()->getCell("K".$currentRow)->getValue();//获取d列的值
                // $type_tow_name = $PHPExcel->getActiveSheet()->getCell("L".$currentRow)->getValue();//获取d列的值 
                $data['phone'] = trim($PHPExcel->getActiveSheet()->getCell("M".$currentRow)->getValue());//获取d列的值
                $data['create_time'] = date('Y-m-d');
                $data['send_userid'] = $_SESSION['users']['user_id'];
                if($data['barnd_name'] == NULL){
                     //删除临时文件
                    exit;
                }
                
                //判断一级业态是否存在
                $commercial_type_name = $this->Shop_model->get_store_type_id(trim($type_name),'0');
                if($commercial_type_name == NULL){
                    $type = array('type_name'=>$type_name);
                    $commercial_type_name = $this->Shop_model->add_store_type($type);
                }
                // //判断二级业态是否存在
                // $subcommercial_type_name = $this->Shop_model->get_store_type_id(trim($type_tow_name),$commercial_type_name);
                // if($subcommercial_type_name == NULL){
                //     $comm = array('type_name'=>$type_tow_name,'gid'=>$commercial_type_name);
                //     $subcommercial_type_name = $this->Shop_model->add_store_type($comm);
                // }
                //新增商家用户账号
                $arr['username'] = trim($username);
                $arr['password'] = md5('123456');
                $arr['gid'] = '2';
                if($typeid == '2'){
                    $data['store_distinction'] = '2';
                }else{
                    $data['store_distinction'] = '1';
                }
                $data['store_name'] = $username;
                //获取用户id
                 $username = $this->Shop_model->get_user_info($arr['username']);
                if(empty($username)){
                    $userid = $this->Shop_model->add_store_member($arr);
                     //插入数据库
                    $data['business_id'] = $userid;
                    $data['subcommercial_type_name'] = $subcommercial_type_name;
                    $data['commercial_type_name'] = $commercial_type_name;

                    $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  
                        "content" => $_SESSION['users']['username']."导入了商家信息",
                        "create_time" => date('Y-m-d H:i:s'),
                        "userip" => get_client_ip(),
                    );
                    $this->db->insert('hf_system_journal',$log);



                    $import =  $this->db->insert('hf_shop_store',$data); 
                }

             }
    }

    //导出商家
    function dowload_store(){
        $id = intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
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
            $bookings = $this->Shop_model->shop_list($id);
            if(count($bookings) > 0)
            {
                foreach ($bookings as $booking) {
                    $i++;
                    $type_name_one = $this->Shop_model->get_store_type_name($booking['commercial_type_name']);
                    $type_name_tow = $this->Shop_model->get_store_type_name($booking['subcommercial_type_name']);
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

             $log = array(
                'userid'=>$_SESSION['users']['user_id'],  
                "content" => $_SESSION['users']['username']."导出了商家信息",
                "create_time" => date('Y-m-d H:i:s'),
                "userip" => get_client_ip(),
            );
            $this->db->insert('hf_system_journal',$log);


            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            $objWriter->save('php://output');
        }
    }

    //导出商场内的店铺
    function Dow_mollStore(){
         $id = intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
            $this->load->library('excel');
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Stores');
            $arr_title = array(
                'A' => '商家ID',
                'B' => '品牌名称',
                'C' => '商家名称',
                'D' => '联系电话',
                'E' => '创建时间'
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
            $bookings = $this->Shop_model->shop_list($id);
            if(count($bookings) > 0)
            {
                foreach ($bookings as $booking) {
                    $i++;
           
                    $this->excel->getActiveSheet()->setCellValue('A' . $i, $booking['store_id']);
                    $this->excel->getActiveSheet()->setCellValue('B' . $i, $booking['barnd_name']);
                    $this->excel->getActiveSheet()->setCellValue('C' . $i, $booking['store_name']);
                    $this->excel->getActiveSheet()->setCellValue('D' . $i, $booking['phone']); 
                    $this->excel->getActiveSheet()->setCellValue('E' . $i, $booking['create_time']);
                }
            }

            $filename = '商户列表.xls'; //save our workbook as this file name

            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

             $log = array(
                'userid'=>$_SESSION['users']['user_id'],  
                "content" => $_SESSION['users']['username']."导出了商家信息",
                "create_time" => date('Y-m-d H:i:s'),
                "userip" => get_client_ip(),
            );
            $this->db->insert('hf_system_journal',$log);


            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            $objWriter->save('php://output');
        }
    }


}

