<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/default_Controller.php');

/**
 *  后台 首页
*/
class admin extends default_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	function index(){
        $data['page'] = "index.html";
        $data['menu'] = array('index','index');
 		$this->load->view('template.html',$data);
	}


}



?>
