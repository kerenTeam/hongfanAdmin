<?php 
/**
*    卡卷  +  商场活动
*/
class Activity_model extends CI_Model
{
    //卡卷表
    public $coupon = "hf_shop_coupon";
    //优惠、普通活动表
    public $activity = "hf_system_activity";
    //一键钟情表
    public $marriage = "hf_local_marriage";

    function __construct()
    {
        parent::__construct();
    }
    //返回所有卡卷
    function get_coupons(){
        $this->db->select('a.*,b.store_name');
        $this->db->from('hf_shop_coupon as a');
        $this->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
        $query = $this->db->get();
        return $query->result_array();
    }

    //删除卡卷
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

    //删除活动
    function del_Activity($id){
        $where['id'] = $id;
        return $this->db->where($where)->delete($this->activity);
    }


}











 ?>