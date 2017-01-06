<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  商家管理
 *
 * */
require_once(APPPATH.'controllers/Default_Controller.php');

class Moll extends Default_Controller {
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
        $this->load->model('Moll_model');
    }
    
    //业态列表
    function mollyetaiList(){
             //获取所有业态
            $store = $this->Moll_model->get_storetypeList();


            $config['per_page'] = 10;
            //获取页码
            $current_page=intval($this->uri->segment(4));//index.php 后数第4个/
            //var_dump($current_page);
                //配置
            $config['base_url'] = site_url('/moll/Moll/mollyetaiList/');
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
            $listpage = $this->Moll_model->get_storetype_page($config['per_page'],$current_page);
          

            $this->load->library('pagination');//加载ci pagination类
             $this->pagination->initialize($config);
            
            $data['pages'] = $this->pagination->create_links();
            $data['total_rows'] = $config['total_rows'];
            $data['per_page'] = $config['per_page'];
            $data['store'] = $listpage;
         //返回顶级业态
         $data['level'] = $this->Moll_model->get_store('0');
         // 视图
         $data['page'] = $this->view_mollyetaiList;
         $data['menu'] = array('moll','mollyetaiList');
    	 $this->load->view('template.html',$data);
    }
    //新增业态
    function mollAddYetai(){
         //获取父及业态
         $data['store'] =  $this->Moll_model->get_store('0');

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
                $config['upload_path']      = 'Upload/icon';
                $config['allowed_types']    = 'jpg|png|jpeg';
                $config['max_size']     = 2048;
                $config['file_name'] = date('Y-m-d_His');
                $this->load->library('upload', $config);
                //上传
                if ( ! $this->upload->do_upload('icon')) {
                    echo "<script>alert('图片上传失败！');window.location.href='".site_url('/moll/Moll/mollAddYetai/')."'</script>";
                    exit;
                } else{
                    $data['icon'] =  'Upload/icon/'.$this->upload->data('file_name');
                }
            }
            if($this->Moll_model->add_storetype($data)){
                echo "<script>alert('操作成功！');window.location.href='".site_url('/moll/Moll/mollyetaiList')."'</script>";exit;
            }else{
                 echo "<script>alert('操作失败！');window.location.href='".site_url('/moll/Moll/mollAddYetai/')."'</script>";exit;
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
            $data['storeInfo'] = $this->Moll_model->get_storeInfo($id);
            //返回顶级业态
            $data['store'] =  $this->Moll_model->get_store('0');

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
                $config['upload_path']      = 'Upload/icon';
                $config['allowed_types']    = 'jpg|png|jpeg';
                $config['max_size']     = 2048;
                $config['file_name'] = date('Y-m-d_His');
                $this->load->library('upload', $config);
                //上传
                if ( ! $this->upload->do_upload('icon')) {
                    echo "<script>alert('图片上传失败！');window.location.href='".site_url('/moll/Moll/mollEditYetai/'.$data['id'])."'</script>";
                    exit;
                } else{
                    $data['icon'] =  'Upload/icon/'.$this->upload->data('file_name');
                }
            }
            if($this->Moll_model->edit_storeYetai($data['id'],$data)){
                 echo "<script>alert('操作成功！');window.location.href='".site_url('/moll/Moll/mollyetaiList')."'</script>";exit;
            }else{
                  echo "<script>alert('操作失败！');window.location.href='".site_url('/moll/Moll/mollEditYetai/'.$data['id'])."'</script>";
            }
        }else{
            $this->load->view('404.html');
        }
    }

    //ajax 更改业态状态
    function storeType_state(){
        if($_POST){
            $id = $_POST['id'];
            $action = $_POST['action'];
            switch ($action) {
                //正常
                case '1':
                    $data['state'] = '1';
                    if($this->Moll_model->edit_storeYetai($id,$data)){
                        echo "1";
                    }else{
                        echo "2";
                    }
                    break;
                //冻结
                case '2':
                    $data['state'] = '0';
                    if($this->Moll_model->edit_storeYetai($id,$data)){
                        echo "1";
                    }else{
                        echo "2";
                    }
                    break;
            }
        }
    }

    //ajax 删除 业态
    function del_storeType(){
        if($_POST){
            $id = $_POST['id'];
            if($this->Moll_model->del_storeType($id)){
                echo "1";
            }else{
                echo '2';
            }
        }
    }
    //业态搜索
    function search_store(){
        if($_GET){
            $state = $_GET['state'];
            $sear = $_GET['type_name'];
            $gid = $_GET['gid'];
            $store = $this->Moll_model->search($state,$sear,$gid);

            $config['per_page'] = 10;
            //获取页码
            if(isset($_GET['per_page'])){  
                $current_page = $_GET['per_page'];  
            }else{
                  $current_page = '0';  
            }  
            //配置
            $config['base_url'] = site_url('/moll/Moll/search_store?state='.$state.'&type_name='.$sear.'&gid='.$gid);
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
            $config['page_query_string'] = TRUE;  

             //分页数据
            $listpage = $this->Moll_model->search_page($state,$sear,$gid,$config['per_page'],$current_page);
          

            $this->load->library('pagination');//加载ci pagination类
            $this->pagination->initialize($config);
            
            $data['pages'] = $this->pagination->create_links();
            $data['total_rows'] = $config['total_rows'];
            $data['per_page'] = $config['per_page'];
            $data['store'] = $listpage;
             //返回顶级业态
             $data['level'] = $this->Moll_model->get_store('0');
             // 视图
             $data['page'] = $this->view_mollyetaiList;
             $data['menu'] = array('moll','mollyetaiList');
             $this->load->view('template.html',$data);
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
         $data['market'] = $this->Moll_model->get_marketinfo();
         $data['page'] = $this->view_mollBrief;
         $data['menu'] = array('moll','mollBrief');
         $this->load->view('template.html',$data);
    }

    //商场简介修改
    function edit_mollInfo(){
        if($_POST){
            $data = $this->input->post();
            $i = 1;
            foreach ($_FILES as $key => $v) {
                if(!empty($_FILES['img'.$i]['name'])){
                    $config['upload_path']      = 'Upload/logo';
                    $config['allowed_types']    = 'jpg|png|jpeg';
                    $config['max_size']     = 2048;
                    $config['file_name'] = date('Y-m-d_His');
                    $this->load->library('upload', $config);
                    //上传
                    if ( ! $this->upload->do_upload('img'.$i)) {
                        echo "<script>alert('图片上传失败！');window.location.href='".site_url('/moll/Moll/mollBrief')."'</script>";
                        exit;
                    } else{
                        unset($data['img'.$i]);
                        if($i == 1){
                           $data['logo'] =  'Upload/logo/'.$this->upload->data('file_name');
                        }else{
                            $data['pic'] = 'upload/logo/'.$this->upload->data('file_name');
                        }
                    }
                }else{
                    if($i == 1){
                           $data['logo'] =  $data['img'.$i];
                    }else{
                        $data['pic'] = $data['img'.$i];
                    }
                    unset($data['img'.$i]);
                }
                $i ++;
            }

            if($this->Moll_model->edit_mollInfo($data)){
                 echo "<script>alert('操作成功！！');window.location.href='".site_url('/moll/Moll/mollBrief')."'</script>";
                        exit;
            }else{
                 echo "<script>alert('操作失败！');window.location.href='".site_url('/moll/Moll/mollBrief')."'</script>";
                        exit;
            }
        }else{
            $this->load->view('404.html');
        }
    }




}

