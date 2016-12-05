<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class moll_model extends CI_Model
{
	//商场详情
	public $market = 'hf_market_info';
	//楼层关系
	public $floor = 'hf_market_floor';
	
	function __construct()
	{
		parent::__construct();
	}

	//商场详情
	function get_marketinfo(){
		$query = $this->db->get($this->market);
		return $query->row_array();
	}



}


 ?>