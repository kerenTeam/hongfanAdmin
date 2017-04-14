<?php
/*
 * 本地生活
 *
 * */
defined('BASEPATH') OR exit('No direct script access allowed');
class Module_model extends CI_Model{
    //分类表
    public $cate = 'hf_local_service_cates';
    //保姆、维修、开锁信息表
    public $service = 'hf_local_service';
    //房产中介表
    public $house = 'hf_local_house';
	//二手市场
	public $mark = 'hf_local_used_market';
	//二手市场 fenlei 
	public $mark_type = 'hf_local_used_market_type';
	//快递上门 
	public $express = 'hf_local_express';
	//超市比价
	public $market_data = 'hf_local_market_data';

    function __construct()
    {
        parent::__construct();
    }
    //获取所有
    function get_cates($c_id){
        $where['c_id'] = $c_id;
        $query = $this->db->where($where)->order_by('sort','asc')->get($this->cate);
        return $query->result_array();
    }
    //获取某一个分类信息
    function get_cateinfo($id){
        $where['id'] = $id;
        $query = $this->db->where($where)->get($this->cate);
        return $query->row_array();
    }

    //新增分类
    function add_cates($data){
        return $this->db->insert($this->cate,$data);
    }
    //编辑分类
    function edit_cates($id,$data){
        $where['id'] = $id;
        return $this->db->where($where)->update($this->cate,$data);
    }

    //获取普通信息
    function get_serviceList($type_id){
        $where['type_name']  = $type_id;
        $query = $this->db->where($where)->order_by('create_time','desc')->get($this->service);
        return $query->result_array();
    }
	//普通信息 分页
	function get_serviceList_page($type_id,$off,$page){
		$where['type_name']  = $type_id;
        $query = $this->db->where($where)->order_by('create_time','desc')->limit($off,$page)->get($this->service);
        return $query->result_array();
	}

