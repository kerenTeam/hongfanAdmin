<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  登陆
 *
 * */

class Login extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Member_model','m_model');
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
                       case 2:
                           redirect( site_url('shop/SingleShop/shopAdmin') );
                           break;
                        default:
                           $plateid = $this->m_model->group_permiss($this->session->users['gid']);
                           $plateid = json_decode($plateid,true);
                           if(!empty($plateid)){
                                foreach ($plateid as $key => $value) {
                                  $query = $this->db->where('modular_id',$value)->get('hf_system_modular');
                                  $menu[] = $query->row_array();
                                }
                                $arr = array();
                                foreach ($menu as $key => $value) {
                                    if($value['m_id'] == 0){
                                      $arr[$value['modular_id']]['value'] = $value;
                                    }else{
                                       $arr[$value['m_id']]['chick'][] = $value;
                                    }
                                }
                                $json = json_encode($arr);
                                $this->session->set_userdata('menu',$json);
                            }else{
                                $a['error'] = '你没有权限登录！';
                                $this->load->view('login.html',$a);
                            }
                            redirect( site_url('/Admin/index') );
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
            $this->session->unset_userdata('menu');
            //var_dump($_SESSION['menu']);
            redirect('Login/index');
        }else{
            $this->load->view('errors/index.html');
        }
    }


}