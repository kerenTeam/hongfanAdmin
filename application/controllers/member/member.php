<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  会员管理
 *
 * */
require_once(APPPATH.'controllers/Default_Controller.php');

class Member extends Default_Controller {
    //会员列表
    public $view_memberList = 'member/memberList.html';
    //新增会员
    public $view_addMember = 'member/addMember.html';  
    //编辑会员
    public $view_editMember = 'member/editMember.html'; 
    //会员详情管理
    public $view_memberInfo = 'member/memberInfo.html';
    //会员卡列表
    public $view_memberCard = "member/memberCard.html";
    //新增会员卡
    public $view_memberCardAdd = "member/memberCardAdd.html";
    //编辑会员卡
    public $view_memberCardDetail = 'member/memberCardDetail.html';

    function __construct()
    {
        parent::__construct();
    }

    //会员 列表
    function memberList()
    {
        //获取会员列表
    	$config['per_page'] = 10; //每页显示的数据数

    	//页码
        $current_page=intval($this->uri->segment(4));//index.php 后数第4个/
        //分页数据
        $result = $this->user_model->get_user_page('5',$current_page,$config['per_page']);
       	//配置
        $config['base_url'] = site_url('/member/Member/memberList');
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
        //总共多少
        $num = $this->user_model->get_users('5');
        $config['total_rows'] = count($num);//总条数

        $this->load->library('pagination');//加载ci pagination类
        $this->pagination->initialize($config);
        $data = array(
            'users' => $result,
            'pages' => $this->pagination->create_links(),
        );
        //获取会员卡类型
        $data['cards'] = $this->user_model->get_card_type( );
        $data['userNum'] = $this->user_model->get_users('5');
        //视图界面
        $data['page'] = $this->view_memberList;
        $data['menu'] = array('member','memberList');
    	$this->load->view('template.html',$data);
    }


    //新增会员
    function addMember(){
         //获取会员卡类型
       //  $data['cards'] = $this->user_model->get_card_type();
          //获取会员卡类型
        $data['cards'] = $this->user_model->get_card_type( );
          //视图界面
        $data['page'] = $this->view_addMember;
        $data['menu'] = array('member','addMember');
        $this->load->view('template.html',$data);
    }

