<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  商场活动管理
 *
 * */
require_once(APPPATH.'controllers/Default_Controller.php');
class MarketActivity extends Default_Controller {
    //商场活动列表
    public $view_marketActivity = "marketActivity/marketActivityList.html"; 
    //商场活动新增
    public $view_marketAddActivity = "marketActivity/marketAddActivity.html.html";
    //商场活动编辑
    public $view_marketEditActivity = "marketActivity/marketEditActivity.html";
    function __construct()
    {
        parent::__construct();
        $this->load->model('Activity_model');
    }
    //商场活动列表
    function activity(){   	 

         $data['page']= $this->view_marketActivity;
         $data['menu'] = array('marketActivity','activity');
         $this->load->view('template.html',$data);

    }
    //获取所有活动列表
    function get_activity_list(){
        if($_POST){
            $list = $this->Activity_model->get_activity_list();
            if(empty($list)){
                echo "2";
            }else{
                echo json_encode($list);
            }
        }else{
            echo "2";
        }
    }


    //新增商场活动
    function marketAddActivity(){
       $data['page']= $this->view_marketAddActivity;
         $data['menu'] = array('marketActivity','marketAddActivity');
         $this->load->view('template.html',$data);
    }
    //编辑商场活动
    function marketEditActivity(){
        $data['page']= $this->view_marketEditActivity;
         $data['menu'] = array('marketActivity','marketEditActivity');
         $this->load->view('template.html',$data);
    }

    //
    function del_Activity(){
        if($_POST){
            $id = $_POST['id'];
            if(empty($id)){
                echo "2";exit;
            }
            if($this->Activity_model->del_Activity($id)){
                echo "1";
            }else{
                echo "2";
            }
        }else{
            echo "2";
        }
    }
}

