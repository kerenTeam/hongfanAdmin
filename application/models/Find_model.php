<?php
// 发现板块
class Find_model extends CI_Model
{
    public $find = "hf_friend_news";//帖子表
    public $category = "hf_friend_news_category";//分类表
    public $tags = "hf_friend_news_tags";//标签表
    public $news_tag = "hf_friend_news_tag";//帖子的标签表
    public $news_comment = "hf_friend_news_commit";//帖子的评论表
    public $findSpecial = "hf_friend_news_activity";//发现的活动或专题


    //返回帖子列表
    function get_find_service(){
        $this->db->select('a.*,b.username,b.nickname');
        $this->db->from('hf_friend_news as a');
        $this->db->join('hf_user_member as b','a.userid = b.user_id','left');
        $query = $this->db->order_by('type_name','desc')->order_by('a.create_news_time','desc')->get();
        return $query->result_array();
    }

    //根据分类返回帖子
    function get_find_cate_service($id){
        $this->db->select('a.*,b.username,b.nickname');
        $this->db->from('hf_friend_news as a');
        $this->db->join('hf_user_member as b','a.userid = b.user_id','left');
        $query = $this->db->where('categoryid',$id)->order_by('a.create_news_time','desc')->get();
        return $query->result_array();
    }

    //返回举报帖子
    function get_find_service_state($state){
        $this->db->select('a.*,b.username,b.nickname');
        $this->db->from('hf_friend_news as a');
        $this->db->join('hf_user_member as b','a.userid = b.user_id','left');
        $query = $this->db->where('news_state',$state)->order_by('type_name','desc')->order_by('a.create_news_time','desc')->get();
        return $query->result_array();
    }


    //根据关键字返回帖子
    function get_find_sear_service($sear){
        $this->db->select('a.*,b.username,b.nickname');
        $this->db->from('hf_friend_news as a');
        $this->db->join('hf_user_member as b','a.userid = b.user_id','left');
        $query = $this->db->like('content',$sear,'both')->order_by('a.create_news_time','desc')->get();
        return $query->result_array();
    }
    //根据分类和关键字返回帖子
    
    function get_find_service_search($id,$sear){
        $this->db->select('a.*,b.username,b.nickname');
        $this->db->from('hf_friend_news as a');
        $this->db->join('hf_user_member as b','a.userid = b.user_id','left');
        $query = $this->db->like('content',$sear,'both')->where('a.categoryid',$id)->order_by('a.create_news_time','desc')->get();
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
        $this->db->select('a.*,b.username,b.nickname');
        $this->db->from('hf_friend_news_commit as a');
        $this->db->join('hf_user_member as b','a.from_user_id = b.user_id','left');
        $query = $this->db->where($where)->get();
        return $query->result_array();
    }
    //修改评论状态
    function edit_find_service_comment($id,$data){
         $where['id'] = $id;
         return $this->db->where($where)->update($this->news_comment,$data);
    }
    //删除评论
    function del_find_service_comment($id){
        $where['id'] = $id;
        return $this->db->where($where)->delete($this->news_comment);
    }
    //根据id 返回评论
    function get_find_comment($id){
        $where['id'] = $id;
        $query= $this->db->where($where)->get($this->news_comment);
        return $query->row_array();
    }
    //评论搜索
    function find_comment_search($id,$sear){
        $where['friend_news_id'] = $id;
        $this->db->select('a.*,b.username,b.nickname');
        $this->db->from('hf_friend_news_commit as a');
        $this->db->join('hf_user_member as b','a.from_user_id = b.user_id','left');
        $query= $this->db->where($where)->like('content',$sear,'both')->get();
        return $query->result_array();
    }

    //返回活动主题
    function ret_find_activity(){
        $query = $this->db->get('hf_friend_news_activity_group');
        return $query->result_array();
    }
    //编辑活动主题
    function edit_findActivity($id,$data){
        $where['act_id'] = $id;
        return $this->db->where($where)->update("hf_friend_news_activity_group",$data);
    }
    
    //返回活动或专题列表
    function get_find_special($type){
        $where['act_id'] = $type;
        $query = $this->db->where($where)->order_by('create_time','desc')->get($this->findSpecial);
        return $query->result_array();
    }
    
    //新增发现活动或专题
    function add_find_special($data){
        return $this->db->insert($this->findSpecial,$data);
    }
    //返回要编辑的活动或专题
    function ret_findActSpecial($id){
        $where['q_id'] = $id;
        $query = $this->db->where($where)->get($this->findSpecial);
        return $query->row_array();
    }

    //编辑发现活动或专题
    function edit_find_special($id,$data){
        $where['q_id'] = $id;
        return $this->db->where($where)->update($this->findSpecial,$data);
    }
    //删除发现活动或专题
    function del_find_special($id){
        $where['q_id'] = $id;
        return $this->db->where($where)->delete($this->findSpecial);
    }
    //删除该活动或专题下的所有帖子
    function del_find_special_server($id){
        $where['q_id'] = $id;
        return $this->db->where($where)->delete($this->find);
    }
    //返回活动专题的帖子
    function get_find_special_serviceList($qid){
        $where['q_id'] = $qid;
        $query = $this->db->where($where)->order_by('create_news_time','desc')->get($this->find);
        return $query->result_array();
    }
   


}




?>