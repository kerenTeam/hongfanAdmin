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

    //返回千米订单
    function get_qianmi_money($date,$endtime){
        $query = $this->db->where('create_time >=',$date)->where('create_time <=',$endtime)->get($this->payment);
        return $query->result_array();
    }



}





 ?>