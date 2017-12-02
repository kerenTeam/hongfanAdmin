<?php 
//游戏
class Game_model extends CI_Model

{

	public $gameList = "hf_game";  //游戏
	public $prize = "hf_game_prize";//奖品
	public $history = "hf_game_wining_history";//中奖纪录
	function __construct()

    {

       parent::__construct();

    }

    //获取游戏信息
    function select_game_info($id){
    	$query = $this->db->where('id',$id)->get($this->gameList);
    	return $query->row_array();
    }
    function edit_game($id,$data){
    	return $this->db->where('id',$id)->update($this->gameList,$data);
    }
    //获取所有奖品
    function select_prize($id){
    	$query = $this->db->where('gameId',$id)->get($this->prize);
    	return $query->result_array();
    }
    //删除奖品
    function del_prize($id){
    	return $this->db->where('id',$id)->delete($this->prize);
    }
    //新增奖品
    function add_prize($data){
        return $this->db->insert($this->prize,$data);
    }
    //编辑游戏奖品
    function edit_prize($id,$data){
        return $this->db->where('id',$id)->update($this->prize,$data);
    }


    //获取所有中奖纪录
    function select_history($id){
        $this->db->select('a.*,b.nickname,c.title');
        $this->db->from('hf_game_wining_history a');
        $this->db->join('hf_user_member b', 'b.user_id = a.userId','left');
        $this->db->join('hf_game_prize c', 'c.id = a.prizeId','left');
        // $query = $this->db->order_by('a.createTime','desc')->get();
    	$query = $this->db->where('a.gameId',$id)->order_by('a.createTime','desc')->get();
    	return $query->result_array();
    }
    function select_history_page($id,$page,$size){
        $this->db->select('a.*,b.nickname,c.title');
        $this->db->from('hf_game_wining_history a');
        $this->db->join('hf_user_member b', 'b.user_id = a.userId','left');
        $this->db->join('hf_game_prize c', 'c.id = a.prizeId','left');
    	$query = $this->db->where('a.gameId',$id)->order_by('a.createTime','desc')->limit($page,$size)->get();
    	return $query->result_array();
    }
    //返回优惠卷
    function select_coupon(){
        $query = $this->db->where('isGamePrize','1')->get('hf_shop_coupon');
        return $query->result_array();
    }

    //获取提现纪录
    function select_withdrawals(){
        $this->db->select('a.*,b.nickname,c.title');
        $this->db->from('hf_game_wining_history a');
        $this->db->join('hf_user_member b', 'b.user_id = a.userId','left');
        $this->db->join('hf_game_prize c', 'c.id = a.prizeId','left');

        $query = $this->db->where('prizeId','29')->or_where('prizeId','30')->or_where('prizeId','31')->order_by('a.createTime','desc')->get();
        return $query->result_array();
    }
    function select_withdrawals_page($page,$size){
        $this->db->select('a.*,b.nickname,c.title');
        $this->db->from('hf_game_wining_history a');
        $this->db->join('hf_user_member b', 'b.user_id = a.userId','left');
        $this->db->join('hf_game_prize c', 'c.id = a.prizeId','left');

        $query = $this->db->where('prizeId','29')->or_where('prizeId','30')->or_where('prizeId','31')->order_by('a.createTime','desc')->limit($page,$size)->get();
        return $query->result_array();
    }
    //修改提现纪录状态
    function edit_withdrawals($id,$data){
        return $this->db->where('id',$id)->update('hf_game_wining_history',$data);
    }
    //搜索红包提现纪录
    function search_withsrawls($prizeId,$state){
        $this->db->select('a.*,b.nickname,c.title');
        $this->db->from('hf_game_wining_history a');
        $this->db->join('hf_user_member b', 'b.user_id = a.userId','left');
        $this->db->join('hf_game_prize c', 'c.id = a.prizeId','left');
        $query = $this->db->where('a.prizeId',$prizeId)->where('a.withsrawls',$state)->order_by('a.createTime','desc')->get();
        return $query->result_array();
    }  
      //搜索红包提现纪录
    function search_withsrawls_page($prizeId,$state,$page,$size){
        $this->db->select('a.*,b.nickname,c.title');
        $this->db->from('hf_game_wining_history a');
        $this->db->join('hf_user_member b', 'b.user_id = a.userId','left');
        $this->db->join('hf_game_prize c', 'c.id = a.prizeId','left');
        $query = $this->db->where('a.prizeId',$prizeId)->where('a.withsrawls',$state)->limit($page,$size)->order_by('a.createTime','desc')->get();
        return $query->result_array();
    } 
    //
    function search_where_withsrawls($where,$id){
        $this->db->select('a.*,b.nickname,c.title');
        $this->db->from('hf_game_wining_history a');
        $this->db->join('hf_user_member b', 'b.user_id = a.userId','left');
        $this->db->join('hf_game_prize c', 'c.id = a.prizeId','left');
        $query = $this->db->where($where,$id)->order_by('a.createTime','desc')->get();
        return $query->result_array();
    }
    function search_where_withsrawls_page($where,$id,$page,$size){
        $this->db->select('a.*,b.nickname,c.title');
        $this->db->from('hf_game_wining_history a');
        $this->db->join('hf_user_member b', 'b.user_id = a.userId','left');
        $this->db->join('hf_game_prize c', 'c.id = a.prizeId','left');
        $query = $this->db->where($where,$id)->order_by('a.createTime','desc')->limit($page,$size)->get();
        return $query->result_array();
    }

