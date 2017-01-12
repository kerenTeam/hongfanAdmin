<?php 
/**
* 
*/
class Payment_model extends CI_Model
{
    public $payment = "hf_qianmi_order";

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
        $query = $this->db->where($where)->order_by('create_time','desc')->get($this->payment);
        return $query->result_array();
    }


}





 ?>