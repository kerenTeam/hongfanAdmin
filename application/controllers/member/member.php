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
        $result = $this->user_model->get_user_page($current_page,$config['per_page']);
       	//配置
        $config['base_url'] = base_url('member/member/memberList');
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
        $num = $this->user_model->get_users();
        $config['total_rows'] = count($num);//总条数
      
        $this->load->library('pagination');//加载ci pagination类
        $this->pagination->initialize($config);
        $data = array(
            'users' => $result,
            'total' => count($num),
            'current_page' => $current_page,
            'per_page' => $config['per_page'],
            'page' => $this->pagination->create_links(),
        );
        //获取会员卡类型
        $data['cards'] = $this->user_model->get_card_type();
        //获取会员分组
        $data['group'] = $this->user_model->get_user_group();
    	$this->load->view('member/memberList.html',$data);
    }



    //会员组
    function memberGroup()
    {
         $this->load->view('member/memberGroup.html');
    }
    //新增会员
    function addMember(){
         //获取会员卡类型
         $data['cards'] = $this->user_model->get_card_type();
         //获取会员分组
         $data['group'] = $this->user_model->get_user_group();
    	 $this->load->view('member/addMember.html',$data);
    }
    


    //编辑会员
    function editMember(){

         $this->load->view('member/editMember.html');
    }
    //会员卡管理
    function memberCard(){
        $this->load->view('member/memberCard.html');
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
    			echo "<script>alert('网站创建者不能冻结！');window.location.href='".base_url('member/member/memberList')."'</script>";
    			exit;
    		}
    		//自己不能屏蔽
    		if($id == $this->session->users['userid']){
    			echo "<script>alert('不能冻结自己！');window.location.href='".base_url('member/member/memberList')."'</script>";
    			exit;
    		}
    		if($state == 2){
    			$state = 0;
    		}
    		$arr = array('state'=>$state);
    		if($this->user_model->edit_state($id,$arr)){
				echo "<script>alert('操作成功！');window.location.href='".base_url('member/member/memberList')."'</script>";
				exit;
    		}else{
    			echo "<script>alert('失败，请重新操作！');window.location.href='".base_url('member/member/memberList')."'</script>";
				exit;
    		}
    	}else{
    		$this->load->view('404.html');
    	}
    	
    }


}

