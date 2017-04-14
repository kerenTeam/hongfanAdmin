<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  电子券管理
 *
 * */
require_once(APPPATH.'controllers/Default_Controller.php');
class Electronic extends Default_Controller {
    //电子劵列表
    public $view_electronicList = "electronic/electronicList.html"; 
    //电子劵新增
    public $view_addElectronic = "electronic/addElectronic.html";
    //电子卷编辑
    public $view_editElectronic = "electronic/editElectronic.html";
    function __construct()
    {
        parent::__construct();
        $this->load->model('Activity_model');
    }
    //electronic列表
    function electronicList(){
         $data['page']= $this->view_electronicList;
         $data['menu'] = array('marketActivity','electronicList');
         $this->load->view('template.html',$data);
    }

    //返回所有卡卷
    function get_electr_list(){
        if($_POST){
            $list = $this->Activity_model->get_coupons();
            if(empty($list)){
                echo "2";
            }else{
                echo json_encode($list);
            }
        }else{
            echo "2";
        }
    }

    //新增electronic
    function addElectronic(){
        //获取优惠劵类型
         $data['type'] = $this->Activity_model->get_coupon_type();
         $data['page']= $this->view_addElectronic;
         $data['menu'] = array('marketActivity','electronicList');
         $this->load->view('template.html',$data);
    }
    //新增优惠劵操作
    function add_electronic(){
        if($_POST){
            $data = $this->input->post();
            if(isset($data['overflowValue'])){
                if(empty($data['overflowValue'])){
                    unset($data['overflowValue'],$data['cutValue']);
                    $data['coupon_amount'] = $data['discount'];
                }else{
                    $arr = array($data['overflowValue'],$data['cutValue']);
                   // $data['salerule'] = json_encode($arr);
                    $data['coupon_amount'] = implode(',',$arr);
                    unset($data['overflowValue'],$data['cutValue']);
                }
            }
            //日志
            $log = array(
                'userid'=>$_SESSION['users']['user_id'],  
                "content" => $_SESSION['users']['username']."新增了一个优惠卷。优惠卷名称是".$data['name'],
                "create_time" => date('Y-m-d H:i:s'),
                "userip" => get_client_ip(),
            );
            $this->db->insert('hf_system_journal',$log);
            //
            if($this->Activity_model->add_electronic($data)){
                echo "<script>alert('操作成功！');window.location.href='".site_url('/electronic/Electronic/electronicList')."'</script>";exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/electronic/Electronic/addElectronic')."'</script>";exit;
            }
        }else{
            $this->load->view('404.html');
        }
    }

    //编辑electronic
    function editElectronic(){
        $id = intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
            $data['type'] = $this->Activity_model->get_coupon_type();
            //获取卡卷信息
            $data['coupon'] = $this->Activity_model->get_electr_info($id);

             $data['page']= $this->view_editElectronic;
             $data['menu'] = array('marketActivity','electronicList');
             $this->load->view('template.html',$data);
        }
    }

    //卡卷编辑操作
    function edit_Electronic(){
        if($_POST){
            $data = $this->input->post();
            if(isset($data['overflowValue'])){
                if(empty($data['overflowValue'])){
                    unset($data['overflowValue'],$data['cutValue']);
                    $data['coupon_amount'] = $data['discount'];
                }else{
                    $arr = array($data['overflowValue'],$data['cutValue']);
                   // $data['salerule'] = json_encode($arr);
                    $data['coupon_amount'] = implode(',',$arr);
                    unset($data['overflowValue'],$data['cutValue']);
                }
            }
            //日志
            $log = array(
                'userid'=>$_SESSION['users']['user_id'],  
                "content" => $_SESSION['users']['username']."编辑了一个优惠卷。优惠卷id是".$data['id'].',优惠卷名称是'.$data['name'],
                "create_time" => date('Y-m-d H:i:s'),
                "userip" => get_client_ip(),
            );
            $this->db->insert('hf_system_journal',$log);
            if($this->Activity_model->edit_electronic($data['id'],$data)){
                echo "<script>alert('操作成功！');window.location.href='".site_url('/electronic/Electronic/electronicList')."'</script>";
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/electronic/Electronic/editElectronic/'.$data['id'])."'</script>";
            }
        }else{
            $this->load->view('404.html');
        }
    }


    //删除优惠劵
    function del_coupon(){
        if($_POST){
            $id = $_POST['id'];
            if(empty($id)){ 
                echo "2";exit;
            }
            //日志
            $log = array(
                'userid'=>$_SESSION['users']['user_id'],  
                "content" => $_SESSION['users']['username']."删除了一个优惠卷。优惠卷id是".$id,
                "create_time" => date('Y-m-d H:i:s'),
                "userip" => get_client_ip(),
            );
            $this->db->insert('hf_system_journal',$log);
            if($this->Activity_model->del_coupon($id)){
                echo "1";
            }else{
                echo "2";
            }
        }else{ 
            echo "2";
        }
    }

    //搜索优惠劵
    function search_electronic(){
        if($_POST){
            var_dump($_POST);
            exit;
            $type = $_POST['type'];
            $start_time = $_POST['begin_date'];
            $end_date = $_POST['end_date'];
        }else{
            echo "2";
        }
    }


}

