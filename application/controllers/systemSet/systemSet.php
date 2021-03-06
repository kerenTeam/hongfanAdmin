<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*

 *  系统设置

 *

 * */

require_once(APPPATH.'controllers/Default_Controller.php');



class SystemSet extends Default_Controller {

    //权限首页

    public $view_memberLimit = 'member/memberLimit.html';

    //编辑权限

    public $view_memberLimitEdit = 'member/memberLimitEdit.html';

    //后台管理员账号管理

    public $view_admin_user = 'systemSet/accountManage.html';

    //角色管理 

    public $view_roleManage = 'systemSet/roleManage.html';



    //支付账号管理

    public $view_paymanage = 'systemSet/apliyManage.html';

    //其他管理

    public $view_other = "systemSet/other.html";

    //网站信息

    public $view_web_config = 'systemSet/webMessage.html';

    //app banner

    public $view_bannerList = "banner/bannerList.html";    

    // banner 新增

    public $view_addBanner = "banner/addBanner.html";  

    // banner 编辑

    public $view_editBanner = "banner/editBanner.html";

    //App版本管理

    public $view_appversion = 'systemSet/appVersion.html';



    //系统设置 广告管理

    public $view_adverManage = 'systemSet/adverManage.html';

    //系统设置 广告管理

    public $view_adverEdit = 'systemSet/adverEdit.html';

    //引导图广告

    public $view_guideImage = 'systemSet/guideImageManage.html';

    //HI集头条

    public $view_hiHeadline = 'systemSet/hiHeadline.html';

    //系统日志

    public $view_system_journal = "systemSet/journal.html";



    //留言反馈

    public $view_feedback = "systemSet/feedback.html";



    //运费模板

    public $view_express = "systemSet/expressTemplate.html";

    //邀请码
    public $view_invitation = "systemSet/invitation_code.html";

    function __construct()

    {

        parent::__construct();

        $this->load->model('System_model');
     


    }

    //icon guanli 
    function iconList(){

        $data['icon'] = $this->System_model->selectIcon();

        $data['page'] = 'systemSet/iconList.html';

        $data['menu'] = array('systemSet', 'iconList');

        $this->load->view('template.html', $data);
    }
    function edit_icon(){
        if($_POST){
            $id = $this->input->post('id');
            $data['iconName'] = $this->input->post('iconName');
            $bucketList = $this->config->item('buckrtGlobal');
            $bucket = $bucketList['cq']['other'];
            $header = array("token:" . $_SESSION['token'], 'city:1');     
            $data['create_time'] = date('Y-m-d H:i:s',time());
            if (!empty($_FILES['img']['name'])) {
                $tmpfile = new CURLFile(realpath($_FILES['img']['tmp_name']));
                  //  var_dump($tmpfile);
                $pics = array(
                    'pics' => $tmpfile,
                    'porfix' => 'adver/' . $bucket,
                    'bucket' => $bucket,
                );

                $qiuniu = json_decode(curl_post_express($header, QINIUUPLOAD, $pics), true);

                if ($qiuniu['errno'] == '0') {
                    $img = json_decode($qiuniu['data']['img'], true);
                    $data['icon'] = $img[0]['picImg'];
                } else {
                    echo "<script>alert('图片上传失败！');window.location.href='" . site_url('/systemSet/SystemSet/iconList/') . "'</script>";
                    exit;
                }
            }
            
            if($this->System_model->editIcon($id,$data)){
                echo "<script>alert('操作成功！');window.location.href='" . site_url('/systemSet/SystemSet/iconList') . "'</script>";

            }else{
                echo "<script>alert('操作失败！');window.location.href='" . site_url('/systemSet/SystemSet/iconList') . "'</script>";

            }




        }else{
            $this->load->view('404.html');
        }
    }




    //系统设置 后台管理员账号管理

    function index()

    {

        //获取权限类型

         $data['group'] = $this->System_model->get_member_group();

         $data['page'] = $this->view_admin_user;

         $data['menu'] = array('systemSet','systemSet');

    	 $this->load->view('template.html',$data);

    }



    //系统设置 引导图广告管理

    function guideImageManage()

    {

        //返回启动图广告

        $adver = $this->System_model->get_start_advertising('12');

        $data['adver'] = json_decode($adver['banner'],true);

        //返回首页标题图

        // $homeTitle = $this->System_model->get_start_advertising('13');

        // $data['homeTitle'] = json_decode($homeTitle['banner'],true);

        

        $data['id'] = $adver['id'];


        $data['page'] = $this->view_guideImage;

        $data['menu'] = array('systemSet','guideImageManage');

        $this->load->view('template.html',$data);

    }

    //修改 引导图广告

