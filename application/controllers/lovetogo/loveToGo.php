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
	function __construct()
	{
		 parent::__construct();
	}

	//爱购 商品列表
    function loveToGoList(){
        $data['page'] = $this->view_loveToGoList;
        $data['menu'] = array('loveToGo','loveToGoList');
        $this->load->view('template.html',$data);
    }

	//爱购 商品详情
    function loveToGogoodDetail(){
        $data['page'] = $this->view_loveToGogoodDetail;
        $data['menu'] = array('loveToGo','loveToGogoodDetail');
        $this->load->view('template.html',$data);
    }


}