    //根据时间返回数据
    function select_where_with_time($time,$endtime){
        $this->db->select('a.*,b.nickname,c.title');
        $this->db->from('hf_game_wining_history a');
        $this->db->join('hf_user_member b', 'b.user_id = a.userId','left');
        $this->db->join('hf_game_prize c', 'c.id = a.prizeId','left');

        $query = $this->db->where('prizeId','29')->or_where('prizeId','30')->or_where('prizeId','31')->where('a.createTime >=',$time)->where('a.createTime <=',$endtime)->order_by('a.createTime','desc')->get();
        return $query->result_array();
    }    


        //根据时间返回数据
    function select_where_prizeid_time($prizeId,$time,$endtime){
        $this->db->select('a.*,b.nickname,c.title');
        $this->db->from('hf_game_wining_history a');
        $this->db->join('hf_user_member b', 'b.user_id = a.userId','left');
        $this->db->join('hf_game_prize c', 'c.id = a.prizeId','left');

        $query = $this->db->where('prizeId',$prizeId)->where('a.createTime >=',$time)->where('a.createTime <=',$endtime)->order_by('a.createTime','desc')->get();
        return $query->result_array();
    }    
    function select_where_wi_time($where,$id,$time,$endtime){
        $this->db->select('a.*,b.nickname,c.title');
        $this->db->from('hf_game_wining_history a');
        $this->db->join('hf_user_member b', 'b.user_id = a.userId','left');
        $this->db->join('hf_game_prize c', 'c.id = a.prizeId','left');

        $query = $this->db->where('prizeId',$prizeId)->where('a.createTime >=',$time)->where('a.createTime <=',$endtime)->order_by('a.createTime','desc')->get();
        return $query->result_array();
    }    
    function select_wining_time($prizeId,$where,$id,$time,$endtime){
         $this->db->select('a.*,b.nickname,c.title');
        $this->db->from('hf_game_wining_history a');
        $this->db->join('hf_user_member b', 'b.user_id = a.userId','left');
        $this->db->join('hf_game_prize c', 'c.id = a.prizeId','left');

        $query = $this->db->where('prizeId',$prizeId)->where($where,$id)->where('a.createTime >=',$time)->where('a.createTime <=',$endtime)->order_by('a.createTime','desc')->get();
        return $query->result_array();
    }
    





}

 ?>