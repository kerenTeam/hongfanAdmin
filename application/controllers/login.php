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

    }

    function index(){
        // $json = '[{"bannerPic":"upload/banner/1.png","url":"http://www.baidu.com"},{"bannerPic":"upload/banner/2.png","url":"http://www.baidu.com"},{"bannerPic":"upload/banner/3.png","url":"http://www.baidu.com"}]';
        // $a = json_decode($json,true);


        $this->load->view('login.html');
    }
    //登陆操作
    function login_user(){
        if($_POST){

            var_dump($_POST);
        //     $data = $this->input->post();
        //     $user = $this->db->where('user_phone',$data['phone'])->get('hf_member_user')->row_array();
        //     //是否存在用户
        //     if(empty($user)){
        //         $a['error'] = '用户不存在！';
        //         $this->load->view('login.html',$a);
        //     }else{
        //         //密码是否正确
        //         if($user['user_passWord'] != md5($data['password'])){
        //             $a['error'] = '用户名或密码错误！';
        //             $this->load->view('login.html',$a);
        //         }else{
        //             //正确  缓存
        //          //   $this->session->set_userdata('users',$user);
        //             // 判断用户分组
        //             switch ($user['group_Id']){
        //                 case 1:
        //                     redirect( base_url('admin/index') );
        //                     break;
        //                 case 2:
        //                     break;
        //                 case 3:
        //                     break;
        //             }
        //         }
        //     }
        }else{

            $this->load->view('errors/index.html');
        }
    }




}