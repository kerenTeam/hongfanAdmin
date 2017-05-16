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
    //家乡话
    public $report = "hf_local_hometown_reports";
    //app版本
    public $version = "hf_system_version";
    //运费模板
    public $express = "hf_mall_goods_express";
    //家乡话分类
    public $report_cates = "hf_local_hometown_reports_cates";

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
        $query = $this->db->where('type !=','12')->where('type !=','13')->get($this->banner);
        return $query->result_array();
    }
     //返回启动广告
    function get_start_advertising($type){
        $query = $this->db->where('type',$type)->get($this->banner);
        return $query->row_array();
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
        $query = $this->db->order_by('create_time','desc')->get($this->report);
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
    //修改家乡话状态
    function edit_notice_state($id,$data){
        $where['id'] = $id;
        return $this->db->where($where)->update($this->report,$data);
    }

    //返回编辑新闻内容
    function get_notice_info($id){
        $where['id'] = $id;
        $query = $this->db->where($where)->get($this->report);
        return $query->row_array();
    }

    //返回app版本
    function get_app_version(){
        $query = $this->db->order_by('create_time','desc')->get($this->version);
        return $query->row_array();
    }

    //修改App版本
    function edit_app_version($id,$data){
        $where['id'] = $id;
        return $this->db->where($where)->update($this->version,$data);
    }

    //返回温馨提示
    function get_prompt(){
        $where['type'] = 1;
        $query = $this->db->where($where)->get('hf_system_app');
        return $query->result_array();
    }
    //修改温馨提示
    function edit_prompt($id,$data){
        $where['id'] = $id;
        return $this->db->where($where)->update("hf_system_app",$data);
    }

    //返回系统日志
    function get_journal(){
        $sql = "SELECT a.*,b.user_id,b.username,b.nickname from hf_system_journal as a, hf_user_member as b where a.userid = b.user_id order by create_time desc";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    //返回运费模板
    function get_express_temp($id){
        $where['businid'] = $id;
        $query = $this->db->where($where)->get($this->express);
        return $query->result_array();
    }
    //新增运费模板
    function add_express_temp($data){
        return $this->db->insert($this->express,$data);
    }
    //编辑运费模板
    function edit_express_temp($id,$data){
        $where['express_id'] = $id;
        return $this->db->where($where)->update($this->express,$data);
    }

    //删除运费模板
    function del_express_temp($id){
        $where['express_id'] = $id;
        return $this->db->where($where)->delete($this->express);
    }

    //返回家乡话 分类
    function get_reportCates(){
        $query = $this->db->order_by("sort","desc")->get($this->report_cates);
        return $query->result_array();
    }
    //新增家乡话分类
    function add_reportCates($data){
        return $this->db->insert($this->report_cates,$data);
    }

    //编辑家乡话分类
    function edit_report_cates($id,$data){
        $where['cate_id'] = $id;
        return $this->db->where($where)->update($this->report_cates,$data);
    }
    //删除家乡话分类
    function del_report_cates($id){
        $where['cate_id'] = $id;
        return $this->db->where($where)->delete($this->report_cates);
    }

    function ret_feedback(){
        $this->db->select('a.*, b.username,b.nickname');
        $this->db->from('hf_system_feedback a');
        $this->db->join('hf_user_member b', 'b.user_id = a.userid','left');
        $query = $this->db->order_by('a.feedback_data','desc')->get();
        return $query->result_array(); 
    }

}






 ?>