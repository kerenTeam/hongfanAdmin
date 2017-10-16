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

    //获取所有中奖纪录
    function select_history($id){
    	$query = $this->db->where('gameId',$id)->order_by('createTime','desc')->get($this->history);
    	return $query->result_array();
    }
    function select_history_page($id,$page,$size){
    	$query = $this->db->where('gameId',$id)->order_by('createTime','desc')->limit($page,$size)->get($this->history);
    	return $query->result_array();
    }




}

 ?>