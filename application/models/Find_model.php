<?php
// 发现板块
class Find_model extends CI_Model
{
    public $find = "hf_friend_news";//帖子表
    public $category = "hf_friend_news_category";//分类表
    public $tags = "hf_friend_news_tags";//标签表

    //返回帖子列表
    function get_find_service(){
        $this->db->select('a.*,b.username,b.nickname');
        $this->db->from('hf_friend_news as a');
        $this->db->join('hf_user_member as b','a.userid = b.user_id','left');
        $query = $this->db->order_by('a.create_time','desc')->get();
        return $query->result_array();
    }
    //修改帖子状态
    function edit_find_service($id,$data){
        $where['news_id'] = $id;
        return $this->db->where($where)->update($this->find,$data);
    }
    //删除帖子
    function del_find_service($id){
        $where['news_id'] = $id;
        return $this->db->where($where)->delete($this->find);
    }

    //新增帖子
    function add_find_service($data){
        $this->db->insert($this->find,$data);
        return $this->db->insert_id();
    }
    //根据id返回帖子
    function ret_find_content($id){
        $where['news_id'] = $id;
        $query = $this->db->where($where)->get($this->find);
        return  $query->row_array();
    }

    //返回分类列表
    function get_find_cates(){
        $query = $this->db->order_by('sort','asc')->get($this->category);
        return $query->result_array();
    }


    //根据分类id 返回分类名称
    function ret_cate_name($id){
        $where['cate_id'] = $id;
        $query = $this->db->where($where)->get($this->category);
        $row = $query->row_array();
        return $row['cate_name'];
    }

    //新增分类
    function add_find_cates($data){
        return $this->db->insert($this->category,$data);
    }
    //编辑分类
    function edit_find_cates($id,$data){
        $where['cate_id'] = $id;
        return $this->db->where($where)->update($this->category,$data);
    }
    //删除分类
    function del_find_cates($id){
        $where['cate_id'] = $id;
        return $this->db->where($where)->delete($this->category);
    }

    //返回标签列表
    function get_find_tags(){
        $query = $this->db->order_by('create_time','desc')->get($this->tags);
        return $query->result_array();
    }

    //返回热门标签
    function get_hot_tags(){
          $query = $this->db->order_by('usage','desc')->limit('20')->get($this->tags);
          return $query->result_array();
    }
    //新增标签
    function add_find_tags($data){
        return $this->db->insert($this->tags,$data);
    }
    //编辑标签
    function edit_find_tags($id,$data){
        $where['tag_id'] = $id;
        return $this->db->where($where)->update($this->tags,$data);
    }
    //删除标签
    function del_find_tags($id){
        $where['tag_id'] = $id;
        return $this->db->where($where)->delete($this->tags);
    }

    
    


}




?>