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







