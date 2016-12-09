<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
*     商家管理 
*/
class shop_model extends CI_Model
{
    //商家表
    public $shop_store = "hf_shop_store";
    //业态表
    public $store_type = "hf_shop_store_type";
    function __construct()
    {
        parent::__construct();
    }

    //获取所有商家
    function shop_list(){
        $query = $this->db->order_by('create_time','desc')->get($this->shop_store);
        return $query->result_array();
    }
    //修改商家状态
    function edit_shop_state($id,$data){
        $where['store_id'] = $id;
        return $this->db->where($where)->update($this->shop_store,$data);
    }
    //删除商家
    function del_shop_store($id){
        $where['store_id'] = $id;
        return $this->db->where($where)->delete($this->shop_store);
    }
  
    //获取顶级业态
    function store_type_level(){
        $where['gid'] = '0';
        $query = $this->db->where($where)->get($this->store_type);
        return $query->result_array();
    }
    

}






 ?>