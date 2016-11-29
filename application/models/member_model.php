<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class member_model extends CI_Model{
    //用户表
    public $member = 'hf_user_member';
    //会员卡类型表
    public $card = 'hf_shop_membership_card_type';
    //用户分类表
    public $group = 'hf_user_member_group';

    function __construct()
    {
        parent::__construct();
    }

    //获取登陆用户信息
    function get_login_user($phone){
        $sql = "select * FROM ".$this->member." where gid != '5' and phone='".$phone."' or email = '".$phone."' or username='".$phone."'";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    //根据用户id返回用户信息
    function get_user_info($id){
        $where['userid'] = $id;
        $query = $this->db->where($where)->get($this->member);
        return $query->row_array();
    }

    //获取所有用户数
    function get_users(){
        $query = $this->db->get($this->member);
        return $query->result_array();
    }
    //返回用户分页
    function get_user_page($off,$page){
        $query = $this->db->limit($page,$off)->order_by('create_time','desc')->get($this->member);
        return $query->result_array();
    }


    //返回用户分组
    function get_user_group(){
        $query = $this->db->get($this->group);
        return $query->result_array();
    }

    //修改用户状态
    function edit_state($id,$arr){
    	$where['userid'] = $id;
    	$query = $this->db->where($where)->update($this->member,$arr);
    	return $query;
    }

    //新增用户操作
    function add_user_member($data){
        return $this->db->insert($this->member,$data);
    }
    //返回用户地址、积分记录、消息记录
    function get_user_address($db,$id){
        $where['userid'] = $id;
        $query = $this->db->where($where)->order_by('create_time','desc')->get($db);
        return $query->result_array();
    }
    //修改用资料
    function edit_userinfo($userid,$data){
        $where['userid'] = $userid;
        return $this->db->where($where)->update($this->member,$data);
    }
    //删除用户
    function del_member($id){
        $where['userid'] = $id;
        return $this->db->where($where)->delete($this->member);
    }

    //返回会员卡类型
    function get_card_type(){
        $query = $this->db->get($this->card);
        return $query->result_array();
    }

    //新增会员卡
    function add_cards($data){
        return $this->db->insert($this->card,$data);
    }

    //返回会员卡详情
    function get_cardinfo($id){
        $where['id'] = $id;
        $query = $this->db->where($where)->get($this->card);
        return $query->row_array();
    }
    //修改会员卡信息
    function edit_cards($id,$data){
        $where['id'] =$id;
        return $this->db->where($where)->update($this->card,$data);
    }

    //删除会员卡
    function del_cards($id){
        $where['id'] = $id;
        return $this->db->where($where)->delete($this->card);
    }

}