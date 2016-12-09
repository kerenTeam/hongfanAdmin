<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  商家管理
 *
 * */
require_once(APPPATH.'controllers/default_Controller.php');
class shop extends default_Controller {
    //商家首页
    public $view_shopIndex = "shop/shopList.html";
    //新增商家
    public $view_addShop = "shop/addShop.html";
    //编辑商家
    public $view_EditShop = "shop/editShop.html";
    //ceshio
    public $view_ceshi = "banner/ceshi.html";

    function __construct()
    {
        parent::__construct();
        $plateid = $this->user_model->group_permiss($this->session->users['gid']);
        $plateid = json_decode($plateid,true);
        if(!empty($plateid)){
            if(!in_array('0',$plateid) && !in_array('3',$plateid)){
                echo "<script>alert('您没有权限访问！');window.location.href='".site_url('/admin/index')."';</script>";exit;
            }
        }else{
             echo "<script>alert('您没有权限访问！');window.location.href='".site_url('/admin/index')."';</script>";exit;
        }
        //model
        $this->load->model('shop_model');


    }

    //商家 列表主页
    function index()
    {  

        //  $config['per_page'] = 10;
        //     //获取页码
        // $current_page=intval($this->uri->segment(4));//index.php 后数第4个/
        // //var_dump($current_page);
        //     //配置
        // $config['base_url'] = site_url('/moll/moll/mollyetaiList/');
        // //分页配置
        // $config['full_tag_open'] = '<ul class="am-pagination tpl-pagination">';
        // $config['full_tag_close'] = '</ul>';
        // $config['first_tag_open'] = '<li>';
        // $config['first_tag_close'] = '</li>';
        // $config['prev_tag_open'] = '<li>';
        // $config['prev_tag_close'] = '</li>';
        // $config['next_tag_open'] = '<li>';
        // $config['next_tag_close'] = '</li>';
        // $config['cur_tag_open'] = '<li class="am-active"><a>';
        // $config['cur_tag_close'] = '</a></li>';
        // $config['last_tag_open'] = '<li>';
        // $config['last_tag_close'] = '</li>';
        // $config['num_tag_open'] = '<li>';
        // $config['num_tag_close'] = '</li>';

        // $config['first_link']= '首页';
        // $config['next_link']= '下一页';
        // $config['prev_link']= '上一页';
        // $config['last_link']= '末页';
        // $config['num_links'] = 2;
         // $shop = $this->shop_model->shop_list(); 
        // $config['total_rows'] = $shop;
        // //分页数据
        // $listpage = $this->shop_model->shop_list_page($config['per_page'],$current_page);
          

        //     $this->load->library('pagination');//加载ci pagination类
        //     $this->pagination->initialize($config);
        //     $data['pages'] = $this->pagination->create_links();
        // //获取商家列表
        // $data['shops']= $listpage;
        // //获取业态
        // $data['type'] = $this->shop_model->store_type_level();


         $data['page'] = $this->view_ceshi;
         $data['menu'] = array('shop','shopList');
    	 $this->load->view('template.html',$data);
    }
    function return_page(){
       echo '[
    {
        "store_id": "1",
        "business_id": "2",
        "barnd_name": "华为",
        "store_name": "华为手机",
        "secondary_name": "华为手机旗舰店",
        "en_name": "huawei",
        "block_name": "天富三街",
        "floor_name": "1楼",
        "door_no": "1003",
        "commercial_type_name": null,
        "subcommercial_type_name": null,
        "dych_commercial_type_name": null,
        "dych_subcommercial_type_name": null,
        "pct": null,
        "business_hours": "早上9:00 - 晚上22：00",
        "phone": "13245875121",
        "description": "华为手机简介",
        "sina_weibo": null,
        "tc_weibo": null,
        "wechat": null,
        "web_site": null,
        "shop_code": null,
        "area": null,
        "tags": null,
        "logo": "https://g-search1.alicdn.com/img/bao/uploaded/i4//5a/f4/TB1DqPwMXXXXXbkXVXXSutbFXXX.jpg_70x70.jpg",
        "pic": "[{\"picImg\":\"https://ss1.bdstatic.com/70cFuXSh_Q1YnxGkpoWK1HF6hhy/it/u=34949323,3316289746&fm=116&gp=0.jpg\"}]",
        "qr_code": null,
        "op_status": "营业中",
        "create_time": null
    },{
        "store_id": "1",
        "business_id": "2",
        "barnd_name": "华为",
        "store_name": "华为手机",
        "secondary_name": "华为手机旗舰店",
        "en_name": "huawei",
        "block_name": "天富三街",
        "floor_name": "1楼",
        "door_no": "1003",
        "commercial_type_name": null,
        "subcommercial_type_name": null,
        "dych_commercial_type_name": null,
        "dych_subcommercial_type_name": null,
        "pct": null,
        "business_hours": "早上9:00 - 晚上22：00",
        "phone": "13245875121",
        "description": "华为手机简介",
        "sina_weibo": null,
        "tc_weibo": null,
        "wechat": null,
        "web_site": null,
        "shop_code": null,
        "area": null,
        "tags": null,
        "logo": "https://g-search1.alicdn.com/img/bao/uploaded/i4//5a/f4/TB1DqPwMXXXXXbkXVXXSutbFXXX.jpg_70x70.jpg",
        "pic": "[{\"picImg\":\"https://ss1.bdstatic.com/70cFuXSh_Q1YnxGkpoWK1HF6hhy/it/u=34949323,3316289746&fm=116&gp=0.jpg\"}]",
        "qr_code": null,
        "op_status": "营业中",
        "create_time": null
    },{
        "store_id": "1",
        "business_id": "2",
        "barnd_name": "华为",
        "store_name": "华为手机",
        "secondary_name": "华为手机旗舰店",
        "en_name": "huawei",
        "block_name": "天富三街",
        "floor_name": "1楼",
        "door_no": "1003",
        "commercial_type_name": null,
        "subcommercial_type_name": null,
        "dych_commercial_type_name": null,
        "dych_subcommercial_type_name": null,
        "pct": null,
        "business_hours": "早上9:00 - 晚上22：00",
        "phone": "13245875121",
        "description": "华为手机简介",
        "sina_weibo": null,
        "tc_weibo": null,
        "wechat": null,
        "web_site": null,
        "shop_code": null,
        "area": null,
        "tags": null,
        "logo": "https://g-search1.alicdn.com/img/bao/uploaded/i4//5a/f4/TB1DqPwMXXXXXbkXVXXSutbFXXX.jpg_70x70.jpg",
        "pic": "[{\"picImg\":\"https://ss1.bdstatic.com/70cFuXSh_Q1YnxGkpoWK1HF6hhy/it/u=34949323,3316289746&fm=116&gp=0.jpg\"}]",
        "qr_code": null,
        "op_status": "营业中",
        "create_time": null
    },{
        "store_id": "1",
        "business_id": "2",
        "barnd_name": "华为",
        "store_name": "华为手机",
        "secondary_name": "华为手机旗舰店",
        "en_name": "huawei",
        "block_name": "天富三街",
        "floor_name": "1楼",
        "door_no": "1003",
        "commercial_type_name": null,
        "subcommercial_type_name": null,
        "dych_commercial_type_name": null,
        "dych_subcommercial_type_name": null,
        "pct": null,
        "business_hours": "早上9:00 - 晚上22：00",
        "phone": "13245875121",
        "description": "华为手机简介",
        "sina_weibo": null,
        "tc_weibo": null,
        "wechat": null,
        "web_site": null,
        "shop_code": null,
        "area": null,
        "tags": null,
        "logo": "https://g-search1.alicdn.com/img/bao/uploaded/i4//5a/f4/TB1DqPwMXXXXXbkXVXXSutbFXXX.jpg_70x70.jpg",
        "pic": "[{\"picImg\":\"https://ss1.bdstatic.com/70cFuXSh_Q1YnxGkpoWK1HF6hhy/it/u=34949323,3316289746&fm=116&gp=0.jpg\"}]",
        "qr_code": null,
        "op_status": "营业中",
        "create_time": null
    },{
        "store_id": "1",
        "business_id": "2",
        "barnd_name": "华为",
        "store_name": "华为手机",
        "secondary_name": "华为手机旗舰店",
        "en_name": "huawei",
        "block_name": "天富三街",
        "floor_name": "1楼",
        "door_no": "1003",
        "commercial_type_name": null,
        "subcommercial_type_name": null,
        "dych_commercial_type_name": null,
        "dych_subcommercial_type_name": null,
        "pct": null,
        "business_hours": "早上9:00 - 晚上22：00",
        "phone": "13245875121",
        "description": "华为手机简介",
        "sina_weibo": null,
        "tc_weibo": null,
        "wechat": null,
        "web_site": null,
        "shop_code": null,
        "area": null,
        "tags": null,
        "logo": "https://g-search1.alicdn.com/img/bao/uploaded/i4//5a/f4/TB1DqPwMXXXXXbkXVXXSutbFXXX.jpg_70x70.jpg",
        "pic": "[{\"picImg\":\"https://ss1.bdstatic.com/70cFuXSh_Q1YnxGkpoWK1HF6hhy/it/u=34949323,3316289746&fm=116&gp=0.jpg\"}]",
        "qr_code": null,
        "op_status": "营业中",
        "create_time": null
    },{
        "store_id": "1",
        "business_id": "2",
        "barnd_name": "华为",
        "store_name": "华为手机",
        "secondary_name": "华为手机旗舰店",
        "en_name": "huawei",
        "block_name": "天富三街",
        "floor_name": "1楼",
        "door_no": "1003",
        "commercial_type_name": null,
        "subcommercial_type_name": null,
        "dych_commercial_type_name": null,
        "dych_subcommercial_type_name": null,
        "pct": null,
        "business_hours": "早上9:00 - 晚上22：00",
        "phone": "13245875121",
        "description": "华为手机简介",
        "sina_weibo": null,
        "tc_weibo": null,
        "wechat": null,
        "web_site": null,
        "shop_code": null,
        "area": null,
        "tags": null,
        "logo": "https://g-search1.alicdn.com/img/bao/uploaded/i4//5a/f4/TB1DqPwMXXXXXbkXVXXSutbFXXX.jpg_70x70.jpg",
        "pic": "[{\"picImg\":\"https://ss1.bdstatic.com/70cFuXSh_Q1YnxGkpoWK1HF6hhy/it/u=34949323,3316289746&fm=116&gp=0.jpg\"}]",
        "qr_code": null,
        "op_status": "营业中",
        "create_time": null
    },{
        "store_id": "1",
        "business_id": "2",
        "barnd_name": "华为",
        "store_name": "华为手机",
        "secondary_name": "华为手机旗舰店",
        "en_name": "huawei",
        "block_name": "天富三街",
        "floor_name": "1楼",
        "door_no": "1003",
        "commercial_type_name": null,
        "subcommercial_type_name": null,
        "dych_commercial_type_name": null,
        "dych_subcommercial_type_name": null,
        "pct": null,
        "business_hours": "早上9:00 - 晚上22：00",
        "phone": "13245875121",
        "description": "华为手机简介",
        "sina_weibo": null,
        "tc_weibo": null,
        "wechat": null,
        "web_site": null,
        "shop_code": null,
        "area": null,
        "tags": null,
        "logo": "https://g-search1.alicdn.com/img/bao/uploaded/i4//5a/f4/TB1DqPwMXXXXXbkXVXXSutbFXXX.jpg_70x70.jpg",
        "pic": "[{\"picImg\":\"https://ss1.bdstatic.com/70cFuXSh_Q1YnxGkpoWK1HF6hhy/it/u=34949323,3316289746&fm=116&gp=0.jpg\"}]",
        "qr_code": null,
        "op_status": "营业中",
        "create_time": null
    }
]';
    }


    //商家管理
    function shop_admin(){

    	 $this->load->view('shop/shopInfo.html');
    }
    //新增商家
    function addShop(){
        $data['page'] = $this->view_addShop;
        $data['menu'] = array('shop','addShop');
        $this->load->view('template.html',$data);
       
    }
    //编辑商家信息
    function editShop(){
        $data['page'] = $this->view_EditShop;
        $data['menu'] = array('shop','shopList');
        $this->load->view('template.html',$data);
    }


}

