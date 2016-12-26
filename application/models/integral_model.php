<?php 
/**
*   积分商城 + 爱购保税商品
*/
class integral_model extends CI_Model
{
    //商品表
    public $shop_goods = 'hf_mall_goods';
    //分类表
    public $shop_cates = 'hf_mall_category';

    
    function __construct()
    {
       parent::__construct();
    }

     //返回商品分类列表
    function get_goods_cates(){
        $query = $this->db->order_by('sort','asc')->get($this->shop_cates);
        return $query->result_array();
    }
    //积分商城
    function get_goods_list(){
        $this->db->from('hf_mall_goods');
        $this->db->join('hf_mall_category', 'hf_mall_category.catid = hf_mall_goods.categoryid');
        $query = $this->db->where('differentiate','2')->order_by('hf_mall_goods.create_time','desc')->get();
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
    //编辑商品
    function edit_goods($id,$data){
        $where['goods_id'] = $id;
        return $this->db->where('differentiate','2')->where($where)->update($this->shop_goods,$data);
    }
    //删除商品
    function del_goods($id){
        $where['goods_id'] = $id;
        return $this->db->where($where)->delete($this->shop_goods);
    }

    //爱购商品类表
    function get_igo_goods(){
        $where['differentiate'] = '3';
        $this->db->select('goods_id,open_iid,title,price,thumb,commission_price,commission_rate');
        $query = $this->db->where($where)->get($this->shop_goods);
        return $query->result_array();
    }


}

 ?>