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
        $data['page'] = $this->view_homeReportEdit;
        $data['menu'] = array('localLife','homeReport');
        $this->load->view('template.html',$data);
    }
     //本地生活 家乡报道 新增新闻
    function homeReportAdd()
    {
        $data['page'] = $this->view_homeReportAdd;
        $data['menu'] = array('systemSet','homeReportAdd');
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
            if($this->System_model->add_notice($data)){
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
            if($this->System_model->edit_notice($data['id'],$data)){
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
                if($this->System_model->del_notice($id)){
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
