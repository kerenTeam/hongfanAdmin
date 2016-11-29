<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  本地生活
 *
 * */

class module extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('module_model');
    }

    //本地生活 列表主页
    function localLifeList()
    {
        //获取本地列表
        $data['cates'] = $this->module_model->get_cates('本地生活');
        $this->load->view('module/localLife/localLifeList.html',$data);
    }
    //新增分类操作
    function add_cates(){
        if($_POST){
            $data = $this->input->post();
            if(!empty($_FILES['img']['tmp_name'])){
                $config['upload_path']      = 'upload/icon';
                $config['allowed_types']    = 'gif|jpg|png|jpeg';
                $config['max_size']     = 2048;
                $config['file_name'] = date('Y-m-d_His');
                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload('img')) {
                    echo "<script>alert('图片上传失败！');window.location.href='".base_url('module/module/localLifeList')."'</script>";
                    exit;
                } else {
                    $data['icon'] =  'upload/icon/'.$this->upload->data('file_name');
                }
            }
            $data['c_id'] = '本地生活';
            if($this->module_model->add_cates($data)){
                echo "<script>alert('操作成功！');window.location.href='".base_url('module/module/localLifeList')."'</script>";
                exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".base_url('module/module/localLifeList')."'</script>";
                exit;
            }
        }else{
            $this->load->view('404.html');
        }
    }

    //修改分类
    function edit_cates(){
        if($_POST){
            $data = $this->input->post();
            if(!empty($_FILES['img']['tmp_name'])){
                $config['upload_path']      = 'upload/icon';
                $config['allowed_types']    = 'gif|jpg|png|jpeg';
                $config['max_size']     = 2048;
                $config['file_name'] = date('Y-m-d_His');
                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload('img')) {
                    echo "<script>alert('图片上传失败！');window.location.href='".base_url('module/module/localLifeList')."'</script>";
                    exit;
                } else {
                    $data['icon'] =  'upload/icon/'.$this->upload->data('file_name');
                }
            }
            if($this->module_model->edit_cates($data['id'],$data)){
                echo "<script>alert('操作成功！');window.location.href='".base_url('module/module/localLifeList')."'</script>";
                exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".base_url('module/module/localLifeList')."'</script>";
                exit;
            }
        }else{
            $this->load->view('404.html');
        }
    }



	//本地生活 本地服务 列表主页
    function serviceList()
    {
         $this->load->view('module/localLife/serviceList.html');
    }
    //本地生活 本地服务 列表详情
    function serviceInfo()
    {
         $this->load->view('module/localLife/serviceInfo.html');
    }



}
