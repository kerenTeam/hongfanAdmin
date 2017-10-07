<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Default_Controller.php');

/*问答*/
/**
* 
*/
class Question extends Default_Controller
{
	public $dynamic = "hf_friends_news";//动态
	public $cates = "hf_faqs_group";//动态
	public $comment = "hf_friends_news_commont";//评论或回答
	public $expert = "hf_faqs_expert";//专家


	//23
	public $view_question_list = "friends/question_list.html";//问题泪飙
	public $view_question_cates = "friends/question_cates.html";//问题泪飙
	public $view_question_comment = "friends/question_comment.html";//问题泪飙
	public $view_question_expert = "friends/question_expert.html";//专家

	function __construct(){
		# code...
		parent::__construct();
		$this->load->model("Public_model");
	}

	//问答列表
	function question_list(){

		$config['per_page'] = 10;
        //获取页码
        $current_page=intval($this->uri->segment(4));//index.php 后数第4个/
        //配置
        $config['base_url'] = site_url('/friends/Question/question_list');
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
        $list = $this->Public_model->select_where($this->dynamic,'typeId','2','');

        $config['total_rows'] = count($list);

        // //分页数据
        $listpage = $this->Public_model->select_question_list($config['per_page'],$current_page);
          $this->load->library('pagination');//加载ci pagination类

        $this->pagination->initialize($config);

        //返回所有问题分类
        $cates = $this->Public_model->select($this->cates,'');

        $data = array('lists'=>$listpage,'pages' => $this->pagination->create_links(),'cates'=>$cates);

        $data['page'] = $this->view_question_list;
        $data['menu'] = array('question','question_list');
        $this->load->view('template.html',$data);
			
	}

