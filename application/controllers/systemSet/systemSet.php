<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  系统设置
 *
 * */
require_once(APPPATH.'controllers/Default_Controller.php');

class SystemSet extends Default_Controller {
    //权限首页
    public $view_memberLimit = 'member/memberLimit.html';
    //编辑权限
    public $view_memberLimitEdit = 'member/memberLimitEdit.html';
    //后台管理员账号管理
    public $view_admin_user = 'systemSet/accountManage.html';
    //支付账号管理
    public $view_paymanage = 'systemSet/apliyManage.html';
    //其他管理
    public $view_other = "systemSet/other.html";
    //网站信息
    public $view_web_config = 'systemSet/webMessage.html';
    //app banner
    public $view_bannerList = "banner/bannerList.html";    
    // banner 新增
    public $view_addBanner = "banner/addBanner.html";  
    // banner 编辑
    public $view_editBanner = "banner/editBanner.html";

    //系统设置 广告管理
    public $view_adverManage = 'systemSet/adverManage.html';
    //系统设置 广告管理
    public $view_adverEdit = 'systemSet/adverEdit.html';
    function __construct()
    {
        parent::__construct();
        $this->load->model('System_model');

    }


    //系统设置 后台管理员账号管理
    function index()
    {
        //获取权限类型
         $data['group'] = $this->System_model->get_member_group();
         $data['page'] = $this->view_admin_user;
         $data['menu'] = array('systemSet','systemSet');
    	 $this->load->view('template.html',$data);
    }
    //获取管理员列表
    function adminUserList(){
        if($_POST){
            $user = $this->System_model->get_admin_user();
            if(empty($user)){
                echo "2";
            }else{
                echo json_encode($user);
            }
        }else{
            echo "2";
        }
    }
    //新增管理操作
    function add_admin_user(){
        if($_POST){
            $data = $this->input->post();
            if(!empty($_FILES['img']['tmp_name'])){
                $config['upload_path']      = 'Upload/headPic';
                $config['allowed_types']    = 'gif|jpg|png|jpeg';
                $config['max_size']     = 2048;
                $config['file_name'] = date('Y-m-d_His');
                $this->load->library('upload', $config);
                //上传
                if ( ! $this->upload->do_upload('img')) {
                    echo "<script>alert('图片上传失败！');window.location.href='".site_url('/systemSet/SystemSet/index/')."'</script>";
                    exit;
                } else{
                    $data['avatar'] = 'Upload/headPic/'.$this->upload->data('file_name');
                }
            }
            $data['password'] = md5($data['password']);
            if($this->System_model->add_admin_user($data)){
                echo "<script>alert('操作成功！');window.location.href='".site_url('/systemSet/SystemSet/index/')."'</script>";
             }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/systemSet/SystemSet/index/')."'</script>";
             }
        }else{
            $this->load->view('404.html');
        }
    }
    //返回管理员类别
    function admin_user_group(){
        if($_POST){
             $group= $this->System_model->get_member_group();
             if(!empty($group)){
                echo json_encode($group);
             }else{
                echo "2";
             }
        }else{
            echo "2";
        }
    }
    //编辑管理员操作
    function edit_admin_user(){
        if($_POST){
            $id = $_POST['user_id'];
            $username = trim($_POST['username']);
            $user = $this->System_model->get_user($id,$username);
            if(empty($user)){
                $data['username'] = $username;
            }else{
                echo "2";exit;
            }
            if(!empty($_FILES['picArray']['tmp_name'])){
                $config['upload_path']      = 'Upload/headPic';
                $config['allowed_types']    = 'gif|jpg|png|jpeg';
                $config['max_size']     = 2048;
                $config['file_name'] = date('Y-m-d_His');
                $this->load->library('upload', $config);
                //上传
                if ( ! $this->upload->do_upload('picArray')) {
                    echo "<script>alert('图片上传失败！');window.location.href='".site_url('/systemSet/SystemSet/index/')."'</script>";
                    exit;
                } else{
                    $data['avatar'] = '/Upload/headPic/'.$this->upload->data('file_name');
                }
            }
            $data['nickname'] = trim($_POST['nickname']);
            $password = trim($_POST['password']);
            if(!empty($password)){
              $data['password'] = md5($password);
            }

            $data['gid'] = $_POST['group_name'];
            if($this->System_model->edit_admin_user($id,$data)){
                echo "1";
            }else{
                echo "2";
            }

        }else{
            echo "2";
        }
    }

      //刪除管理員
    function del_admin_user(){
       if($_POST){
            $id = $_POST['userid'];
            if(empty($id)){
                echo "2";exit;
            }else{
                if($this->System_model->del_admin_user($id)){
                    echo "1";
                }else{
                    echo "2";
                }
            }
       }else{
         echo "2";
       }
    }



    //系统设置 广告管理
    function adverManage(){
        //返回所有广告
        $data['adver'] = $this->System_model->get_app_adver();
         $data['page'] = $this->view_adverManage;
         $data['menu'] = array('systemSet','adverManage');
         $this->load->view('template.html',$data);
    }
    //系统设置 编辑广告
    function adverEdit(){
        $id = intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
            $data['adver'] = $this->System_model->get_adver_info($id);
            $data['id'] = $id;
             $data['page'] = $this->view_adverEdit;
             $data['menu'] = array('systemSet','adverEdit');
             $this->load->view('template.html',$data);
        }
    }
    //编辑广告操做
    function edit_adver(){
        if($_POST){
            $data = $this->input->post();
   
            if(!empty($_FILES['img']['tmp_name'])){
                $config['upload_path']      = 'Upload/adver';
                $config['allowed_types']    = 'gif|jpg|png|jpeg';
                $config['max_size']     = 2048;
                $config['file_name'] = date('Y-m-d_His');
                $this->load->library('upload', $config);
                //上传
                if ( ! $this->upload->do_upload('img')) {
                    echo "<script>alert('图片上传失败！');window.location.href='".site_url('/systemSet/SystemSet/adverEdit/'.$data['id'])."'</script>";
                    exit;
                } else{
                    $data['pic'] = '/Upload/adver/'.$this->upload->data('file_name');
                }
            }
            if($this->System_model->edit_adver($data['id'],$data)){
                echo "<script>alert('操作成功！');window.location.href='".site_url('/systemSet/SystemSet/adverManage')."'</script>";
            }else{
                 echo "<script>alert('操作失败！');window.location.href='".site_url('/systemSet/SystemSet/adverEdit/'.$data['id'])."'</script>";
            }
        }else{
            $this->load->view('404.html');
        }
    }





    //系统设置 支付账号管理
    function apliyManage(){
         $data['page'] = $this->view_paymanage;
         $data['menu'] = array('systemSet','apliyManage');
    	 $this->load->view('template.html',$data);
    }

    
    //系统设置 其他管理
    function other(){
     $data['page'] = $this->view_other;
     $data['menu'] = array('systemSet','other');
     $this->load->view('template.html',$data);
    }
    //系统设置 网站信息管理
    function webMessage(){
        //获取web设置
        $system = $this->System_model->get_webSystem();
        $data['webset'] = json_decode($system['system_value'],true);
        $data['page'] = $this->view_web_config;
        $data['menu'] = array('systemSet','webMessage');
        $this->load->view('template.html',$data);
    }
    //网站信息操做
    function edit_WebSystem(){
        if($_POST){
            $data = $this->input->post();
            if(!empty($_FILES['img']['tmp_name'])){
                $config['upload_path']      = 'Upload/logo';
                $config['allowed_types']    = 'gif|jpg|png|jpeg';
                $config['max_size']     = 2048;
                $config['file_name'] = date('Y-m-d_His');
                $this->load->library('upload', $config);
                //上传
                if ( ! $this->upload->do_upload('img')) {
                    echo "<script>alert('图片上传失败！');window.location.href='".site_url('/systemSet/SystemSet/webMessage')."'</script>";
                    exit;
                } else{
                    $data['logo'] = 'Upload/logo/'.$this->upload->data('file_name');
                }
            }
            $json = json_encode($data,JSON_UNESCAPED_UNICODE);
            $arr= array('system_value'=>$json);
            if($this->System_model->edit_WebSystem($arr)){
                 echo "<script>alert('操作成功！');window.location.href='".site_url('/systemSet/SystemSet/webMessage')."'</script>";exit;
            }else{
                 echo "<script>alert('操作失败！');window.location.href='".site_url('/systemSet/SystemSet/webMessage')."'</script>";exit;
            }
        }else{
            $this->load->view('404.html');
        }
    }

      //权限管理
    function memberLimit(){
        //返回所有权限  
        $data['group'] = $this->user_model->get_user_group($this->session->users['gid']);
        //所有模块 
        $query = $this->db->where('m_id','0')->get('hf_system_modular');
        $data['module'] = $query->result_array();  
        $query1 = $this->db->where('m_id !=','0')->get('hf_system_modular');
        $data['module_list'] = $query1->result_array();

        $data['page'] = $this->view_memberLimit;
        $data['menu'] = array('systemSet','memberLimit');
        $this->load->view('template.html',$data);
    }
    //权限编辑
    function memberLimitEdit(){
        $id = intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
            //获取详情
            $group = $this->user_model->get_group_info($id);
            $group_permission = json_decode($group['group_permission'],true);
       
            //获取所有模块
            $query = $this->db->where('m_id','0')->get('hf_system_modular');
            $modular = $query->result_array();
            foreach ($modular as $key => $value) {
                $a = $this->System_model->get_modular($value['modular_id']);
                foreach ($a as $k => $v) {
                   if(in_array($v['modular_id'],$group_permission)){
                         $a[$k]['true'] = '1';
                   }else{
                        $a[$k]['true'] = '0';
                   }
                }
                $modular[$key]['check'] = $a;
            }
            $data['group'] = $group;
      
            $data['module_list'] = $modular;
            $data['page'] = $this->view_memberLimitEdit;
            $data['menu'] = array('systemSet','memberLimitEdit');
            $this->load->view('template.html',$data);
        }
    }

    //新增权限
    function add_member_group(){
        if($_POST){
             $data['group_name'] = $this->input->post('group_name');
             $group_permission = $this->input->post('group_permission');
             foreach ($group_permission as $key => $value) {
                $k[] = (string)$key; 
                foreach ($value as $v) {
                    $arr[]  = $v;
                }
             }
            $data['group_permission'] = json_encode(array_merge($k,$arr));
            if($this->user_model->add_group($data)){
                echo "<script>alert('操作成功!');window.location.href='".site_url('/systemSet/SystemSet/memberLimit')."'</script>";exit;
            }else{
                echo "<script>alert('操作失败!');window.location.href='".site_url('/systemSet/SystemSet/memberLimit')."'</script>";exit;
            }
        }else{
            $this->load->view('404.html');
        }
    }
    
    //编辑权限
    function edit_member_group(){
        if($_POST){
            $id = $this->input->post('gid');
            $data['group_name'] = $this->input->post('group_name');
            $group_permission = $this->input->post('group_permission');
             foreach ($group_permission as $key => $value) {
                $k[] = (string)$key; 
                foreach ($value as $v) {
                    $arr[]  = $v;
                }
             }
            $data['group_permission'] = json_encode(array_merge($k,$arr));
            if($this->user_model->edit_group($id,$data)){
                 echo "<script>alert('操作成功!');window.location.href='".site_url('/systemSet/SystemSet/memberLimit')."'</script>";exit;
             }else{
                 echo "<script>alert('操作失败!');window.location.href='".site_url('/systemSet/SystemSet/memberLimit')."'</script>";exit;
             }
        }else{
            $this->load->view('404.html');
        }
    }
    //删除权限
    function del_group(){
        $id=intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
            $data['gid'] = '0';
            if($this->user_model->edit_admin_user($id,$data)){
                if($this->user_model->del_group($id)){
                     echo "<script>alert('操作成功!');window.location.href='".site_url('/systemSet/SystemSet/memberLimit')."'</script>";exit;
                }else{
                      echo "<script>alert('操作失败!');window.location.href='".site_url('/systemSet/SystemSet/memberLimit')."'</script>";exit;
                }
            }else{
                echo "<script>alert('操作失败!');window.location.href='".site_url('/systemSet/SystemSet/memberLimit')."'</script>";exit;
            }
        }
    }


     //banner列表
    function bannerList(){
        //获去首页banner
        // $data['homebanner'] = $this->System_model->get_bannerlist('Index');
        // //获取超市比价banner
        // $data['supermarketBanner'] = $this->System_model->get_bannerlist('Supermarket');
        // //获取为民服务banner
        // $data['serviceBanner'] = $this->System_model->get_bannerlist('Service'); 
        // //获取商城banner
        // $data['mallBanner'] = $this->System_model->get_bannerlist('Mall');
       
        $data['banners'] = $this->System_model->get_bannerlist();


        $data['page'] = $this->view_bannerList;
        $data['menu'] = array('systemSet','bannerList');
        $this->load->view('template.html',$data);
    }
    //新增banner
    function addBanner(){
        $id = intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
            $data['id'] = $id;
            $data['page'] = $this->view_addBanner;
            $data['menu'] = array('systemSet','banner');
            $this->load->view('template.html',$data);
        }
       
    }
    //新增banner操作
    function add_banner(){
        if($_POST){
            $id = $this->input->post('id');
            $data = $this->input->post();
            if(!empty($_FILES['img']['name'])){
                $config['upload_path']      = 'Upload/banner/';
                $config['allowed_types']    = 'gif|jpg|png|jpeg';
                $config['max_size']     = 2048;
                $config['file_name'] = date('Y-m-d_His');
                $this->load->library('upload', $config);
                // 上传
                if(!$this->upload->do_upload('img')) {
                     echo "<script>alert('图片上传失败！');window.location.href='".site_url('/systemSet/SystemSet/addBanner/'.$data['id'])."'</script>";exit;
                }else{
                   
                    $data['bannerPic'] = '/Upload/banner/'.$this->upload->data('file_name');
                    }
            }
            unset($data['id']);
             $a[] = $data;
            //获取原由的banner
            $banner = $this->System_model->get_banner($id);
            if(!empty($banner['banner'])){
                $bannerPic = json_decode($banner['banner'],true);
                 $shu = array_merge($bannerPic,$a);
                 $json = json_encode($shu);
                 $arr = array('banner'=>$json);
            }else{
                $json = json_encode($a);
                $arr = array('banner'=>$json);
            }
            if($this->System_model->edit_banner($id,$arr)){
                echo "<script>alert('操作成功！');window.location.href='".site_url('/systemSet/SystemSet/bannerList')."'</script>";exit;
            }else{
                 echo "<script>alert('操作失败!');window.location.href='".site_url('/systemSet/SystemSet/addBanner/'.$id)."'</script>";exit;
            }
        }
    }
    //编辑banner
    function editBanner(){
        $id = intval($this->uri->segment(4));
        $num = intval($this->uri->segment(5));
        if($id == 0 || $num == 0){
            $this->load->view('404.html');
        }else{
            //获取banner信息
            $banner = $this->System_model->get_banner($id);
            $bannerpic = json_decode($banner['banner'],true);
            $data['id'] = $id;
            $data['num'] = $num;
            $data['banner'] = $bannerpic[$num-1];
            $data['page'] = $this->view_editBanner;
            $data['menu'] = array('systemSet','banner');
            $this->load->view('template.html',$data);
         }
    }
    //编辑banner操作
    function edit_banner(){
        if($_POST){
             $id = $this->input->post('id');
             $num = $this->input->post('num');
            $data = $this->input->post();
            if(!empty($_FILES['img']['name'])){
                $config['upload_path']      = 'Upload/banner/';
                $config['allowed_types']    = 'gif|jpg|png|jpeg';
                $config['max_size']     = 2048;
                $config['file_name'] = date('Y-m-d_His');
                $this->load->library('upload', $config);
                // 上传
                if(!$this->upload->do_upload('img')) {
                     echo "<script>alert('图片上传失败！');window.location.href='".site_url('/systemSet/SystemSet/editBanner/'.$data['id'].'/'.$num)."'</script>";exit;
                }else{
                   
                    $data['bannerPic'] = '/Upload/banner/'.$this->upload->data('file_name');
                    }
            }
            unset($data['id']);
            unset($data['num']);
      
            //获取原由的banner
            $banner = $this->System_model->get_banner($id);
            if(!empty($banner['banner'])){
                $bannerPic = json_decode($banner['banner'],true);
                $bannerPic[$num-1] = $data;
               // var_dump($bannerPic);
                  $json = json_encode($bannerPic);
                  $arr = array('banner'=>$json);
                if($this->System_model->edit_banner($id,$arr)){
                    echo "<script>alert('操作成功！');window.location.href='".site_url('/systemSet/SystemSet/bannerList')."'</script>";exit;
                }else{
                     echo "<script>alert('操作失败!');window.location.href='".site_url('/systemSet/SystemSet/editBanner/'.$id.'/'.$num)."'</script>";exit;
                }
            }
        }
    }

    //删除banner
    function del_banner(){
        $id = intval($this->uri->segment(4));
        $num = intval($this->uri->segment(5));
        if($id == 0 || $num == 0){
            $this->load->view('404.html');
        }else{
            //获取banner信息
            $banner = $this->System_model->get_banner($id);
            $bannerpic = json_decode($banner['banner'],true);
            $list = $num-1;
            @unlink($bannerpic[$list]['bannerPic']);
            unset($bannerpic[$list]);
            if(!empty($bannerpic)){
                $json = json_encode(array_merge($bannerpic));
                $arr = array('banner'=>$json);
                if($this->System_model->edit_banner($id,$arr)){
                    echo "<script>alert('操作成功！');window.location.href='".site_url('/systemSet/SystemSet/bannerList')."'</script>";exit;
                }else{
                     echo "<script>alert('操作失败!');window.location.href='".site_url('/systemSet/SystemSet/bannerList')."'</script>";exit;
                }
            }else{
                $arr = array('banner'=>'');
                if($this->System_model->edit_banner($id,$arr)){
                    echo "<script>alert('操作成功！');window.location.href='".site_url('/systemSet/SystemSet/bannerList')."'</script>";exit;
                }else{
                    echo "<script>alert('操作失败!');window.location.href='".site_url('/systemSet/SystemSet/bannerList')."'</script>";exit;
                }
            }
         }
    }
}

