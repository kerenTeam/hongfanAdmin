<?php 
/**
*    为名服务
*/
class service_model extends CI_Model
{
    // 帮帮团成员
    public $service_user = "hf_service_help_user";
    //用户请求表
    public $service_request = 'hf_service_request';
    function __construct()
    {
        parent::__construct();
    }

    //返回成员列表
    function get_help_user(){
        $query = $this->db->get($this->service_user);
        return $query->result_array();
    }
    //推荐
    function edit_helpuser_state($id,$data){
        $where['id'] = $id;
        return $this->db->where($where)->update($this->service_user,$data);
    }
    //删除
    function del_help_user($id){
        $where['id'] = $id;
        return $this->db->where($where)->delete($this->service_user);
    }


}



 ?>