	//新增问题
	function add_problem(){
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
			$data['userid'] = $_SESSION['users']['user_id'];
			$data['typeId'] = '2';

			$header = array("token:".$_SESSION['token'],'city:'.'1');    
			if(!empty($_FILES['img']['name'])){
                    $tmpfile = new CURLFile(realpath($_FILES['img']['tmp_name']));
                
                    $pics = array(
                        'pics' =>$tmpfile,
                        'porfix'=>'question/news',
                        'bucket'=>'cqcfriends',
                    );
				
					$qiuniu = json_decode(curl_post_express($header,QINIUUPLOAD,$pics),true);

					if($qiuniu['errno'] == '0'){
						$img = json_decode($qiuniu['data']['img'],true);
						$icon[]['picImg'] =$img[0]['picImg'];
						$data['pic'] = json_encode($icon);
					}else{
						// echo "1";
					  echo "<script>alert('图片上传失败！');window.location.href='".site_url('/friends/Question/question_list')."'</script>";exit;
					}
            }
            if($this->Public_model->insert($this->dynamic,$data)){
            	$log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."新增了问答问题，问题内容是：".$data['content'],
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                				$this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/friends/Question/question_list')."'</script>";exit;
            }else{
  				echo "<script>alert('操作失败！');window.location.href='".site_url('/friends/Question/question_list')."'</script>";exit;
            }
		}else{
			$this->load->view('404.html');
		}

	}


	//编辑问题
	function edit_problem(){
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

			$header = array("token:".$_SESSION['token'],'city:'.'1');    
			if(!empty($_FILES['img']['name'])){
                    $tmpfile = new CURLFile(realpath($_FILES['img']['tmp_name']));
                
                    $pics = array(
                        'pics' =>$tmpfile,
                        'porfix'=>'question/news',
                        'bucket'=>'cqcfriends',
                    );
				
					$qiuniu = json_decode(curl_post_express($header,QINIUUPLOAD,$pics),true);

					if($qiuniu['errno'] == '0'){
						$img = json_decode($qiuniu['data']['img'],true);
						$icon[]['picImg'] =$img[0]['picImg'];
						$data['pic'] = json_encode($icon);
					}else{
						// echo "1";
					  echo "<script>alert('图片上传失败！');window.location.href='".site_url('/friends/Question/question_list')."'</script>";exit;
					}
            }
            if($this->Public_model->updata($this->dynamic,'id',$data['id'],$data)){
            	$log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."编辑了问答问题，问题id是：".$data['id']."，问题内容是：".$data['content'],
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/friends/Question/question_list')."'</script>";exit;
            }else{
  				echo "<script>alert('操作失败！');window.location.href='".site_url('/friends/Question/question_list')."'</script>";exit;
            }
		}else{
			$this->load->view('404.html');
		}
	}

	//删除问题
	function del_problem(){
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
		$id = intval($this->uri->segment('4'));
		if($id == '0'){
			$this->load->view('404.html');
		}else{
			if($this->Public_model->delete($this->dynamic,'id',$id)){
				$this->Public_model->delete($this->comment,'newsId',$id);
            	$log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."删除了问答问题，问题id是：".$id,
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/friends/Question/question_list')."'</script>";exit;
            }else{
  				echo "<script>alert('操作失败！');window.location.href='".site_url('/friends/Question/question_list')."'</script>";exit;
            }
		}
	}

	//查看回答
	function see_problem(){
		$id = intval($this->uri->segment(4));
		if($id == '0'){
			$this->load->view('404.html');
		}else{
			$data['lists'] = $this->Public_model->select_question_comment($id);
			$data['newsId'] = $id;
	        $data['page'] = $this->view_question_comment;
	        $data['menu'] = array('question','question_list');
	        $this->load->view('template.html',$data);
		}
       
	}

	//新增回答内容
	function add_answer(){
		if($_POST){
			$data = $this->input->post();
			$data['userid'] = $_SESSION['users']['user_id'];
			$header = array("token:".$_SESSION['token'],'city:'.'1');    
			if(!empty($_FILES['img']['name'])){
                    $tmpfile = new CURLFile(realpath($_FILES['img']['tmp_name']));
                
                    $pics = array(
                        'pics' =>$tmpfile,
                        'porfix'=>'question/news',
                        'bucket'=>'cqcfriends',
                    );
				
					$qiuniu = json_decode(curl_post_express($header,QINIUUPLOAD,$pics),true);

					if($qiuniu['errno'] == '0'){
						$img = json_decode($qiuniu['data']['img'],true);
						$icon[]['picImg'] =$img[0]['picImg'];
						$data['pics'] = json_encode($icon);
					}else{
						// echo "1";
					  echo "<script>alert('图片上传失败！');window.location.href='".site_url('/friends/Question/see_problem/').$data['newsId']."'</script>";exit;
					}
            }
            if($this->Public_model->insert($this->comment,$data)){
            	$log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."新增问答问题的回答，问题id是：".$data['newsId']."，回答内容是：".$data['commont'],
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/friends/Question/see_problem/').$data['newsId']."'</script>";exit;
            }else{
  				echo "<script>alert('操作失败！');window.location.href='".site_url('/friends/Question/see_problem/').$data['newsId']."'</script>";exit;
            }
		}else{
			$this->load->view('404.html');
		}
	}

	//编辑回答内容
	function edit_answer(){
		if($_POST){
			$data = $this->input->post();
			$header = array("token:".$_SESSION['token'],'city:'.'1');    
			if(!empty($_FILES['img']['name'])){
                    $tmpfile = new CURLFile(realpath($_FILES['img']['tmp_name']));
                
                    $pics = array(
                        'pics' =>$tmpfile,
                        'porfix'=>'question/news',
                        'bucket'=>'cqcfriends',
                    );
				
					$qiuniu = json_decode(curl_post_express($header,QINIUUPLOAD,$pics),true);

					if($qiuniu['errno'] == '0'){
						$img = json_decode($qiuniu['data']['img'],true);
						$icon[]['picImg'] =$img[0]['picImg'];
						$data['pics'] = json_encode($icon);
					}else{
						// echo "1";
					  echo "<script>alert('图片上传失败！');window.location.href='".site_url('/friends/Question/see_problem/').$data['newsId']."'</script>";exit;
					}
            }
            if($this->Public_model->updata($this->comment,'id',$data['id'],$data)){
            	$log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."编辑问答问题的回答，问题id是：".$data['newsId']."，回答内容是：".$data['commont'],
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/friends/Question/see_problem/').$data['newsId']."'</script>";exit;
            }else{
  				echo "<script>alert('操作失败！');window.location.href='".site_url('/friends/Question/see_problem/').$data['newsId']."'</script>";exit;
            }
		}else{
			$this->load->view('404.html');
		}
	}

	//删除回答
	function del_answer(){
		$id = intval($this->uri->segment(4));
		$newsId = intval($this->uri->segment(5));
		if($id == 0 || $newsId == 0){
			$this->load->view('404.html');
		}else{
			 if($this->Public_model->delete($this->comment,'id',$id)){
            	$log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."删除问答问题的回答，问题id是：".$newsId."，回答id是：".$id,
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/friends/Question/see_problem/').$newsId."'</script>";exit;
            }else{
  				echo "<script>alert('操作失败！');window.location.href='".site_url('/friends/Question/see_problem/').$newsId."'</script>";exit;
            }
		}
	}

	//问答分类
	function question_cates(){

		$config['per_page'] = 10;
        //获取页码
        $current_page=intval($this->uri->segment(4));//index.php 后数第4个/
        //配置
        $config['base_url'] = site_url('/friends/Question/question_list');
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
        $list = $this->Public_model->select($this->cates,'');

        $config['total_rows'] = count($list);

        // //分页数据
        $listpage = $this->Public_model->select_question_cates($config['per_page'],$current_page);
          $this->load->library('pagination');//加载ci pagination类

        $this->pagination->initialize($config);

        $data = array('lists'=>$listpage,'pages' => $this->pagination->create_links());

        $data['page'] = $this->view_question_cates;
        $data['menu'] = array('question','question_cates');
        $this->load->view('template.html',$data);
	}


	//新增问答分类
	function add_question_cates(){
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
			$data['createUser'] = $_SESSION['users']['user_id'];

			$header = array("token:".$_SESSION['token'],'city:'.'1');    
			if(!empty($_FILES['img']['name'])){
                    $tmpfile = new CURLFile(realpath($_FILES['img']['tmp_name']));
                
                    $pics = array(
                        'pics' =>$tmpfile,
                        'porfix'=>'question/cates',
                        'bucket'=>'cqcfriends',
                    );
				
					$qiuniu = json_decode(curl_post_express($header,QINIUUPLOAD,$pics),true);

					if($qiuniu['errno'] == '0'){
						$img = json_decode($qiuniu['data']['img'],true);
						$icon[]['picImg'] =$img[0]['picImg'];
						$data['icon'] = json_encode($icon);
					}else{
						// echo "1";
					  echo "<script>alert('图片上传失败！');window.location.href='".site_url('/friends/Question/question_cates')."'</script>";exit;
					}
            }
            if($this->Public_model->insert($this->cates,$data)){
            	$log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."新增了问答分类，分类名称是：".$data['name'],
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                				$this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/friends/Question/question_cates')."'</script>";exit;
            }else{
  				echo "<script>alert('操作失败！');window.location.href='".site_url('/friends/Question/question_cates')."'</script>";exit;
            }

		}else{
			$this->load->view('404.html');
		}
	}

	//bianji 
	function edit_question_cates(){
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
			$header = array("token:".$_SESSION['token'],'city:'.'1');    
			if(!empty($_FILES['img']['name'])){
                    $tmpfile = new CURLFile(realpath($_FILES['img']['tmp_name']));
                
                    $pics = array(
                        'pics' =>$tmpfile,
                        'porfix'=>'question/cates',
                        'bucket'=>'cqcfriends',
                    );
				
					$qiuniu = json_decode(curl_post_express($header,QINIUUPLOAD,$pics),true);

					if($qiuniu['errno'] == '0'){
						$img = json_decode($qiuniu['data']['img'],true);
						$icon[]['picImg'] =$img[0]['picImg'];
						$data['icon'] = json_encode($icon);
					}else{
						// echo "1";
					  echo "<script>alert('图片上传失败！');window.location.href='".site_url('/friends/Question/question_cates')."'</script>";exit;
					}
            }
            if($this->Public_model->updata($this->cates,'id',$data['id'],$data)){
            	$log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."编辑了问答分类，分类名称是：".$data['name'].",分类id是：".$data['id'],
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/friends/Question/question_cates')."'</script>";exit;
            }else{
  				echo "<script>alert('操作失败！');window.location.href='".site_url('/friends/Question/question_cates')."'</script>";exit;
            }

		}else{
			$this->load->view('404.html');
		}
	}

	//删除分类
	function del_question_cates(){
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
		$id = intval($this->uri->segment('4'));
		if($id == '0'){
			$this->load->view('404.html');
		}else{
			if($this->Public_model->delete($this->cates,'id',$id)){
            	$log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."删除了问答分类,分类id是：".$id,
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/friends/Question/question_cates')."'</script>";exit;
            }else{
  				echo "<script>alert('操作失败！');window.location.href='".site_url('/friends/Question/question_cates')."'</script>";exit;
            }
		}

	}




	//专家信息
	function question_expert(){
		$id = intval($this->uri->segment(4));
		 //获取分类
        $cates = $this->Public_model->select($this->cates,'');
        $config['per_page'] = 10;

		if($id == 0){
			 $current_page=intval($this->uri->segment(4));//index.php 后数第4个/
			 $config['base_url'] = site_url('/friends/Question/question_expert');
			 $cateid = $cates[0]['id'];
		}else{
        	$current_page=intval($this->uri->segment(5));//index.php 后数第4个/
        	$config['base_url'] = site_url('/friends/Question/question_expert/'.$id);
        	$cateid = $id;
		}
        //获取页码
        //配置
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

       

        $list = $this->Public_model->select_where($this->expert,'groupId',$cateid,'');

        $config['total_rows'] = count($list);

        // //分页数据
        $listpage = $this->Public_model->select_where_page($this->expert,'groupId',$cateid,$config['per_page'],$current_page,'');
        $this->load->library('pagination');//加载ci pagination类

        $this->pagination->initialize($config);

        $user = $this->Public_model->select_where("hf_user_member",'gid','5','');


        $data = array('lists'=>$listpage,'pages' => $this->pagination->create_links(),'cates'=>$cates,'users'=>$user,'cateid'=>$cateid);

        $data['page'] = $this->view_question_expert;
        $data['menu'] = array('question','question_expert');
        $this->load->view('template.html',$data);
	}

	//新增专家组
	function add_expert(){
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

			//多条件查询
			$true = $this->Public_model->select_manWhere($this->expert,$data['groupId'],$data['userId']);
			if(!empty($true)){
				echo "<script>alert('该类别下，专家以存在！');window.location.href='".site_url('/friends/Question/question_expert')."'</script>";exit;
			}

			
            if($this->Public_model->insert($this->expert,$data)){
            	$log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."新增了问答分类专家，分类id是：".$data['groupId'].",用户id是：".$data['userId'],
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/friends/Question/question_expert/').$data['groupId']."'</script>";exit;
            }else{
  				echo "<script>alert('操作失败！');window.location.href='".site_url('/friends/Question/question_expert')."'</script>";exit;
            }
		}else{
			echo $this->load->view('404.html');
		}
	}

	//编辑专家
	function edit_expert(){
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

			//多条件查询
			// $true = $this->Public_model->select_manWhere($this->expert,$data['groupId'],$data['userId']);
			// if(!empty($true)){
			// 	echo "<script>alert('该类别下，专家以存在！');window.location.href='".site_url('/friends/Question/question_expert')."'</script>";exit;
			// }

			
            if($this->Public_model->updata($this->expert,'id',$data['id'],$data)){
            	$log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."编辑了问答分类专家，分类id是：".$data['groupId'].",记录id是：".$data['id'],
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/friends/Question/question_expert/').$data['groupId']."'</script>";exit;
            }else{
  				echo "<script>alert('操作失败！');window.location.href='".site_url('/friends/Question/question_expert')."'</script>";exit;
            }
		}else{
			echo $this->load->view('404.html');
		}
	}

	//删除专家
	function del_expert(){
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
		$id = intval($this->uri->segment('4'));
		if($id == '0'){
			$this->load->view('404.html');
		}else{
			if($this->Public_model->delete($this->expert,'id',$id)){
            	$log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."删除了问答专家,id是：".$id,
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/friends/Question/question_expert')."'</script>";exit;
            }else{
  				echo "<script>alert('操作失败！');window.location.href='".site_url('/friends/Question/question_expert')."'</script>";exit;
            }
		}
	}

}


 ?>