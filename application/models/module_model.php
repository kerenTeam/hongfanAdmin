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
        $query = $this->db->where($where)->get($this->service);
        return $query->result_array();
    }

    //房产信息
    function get_houst(){
        $query = $this->db->order_by('cerate_time','desc')->get($this->house);
        return $query->result_array();
    }

    //二手市场
    //function


}