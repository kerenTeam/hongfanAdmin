<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  家乡报道
 *
 * */
require_once(APPPATH.'controllers/Default_Controller.php');
class HomeReport extends Default_Controller {
    //本地生活 家乡报道
    public $view_homeReport = "module/homeReport/homeReport.html";
    //本地生活 家乡报道 编辑新闻
    public $view_homeReportEdit = "module/homeReport/homeReportEdit.html";
    //本地生活 家乡报道 新增新闻
    public $view_homeReportAdd = "module/homeReport/homeReportAdd.html";
    function __construct()
    {
        parent::__construct();
        $this->load->model('System_model');
    }
    //本地生活 家乡报道
    function index()
    {
        $data['page'] = $this->view_homeReport;
        $data['menu'] = array('localLife','homeReport');
        $this->load->view('template.html',$data);
    }
    //本地生活 家乡报道 编辑新闻
    function homeReportEdit()
    {
        $id = intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
            $data['info'] = $this->System_model->get_notice_info($id);
            $data['page'] = $this->view_homeReportEdit;
            $data['menu'] = array('localLife','homeReport');
            $this->load->view('template.html',$data);
        }
    }
     //本地生活 家乡报道 新增新闻
    function homeReportAdd()
    {
        $data['page'] = $this->view_homeReportAdd;
        $data['menu'] = array('localLife','homeReport');
        $this->load->view('template.html',$data);
    }
    //返回所有公告
    function get_notice_list(){
        if($_POST){
            $list = $this->System_model->get_notice_list();
            if(empty($list)){
                echo "2";
            }else{
                echo json_encode($list);
            }
        }else{
            echo "2";
        }
    }

    //新增系统公告
    function add_notice(){
        if($_POST){
            $data = $this->input->post();
            if(!empty($_FILES['img']['tmp_name'])){
                $config['upload_path']      = 'Upload/news';
                $config['allowed_types']    = 'gif|jpg|png|jpeg';
                $config['max_size']     = 2048;
                $config['file_name'] = date('Y-m-d_His');
                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload('img')) {
                    echo "<script>alert('图片上传失败！');window.location.href='".site_url('/module/HomeReport/index')."'</script>";
                    exit;
                } else {
                    $data['pic'] =  '/Upload/news/'.$this->upload->data('file_name');
                }
            }
            $data['userid'] = $this->session->users['user_id'];
            if($this->System_model->add_notice($data)){
                //日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."新增了一个系统公告。公告名称是".$data['name'],
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);

                 echo "<script>alert('操作成功！');window.location.href='".site_url('/module/HomeReport/index')."'</script>";
                    exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/module/HomeReport/homeReportAdd')."'</script>";
                    exit; 
            }
        }else{
            $this->load->view('404.html');
        }
    }

    //编辑系统公告
    function edit_notice(){
        if($_POST){
            $data = $this->input->post();
            if(!empty($_FILES['img']['tmp_name'])){
                $config['upload_path']      = 'Upload/news';
                $config['allowed_types']    = 'gif|jpg|png|jpeg';
                $config['max_size']     = 2048;
                $config['file_name'] = date('Y-m-d_His');
                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload('img')) {
                    echo "<script>alert('图片上传失败！');window.location.href='".site_url('/module/HomeReport/index')."'</script>";
                    exit;
                } else {
                    $data['pic'] =  '/Upload/news/'.$this->upload->data('file_name');
                }
            }
            $data['userid'] = $this->session->users['user_id'];
            if($this->System_model->edit_notice($data['id'],$data)){
                   //日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."编辑了一个系统公告。公告名称是".$data['name'].",公告id是：".$data['id'],
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);
                 echo "<script>alert('操作成功！');window.location.href='".site_url('/module/HomeReport/index')."'</script>";
                    exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/module/HomeReport/index')."'</script>";
                    exit; 
            }
        }else{
            $this->load->view('404.html');
        }
    }

    //删除系统公告
    function del_notice(){
        if($_POST){
            $id = $_POST['id'];
            if(empty($id)){
                echo "2";
            }else{
                $news= $this->System_model->get_notice_info($id);
                   @unlink($news['pic']);
                if($this->System_model->del_notice($id)){
                    //日志
                    $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  
                        "content" => $_SESSION['users']['username']."删除了一个系统公告。公告id是：".$data['id'],
                        "create_time" => date('Y-m-d H:i:s'),
                        "userip" => get_client_ip(),
                    );
                    $this->db->insert('hf_system_journal',$log);
                    echo "1";
                }else{
                    echo "2";
                }
            }
        }else{
            echo "2";
        }
    }
}
