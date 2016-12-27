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
	function __construct()
	{
		 parent::__construct();
         $this->load->model('Integral_model');
         $plateid = $this->user_model->group_permiss($this->session->users['gid']);
         $plateid = json_decode($plateid,true);
         if(!empty($plateid)){
            if(!in_array('0',$plateid) && !in_array('8',$plateid)){
                echo "<script>alert('您没有权限访问！');window.location.href='".site_url('/Admin/index')."';</script>";exit;
            }
         }else{
             echo "<script>alert('您没有权限访问！');window.location.href='".site_url('/Admin/index')."';</script>";exit;
         }


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







