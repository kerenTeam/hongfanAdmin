<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  商城管理
 *
 * */
require_once(APPPATH.'controllers/Default_Controller.php');

class Native extends Default_Controller {

    //土特产商品列表
    public $view_native_index = "store/native_index.html";
    //土特产订单列表
    public $view_native_order = "store/native_order.html";
    //土特产新增
    public $view_native_add = "store/native_add.html";
    //土特产编辑
    public $view_native_edit = "store/native_edit.html";
    function __construct()
    {
         parent::__construct();
         $this->load->model('Integral_model');
    }

    //土特产商品列表
    function native_index(){

        $data['page'] = $this->view_native_index;
        $data['menu'] = array('native','native_index');
        $this->load->view('template.html',$data);
    }

    //返回土特产商品
    function get_native_list(){
        if($_POST){
            $list = $this->Integral_model->
        }else{
            echo "2";
        }
    }

    //土特产订单列表
    function native_order(){
        $data['page'] = $this->view_native_index;
        $data['menu'] = array('native','native_order');
        $this->load->view('template.html',$data);
    }
    //土特产新增
    function native_add(){
        $data['page'] = $this->view_native_add;
        $data['menu'] = array('native','native_add');
        $this->load->view('template.html',$data);
    }
    //土特产编辑
    function native_edit(){
        $data['page'] = $this->view_native_edit;
        $data['menu'] = array('native','native_edit');
        $this->load->view('template.html',$data);
    }
}
?>