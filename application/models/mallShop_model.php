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

}






 ?>