<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  一键钟情
 *
 * */
require_once(APPPATH.'controllers/Default_Controller.php');
class Fallinlove extends Default_Controller {
    //一键钟情 活动列表
    public $view_loveactivityList = "module/fallinlove/loveactivityList.html";
    //本地服务 编辑活动详情
    public $view_loveEditactivity = "module/fallinlove/loveEditactivity.html";
    //本地服务 新增活动
    public $view_loveAddactivity = "module/fallinlove/loveAddactivity.html";
    //本地服务 报名情况列表
    public $view_loveApplyList = "module/fallinlove/loveApplyList.html";

    function __construct(){
        parent::__construct();
        $this->load->model('Activity_model');
    }
    //一键钟情 活动列表
    function loveactivityList()
    {
        $data['page'] = $this->view_loveactivityList;
        $data['menu'] = array('fallinlove','loveactivityList');
        $this->load->view('template.html',$data);
    }

    //获取一见钟情活动列表
    function get_loveactivity(){
        if($_POST){
            $list = $this->Activity_model->get_love_list();
            foreach ($list as $k => $value) {
                $list[$k]['people'] = count($this->Activity_model->get_activity_users($value['id']));
            }
            if(empty($list)){
                echo "2";
            }else{
                echo json_encode($list);
            }
        }else{
            echo "2";
        }
    }

    //一键钟情 编辑活动详情
    function loveEditactivity()
    {
        $id = intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
            $data['info'] = $this->Activity_model->get_loveactivity_info($id);
            $data['page'] = $this->view_loveEditactivity;
            $data['menu'] = array('fallinlove','loveEditactivity');
            $this->load->view('template.html',$data);
        }
    }
    //一键钟情 新增活动
    function loveAddactivity()
    {
        $data['page'] = $this->view_loveAddactivity;
        $data['menu'] = array('fallinlove','loveAddactivity');
        $this->load->view('template.html',$data);
    }

    //新增一键钟情活动
    function add_love_activity(){
        if($_POST){
            $data = $this->input->post();
            if($this->Activity_model->add_love_activity($data)){
                echo "<script>alert('操作成功！');window.location.href='".site_url('/module/Fallinlove/loveactivityList')."'</script>";
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/module/Fallinlove/loveAddactivity')."'</script>";
            }
        }else{
            $this->load->view('404.html');
        }
    }
    //一键钟情 报名情况列表
    function loveApplyList()
    {
        $id = intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
            $data['activity_id'] = $id;
            $data['page'] = $this->view_loveApplyList;
            $data['menu'] = array('fallinlove','loveApplyList');
            $this->load->view('template.html',$data);
        }
    }

    //获取报名用户
    function get_activity_user(){
        if($_POST){ 
            $id = $_POST['id'];
            if(empty($id)){
                echo "2";
            }else{
                $list = $this->Activity_model->get_activity_users($id);
                if(empty($list)){
                    echo "2";
                }else{
                    echo json_encode($list);
                }
            }
        }else{
            echo "2";
        }
    }


    //一见钟情删除
    function del_love_activity(){
        if($_POST){
            $id = $_POST['id'];
            if(empty($id)){
                echo "2";
            }else{
                if($this->Activity_model->del_love_activity($id)){
                    echo "1";
                }else{
                    echo "2";
                }
            }
        }else{
            $this->load->view('404.html');
        }
     
    }

    function edit_love_activity(){
        if($_POST){
            $data = $this->input->post();
            if($this->Activity_model->edit_love_activity($data['id'],$data)){
                  echo "<script>alert('操作成功！');window.location.href='".site_url('/module/Fallinlove/loveactivityList')."'</script>";
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/module/Fallinlove/loveEditactivity/'.$data['id'])."'</script>";
            }
        }else{
            $this->load->view('404.html');
        }
    }




}
