<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class member_model extends CI_Model{
    public $member = 'hf_user_member';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    //获取登陆用户信息
    function get_login_user($phone){
        $sql = "select * FROM hf_user_member where gid != '5' and phone='".$phone."' or email = '".$phone."' or username='".$phone."'";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    //获取用户列表
    function get_users(){
        $query = $this->db->get($this->member);
        return $query->result_array();
    }




}