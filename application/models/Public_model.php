<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Public_model extends CI_Model
{
	
	//获取今日会员
	function ret_new_member(){
		$sql = "select * from hf_user_member where gid='5' and TO_DAYS(create_time) = to_days(now())";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	//新增
	function insert($table,$data){
		return $this->db->insert($table,$data);
	}

	//编辑
	function updata($table,$where,$id,$data){
		return $this->db->where($where,$id)->update($table,$data);
	}
	//删除
	function delete($table,$where,$id){
		return $this->db->where($where,$id)->delete($table);
	}


	//查询
	function select($table,$sort){
		$query = $this->db->order_by($sort,'desc')->get($table);
        return $query->result_array();
	}

	//条件查询
	function select_where($table,$where,$data,$sort){
		$query = $this->db->where($where,$data)->order_by($sort,'desc')->get($table);
        return $query->result_array();
	}

	//分页查询
	function select_page($table,$size,$page,$sort){
		$query = $this->db->order_by($sort,"desc")->limit($size,$page)->get($table);
        return $query->result_array();
	}

	//fanhui huiyuan 
	function select_where_member($table,$where,$data,$sort){
		$query = $this->db->where($where,$data)->where('gid','5')->order_by($sort,'desc')->get($table);
        return $query->result_array();
	}

	function select_where_member_page($table,$where,$id,$size,$page,$sort){
		$query = $this->db->where($where,$id)->where('gid','5')->order_by($sort,"asc")->order_by('create_time','desc')->limit($size,$page)->get($table);
        return $query->result_array();
	}

	//返回圈子
	function select_circle_page($size,$page){
		$this->db->select('a.*,b.nickname');
        $this->db->from('hf_faqs_space as a');
        $this->db->join('hf_user_member as b', 'b.user_id = a.createUserId','left');
        $query = $this->db->order_by('a.createTime','desc')->limit($size,$page)->get();
        return $query->result_array();
	}

	//返回圈子动态
	function select_circle_news_page($where,$id,$size,$page){
		$this->db->select('a.*,b.nickname');
        $this->db->from('hf_friends_news as a');
        $this->db->join('hf_user_member as b', 'b.user_id = a.userid','left');
        $query = $this->db->where($where,$id)->order_by('a.create_time','desc')->limit($size,$page)->get();
        return $query->result_array();
	}

	//返回所有动态
	function select_news_page($where,$id,$size,$page,$sort){
		$this->db->select('a.*,b.nickname,c.name');
        $this->db->from('hf_friends_news as a');
        $this->db->join('hf_user_member as b', 'b.user_id = a.userid','left');
        $this->db->join('hf_faqs_space as c', 'c.id = a.spaceType','left');
        $query = $this->db->where($where,$id)->order_by($sort,'desc')->limit($size,$page)->get();
        return $query->result_array();
	}

	//返回标签
	function select_lable($size,$page){
		$this->db->select('a.*,b.nickname');
        $this->db->from('hf_friends_lable_group as a');
        $this->db->join('hf_user_member as b', 'b.user_id = a.createUserID','left');
        $query = $this->db->order_by('a.create_time','desc')->limit($size,$page)->get();
        return $query->result_array();
	}

	//返回问答份额里
	function select_question_cates($size,$page){
		$this->db->select('a.*,b.nickname');
        $this->db->from('hf_faqs_group as a');
        $this->db->join('hf_user_member as b', 'b.user_id = a.createUser','left');
        $query = $this->db->order_by('a.createTime','desc')->limit($size,$page)->get();
        return $query->result_array();
	}

	//返回问答帖子
	function select_question_list($size,$page){
		$this->db->select('a.*,b.nickname,c.name');
        $this->db->from('hf_friends_news as a');
        $this->db->join('hf_user_member as b', 'b.user_id = a.userid','left');
        $this->db->join('hf_faqs_group as c', 'a.faqsType = c.id','left');
        $query = $this->db->where('typeId','2')->order_by('a.create_time','desc')->limit($size,$page)->get();
        return $query->result_array();
	}
	//返回问题回答
	function select_question_comment($id){
		$this->db->select('a.*,b.nickname,c.content');
        $this->db->from('hf_friends_news_commont as a');
        $this->db->join('hf_user_member as b', 'b.user_id = a.userid','left');
        $this->db->join('hf_friends_news as c', 'c.id = a.newsId','left');
        $query = $this->db->where('a.newsId',$id)->order_by('a.create_time','desc')->get();
        return $query->result_array();
	}

	//根据类别返回专家
	function select_where_page($table,$where,$id,$size,$page,$sort){
		$this->db->select('a.*,b.nickname,b.avatar,b.answerNums,c.name');
        $this->db->from('hf_faqs_expert as a');
        $this->db->join('hf_user_member as b', 'b.user_id = a.userId','left');
        $this->db->join('hf_faqs_group as c', 'c.id = a.groupId','left');
        $query = $this->db->where($where,$id)->order_by($sort,'desc')->get();
	    return $query->result_array();
	}

	//多条件返回专拣
	function select_manWhere($table,$where1,$where2){
		$query = $this->db->where('groupId',$where1)->where('userid',$where2)->get($table);
		return $query->row_array();
	}


	//返回交友会员
	function select_frirnds_user(){
		$query = $this->db->where('gender','1')->or_where('gender','2')->where('gid','5')->order_by('create_time','desc')->get('hf_user_member');
		return $query->result_array();
	}
	function select_frirnds_user_page($size,$page){
		$query = $this->db->where('gender','1')->or_where('gender','2')->where('gid','5')->order_by('create_time','desc')->limit($size,$page)->get('hf_user_member');
		return $query->result_array();
	}
	
	//返回资料审核
	function select_friends_dataAudit($id,$size,$page){
		$this->db->select('a.*,b.nickname');
        $this->db->from('hf_friends_my_photo as a');
        $this->db->join('hf_user_member as b', 'b.user_id = a.userId','left');
        $query = $this->db->where('a.needReview',$id)->order_by('a.create_time','desc')->limit($size,$page)->get();
        return $query->result_array();
	}
	
	//
	function select_info($phone){
		$query = $this->db->where('phone',$phone)->get('hf_user_member');
		return $query->row_array();
	}

	//帆就今日数据
	function dayList($table,$time){
		$sql = 'select id from '.$table.' where to_days('.$time.') = to_days(now())';
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//返回昨日数据
	function toDayList($table,$time){
		$sql = 'SELECT id FROM '.$table.' WHERE TO_DAYS( NOW( ) ) - TO_DAYS('.$time.') <= 1';
		$query = $this->db->query($sql);
		return $query->result_array();
	}


}




 ?>