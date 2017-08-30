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

        date_default_timezone_set("Asia/Shanghai");

        $this->load->model('Member_model','m_model');

        $this->load->helper('default_helper');

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

                   session_start();
                   $_SESSION['users']  = $user;

                   $url = APPLOGIN."/api/useraccount/login";
                   $arr = array('phone'=>USERPHONE,"password"=>USERPASSWORD);
                   $token = curl_post_token($url,$arr);
                   $_SESSION['token'] = trim($token);

                   switch ($user['gid']){

                        case 2:
                           //unset($_SESSION['menu']);
                           $_SESSION['buket'] = 'ebus';
                           $_SESSION['host'] = $this->config->item('ebus','hostGlobal');
                        

                           redirect( site_url('shop/SingleShop/shopAdmin') );

                           break;

                        default:

                        $group = $this->m_model->group_permiss($_SESSION['users']['gid']);
                        
                        $plateid = json_decode($group['group_permission'],true);
            
                        $_SESSION['city'] = $group['city'];
                        if(!empty($plateid)){
                                foreach ($plateid as $key => $value) {
                                    $query = $this->db->where('modular_id',$value)->get('hf_system_modular');
                                    $menu[] = $query->row_array();
                                }
                                $arr = array();
                                $menus = subtree($menu);
                                $_SESSION['user_power'] =json_encode($menus);
                                foreach($menus as $key=>$value){
                                    if($value['state'] == '1'){
                                        if($value['m_id'] == '0'){
                                            $menus_data[$value['modular_id']]['value'] = $value;
                                        }else{
                                            $menus_data[$value['m_id']]['value']['chick'][] = $value;
                                        }
                                    }
                                }
                                $_SESSION['menu'] = json_encode($menus_data);
                            
                        }else{
            
                            $a['error'] = '你没有权限登录！';
            
                            $this->load->view('login.html',$a);
            
                        }
                        $data = array(

                                "userid" => $user['user_id'],

                                "content" => $user['username']."登录了！",

                                "create_time" => date('Y-m-d H:i:s'),

                                "userip" => get_client_ip(),

                                "login_address" => GetIpLookup(get_client_ip()),

                            );

                            $this->db->insert('hf_system_journal',$data);

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

            // $this->session->unset_userdata('users');

            // $this->session->unset_userdata('menu');

            unset($_SESSION['users'],$_SESSION['menu']);

            //var_dump($_SESSION['menu']);

            redirect('Login/index');

        }else{

            $this->load->view('errors/index.html');

        }

    }





}