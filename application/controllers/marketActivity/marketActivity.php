<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 *  商场活动管理
 *
 * */

require_once(APPPATH.'controllers/Default_Controller.php');

class MarketActivity extends Default_Controller {

    //商场活动列表

    public $view_marketActivity = "marketActivity/marketActivityList.html"; 

    //商场活动新增

    public $view_marketAddActivity = "marketActivity/marketAddActivity.html";

    //商场活动编辑

    public $view_marketEditActivity = "marketActivity/marketEditActivity.html";

    function __construct()

    {

        parent::__construct();

        $this->load->model('Activity_model');

    }

    //商场活动列表

    function activity(){   	 



         $data['page']= $this->view_marketActivity;

         $data['menu'] = array('moll','activity');

         $this->load->view('template.html',$data);



    }

    //获取所有活动列表

    function get_activity_list(){

        if($_POST){

            $list = $this->Activity_model->get_activity_list();

            if(empty($list)){

                echo "2";

            }else{

                echo json_encode($list);

            }

        }else{

            echo "2";

        }

    }

    //新增商场活动

    function marketAddActivity(){
        $q= $this->uri->uri_string();
      
		$url = preg_replace('|[0-9]+|','',$q);
		if(substr($url,-1) == '/'){
			$url = substr($url,0,-1);
        }
        $user_power = json_decode($_SESSION['user_power'],TRUE);


		if(!deep_in_array($url,$user_power)){
			echo "<script>alert('您暂无权限执行此操作！请联系系统管理员。');window.history.go(-1);</script>";
					exit;
		}	



         //获取商场所有优惠劵

         $time = date('Y-m-d');

         $data['coupon'] = $this->Activity_model->get_coupon_list($time);

         $data['page']= $this->view_marketAddActivity;

         $data['menu'] = array('marketActivity','activity');

         $this->load->view('template.html',$data);

    }



    //新增活动操作

    function market_add_activity(){
        

        if($_POST){

            $data = $this->input->post();

            if(empty($data['type'])){

                echo "<script>alert('活动类型不能为空！');window.location.href='".site_url('/shop/SingleShop/shopAddActivity')."'</script>";

                exit;

            }
            
            $bucketList =  $this->config->item('buckrtGlobal');
            switch($_SESSION['city']){
                case '0':
                   // $data['city'] = $this->input->post('city');
                     $city = $this->input->post('city');
                     $bucket =$bucketList['cq']['other'];
                    break;
                case '1':
                    $data['city'] = '1';
                    $city = '1';
                    $bucket =$bucketList['cq']['other'];
                    break;
                case '2':
                    $city = '2';
                    $bucket =$bucketList['nj']['other'];
                    break;
                case '3':
                $city = '3';
                    $bucket =$bucketList['xh']['other'];
                    break;
                case '4':
                $city = '4';
                    $bucket =$bucketList['ls']['other'];
                    break;
                
            }

            $header = array("token:".$_SESSION['token'],'city:'.$city);   

            if(!empty($_FILES['img']['name'])){
                
                $tmpfile = new CURLFile(realpath($_FILES['img']['tmp_name']));
                //  var_dump($tmpfile);
                  $pics = array(
                      'pics' =>$tmpfile,
                      'porfix'=>'store/activity/'.$bucket,
                      'bucket'=>$bucket,
                  );
              
                  $qiuniu = json_decode(curl_post_express($header,QINIUUPLOAD,$pics),true);
                
                  if($qiuniu['errno'] == '0'){
                      $img = json_decode($qiuniu['data']['img'],true);
                      $data['picImg']  =$img[0]['picImg'];
                      
                  }else{
                    echo "<script>alert('图片上传失败！');window.location.href='".site_url('/marketActivity/MarketActivity/marketEditActivity/'.$data['id'])."'</script>";exit;
                  }

            }

            if($data['type'] == 1){

                $cou = array_filter($data['couponid']);

                if(!empty($cou)){

                    $data['couponid'] = implode(',',$cou);

                }else{

                    $data['couponid'] = '';

                 }

             }else{

                $data['couponid'] = '';

             }





            //日志

            $log = array(

                'userid'=>$_SESSION['users']['user_id'],  

                "content" => $_SESSION['users']['username']."新增了一个活动，活动名称是".$data['title'],

                "create_time" => date('Y-m-d H:i:s'),

                "userip" => get_client_ip(),

            );

            $this->db->insert('hf_system_journal',$log);





            if($this->Activity_model->add_activity($data)){

                echo "<script>alert('操作成功！');window.location.href='".site_url('/marketActivity/MarketActivity/activity')."'</script>";exit;

            }else{

                echo "<script>alert('操作失败！');window.location.href='".site_url('/marketActivity/MarketActivity/marketAddActivity')."'</script>";exit;

            }



        }else{

            $this->load->view('404.html');

        }

    }





