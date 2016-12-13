<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
*     管理员商城管理 
*/
class shop_model extends CI_Model
{
    //商家用户表
    public $member = "hf_user_member";
    //店铺表
    public $shop_store = "hf_shop_store";
    //业态表
    public $store_type = "hf_shop_store_type";
    //商品表
    public $goods = "hf_mall_goods";
    function __construct()
    {
        parent::__construct();
    }

   
    //获取所有店铺
    function shop_list(){
        $query = $this->db->order_by('create_time','desc')->get($this->shop_store);
        return $query->result_array();
    }
    //修改店铺状态
    function edit_shop_state($id,$data){
        $where['store_id'] = $id;
        return $this->db->where($where)->update($this->shop_store,$data);
    }
    //删除店铺
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
    //返回二级业态
    function store_type_tow($gid){
        $where['gid'] = $gid;
        $query = $this->db->where($where)->get($this->store_type);
        return $query->result_array();
    }
    
    //获取商家信息
    function get_store_Info($id){
        $where['store_id'] = $id;
        $query = $this->db->where($where)->get($this->shop_store);
        return $query->row_array();
    }    
    //获取商户登录用户
    function get_login_store($userid){
        $sql = "SELECT username,password FROM $this->member where user_id = $userid";
        $query = $this->db->query($sql);
        return $query->row_array();
    }
    //修改商家信息
    function edit_store_info($id,$data){
        $where['store_id'] = $id;
        return $this->db->where($where)->update($this->shop_store,$data);
    }
    //新增商家
    function add_store_info($data){
        return $this->db->insert($this->shop_store,$data);
    }

}






 ?>