    //新增会员操作
    function add_user(){
        if($_POST){
            $data = $this->input->post();
            $data['password'] = md5($this->input->post('password'));
            $data['gid'] = '5';
            //是否被注册
            $user = $this->user_model->get_login_user($data['phone']);
            if($user){
                echo "<script>alert('电话已被注册！请重新添加！');window.location.href='".site_url('/member/Member/addMember')."'</script>";
                exit;
            }

           


            //插入
            if($this->user_model->add_user_member($data)){
                 //日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."新增了一个普通用户。用户名是".$data['username'],
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);
                echo "<script>alert('操作成功！');window.location.href='".site_url('/member/Member/memberList')."'</script>";
                exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/member/Member/addMember')."'</script>";
                exit;
            }
        }else{
            $this->load->view('404.html');
        }
    }

    //编辑会员
    function editMember(){
         $id = intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
            //获取会员信息
            $data['userinfo'] = $this->user_model->get_user_info($id);
            //获取分组信息
           // $data['group'] = $this->user_model->get_user_group();
             $data['cards'] = $this->user_model->get_card_type( );
            $data['userid'] = $id;
            //视图界面
            $data['page'] = $this->view_editMember;
            $data['menu'] = array('member','memberList');
            $this->load->view('template.html',$data);
        }
    }

    //编辑处理
    function edit_userinfo(){
        if($_POST){
            $data = $this->input->post();
            if(!empty($this->input->post('password'))){
                $data['password'] = md5($this->input->post('password'));
            }
            


            if($this->user_model->edit_userinfo($data['user_id'],$data)){
                //日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."编辑了一个普通用户。用户名是".$data['username']."用户id是：".$data['user_id'],
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);
                echo "<script>alert('操作成功！');window.location.href='".site_url('/member/Member/memberList')."'</script>";
                exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/member/Member/editMember/'.$data['userid'])."'</script>";
                exit;
            }
        }else{
            $this->load->view('404.html');
        }
    }
    //删除会员
    function delMember(){
        $id = intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
          
            //自己不能删除
            if($id == $_SESSION['users']['user_id']){
                echo "<script>alert('不能删除自己！');window.location.href='".site_url('/member/Member/memberList')."'</script>";
                exit;
            }
            if($this->user_model->del_member($id)){
                //日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."删除了一个普通用户。用户id是：".$id,
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);
                echo "<script>alert('操作成功！');window.location.href='".site_url('/member/Member/memberList')."'</script>";
                exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/member/Member/memberList')."'</script>";
                exit;
            }
        }
    }
    //会员详情管理
    function memberInfo(){
        $id=intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
            //用户信息
            $data['userinfo'] = $this->user_model->get_user_info($id);
            //用户地址
            $data['address'] = $this->user_model->get_user_address('hf_user_address',$id);
            //用户积分记录
            $data['inter'] = $this->user_model->get_user_address('hf_user_intergral',$id);
            //消息记录
            $data['message'] = $this->user_model->get_user_address('hf_user_message',$id);
             //视图界面
            $data['page'] = $this->view_memberInfo;
            $data['menu'] = array('member','memberList');
            $this->load->view('template.html',$data);
        }
    }

    //返回用户消息
    function ret_user_message(){
        if($_POST){
            $id = $_POST['userid'];
                    //消息记录
            $list= $this->user_model->get_user_address('hf_user_message',$id);
            if(empty($list)){
                echo "3";
            }else{
                echo json_encode($list);
            }
        }else{
            echo "2";
        }
    }

    //返回用户积分记录
    function ret_user_intergral(){
        if($_POST){
            $id = $_POST['userid'];
            $list = $this->user_model->get_user_address('hf_user_intergral',$id);
            if(empty($list)){
                echo "3";
            }else{
                echo json_encode($list);
            }
        }else{
            echo "2";
        }
    }

    //返回用户地址
    function ret_user_address(){
        if($_POST){
                $id = $_POST['userid'];
                $list = $this->user_model->get_user_address('hf_user_address',$id);
                if(empty($list)){
                    echo "3";
                }else{
                    echo json_encode($list);
                }
        }else{
            echo "2";
        }
    }

    //会员搜索
    function search(){
        if($_POST){
            $card_type = $this->input->post('card');
            $gender = $this->input->post('gender');
            $state = $this->input->post('state');
            $sear = trim($this->input->post('sear'));

            $config['per_page'] = 10; //每页显示的数据数
            //页码
            $current_page=intval($this->uri->segment(4));//index.php 后数第4个/
            //分页数据
            $result = $this->user_model->search_users_page('5',$card_type,$gender,$state,$sear,$current_page,$config['per_page']);
            //配置
            $config['base_url'] = site_url('/member/Member/memberList');
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
            //总共多少
            $num = $this->user_model->search_users('5',$card_type,$gender,$state,$sear);

            $this->load->library('pagination');//加载ci pagination类
            $this->pagination->initialize($config);
            $data = array(
                'users' => $result,
                'pages' => $this->pagination->create_links(),
            );
            //获取会员卡类型
            $data['cards'] = $this->user_model->get_card_type( );

            $data['title'] = '搜索结果';
             //视图界面
            $data['page'] = $this->view_memberList;
            $data['menu'] = array('member','memberList');
            $this->load->view('template.html',$data);
              
            }else{
                $this->load->view('404.html');
            }
    }

    //会员组
    function memberGroup()
    {

        $this->load->view('member/memberGroup.html');
    }

    //会员卡管理
    function memberCard(){
        //获取所有会员卡
        $data['cards'] = $this->user_model->get_card_type();
          //视图界面
            $data['page'] = $this->view_memberCard;
            $data['menu'] = array('member','memberCard');
            $this->load->view('template.html',$data);
    }

    //会员卡管理-会员卡详情
    function memberCardDetail(){
        $id=intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
            //获取会员卡详情
            $data['card'] = $this->user_model->get_cardinfo($id);
            $data['id'] = $id;
            //视图界面
            $data['page'] = $this->view_memberCardDetail;
            $data['menu'] = array('member','memberCard');
            $this->load->view('template.html',$data);
        }
    }
    //会员卡编辑处理
    function edit_card(){
        if($_POST){
            $data = $this->input->post();
            if(!empty($_FILES['img']['tmp_name'])){
                //配置
                $config['upload_path']      = 'Upload/cards';
                $config['allowed_types']    = 'gif|jpg|png|jpeg';
                $config['max_size']     = 2048;
                $config['file_name'] = date('Y-m-d_His');
                $this->load->library('upload', $config);
                //上传
                if ( ! $this->upload->do_upload('img')) {
                    echo "<script>alert('图片上传失败！');window.location.href='".site_url('/member/Member/memberCardDetail/'.$data['id'])."'</script>";
                    exit;
                } else{
                    $data['pic'] =  '/Upload/cards/'.$this->upload->data('file_name');
                }
            }
            //操作数据库
            if($this->user_model->edit_cards($data['id'],$data)){
                 //日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."编辑了一个会员卡。会员卡名是".$data['name']."会员卡Id是:".$data['id'],
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);
                echo "<script>alert('操作成功！');window.location.href='".site_url('/member/Member/memberCard')."'</script>";
                exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/member/Member/memberCardDetail/'.$data['id'])."'</script>";
                exit;
            }
        }else{
            $this->load->view('404.html');
        }
    }

    //删除会员卡
    function del_card(){
        $id=intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
            if($this->user_model->del_cards($id)){
                //日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."删除了一个会员卡。会员卡Id是:".$id,
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/member/Member/memberCard')."'</script>";
                exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/member/Member/memberCard')."'</script>";
                exit;
            }
        }

    }

    //会员卡管理-添加会员卡
    function memberCardAdd(){
 
            $data['page'] = $this->view_memberCardAdd;
            $data['menu'] = array('member','memberCard');
            $this->load->view('template.html',$data);
    }

    //会员卡新增操作
    function add_cards(){
        if($_POST){
            $data = $this->input->post();
            if(!empty($_FILES['img']['tmp_name'])){
                $config['upload_path']      = 'Upload/cards';
                $config['allowed_types']    = 'gif|jpg|png|jpeg';
                $config['max_size']     = 2048;
                $config['file_name'] = date('Y-m-d_His');

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('img'))
                {
                    echo "<script>alert('图片上传失败！');window.location.href='".site_url('/member/Member/memberCardAdd')."'</script>";
                    exit;
                }
                else
                {
                    $data['pic'] =  '/Upload/cards/'.$this->upload->data('file_name');
                }
            }
            if($this->user_model->add_cards($data)){
                 //日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."新增了一个会员卡。会员卡名是".$data['name'],
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/member/Member/memberCard')."'</script>";
                exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/member/Member/memberCardAdd')."'</script>";
                exit;
            }
        }else{
            $this->load->view('404.html');
        }
    }

    //屏蔽会员/解除会员屏蔽
    function up_user_state(){
    	$state=intval($this->uri->segment(4));
    	$id=intval($this->uri->segment(5));
        //是否是修改状态
    	if($id ==0 && $state ==0){
    		$this->load->view('404.html');
    	}else if($state == 1 || $state ==2){
    	    //网站建立者不能屏蔽
    		if($id == 1){
    			echo "<script>alert('网站创建者不能冻结！');window.location.href='".site_url('/member/Member/memberList')."'</script>";
    			exit;
    		}
    		//自己不能屏蔽
    		if($id == $_SESSION['users']['user_id']){
    			echo "<script>alert('不能冻结自己！');window.location.href='".site_url('/member/Member/memberList')."'</script>";
    			exit;
    		}
    		if($state == 2){
    			$state = 0;
    		}
    		$arr = array('state'=>$state);
    		if($this->user_model->edit_state($id,$arr)){
                 //日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."屏蔽了一个会员。会员id是".$id,
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);
				echo "<script>alert('操作成功！');window.location.href='".site_url('/member/Member/memberList')."'</script>";
				exit;
    		}else{
    			echo "<script>alert('失败，请重新操作！');window.location.href='".site_url('/member/Member/memberList')."'</script>";
				exit;
    		}
    	}else{
    		$this->load->view('404.html');
    	}
    }

  



}

