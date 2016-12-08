<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  商家管理
 *
 * */
require_once(APPPATH.'controllers/default_Controller.php');

class moll extends default_Controller {
    //业态列表
    public $view_mollyetaiList = "moll/mollyetaiList.html";
    //新增业态
    public $view_mollAddYetai = "moll/mollAddYetai.html";
    //编辑业态
    public $view_mollEditYetai = "moll/mollEditYetai.html";
    //楼层信息
    public $view_mollFloorInfo = "moll/mollFloorInfo.html";
    //商场简介
    public $view_mollBrief = "moll/mollBrief.html";
    function __construct()
    {
        parent::__construct();
        $this->load->model('moll_model');
        $plateid = $this->user_model->group_permiss($this->session->users['gid']);
        $plateid = json_decode($plateid,true);
        if(!empty($plateid)){
            if(!in_array('0',$plateid) && !in_array('1',$plateid)){
                echo "<script>alert('您没有权限访问！');window.location.href='".site_url('/admin/index')."';</script>";exit;
            }
        }
    }
    
    //业态列表
    function mollyetaiList(){
             //获取所有业态
            $store = $this->moll_model->get_storetypeList();


            $config['per_page'] = 10;
            //获取页码
            $current_page=intval($this->uri->segment(4));//index.php 后数第4个/
            //var_dump($current_page);
                //配置
            $config['base_url'] = site_url('/moll/moll/mollyetaiList/');
            //分页配置
            $config['full_tag_open'] = '<ul class="am-pagination tpl-pagination">';
            $config['full_tag_close'] = '</ul>';
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="am-active"><a>';
            $config['cur_tag_close'] = '</a></li>';
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';

            $config['first_link']= '首页';
            $config['next_link']= '下一页';
            $config['prev_link']= '上一页';
            $config['last_link']= '末页';
            $config['num_links'] = 2;
            $config['total_rows'] = count($store);
            //分页数据
            $listpage = $this->moll_model->get_storetype_page($config['per_page'],$current_page);
          

            $this->load->library('pagination');//加载ci pagination类
             $this->pagination->initialize($config);
            
            $data['pages'] = $this->pagination->create_links();
            $data['total_rows'] = $config['total_rows'];
            $data['per_page'] = $config['per_page'];
            $data['store'] = $listpage;
         //返回顶级业态
         $data['level'] = $this->moll_model->get_store('0');
         // 视图
         $data['page'] = $this->view_mollyetaiList;
         $data['menu'] = array('moll','mollyetaiList');
    	 $this->load->view('template.html',$data);
    }
    //新增业态
    function mollAddYetai(){
         //获取父及业态
         $data['store'] =  $this->moll_model->get_store('0');

         $data['page'] = $this->view_mollAddYetai;
         $data['menu'] = array('moll','mollyetaiList');
         $this->load->view('template.html',$data);
    }
    //新增业态操作
    function add_mollYetai(){
        if($_POST){
            $data = $this->input->post();
            if(!empty($_FILES['icon']['tmp_name'])){
                //配置
                $config['upload_path']      = 'upload/icon';
                $config['allowed_types']    = 'jpg|png|jpeg';
                $config['max_size']     = 2048;
                $config['file_name'] = date('Y-m-d_His');
                $this->load->library('upload', $config);
                //上传
                if ( ! $this->upload->do_upload('icon')) {
                    echo "<script>alert('图片上传失败！');window.location.href='".site_url('/moll/moll/mollAddYetai/')."'</script>";
                    exit;
                } else{
                    $data['icon'] =  'upload/icon/'.$this->upload->data('file_name');
                }
            }
            if($this->moll_model->add_storetype($data)){
                echo "<script>alert('操作成功！');window.location.href='".site_url('/moll/moll/mollyetaiList')."'</script>";exit;
            }else{
                 echo "<script>alert('操作失败！');window.location.href='".site_url('/moll/moll/mollAddYetai/')."'</script>";exit;
            }
        }else{
            $this->load->view('404.html');
        }
    }

     //编辑业态
    function mollEditYetai(){
        $id = intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
            //根据ID返回业态详情
            $data['storeInfo'] = $this->moll_model->get_storeInfo($id);
            //返回顶级业态
            $data['store'] =  $this->moll_model->get_store('0');

             $data['page'] = $this->view_mollEditYetai;
             $data['menu'] = array('moll','mollyetaiList');
             $this->load->view('template.html',$data);
        }
    }

    //编辑业态操作
    function edit_storeYetai(){
        if($_POST){
            $data = $this->input->post();
             if(!empty($_FILES['icon']['tmp_name'])){
                //配置
                $config['upload_path']      = 'upload/icon';
                $config['allowed_types']    = 'jpg|png|jpeg';
                $config['max_size']     = 2048;
                $config['file_name'] = date('Y-m-d_His');
                $this->load->library('upload', $config);
                //上传
                if ( ! $this->upload->do_upload('icon')) {
                    echo "<script>alert('图片上传失败！');window.location.href='".site_url('/moll/moll/mollEditYetai/').$data['id']."'</script>";
                    exit;
                } else{
                    $data['icon'] =  'upload/icon/'.$this->upload->data('file_name');
                }
            }
            var_dump($data);
            
        }else{
            $this->load->view('404.html');
        }
    }



    //楼层信息
    function mollFloorInfo(){
         $data['page'] = $this->view_mollFloorInfo;
         $data['menu'] = array('moll','mollFloorInfo');
         $this->load->view('template.html',$data);
    }
    //商场简介
    function mollBrief(){
         $data['market'] = $this->moll_model->get_marketinfo();
 
         $data['page'] = $this->view_mollBrief;
         $data['menu'] = array('moll','mollBrief');
         $this->load->view('template.html',$data);
    }



}