    //搜索所有数据
    function search_service($sear,$type_id){
        $sql = "SELECT * FROM $this->service where type_name = $type_id and name like '%$sear%' or link_man like '%$sear%' or phone like '%$sear%' order by create_time desc";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    //搜索分页数据
    function search_service_page($sear,$type_id,$off,$page){
        $sql = "SELECT * FROM $this->service where type_name = $type_id and name like '%$sear%' or link_man like '%$sear%' or phone like '%$sear%' order by create_time desc limit $page,$off";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
	
	//获取普通信息详情
	function get_serviceinfo($id){
		$where['id'] = $id;
		$query = $this->db->where($where)->get($this->service);
		return $query->row_array();
	}
	
	//新增普通信息
	function add_service($data){
		return $this->db->insert($this->service,$data);
	}
	
	//编辑普通信息
	function edit_service($id,$data){
		$where['id'] = $id;
		return $this->db->where($where)->update($this->service,$data);
	}
	//删除普通信息
	function del_service($id){
		$where['id'] = $id;
		return $this->db->where($where)->delete($this->service);
	}

    //房产信息
    function get_houst(){
        $query = $this->db->order_by('create_time','desc')->get($this->house);
        return $query->result_array();
    }
	//房产信息 分页
	function get_houst_page($off,$page){
		$query = $this->db->order_by('create_time','desc')->limit($off,$page)->get($this->house);
		return $query->result_array();
	}
	
	//新增房产信息
	function add_houst($data){
		return $this->db->insert($this->house,$data);
	}
	
	//获取房产信息详情
	function get_houstinfo($id){
		$where['house_id'] = $id;
		$query = $this->db->where($where)->get($this->house);
		return $query->row_array();
	}
	//搜索房产信息
    function search_houst($sear){
        $sql = "SELECT * FROM $this->house where name like '%$sear%' or house_layout like '%$sear%' or quarters like '%$sear%' or area_address like '%$sear%' order by create_time desc";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    //搜索房产信息分页
    function search_houst_page($sear,$off,$page){
        $sql = "SELECT * FROM $this->house where name like '%$sear%' or house_layout like '%$sear%' or quarters like '%$sear%' or area_address like '%$sear%' order by create_time desc limit $page,$off";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

	//编辑房产信息
	function edit_houst($id,$data){
		$where['house_id'] = $id;
        unset($data['id']);
		return $this->db->where($where)->update($this->house,$data);
	}
	
	//删除房产信息
	function del_houst($id){
		$where['house_id'] = $id;
		return $this->db->where($where)->delete($this->house);
	}
	
    //二手市场
    function get_mark(){
		$query = $this->db->order_by('create_time','desc')->get($this->mark);
		return $query->result_array();
	}
	//获取二手市场分类
	function get_mark_type(){
		$query = $this->db->get($this->mark_type);
		return $query->result_array();
	}
	//二手市场 分页
	function get_mark_page($off,$page){
		$sql ="SELECT a.id,a.userid,a.isbusiness,a.recommend_state,a.colour,a.title,a.phone,a.type,a.price,a.address,a.brand,a.create_time,b.tagid,b.tag FROM hf_local_used_market as a,hf_local_used_market_type as b where a.type = b.tagid order by create_time desc limit $page,$off";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
    //二手市场 搜索
    function search_mark($sear){
        $sql = "SELECT a.id,a.userid,a.title,a.phone,a.type,a.price,a.address,a.brand_new,a.create_time,b.tagid,b.tag FROM hf_local_used_market as a,hf_local_used_market_type as b where a.type = b.tagid and a.title like '%$sear%' order by create_time desc";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    function search_mark_page($sear,$off,$page){
        $sql = "SELECT a.id,a.userid,a.title,a.phone,a.type,a.price,a.address,a.brand_new,a.create_time,b.tagid,b.tag FROM hf_local_used_market as a,hf_local_used_market_type as b where a.type = b.tagid and a.title like '%$sear%' order by create_time desc limit $page,$off";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

	//新增二手市场信息
	function add_market($data){
		return $this->db->insert($this->mark,$data);
	}
	//编辑二手市场详情
	function edit_markinfo($id,$data){
		$where['id'] = $id;
		return $this->db->where($where)->update($this->mark,$data);

	}
	//获取二手市场详情
	function get_markinfo($id){
		$where['id'] = $id;
		$query = $this->db->where($where)->get($this->mark);
		return $query->row_array();
	}
		//删除二手市场
	function del_mark($id){
		$where['id'] = $id;
		return $this->db->where($where)->delete($this->mark);
	}
	
	//快递上门
	function get_express(){
		$query = $this->db->order_by('create_time','desc')->get($this->express);
		return $query->result_array();
	}
	//快递上门 分页
	function get_express_page($off,$page){
		$query = $this->db->order_by('create_time','desc')->limit($off,$page)->get($this->express);
		return $query->result_array();
	}
	//快递上门搜索
    function search_express($sear){
         $sql = "SELECT * FROM $this->express where sender_address like '%$sear%' or link_man like '%$sear%' or phone like '%$sear%' order by create_time desc";
         $query = $this->db->query($sql);
         return $query->result_array();
    }
     function search_express_page($sear,$off,$page){
             $sql = "SELECT * FROM $this->express where sender_address like '%$sear%' or link_man like '%$sear%' or phone like '%$sear%' order by create_time desc limit $page,$off";
             $query = $this->db->query($sql);
             return $query->result_array();
        }




	//超市比价
	function get_market_data(){
		$query = $this->db->order_by('date','desc')->get($this->market_data);
		return $query->result_array();
	}
	//超市比价 分页
	function get_market_data_page($off,$page){
        $sql = "select * FROM hf_local_market_data ORDER BY date desc limit $page,$off";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
    //超市比价搜索
    function search_market_data($sear){
        $sql = "SELECT * FROM $this->market_data where market_name like '%$sear%' or goods_name like '%$sear%' order by date desc";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
     function search_market_data_page($sear,$off,$page){
            $sql = "SELECT * FROM $this->market_data where market_name like '%$sear%' or goods_name like '%$sear%' order by date desc limit $page,$off";
            $query = $this->db->query($sql);
            return $query->result_array();
        }


	
	//获取超市比价详情
	function get_market_data_info($id){
		$where['id'] = $id;
		$query = $this->db->where($where)->get($this->market_data);
		return $query->row_array();
	}
    //新增超市比价
    function add_market_data($data){
        return $this->db->insert($this->market_data,$data);
    }
    //修改超市比价
    function edit_market_info($id,$data)
    {
       $where['id'] = $id;
       return $this->db->where($where)->update($this->market_data,$data);
    }
	//删除超市比价
	function del_market_data($id){
		$where['id'] = $id;
		return $this->db->where($where)->delete($this->market_data);
	}

	//返回某个超市的商品
	function get_market_list($id){
		$where['marketid'] = $id;
		$query = $this->db->where($where)->get($this->market_data);
		return $query->result_array();
	}
	function get_market_list_page($id,$off,$page){
		 $sql = "select * FROM hf_local_market_data where marketid = '$id' ORDER BY date desc limit $page,$off";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//返回免责声明
	function get_disclaimer(){
		$query = $this->db->where('id','1')->get('hf_local_disclaimer');
		return $query->row_array();
	}
	//修改免责声明
	function edit_disclaimer($id,$data){
	    return $this->db->where("id",$id)->update('hf_local_disclaimer',$data);
	}
	//返回所有招聘信息
	function get_recruit_list($type){
		$where['type_name'] = $type;
		$query = $this->db->where($where)->order_by('create_time','desc')->get($this->service);
		return $query->result_array();
	}

}