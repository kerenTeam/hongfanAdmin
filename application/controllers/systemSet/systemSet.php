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
    //角色管理 
    public $view_roleManage = 'systemSet/roleManage.html';

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
    //App版本管理
    public $view_appversion = 'systemSet/appVersion.html';

    //系统设置 广告管理
    public $view_adverManage = 'systemSet/adverManage.html';
    //系统设置 广告管理
    public $view_adverEdit = 'systemSet/adverEdit.html';
    //引导图广告
    public $view_guideImage = 'systemSet/guideImageManage.html';
    //HI集头条
    public $view_hiHeadline = 'systemSet/hiHeadline.html';
    //系统日志
    public $view_system_journal = "systemSet/journal.html";

    //运费模板
    public $view_express = "systemSet/expressTemplate.html";
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

    //系统设置 引导图广告管理
    function guideImageManage()
    {
        //返回启动图广告
        $adver = $this->System_model->get_start_advertising();
        $data['adver'] = json_decode($adver['banner'],true);
        $data['id'] = $adver['id'];
        $data['page'] = $this->view_guideImage;
        $data['menu'] = array('systemSet','guideImageManage');
        $this->load->view('template.html',$data);
    }
    //修改 引导图广告
    function edit_advertising(){
        if($_POST){
            $id = $this->input->post('id');
            //$pic =array();
            $i ='0';
            $a ='1';
            foreach($_FILES as $val){
                if(!empty($_FILES['img'.$a]['tmp_name'])){
                    $config['upload_path']      = 'Upload/banner';
                    $config['allowed_types']    = 'gif|jpg|png|jpeg';
                    $config['max_size']     = 2048;
                    $config['file_name'] = date('Y-m-d_His');
                    $this->load->library('upload', $config);
                    //上传
                    if ( ! $this->upload->do_upload('img'.$a)) {
                        echo "<script>alert('图片上传失败！');window.location.href='".site_url('/systemSet/SystemSet/guideImageManage/')."'</script>";
                        exit;
                    } else{
                        $pic[$i]['id'] =$a;
                        $pic[$i]['pic'] = '/Upload/banner/'.$this->upload->data('file_name');
                    }
                }else{
                    $pic[$i]['id'] =$a;
                    $pic[$i]['pic']  = $_POST['img'.$a];
                    
                }
                $i++;
                $a++;
            }
            $data['banner'] = json_encode($pic);
            //var_dump(json_encode($pic));
            if($this->System_model->edit_banner($id,$data)){
                echo "<script>alert('操作成功！');window.location.href='".site_url('/systemSet/SystemSet/guideImageManage')."'</script>";
            }else{
                 echo "<script>alert('操作失败！');window.location.href='".site_url('/systemSet/SystemSet/guideImageManage')."'</script>";
            }
        }else{
            $this->load->view('404.html');
        }
    }

    //系统设置  HI集头条管理
    function hiHeadline()
    {
         $data['page'] = $this->view_hiHeadline;
         $data['menu'] = array('systemSet','hiHeadline');
         $this->load->view('template.html',$data);
    }
    
    //系统设置 角色管理
    function roleManage()
    {   
     
        //所有角色
        $data['group'] = $this->System_model->get_member_group();

        $data['page'] = $this->view_roleManage;
        $data['menu'] = array('systemSet','systemSet');
        $this->load->view('template.html',$data);
    }

    //获取管理用户列表
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
    //新增管理用户操作
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
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."新增了一个管理员，管理员名称是：".$data['username'],
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);
                echo "<script>alert('操作成功！');window.location.href='".site_url('/systemSet/SystemSet/index/')."'</script>";
             }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/systemSet/SystemSet/index/')."'</script>";
             }
        }else{
            $this->load->view('404.html');
        }
    }
    //返回角色
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
                    $data['avatar'] = 'Upload/headPic/'.$this->upload->data('file_name');
                }
            }
            $data['nickname'] = trim($_POST['nickname']);
            $password = trim($_POST['password']);
            if(!empty($password)){
              $data['password'] = md5($password);
            }

            $data['gid'] = $_POST['group_name'];
            if($this->System_model->edit_admin_user($id,$data)){
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."编辑了一个管理员，管理员名称是：".$data['username'].",管理员id是：".$id,
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

    //刪除管理員
    function del_admin_user(){
       if($_POST){
            $id = $_POST['userid'];
            if(empty($id)){
                echo "2";exit;
            }else{
                if($this->System_model->del_admin_user($id)){
                     $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  
                        "content" => $_SESSION['users']['username']."删除了一个管理员，管理员id是：".$id,
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


    //系统设置 广告管理
    function adverManage(){
        //返回所有广告
        $data['adver'] = $this->System_model->get_app_adver();
         $data['page'] = $this->view_adverManage;
         $data['menu'] = array('moll','adverManage');
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
                   $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  
                        "content" => $_SESSION['users']['username']."编辑了一个广告内容，广告id是：".$data['id'],
                        "create_time" => date('Y-m-d H:i:s'),
                        "userip" => get_client_ip(),
                    );
                    $this->db->insert('hf_system_journal',$log);
                echo "<script>alert('操作成功！');window.location.href='".site_url('/systemSet/SystemSet/adverManage')."'</script>";
            }else{
                 echo "<script>alert('操作失败！');window.location.href='".site_url('/systemSet/SystemSet/adverEdit/'.$data['id'])."'</script>";
            }
        }else{
            $this->load->view('404.html');
        }
    }





    // //系统设置 支付账号管理
    // function apliyManage(){
    //      $data['page'] = $this->view_paymanage;
    //      $data['menu'] = array('systemSet','apliyManage');
    // 	 $this->load->view('template.html',$data);
    // }

    
    // //系统设置 其他管理
    // function other(){
    //  $data['page'] = $this->view_other;
    //  $data['menu'] = array('systemSet','other');
    //  $this->load->view('template.html',$data);
    // }
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
                $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  
                        "content" => $_SESSION['users']['username']."修改了网站信息",
                        "create_time" => date('Y-m-d H:i:s'),
                        "userip" => get_client_ip(),
                    );
                    $this->db->insert('hf_system_journal',$log);
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
        $query = $this->db->order_by('modular_id','asc')->get('hf_system_modular');
        $arr = $query->result_array();
        // var_dumP($arr);
        // exit;
        //返回整理好的数组
        $data['modular'] = subtree($arr);

        $data['page'] = $this->view_memberLimit;
        $data['menu'] = array('systemSet','memberLimit');
        $this->load->view('template.html',$data);
    }

    //添加权限
    function add_Authority(){
        if($_POST){
            $data = $this->input->post();
            if($this->db->insert('hf_system_modular',$data)){
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."新增了一个权限，权限组名称是：".$data['name'],
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);
                echo "<script>alert('添加成功！');window.location.href='".site_url('systemSet/SystemSet/memberLimit')."'</script>";exit;
            }else{
                echo "<script>alert('添加失败！');window.location.href='".site_url('systemSet/SystemSet/memberLimit')."'</script>";exit;
            }
        }else{
            $this->load->view('404.html');
        }
    }
    //编辑权限
    function edit_Authority(){
        if($_POST){
             $data = $this->input->post();
             $id = $this->input->post('id');
             unset($data['id']);
             if($this->db->where("modular_id",$id)->update('hf_system_modular',$data)){
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."修改了一个权限，权限id是：".$id."权限组名称是：".$data['name'],
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);
                echo "<script>alert('操作成功!');window.location.href='".site_url('/systemSet/SystemSet/memberLimit')."'</script>";exit;
             }else{
                echo "<script>alert('操作失败!');window.location.href='".site_url('/systemSet/SystemSet/memberLimit')."'</script>";exit;

             }
        }else{
            $this->load->view('404.html');
        }
    }

    //删除权限
    function del_Authority(){
        if($_POST){
            $id = $this->input->post('id');
            if($this->db->where('modular_id',$id)->delete('hf_system_modular')){
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."删除了一个权限，权限id是：".$id,
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


    //角色编辑
    function memberLimitEdit(){
        if($_POST){
            $data['group_name'] = trim($this->input->post('group_name'));
            $id = $this->input->post('gid');
            if($this->user_model->edit_group($id,$data)){
                    $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  
                        "content" => $_SESSION['users']['username']."修改了一个角色，角色id是：".$id,
                        "create_time" => date('Y-m-d H:i:s'),
                        "userip" => get_client_ip(),
                    );
                    $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('systemSet/SystemSet/roleManage')."'</script>";exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('systemSet/SystemSet/roleManage')."'</script>";exit;

            }
        }else{
            $this->load->view('404.html');
        }
    }

    //新增角色
    function add_member_group(){
        if($_POST){
             $data['group_name'] = $this->input->post('group_name');
            if($this->user_model->add_group($data)){
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."新增了一个角色，角色名称是：".$data['group_name'],
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);
                echo "<script>alert('操作成功!');window.location.href='".site_url('/systemSet/SystemSet/roleManage')."'</script>";exit;
            }else{
                echo "<script>alert('操作失败!');window.location.href='".site_url('/systemSet/SystemSet/roleManage')."'</script>";exit;
            }
        }else{
            $this->load->view('404.html');
        }
    }

    //删除角色
    function del_group(){
        if($_POST){
            $id = $this->input->post('gid');
            if($this->user_model->del_group($id)){
                   $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  
                        "content" => $_SESSION['users']['username']."删除了一个角色，角色id是：".$id,
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

    //给角色分配权限
    function allot_group(){
        $type = $this->uri->segment('4');
        if($type == 'Authority'){
            $gid = $this->uri->segment('5');
            $data['gid'] = $gid;
            //获取角色权限
            $group = $this->user_model->get_group_info($gid);
            $group_permission = json_decode($group['group_permission'],true);

            $query = $this->db->order_by('modular_id','asc')->get('hf_system_modular');
            $arr = $query->result_array();
            //返回整理好的数组
            $data['modular'] = subtree($arr,$group_permission);

            $data['page'] = 'systemSet/allot_group.html';
            $data['menu'] = array('systemSet','systemSet');
            $this->load->view('template.html',$data);

        }else{
            $this->load->view('404.html');
        }
    }
    //角色分配权限操作
    function add_allot_group(){
        if($_POST){
            $data['group_permission'] = $this->input->post('goodsid');
            $id = $this->input->post('id');
         
            if($this->user_model->edit_group($id,$data)){
                    $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  
                        "content" => $_SESSION['users']['username']."修改了一个角色的权限，角色id是：".$id,
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

     //banner列表
    function bannerList(){

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
                   $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  
                        "content" => $_SESSION['users']['username']."新增了一个banner，banner id是：".$id,
                        "create_time" => date('Y-m-d H:i:s'),
                        "userip" => get_client_ip(),
                    );
                    $this->db->insert('hf_system_journal',$log);
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
                    $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  
                        "content" => $_SESSION['users']['username']."编辑了一个banner，banner id是：".$id,
                        "create_time" => date('Y-m-d H:i:s'),
                        "userip" => get_client_ip(),
                    );
                    $this->db->insert('hf_system_journal',$log);
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
                    $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  
                        "content" => $_SESSION['users']['username']."删除了一个banner，banner id是：".$id,
                        "create_time" => date('Y-m-d H:i:s'),
                        "userip" => get_client_ip(),
                    );
                    $this->db->insert('hf_system_journal',$log);
                    echo "<script>alert('操作成功！');window.location.href='".site_url('/systemSet/SystemSet/bannerList')."'</script>";exit;
                }else{
                     echo "<script>alert('操作失败!');window.location.href='".site_url('/systemSet/SystemSet/bannerList')."'</script>";exit;
                }
            }else{
                $arr = array('banner'=>'');
                if($this->System_model->edit_banner($id,$arr)){
                    $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  
                        "content" => $_SESSION['users']['username']."删除了banner id是".$id."的所有banner，banner id是：".$id,
                        "create_time" => date('Y-m-d H:i:s'),
                        "userip" => get_client_ip(),
                    );
                    $this->db->insert('hf_system_journal',$log);
                    echo "<script>alert('操作成功！');window.location.href='".site_url('/systemSet/SystemSet/bannerList')."'</script>";exit;
                }else{
                    echo "<script>alert('操作失败!');window.location.href='".site_url('/systemSet/SystemSet/bannerList')."'</script>";exit;
                }
            }
         }
    }

    //APP版本管理
    function app_version(){
        //获取已有的APP版本信息
        $data['app'] = $this->System_model->get_app_version();
        $data['page'] = $this->view_appversion;
        $data['menu'] = array('systemSet','version');
        $this->load->view('template.html',$data);
    }

    //修改版本
    function edit_app_version(){
   
        if($_POST){
            $id= $this->input->post('id');
            $data['versionNum']= $this->input->post('versionNum');
            $data['create_time'] = date('Y-m-d H:i:s');
           
            if(!empty($_FILES['file']['tmp_name'])){
                $file_path = "Upload/xls/".$_FILES["file"]['name']; 
                move_uploaded_file($_FILES["file"]["tmp_name"],  $file_path);
                  if(!file_exists($file_path)){
                    echo "<script>alert('安装包上传失败!');window.location.href='".site_url('systemSet/SystemSet/app_version')."'</script>";
                    exit;
                 }
                $data['android_path_url']= $file_path;
                if($this->System_model->edit_app_version($id,$data)){
                    echo "<script>alert('操作成功!');window.location.href='".site_url('systemSet/SystemSet/app_version')."'</script>";
                }else{
                    echo "<script>alert('操作失败!');window.location.href='".site_url('systemSet/SystemSet/app_version')."'</script>";
                }
            }else{
                echo "4";
            }
        }else{
            $this->load->view('404.html');
        }
      
    }

    //返回APP温馨提示
    function get_prompt(){
        if($_POST){
            $list = $this->System_model->get_prompt();
            if($list){
                echo json_encode($list);
            }else{
                echo "2";
            }
        }else{
            echo "2";
        }
    }

    //修改温馨提示
    function edit_prompt(){
        if($_POST){
            $id = $this->input->post('id');
            $data['content'] = $this->input->post('content');
            if($this->System_model->edit_prompt($id,$data)){
                echo "1";
            }else{
                echo "2";
            }
        }else{
            echo "2";
        }
    }

    //系统日志
    function journal_list(){
        $data['page'] = $this->view_system_journal;
        $data['menu'] = array('systemSet','journal');
        $this->load->view('template.html',$data);
    }

    //返回系统日志列表
    function get_system_journal(){
        if($_POST){
            $list = $this->System_model->get_journal();
            if($list){
                echo json_encode($list);
            }else{
                echo "2";
            }
        }else{
            echo "2";
        }
    }


    //运费模板
    function expressTemplate(){
        $data['store_id'] =  $this->session->businessId;
        $data['page'] = $this->view_express;
        $data['menu'] = array('shop','expressTemplate');
        $this->load->view('template.html',$data);
    }
    //返回运费模板
    function ret_express_list(){
        if($_POST){
            $storeid =$this->input->post('storeid');
            $list = $this->System_model->get_express_temp($storeid);
            if(!empty($list)){
                echo json_encode($list);
            }else{
                echo "3";
            }
        }else{
            echo "2";
        }
    }

    //新增运费模板
    function add_express(){
        if($_POST){
            $data = $this->input->post();
            $data['businid'] = $this->session->businessId;
            $data['create_time'] = date('Y-m-d H:i:s');
            if($this->System_model->add_express_temp($data)){
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."新增了一个快递模板 快递公司名称是".$data['expressName'],
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);
               echo "<script>alert('操作成功！');window.location.href='".site_url('/systemSet/SystemSet/expressTemplate')."'</script>";exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/systemSet/SystemSet/expressTemplate')."'</script>";exit;
            }
        }else{
            $this->load->view('404.html');
        }
    }

    //编辑运费模板
    function edit_express(){
        if($_POST){
            $data = $this->input->post();
            if($this->System_model->edit_express_temp($data['express_id'],$data)){
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."编辑了一个快递模板 快递公司名称是".$data['expressName'].",模板id是".$data['express_id'],
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
    //删除快递模板
    function del_express(){
        if($_POST){
            $id = $this->input->post('express_id');
            if($this->System_model->del_express_temp($id)){
                  $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."编辑了一个快递模板,模板id是".$id,
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





}

