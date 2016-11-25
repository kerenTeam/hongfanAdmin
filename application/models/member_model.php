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
        // Call the Model constructor
        parent::__construct();
    }

    //获取登陆用户信息
    function get_login_user($phone){
        $sql = "select * FROM ".$this->member." where gid != '5' and phone='".$phone."' or email = '".$phone."' or username='".$phone."'";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    //获取用户列表
    function get_users(){
        $query = $this->db->get($this->member);
        return $query->result_array();
    }
    //返回用户分页
    function get_user_page($off,$page){
        $query = $this->db->limit($page,$off)->get($this->member);
        return $query->result_array();
    }

    //返回会员卡类型
    function get_card_type(){
        $query = $this->db->get($this->card);
        return $query->result_array();
    }

    //返回用户分组
    function get_user_group(){
        $query = $this->db->get($this->group);
        return $query->result_array();
    }


    //根据查询内容返回用户



    //修改用户状态
    function edit_state($id,$arr){
    	$where['userid'] = $id;
    	$query = $this->db->where($where)->update($this->member,$arr);
    	return $query;
    }




}