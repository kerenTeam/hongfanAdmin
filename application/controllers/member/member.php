<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  会员管理
 *
 * */
require_once(APPPATH.'controllers/default_Controller.php');

class member extends default_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('member_model','user_model');
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
        $config['base_url'] = site_url('/member/member/memberList');
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
            'page' => $this->pagination->create_links(),
        );
        //获取会员卡类型
        $data['cards'] = $this->user_model->get_card_type( );
        //获取会员分组
        $data['group'] = $this->user_model->get_user_group();
    	$this->load->view('member/memberList.html',$data);
    }


    //新增会员
    function addMember(){
         //获取会员卡类型
       //  $data['cards'] = $this->user_model->get_card_type();
          //获取会员卡类型
        $data['cards'] = $this->user_model->get_card_type( );
         //获取会员分组
         //$data['group'] = $this->user_model->get_user_group();
    	 $this->load->view('member/addMember.html',$data);
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
                echo "<script>alert('电话已被注册！请重新添加！');window.location.href='".site_url('/member/member/addMember')."'</script>";
                exit;
            }
            //插入
            if($this->user_model->add_user_member($data)){
                echo "<script>alert('操作成功！');window.location.href='".site_url('/member/member/memberList')."'</script>";
                exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/member/member/addMember')."'</script>";
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

            $this->load->view('member/editMember.html',$data);
        }
    }

    //编辑处理
    function edit_userinfo(){
        if($_POST){
            $data = $this->input->post();
            $data['password'] = md5($this->input->post('password'));
            if($this->user_model->edit_userinfo($data['user_id'],$data)){
                echo "<script>alert('操作成功！');window.location.href='".site_url('/member/member/memberList')."'</script>";
                exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/member/member/editMember/').$data['userid']."'</script>";
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
            if($id == 1){
                echo "<script>alert('网站创建者不能删除！');window.location.href='".site_url('/member/member/memberList')."'</script>";
                exit;
            }
            //自己不能删除
            if($id == $this->session->users['user_id']){
                echo "<script>alert('不能删除自己！');window.location.href='".site_url('/member/member/memberList')."'</script>";
                exit;
            }
            if($this->user_model->del_member($id)){
                echo "<script>alert('操作成功！');window.location.href='".site_url('/member/member/memberList')."'</script>";
                exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/member/member/memberList')."'</script>";
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
            $this->load->view('member/memberInfo.html',$data);
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
            $config['base_url'] = site_url('/member/member/memberList');
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
                'page' => $this->pagination->create_links(),
            );
            //获取会员卡类型
            $data['cards'] = $this->user_model->get_card_type( );
            //获取会员分组
            $data['group'] = $this->user_model->get_user_group();
            $data['title'] = '搜索结果';
            $this->load->view('member/memberList.html',$data);
              
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
        $this->load->view('member/memberCard.html',$data);
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
            $this->load->view('member/memberCardDetail.html',$data);
        }
    }
    //会员卡编辑处理
    function edit_card(){
        if($_POST){
            $data = $this->input->post();
            if(!empty($_FILES['img']['tmp_name'])){
                //配置
                $config['upload_path']      = 'upload/cards';
                $config['allowed_types']    = 'gif|jpg|png|jpeg';
                $config['max_size']     = 2048;
                $config['file_name'] = date('Y-m-d_His');
                $this->load->library('upload', $config);
                //上传
                if ( ! $this->upload->do_upload('img')) {
                    echo "<script>alert('图片上传失败！');window.location.href='".site_url('/member/member/memberCardDetail/').$data['id']."'</script>";
                    exit;
                } else{
                    $data['pic'] =  'upload/cards/'.$this->upload->data('file_name');
                }
            }
            //操作数据库
            if($this->user_model->edit_cards($data['id'],$data)){
                echo "<script>alert('操作成功！');window.location.href='".site_url('/member/member/memberCard')."'</script>";
                exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/member/member/memberCardDetail/').$data['id']."'</script>";
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
                echo "<script>alert('操作成功！');window.location.href='".site_url('/member/member/memberCard')."'</script>";
                exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/member/member/memberCard')."'</script>";
                exit;
            }
        }

    }

    //会员卡管理-添加会员卡
    function memberCardAdd(){
        $this->load->view('member/memberCardAdd.html');
    }

    //会员卡新增操作
    function add_cards(){
        if($_POST){
            $data = $this->input->post();
            if(!empty($_FILES['img']['tmp_name'])){
                $config['upload_path']      = 'upload/cards';
                $config['allowed_types']    = 'gif|jpg|png|jpeg';
                $config['max_size']     = 2048;
                $config['file_name'] = date('Y-m-d_His');

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('img'))
                {
                    echo "<script>alert('图片上传失败！');window.location.href='".site_url('/member/member/memberCardAdd')."'</script>";
                    exit;
                }
                else
                {
                    $data['pic'] =  'upload/cards/'.$this->upload->data('file_name');
                }
            }
            if($this->user_model->add_cards($data)){
                echo "<script>alert('操作成功！');window.location.href='".site_url('/member/member/memberCard')."'</script>";
                exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/member/member/memberCardAdd')."'</script>";
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
    			echo "<script>alert('网站创建者不能冻结！');window.location.href='".site_url('/member/member/memberList')."'</script>";
    			exit;
    		}
    		//自己不能屏蔽
    		if($id == $this->session->users['user_id']){
    			echo "<script>alert('不能冻结自己！');window.location.href='".site_url('/member/member/memberList')."'</script>";
    			exit;
    		}
    		if($state == 2){
    			$state = 0;
    		}
    		$arr = array('state'=>$state);
    		if($this->user_model->edit_state($id,$arr)){
				echo "<script>alert('操作成功！');window.location.href='".site_url('/member/member/memberList')."'</script>";
				exit;
    		}else{
    			echo "<script>alert('失败，请重新操作！');window.location.href='".site_url('/member/member/memberList')."'</script>";
				exit;
    		}
    	}else{
    		$this->load->view('404.html');
    	}
    }

    //权限管理
    function memberLimit(){
        //返回所有权限  
        $data['group'] = $this->user_model->get_user_group();
        //所有模块 
        $data['plate'] = array(
                '0'=>array('id'=>'0','name'=>'所有模块'),
                '1'=>array('id'=>'1','name'=>'系统设置'),
                '2'=>array('id'=>'2','name'=>'商场设置'),
                '3'=>array('id'=>'3','name'=>'店铺管理'),
                '4'=>array('id'=>'4','name'=>'电商管理'),
                '5'=>array('id'=>'5','name'=>'电子劵'),
                '6'=>array('id'=>'6','name'=>'主页模块'),
                '7'=>array('id'=>'7','name'=>'卡卷管理'),
                '8'=>array('id'=>'8','name'=>'会员管理'),
            );
        $this->load->view('member/memberLimit.html',$data);
    }

    //新增权限
    function add_member_group(){
        if($_POST){
            $data['group_name'] = $this->input->post('group_name');
            $data['group_permission'] = json_encode($this->input->post('group_permission'));
            if($this->user_model->add_group($data)){
                echo "<script>alert('操作成功!');window.location.href='".site_url('/member/member/memberLimit')."'</script>";exit;
            }else{
                echo "<script>alert('操作失败!');window.location.href='".site_url('/member/member/memberLimit')."'</script>";exit;
            }
        }else{
            $this->load->view('404.html');
        }
    }
    
    //编辑权限
    function edit_member_group(){
        if($_POST){
            $id = $this->input->post('gid');
            $data['group_name'] = $this->input->post('group_name');
            $data['group_permission'] = json_encode($this->input->post('group_permission'));
            if($this->user_model->edit_group($id,$data)){
                 echo "<script>alert('操作成功!');window.location.href='".site_url('/member/member/memberLimit')."'</script>";exit;
             }else{
                 echo "<script>alert('操作失败!');window.location.href='".site_url('/member/member/memberLimit')."'</script>";exit;
             }
        }else{
            $this->load->view('404.html');
        }
    }



}

