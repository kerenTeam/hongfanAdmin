<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Default_Controller.php');



/**

 *  后台 首页

*/

class Admin extends Default_Controller

{

	function __construct()

	{

		parent::__construct();

	}



	function index(){
            
            $_SESSION['buket'] = 'demo';
            $_SESSION['host'] = 'http://ov2jx0xre.bkt.clouddn.com';
                if(isset($_SESSION['businessId'])){

                    if($_SESSION['users']['user_id'] != $_SESSION['businessId']){

                    unset($_SESSION['businessId']);

                    }

                }

           
                //获取用户登录次数

                $query = $this->db->where('userid',$_SESSION['users']['user_id'])->where('login_address !=','')->order_by('create_time','desc')->get('hf_system_journal');

                $login = $query->result_array();

                if(!empty($login)){

                    $data['loginNum'] = count($login);

                    $data['lastTime'] = $login[0];

                }else{

                    $data['loginNum'] = '1';

                    $data['lastTime'] = '';

                }



                $data['page'] = "index.html";

                $data['menu'] = array('index','index');

 		         $this->load->view('template.html',$data);

	}



}







?>

	