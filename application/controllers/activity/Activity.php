<?php  

defined('BASEPATH') OR exit('No direct script access allowed');

/*

活动

 * */

require_once(APPPATH.'controllers/Default_Controller.php');

class Activity extends Default_Controller {

	
	function __construct()
	{
		parent::__construct();
	}


	//双旦活动
	function newYearsDay(){

		$data['page'] = 'friends/friends_recommend.html';
        $data['menu'] = array('activity','newYearsDay');
        $this->load->view('template.html',$data);
	}

	//返回双旦活动
	function newYesrsDay(){
		
	}



}


?>