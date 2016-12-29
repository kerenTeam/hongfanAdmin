<?php 
/**
*    为名服务
*/
class Service_model extends CI_Model
{
    // 帮帮团成员
    public $service_user = "hf_service_help_user";
    //用户请求表
    public $service_request = 'hf_service_request';
    //义工团队表
    public $team = 'hf_service_volunteer_team';
    //团队活动表
    public $team_activity = 'hf_service_volunteer_activities';

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

    //修改帮帮团成员资料
    function edit_help_user($id,$data){
        $where['helper_id'] = $id;
        return $this->db->where($where)->update($this->service_user,$data);
    }

    //返回用户id
    function get_user_id($username){
        $where['username'] = $username;
        $query = $this->db->where($where)->get('hf_user_member');
        $res = $query->row_array();
        return $res['user_id'];
    }
    //返回帮帮团尘成员id
    function get_help_userid($name){
        $where['name'] = $name;
        $query = $this->db->where($where)->get($this->service_user);
        $res = $query->row_array();
        return $res['helper_id'];
    }
    //返回义工团队详情
    function get_team_info(){
        $query = $this->db->get($this->team);
        return $query->row_array();
    }

    //修改义工团队信息
    function edit_team_info($id,$data){
        $where['id'] = $id;
        return $this->db->where($where)->update($this->team,$data);
    }

    //发起活动
    function add_volunteer_activities($data){
        return $this->db->insert($this->team_activity,$data);
    }

    //返回活动列表
    function get_activities_list(){
        $query = $this->db->order_by('create_time','desc')->get($this->team_activity);
        return $query->result_array();
    }
    //删除活动列表
    function del_volunter_activivies($id){
        $where['id'] = $id;
        return $this->db->where($where)->delete($this->team_activity);
    }
}



 ?>