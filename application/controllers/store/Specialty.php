<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  特色馆商品
 *
 * */
require_once(APPPATH.'controllers/Default_Controller.php');
class Specialty extends Default_Controller {
    
    //特色馆分类
    public $view_specialtyCates = "store/specialty/specialtyCates.html";
    //新增特色馆分类
    public $view_specialtyAddCates =  "store/specialty/specialtyAddCates.html";
    //编辑特色馆分类
    public $view_specialtyEditCates = "store/specialty/specialtyEditCates.html";

    function __construct()
    {
        parent::__construct();
        $this->load->model('MallShop_model');
    }

    //特色馆分类
    function specialtyCate(){
        $data['page'] = $this->view_specialtyCates;
        $data['menu'] = array('store','specialtyCate');
        $this->load->view('template.html',$data);
    }

    //返回特色馆分类
    function ret_specialty_cate(){
        if($_POST){
           $catelist = $this->MallShop_model->get_goods_cates_list('2');
           echo json_encode($catelist);
        }else{
            echo "2";
        }
    }

   //添加特色馆分类
    function storeAddSort(){
        //获取特色馆顶级分类
         $data['cates'] = $this->MallShop_model->get_cate_level('2');

         $data['page'] = $this->view_specialtyAddCates;
         $data['menu'] = array('store','specialtyCate');
         $this->load->view('template.html',$data);
    }
    //添加特色馆分类操作
    function add_store_cate(){
        if($_POST){
            $data = $this->input->post();
            $data['type'] = '2';
            if(!empty($_FILES['icon']['tmp_name'])){
                $config['upload_path']      = 'Upload/icon';
                $config['allowed_types']    = 'jpg|png|jpeg';
                $config['max_size']     = 2048;
                $config['file_name'] = date('Y-m-d_His');
                $this->load->library('upload', $config);
                //上传
                if ( ! $this->upload->do_upload('icon')) {
                    echo "<script>alert('图片上传失败！');window.location.href='".site_url('/store/Specialty/storeAddSort/')."'</script>";
                    exit;
                } else{
                    $data['icon'] =  '/Upload/icon/'.$this->upload->data('file_name');
                }
            }
            if($this->MallShop_model->add_store_cate($data)){
                 $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."添加了一个特色馆分类，分类名称是：".$data['catname'],
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);
                echo  "<script>alert('操作成功！');window.location.href='".site_url('/store/Specialty/specialtyCate')."'</script>";
            }else{
                echo  "<script>alert('操作失败！');window.location.href='".site_url('/store/Specialty/storeAddSort')."'</script>";
            }
        }else{
            $this->load->view('404.html');
        }
    }
    //编辑特色馆分类
    function storeEditSort(){
         $id = intval($this->uri->segment(4));
         if($id == 0){
            $this->load->view('404.html');
         }else{
             //获取特色馆顶级分类
             $data['cates'] = $this->MallShop_model->get_cate_level('2');
             $data['cateinfo'] = $this->MallShop_model->get_cateInfo($id);
             $data['page'] = $this->view_specialtyEditCates;
             $data['menu'] = array('store','specialtyCate');
            $this->load->view('template.html',$data);
         }
    }
    //编辑特色馆分类操作
    function edit_store_cate(){
        if($_POST){
            $data = $this->input->post();
            if(!empty($_FILES['icon']['tmp_name'])){
                $config['upload_path']      = 'Upload/icon';
                $config['allowed_types']    = 'jpg|png|jpeg';
                $config['max_size']     = 2048;
                $config['file_name'] = date('Y-m-d_His');
                $this->load->library('upload', $config);
                //上传
                if ( ! $this->upload->do_upload('icon')) {
                    echo "<script>alert('图片上传失败！');window.location.href='".site_url('/store/Specialty/storeEditSort/'.$data['catid'])."'</script>";
                    exit;
                } else{
                    $data['icon'] =  '/Upload/icon/'.$this->upload->data('file_name');
                }
            }
            if($this->MallShop_model->edit_store_cate($data['catid'],$data)){
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."编辑了一个特色馆分类，分类名称是：".$data['catname'].",分类id是：".$data['catid'],
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);
                 echo "<script>alert('操作成功！');window.location.href='".site_url('/store/Specialty/specialtyCate')."'</script>";
             }else{
                 echo "<script>alert('操作失败！');window.location.href='".site_url('/store/Specialty/storeEditSort/'.$data['catid'])."'</script>";
             }
        }else{
            $this->load->view('404.html');
        }
    }

    //删除特色馆分类
    function del_store_cate(){
        if($_POST){
            $id = $_POST['id'];
            if($this->MallShop_model->del_store_cate($id)){
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."删除了一个特色馆分类，分类id是：".$id,
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
    //特色馆分类搜索
    function search_cate(){
        if($_POST){
            $sear = $_POST['sear'];
            $cates = $this->MallShop_model->search_cates($sear,'2');
            echo json_encode($cates);
        }else{
            echo "2";
        }
    }
}


?>