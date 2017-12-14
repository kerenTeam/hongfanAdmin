<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

/**

*     管理员商城管理 

*/

class Shop_model extends CI_Model

{

    //商家用户表

    public $member = "hf_user_member";

    //店铺表

    public $shop_store = "hf_shop_store";

    //业态表

    public $store_type = "hf_shop_store_type";

    //商品表

    public $goods = "hf_mall_goods";

    //推荐商品，或商家

    public $store_goods = "hf_shop_active_store_goods";



    function __construct()

    {

        parent::__construct();

    }

    //获取所有店铺

    function shop_list($type){

        $where['store_distinction'] = $type;
        $query = $this->db->where($where)->order_by('store_id','desc')->get($this->shop_store);
        return $query->result_array();

    }

    //根据城市返回店铺列表
    function city_shop_list($type,$city){
        
        $where['store_distinction'] = $type;
        $query = $this->db->where($where)->where('city',$city)->order_by('store_id','desc')->get($this->shop_store);

        return $query->result_array();
    }



    //修改店铺状态

    function edit_shop_state($id,$data){

        $where['store_id'] = $id;

        return $this->db->where($where)->update($this->shop_store,$data);

    }

    //修改店铺商品状态

    function edit_goods_state($id,$data){

        $where['storeid'] = $id;

        return $this->db->where($where)->update($this->goods,$data);

    }

    //根据店铺名称返回店铺
    function shopStore($storeName){
        $query = $this->db->where('store_name',$storeName)->get($this->shop_store);
        return $query->row_array();
    }

    //
    function shopIdStore($storeName,$storeId){
        $query = $this->db->where('store_name',$storeName)->where('store_id !=',$storeId)->get($this->shop_store);
        return $query->row_array();
    }

    //新增店铺

    function add_store($data){

        return $this->db->insert($this->shop_store,$data);

    }





    //删除店铺

    function del_shop_store($id){

        $where['store_id'] = $id;

        return $this->db->where($where)->delete($this->shop_store);

    }



    //删除店铺下所有商品

    function del_store_goods($id){

        $where['storeid'] = $id;

        return $this->db->where($where)->delete($this->goods);

    }

    //删除登陆账户

    function del_shop_member($id){

        $where['user_id'] = $id;

        return $this->db->where($where)->delete($this->member);

    }

  

    //获取顶级业态

    function store_type_level(){

        $where['gid'] = '0';

        $query = $this->db->where($where)->get($this->store_type);

        return $query->result_array();

    }

    //返回二级业态

    function store_type_tow($gid){

        $where['gid'] = $gid;

        $query = $this->db->where($where)->get($this->store_type);

        return $query->result_array();

    }

    

    //获取商家信息

    function get_store_Info($id){

        $where['store_id'] = $id;

        $query = $this->db->where($where)->get($this->shop_store);

        return $query->row_array();

    }    

    //获取商户登录用户

    function get_login_store($userid){

        $sql = "SELECT * FROM $this->member where user_id = '$userid'";

        $query = $this->db->query($sql);

        return $query->row_array();

    }

    //修改商家信息

    function edit_store_info($id,$data){

        $where['store_id'] = $id;

        return $this->db->where($where)->update($this->shop_store,$data);

    }

    //新增商家登录账号

    function add_store_member($data){

        $this->db->insert($this->member,$data);

        return $this->db->insert_id();

    }

    //新增商家

    function add_store_info($data){

        return $this->db->insert($this->shop_store,$data);

    }

    //根据username返回数据

    function get_user_info($name){

        $where['phone'] = $name;

        $query = $this->db->where($where)->get($this->member);

        return $query->row_array();

    }

    //用户

    function get_user_id($name){

        $where['username'] = $name;

        $query = $this->db->where('gid','5')->where($where)->get($this->member);

        return $query->row_array();

    }

    //修改商家登录账号

    function edit_store_member($userid,$data){

        $where['user_id'] = $userid;

        return $this->db->where($where)->update($this->member,$data);

    }

    function get_member_info($userid,$username){

        $sql = "SELECT * From $this->member where user_id != '$userid' and phone = '$username'";

        $query = $this->db->query($sql);

        return $query->row_array();

    }

    //根据一级业态名返回id

    function get_store_type_id($name,$gid){

        $where['type_name'] = $name;

        $or_where['gid'] = $gid;

        $query = $this->db->where($or_where)->where($where)->get($this->store_type);

        $type = $query->row_array();

         return $type['id'];

    }



    //新增顶级业态

    function add_store_type($data){

        $this->db->insert($this->store_type,$data);

        return $this->db->insert_id();

    } 

    //根据业态id返回业态名

    function get_store_type_name($id){

        $where['id'] = $id;

        $query = $this->db->where($where)->get($this->store_type);

        $res = $query->row_array();

        return $res['type_name'];

    }





    //获取推荐

    function get_find_shop(){

        $query = $this->db->where('type','2')->or_where('type','3')->get($this->store_goods);

        return $query->result_array();

    }



    //获取hot推荐

    function get_hot_goods(){

        $query = $this->db->where('type','4')->get($this->store_goods);

        return $query->result_array();

    }



    //获取推荐商家信息

    function get_store_find($storeid){

        $this->db->select('store_name,store_id,barnd_name');

        $query = $this->db->where('store_id',$storeid)->where('state','1')->get('hf_shop_store');

        return $query->row_array();

    }



    //获取推荐详情

    function get_sales_info($id){

        $where['id'] = $id;

        $query = $this->db->where($where)->get($this->store_goods);

        return $query->row_array();

    }

   //修改某个展销信息

    function edit_salse($id,$data){

        $where['id'] = $id;

        return $this->db->where($where)->update($this->store_goods,$data);

    }











}













 ?>