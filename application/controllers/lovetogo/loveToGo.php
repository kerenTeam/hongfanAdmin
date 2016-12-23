<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
require_once(APPPATH.'controllers/default_Controller.php');

class loveToGo extends default_Controller
{
	public $view_loveToGoList = 'loveToGo/loveToGoList.html';	
	public $view_loveToGogoodDetail = 'loveToGo/loveToGogoodDetail.html';
    public $view_loveToGoListLocal = 'loveToGo/loveToGoListLocal.html';   
    public $view_loveToGogoodLocalDetail = 'loveToGo/loveToGogoodLocalDetail.html';
	function __construct()
	{
		 parent::__construct();
	}
    //爱购 本地商品
    function loveToGoListLocal(){
        $data['page'] = $this->view_loveToGoListLocal;
        $data['menu'] = array('loveToGo','loveToGoListLocal');
        $this->load->view('template.html',$data);
    }

    //爱购 本地商品详情
    function loveToGogoodLocalDetail(){
        $data['page'] = $this->view_loveToGogoodDetail;
        $data['menu'] = array('loveToGo','loveToGogoodLocalDetail');
        $this->load->view('template.html',$data);
    }

    //获取远程爱购商品列表
    function get_remote_goods(){
        if($_POST){
            $page = $_POST['page'];
            $post_data = array(  
              'appkey' => IGOAPPKEY,  
              'appsecret' => IGOAPPSECRET,
              'page_no' => $page,
              'page_size' => 100
            ); 
            $post = curl_post(IGOLISTAPIURL, $post_data);  
            $goods = json_decode($post,true);
            $goods_list = array_values($goods['data']['lists']);
            if(empty($goods_list)){
                echo "2";
            }else{
                echo json_encode($goods_list);
            }
        }else{
            echo "2";
        }
    }
    //获取远程爱购商品详情
    function remote_goods_info(){
        if($_POST){
            echo "1";
        }else{
            echo "2";
        }
    }
	//爱购 商品库
    function loveToGoList(){

        $data['page'] = $this->view_loveToGoList;
        $data['menu'] = array('loveToGo','loveToGoList');
        $this->load->view('template.html',$data);
    }

	//爱购 商品库 商品详情
    function loveToGogoodDetail(){
        $data['page'] = $this->view_loveToGogoodDetail;
        $data['menu'] = array('loveToGo','loveToGogoodDetail');
        $this->load->view('template.html',$data);
    }


}







