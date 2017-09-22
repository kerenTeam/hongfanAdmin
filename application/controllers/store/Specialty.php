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

    //天天特价商品

    public $view_discountGoods = "store/specialty/discountGoods.html";

    //推荐商品

    public $view_recommendGoods = "store/specialty/recommendGoods.html";


    function __construct()

    {

        parent::__construct();

        $this->load->model('MallShop_model');

        $this->load->model('Shop_model');

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

           $catelist = $this->MallShop_model->get_mall_cates();

           echo json_encode($catelist);

        }else{

            echo "2";

        }

    }



   //添加特色馆分类

    function storeAddSort(){
        $q= $this->uri->uri_string();
		$url = preg_replace('|[0-9]+|','',$q);
		if(substr($url,-1) == '/'){
			$url = substr($url,0,-1);
		}
			// var_dump($url);
		$user_power = json_decode($_SESSION['user_power'],TRUE);

		if(!deep_in_array($url,$user_power)){
			echo "<script>alert('您暂无权限执行此操作！请联系系统管理员。');window.history.go(-1);</script>";
					exit;
		}	

        //获取特色馆顶级分类

         $data['cates'] = $this->MallShop_model->get_cate_level('2');



         $data['page'] = $this->view_specialtyAddCates;

         $data['menu'] = array('store','specialtyCate');

         $this->load->view('template.html',$data);

    }

    //添加特色馆分类操作

    function add_store_cate(){
         $q= $this->uri->uri_string();
        $url = preg_replace('|[0-9]+|','',$q);
        if(substr($url,-1) == '/'){
            $url = substr($url,0,-1);
        }
            // var_dump($url);
        $user_power = json_decode($_SESSION['user_power'],TRUE);

        if(!deep_in_array($url,$user_power)){
            echo "<script>alert('您暂无权限执行此操作！请联系系统管理员。');window.history.go(-1);</script>";
                    exit;
        }   
        if($_POST){

            $data = $this->input->post();

            $data['type'] = '2';

            if(!empty($_FILES['icon']['tmp_name'])){

                $config['upload_path']      = 'Upload/icon';

                $config['allowed_types']    = 'jpg|png|jpeg|svg';

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

             $data['cates'] = $this->MallShop_model->get_goods_cates('0','2');

             $data['cateinfo'] = $this->MallShop_model->get_cateInfo($id);

             $data['page'] = $this->view_specialtyEditCates;

             $data['menu'] = array('store','specialtyCate');

            $this->load->view('template.html',$data);

         }

    }

    //编辑特色馆分类操作

    function edit_store_cate(){
           $q= $this->uri->uri_string();
        $url = preg_replace('|[0-9]+|','',$q);
        if(substr($url,-1) == '/'){
            $url = substr($url,0,-1);
        }
            // var_dump($url);
        $user_power = json_decode($_SESSION['user_power'],TRUE);

        if(!deep_in_array($url,$user_power)){
            echo "<script>alert('您暂无权限执行此操作！请联系系统管理员。');window.history.go(-1);</script>";
                    exit;
        }   

        if($_POST){

            $data = $this->input->post();

            if(!empty($_FILES['icon']['tmp_name'])){

                $config['upload_path']      = 'Upload/icon';

                $config['allowed_types']    = 'jpg|png|jpeg|svg';

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
        $q= $this->uri->uri_string();
		$url = preg_replace('|[0-9]+|','',$q);
		if(substr($url,-1) == '/'){
			$url = substr($url,0,-1);
		}
			// var_dump($url);
		$user_power = json_decode($_SESSION['user_power'],TRUE);

		if(!deep_in_array($url,$user_power)){
			echo "<script>alert('您暂无权限执行此操作！请联系系统管理员。');window.history.go(-1);</script>";
					exit;
		}	

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



    //天天特价

    function discountGoods(){

        $data['page'] = $this->view_discountGoods;

        $data['menu'] = array('store','discountGoods');

        $this->load->view('template.html',$data);

    }

    //推荐商品

    function recommendGoods(){
        $data['type'] = '6';
        $data['page'] = $this->view_recommendGoods;

        $data['menu'] = array('store','recommendGoods');

        $this->load->view('template.html',$data);

    }

    //HI抢购
    function hi_buying(){
        $data['type'] = '1';
        $data['page'] = $this->view_recommendGoods;

        $data['menu'] = array('store','hi_buying');

        $this->load->view('template.html',$data);
    }
    //hi货帮
    function hi_goods(){
        $data['type'] = '2';
        $data['page'] = $this->view_recommendGoods;

        $data['menu'] = array('store','hi_goods');

        $this->load->view('template.html',$data);
    }
    //HI土货
    function hi_Tuhuo(){
        $data['type'] = '3';
        $data['page'] = $this->view_recommendGoods;

        $data['menu'] = array('store','hi_Tuhuo');

        $this->load->view('template.html',$data);
    }

    //HI洋货
    function hi_overseas(){
        $data['type'] = '4';
        $data['page'] = $this->view_recommendGoods;

        $data['menu'] = array('store','hi_overseas');

        $this->load->view('template.html',$data);
    }
    //HI特色
    function hi_characteristic(){
        $data['type'] = '5';
        $data['page'] = $this->view_recommendGoods;

        $data['menu'] = array('store','hi_characteristic');

        $this->load->view('template.html',$data);
    }


    //修改商品排序

    function edit_goods_stor(){
     

        if($_POST){

            $data = $this->input->post();

            //$data['sort'] = $this->input->post('sort');

            if($this->MallShop_model->edit_goods_state($data['goods_id'],$data)){

                $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."修改了商品排序，商品id是".$data['goods_id'],

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

    //返回推荐商品
    function recommentGoods(){
         if($_POST){

            //获取所有商品

            $id = $this->input->post('default');
            $goods_list = $this->MallShop_model->ret_recommentType($id);

            //获取商品库存

            foreach($goods_list as $k=>$v){

                //获取商品属性

                $parent=  $this->MallShop_model->get_goods_parent($v['goods_id']);

                if(!empty($parent)){

                    $a = '0';

                    foreach($parent as $key=>$val){

                        $a += $val['stock'];

                    }

                    $goods_list[$k]['amount'] = $a;

                }else{

                    $goods_list[$k]['amount'] = '0';

                }

            } 

            if(empty($goods_list)){

                echo "2";

            }else{

                echo json_encode($goods_list,JSON_UNESCAPED_UNICODE);

            }

        }else{

            echo "2";

        }
    }


    //取消商品推荐
    function edit_recomment(){
        if($_POST){
            $id = $this->input->post('goodsid');
            $data['recommentType'] = '0';

            if($this->MallShop_model->edit_goods($id,$data)){
                $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."取消了一个商品推荐，商品id是：".$id,

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











}





?>