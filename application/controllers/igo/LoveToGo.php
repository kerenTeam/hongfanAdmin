<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
require_once(APPPATH.'controllers/Default_Controller.php');

class LoveToGo extends Default_Controller
{
	public $view_loveToGoList = 'loveToGo/loveToGoList.html';	
	public $view_loveToGogoodDetail = 'loveToGo/loveToGogoodDetail.html';
	public $view_loveToGoOrderList = 'loveToGo/loveToGoOrderList.html';
    function __construct()
	{
		 parent::__construct();
         $this->load->model('Integral_model');

	}

  
    //获取远程爱购商品列表
    function get_remote_goods(){
        if($_POST){
            $page = $_POST['page'];
            $goods_list = $this->Integral_model->get_igo_goods();
            if(empty($goods_list)){
                echo "2";
            }else{
                echo json_encode($goods_list);
            }
        }else{
            echo "2";
        }
    }
   
    //爱购 商品列表
    function loveToGoList(){

        $data['page'] = $this->view_loveToGoList;
        $data['menu'] = array('loveToGo','loveToGoList');
        $this->load->view('template.html',$data);
    }
    //爱购 订单列表
    function loveToGoOrderList(){

        $data['page'] = $this->view_loveToGoOrderList;
        $data['menu'] = array('loveToGo','loveToGoOrderList');
        $this->load->view('template.html',$data);
    }
    //爱购 本地商品详情
    function loveToGogoodLocalDetail(){
        if(!$_GET){
            $this->load->view('404.html');
        }else{
            $post_data = array(  
              'appkey' => IGOAPPKEY,  
              'appsecret' => IGOAPPSECRET,
              'open_iid' => $_GET['openid']
            ); 
            $post = curl_post(IGOINFOAPIURL, $post_data);  
            $goods = json_decode($post,true);
            $data['goods'] = $goods['data'];
          
            $data['page'] = $this->view_loveToGogoodDetail;
            $data['menu'] = array('loveToGo','loveToGoList');
            $this->load->view('template.html',$data);
        }
    }





}







