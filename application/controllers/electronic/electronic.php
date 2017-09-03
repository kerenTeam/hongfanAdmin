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

    //电子券核销列表

    public $view_afterSales = "electronic/afterSales.html";

    function __construct()

    {

        parent::__construct();

        $this->load->model('Activity_model');

        $this->load->model('Shop_model');

    }

    //electronic列表

    function electronicList(){

         $data['page']= $this->view_electronicList;

         $data['menu'] = array('moll','electronicList');

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

         //获取找点商家

         $data['store']  =  $this->Shop_model->shop_list('1');



         $data['page']= $this->view_addElectronic;

         $data['menu'] = array('moll','electronicList');

         $this->load->view('template.html',$data);

    }

    //新增优惠劵操作

    function add_electronic(){
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

           if($data['typeid'] == 2){

                  $arr = array($data['overflow'],$data['cut']);

                    $data['coupon_amount'] = implode(',',$arr);

                   unset($data['overflow'],$data['cut']);

            }else{

                    unset($data['overflow'],$data['cut']);

            }

   

            //

            if($this->Activity_model->add_electronic($data)){

                 //日志

                $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."新增了一个优惠卷。优惠卷名称是".$data['name'],

                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );

                $this->db->insert('hf_system_journal',$log);

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



                //获取找点商家

             $data['store']  =  $this->Shop_model->shop_list('1');



             $data['page']= $this->view_editElectronic;

             $data['menu'] = array('moll','electronicList');

             $this->load->view('template.html',$data);

        }

    }



    //卡卷编辑操作

    function edit_Electronic(){
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

            if($data['typeid'] == 2){

                  $arr = array($data['overflow'],$data['cut']);

                    $data['coupon_amount'] = implode(',',$arr);

                   unset($data['overflow'],$data['cut']);

            }else{

                    unset($data['overflow'],$data['cut']);

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

    //核销列表

    function afterSales(){
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

        //查看核销情况列表

        $id = intval($this->uri->segment('4'));

        if($id == 0){

            $this->load->view('404.html');

        }else{

         $data['id'] = $id;



         //返回核销数

         $data['he'] = $this->Activity_model->get_WriteNum($id);

         //返回领取数

          $data['lin'] = $this->Activity_model->get_ReceiveNum($id);



         $data['page']= $this->view_afterSales;

         $data['menu'] = array('moll','electronicList');

         $this->load->view('template.html',$data);

        }

    }



    //返回核销信息

    function ret_after_list(){

        if($_POST){

            $id = $this->input->post('id');

            $list = $this->Activity_model->ret_after_list($id);

            foreach($list as $key=>$val){

                $list[$key]['store_name'] = $this->Activity_model->get_store_name($val['store_id']);

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



    //根据日期返回核销记录

    function search_after(){

        if($_POST){

            $start_time = $this->input->post('time');

            $end_time = $this->input->post('endtime');

            $id = $this->input->post('id');

            $list = $this->Activity_model->get_search_after($id,$start_time,$end_time);

            if(!empty($list)){

                foreach($list as $key=>$val){

                   $list[$key]['store_name'] = $this->Activity_model->get_store_name($val['store_id']);

                }

                echo json_encode($list);



            }else{

                echo "3";

            }





        }else{

            echo "2";

        }

    }







}



