<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Default_Controller.php');
/*
*   发现板块
*/
class Find extends Default_Controller {

	//文章；列表
	public $view_content = "find/findContent.html";
    //帖子评论列表
    public $view_comment = "find/findComment.html";
    //新增帖子
    public $view_addService = "find/findAddService.html";
    //编辑帖子
    public $view_editService = "find/findEditService.html";
	//分类列表
	public $view_cates = 'find/findCates.html';
	//标签列表
	public $view_tags = 'find/findTags.html';
    //活动专题
    public $view_findSpecial = 'find/findSpecial.html';
    //活动 增加
    public $view_findAddSpecial = 'find/findAddSpecial.html';
    //活动 编辑
    public $view_findEditSpecial = 'find/findEditSpecial.html';
    //活动专题编辑
    public $view_findActivity = "find/findActivity.html";
    //活动 发现/专题 帖子列表
    public $view_findNotesList = "find/findNotesList.html";

    function __construct()
    {
        parent::__construct();
        $this->load->model('Find_model');
    }

    //文章列表	
	function findContent(){
        $data['cates'] = $this->Find_model->get_find_cates();
        $data['page'] = $this->view_content;
        $data['menu'] = array('find','findContent');
 		$this->load->view('template.html',$data);
    }

    //帖子搜索
    function search_find_service(){
        if($_POST){
            $cateid = $this->input->post('cate_id');
            $sear = $this->input->post('search');
            $list = '';
            //判断条件
            if(!empty($cateid) && empty($sear)){
                $list = $this->Find_model->get_find_cate_service($cateid);
            }else if(empty($cateid) && !empty($sear)){
                $list = $this->Find_model->get_find_sear_service($sear);
            }else if(!empty($cateid) && !empty($sear)){
                $list = $this->Find_model->get_find_service_search($cateid,$sear);
            }

            if(!empty($list)){
                //获取分类名
                 foreach($list as $key=>$val){
                        if(empty($val['categoryid'])){
                            $list[$key]['cate_name'] = "还没有归类,请编辑归类!";
                        }else{
                            $list[$key]['cate_name'] = $this->Find_model->ret_cate_name($val['categoryid']);
                        }
                 }
                 echo json_encode($list);
            }else{
                echo "3";
            }
        }else{
            echo "2";
        }
    }

