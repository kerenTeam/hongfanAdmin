<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
*   商品管理
*/
class mallShop_model extends CI_Model
{
    //商品分类表
    public $shop_cates = "hf_mall_category";
    //商品列表
    public $shop_goods = "hf_mall_goods";
    function __construct()
    {
        parent::__construct();
    }

    //返回商品分类列表
    function get_goods_cates(){
        $query = $this->db->order_by('sort','asc')->get($this->shop_cates);
        return $query->result_array();
    }
    //获取顶级分类
    function get_cate_level(){
        $where['parentid'] = '0';
        $query = $this->db->where($where)->order_by('sort','asc')->get($this->shop_cates);
        return $query->result_array();
    }
    //新增分类
    function add_store_cate($data){
        return $this->db->insert($this->shop_cates,$data);
    }
    //删除分类
    function del_store_cate($id){
        $where['catid'] = $id;
        return $this->db->where($where)->delete($this->shop_cates);
    }
    //根据id返回分类
    function get_cateInfo($id){
        $where['catid'] = $id;
        $query = $this->db->where($where)->get($this->shop_cates);
        return $query->row_array();
    }
    //编辑分类
    function edit_store_cate($id,$data){
        $where['catid'] = $id;
        return $this->db->where($where)->update($this->shop_cates,$data);
    }
    //分类搜索
    function search_cates($sear){
        $query = $this->db->like('catname',$sear,'both')->get($this->shop_cates);
        return $query->result_array();
    }

}






 ?>