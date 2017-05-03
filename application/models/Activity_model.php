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
    //一见钟情参与表
    public $marriage_join = "hf_local_marriage_join";

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
        $query = $this->db->order_by('id','desc')->get();
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
        
        // $this->db->select('a.*,b.store_name');
        // $this->db->from('hf_system_activity as a');
        // $this->db->join('hf_shop_store as b','a.storeid = b.store_id','left');
        // $query = $this->db->get();
        $query = $this->db->order_by('create_time','desc')->get($this->activity);
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

    //新增一键钟情活动
    function add_love_activity($data){
        return $this->db->insert($this->marriage,$data);
    }

    //删除一见钟情
    function del_love_activity($id){
        $where['id'] = $id;
        return $this->db->where($where)->delete($this->marriage);
    }

    //获取一键钟情活动详情
    function get_loveactivity_info($id){
        $where['id'] = $id;
        $query = $this->db->where($where)->get($this->marriage);
        return $query->row_array();
    }

    //编辑
    function edit_love_activity($id,$data){
        $where['id'] = $id;
        return $this->db->where($where)->update($this->marriage,$data);
    }

    //返回报名详情
    function get_activity_users($id){
       $sql = "SELECT `a`.*, `b`.`username`,b.nickname FROM `hf_local_marriage_join` `a` LEFT JOIN `hf_user_member` `b` ON `b`.`user_id` = `a`.`userid` WHERE `marriage_id` = '$id'";
       $query = $this->db->query($sql);
        return $query->result_array();
    }

    //返回卡卷核销信息
    function ret_after_list($id){
        $where['shop_coupon_id']= $id;
        $this->db->select('a.*,c.nickname');
        $this->db->from('hf_shop_couponverify as a');
        $this->db->join('hf_user_member as c','a.userid = c.user_id','left');
        $query = $this->db->where($where)->order_by('create_time','desc')->get();
        return $query->result_array();
    }

    //根据日期返回核销信息
    function get_search_after($id,$time,$endtime){
        $where['shop_coupon_id']= $id;
        $this->db->select('a.*,c.nickname');
        $this->db->from('hf_shop_couponverify as a');
        $this->db->join('hf_user_member as c','a.userid = c.user_id','left');
        $query = $this->db->where($where)->where('a.create_time >=',$time)->where('a.create_time <=',$endtime)->order_by('a.create_time','desc')->get();
        return $query->result_array();
    }


    //返回核销商家名称
    function get_store_name($id){
        $where['business_id'] = $id;
        $query = $this->db->where($where)->get('hf_shop_store');
        $res = $query->row_array();
        return $res['store_name'];
    }

    //返回核销数
    function get_WriteNum($id){
        $where['shop_coupon_id'] = $id;
        $query = $this->db->where($where)->get('hf_shop_couponverify');
        return $query->result_array();
    }

    //返回领取数
    function get_ReceiveNum($id){
        $where['store_coupon_id'] = $id;
        $query = $this->db->where($where)->get('hf_user_coupon');
        return $query->result_array();
    }


}











 ?>