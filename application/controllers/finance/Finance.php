<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Default_Controller.php');
/*
*   发现板块
*/
class Finance extends CI_Controller {

    public $view_finance_order = "finance/finance_order.html";


    function __construct()
    {
        parent::__construct();
        $this->load->model('MallShop_model');
    }


    function mallOrder(){

        $data['page'] = $this->view_finance_order;
        $data['menu'] = array('finance','mallOrder');
        $this->load->view('template.html',$data);
    }

    //返回所有以支付订单订单
    function ret_moll_order(){
        if($_POST){
            $list = $this->MallShop_model->get_moll_order();
            if(!empty($list)){
                echo json_encode($list);
            }else{
                echo "3";
            }
        }else{
            echo "2";
        }
    }

    //查看详情
    function mollOrder_info(){
        $id = intval($this->uri->segment(4));
        if($id != 0){

        }else{
            $this->load->view('404.html');
        }
    }




}