    //编辑商场活动

    function marketEditActivity(){
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

        $id = intval($this->uri->segment(4));

        if($id == 0){

            $this->load->view('404.html');

        }else{



            //获取活动详情

            $info = $this->Activity_model->get_activity_info($id);

          

            $time = date('Y-m-d');

            $coupon = $this->Activity_model->get_coupon_list($time);

               if(!empty($info['couponid'])){

                $couponid = explode(',',$info['couponid']);

                foreach ($coupon as $key => $value) {

                   if(in_array($value['id'],$couponid)){

                        $coupon[$key]['check'] = '1'; 

                   }else{

                        $coupon[$key]['check'] = '0';  

                   }

                }

            }

            $data['coupon'] = $coupon;

            $data['info'] = $info;



          



             $data['page']= $this->view_marketEditActivity;

             $data['menu'] = array('marketActivity','activity');

             $this->load->view('template.html',$data);

        }

    }



    //编辑操作、

    function edit_market_activity(){

        if($_POST){

            $data = $this->input->post();

             if(empty($data['type'])){

                echo "<script>alert('活动类型不能为空！');window.location.href='".site_url('/shop/SingleShop/shopAddActivity')."'</script>";

                exit;

            }


            $bucketList =  $this->config->item('buckrtGlobal');
            switch($_SESSION['city']){
                case '0':
                   // $data['city'] = $this->input->post('city');
                     $city = $this->input->post('city');
                     $bucket =$bucketList['cq']['other'];
                    break;
                case '1':
                    $data['city'] = '1';
                    $city = '1';
                    $bucket =$bucketList['cq']['other'];
                    break;
                case '2':
                    $city = '2';
                    $bucket =$bucketList['nj']['other'];
                    break;
                case '3':
                $city = '3';
                    $bucket =$bucketList['xh']['other'];
                    break;
                case '4':
                $city = '4';
                    $bucket =$bucketList['ls']['other'];
                    break;
                
            }

            $header = array("token:".$_SESSION['token'],'city:'.$city);   

            if(!empty($_FILES['img']['name'])){
                
                $tmpfile = new CURLFile(realpath($_FILES['img']['tmp_name']));
                //  var_dump($tmpfile);
                  $pics = array(
                      'pics' =>$tmpfile,
                      'porfix'=>'store/activity/'.$bucket,
                      'bucket'=>$bucket,
                  );
              
                  $qiuniu = json_decode(curl_post_express($header,QINIUUPLOAD,$pics),true);
                
                  if($qiuniu['errno'] == '0'){
                      $img = json_decode($qiuniu['data']['img'],true);
                      $data['picImg']  =$img[0]['picImg'];
                      
                  }else{
                    echo "<script>alert('图片上传失败！');window.location.href='".site_url('/marketActivity/MarketActivity/marketEditActivity/'.$data['id'])."'</script>";exit;
                }

            }

           

          

            if($data['type'] == 1){

                $cou = array_unique(array_filter($data['couponid']));

                if(!empty($cou)){

                    $data['couponid'] = implode(',',$cou);

                }else{

                    $data['couponid'] = '';

                }

            }else{

                $data['couponid'] = '';

            }



            //日志

            $log = array(

                'userid'=>$_SESSION['users']['user_id'],  

                "content" => $_SESSION['users']['username']."编辑了一个活动，活动id是".$data['id'].",活动名称是".$data['title'],

                "create_time" => date('Y-m-d H:i:s'),

                "userip" => get_client_ip(),

            );

            $this->db->insert('hf_system_journal',$log);



            if($this->Activity_model->edit_activity_info($data['id'],$data)){

                echo "<script>alert('操作成功！');window.location.href='".site_url('/marketActivity/MarketActivity/activity')."'</script>";exit;

            }else{

                echo "<script>alert('操作失败！');window.location.herf='".site_url('/marketActivity/MarketActivity/marketEditActivity/'.$data['id'])."'</script>";exit;

            }



        }else{

            $this->load->view('404.html');

        }

    }





    //

    function del_Activity(){
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

            $info = $this->Activity_model->get_activity_info($id);



            //日志

            $log = array(

                'userid'=>$_SESSION['users']['user_id'],  

                "content" => $_SESSION['users']['username']."删除了一个活动，活动id是".$id.",活动名称是".$info['title'],

                "create_time" => date('Y-m-d H:i:s'),

                "userip" => get_client_ip(),

            );

            $this->db->insert('hf_system_journal',$log);



            if($this->Activity_model->del_Activity($id)){

                @unlink($info['picImg']);

                echo "1";

            }else{

                echo "2";

            }

        }else{

            echo "2";

        }

    }

}