    //评论列表 
    function findComment(){
        $newsid = intval($this->uri->segment(4));
        if($newsid == 0){
            $this->load->view('404.html');
        }else{
            $data['news_id'] = $newsid;
            $data['page'] = $this->view_comment;
            $data['menu'] = array('find','findContent');
            $this->load->view('template.html',$data);
        }
    }
    //返回评论列表
    function ret_find_service_comment(){
        if($_POST){
            $newsid = $this->input->post('news_id');
            if(!empty($newsid)){
                $list = $this->Find_model->get_find_service_comment($newsid);
                if(!empty($list)){
                    echo json_encode($list);
                }else{
                    echo "3";
                }
            }else{
                echo "3";
            }
        }else{
            echo "2";
        }
    }
    //修改帖子评论
    function edit_service_comment(){
        if($_POST){
            $id = $this->input->post('id');
            $data['state'] = $this->input->post('state');
            $comment = $this->Find_model->get_find_comment($id);
            if($this->Find_model->edit_find_service_comment($id,$data)){
                  // 日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."修改了一个帖子评论状态，帖子编号是".$comment['friend_news_id'].",评论id是：".$id,
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
    //删除帖子评论
    function del_service_comment(){
        if($_POST){
            $id = $this->input->post('id');
            $comment = $this->Find_model->get_find_comment($id);
            if(!empty($comment)){
                if($this->Find_model->del_find_service_comment($id)){
                    // 日志
                    $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  
                        "content" => $_SESSION['users']['username']."删除了一个帖子评论，评论id是：".$id.",帖子遍号是：".$comment['friend_news_id'],
                        "create_time" => date('Y-m-d H:i:s'),
                        "userip" => get_client_ip(),
                    );
                    echo "1";
                }else{
                    echo "3";
                }
            }else{
                echo "3";
            }
        }else{
            echo "2";
        }
    }

    //评论搜索
    function search_find_comment(){
        if($_POST){
            $id = $this->input->post('news_id');
            $sear = $this->input->post('search');
            if(!empty($sear)){
                $list = $this->Find_model->find_comment_search($id,$sear);
                if(!empty($list)){
                    echo json_encode($list);
                }else{
                    echo "3";
                }
            }else{
                echo "3";
            }
        }else{
            echo "2";
        }
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

    //推荐帖子
    function find_recommend(){
        if($_POST){
            $id = $this->input->post('newsid');
            $data['type_name'] = $this->input->post('type');
          
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
                   $data['banner_pic'] = '/Upload/find/'.$this->upload->data('file_name');
                }
            }
            if($this->Find_model->edit_find_service($id,$data)){
                // 日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."推荐了一个帖子到首页显示，帖子id是".$id,
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

    //批量给帖子设置分类
    function find_service_cate(){
        if($_POST){
            $id = $this->input->post('ids');
            $data['categoryid'] = $this->input->post('cate_id');
            $arr = json_decode($id,true);
            foreach($arr as $v){
                $ls = $this->Find_model->edit_find_service($v,$data);
            }
            if($ls){
                   // 日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."批量给帖子设置了分类，帖子id是".implode(',',$arr).',分类id是:'.$data['categoryid'],
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
            //获取帖子标签
            $data['news_tag'] = $this->Find_model->ret_news_tag($id);
          
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
                    $pic[0]['picImg'] = '/Upload/find/'.$this->upload->data('file_name');
                    $data['pic']= json_encode($pic);
                }
            }
            $tags = explode(',',$data['tags']);
            unset($data['tags']);
            if($this->Find_model->edit_find_service($data['news_id'],$data)){
                //删除所有已有的标签
                $this->Find_model->del_news_tags($data['news_id']);
                //新增帖子标签
                foreach($tags as $v){
                    $arr = array(
                        'userid'=> $data['userid'],
                        'news_id' => $data['news_id'],
                        'tag_id' => $v,
                        'create_news_tag_time'=> date('Y-m-d H:i:s'),
                    );
                    $this->Find_model->add_news_tag($arr);
                }
                // 日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."编辑了一个帖子，帖子id是：".$data['news_id'],
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);
                echo "<script>alert('操作成功！');window.location.href='".site_url('/find/Find/findContent')."'</script>";exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/find/Find/findContent')."'</script>";exit;
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
                    //删除所有已有的标签
                    $this->Find_model->del_news_tags($id);
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

    //批量删除帖子
    function del_service_find(){
        if($_POST){
            $id = $this->input->post('ids');
            $arr = json_decode($id,true);
           // var_dump($arr);exit;
            foreach($arr as $v){
                //删除所有已有的标签
                $this->Find_model->del_news_tags($v);
                $ls = $this->Find_model->del_find_service($v);
            }
            if($ls){
                      // 日志
                    $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  
                        "content" => $_SESSION['users']['username']."批量删除了帖子，帖子id是：". implode(',',$arr),
                        "create_time" => date('Y-m-d H:i:s'),
                        "userip" => get_client_ip(),
                    );
                    $this->db->insert('hf_system_journal',$log);
                    echo "1";
            }else{
                echo "3";
            }

        }else{
            echo "3";
        }
    }



    //新增帖子界面
    function addService(){
        $id = intval($this->uri->segment(4));
        if($id == 0){
            $data['q_id'] = '';
        }else{
            $data['q_id'] = $id;
        }
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
                     $pic[0]['picImg'] = '/Upload/find/'.$this->upload->data('file_name');
                    $data['pic']= json_encode($pic);
                }
            }
            $tags = explode(',',$data['tags']);
            unset($data['tags']);
            $data['userid'] = $_SESSION['users']['user_id'];
            $data['create_news_time'] = date('Y_m-d H:i:s');

            $id =$this->Find_model->add_find_service($data); 
            if($id){
                foreach($tags as $v){
                    $arr = array(
                        'userid'=> $data['userid'],
                        'news_id' => $id,
                        'tag_id' => $v,
                        'create_news_tag_time'=> $data['create_news_time'],
                    );
                    $this->Find_model->add_news_tag($arr);
                }
                // 日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."新增了一个帖子，帖子id是".$id,
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);
                 if(!empty($data['q_id'])){
                    
                    echo "<script>alert('操作成功！');window.location.href='".site_url('/find/Find/findNotesList/'.$data['q_id'])."'</script>";exit;
                 }else{
                     echo "<script>alert('操作成功！');window.location.href='".site_url('/find/Find/findContent')."'</script>";exit;
                 }
            }else{
                if(!empty($data['q_id'])){
                echo "<script>alert('操作失败！');window.location.href='".site_url('/find/Find/addService/'.$data['q_id'])."'</script>";exit;
                }else{
                     echo "<script>alert('操作失败！');window.location.href='".site_url('/find/Find/findContent')."'</script>";exit;
                }
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
            foreach($list as $k=>$v){
                $list[$k]['nums'] = count($this->Find_model->get_find_cate_service($v['cate_id']));
            }
            if($list){
                echo json_encode($list);
            }else{
                echo "3";
            }
        }else{
            echo "2";
        }
    }

    //分类搜所
    function search_find_cates(){
        if($_POST){
            $sear = $this->input->post('search');
            $list = $this->Find_model->find_cates_search($sear);
            if(empty($list)){
                echo "3";
            }else{
                echo json_encode($list);
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
    
    //标签搜索
    function search_find_tags(){
        if($_POST){
            $sear = $this->input->post('search');
            $list = $this->Find_model->find_tags_search($sear);
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
            if($this->Find_model->edit_find_tags($data['tag_id'],$data)){
                  // 日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."修改了一个发现板块的标签，标签名称是：".$data['tagName']."，标签id是：".$data['tag_id'],
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

    //返回活动专题icon
    function findActivity(){
        $data['activity'] = $this->Find_model->ret_find_activity();
        
        $data['page'] = $this->view_findActivity;
        $data['menu'] = array('find','findActivity');
 		$this->load->view('template.html',$data);
    }
    //编辑活动专题icon
    function edit_findActivity(){
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
                    echo "<script>alert('图片上传失败！');window.location.href=''".site_url('/find/Find/findActivity')."'</script>";
                    exit;
                } else{
                     $data['act_pic'] = '/Upload/find/'.$this->upload->data('file_name');
                }
            }
            if($data['act_id'] == 1){
                $title = "活动";
            }else{
                $title = "专题";
            }
            if($this->Find_model->edit_findActivity($data['act_id'],$data)){
                    // 日志
                    $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  
                        "content" => $_SESSION['users']['username']."修改了".$title."icon，更改后名称为：".$data['act_name'],
                        "create_time" => date('Y-m-d H:i:s'),
                        "userip" => get_client_ip(),
                    );
                    $this->db->insert('hf_system_journal',$log);
                  echo "<script>alert('操作成功！');window.location.href='".site_url('/find/Find/findActivity')."'</script>"; exit;
                   
            }else{
                 echo "<script>alert('操作失败！');window.location.href='".site_url('/find/Find/findActivity')."'</script>";
                    exit;
            }
        }else{
            $this->load->view('404.html');
        }
    }
    
    //发现专题 列表
    function findSpecial(){
        $id = intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
            $data['type'] = $id;
            $data['page'] = $this->view_findSpecial;
            $data['menu'] = array('find','findActivity');
            $this->load->view('template.html',$data);
        }
    }

    //返回专题活动列表
    function ret_findSpecial_list(){
        if($_POST){
            $type = $this->input->post('type');
            $list = $this->Find_model->get_find_special($type);
            foreach($list as $k=>$v){
                $a = $this->Find_model->get_find_special_serviceList($v['q_id']);
                $list[$k]['nums'] = count($a);
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

    //活动专题 新增
    function findAddSpecial(){
        $id = intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
            $data['type'] = $id;
            $data['page'] = $this->view_findAddSpecial;
            $data['menu'] = array('find','findActivity');
            $this->load->view('template.html',$data);
        }
    }

    //活动专题 新增操作
    function add_findSpecial(){
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
                    echo "<script>alert('图片上传失败！');window.location.href='".site_url('/find/Find/findAddSpecial/'.$data['act_id'])."'</script>";
                    exit;
                } else{
                     $data['pic'] = '/Upload/find/'.$this->upload->data('file_name');
                }
            }
            if($this->Find_model->add_find_special($data)){
                if($data['act_id'] == 1){
                    $title = "活动";
                }else{
                    $title = "专题";
                }
                // 日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."新增了一个".$title."，名称是：".$data['title'],
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);

                 echo "<script>alert('操作成功！');window.location.href='".site_url('/find/Find/findSpecial/'.$data['act_id'])."'</script>";
                    exit;
            }else{
                 echo "<script>alert('操作失败！');window.location.href='".site_url('/find/Find/findAddSpecial/'.$data['act_id'])."'</script>";
                    exit;
            }            
        }else{
            $this->load->view('404.html');
        }
    }


