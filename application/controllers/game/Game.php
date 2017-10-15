<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Default_Controller.php');
/**
* 
*/
class Game extends Default_Controller
{
	

	public $view_gameList = 'game/gameList.html';
	public $view_gameInfo = 'game/gameInfo.html';
	public $view_awardRecord = 'game/awardRecord.html';


	function __construct()
	{
		parent::__construct();	
	}


	function gameList(){

		$data['page'] = $this->view_gameList;
        $data['menu'] = array('game','gameList');
        $this->load->view('template.html',$data);

	}

	function gameInfo(){

		$data['page'] = $this->view_gameInfo;
        $data['menu'] = array('game','gameList');
        $this->load->view('template.html',$data);

	}

	function awardRecord(){

		$data['page'] = $this->view_awardRecord;
        $data['menu'] = array('game','gameList');
        $this->load->view('template.html',$data);

	}







}