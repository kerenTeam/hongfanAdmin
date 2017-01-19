<?php 
/**
*    卡卷  +  商场活动
*/
class Activity_model extends CI_Model
{
    //卡卷表
    public $coupon = "hf_shop_coupon";
    public $coupon_type = "hf_shop_coupon_type";
    //优惠、普通活动表
    public $activity = "hf_system_activity";
    //一键钟情表
    public $marriage = "hf_local_marriage";

    function __construct()
    {
        parent::__construct();
    }
    //返回所有卡卷类型
    function get_coupon_type(){
        $query = $this->db->get($this->coupon_type);
        return $query->result_array();
    }
    //返回所有卡劵
    function get_coupons(){
        $this->db->select('a.*,b.store_name');
        $this->db->from('hf_shop_coupon as a');
        $this->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
        $query = $this->db->get();
        return $query->result_array();
    }
    //返回卡卷详情
    function get_electr_info($id){
        $where['id'] = $id;
        $query = $this->db->where($where)->get($this->coupon);
        return $query->row_array();
    }

    //新增卡劵
    function add_electronic($data){
        return $this->db->insert($this->coupon,$data);
    }

    //编辑卡卷
    function edit_electronic($id,$data){
        $where['id'] = $id;
        return $this->db->where($where)->update($this->coupon,$data);
    }

    //删除卡劵
    function del_coupon($id){
        $where['id'] = $id;
        return $this->db->where($where)->delete($this->coupon);
    }

    //返回所有活动列表
    function get_activity_list(){
        $this->db->select('a.*,b.store_name');
        $this->db->from('hf_system_activity as a');
        $this->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
        $query = $this->db->get();
        return $query->result_array();
    }

    //返回所有未过期的优惠劵
    function get_coupon_list($time){
        $this->db->select('a.*,b.store_name');
        $this->db->from('hf_shop_coupon as a');
        $this->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
        $query = $this->db->where('end_date >=',$time)->get();
        return $query->result_array();
    }
    //新增活动
    function add_activity($data){
        return $this->db->insert($this->activity,$data);
    }

    //根据id返回活动详情
    function get_activity_info($id){
        $where['id'] = $id;
        $query = $this->db->where($where)->get($this->activity);
        return $query->row_array();
    }

    //编辑活动
    function edit_activity_info($id,$data){
        $where['id'] = $id;
        return $this->db->where($where)->update($this->activity,$data);
    }
    //删除活动
    function del_Activity($id){
        $where['id'] = $id;
        return $this->db->where($where)->delete($this->activity);
    }


    //获取一见钟情活动列表
    function get_love_list(){
        $query = $this->db->order_by('create_time','desc')->get($this->marriage);
        return $query->result_array();
    }


}











 ?>