<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class system_model extends CI_Model
{
    //用户表
    public $member = 'hf_user_member';
    //banner 表
    //系统设置表

    function __construct()
    {
       parent::__construct();
    }

    //返回所有管理员账户
    function get_admin_user(){
       $sql = "SELECT a.username,a.user_id,a.nickname,a.gid,a.create_time,a.avatar,b.gid,b.group_name FROM hf_user_member as a,hf_user_member_group as b where a.gid = b.gid and a.gid != 5 and a.gid != 2 order by a.create_time desc";
       $query = $this->db->query($sql);
       return $query->result_array();
    }

    //返回用户权限
    function get_member_group(){
        $sql = "SELECT * FROM hf_user_member_group where gid != 5 and gid != 2 order by create_time desc";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    //新增管理员用户
    function add_admin_user($data){
        return $this->db->insert($this->member,$data);
    }
    //编辑


}






 ?>