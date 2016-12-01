<?php
/*
 * 本地生活
 *
 * */
defined('BASEPATH') OR exit('No direct script access allowed');
class module_model extends CI_Model{
    //分类表
    public $cate = 'hf_local_service_cates';
    //保姆、维修、开锁信息表
    public $service = 'hf_local_service';
    //房产中介表
    public $house = 'hf_local_house';
	//二手市场
	public $mark = 'hf_local_used_market';
	//快递上门 
	public $express = 'hf_local_express';
	//超市比价
	public $market_data = 'hf_local_market_data';

    function __construct()
    {
        parent::__construct();
    }
    //获取所有
    function get_cates($c_id){
        $where['c_id'] = $c_id;
        $query = $this->db->where($where)->order_by('sort','asc')->get($this->cate);
        return $query->result_array();
    }
    //获取某一个分类信息
    function get_cateinfo($id){
        $where['id'] = $id;
        $query = $this->db->where($where)->get($this->cate);
        return $query->row_array();
    }

    //新增分类
    function add_cates($data){
        return $this->db->insert($this->cate,$data);
    }
    //编辑分类
    function edit_cates($id,$data){
        $where['id'] = $id;
        return $this->db->where($where)->update($this->cate,$data);
    }

    //获取普通信息
    function get_serviceList($type_id){
        $where['type_name']  = $type_id;
        $query = $this->db->where($where)->order_by('create_time','desc')->get($this->service);
        return $query->result_array();
    }
	//普通信息 分页
	function get_serviceList_page($type_id,$off,$page){
		$where['type_name']  = $type_id;
        $query = $this->db->where($where)->order_by('create_time','desc')->limit($off,$page)->get($this->service);
        return $query->result_array();
	}
	
	//获取普通信息详情
	function get_serviceinfo($id){
		$where['id'] = $id;
		$query = $this->db->where($where)->get($this->service);
		return $query->row_array();
	}

    //房产信息
    function get_houst(){
        $query = $this->db->order_by('create_time','desc')->get($this->house);
        return $query->result_array();
    }
	//房产信息 分页
	function get_houst_page($off,$page){
		$query = $this->db->order_by('create_time','desc')->limit($page,$off)->get($this->house);
		return $query->result_array();
	}
	
	//获取房产信息详情
	function get_houstinfo($id){
		$where['id'] = $id;
		$query = $this->db->where($where)->get($this->house);
		return $query->result_array();
	}
	
    //二手市场
    function get_mark(){
		$query = $this->db->order_by('create_time','desc')->get($this->mark);
		return $query->result_array();
	}
	//二手市场 分页
	function get_mark_page($off,$page){
		$query = $this->db->order_by('create_time','desc')->limit($page,$off)->get($this->mark);
		return $query->result_array();
	}
	//获取二手市场详情
	function get_markinfo($id){
		$where['id'] = $id;
		$query = $this->db->where($where)->get($this->mark);
		return $query->row_array();
	}
	
	//快递上门
	function get_express(){
		$query = $this->db->order_by('create_time','desc')->get($this->express);
		return $query->result_array();
	}
	//快递上门 分页
	function get_express_page($off,$page){
		$query = $this->db->order_by('create_time','desc')->limit($page,$off)->get($this->express);
		return $query->result_array();
	}
	
	//超市比价
	function get_market_data(){
		$query = $this->db->order_by('date','desc')->get($this->market_data);
		return $query->result_array();
	}
	//超市比价 分页
	function get_market_data_page($off,$page){
		$query = $this->db->order_by('date','desc')->limit($page,$off)->get($this->market_data);
		return $query->result_array();
	}
	
	//获取超市比价详情
	function get_market_data_info($id){
		$where['id'] = $id;
		$query = $this->db->where($where)->get($this->market_data);
		return $query->row_array();
	}


}