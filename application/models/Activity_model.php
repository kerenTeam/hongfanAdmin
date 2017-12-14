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

    //县志
    public $annals = "hf_city_annals";

    //用户卡卷
    public $usercoupon = "hf_user_coupon";



    function __construct()

    {

        parent::__construct();

    }

    //
    function select_where($table,$where,$id){
        $query = $this->db->where($where,$id)->get($table);
        return $query->result_array();
    }    
    function select_where_one($table,$where,$id){
        $query = $this->db->where($where,$id)->get($table);
        return $query->row_array();
    }

    //
    function select_where_may($table,$where,$id,$where1,$id1){
        $query = $this->db->where($where,$id)->where($where1,$id1)->get($table);
        return $query->result_array();
    }
    function select_where_three($table,$where,$id,$where1,$id1,$time,$endtime){
        $query = $this->db->where($where,$id)->where($where1,$id1)->where('create_time >=',$time)->where('create_time <=',$endtime)->get($table);
        return $query->result_array();
    }


    //删除核销记录
    function del_afterSales($id){
        return $this->db->where('id',$id)->delete('hf_shop_couponverify');
    }


    //返回所有卡卷类型

    function get_coupon_type(){

        $query = $this->db->get($this->coupon_type);

        return $query->result_array();

    }

    //返回所有卡劵

    function get_coupons(){

        // $this->db->select('a.*,b.store_name');

        // $this->db->from('hf_shop_coupon as a');


        $query = $this->db->order_by('state,id','desc')->get('hf_shop_coupon');

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




    //返回卡卷核销信息

    function ret_after_list($id){

        $where['shop_coupon_id']= $id;

        $this->db->select('a.*,c.nickname,b.orderUUID');

        $this->db->from('hf_shop_couponverify as a');

        $this->db->join('hf_user_member as c','a.userid = c.user_id','left');
        $this->db->join('hf_user_coupon as b','a.user_coupon_id = b.user_coupon_id','left');

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

    //返回领取数
    function selCouponReceive($page,$size){
        $this->db->select('a.*,b.title,b.name,c.nickname');
        $this->db->from('hf_shop_coupon as b');
        $this->db->join('hf_user_coupon as a','a.store_coupon_id = b.id','left');
        $this->db->join('hf_user_member as c','a.userid = c.user_id','left');


        $query = $this->db->order_by('a.user_coupon_id','desc')->limit($page,$size)->get();
        return $query->result_array();
    }


    //招商信息
    function select_attract($where){
       $this->db->select('a.*,b.nickname');

        $this->db->from('hf_local_atteactInvestment as a');

        $this->db->join('hf_user_member as b','a.userid = b.user_id','left');

        $query = $this->db->where("a.city",$where)->order_by('a.id','desc')->get();
        return $query->result_array();

    }
    //招商
     function select_attract_page($size,$page){
       $this->db->select('a.*,c.nickname');

        $this->db->from('hf_local_atteactInvestment as a');

        $this->db->join('hf_user_member as c','a.userid = c.user_id','left');

        $query = $this->db->order_by('a.id','desc')->limit($size,$page)->get();
        return $query->result_array();
    }
    //tinajiafenye
    function select_attract_where_page($where,$size,$page){
       $this->db->select('a.*,c.nickname');

        $this->db->from('hf_local_atteactInvestment as a');

        $this->db->join('hf_user_member as c','a.userid = c.user_id','left');

        $query = $this->db->where('a.city',$where)->order_by('a.id','desc')->limit($size,$page)->get();
        return $query->result_array();
    }

    function updata_attract($id,$data){
       return  $this->db->where('id',$id)->update('hf_local_atteactInvestment',$data);
    }



    //县志
    function select_annals(){
        $query = $this->db->get($this->annals);
        return $query->result_array();
    }
    function select_where_annals($city){
        $query = $this->db->where('city',$city)->get($this->annals);
        return $query->result_array();
    }
    function select_annals_info($id){
        $query = $this->db->where('id',$id)->get($this->annals);
        return $query->row_array();
    }
    function edit_annals($id,$data){
        return $this->db->where('id',$id)->update($this->annals,$data);
    }


    //返回领取记录
    function receive_coupon($id){
        $this->db->select('a.*,c.nickname,c.phone');

        $this->db->from('hf_user_coupon as a');

        $this->db->join('hf_user_member as c','a.userid = c.user_id','left');

        $query = $this->db->where('a.store_coupon_id',$id)->order_by('a.user_coupon_id','desc')->get();
        return $query->result_array();
    }
    //搜索领取记录
    function search_receive($id,$state){
        $this->db->select('a.*,c.nickname,c.phone');

        $this->db->from('hf_user_coupon as a');

        $this->db->join('hf_user_member as c','a.userid = c.user_id','left');

        $query = $this->db->where('a.store_coupon_id',$id)->where('a.user_coupon_state',$state)->order_by('a.user_coupon_id','desc')->get();
        return $query->result_array();
    }
    //修改领取状态
    function updataCoupon($id,$data){
        return $this->db->where('user_coupon_id',$id)->update('hf_user_coupon',$data);
    }

    //删除领取记录
    function del_receive($id){
        return $this->db->where('user_coupon_id',$id)->delete('hf_user_coupon');
    }


}























 ?>