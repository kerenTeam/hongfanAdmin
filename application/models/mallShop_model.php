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
    //店铺表
    public $shop_store = 'hf_shop_store';
    //商品评论表
    public $shop_comment = 'hf_mall_comment'; 
    //商家订单表
    public $shop_order = 'hf_mall_order';  
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
    //返会商家店铺
    function get_store_list($userid){
        $where['business_id'] = $userid;
        $query = $this->db->where($where)->get($this->shop_store);
        return $query->row_array();
    }

    //商家商品列表
    function get_goods_list($storeid){
        $where['storeid'] = $storeid;
        $query = $this->db->where($where)->order_by('create_time','desc')->get($this->shop_goods);
        return $query->result_array(); 
    }
    //商品上下架
    function edit_goods_state($id,$data){
        $where['goods_id'] = $id;
        return $this->db->where($where)->update($this->shop_goods,$data);
    }
    //新增商品
    function add_shop_goods($data){
        return $this->db->insert($this->shop_goods,$data);
    }
    //根据id返会商品详情
    function get_goodsInfo($id){
        $where['goods_id'] = $id;
        $query = $this->db->where($where)->get($this->shop_goods);
        return $query->row_array();
    }
    //根据商品返回评论
    function get_goods_comment($id){
        $where['goodsid'] = $id;
        $query = $this->db->where($where)->get($this->shop_comment);
        return $query->result_array();
    }
    //编辑商品
    function edit_goods($id,$data){
        $where['goods_id'] = $id;
        return $this->db->where($where)->update($this->shop_goods,$data);
    }
    //删除商品
    function del_goods($id){
        $where['goods_id'] = $id;
        return $this->db->where($where)->delete($this->shop_goods);
    }

    //返回商家订单列表
    function get_store_orders($storeid){

        $sql = "SELECT a.order_id,a.order_UUID,a.buyer,a.goods_data,a.seller,a.amount,a.create_time,a.updatetime,a.order_status,b.user_id,b.username from hf_mall_order as a,hf_user_member as b where a.buyer = b.user_id and seller = $storeid";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    //修改订单信息
    function edit_order_state($id,$data){
        $where['order_id'] = $id;
        return $this->db->where($where)->update($this->shop_order,$data);
    }
    //根据订单id返回订单数据
    function get_order_info($id){
        $where['order_id'] = $id;
        $query = $this->db->where($where)->get($this->shop_order);
        return $query->row_array();
    }



    //返回店铺详情
    function get_basess_info($storeid){
        $where['store_id'] = $storeid;
        $query = $this->db->where($where)->get($this->shop_store);
        return $query->row_array();
    }
    //修改店铺详情
    function edit_store_info($id,$data){
        $where['store_id'] = $id;
        return $this->db->where($where)->update($this->shop_store,$data);
    }

}






 ?>