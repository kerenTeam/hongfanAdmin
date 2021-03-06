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
      //推荐商品，或商家
    public $store_goods = "hf_shop_active_store_goods";

    function __construct()
    {
        parent::__construct();
    }

    //返回商品分类列表
    function get_goods_cates($parentid,$type){
        $query = $this->db->where('parentid',$parentid)->where('type',$type)->order_by('sort','asc')->get($this->shop_cates);
        return $query->result_array();
    } 
       //返回商品分类列表
    function get_cates_parent($parentid){
        $query = $this->db->where('type',$parentid)->order_by('sort','asc')->get($this->shop_cates);
        return $query->result_array();
    } 
    //返回所有分类
    function get_mall_cates(){
        $query = $this->db->order_by('sort','asc')->get($this->shop_cates);
        return $query->result_array();
    }

    //返回所有分类
    function get_goods_cates_list($id){
        $where['type'] = $id;
        $query = $this->db->where($where)->order_by('sort','asc')->get($this->shop_cates);
        return $query->result_array();
    }
    //获取顶级分类
    function get_cate_level($type){
        $where['parentid'] = '0';
        $query = $this->db->where($where)->where('type',$type)->order_by('sort','asc')->get($this->shop_cates);
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
    function search_cates($sear,$type){
        $where['type'] = $type;
        $query = $this->db->where($where)->like('catname',$sear,'both')->get($this->shop_cates);
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
        $this->db->select('a.*, b.catname');
        $this->db->from('hf_mall_goods a');
        $this->db->join('hf_mall_category b', 'b.catid = a.categoryid','left');
        $query = $this->db->where('storeid',$storeid)->where('goods_state !=','2')->order_by('a.goods_id','desc')->get();
        return $query->result_array(); 
    }
    
    //商品上下架
    function edit_goods_state($id,$data){
        $where['goods_id'] = $id;
        return $this->db->where($where)->update($this->shop_goods,$data);
    }
    //新增商品
    function add_shop_goods($data){
         $this->db->insert($this->shop_goods,$data);
         return $this->db->insert_id();
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
        $sql = "SELECT a.*,b.user_id,b.nickname from hf_mall_order as a,hf_user_member as b where a.buyer = b.user_id and a.seller = '$storeid' order by a.create_time desc";
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
    //根据uuid返回支付信息
    function ret_order_paydata($uuid){
        $where['repay_UUID'] = $uuid;
        $query = $this->db->where($where)->get("hf_mall_order_repaydata");
        return $query->row_array();
    }


    //根据类型返回所有商家
    function ret_store_type($type,$store_distinction){
        $where['store_distinction'] = $store_distinction;
        $where['store_type'] = $type;
        $query = $this->db->where($where)->order_by('store_id','desc')->get($this->shop_store);
        return $query->result_array();
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
       $this->db->select('a.*,b.nickname,c.title');

        $this->db->from('hf_mall_comment as a');
        $this->db->join('hf_user_member as b','a.buyerid = b.user_id','left');
        $this->db->join('hf_mall_goods as c','a.goodsid = c.goods_id','left');
        $query =  $this->db->where('a.stroeid', $store_id)->order_by('a.seller_ctime','desc')->get();
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
    //返回所有购物中心商品列表
    function get_since_goodslist($type){
        $this->db->select('a.*,b.store_name,c.catname');
        $this->db->from('hf_mall_goods as a');
        $this->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
        $this->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
        $query = $this->db->where('goods_state !=','2')->group_start()->where('a.goods_state',$type)->group_end()->order_by("a.create_time",'desc')->get();
        return $query->result_array();
    }


    //返回回收站商品数据
    function get_godosRecycle(){
        $this->db->select('a.*,b.store_name,c.catname');
        $this->db->from('hf_mall_goods as a');
        $this->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
        $this->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
        $query = $this->db->where('a.goods_state','2')->order_by("a.create_time",'desc')->get();
        return $query->result_array();
    }

    //返回所有商品列表
    function get_goodslist(){
        $this->db->select('a.*,b.store_name,c.catname');
        $this->db->from('hf_mall_goods as a');
        $this->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
        $this->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
        $query = $this->db->where('goods_state !=','2')->order_by("a.goods_id",'desc')->get();
        return $query->result_array();
    }
    //返回特价商品列表
    function get_specials_goods(){
        $this->db->select('a.*,b.store_name,c.catname');
        $this->db->from('hf_mall_goods as a');
        $this->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
        $this->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
        $query = $this->db->where('a.specials_state','1')->where('a.goods_state','1')->order_by("a.sort",'asc')->get();
        return $query->result_array();
    }
    
    //返回推荐商品列表
    function get_remment_goods(){
        $this->db->select('a.*,b.store_name,c.catname');
        $this->db->from('hf_mall_goods as a');
        $this->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
        $this->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
        $query = $this->db->where('a.recommend','1')->where('goods_state','1')->order_by("a.sort",'asc')->get();
        return $query->result_array();
    }

    //返回首页推荐数据
    function ret_recommentType($type){
        $this->db->select('a.*,b.store_name,c.catname');
        $this->db->from('hf_mall_goods as a');
        $this->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
        $this->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
        $query = $this->db->where('a.recommentType',$type)->order_by("a.sort",'asc')->get();
        return $query->result_array();
    }
    
    //返回分页商品列表
    function get_goodslist_page($page,$off){
        $this->db->select('a.*,b.store_name,c.catname');
        $this->db->from('hf_mall_goods as a');
        $this->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
        $this->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
        $query = $this->db->where('goods_state !=','2')->order_by("a.create_time",'desc')->limit($off,$page)->get();
        return $query->result_array();
    }

    //返回所有订单
    function get_order_list(){
        $this->db->select('a.*,b.store_name,c.nickname');
        $this->db->from('hf_shop_store as b');
        $this->db->join('hf_mall_order as a','a.seller = b.store_id','left');
        $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
        $query = $this->db->where('a.admin_delOrder','1')->where('a.order_type !=','0')->order_by('a.pay_time DESC,a.create_time DESC')->limit(100)->get();
        return $query->result_array();
    }

    //返回回收站订单
    function ret_orderRe($type){
        $this->db->select('a.*,b.store_name,c.username,c.nickname');
        $this->db->from('hf_mall_order as a');
        $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');
        $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
        $query = $this->db->where('order_type',$type)->where('a.admin_delOrder !=','1')->order_by('a.create_time','desc')->get();
        return $query->result_array();
    }

    function del_store_order($id){
        $where['order_id'] = $id;
        return $this->db->where($where)->delete($this->shop_order);
    }



    //获取所有活动
    function get_activity_list($storeid){
        $query = $this->db->where('storeid',$storeid)->get($this->shop_activity);
        return $query->result_array();
    }

    //新增商家活动
    function add_activity($data){
        return $this->db->insert($this->shop_activity,$data);
    }
    //获取商家活动详情
    function get_activity_info($id){
        $where['id'] = $id;
        $query = $this->db->where($where)->get($this->shop_activity);
        return $query->row_array();
    }

    //编辑活动详情
    function edit_activity_info($id,$data){
        $where['id'] = $id;
        return $this->db->where($where)->update($this->shop_activity,$data);
    }    
    //删除活动
    function del_Activity($id){
         $where['id'] = $id;
        return $this->db->where($where)->delete($this->shop_activity);
    }


    //返回商城展销商品
    function get_active_sales($type){
        $where['type'] = $type;
        $query = $this->db->where($where)->get($this->store_goods);
        return $query->result_array();
    }

    //删除展销
    function del_Sales($id){
        $where['id'] = $id;
        return $this->db->where($where)->delete($this->store_goods);
    }

    //获取展销商品信息
    function get_goods_title($id){
        $where['goods_id'] = $id;
        $this->db->select('goods_id,title,thumb');
        $query = $this->db->where($where)->get($this->shop_goods);
        return $query->row_array();
    }

    //获取某个展销信息
    function get_sales_info($id){
        $where['id'] = $id;
        $query = $this->db->where($where)->get($this->store_goods);
        return $query->row_array();
    }

    //修改某个展销信息
    function edit_salse($id,$data){
        $where['id'] = $id;
        return $this->db->where($where)->update($this->store_goods,$data);
    }

    //新增展销活动
    function add_sales($data){
        return $this->db->insert($this->store_goods,$data);
    }


    //新增商品并返回商品id
    function add_goods_id($data){
        $this->db->insert($this->shop_goods,$data);
        return $this->db->insert_id();
    }


    //获取商品属性
    function get_goods_parent($id){
        $where['g_id'] = $id;
        $query = $this->db->where($where)->order_by('id','asc')->get('hf_mall_goods_property');
        return $query->result_array();
    }

    //刪除商品所有屬性
    function del_goods_prop($id){
        $where['g_id'] = $id;
        return $this->db->where($where)->delete("hf_mall_goods_property");
    }

    //根据商品更新时间排序
    function get_goods_time($time){
        $this->db->select('a.*,b.store_name,c.catname');
        $this->db->from('hf_mall_goods as a');
        $this->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
        $this->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
        $query = $this->db->where('goods_state !=','2')->order_by("a.create_time",$time)->get();
        return $query->result_array();
    }

    //返回商品库存数排序
    function get_goods_amout($sort){
        $this->db->select('a.*,b.store_name,c.catname');
        $this->db->from('hf_mall_goods as a');
        $this->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
        $this->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
        $query = $this->db->where('goods_state !=','2')->order_by("a.amount",$sort)->get();
        return $query->result_array();
    } 
    //返回商品库存数排序
    function get_goods_price($sort){
        $this->db->select('a.*,b.store_name,c.catname');
        $this->db->from('hf_mall_goods as a');
        $this->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
        $this->db->join('hf_mall_category as c','a.categoryid = c.catid','left');
        $query = $this->db->where('goods_state !=','2')->order_by("a.price",$sort)->get();
        return $query->result_array();
    }

    //返回运费模板
    function get_express_temp(){
        $query = $this->db->get("hf_mall_goods_express");
        return $query->result_array();
    }


    //返回用户收货地址
    function ret_user_address($id){
        $where['id'] = $id;
        $query = $this->db->where($where)->get('hf_user_address');
        return $query->row_array();
    }

    //返回运费模板
    function ret_store_express($id){
        $where['express_id'] = $id;
        $query = $this->db->where($where)->get('hf_mall_goods_express');
        return $query->row_array();
    }   

    //返回所有以支付订单
    function get_moll_order(){
        $this->db->select('a.*,b.store_name,c.username,c.nickname,d.payType');
        $this->db->from('hf_mall_order as a');
        $this->db->join('hf_shop_store as b','a.seller = b.store_id','left');
        $this->db->join('hf_user_member as c','a.buyer = c.user_id','left');
        $this->db->join('hf_mall_order_repaydata as d','a.order_UUID = d.repay_UUID','left');
        $query = $this->db->where('order_status !=','1')->order_by('a.create_time','desc')->limit('200','0')->get();
        return $query->result_array();
    }

    //返回所有商家
    function ret_mollStore(){
        $where['store_distinction'] = '2';
        $where['state'] = '1';
        //$where['store_type'] = $type;
        $query = $this->db->where($where)->order_by('store_id','desc')->get($this->shop_store);
        return $query->result_array();
    }

    //更具uuid返回订单
    function retUuidOrder($uuid,$id){
        $query = $this->db->where('order_UUID',$uuid)->where('order_id !=',$id)->get($this->shop_order);
        return $query->result_array();
    }


}






 ?>