    function edit_advertising(){

        if($_POST){

            $id = $this->input->post('id');

            //$pic =array();

            $i ='0';

            $a ='1';

            $bucketList =  $this->config->item('buckrtGlobal');
            switch($_SESSION['city']){
                case '0':
                case '1':
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
            
          

            foreach($_FILES as $val){
                if(!empty($_FILES['img'.$a]['name'])){
                    $tmpfile = new CURLFile(realpath($_FILES['img'.$a]['tmp_name']));
                  //  var_dump($tmpfile);
                    $pics = array(
                        'pics' =>$tmpfile,
                        'porfix'=>'adver/'.$bucket,
                        'bucket'=>$bucket,
                    );
                
                    $qiuniu = json_decode(curl_post_express($header,QINIUUPLOAD,$pics),true);
                  
                    if($qiuniu['errno'] == '0'){
                        $img = json_decode($qiuniu['data']['img'],true);

                        $pic[$i]['id'] =$a;
                        
                        $pic[$i]['sort'] = $this->input->post('sort'.$a);

                        $pic[$i]['pic'] =$img[0]['picImg'];
                        
                    }else{
                        echo "<script>alert('图片上传失败！');window.location.href='".site_url('/systemSet/SystemSet/guideImageManage/')."'</script>";exit;
                    }
    
                }else{

                    if(isset($_POST['img'.$a])){

                        $pic[$i]['id'] =$a;

                        $pic[$i]['sort'] = $this->input->post('sort'.$a);

                        $pic[$i]['pic']  = $_POST['img'.$a];

                    }

                }

                $i++;

                $a++;

            }

            foreach($pic as $k=>$v){

                $num1[$k] = $v['sort'];

            }

            array_multisort($num1, SORT_ASC, $pic);





            $data['banner'] = json_encode($pic);

            //var_dump(json_encode($pic));

            if($this->System_model->edit_banner($id,$data)){

                echo "<script>alert('操作成功！');window.location.href='".site_url('/systemSet/SystemSet/guideImageManage')."'</script>";

            }else{

                 echo "<script>alert('操作失败！');window.location.href='".site_url('/systemSet/SystemSet/guideImageManage')."'</script>";

            }

        }else{

            $this->load->view('404.html');

        }

    }



    //删除启动图

    function del_advertisiting(){

        $id = intval($this->uri->segment(4));

        $bid = intval($this->uri->segment(5));

        if($id == 0){

            $this->load->view('404.html');

        }else{

            $adver = $this->System_model->get_start_advertising('12');

            $pic = json_decode($adver['banner'],true);

 

            foreach($pic as $k=>$v){

                if($v['id'] == $id){

                    unset($pic[$k]);

                }

            }

           shuffle($pic);

           $data['banner'] = json_encode($pic);

    

           if($this->System_model->edit_banner($bid,$data)){

                echo "<script>alert('操作成功！');window.location.href='".site_url('/systemSet/SystemSet/guideImageManage')."'</script>";

           }else{

                echo "<script>alert('操作成功！');window.location.href='".site_url('/systemSet/SystemSet/guideImageManage')."'</script>";

           }

        }

    }


    //系统设置 角色管理

    function roleManage()

    {   

    
        //所有角色

        $data['group'] = $this->System_model->get_member_group();



        $data['page'] = $this->view_roleManage;

        $data['menu'] = array('systemSet','systemSet');

        $this->load->view('template.html',$data);

    }



    //获取管理用户列表

    function adminUserList(){

        if($_POST){

            $user = $this->System_model->get_admin_user();

            if(empty($user)){

                echo "2";

            }else{

                echo json_encode($user);

            }

        }else{

            echo "2";

        }

    }

    //新增管理用户操作

    function add_admin_user(){

        if($_POST){

            $data = $this->input->post();

            // $bucketList =  $this->config->item('buckrtGlobal');
            // switch($_SESSION['city']){
            //     case '0':
            //     case '1':
            //         $city = '1';
            //         $bucket =$bucketList['cq']['other'];
            //         break;
            //     case '2':
            //     $city = '2';
            //         $bucket =$bucketList['nj']['other'];
            //         break;
            //     case '3':
            //     $city = '3';
            //         $bucket =$bucketList['xh']['other'];
            //         break;
            //     case '4':
            //     $city = '4';
            //         $bucket =$bucketList['ls']['other'];
            //         break;
                
            // }

            // $header = array("token:".$_SESSION['token'],'city:'.$city);     
            
            // if(!empty($_FILES['picArray']['name'])){
            //     $tmpfile = new CURLFile(realpath($_FILES['picArray']['tmp_name']));
            
            //     $pics = array(
            //         'pics' =>$tmpfile,
            //         'porfix'=>'admin_user/avatar/'.$bucket,
            //         'bucket'=>$bucket,
            //     );
            
            //     $qiuniu = json_decode(curl_post_express($header,QINIUUPLOAD,$pics),true);
            //     // var_dump($a);
            //     if($qiuniu['errno'] == '0'){
            //         $img = json_decode($qiuniu['data']['img'],true);
            //         $pic[]['picImg'] =$img[0]['picImg'];
            //         $data['avatar'] = json_encode($pic);
            //     }else{
            //         echo "<script>alert('图片上传失败！');window.location.href='".site_url('/systemSet/SystemSet/')."'</script>";exit;
            //     }

            // }

            $data['password'] = md5($data['password']);

            if($this->System_model->add_admin_user($data)){

                $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."新增了一个管理员，管理员名称是：".$data['username'],

                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );

                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('systemSet/SystemSet')."'</script>";

             }else{

                echo "<script>alert('操作失败！');window.location.href='".site_url('systemSet/SystemSet')."'</script>";

             }

        }else{

            $this->load->view('404.html');

        }

    }

    //返回角色

    function admin_user_group(){

        if($_POST){

             $group= $this->System_model->get_member_group();

             if(!empty($group)){

                echo json_encode($group);

             }else{

                echo "2";

             }

        }else{

            echo "2";

        }

    }

    //编辑管理员操作

