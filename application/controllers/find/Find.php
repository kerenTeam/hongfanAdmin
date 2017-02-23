<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Default_Controller.php');
/*
*   发现板块
*/
class Find extends Default_Controller {

	//文章；列表
	public $view_content = "find/findContent.html";
	//分类列表
	public $view_cates = 'find/findCates.html';
	//标签列表
	public $view_tags = 'find/findTags.html';


    function __construct()
    {
        parent::__construct();
    }

    //文章列表	
	function findContent(){
		
        $data['page'] = $this->view_content;
        $data['menu'] = array('find','findContent');
 		$this->load->view('template.html',$data);
    }

    //分类列表
    function findCates(){

    	$data['page'] = $this->view_cates;
        $data['menu'] = array('find','findCates');
 		$this->load->view('template.html',$data);
    }
    //标签列表
    function findTags(){

    	$data['page'] = $this->view_tags;
        $data['menu'] = array('find','findTags');
 		$this->load->view('template.html',$data);
    }



}
