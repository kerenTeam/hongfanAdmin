<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
*   商品管理
*/
class MallShop_model extends CI_Model
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
    //优惠劵
    public $shop_coupon = "hf_shop_coupon"; 
     //优惠劵类型
    public $shop_coupon_type = "hf_shop_coupon_type";
    //活动表
    public $shop_activity = "hf_system_activity";
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
    //根据名称返回分类
    function get_cate_id($name){
        $where['catname'] = $name;
        $query = $this->db->where($where)->get($this->shop_cates);
        $res = $query->row_array();
        return $res['catid'];
    }
    //新增分类
    function add_store_cate($data){
        return $this->db->insert($this->shop_cates,$data);
    } 
    //新增分类 返回id
    function add_cate($data){
         $this->db->insert($this->shop_cates,$data);
         return $this->db->insert_id();
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
        $this->db->from('hf_mall_goods');
        $this->db->join('hf_mall_category', 'hf_mall_category.catid = hf_mall_goods.categoryid');
        $query = $this->db->where('storeid',$storeid)->where('differentiate','1')->order_by('hf_mall_goods.create_time','desc')->get();
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
      
        $query = $this->db->where($where)->where('commentid','0')->get($this->shop_comment);
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

    //返回店铺优惠券
    function get_store_coupon($storeid){
        $where['storeid'] = $storeid;
        $query = $this->db->where($where)->get($this->shop_coupon);
        return $query->result_array();
    }

    //返回商家所有评论
    function get_store_comment($store_id){
        //$where['storeid'] = $storeid;
       $this->db->select('a.*, b.username,c.title');

        $this->db->from('hf_mall_comment as a');
        $this->db->join('hf_user_member as b','a.buyerid = b.user_id','left');
        $this->db->join('hf_mall_goods as c','a.goodsid = c.goods_id','left');
        $query =  $this->db->where('a.stroeid', $store_id)->where('commentid','0')->get();
         return $query->result_array();
    } 
    function gte_store_reply($commentid){
        //$where['storeid'] = $storeid;
        $this->db->select('seller_comment');
        $this->db->from('hf_mall_comment');
        $query =  $this->db->where('commentid',$commentid)->get();
         return $query->row_array();
    }
    //修改评论状态
    function edit_comment_state($id,$data){
        $where['id'] = $id;
        return $this->db->where($where)->update($this->shop_comment,$data);
    }
    //删除评论
    function del_store_comment($id){
        $where['id'] = $id;
        return $this->db->where($where)->delete($this->shop_comment);
    }

    //获取会员卡类型
    function get_coupon_type(){
        $query = $this->db->get($this->shop_coupon_type);
        return $query->result_array();
    }
    //新增优惠劵
    function add_coupon($data){
        return $this->db->insert($this->shop_coupon,$data);
    }
    //获取优惠劵详情
    function get_conpon_info($id){
        $where['id'] = $id;
        $query = $this->db->where($where)->get($this->shop_coupon);
        return $query->row_array();
    }
    //编辑优惠劵
    function edit_coupon($id,$data){
        $where['id'] = $id;
        return $this->db->where($where)->update($this->shop_coupon,$data);
    }
    //删除
    function del_coupon($id){
        $where['id'] = $id;
        return $this->db->where($where)->delete($this->shop_coupon);
    }

    //返回所有商品列表
    function get_goodslist(){
        $this->db->select('a.*,b.store_name,c.catname');
        $this->db->from('hf_mall_goods as a');
        $this->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
        $this->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
        $query = $this->db->get();
        return $query->result_array();
    }

    //返回所有订单
    function get_order_list(){
        $this->db->select('a.*,b.store_name,c.username');
        $this->db->from('hf_mall_order as a');
        $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');
        $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
        $query = $this->db->get();
        return $query->result_array();
    }

    //获取所有活动
    function get_activity_list($storeid){
        $query = $this->db->where('storeid',$storeid)->get($this->shop_activity);
        return $query->result_array();
    }


}






 ?>