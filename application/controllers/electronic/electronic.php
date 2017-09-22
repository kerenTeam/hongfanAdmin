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

    //招商信息
    public $view_attract = "electronic/attract.html";

    //县志
    public $view_annals = "electronic/annals.html";
    public $view_editAnnals = "electronic/edit_annals.html";


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
            switch ($_SESSION['city']) {
                case '0':
                    $data['city'] = $this->input->post('city');
                    break;
                case '1':
                     $data['city'] = '1';
                    break;
                case '2':
                     $data['city'] = '2';
                    break;
                case '3':
                     $data['city'] = '3';
                    break;
                case '4':
                     $data['city'] = '4';
                    break;
            }

           if($data['typeid'] == 2){

                  $arr = array($data['overflow'],$data['cut']);

                    $data['coupon_amount'] = implode(',',$arr);

                   unset($data['overflow'],$data['cut']);

            }else{

                    unset($data['overflow'],$data['cut']);

            }

   
            $header = array("token:".$_SESSION['token'],'city:'.$data['city']);    
            if(!empty($_FILES['img']['name'])){
                    $tmpfile = new CURLFile(realpath($_FILES['img']['tmp_name']));
                
                    $pics = array(
                        'pics' =>$tmpfile,
                        'porfix'=>'shop/coupon',
                        'bucket'=>"ebus",
                    );
                
                    $qiuniu = json_decode(curl_post_express($header,QINIUUPLOAD,$pics),true);

                    if($qiuniu['errno'] == '0'){
                        $img = json_decode($qiuniu['data']['img'],true);
                        $icon[]['picImg'] =$img[0]['picImg'];
                        $data['pic'] = json_encode($icon);
                    }else{
                      echo "<script>alert('图片上传失败！');window.location.href='".site_url('/electronic/Electronic/addElectronic')."'</script>";exit;
                    }
            }


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
            switch ($_SESSION['city']) {
                case '0':
                    $data['city'] = $this->input->post('city');
                    break;
                case '1':
                     $data['city'] = '1';
                    break;
                case '2':
                     $data['city'] = '2';
                    break;
                case '3':
                     $data['city'] = '3';
                    break;
                case '4':
                     $data['city'] = '4';
                    break;
            }

            if($data['typeid'] == 2){

                  $arr = array($data['overflow'],$data['cut']);

                    $data['coupon_amount'] = implode(',',$arr);

                   unset($data['overflow'],$data['cut']);

            }else{

                    unset($data['overflow'],$data['cut']);

            }
            $header = array("token:".$_SESSION['token'],'city:'.$data['city']);    
            if(!empty($_FILES['img']['name'])){
                    $tmpfile = new CURLFile(realpath($_FILES['img']['tmp_name']));
                
                    $pics = array(
                        'pics' =>$tmpfile,
                        'porfix'=>'shop/coupon',
                        'bucket'=>"ebus",
                    );
                
                    $qiuniu = json_decode(curl_post_express($header,QINIUUPLOAD,$pics),true);

                    if($qiuniu['errno'] == '0'){
                        $img = json_decode($qiuniu['data']['img'],true);
                        $icon[]['picImg'] =$img[0]['picImg'];
                        $data['pic'] = json_encode($icon);
                    }else{
                      echo "<script>alert('图片上传失败！');window.location.href='".site_url('/electronic/Electronic/addElectronic')."'</script>";exit;
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


    //招商信息
    function attract(){

       

        $config['per_page'] = 10;

        //获取页码

        $current_page=intval($this->uri->segment(4));//index.php 后数第4个/

        //var_dump($current_page);

            //配置

        $config['base_url'] = site_url('/module/LocalLife/Hi_Carpooling');

        //分页配置

        $config['full_tag_open'] = '<ul class="am-pagination tpl-pagination">';

        $config['full_tag_close'] = '</ul>';

        $config['first_tag_open'] = '<li>';

        $config['first_tag_close'] = '</li>';

        $config['prev_tag_open'] = '<li>';

        $config['prev_tag_close'] = '</li>';

        $config['next_tag_open'] = '<li>';

        $config['next_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="am-active"><a>';

        $config['cur_tag_close'] = '</a></li>';

        $config['last_tag_open'] = '<li>';

        $config['last_tag_close'] = '</li>';

        $config['num_tag_open'] = '<li>';

        $config['num_tag_close'] = '</li>';



        $config['first_link']= '首页';

        $config['next_link']= '下一页';

        $config['prev_link']= '上一页';

        $config['last_link']= '末页';



        

        switch ($_SESSION['city']) {
            case '0':
                $list = $this->Activity_model->select_attract('');
                $config['total_rows'] = count($list);
                // //分页数据
                $listpage = $this->Activity_model->select_attract_page($config['per_page'],$current_page);  
                break;
            case '1':
                 $list = $this->Activity_model->select_attract('1');
                $config['total_rows'] = count($list);
                // //分页数据
                $listpage = $this->Activity_model->select_attract_where_page('1',$config['per_page'],$current_page);  
                break;
            case '2':
                 $list = $this->Activity_model->select_attract('2');
                $config['total_rows'] = count($list);
                // //分页数据
                $listpage = $this->Activity_model->select_attract_where_page('2',$config['per_page'],$current_page);  
                break;
            case '3':
                 $list = $this->Activity_model->select_attract('3');
                $config['total_rows'] = count($list);
                // //分页数据
                $listpage = $this->Activity_model->select_attract_where_page('3',$config['per_page'],$current_page);  
                break;
            case '4':
                $list = $this->Activity_model->select_attract('4');
                $config['total_rows'] = count($list);
                // //分页数据
                $listpage = $this->Activity_model->select_attract_where_page('4',$config['per_page'],$current_page);  
                break;
            
        }

        
        $this->load->library('pagination');//加载ci pagination类

        $this->pagination->initialize($config);

        $data = array('lists'=>$listpage,'pages' => $this->pagination->create_links());

        $data['page'] = $this->view_attract;
        $data['menu'] = array('moll','attract');
        $this->load->view('template.html',$data);
    }

    //联系
    function edit_attract_state(){
        $id = intval($this->uri->segment('4'));
        if($id == '0'){
            $this->load->view('404.html');
        }else{
            $data['state'] = '1';
            if($this->Activity_model->updata_attract($id,$data)){
             echo "<script>alert('操作成功');window.history.go(-1);</script>";

            }else{
                echo "<script>alert('操作失败');window.history.go(-1);</script>";
            }
        }
    }


    //县志
    function annals(){
         switch ($_SESSION['city']) {
            case '0':
                $list = $this->Activity_model->select_annals('');
         
                break;
            case '1':
                 $list = $this->Activity_model->select_where_annals('1');
       
                break;
            case '2':
                 $list = $this->Activity_model->select_where_annals('2');
 
                break;
            case '3':
                 $list = $this->Activity_model->select_where_annals('3');
          
                break;
            case '4':
                $list = $this->Activity_model->select_where_annals('4');
          
                break;
            
        }
        $data['lists'] = $list;
        $data['page'] = $this->view_annals;
        $data['menu'] = array('moll','annals');
        $this->load->view('template.html',$data);
    }

    //编辑县志
    function edit_annals(){

        $id = intval($this->uri->segment('4'));
        if($id == '0'){
            $this->load->view('404.html');
        }else{
            $_SESSION['buket'] = "cqclocal";
            $_SESSION['host'] = "http://cqclocal.zlzmm.com/";
            $news = $this->Activity_model->select_annals_info($id);
            $data['annals'] = $news;
            $data['page'] = $this->view_editAnnals;
            $data['menu'] = array('moll','annals');
            $this->load->view('template.html',$data);
        }

    }
        
    function editAnnals(){
        if($_POST){
            $data = $this->input->post();

            $header = array("token:".$_SESSION['token'],'city:'.'1');    
            if(!empty($_FILES['img']['name'])){
                    $tmpfile = new CURLFile(realpath($_FILES['img']['tmp_name']));
                
                    $pics = array(
                        'pics' =>$tmpfile,
                        'porfix'=>'shop/annals',
                        'bucket'=>"cqclocal",
                    );
                
                    $qiuniu = json_decode(curl_post_express($header,QINIUUPLOAD,$pics),true);

                    if($qiuniu['errno'] == '0'){
                        $img = json_decode($qiuniu['data']['img'],true);
                        $icon[]['picImg'] =$img[0]['picImg'];
                        $data['pic'] = json_encode($icon);
                    }else{
                      echo "<script>alert('图片上传失败！');window.location.href='".site_url('/electronic/Electronic/edit_annals/'.$data['id'])."'</script>";exit;
                    }
            }

            if($this->Activity_model->edit_annals($data['id'],$data)){

                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."编辑了县志信息，县志id是：".$data['id'],
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                $this->db->insert('hf_system_journal',$log);
                echo "<script>alert('操作成功');window.location.href='".site_url('/electronic/Electronic/annals/')."'</script>";exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/electronic/Electronic/edit_annals/'.$data['id'])."'</script>";exit;
            }


        }else{
            $this->load->view('404.html');
        }
    }






}



