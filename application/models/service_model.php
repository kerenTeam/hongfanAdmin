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
        $where['helper_id'] = $id;
        return $this->db->where($where)->update($this->service_user,$data);
    }
    //删除
    function del_help_user($id){
        $where['helper_id'] = $id;
        return $this->db->where($where)->delete($this->service_user);
    }
    //返回请求列表
    function get_requert(){
        $this->db->select('a.*,b.username,b.phone,c.name');
        $this->db->from('hf_service_request as a');
        $this->db->join('hf_user_member as b','a.user_id = b.user_id','left');
        $this->db->join('hf_service_help_user as c','a.helper_id = c.helper_id','left');
        $query = $this->db->get();
        return $query->result_array();
    }
    //删除服务请求
    function del_help_request($id){
        $where['id'] = $id;
        return $this->db->where($where)->delete($this->service_request);
    }

    //回复请求
    function edit_help_request($id,$data){
        $where['id'] = $id;
        return $this->db->where($where)->update($this->service_request,$data);
    }
    //给用户回复消息
    function add_user_message($data){
        return $this->db->insert('hf_user_message',$data);
    }

}



 ?>