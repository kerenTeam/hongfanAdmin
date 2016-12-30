<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  电子券管理
 *
 * */
require_once(APPPATH.'controllers/Default_Controller.php');
class Electronic extends Default_Controller {
    //电子劵列表
    public $view_electronicList = "electronic/electronicList.html"; 
    //电子劵新增
    public $view_addElectronic = "electronic/addElectronic.html";
    //电子卷编辑
    public $view_editElectronic = "electronic/editElectronic.html";
    function __construct()
    {
        parent::__construct();
        $this->load->model('Activity_model');
    }
    //electronic列表
    function electronicList(){
         $data['page']= $this->view_electronicList;
         $data['menu'] = array('electronic','electronicList');
         $this->load->view('template.html',$data);
    }

    //返回所有卡卷
    function get_electr_list(){
        if($_POST){
            $list = $this->Activity_model->get_coupons();
            if(empty($list)){
                echo "2";
            }else{
                echo json_encode($list);
            }
        }else{
            echo "2";
        }
    }

    //新增electronic
    function addElectronic(){
       $data['page']= $this->view_addElectronic;
         $data['menu'] = array('electronic','electronicList');
         $this->load->view('template.html',$data);
    }
    //编辑electronic
    function editElectronic(){
        $id = intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{



             $data['page']= $this->view_editElectronic;
             $data['menu'] = array('electronic','electronicList');
             $this->load->view('template.html',$data);
        }
    }

    //删除优惠劵
    function del_coupon(){
        if($_POST){
            $id = $_POST['id'];
            if(empty($id)){
                echo "2";exit;
            }
            if($this->Activity_model->del_coupon($id)){
                echo "1";
            }else{
                echo "2";
            }
        }else{ 
            echo "2";
        }
    }
}

