<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Default_Controller.php');

/**
 *  后台 首页
*/
class Admin extends Default_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	function index(){
        unset($_SESSION['businessId']);
        $data['page'] = "index.html";
        $data['menu'] = array('index','index');
 		$this->load->view('template.html',$data);
	}
}



?>
