<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Default_Controller.php');
/*
*   发现板块
*/
class Find extends CI_Controller {

	//文章；列表
	public $view_content = "find/findContent.html";
    //新增帖子
    public $view_addService = "find/findAddService.html";
    //编辑帖子
    public $view_editService = "find/findEditService.html";
	//分类列表
	public $view_cates = 'find/findCates.html';
	//标签列表
	public $view_tags = 'find/findTags.html';


    function __construct()
    {
        parent::__construct();
        $this->load->model('Find_model');
    }

    //文章列表	
	function findContent(){

        $data['page'] = $this->view_content;
        $data['menu'] = array('find','findContent');
 		$this->load->view('template.html',$data);
    }
    //返回帖子列表
    function ret_find_service(){
        if($_POST){
            $list = $this->Find_model->get_find_service();
            foreach($list as $key=>$val){
                if(empty($val['categoryid'])){
                    $list[$key]['cate_name'] = "还没有归类,请编辑归类!";
                }else{
                    $list[$key]['cate_name'] = $this->Find_model->ret_cate_name($val['categoryid']);
                }
            }
            if(!empty($list)){
                echo json_encode($list);
            }else{
                echo "3";
            }
        }else{
            echo "2";
        }
    }
    //编辑帖子界面
    function editFindService(){
        $id = intval($this->uri->segment(4));
        //获取要编辑的数据
        $news = $this->Find_model->ret_find_content($id);
        if(empty($news)){
            $this->load->view('404.html');
        }else{
            //获取所有分类
            $data['cates'] = $this->Find_model->get_find_cates();
            //获取热门标签
            $data['tags'] = $this->Find_model->get_hot_tags();
         
            $data['news'] = $news;
            $data['page'] = $this->view_editService;
            $data['menu'] = array('find','findContent');
            $this->load->view('template.html',$data);
         }
    }
    //修改帖子操作
    function edit_service(){
        if($_POST){
            $data = $this->input->post();
            if(!empty($_FILES['picArray']['tmp_name'])){
                $config['upload_path']      = 'Upload/find';
                $config['allowed_types']    = 'gif|jpg|png|jpeg';
                $config['max_size']     = 2048;
                $config['file_name'] = date('Y-m-d_His');
                $this->load->library('upload', $config);
                //上传
                if ( ! $this->upload->do_upload('picArray')) {
                    echo "3";
                    exit;
                } else{
                    $data['pic'] = '/Upload/find/'.$this->upload->data('file_name');
                }
            }
            if($this->Find_model->edit_find_service($data['find_id'],$data)){
                // 日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."编辑了一个帖子，帖子id是：".$data['find_id'],
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);
                echo "1";
            }else{
                echo "3";
            }

        }else{
            echo "2";
        }
    }

    //删除帖子
    function del_sercive(){
        if($_POST){
            $id = $this->input->post('find_id');
            if(empty($id)){
               echo "3";
            }else{
                $pic = $this->Find_model->ret_find_content($id);
                @unlink(substr($pic['pic'],'1'));
                if($this->Find_model->del_find_service($id)){
                      // 日志
                    $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  
                        "content" => $_SESSION['users']['username']."删除了一个帖子，帖子id是：".$id,
                        "create_time" => date('Y-m-d H:i:s'),
                        "userip" => get_client_ip(),
                    );
                    $this->db->insert('hf_system_journal',$log);
                    echo "1";
                }else{
                    echo "3";
                }
            }
        }else{
            echo "2";
        }
    }
    //新增帖子界面
    function addService(){
        //获取所有分类
        $data['cates'] = $this->Find_model->get_find_cates();
        //获取热门标签
        $data['tags'] = $this->Find_model->get_hot_tags();


        $data['page'] = $this->view_addService;
        $data['menu'] = array('find','findContent');
 		$this->load->view('template.html',$data);
    }


    //新增帖子操作
    function add_find_service(){
        if($_POST){
            $data = $this->input->post();
            if(!empty($_FILES['img']['tmp_name'])){
                $config['upload_path']      = 'Upload/find';
                $config['allowed_types']    = 'gif|jpg|png|jpeg';
                $config['max_size']     = 2048;
                $config['file_name'] = date('Y-m-d_His');
                $this->load->library('upload', $config);
                //上传
                if ( ! $this->upload->do_upload('img')) {
                    echo "3";
                    exit;
                } else{
                    $data['pic'] = '/Upload/find/'.$this->upload->data('file_name');
                }
            }
            $data['tags'] = str_replace(',','|||',$data['tags']);
            $data['userid'] = $_SESSION['users']['user_id'];
            $data['create_time'] = date('Y_m-d H:i:s');

            $id =$this->Find_model->add_find_service($data); 
            if($id){
                // 日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."新增了一个帖子，帖子id是".$id,
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);
                echo "<script>alert('操作成功！');window.location.href='".site_url('/find/Find/findContent')."'</script>";exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/find/Find/findContent')."'</script>";exit;
            }

        }else{
            $this->load->view('404.html');
        }
    }

    //分类列表
    function findCates(){

    	$data['page'] = $this->view_cates;
        $data['menu'] = array('find','findCates');
 		$this->load->view('template.html',$data);
    }

    //返回分类列表
    function ret_find_cates(){
        if($_POST){
            $list = $this->Find_model->get_find_cates();
            if($list){
                echo json_encode($list);
            }else{
                echo "3";
            }
        }else{
            echo "2";
        }

    }

    //新增分类操作
    function add_find_cates(){
        if($_POST){
            $data = $this->input->post();
            $data['create_time'] = date('Y-m-d H:i:s');
            if($this->Find_model->add_find_cates($data)){
                 // 日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."新增了一个发现板块的分类，分类名称是：".$data['cate_name'],
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);
                echo "<script>alert('操作成功！');window.location.href='".site_url('/find/Find/findCates')."'</script>";exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/find/Find/findCates')."'</script>";exit;
            }
        }else{
            $this->load->view('404.html');
        }
    }

    //编辑分类操作
    function edit_find_cates(){
         if($_POST){
            $id = $this->input->post('cate_id');
            $data['cate_name'] = $this->input->post('cate_name');
            $data['sort'] = $this->input->post('sort');
            if($this->Find_model->edit_find_cates($id,$data)){
                // 日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."编辑了一个发现板块的分类，分类id是：".$id,
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);
                echo "1";
            }else{
                echo "3";
            }

         }else{
             echo "2";
         }
    }

    //删除分类
    function del_find_cates(){
        if($_POST){
            $id = $this->input->post('cate_id');
            if($this->Find_model->del_find_cates($id)){
                // 日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."删除了一个发现板块的分类，分类id是：".$id,
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);
                echo "1";
            }else{
                echo "2";
            }
        }else{
            echo "2";
        }
    }


    //标签列表
    function findTags(){

    	$data['page'] = $this->view_tags;
        $data['menu'] = array('find','findTags');
 		$this->load->view('template.html',$data);
    }

    //返回标签列表
    function ret_find_tags(){
        if($_POST){
            $list = $this->Find_model->get_find_tags();
            if($list){
                echo json_encode($list);
            }else{
                echo "3";
            }
        }else{
            echo "2";
        }
    }

    //新增标签操作
    function add_find_tags(){
        if($_POST){
            $data = $this->input->post();
            $data['create_time'] = date('Y-m-d H:i:s');
            if($this->Find_model->add_find_tags($data)){
                // 日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."新增了一个发现板块的标签，标签名称是：".$data['tagName'],
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);
                echo "<script>alert('操作成功！');window.location.href='".site_url('/find/Find/findTags')."'</script>";exit;
            }else{  
                echo "<script>alert('操作失败！');window.location.href='".site_url('/find/Find/findTags')."'</script>";exit;
            }
        }else{
            $this->load->view('404.html');
        }
    }

    //编辑标签操作
    function edit_find_tags(){
        if($_POST){
            $data = $this->input->post();
            if($this->Find_model->edit_find_tags($data['tagid'],$data)){
                  // 日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."修改了一个发现板块的标签，标签名称是：".$data['tagName']."，标签id是：".$data['tagid'],
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);
                echo "1";
            }else{
                echo "3";
            }
        }else{
            echo "2";
        }
    }

    //删除标签
    function del_find_tags(){
        if($_POST){
            $id = $this->input->post('tagid');
            if($this->Find_model->del_find_tags($id)){
                  // 日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."删除了一个发现板块的标签，标签id是：".$id,
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);
                echo "1";
            }else{
                echo "3";
            }
        }else{
            echo "2";
        }
    }





}
