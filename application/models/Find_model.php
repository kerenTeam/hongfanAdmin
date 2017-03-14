<?php
// 发现板块
class Find_model extends CI_Model
{
    public $find = "hf_friend_news";//帖子表
    public $category = "hf_friend_news_category";//分类表
    public $tags = "hf_friend_news_tags";//标签表
    public $news_tag = "hf_friend_news_tag";//帖子的标签表
    public $news_comment = "hf_friend_news_commit";//帖子的评论表

    //返回帖子列表
    function get_find_service(){
        $this->db->select('a.*,b.username,b.nickname');
        $this->db->from('hf_friend_news as a');
        $this->db->join('hf_user_member as b','a.userid = b.user_id','left');
        $query = $this->db->order_by('a.create_time','desc')->get();
        return $query->result_array();
    }

    //根据分类返回帖子
    function get_find_cate_service($id){
        $this->db->select('a.*,b.username,b.nickname');
        $this->db->from('hf_friend_news as a');
        $this->db->join('hf_user_member as b','a.userid = b.user_id','left');
        $query = $this->db->where('categoryid',$id)->order_by('a.create_time','desc')->get();
        return $query->result_array();
    }
    //根据关键字返回帖子
    function get_find_sear_service($sear){
        $this->db->select('a.*,b.username,b.nickname');
        $this->db->from('hf_friend_news as a');
        $this->db->join('hf_user_member as b','a.userid = b.user_id','left');
        $query = $this->db->like('content',$sear,'both')->order_by('a.create_time','desc')->get();
        return $query->result_array();
    }
    //根据分类和关键字返回帖子
    
    function get_find_service_search($id,$sear){
        $this->db->select('a.*,b.username,b.nickname');
        $this->db->from('hf_friend_news as a');
        $this->db->join('hf_user_member as b','a.userid = b.user_id','left');
        $query = $this->db->like('content',$sear,'both')->where('categoryid',$id)->order_by('a.create_time','desc')->get();
        return $query->result_array();
    }

    //修改帖子状态
    function edit_find_service($id,$data){
        $where['news_id'] = $id;
        return $this->db->where($where)->update($this->find,$data);
    }
    //删除帖子已有的标签
    function del_news_tags($id){
        $where['news_id'] = $id;
        return $this->db->where($where)->delete($this->news_tag);
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

    //帖子标签新增
    function add_news_tag($data){
        return $this->db->insert($this->news_tag,$data);
    }
    //根据id返回帖子
    function ret_find_content($id){
        $where['news_id'] = $id;
        $query = $this->db->where($where)->get($this->find);
        return  $query->row_array();
    }
    //根据帖子id返回帖子标签
    function ret_news_tag($id){
        $where['news_id'] = $id;
        $query = $this->db->where($where)->get($this->news_tag);
        return $query->result_array();
    }

    //返回分类列表
    function get_find_cates(){
        $query = $this->db->order_by('sort','asc')->get($this->category);
        return $query->result_array();
    }

    //分类关键字搜索
    function find_cates_search($data){
        $query = $this->db->like('cate_name',$data,'both')->order_by('create_time','desc')->get($this->category);
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
    
    //标签关键字搜索
    function find_tags_search($data){
        $query = $this->db->like('tagName',$data,'both')->order_by('create_time','desc')->get($this->tags);
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

    //返回帖子的所有评论
    function get_find_service_comment($id){
        $where['friend_news_id'] = $id;
        $query = $this->db->where($where)->get($this->news_comment);
        return $query->result_array();
    }
    //修改评论状态
    function edit_find_service_comment($id,$data){
         $where['id'] = $id;
         return $this->db->where($where)->update($this->news_comment,$data);
    }
    
    


}




?>