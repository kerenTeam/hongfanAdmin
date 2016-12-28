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
        $sql = "select * FROM ".$this->member." where gid != 5 and username='".$phone."'";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    //根据用户id返回用户信息
    function get_user_info($id){
        $where['user_id'] = $id;
        $query = $this->db->where($where)->get($this->member);
        return $query->row_array();
    }

    //获取所有用户数
    function get_users($gid){
        $where['gid'] = $gid;
        $query = $this->db->where($where)->get($this->member);
        return $query->result_array();
    }
    //返回用户分页
    function get_user_page($gid,$off,$page){
        $where['gid'] = $gid;
        $query = $this->db->where($where)->limit($page,$off)->order_by('create_time','desc')->get($this->member);
        return $query->result_array();
    }
    //搜索会员总数
    function search_users($gid,$card,$gender,$state,$sear){
        //会员卡
        $cardsql ='';
        $gendersql ='';
        $statesql ='';
        $searsql ='';
        if(!empty($card)){
            $cardsql = " and card_id = '$card'";
           // $sql = "SELECT * FROM $this->member where gid='$gid' and card_id = '$card' order by create_time desc";
        //性别不为空
        }
        if(!empty($gender)){
            $gendersql = " and gender = '$gender'";
           // $sql = "SELECT * FROM $this->member where gid='$gid' and gender ='$gender' order by create_time desc";
       //状态不为空
        }
        if($state == 0 || $state == 1){
           // $sql = "SELECT * FROM $this->member where gid='$gid'  and state = '$state' order by create_time desc";
            $statesql = " and state = '$state'";
        //关键字不为空
        }
        if(!empty($sear)){
          // $sql = "SELECT * FROM $this->member where gid='$gid' and username like '%$sear%' or nickname like '%$sear%' or phone like '%$sear%' order by create_time desc";
            $searsql = " and username like '%$sear%' or nickname like '%$sear%' or phone like '%$sear%'";
           //全部不为空
        }
        $sql = "SELECT * FROM $this->member where gid='$gid' $cardsql $gendersql $statesql $searsql order by create_time desc";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    //搜索会员分页
       function search_users_page($gid,$card,$gender,$state,$sear,$off,$page){
        //会员卡
        $cardsql ='';
        $gendersql ='';
        $statesql ='';
        $searsql ='';
        if(!empty($card)){
            $cardsql = " and card_id = '$card'";
           // $sql = "SELECT * FROM $this->member where gid='$gid' and card_id = '$card' order by create_time desc";
        //性别不为空
        }
        if(!empty($gender)){
            $gendersql = " and gender = '$gender'";
           // $sql = "SELECT * FROM $this->member where gid='$gid' and gender ='$gender' order by create_time desc";
       //状态不为空
        }
        if($state == 0 || $state == 1){
           // $sql = "SELECT * FROM $this->member where gid='$gid'  and state = '$state' order by create_time desc";
            $statesql = " and state = '$state'";
        //关键字不为空
        }
        if(!empty($sear)){
          // $sql = "SELECT * FROM $this->member where gid='$gid' and username like '%$sear%' or nickname like '%$sear%' or phone like '%$sear%' order by create_time desc";
            $searsql = " and username like '%$sear%' or nickname like '%$sear%' or phone like '%$sear%'";
           //全部不为空
        }
        $sql = "SELECT * FROM $this->member where gid='$gid' $cardsql $gendersql $statesql $searsql order by create_time desc limit $off,$page";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    //修改用户状态
    function edit_state($id,$arr){
    	$where['user_id'] = $id;
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
    //修改用户资料
    function edit_userinfo($userid,$data){
        $where['user_id'] = $userid;
        return $this->db->where($where)->update($this->member,$data);
    }
    //删除用户
    function del_member($id){
        $where['user_id'] = $id;
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


    //返回用户权限分组
    function get_user_group($usergid){
        $sql = "SELECT * FROM $this->group where gid != 5 and gid !=1 and gid != $usergid and gid != 2 order by create_time desc";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    //新增用户权限分组
    function add_group($data){
        return $this->db->insert($this->group,$data);
    }
    //编辑权限管理
    function edit_group($id,$data){
        $where['gid'] = $id;
        return $this->db->where($where)->update($this->group,$data);
    }
    //根据权限ID 返回权限
    function group_permiss($id){
        $where['gid'] = $id;
        $query = $this->db->where($where)->get($this->group);
        $row = $query->row_array();
        return $row['group_permission'];
    }
    //删除权限
    function del_group($id){
        $where['gid'] = $id;
        return $this->db->where($where)->delete($this->group);
    }
    //根据权限更改用户资料
    function edit_admin_user($gid,$data){
        $where['gid'] = $gid;
        return $this->db->where($where)->update($this->member,$data);
    }



}