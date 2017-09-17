<?php 
/**
* 
*/
class Payment_model extends CI_Model
{
    public $payment = "hf_qianmi_order";
    public $recharge = "hf_tool_recharge";

    function __construct()
    {
        parent::__construct();
    }

    //返回千米月订单
    function get_qianmi_money($date,$endtime,$type){
        $query = $this->db->where('type',$type)->where('create_time >=',$date)->where('create_time <=',$endtime)->get($this->payment);
        return $query->result_array();
    }

    //返回千米所有订单
    function get_qianmi_order($type){
        $where['type'] = $type;
        $this->db->select('a.*,b.nickname');
        $this->db->from('hf_qianmi_order a');
        $this->db->join('hf_user_member b', 'b.user_id = a.userid','left');
        $query = $this->db->where($where)->order_by('create_time','desc')->get();
        return $query->result_array();
    }
    function get_phone_order($type){
        $where['type'] = $type;
        $this->db->select('a.*,b.nickname');
        $this->db->from('hf_qianmi_order a');
        $this->db->join('hf_user_member b', 'b.user_id = a.userid','left');
        $query = $this->db->where($where)->where('a.state','1')->order_by('create_time','desc')->get();
        return $query->result_array();
    }

    //删除千米订单
    function del_qianmi_order($id){
        $where['id'] = $id;
        return $this->db->where($where)->delete($this->payment);
    }

    //返回充值设置
    function ret_recharge(){
        $this->db->select('a.*,b.nickname');
        $this->db->from('hf_tool_recharge a');
        $this->db->join('hf_user_member b', 'b.user_id = a.createUserid','left');
        $query = $this->db->order_by('a.createTime','desc')->get();
        return $query->result_array();
    }

    //新增充值设置
    function add_recharge($data){
        return $this->db->insert($this->recharge,$data);
    }

    //编辑话费这只
    function edit_recharge($id,$data){
        return $this->db->where('id',$id)->update($this->recharge,$data);
    }

    //删除充值套惨
    function del_recharge($id){
        return $this->db->where('id',$id)->delete($this->recharge);
    }
}





 ?>