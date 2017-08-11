<?php

class welcome_model extends CI_Model
{
    //查询
        //查询
    function select($table,$sort){
        $query = $this->db->order_by($sort,'desc')->get($table);
        return $query->result_array();
    }
    //分页查询
    function select_page($table,$page,$size,$sort){
        $query = $this->db->order_by($sort,'desc')->limit($size,$page)->get($table);
        return $query->result_array();
    }

    //新增
    function insert($table,$data){
        return $this->db->insert($table,$data);
    }

    //编辑
    function updata($table,$where,$id,$data){
        return $this->db->where($where,$id)->update($table,$data);
    }
    //删除
    function delete($table,$where,$id){
        return $this->db->where($where,$id)->delete($table);
    }

    //查询详情
    function select_info($table,$where,$id){
        $query = $this->db->where($where,$id)->get($table);
        return $query->row_array();
    }

    //根据某些条件查询数据
    function select_where($table,$where,$data,$sort){
        $query = $this->db->where($where,$data)->order_by($sort,'desc')->get($table);
        return $query->result_array();
    }

    //返回自定义条数数据
    function select_limit($table,$where,$id,$sort,$limit){
         $query = $this->db->where($where,$id)->order_by($sort,'desc')->limit($limit)->get($table);
        return $query->result_array();
    }
}





?>