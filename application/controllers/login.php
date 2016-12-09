<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  登陆
 *
 * */

class login extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('member_model','m_model');
    }
    //管理员登陆界面
    function index(){
      
        $this->load->view('login.html');
    }
    


    //登陆操作
    function login_user(){
        if($_POST){

            $data = $this->input->post();
            $user = $this->m_model->get_login_user(trim($data['user_phone']));
            //是否存在用户
            if(empty($user)){
                $a['error'] = '用户不存在！';
                $this->load->view('login.html',$a);
            }else{
                //密码是否正确
                if($user['password'] != md5($data['password'])){
                    $a['error'] = '用户名或密码错误！';
                    $this->load->view('login.html',$a);
                }else{
                    //正确  缓存
                   $this->session->set_userdata('users',$user);
                    // 判断用户分组
                   switch ($user['gid']){
                       case 1:
                           redirect( site_url('admin/index') );
                           break;
                       case 2:
                           
                           redirect( site_url('shop/singleShop/shopAdmin/') );
                           break;
                   }
                }
            }
        }else{

            $this->load->view('errors/index.html');
        }
    }

    //退出登陆
    function loginOut(){
        if($_GET){
            $this->session->unset_userdata('users');
            redirect('login/index');
        }else{
            $this->load->view('errors/index.html');
        }
    }


}