    //活动专题 编辑
    function findEditSpecial(){      
        $id = intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
            $data['info'] = $list = $this->Find_model->ret_findActSpecial($id);
            $data['page'] = $this->view_findEditSpecial;
            $data['menu'] = array('find','findActivity');
            $this->load->view('template.html',$data);
        }
    }
    //活动专题 编辑操作
    function edit_find_special(){
        if($_POST){
            $data = $this->input->post();
            $act = $list = $this->Find_model->ret_findActSpecial($data['q_id']);
         
            if(!empty($_FILES['img']['tmp_name'])){
                $config['upload_path']      = 'Upload/find';
                $config['allowed_types']    = 'gif|jpg|png|jpeg';
                $config['max_size']     = 2048;
                $config['file_name'] = date('Y-m-d_His');
                $this->load->library('upload', $config);
                //上传
                if ( ! $this->upload->do_upload('img')) {
                    echo "<script>alert('图片上传失败！');window.location.href='".site_url('/find/Find/findEditSpecial/'.$data['q_id'])."'</script>";
                    exit;
                } else{
                     unlink(substr($act['pic'],1));
                     $data['pic'] = '/Upload/find/'.$this->upload->data('file_name');
                }
            }
            if($this->Find_model->edit_find_special($data['q_id'],$data)){
                    if($act['act_id'] == 1){
                        $title = "活动";
                    }else{
                        $title = "专题";
                    }
                    // 日志
                    $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  
                        "content" => $_SESSION['users']['username']."编辑了一个".$title."，名称是：".$data['title'].',id是：'.$data['q_id'],
                        "create_time" => date('Y-m-d H:i:s'),
                        "userip" => get_client_ip(),
                    );
                $this->db->insert('hf_system_journal',$log);

                    echo "<script>alert('操作成功！');window.location.href='".site_url('/find/Find/findSpecial/'.$act['act_id'])."'</script>";
                    exit;
            }else{
                  echo "<script>alert('操作失败！');window.location.href='".site_url('/find/Find/findEditSpecial/'.$data['q_id'])."'</script>";
                    exit;
            }
        }else{
            $this->load->view('404.html');
        }
    }

    //删除活动或专题
    function del_findSpecial(){
        if($_POST){
            $id = $this->input->post('q_id');
            if($this->Find_model->del_find_special($id)){
                if($this->Find_model->del_find_special_server($id)){
                    echo "1";
                }else{
                    echo "3";
                }
            }else{
                echo "3";
            }
        }else{
            echo "2";
        }
    }
    //发现 发现/专题 帖子列表
    function findNotesList(){
        
        $id = intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
            $data['id'] = $id;
            $data['page'] = $this->view_findNotesList;
            $data['menu'] = array('find','findActivity');
            $this->load->view('template.html',$data);
        }
    }
    //返回活动专题帖子列表
    function ret_findSpecial_service(){
        if($_POST){
            $q_id = $this->input->post('q_id');
            $list = $this->Find_model->get_find_special_serviceList($q_id);
            if(!empty($list)){
                echo json_encode($list);
            }else{
                echo "3";
            }
        }else{
            echo "2";
        }
    }

    //推荐专题到banner显示
    function findSpecial_recommend(){
        if($_POST){
            $id = $this->input->post('q_id');
            $data['banner_state'] = $this->input->post('banner_state');
            if($this->Find_model->edit_find_special($id,$data)){
                  
                    // 日志
                    $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  
                        "content" => $_SESSION['users']['username']."推荐了一个专题展示到banner,id是：".$id,
                        "create_time" => date('Y-m-d H:i:s'),
                        "userip" => get_client_ip(),
                    );
                    $this->db->insert('hf_system_journal',$log);

                    echo "1";
                    exit;
            }else{
                  echo "3";
                    exit;
            }
        }else{
            echo "2";
        }
    }

    //取消推荐显示
    function findSpecial_Qurecommend(){
        if($_POST){
            $id = $this->input->post('id');
             $data['type_name'] = '0';
            if($this->db->where('news_id',$id)->update('hf_friend_news',$data)){
                // 日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."取消了一个首页推荐帖子，帖子id是：".$id,
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);
                echo "1";
            }else{
                echo "2";
            }
        }else{
            echo "3";
        }
    }

}