    function edit_admin_user(){

        if($_POST){

            $id = $_POST['user_id'];

            $username = trim($_POST['username']);

            $user = $this->System_model->get_user($id,$username);

            if(empty($user)){

                $data['username'] = $username;

            }else{

                echo "2";exit;

            }


            $bucketList =  $this->config->item('buckrtGlobal');
            switch($_SESSION['city']){
                case '0':
                case '1':
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
            
            if(!empty($_FILES['picArray']['name'])){
                $tmpfile = new CURLFile(realpath($_FILES['picArray']['tmp_name']));
            
                $pics = array(
                    'pics' =>$tmpfile,
                    'porfix'=>'admin_user/avatar/'.$bucket,
                    'bucket'=>$bucket,
                );
            
                $qiuniu = json_decode(curl_post_express($header,QINIUUPLOAD,$pics),true);
                // var_dump($a);
                if($qiuniu['errno'] == '0'){
                    $img = json_decode($qiuniu['data']['img'],true);
                    $pic[]['picImg'] =$img[0]['picImg'];
                    $data['avatar'] = json_encode($pic);
                }else{
                    echo "<script>alert('图片上传失败！');window.location.href='".site_url('/systemSet/SystemSet/')."'</script>";exit;
                }

            }


         
            $data['nickname'] = trim($_POST['nickname']);

            $password = trim($_POST['password']);

            if(!empty($password)){

              $data['password'] = md5($password);

            }



            $data['gid'] = $_POST['group_name'];

            if($this->System_model->edit_admin_user($id,$data)){

                $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."编辑了一个管理员，管理员名称是：".$data['username'].",管理员id是：".$id,

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



    //刪除管理員

    function del_admin_user(){

       if($_POST){

            $id = $_POST['userid'];

            if(empty($id)){

                echo "2";exit;

            }else{

                if($this->System_model->del_admin_user($id)){

                     $log = array(

                        'userid'=>$_SESSION['users']['user_id'],  

                        "content" => $_SESSION['users']['username']."删除了一个管理员，管理员id是：".$id,

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





    //系统设置 广告管理

    function adverManage(){

        //返回所有广告

         $data['adver'] = $this->System_model->get_app_adver();

         $data['page'] = $this->view_adverManage;

         $data['menu'] = array('moll','adverManage');

         $this->load->view('template.html',$data);

    }

    //系统设置 编辑广告

    function adverEdit(){

        $id = intval($this->uri->segment(4));

        if($id == 0){

            $this->load->view('404.html');

        }else{

            $data['adver'] = $this->System_model->get_adver_info($id);

            $data['id'] = $id;

             $data['page'] = $this->view_adverEdit;

             $data['menu'] = array('moll','adverManage');

             $this->load->view('template.html',$data);

        }

    }

    //编辑广告操做

    function edit_adver(){

        if($_POST){

            $data = $this->input->post();


            $bucketList =  $this->config->item('buckrtGlobal');
            switch($_SESSION['city']){
                case '0':
                case '1':
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
            
                $pics = array(
                    'pics' =>$tmpfile,
                    'porfix'=>'adver/'.$bucket,
                    'bucket'=>$bucket,
                );
            
                $qiuniu = json_decode(curl_post_express($header,QINIUUPLOAD,$pics),true);
               
                if($qiuniu['errno'] == '0'){
                    $img = json_decode($qiuniu['data']['img'],true);
                    $data['pic'] =$img[0]['picImg'];
                }else{
                    echo "<script>alert('图片上传失败！');window.location.href='".site_url('/systemSet/SystemSet/adverEdit/'.$data['id'])."'</script>";exit;
                }

            }

        

            if($this->System_model->edit_adver($data['id'],$data)){

                   $log = array(

                        'userid'=>$_SESSION['users']['user_id'],  

                        "content" => $_SESSION['users']['username']."编辑了一个广告内容，广告id是：".$data['id'],

                        "create_time" => date('Y-m-d H:i:s'),

                        "userip" => get_client_ip(),

                    );

                    $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/systemSet/SystemSet/adverManage')."'</script>";

            }else{

                 echo "<script>alert('操作失败！');window.location.href='".site_url('/systemSet/SystemSet/adverEdit/'.$data['id'])."'</script>";

            }

        }else{

            $this->load->view('404.html');

        }

    }
      //权限管理

    function memberLimit(){

        //返回所有权限  

        $query = $this->db->order_by('modular_id','asc')->get('hf_system_modular');

        $arr = $query->result_array();


        //返回整理好的数组

        $data['modular'] = subtree($arr);



        $data['page'] = $this->view_memberLimit;

        $data['menu'] = array('systemSet','memberLimit');

        $this->load->view('template.html',$data);

    }



    //添加权限

    function add_Authority(){

        if($_POST){

            $data = $this->input->post();

            if($this->db->insert('hf_system_modular',$data)){

                $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."新增了一个权限，权限组名称是：".$data['name'],

                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );

                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('添加成功！');window.location.href='".site_url('systemSet/SystemSet/memberLimit')."'</script>";exit;

            }else{

                echo "<script>alert('添加失败！');window.location.href='".site_url('systemSet/SystemSet/memberLimit')."'</script>";exit;

            }

        }else{

            $this->load->view('404.html');

        }

    }

    //编辑权限

    function edit_Authority(){

        if($_POST){

             $data = $this->input->post();

             $id = $this->input->post('id');

             unset($data['id']);

             if($this->db->where("modular_id",$id)->update('hf_system_modular',$data)){

                $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."修改了一个权限，权限id是：".$id."权限组名称是：".$data['name'],

                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );

                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功!');window.location.href='".site_url('/systemSet/SystemSet/memberLimit')."'</script>";exit;

             }else{

                echo "<script>alert('操作失败!');window.location.href='".site_url('/systemSet/SystemSet/memberLimit')."'</script>";exit;



             }

        }else{

            $this->load->view('404.html');

        }

    }



    //删除权限

    function del_Authority(){

        if($_POST){

            $id = $this->input->post('id');

            if($this->db->where('modular_id',$id)->delete('hf_system_modular')){

                $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."删除了一个权限，权限id是：".$id,

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





    //角色编辑

    function memberLimitEdit(){

        if($_POST){

            $data['group_name'] = trim($this->input->post('group_name'));

            $id = $this->input->post('gid');

            if($this->user_model->edit_group($id,$data)){

                    $log = array(

                        'userid'=>$_SESSION['users']['user_id'],  

                        "content" => $_SESSION['users']['username']."修改了一个角色，角色id是：".$id,

                        "create_time" => date('Y-m-d H:i:s'),

                        "userip" => get_client_ip(),

                    );

                    $this->db->insert('hf_system_journal',$log);



                echo "<script>alert('操作成功！');window.location.href='".site_url('systemSet/SystemSet/roleManage')."'</script>";exit;

            }else{

                echo "<script>alert('操作失败！');window.location.href='".site_url('systemSet/SystemSet/roleManage')."'</script>";exit;



            }

        }else{

            $this->load->view('404.html');

        }

    }



    //新增角色

    function add_member_group(){

        if($_POST){

             $data['group_name'] = $this->input->post('group_name');

            if($this->user_model->add_group($data)){

                $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."新增了一个角色，角色名称是：".$data['group_name'],

                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );

                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功!');window.location.href='".site_url('/systemSet/SystemSet/roleManage')."'</script>";exit;

            }else{

                echo "<script>alert('操作失败!');window.location.href='".site_url('/systemSet/SystemSet/roleManage')."'</script>";exit;

            }

        }else{

            $this->load->view('404.html');

        }

    }



    //删除角色

    function del_group(){

        if($_POST){

            $id = $this->input->post('gid');

            if($this->user_model->del_group($id)){

                   $log = array(

                        'userid'=>$_SESSION['users']['user_id'],  

                        "content" => $_SESSION['users']['username']."删除了一个角色，角色id是：".$id,

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



    //给角色分配权限

    function allot_group(){

        $type = $this->uri->segment('4');

        if($type == 'Authority'){

            $gid = $this->uri->segment('5');

            $data['gid'] = $gid;

            //获取角色权限

            $group = $this->user_model->get_group_info($gid);

            $group_permission = json_decode($group['group_permission'],true);



            $query = $this->db->order_by('modular_id','asc')->get('hf_system_modular');

            $arr = $query->result_array();

            //返回整理好的数组

            $data['modular'] = subtree($arr,$group_permission);



            $data['page'] = 'systemSet/allot_group.html';

            $data['menu'] = array('systemSet','systemSet');

            $this->load->view('template.html',$data);



        }else{

            $this->load->view('404.html');

        }

    }

    //角色分配权限操作

    function add_allot_group(){

        if($_POST){

            $data['group_permission'] = $this->input->post('goodsid');

            $id = $this->input->post('id');

         

            if($this->user_model->edit_group($id,$data)){

                    $log = array(

                        'userid'=>$_SESSION['users']['user_id'],  

                        "content" => $_SESSION['users']['username']."修改了一个角色的权限，角色id是：".$id,

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



     //banner列表

    function bannerList(){
        $data['banners'] = '';
        switch($_SESSION['city']){
            case '0':
            $data['banners'] = $this->System_model->get_bannerlist();
                break;
            case "1":
            $data['banners'] = $this->System_model->get_city_bannerlist('1');
                break;
            case "2":
            $data['banners'] = $this->System_model->get_city_bannerlist('2');
            
                break;
            case "3":
            $data['banners'] = $this->System_model->get_city_bannerlist('3');
            
                break;
            case "4":
            $data['banners'] = $this->System_model->get_city_bannerlist('4');
                break;
        }
        $data['page'] = $this->view_bannerList;

        $data['menu'] = array('systemSet','bannerList');

        $this->load->view('template.html',$data);

    }

    

    //新增banner

    function addBanner(){

        $id = intval($this->uri->segment(4));

        if($id == 0){

            $this->load->view('404.html');

        }else{

            $data['id'] = $id;

            $data['page'] = $this->view_addBanner;

            $data['menu'] = array('systemSet','banner');

            $this->load->view('template.html',$data);

        }

       

    }

    //新增banner操作

    function add_banner(){

        if($_POST){

            $id = $this->input->post('id');
            $data = $this->input->post(); 
            $bucketList =  $this->config->item('buckrtGlobal');
            switch($_SESSION['city']){
                case '0':
                case '1':
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
            
                $pics = array(
                    'pics' =>$tmpfile,
                    'porfix'=>'banner/'.$bucket,
                    'bucket'=>$bucket,
                );
            
                $qiuniu = json_decode(curl_post_express($header,QINIUUPLOAD,$pics),true);
                // var_dump($a);
                if($qiuniu['errno'] == '0'){
                    $img = json_decode($qiuniu['data']['img'],true);
                    $data['bannerPic'] =$img[0]['picImg'];
                }else{
                    echo "<script>alert('图片上传失败！');window.location.href='".site_url('/systemSet/SystemSet/addBanner/'.$id)."'</script>";exit;
                }

            }



            unset($data['id']);

             $a[] = $data;
        

            //获取原由的banner

            $banner = $this->System_model->get_banner($id);


            if(!empty($banner['banner'])){

                $bannerPic = json_decode($banner['banner'],true);

                $shu = array_merge($bannerPic,$a);
                array_multisort(array_column($shu,'sort'),SORT_ASC,$shu);


                 $json = json_encode($shu);

                 $arr = array('banner'=>$json);

            }else{

                $json = json_encode($a);

                $arr = array('banner'=>$json);

            }
            if($this->System_model->edit_banner($id,$arr)){

                   $log = array(

                        'userid'=>$_SESSION['users']['user_id'],  

                        "content" => $_SESSION['users']['username']."新增了一个banner，banner id是：".$id,

                        "create_time" => date('Y-m-d H:i:s'),

                        "userip" => get_client_ip(),

                    );

                    $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/systemSet/SystemSet/bannerList')."'</script>";exit;
            }else{

                 echo "<script>alert('操作失败!');window.location.href='".site_url('/systemSet/SystemSet/addBanner/'.$id)."'</script>";exit;

            }

        }

    }

    //编辑banner

    function editBanner(){

        $id = intval($this->uri->segment(4));

        $num = intval($this->uri->segment(5));

        if($id == 0 || $num == 0){

            $this->load->view('404.html');

        }else{

            //获取banner信息

            $banner = $this->System_model->get_banner($id);

            $bannerpic = json_decode($banner['banner'],true);

            $data['id'] = $id;

            $data['num'] = $num;

            $data['banner'] = $bannerpic[$num-1];

            $data['page'] = $this->view_editBanner;

            $data['menu'] = array('systemSet','banner');

            $this->load->view('template.html',$data);

         }

    }

    //编辑banner操作

    function edit_banner(){

        if($_POST){

            $id = $this->input->post('id');

            $num = $this->input->post('num');

            $data = $this->input->post();

            $bucketList =  $this->config->item('buckrtGlobal');
            switch($_SESSION['city']){
                case '0':
                case '1':
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
            
                $pics = array(
                    'pics' =>$tmpfile,
                    'porfix'=>'banner/'.$bucket,
                    'bucket'=>$bucket,
                );
            
                $qiuniu = json_decode(curl_post_express($header,QINIUUPLOAD,$pics),true);
                // var_dump($a);
                if($qiuniu['errno'] == '0'){
                    $img = json_decode($qiuniu['data']['img'],true);
                    $data['bannerPic'] =$img[0]['picImg'];
                }else{
                     echo "<script>alert('操作失败!');window.location.href='".site_url('/systemSet/SystemSet/editBanner/'.$id.'/'.$num)."'</script>";exit;
                }

            }

            unset($data['id']);

            unset($data['num']);

      

            //获取原由的banner

            $banner = $this->System_model->get_banner($id);

            if(!empty($banner['banner'])){

                $bannerPic = json_decode($banner['banner'],true);

                $bannerPic[$num-1] = $data;
                $a = array_multisort(array_column($bannerPic,'sort'),SORT_ASC,$bannerPic);
                $json = json_encode($bannerPic);
                $arr = array('banner'=>$json);
                if($this->System_model->edit_banner($id,$arr)){

                    $log = array(

                        'userid'=>$_SESSION['users']['user_id'],  

                        "content" => $_SESSION['users']['username']."编辑了一个banner，banner id是：".$id,

                        "create_time" => date('Y-m-d H:i:s'),

                        "userip" => get_client_ip(),

                    );

                    $this->db->insert('hf_system_journal',$log);

                    echo "<script>alert('操作成功！');window.location.href='".site_url('/systemSet/SystemSet/bannerList')."'</script>";exit;

                }else{

                     echo "<script>alert('操作失败!');window.location.href='".site_url('/systemSet/SystemSet/editBanner/'.$id.'/'.$num)."'</script>";exit;

                }

            }

        }

    }



    //删除banner

    function del_banner(){

        $id = intval($this->uri->segment(4));

        $num = intval($this->uri->segment(5));

        if($id == 0 || $num == 0){

            $this->load->view('404.html');

        }else{

            //获取banner信息

            $banner = $this->System_model->get_banner($id);

            $bannerpic = json_decode($banner['banner'],true);

            $list = $num-1;

            @unlink($bannerpic[$list]['bannerPic']);

            unset($bannerpic[$list]);

            if(!empty($bannerpic)){

                $json = json_encode(array_merge($bannerpic));

                $arr = array('banner'=>$json);

                if($this->System_model->edit_banner($id,$arr)){

                    $log = array(

                        'userid'=>$_SESSION['users']['user_id'],  

                        "content" => $_SESSION['users']['username']."删除了一个banner，banner id是：".$id,

                        "create_time" => date('Y-m-d H:i:s'),

                        "userip" => get_client_ip(),

                    );

                    $this->db->insert('hf_system_journal',$log);

                    echo "<script>alert('操作成功！');window.location.href='".site_url('/systemSet/SystemSet/bannerList')."'</script>";exit;

                }else{

                     echo "<script>alert('操作失败!');window.location.href='".site_url('/systemSet/SystemSet/bannerList')."'</script>";exit;

                }

            }else{

                $arr = array('banner'=>'');

                if($this->System_model->edit_banner($id,$arr)){

                    $log = array(

                        'userid'=>$_SESSION['users']['user_id'],  

                        "content" => $_SESSION['users']['username']."删除了banner id是".$id."的所有banner，banner id是：".$id,

                        "create_time" => date('Y-m-d H:i:s'),

                        "userip" => get_client_ip(),

                    );

                    $this->db->insert('hf_system_journal',$log);

                    echo "<script>alert('操作成功！');window.location.href='".site_url('/systemSet/SystemSet/bannerList')."'</script>";exit;

                }else{

                    echo "<script>alert('操作失败!');window.location.href='".site_url('/systemSet/SystemSet/bannerList')."'</script>";exit;

                }

            }

         }

    }



    //APP版本管理

    function app_version(){

        //获取已有的APP版本信息

        $data['app'] = $this->System_model->get_app_version();

        $data['page'] = $this->view_appversion;

        $data['menu'] = array('systemSet','version');

        $this->load->view('template.html',$data);

    }



    //修改版本

    function edit_app_version(){

        if($_POST){

            $id= $this->input->post('id');

            $data['versionNum']= $this->input->post('versionNum');

            $data['ios_versionNum']= $this->input->post('ios_versionNum');

            // $data['ios_path_url']= $this->input->post('ios_path_url');

            $data['create_time'] = date('Y-m-d H:i:s');
            $bucketList =  $this->config->item('buckrtGlobal');

            $city = '1';
            $bucket =$bucketList['cq']['other'];
                    

            $header = array("token:".$_SESSION['token'],'city:'.$city);     
            
            if(!empty($_FILES['file']['name'])){
                $tmpfile = new CURLFile(realpath($_FILES['file']['tmp_name']));
            
                $pics = array(
                    'pics' =>$tmpfile,
                    'porfix'=>'app/'.$bucket,
                    'bucket'=>$bucket,
                );
            
                $qiuniu = json_decode(curl_post_express($header,QINIUUPLOAD,$pics),true);
                // var_dump($a);
                if($qiuniu['errno'] == '0'){
                    $img = json_decode($qiuniu['data']['img'],true);
                    $data['android_path_url'] =$img[0]['picImg'];
                }else{
                     echo "<script>alert('安装包上传失败!');window.location.href='".site_url('systemSet/SystemSet/app_version')."'</script>";
                 }

            }
            if(!empty($_FILES['ios']['name'])){
                $tmpfile = new CURLFile(realpath($_FILES['ios']['tmp_name']));
            
                $pics = array(
                    'pics' =>$tmpfile,
                    'porfix'=>'app/'.$bucket,
                    'bucket'=>$bucket,
                );
            
                $qiuniu = json_decode(curl_post_express($header,QINIUUPLOAD,$pics),true);
                // var_dump($a);
                if($qiuniu['errno'] == '0'){
                    $img = json_decode($qiuniu['data']['img'],true);
                    $data['ios_path_url'] =$img[0]['picImg'];
                }else{
                    echo "<script>alert('安装包上传失败!');window.location.href='".site_url('systemSet/SystemSet/app_version')."'</script>";exit;
                 }

            }
           
            if($this->System_model->edit_app_version($id,$data)){

                echo "<script>alert('操作成功!');window.location.href='".site_url('systemSet/SystemSet/app_version')."'</script>";

            }else{

                echo "<script>alert('操作失败!');window.location.href='".site_url('systemSet/SystemSet/app_version')."'</script>";

            }



        }else{

            $this->load->view('404.html');

        }

      

    }





    //系统日志

    function journal_list(){

        $data['page'] = $this->view_system_journal;

        $data['menu'] = array('systemSet','journal');

        $this->load->view('template.html',$data);

    }



    //返回系统日志列表

    function get_system_journal(){

        if($_POST){

            $list = $this->System_model->get_journal();

            if($list){

                echo json_encode($list);

            }else{

                echo "2";

            }

        }else{

            echo "2";

        }

    }





    //运费模板

    function expressTemplate(){

        $data['store_id'] =  $_SESSION['businessId'];

        $data['page'] = $this->view_express;

        $data['menu'] = array('shop','expressTemplate');

        $this->load->view('template.html',$data);

    }

    //返回运费模板

    function ret_express_list(){

        if($_POST){

            $storeid =$this->input->post('storeid');

            $list = $this->System_model->get_express_temp($storeid);

            if(!empty($list)){

                echo json_encode($list);

            }else{

                echo "3";

            }

        }else{

            echo "2";

        }

    }



    //新增运费模板

    function add_express(){

        if($_POST){

            $data = $this->input->post();

            $data['businid'] = $_SESSION['businessId'];

            $data['create_time'] = date('Y-m-d H:i:s');

            if($this->System_model->add_express_temp($data)){

                $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."新增了一个快递模板 快递公司名称是".$data['expressName'],

                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );

                $this->db->insert('hf_system_journal',$log);

               echo "<script>alert('操作成功！');window.location.href='".site_url('/systemSet/SystemSet/expressTemplate')."'</script>";exit;

            }else{

                echo "<script>alert('操作失败！');window.location.href='".site_url('/systemSet/SystemSet/expressTemplate')."'</script>";exit;

            }

        }else{

            $this->load->view('404.html');

        }

    }



    //编辑运费模板

    function edit_express(){

        if($_POST){

            $data = $this->input->post();

            if($this->System_model->edit_express_temp($data['express_id'],$data)){

                $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."编辑了一个快递模板 快递公司名称是".$data['expressName'].",模板id是".$data['express_id'],

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

    //删除快递模板

    function del_express(){

        if($_POST){

            $id = $this->input->post('express_id');

            if($this->System_model->del_express_temp($id)){

                  $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."编辑了一个快递模板,模板id是".$id,

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



    

    //反馈留言

    function feedback(){



        $data['page'] = $this->view_feedback;

        $data['menu'] = array('member','feedback');

        $this->load->view('template.html',$data);

    }



    //返回反馈留言

    function ret_feedback(){

        if($_POST){

            $list = $this->System_model->ret_feedback();

            if(!empty($list)){

                echo json_encode($list);

            }else{

                echo "3";

            }

        }else{

            echo "3";

        }

    }




    //邀请码
    function invitation_code(){

        $list = count($this->System_model->select_invitation());

        $data = array('count'=>$list);
        if(!isset($_SESSION['invition'])){
            $_SESSION['invition'] = '0';
        }
        $data['page'] = $this->view_invitation;
        $data['menu'] = array('systemSet','invitation_code');
        $this->load->view('template.html',$data);
    }

    //返回邀请纪录
    function retInvition(){
        if($_POST){
            $UserPhone = trim($this->input->post('userPhone'));
            $phone = $this->input->post('phone');

            $page = $this->input->post('page');
            if($page != '0'){
                $_SESSION['invition'] = $page;
            }
            $size = $this->input->post('size');

            if(!empty($UserPhone) && empty($phone)){
                $query = $this->db->where('userPhone',$UserPhone)->get('hf_user_invite');
                $res = $query->result_array();
                $list = count($res);
                                // //分页数据
                $this->db->select('a.*, b.username,b.nickname');
                $this->db->from('hf_user_invite a');
                $this->db->join('hf_user_member b', 'b.user_id = a.userid','left');
                $query1 = $this->db->where('a.userPhone',$UserPhone)->order_by('createTime','desc')->limit($size,$page)->get();
                $listpage = $query1->result_array();
            }else if(empty($UserPhone) && !empty($phone)){
                $query = $this->db->where('invitationCode',$phone)->get('hf_user_invite');
                $res = $query->result_array();
                $list = count($res);
                                // //分页数据
                $this->db->select('a.*, b.username,b.nickname');
                $this->db->from('hf_user_invite a');
                $this->db->join('hf_user_member b', 'b.user_id = a.userid','left');
                $query1 = $this->db->where('a.invitationCode',$phone)->order_by('createTime','desc')->limit($size,$page)->get();
                $listpage = $query1->result_array();

            }else if(!empty($UserPhone) && !empty($phone)){
                $query = $this->db->where('invitationCode',$phone)->where('userPhone',$UserPhone)->get('hf_user_invite');
                $res = $query->result_array();
                $list = count($res);
                                // //分页数据
                $this->db->select('a.*, b.username,b.nickname');
                $this->db->from('hf_user_invite a');
                $this->db->join('hf_user_member b', 'b.user_id = a.userid','left');
                $query1 = $this->db->where('a.invitationCode',$phone)->where('userPhone',$UserPhone)->order_by('createTime','desc')->limit($size,$page)->get();
                $listpage = $query1->result_array();
            }else if(empty($UserPhone) && empty($phone)){

                $list = count($this->System_model->select_invitation());
                // //分页数据
                $listpage = $this->System_model->select_invitation_page($size,$page);
            }

            if(!empty($listpage)){
                echo json_encode(['total'=>$list,'subjects'=>$listpage]);
            }else{
                echo "2";
            }

        }
    }
    //导出邀请列表
    function DowIntivition(){
        if($_POST){
            $phone = $this->input->post('phone');
            $time = $this->input->post('begin_time');
            $endtime = $this->input->post('end_time');

            if(!empty($time)){
                $t = $time.' 00:00:00';
                $e = $endtime.' 23:59:59';
            }else{
                $t = '';
                $e = '';
            }

            if(!empty($t) && empty($phone)){
   
                $this->db->select('a.*,b.nickname');
                $this->db->from('hf_user_invite a');
                $this->db->join('hf_user_member b', 'b.user_id = a.userid','left');
                $query1 = $this->db->where('a.createTime >=',$t)->where('a.createTime <=',$e)->order_by('createTime','desc')->get();
                $listpage = $query1->result_array();
                                // //分页数据
               
            }else if(empty($t) && !empty($phone)){
                $this->db->select('a.*,b.nickname');
                $this->db->from('hf_user_invite a');
                $this->db->join('hf_user_member b', 'b.user_id = a.userid','left');
                $query1 = $this->db->where('a.invitationCode',$phone)->get();
                $listpage = $query1->result_array();

                                // //分页数据
              

            }else if(!empty($t) && !empty($phone)){
                 $this->db->select('a.*, b.nickname');
                $this->db->from('hf_user_invite a');
                $this->db->join('hf_user_member b', 'b.user_id = a.userid','left');
                $query1 = $this->db->where('a.createTime >=',$t)->where('a.createTime <=',$e)->where('a.invitationCode',$phone)->get();
                $listpage = $query1->result_array();

                                // //分页数据
             
            }else if(empty($t) && empty($phone)){
                $this->db->select('a.*,b.nickname');
                $this->db->from('hf_user_invite a');
                $this->db->join('hf_user_member b', 'b.user_id = a.userid','left');
                $query1 = $this->db->get('hf_user_invite');
                $listpage = $query1->result_array();
                // //分页数据
            }
          
            
            if(!empty($listpage)){
                $this->load->library('excel');

                //activate worksheet number 1

                $this->excel->setActiveSheetIndex(0);

                //name the worksheet

                $this->excel->getActiveSheet()->setTitle('Stores');

                $arr_title = array(

                    'A' => '编号',

                    'B' => '被邀请用户手机号',

                    'C' => '被邀请者用户名称',
                    'D' => '邀请者电话号',

                    'E' => '来源',

                    'F' => '邀请时间'
                );

                 //设置excel 表头

                foreach ($arr_title as $key => $value) {

                    $this->excel->getActiveSheet()->setCellValue($key . '1', $value);

                    $this->excel->getActiveSheet()->getStyle($key . '1')->getFont()->setSize(13);

                    $this->excel->getActiveSheet()->getStyle($key . '1')->getFont()->setBold(true);

                   $this->excel->getActiveSheet()->getDefaultColumnDimension('A')->setWidth(20);

                    $this->excel->getActiveSheet()->getStyle($key . '1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                }

                $i = 1;

                //查询数据库得到要导出的内容

               // $bookings = $this->Shop_model->shop_list($id);


                foreach ($listpage as $booking) {
                    $i++;
                   
                    $this->excel->getActiveSheet()->setCellValue('A' . $i, $booking['id']);
                    $this->excel->getActiveSheet()->setCellValue('B' . $i, $booking['userPhone']);
                    $this->excel->getActiveSheet()->setCellValue('C' . $i, $booking['nickname']);
                    $this->excel->getActiveSheet()->setCellValue('D' . $i, $booking['invitationCode']);
                    if($booking['fromType'] == '1'){
                        $this->excel->getActiveSheet()->setCellValue('E' . $i,'APP');
                    }else{
                        $this->excel->getActiveSheet()->setCellValue('E' . $i,'WEB');
                    }
                    $this->excel->getActiveSheet()->setCellValue('F' . $i, $booking['createTime']);
                }

                



                $filename = '邀请纪录.xls'; //save our workbook as this file name



                header('Content-Type: application/vnd.ms-excel'); //mime type

                header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name

                header('Cache-Control: max-age=0'); //no cache



                 $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."导出了邀请纪录",

                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );

                $this->db->insert('hf_system_journal',$log);

                $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

                $objWriter->save('php://output');


            }else{
                echo "<script>alert('暂无邀请纪录！');window.history.go(-1);</script>";

            }

            
        }
    }



    // //新增邀请码
    // function add_invitation_code(){
    //     if($_POST){ 
    //         $data = $this->input->post();
    //         if($this->System_model->insert('hf_system_invitation',$data)){
    //             $log = array(

    //                 'userid'=>$_SESSION['users']['user_id'],  

    //                 "content" => $_SESSION['users']['username']."新增了一个邀请码,归属姓名是".$data['name'],

    //                 "create_time" => date('Y-m-d H:i:s'),

    //                 "userip" => get_client_ip(),

    //             );

    //             $this->db->insert('hf_system_journal',$log);
    //            echo "<script>alert('操作成功！');window.location.href='".site_url('/systemSet/SystemSet/invitation_code')."'</script>";exit;
    //         }else{
    //             echo "<script>alert('操作失败！');window.location.href='".site_url('/systemSet/SystemSet/invitation_code')."'</script>";exit;

    //         }
    //     }else{
    //         $this->load->view('404.html');
    //     }
    // }
    // //编辑邀请码
    //  function edit_invitation_code(){
    //     if($_POST){ 
    //         $data = $this->input->post();
    //         if($this->System_model->updata('hf_system_invitation','id',$data['id'],$data)){
    //             $log = array(

    //                 'userid'=>$_SESSION['users']['user_id'],  

    //                 "content" => $_SESSION['users']['username']."编辑了一个邀请码,归属姓名是".$data['name'].',记录id是：'.$data['id'],

    //                 "create_time" => date('Y-m-d H:i:s'),

    //                 "userip" => get_client_ip(),

    //             );

    //             $this->db->insert('hf_system_journal',$log);
    //            echo "<script>alert('操作成功！');window.location.href='".site_url('/systemSet/SystemSet/invitation_code')."'</script>";exit;
    //         }else{
    //             echo "<script>alert('操作失败！');window.location.href='".site_url('/systemSet/SystemSet/invitation_code')."'</script>";exit;

    //         }
    //     }else{
    //         $this->load->view('404.html');
    //     }
    // }

    // //状态
    // function edit_invitation_state(){
    //     $id = intval($this->uri->segment('4'));
    //     $state = intval($this->uri->segment('5'));

    //     if($id == "0" || $state == "0"){
    //         $this->load->view('404.html');
    //     }else{
    //         if($state == '1'){
    //             $data['state'] = '1';
    //         }else{
    //             $data['state'] = '0';
    //         }

    //         if($this->System_model->updata('hf_system_invitation','id',$id,$data)){
    //             $log = array(

    //                 'userid'=>$_SESSION['users']['user_id'],  

    //                 "content" => $_SESSION['users']['username']."编辑了一个邀请码,记录id是：".$id,

    //                 "create_time" => date('Y-m-d H:i:s'),

    //                 "userip" => get_client_ip(),

    //             );

    //             $this->db->insert('hf_system_journal',$log);
    //            echo "<script>alert('操作成功！');window.location.href='".site_url('/systemSet/SystemSet/invitation_code')."'</script>";exit;
    //         }else{
    //             echo "<script>alert('操作失败！');window.location.href='".site_url('/systemSet/SystemSet/invitation_code')."'</script>";exit;
    //         }
    //     }
    // }

    // //删除激励
    // function del_invitation(){
    //     $id = intval($this->uri->segment(4));

    //     if($id == '0'){
    //         $this->load->view('404.html');
    //     }else{
    //         if($this->System_model->delete('hf_system_invitation','id',$id)){
    //              $log = array(

    //                 'userid'=>$_SESSION['users']['user_id'],  
    //                 "content" => $_SESSION['users']['username']."删除了一个邀请码,记录id是：".$id,
    //                 "create_time" => date('Y-m-d H:i:s'),
    //                 "userip" => get_client_ip(),
    //             );

    //             $this->db->insert('hf_system_journal',$log);
    //             echo "<script>alert('操作成功！');window.location.href='".site_url('/systemSet/SystemSet/invitation_code')."'</script>";exit;
    //         }else{
    //             echo "<script>alert('操作失败！');window.location.href='".site_url('/systemSet/SystemSet/invitation_code')."'</script>";exit;

    //         }
    //     }
    // }

    //消息推送
    function newsPush(){

  

        $data['page'] = '/systemSet/puth.html';
        $data['menu'] = array('systemSet', 'newsPush');
        $this->load->view('template.html', $data);
    }

    //
    function puthMessage(){
        if($_POST){
            $data = $this->input->post();
            
            $this->load->library('puth');

            $igt = new IGeTui(HOST,APPKEY,MASTERSECRET);
            switch ($data["laterOpt"]) {
                // 打开应用
                case '1':
                   $template = $this->puth->IGtNotificationTemplateDemo($data['title'],$data['content']);
                   break; 
                // 打开链接
                case '2':
                    $template = $this->puth->IGtLinkTemplateDemo($data['title'],$data['content'],$data['link']);
                    break; 
                // 下载应用
                case '3':

                    $template = $this->puth->IGtNotyPopLoadTemplateDemo($data['title'],$data['content'],$data['appname'],$data['popTitle'],$data['popContent'],$data['appurl']);
                    break;
                //透传
                case '4':
                    $content = json_encode(array("title"=>$data['title'],'content'=>$data['content'],'payload'=>array('banner'=>$data['linkUrl'],"info"=>$data['linkTitle'])));
                    if($data['plateform'] == '1'){
                        $template = $this->puth->IGtTransmissionTemplateDemo($content);
                    }else{
                        $template = $this->puth->IosIGtTransmissionTemplateDemo($content);
                    }
                    break;
                
                // 打开应用
                default:
                    
                   // $template = $this->puth->IGtTransmissionTemplateDemo($data['title'],$data['content']);
                  
                    break;
            }

            // $message = new IGtSingleMessage();

            $message = new IGtAppMessage();
            $message->set_isOffline(true);//是否离线
            $message->set_offlineExpireTime(3600*12*1000);//离线时间
            $message->set_data($template);//设置推送消息类型
           
            $appIdList=array(APPID);
            $message->set_appIdList($appIdList);
            //$message->set_conditions($cdt->getCondition());
            $rep = $igt->pushMessageToApp($message,"任务组名");

            unset($data['plateform']);
            if($rep['result'] == 'ok'){
                $data['status'] = '1';
                $this->System_model->insertPush($data);
                echo "<script>alert('推送成功！');window.location.href='".site_url('/systemSet/SystemSet/newsPush')."'</script>";exit;
            }else{
                $data['status'] = '0';
                $this->System_model->insertPush($data);
                echo "<script>alert('推送失败！');window.location.href='".site_url('/systemSet/SystemSet/newsPush')."'</script>";exit;
            }
           

        }
    }



    //全推
    function pushMessageToApp(){
        $this->load->library('puth');

        $igt = new IGeTui(HOST,APPKEY,MASTERSECRET);
        //定义透传模板，设置透传内容，和收到消息是否立即启动启用
        // $template = $this->puth->IGtNotificationTemplate();
        // $template = IGtLinkTemplateDemo();
        // $template = IGtNotyPopLoadTemplateDemo();
        // 定义"AppMessage"类型消息对象，设置消息内容模板、发送的目标App列表、是否支持离线发送、以及离线消息有效期(单位毫秒)
        $message = new IGtAppMessage();
        $message->set_isOffline(true);
        $message->set_offlineExpireTime(10 * 60 * 1000);//离线时间单位为毫秒，例，两个小时离线为3600*1000*2
        $message->set_data($template);

        $appIdList=array(APPID);
        // $phoneTypeList=array('ANDROID');
        // $provinceList=array('浙江');
        // $tagList=array('haha');
        //用户属性
        //$age = array("0000", "0010");


        //$cdt = new AppConditions();
       // $cdt->addCondition(AppConditions::PHONE_TYPE, $phoneTypeList);
       // $cdt->addCondition(AppConditions::REGION, $provinceList);
        //$cdt->addCondition(AppConditions::TAG, $tagList);
        //$cdt->addCondition("age", $age);

        $message->set_appIdList($appIdList);
        //$message->set_conditions($cdt->getCondition());

        $rep = $igt->pushMessageToApp($message,"任务组名");

        var_dump($rep);
        echo ("<br><br>");
    }

    //正对个人推送
    function pushMessageToSingle(){
        $this->load->library('puth');

        $igt = new IGeTui(HOST,APPKEY,MASTERSECRET);

        //消息模版：
        // 4.NotyPopLoadTemplate：通知弹框下载功能模板
        $content = '{
    "title": "买券优惠了",
    "content": "买券优惠了",
    "payload": {
        "banner": "market/BuyOffer.html&null",
        "info": "推送跳转页面"
    }
}';
        $template = $this->puth->IosIGtTransmissionTemplateDemo($content);

        //定义"SingleMessage"
        $message = new IGtSingleMessage();

        $message->set_isOffline(true);//是否离线
        $message->set_offlineExpireTime(3600*12*1000);//离线时间
        $message->set_data($template);//设置推送消息类型
        //$message->set_PushNetWorkType(0);//设置是否根据WIFI推送消息，2为4G/3G/2G，1为wifi推送，0为不限制推送
        //接收方
        $target = new IGtTarget();
        $target->set_appId(APPID);
        $target->set_clientId('cf066c9d0c146870e695e2e8dbeb8340');
    //    $target->set_alias(Alias);

        try {
            $rep = $igt->pushMessageToSingle($message, $target);
            var_dump($rep);
            echo ("<br><br>");

        }catch(RequestException $e){
            $requstId =e.getRequestId();
            //失败时重发
            $rep = $igt->pushMessageToSingle($message, $target,$requstId);
            var_dump($rep);
            echo ("<br><br>");
        }
    }

    

    


}



