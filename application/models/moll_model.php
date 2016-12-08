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
	//业态配置
	public $stote_type = 'hf_shop_store_type';
	
	function __construct()
	{
		parent::__construct();
	}
	//返回所有业态
	function get_storetypeList(){

		$where['state'] ='1';
		$query = $this->db->where($where)->order_by('sort','asc')->get($this->stote_type);
		return $query->result_array();
	}
	//业态 分页 
	function get_storetype_page($off,$page){
		$where['state'] ='1';
		$query = $this->db->where($where)->order_by('sort','asc')->limit($off,$page)->get($this->stote_type);
		return $query->result_array();
	}
	//根据业态gid返回
	function get_store($gid){
		$where['gid'] = $gid;
		$query = $this->db->where($where)->order_by('gid','asc')->get($this->stote_type);
		return $query->result_array();
	}
	//新增业态
	function add_storetype($data){
		return $this->db->insert($this->stote_type,$data);
	}
	//根据业态ID返回详情
	function get_storeInfo($id){
		$where['id'] = $id;
		$query = $this->db->where($where)->get($this->stote_type);
		return $query->row_array();
	}
	//编辑业态
	function edit_storeYetai($id,$data){
		$where['id'] = $id;
		return $this->db->where($where)->update($this->stote_type,$data);
	}
	//删除业态
	function del_storeType($id){
		$where['id'] = $id;
		return $this->db->where($where)->delete($this->stote_type);
	}

	//商场详情
	function get_marketinfo(){
		$query = $this->db->get($this->market);
		return $query->row_array();
	}



}


 ?>