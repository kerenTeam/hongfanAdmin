<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class System_model extends CI_Model
{
    //用户表
    public $member = 'hf_user_member';
    //banner 表
    public $banner = 'hf_banners';
    //系统设置表
    public $system = "hf_system";
    //广告
    public $adver = "hf_ads";
    //系统公告
    public $report = "hf_local_hometown_reports";

    function __construct()
    {
       parent::__construct();
    }

    //返回所有管理员账户
    function get_admin_user(){
       $sql = "SELECT a.username,a.password,a.user_id,a.nickname,a.gid,a.create_time,a.avatar,b.gid,b.group_name FROM hf_user_member as a,hf_user_member_group as b where a.gid = b.gid and a.gid != 5 and a.gid != 2 order by a.create_time desc";
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
    //根据用户名返回用户
    function get_user($usreid,$username){
        $query = $this->db->where('user_id !=',$usreid)->where('gid !=','2')->where('gid !=','5')->where('username',$username)->get($this->member);
        return $query->result_array();
    }
    //编辑管理员用户
    function edit_admin_user($id,$data){
        $where['user_id'] = $id;
        return $this->db->where($where)->update($this->member,$data);
    }
    //刪除管理員
    function del_admin_user($id){
        $where['user_id'] = $id;
        return $this->db->where($where)->delete($this->member);
    }
    //返回所有banner
    function get_bannerlist(){
        $query = $this->db->get($this->banner);
        return $query->result_array();
    }
    //根据id返回banner数据
    function get_banner($id){
        $where['id'] = $id;
        $query = $this->db->where($where)->get($this->banner);
        return $query->row_array();
     }
     //修改banner
     function edit_banner($id,$data){
        $where['id'] = $id;
        return $this->db->where($where)->update($this->banner,$data);
     }


     //返回网站系统设置
     function get_webSystem(){
        $where['system_name'] = 'web_system';
        $this->db->select('system_value');
        $query = $this->db->where($where)->get($this->system);
        return $query->row_array();
     }
     //修改网站系统配置
     function edit_WebSystem($data){
        $where['system_name'] = 'web_system';
        return $this->db->where($where)->update($this->system,$data);
     }

     //返回所有广告
     function get_app_adver(){
        $query = $this->db->get($this->adver);
        return $query->result_array();
     }

     //返回广告详情
     function get_adver_info($id){
        $where['id'] = $id;
        $query = $this->db->where($where)->get($this->adver);
        return $query->row_array();
     }

     //修改广告详情
     function edit_adver($id,$data){
        $where['id'] = $id;
        return $this->db->where($where)->update($this->adver,$data);
     }

    //返回权限子模块
    function get_modular($id){
        $query = $this->db->where('m_id',$id)->get('hf_system_modular');
        return $query->result_array();
    }

    //返回所有系统公告
    function get_notice_list(){
        $query = $this->db->order_by('create_time','asc')->get($this->report);
        return $query->result_array();
    }
    //删除系统公告
    function del_notice($id){
        $where['id'] = $id;
        return $this->db->where($where)->delete($this->report);
    }
    //新增系统公告
    function add_notice($data){
        return $this->db->insert($this->report,$data);
    }
    //编辑系统公告
    function edit_notice($id,$data){
        $where['id'] = $id;
        return $this->db->where($where)->update($this->report,$data);
    }


}






 ?>