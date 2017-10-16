<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Default_Controller.php');

/*交友*/
/**
* 
*/
class Friends extends Default_Controller
{
	//数据表
	public $circle = "hf_faqs_space";//圈子
	public $dynamic = "hf_friends_news";//动态
	public $label = "hf_friends_lable_group";//标签
    public $member = "hf_user_member";//会员
    public $gift = "hf_friends_gift_group";//礼物

	//页面
	public $view_attract = "friends/circle.html";//圈子
	public $view_circle_news = "friends/circle_news.html";//圈子动态
	public $view_friends_news = "friends/friends_news.html";//交友所有动态
	public $view_friends_circle_news = "friends/friends_circle_news.html";//圈子动态
	public $view_report_news = "friends/report_news.html";//圈子动态
	public $view_lable = "friends/friends_lable.html";//标签
    public $view_friends_member = "friends/friends_member.html";//会员
    public $view_fictitious_goods = "friends/fictitious_goods.html";//虚拟商品
    public $view_friends_dataAudit = 'friends/friends_dataAudit.html';



	function __construct()
	{
		# code...
		parent::__construct();
		$this->load->model('Public_model');
	}  


	//圈子
	function circle(){
        // $data =  strtotime('2017-09-29 00:00:00');
        // var_Dump(strtotime('2017-09-29 00:00:00'));
        // //var_Dump(microtime());
        //  list($msec, $sec) = explode(' ', microtime());
        //  $msectime =  (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
 
        // exit;
      
		$config['per_page'] = 10;
        //获取页码
        $current_page=intval($this->uri->segment(4));//index.php 后数第4个/
        //配置
        $config['base_url'] = site_url('/friends/Friends/circle');
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
        $list = $this->Public_model->select($this->circle,'');

        $config['total_rows'] = count($list);

        // //分页数据
        $listpage = $this->Public_model->select_circle_page($config['per_page'],$current_page);
          $this->load->library('pagination');//加载ci pagination类

            $this->pagination->initialize($config);

        $data = array('lists'=>$listpage,'pages' => $this->pagination->create_links());

        $data['page'] = $this->view_attract;
        $data['menu'] = array('circle','circle');
        $this->load->view('template.html',$data);
	}

	//新增圈子
	function add_circle(){
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
			$data['createUserId'] = $_SESSION['users']['user_id'];
			$header = array("token:".$_SESSION['token'],'city:'.'1');    
			if(!empty($_FILES['img']['name'])){
                    $tmpfile = new CURLFile(realpath($_FILES['img']['tmp_name']));
                
                    $pics = array(
                        'pics' =>$tmpfile,
                        'porfix'=>'friends/circle',
                        'bucket'=>BUCKET,
                    );
				
					$qiuniu = json_decode(curl_post_express($header,QINIUUPLOAD,$pics),true);

					if($qiuniu['errno'] == '0'){
						$img = json_decode($qiuniu['data']['img'],true);
						$icon[]['picImg'] =$img[0]['picImg'];
						$data['picImg'] = json_encode($icon);
					}else{
					  echo "<script>alert('图片上传失败！');window.location.href='".site_url('/friends/Friends/circle')."'</script>";exit;
					}
            }
            if($this->Public_model->insert($this->circle,$data)){
            	$log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."新增了圈子，圈子名称是：".$data['name'],
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                				$this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/friends/Friends/circle')."'</script>";exit;
            }else{
  				echo "<script>alert('操作失败！');window.location.href='".site_url('/friends/Friends/circle')."'</script>";exit;
            }
		}else{
			$this->load->view('404.html');
		}
	}

	//编辑
	function edit_circle(){
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
                        'porfix'=>'friends/circle',
                        'bucket'=>BUCKET,
                    );
				
					$qiuniu = json_decode(curl_post_express($header,QINIUUPLOAD,$pics),true);

					if($qiuniu['errno'] == '0'){
						$img = json_decode($qiuniu['data']['img'],true);
						$icon[]['picImg'] =$img[0]['picImg'];
						$data['picImg'] = json_encode($icon);
					}else{
					  echo "<script>alert('图片上传失败！');window.location.href='".site_url('/friends/Friends/circle')."'</script>";exit;
					}
            }
            if($this->Public_model->updata($this->circle,'id',$data['id'],$data)){
            	$log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."编辑了圈子，圈子名称是：".$data['name'],
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                				$this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/friends/Friends/circle')."'</script>";exit;
            }else{
  				echo "<script>alert('操作失败！');window.location.href='".site_url('/friends/Friends/circle')."'</script>";exit;
            }

		}else{
			$this->load->view('404.html');
		}
	}

	//删除圈子
	function del_circle(){
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
		$id = intval($this->uri->segment('4'));
		if($id == '0'){
			$this->load->view('404.html');
		}else{
			if($this->Public_model->delete($this->circle,'id',$id)){
				$log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."编辑了圈子，圈子名称是：".$data['name'],
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),
                );
                				$this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/friends/Friends/circle')."'</script>";exit;
			}else{
				echo "<script>alert('操作失败！');window.location.href='".site_url('/friends/Friends/circle')."'</script>";exit;

			}
		}
	}

	//查看圈子帖子
	function circle_news(){
		$id = intval($this->uri->segment(4));
		$config['per_page'] = 10;
        //获取页码
        $current_page=intval($this->uri->segment(5));//index.php 后数第4个/
        //配置
        $config['base_url'] = site_url('/friends/Friends/circle/'.$id);
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
        $list = $this->Public_model->select_where($this->dynamic,'spaceType',$id,'');

        $config['total_rows'] = count($list);

        // //分页数据
        $listpage = $this->Public_model->select_circle_news_page('spaceType',$id,$config['per_page'],$current_page);
          $this->load->library('pagination');//加载ci pagination类

            $this->pagination->initialize($config);

        $data = array('lists'=>$listpage,'pages' => $this->pagination->create_links(),'spaceType'=>$id);

        $data['page'] = $this->view_circle_news;
        $data['menu'] = array('circle','circle');
        $this->load->view('template.html',$data);
	}

	//交友dongtai 
	function dynamic(){
		$config['per_page'] = 10;
        //获取页码
        $current_page=intval($this->uri->segment(4));//index.php 后数第4个/
        //配置
        $config['base_url'] = site_url('/friends/Friends/dynamic');
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
        $list = $this->Public_model->select_where($this->dynamic,'typeId','1','');

        $config['total_rows'] = count($list);

        // //分页数据
        $listpage = $this->Public_model->select_news_page('typeId','1',$config['per_page'],$current_page,'create_time');
          $this->load->library('pagination');//加载ci pagination类

            $this->pagination->initialize($config);

        $data = array('lists'=>$listpage,'pages' => $this->pagination->create_links());

        $data['page'] = $this->view_friends_news;
        $data['menu'] = array('friends','dynamic');
        $this->load->view('template.html',$data);
	}

	//圈子动态
	function friends_circle_news(){
		$config['per_page'] = 10;
        //获取页码
        $current_page=intval($this->uri->segment(4));//index.php 后数第4个/
        //配置
        $config['base_url'] = site_url('/friends/Friends/friends_circle_news');
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
        $list = $this->Public_model->select_where($this->dynamic,'typeId','3','');

        $config['total_rows'] = count($list);

        // //分页数据
        $listpage = $this->Public_model->select_news_page('typeId','3',$config['per_page'],$current_page,'create_time');
          $this->load->library('pagination');//加载ci pagination类

            $this->pagination->initialize($config);

        $data = array('lists'=>$listpage,'pages' => $this->pagination->create_links());

        $data['page'] = $this->view_friends_circle_news;
        $data['menu'] = array('friends','friends_circle_news');
        $this->load->view('template.html',$data);

	}

	//举报帖子
	function report(){
		$config['per_page'] = 10;
        //获取页码
        $current_page=intval($this->uri->segment(4));//index.php 后数第4个/
        //配置
        $config['base_url'] = site_url('/friends/Friends/report');
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
        $list = $this->Public_model->select_where($this->dynamic,'typeId','5','id');

        $config['total_rows'] = count($list);

        // //分页数据
        $listpage = $this->Public_model->select_news_page('typeId','5',$config['per_page'],$current_page,'report_time');
          $this->load->library('pagination');//加载ci pagination类

            $this->pagination->initialize($config);

        $data = array('lists'=>$listpage,'pages' => $this->pagination->create_links());

        $data['page'] = $this->view_report_news;
        $data['menu'] = array('friends','report');
        $this->load->view('template.html',$data);

	}

    //圈子举报动态
    function report_circle(){
        $config['per_page'] = 10;
        //获取页码
        $current_page=intval($this->uri->segment(4));//index.php 后数第4个/
        //配置
        $config['base_url'] = site_url('/friends/Friends/report');
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
        $list = $this->Public_model->select_where($this->dynamic,'typeId','5','id');

        $config['total_rows'] = count($list);

        // //分页数据
        $listpage = $this->Public_model->select_news_page('typeId','5',$config['per_page'],$current_page,'report_time');
          $this->load->library('pagination');//加载ci pagination类

            $this->pagination->initialize($config);

        $data = array('lists'=>$listpage,'pages' => $this->pagination->create_links());

        $data['page'] = $this->view_report_news;
        $data['menu'] = array('friends','report');
        $this->load->view('template.html',$data);
    }




	//新增动态
	function add_friends_news(){
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
		if($_POST){
			$data = $this->input->post();
			$data['userid'] = $_SESSION['users']['user_id'];
			$header = array("token:".$_SESSION['token'],'city:'.'1');    
			if(!empty($_FILES['img']['name'])){
                    $tmpfile = new CURLFile(realpath($_FILES['img']['tmp_name']));
                
                    $pics = array(
                        'pics' =>$tmpfile,
                        'porfix'=>'friends/circle/news',
                        'bucket'=>BUCKET,
                    );
				
					$qiuniu = json_decode(curl_post_express($header,QINIUUPLOAD,$pics),true);

					if($qiuniu['errno'] == '0'){
						$img = json_decode($qiuniu['data']['img'],true);
						$icon[]['picImg'] =$img[0]['picImg'];
						$data['pic'] = json_encode($icon);
					}else{
					  echo "<script>alert('图片上传失败！');window.location.href='".site_url('/friends/Friends/dynamic')."'</script>";exit;
					}
            }
            if($this->Public_model->insert($this->dynamic,$data)){
            	$log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."新增了交友动态，动态内容是：".$data['content'],
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                				$this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/friends/Friends/dynamic')."'</script>";exit;	
            }else{
  				echo "<script>alert('操作失败！');window.location.href='".site_url('/friends/Friends/dynamic')."'</script>";exit;
            }
		}else{
			$this->load->view('404.html');
		}
	}

	//编辑动态
	function edit_friends_news(){
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
		if($_POST){
			$data = $this->input->post();
			$header = array("token:".$_SESSION['token'],'city:'.'1');    
			if(!empty($_FILES['img']['name'])){
                    $tmpfile = new CURLFile(realpath($_FILES['img']['tmp_name']));
                
                    $pics = array(
                        'pics' =>$tmpfile,
                        'porfix'=>'friends/circle/news',
                        'bucket'=>BUCKET,
                    );
				
					$qiuniu = json_decode(curl_post_express($header,QINIUUPLOAD,$pics),true);

					if($qiuniu['errno'] == '0'){
						$img = json_decode($qiuniu['data']['img'],true);
						$icon[]['picImg'] =$img[0]['picImg'];
						$data['pic'] = json_encode($icon);
					}else{
					  echo "<script>alert('图片上传失败！');window.location.href='".site_url('/friends/Friends/dynamic')."'</script>";exit;
					}
            }
            if($this->Public_model->updata($this->dynamic,'id',$data['id'],$data)){
            	$log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."编辑了交友动态，动态id是：".$data['id'],
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                				$this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/friends/Friends/dynamic')."'</script>";exit;
            }else{
  				echo "<script>alert('操作失败！');window.location.href='".site_url('/friends/Friends/dynamic')."'</script>";exit;
            }
		}else{
			$this->load->view('404.html');
		}
	}

	//删除动态
	function del_friends_news(){
		// $q= $this->uri->uri_string();
		// $url = preg_replace('|[0-9]+|','',$q);
		// if(substr($url,-1) == '/'){
		// 	$url = substr($url,0,-1);
		// }
		// $user_power = json_decode($_SESSION['user_power'],TRUE);
		// if(!deep_in_array($url,$user_power)){
		// 	echo "<script>alert('您暂无权限执行此操作！请联系系统管理员。');window.history.go(-1);</script>";exit;
		// }
		$id = intval($this->uri->segment('4'));
		if($id == '0'){
			$this->load->view('404.html');
		}else{
			if($this->Public_model->delete($this->dynamic,'id',$id)){
				$log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."删除了交友动态,动态id是：".$id,
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                				$this->db->insert('hf_system_journal',$log);


				echo "<script>alert('操作成功！');window.location.href='".site_url('/friends/Friends/dynamic')."'</script>";exit;
			}else{
  				echo "<script>alert('操作失败！');window.location.href='".site_url('/friends/Friends/dynamic')."'</script>";exit;
			}
		}



	}




	//新增动态
	function add_circle_news(){
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
		if($_POST){
			$data = $this->input->post();
			$data['userid'] = $_SESSION['users']['user_id'];
			$header = array("token:".$_SESSION['token'],'city:'.'1');    
			if(!empty($_FILES['img']['name'])){
                    $tmpfile = new CURLFile(realpath($_FILES['img']['tmp_name']));
                
                    $pics = array(
                        'pics' =>$tmpfile,
                        'porfix'=>'friends/circle/news',
                        'bucket'=>BUCKET,
                    );
				
					$qiuniu = json_decode(curl_post_express($header,QINIUUPLOAD,$pics),true);

					if($qiuniu['errno'] == '0'){
						$img = json_decode($qiuniu['data']['img'],true);
						$icon[]['picImg'] =$img[0]['picImg'];
						$data['pic'] = json_encode($icon);
					}else{
					  echo "<script>alert('图片上传失败！');window.location.href='".site_url('/friends/Friends/circle')."'</script>";exit;
					}
            }
            if($this->Public_model->insert($this->dynamic,$data)){
            	$log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."新增了圈子动态，圈子id是：".$data['spaceType'],
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                				$this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/friends/Friends/circle_news/').$data['spaceType']."'</script>";exit;	
            }else{
  				echo "<script>alert('操作失败！');window.location.href='".site_url('/friends/Friends/circle_news/').$data['spaceType']."'</script>";exit;
            }
		}else{
			$this->load->view('404.html');
		}
	}

	//编辑动态
	function edit_circle_news(){
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
		if($_POST){
			$data = $this->input->post();
			$header = array("token:".$_SESSION['token'],'city:'.'1');    
			if(!empty($_FILES['img']['name'])){
                    $tmpfile = new CURLFile(realpath($_FILES['img']['tmp_name']));
                
                    $pics = array(
                        'pics' =>$tmpfile,
                        'porfix'=>'friends/circle/news',
                        'bucket'=>BUCKET,
                    );
				
					$qiuniu = json_decode(curl_post_express($header,QINIUUPLOAD,$pics),true);

					if($qiuniu['errno'] == '0'){
						$img = json_decode($qiuniu['data']['img'],true);
						$icon[]['picImg'] =$img[0]['picImg'];
						$data['pic'] = json_encode($icon);
					}else{
					  echo "<script>alert('图片上传失败！');window.location.href='".site_url('/friends/Friends/circle')."'</script>";exit;
					}
            }
            if($this->Public_model->updata($this->dynamic,'id',$data['id'],$data)){
            	$log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."编辑了圈子动态，圈子id是：".$data['spaceType'].',动态id是：'.$data['id'],
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                				$this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/friends/Friends/circle_news/').$data['spaceType']."'</script>";exit;
            }else{
  				echo "<script>alert('操作失败！');window.location.href='".site_url('/friends/Friends/circle_news/').$data['spaceType']."'</script>";exit;
            }
		}else{
			$this->load->view('404.html');
		}
	}

    //回复动态显示
    function edit_news_state(){
        $id = intval($this->uri->segment('4'));
        $state = intval($this->uri->segment('5'));

        if($id == "0" || $state == "0"){
            $this->load->view('404.html');
        }else{
            $data['typeId'] = $state;
            if($this->Public_model->updata($this->dynamic,'id',$id,$data)){
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."恢复了举报动态,动态id是：".$id,
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/friends/Friends/report')."'</script>";exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/friends/Friends/report')."'</script>";exit;
            }
        }
    }


	//删除动态
	function del_circle_news(){
		$q= $this->uri->uri_string();
		$url = preg_replace('|[0-9]+|','',$q);
		if(substr($url,-1) == '/'){
			$url = substr($url,0,-1);
		}
		$user_power = json_decode($_SESSION['user_power'],TRUE);
		if(!deep_in_array($url,$user_power)){
			echo "<script>alert('您暂无权限执行此操作！请联系系统管理员。');window.history.go(-1);</script>";exit;
		}
		$id = intval($this->uri->segment('4'));
		$spaceType = intval($this->uri->segment('5'));
		if($id == '0'){
			$this->load->view('404.html');
		}else{
			if($this->Public_model->delete($this->dynamic,'id',$id)){
				$log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."删除了圈子动态，圈子id是：".$spaceType.',动态id是：'.$id,
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
               	$this->db->insert('hf_system_journal',$log);

				echo "<script>alert('操作成功！');window.location.href='".site_url('/friends/Friends/circle_news/').$spaceType."'</script>";exit;
			}else{
  				echo "<script>alert('操作失败！');window.location.href='".site_url('/friends/Friends/circle_news/').$spaceType."'</script>";exit;
			}
		}

	}

	
    
	//标签
	function label(){
		$config['per_page'] = 10;
        //获取页码
        $current_page=intval($this->uri->segment(4));//index.php 后数第4个/
        //配置
        $config['base_url'] = site_url('/friends/Friends/goddess');
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
        $list = $this->Public_model->select($this->label,'');

        $config['total_rows'] = count($list);

        // //分页数据
        $listpage = $this->Public_model->select_lable($config['per_page'],$current_page);
          $this->load->library('pagination');//加载ci pagination类

            $this->pagination->initialize($config);

        $data = array('lists'=>$listpage,'pages' => $this->pagination->create_links());

        $data['page'] = $this->view_lable;
        $data['menu'] = array('friends','lable');
        $this->load->view('template.html',$data);
	}

	//新增tag标签
	function add_lable(){
		$q= $this->uri->uri_string();
		$url = preg_replace('|[0-9]+|','',$q);
		if(substr($url,-1) == '/'){
			$url = substr($url,0,-1);
		}
		$user_power = json_decode($_SESSION['user_power'],TRUE);
		if(!deep_in_array($url,$user_power)){
			echo "<script>alert('您暂无权限执行此操作！请联系系统管理员。');window.history.go(-1);</script>";exit;
		}
		if($_POST){
			$data = $this->input->post();
			$data['createUserId'] = $_SESSION['users']['user_id'];
			if($this->Public_model->insert($this->label,$data)){
				$log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."新增了TAG标签,标签名称是：".$data['lableName'],
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
				$this->db->insert('hf_system_journal',$log);

				echo "<script>alert('操作成功！');window.location.href='".site_url('/friends/Friends/label')."'</script>";exit;
			}else{
				echo "<script>alert('操作失败！');window.location.href='".site_url('/friends/Friends/label')."'</script>";exit;

			}

		}else{
			$this->load->view('404.html');
		}
	}
	//编辑标签
	function edit_lable(){
		$q= $this->uri->uri_string();
		$url = preg_replace('|[0-9]+|','',$q);
		if(substr($url,-1) == '/'){
			$url = substr($url,0,-1);
		}
		$user_power = json_decode($_SESSION['user_power'],TRUE);
		if(!deep_in_array($url,$user_power)){
			echo "<script>alert('您暂无权限执行此操作！请联系系统管理员。');window.history.go(-1);</script>";exit;
		}
		if($_POST){
			$data = $this->input->post();
			$data['createUserId'] = $_SESSION['users']['user_id'];
			if($this->Public_model->updata($this->label,'id',$data['id'],$data)){
				$log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."编辑了TAG标签,标签id是".$data['id'].",标签名称是：".$data['lableName'],
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
				$this->db->insert('hf_system_journal',$log);

				echo "<script>alert('操作成功！');window.location.href='".site_url('/friends/Friends/label')."'</script>";exit;
			}else{
				echo "<script>alert('操作失败！');window.location.href='".site_url('/friends/Friends/label')."'</script>";exit;

			}

		}else{
			$this->load->view('404.html');
		}
	}

	//删除标签
	function del_lable(){
		$q= $this->uri->uri_string();
		$url = preg_replace('|[0-9]+|','',$q);
		if(substr($url,-1) == '/'){
			$url = substr($url,0,-1);
		}
		$user_power = json_decode($_SESSION['user_power'],TRUE);
		if(!deep_in_array($url,$user_power)){
			echo "<script>alert('您暂无权限执行此操作！请联系系统管理员。');window.history.go(-1);</script>";exit;
		}
		$id = intval($this->uri->segment('4'));
		if($id == "0"){
			$this->load->view('404.html');
		}else{
			if($this->Public_model->delete($this->label,'id',$id)){
				$log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."删除了TAG标签,标签id是".$id,
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
				$this->db->insert('hf_system_journal',$log);

				echo "<script>alert('操作成功！');window.location.href='".site_url('/friends/Friends/label')."'</script>";exit;
			}else{
				echo "<script>alert('操作失败！');window.location.href='".site_url('/friends/Friends/label')."'</script>";exit;

			}
		}
	}
	
    //会员列表
    function friends_member(){
        $config['per_page'] = 10;
        //获取页码
        $current_page=intval($this->uri->segment(4));//index.php 后数第4个/
        //配置
        $config['base_url'] = site_url('/friends/Friends/friends_member');
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
        $list = $this->Public_model->select_frirnds_user();

        $config['total_rows'] = count($list);

        //获取今日的注册用户

        $member = $this->Public_model->ret_new_member();
        // //分页数据
        $listpage = $this->Public_model->select_frirnds_user_page($config['per_page'],$current_page);
        $this->load->library('pagination');//加载ci pagination类

        $this->pagination->initialize($config);

        $data = array('lists'=>$listpage,'pages' => $this->pagination->create_links(),'userNum'=>count($list),'newNum'=>count($member));

        $data['page'] = $this->view_friends_member;
        $data['menu'] = array('friends','friends_member');
        $this->load->view('template.html',$data);

    }

    //编辑信息
    function edit_friends_member(){
        if($_POST){

        }else{
            $this->load->view('404.html');
        }
    }

    //男神榜
    function schoolboy(){
        $config['per_page'] = 10;
        //获取页码
        $current_page=intval($this->uri->segment(4));//index.php 后数第4个/
        //配置
        $config['base_url'] = site_url('/friends/Friends/schoolboy');
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
        $list = $this->Public_model->select_where_member($this->member,'gender','1','resommendOnHomeIndex');

        $config['total_rows'] = count($list);
 
        // //分页数据
        $listpage = $this->Public_model->select_where_member_page($this->member,'gender','1',$config['per_page'],$current_page,'resommendOnHomeIndex');
        $this->load->library('pagination');//加载ci pagination类

        $this->pagination->initialize($config);

        $data = array('lists'=>$listpage,'pages' => $this->pagination->create_links(),'userNum'=>count($list));

        $data['page'] = $this->view_friends_member;
        $data['menu'] = array('friends','schoolboy');
        $this->load->view('template.html',$data);
    }

    //女神榜
    function goddess(){
         $config['per_page'] = 10;
        //获取页码
        $current_page=intval($this->uri->segment(4));//index.php 后数第4个/
        //配置
        $config['base_url'] = site_url('/friends/Friends/goddess');
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
        $list = $this->Public_model->select_where_member($this->member,'gender','2','');

        $config['total_rows'] = count($list);
 
        // //分页数据
        $listpage = $this->Public_model->select_where_member_page($this->member,'gender','2',$config['per_page'],$current_page,'resommendOnHomeIndex');
        $this->load->library('pagination');//加载ci pagination类

        $this->pagination->initialize($config);

        $data = array('lists'=>$listpage,'pages' => $this->pagination->create_links(),'userNum'=>count($list));

        $data['page'] = $this->view_friends_member;
        $data['menu'] = array('friends','goddess');
        $this->load->view('template.html',$data);
    }

    //推荐榜
    function recomment(){
        $config['per_page'] = 10;
        //获取页码
        $current_page=intval($this->uri->segment(4));//index.php 后数第4个/
        //配置
        $config['base_url'] = site_url('/friends/Friends/recomment');
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
        $list = $this->Public_model->select_where($this->member,'recommend','1','');

        $config['total_rows'] = count($list);
 
        // //分页数据
        $listpage = $this->Public_model->select_where_member_page($this->member,'recommend','1',$config['per_page'],$current_page,'resommendOnHomeIndex');
        $this->load->library('pagination');//加载ci pagination类

        $this->pagination->initialize($config);

        $data = array('lists'=>$listpage,'pages' => $this->pagination->create_links(),'userNum'=>count($list),'recomd'=>
            '1');

        $data['page'] = $this->view_friends_member;
        $data['menu'] = array('friends','recomment');
        $this->load->view('template.html',$data);
    }


    //推荐到推荐榜
    function edit_recommend_state(){
        $id = intval($this->uri->segment('4'));
        $state = intval($this->uri->segment('5'));
        if($id == "0" || $state == "0"){
            $this->load->view('404.html');
        }else{
            if($state == "1"){
                $data['recommend'] = '1';
                $title = "推荐了会员到推荐榜展示";
            }else{
                $data['recommend'] = '0';
                $title ="取消了会员在推荐榜展示";
            }
            if($this->Public_model->updata($this->member,'user_id',$id,$data)){
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username'].$title.",会员id是".$id,
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.history.go(-1);</script>";exit;
            }else{
                echo "<script>alert('操作失败！');window.history.go(-1);</script>";exit;
            }
        }
    }
    //推荐到APP首页
    function recommend_home(){
        $id = intval($this->uri->segment('4'));
        $state = intval($this->uri->segment('5'));
        if($id == "0" || $state == "0"){
            $this->load->view('404.html');
        }else{
            if($state == "1"){
                $data['resommendOnHome'] = '1';
                $title = "推荐了会员到APP首页展示";
            }else{
                $data['resommendOnHome'] = '0';
                $title ="取消了会员在APP首页展示";
            }
            if($this->Public_model->updata($this->member,'user_id',$id,$data)){
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username'].$title.",会员id是".$id,
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.history.go(-1);</script>";exit;
            }else{
                echo "<script>alert('操作失败！');window.history.go(-1);</script>";exit;
            }
        }
    }



    //虚拟商品
    function fictitious_goods(){
        $data['lists'] = $this->Public_model->select($this->gift,'id');
        $data['page'] = $this->view_fictitious_goods;
        $data['menu'] = array('friends','fictitious_goods');
        $this->load->view('template.html',$data);
    }

    //新增虚拟礼物
    function add_fictitious(){
        if($_POST){
            $data = $this->input->post();
            $header = array("token:".$_SESSION['token'],'city:'.'1');    
            if(!empty($_FILES['img']['name'])){
                    $tmpfile = new CURLFile(realpath($_FILES['img']['tmp_name']));
                
                    $pics = array(
                        'pics' =>$tmpfile,
                        'porfix'=>'friends/fictitious/goods',
                        'bucket'=>'cqcfriends',
                    );
                
                    $qiuniu = json_decode(curl_post_express($header,QINIUUPLOAD,$pics),true);

                    if($qiuniu['errno'] == '0'){
                        $img = json_decode($qiuniu['data']['img'],true);
                        $icon[]['picImg'] =$img[0]['picImg'];
                        $data['picImg'] = json_encode($icon);
                    }else{
                      echo "<script>alert('图片上传失败！');window.location.href='".site_url('/friends/Friends/fictitious_goods')."'</script>";exit;
                    }
            }
            if($this->Public_model->insert($this->gift,$data)){
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."新增了虚拟礼物,礼物标题是".$data['title'],
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/friends/Friends/fictitious_goods')."'</script>";exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/friends/Friends/fictitious_goods')."'</script>";exit;
            }
        }else{
            $this->load->view('404.html');
        }
    }

    //编辑虚拟商品
    function edit_fictitious(){
        if($_POST){
            $data = $this->input->post();
            $header = array("token:".$_SESSION['token'],'city:'.'1');    
            if(!empty($_FILES['img']['name'])){
                    $tmpfile = new CURLFile(realpath($_FILES['img']['tmp_name']));
                
                    $pics = array(
                        'pics' =>$tmpfile,
                        'porfix'=>'friends/fictitious/goods',
                        'bucket'=>'cqcfriends',
                    );
                
                    $qiuniu = json_decode(curl_post_express($header,QINIUUPLOAD,$pics),true);

                    if($qiuniu['errno'] == '0'){
                        $img = json_decode($qiuniu['data']['img'],true);
                        $icon[]['picImg'] =$img[0]['picImg'];
                        $data['picImg'] = json_encode($icon);
                    }else{
                      echo "<script>alert('图片上传失败！');window.location.href='".site_url('/friends/Friends/fictitious_goods')."'</script>";exit;
                    }
            }
            if($this->Public_model->updata($this->gift,'id',$data['id'],$data)){
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."编辑了虚拟礼物,礼物标题是".$data['title'],
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/friends/Friends/fictitious_goods')."'</script>";exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/friends/Friends/fictitious_goods')."'</script>";exit;
            }
        }else{
            $this->load->view('404.html');
        }
    }

    //删除虚拟商品
    function del_fictitius(){
        $id = intval($this->uri->segment(4));
        if($id == '0'){
            $this->load->view('404.html');

        }else{
             if($this->Public_model->delete($this->gift,'id',$id)){
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."编辑了虚拟礼物,礼物id是".$id,
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/friends/Friends/fictitious_goods')."'</script>";exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/friends/Friends/fictitious_goods')."'</script>";exit;
            }
        }
    }

    //男神女神搜索
    function search_friends(){
        $config['per_page'] = 10;
        //获取页码
        $current_page=intval($this->input->get("size"));//index.php 后数第4个/

        $age = $this->input->get('ages');
        $startTime = $this->input->get('begin_time');
        $endTime = $this->input->get('end_time');
        $sear = $this->input->get('sear');
        $gender = $this->input->get('gender');
        // var_dump($_GET);

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



        $list = friends_member_search($age,$gender,$startTime,$endTime,$sear);
       // var_dump($startTime);
       //  var_dump($endTime);
       //  var_dump($list);
       //  var_dump($gender);
       //  exit;

        $config['total_rows'] = count($list);

        $config['page_query_string'] = TRUE;//关键配置
        // $config['reuse_query_string'] = FALSE;
        $config['query_string_segment'] = 'size';
        $config['base_url'] = site_url('/friends/Friends/search_friends?').'ages='.$age.'&gender='.$gender.'&begin_time='.$startTime.'&end_time='.$endTime.'&sear='.$sear;

        // //分页数据
        $listpage = friends_member_search_page($age,$gender,$startTime,$endTime,$sear,$config['per_page'],$current_page);
        $this->load->library('pagination');//加载ci pagination类

        $this->pagination->initialize($config);

        $data = array('lists'=>$listpage,'pages' => $this->pagination->create_links(),'userNum'=>count($list));
        // var_dump($data);
        // exit;

        $data['page'] = $this->view_friends_member;
        $data['menu'] = array('friends','friends_member');
        $this->load->view('template.html',$data);
    }


    //审核交友照片
    function data_audit(){
        $config['per_page'] = 10;
        //获取页码
        $current_page=intval($this->uri->segment(4));//index.php 后数第4个/
        //配置
        $config['base_url'] = site_url('/friends/Friends/data_audit');
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
        $list = $this->Public_model->select_where('hf_friends_my_photo','needReview','0','');

        $config['total_rows'] = count($list);
 
        // //分页数据
        $listpage = $this->Public_model->select_friends_dataAudit('0',$config['per_page'],$current_page);
        $this->load->library('pagination');//加载ci pagination类

        $this->pagination->initialize($config);

        $data = array('lists'=>$listpage,'pages' => $this->pagination->create_links(),'userNum'=>count($list),'recomd'=>
            '1');

        $data['page'] = $this->view_friends_dataAudit;
        $data['menu'] = array('friends','data_audit');
        $this->load->view('template.html',$data);

    }


    //修改交友资料状态
    function edit_dataAudit(){
        $id = intval($this->uri->segment(4));

        if($id == '0'){
            $this->load->view('404.html');
        }else{
            $data['needReview'] = '1';
            if($this->Public_model->updata('hf_friends_my_photo','id',$id,$data)){
                 $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."审核通过了一个交友照片,id是".$id,
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/friends/Friends/data_audit')."'</script>";exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/friends/Friends/data_audit')."'</script>";exit;

            }

        }
    }
    //删除交友资料
    function del_dataAudit(){
        $id = intval($this->uri->segment(4));

        if($id == '0'){
            $this->load->view('404.html');
        }else{
            if($this->Public_model->delete('hf_friends_my_photo','id',$id)){
                 $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."删除了一个交友照片,id是".$id,
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/friends/Friends/data_audit')."'</script>";exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/friends/Friends/data_audit')."'</script>";exit;

            }

        }
    }

    //修改会员排序
    function edit_member_info(){
        if($_POST){
            $data = $this->input->post();
            $header = array("token:".$_SESSION['token'],'city:'.'1');    
            if(!empty($_FILES['img']['name'])){
                    $tmpfile = new CURLFile(realpath($_FILES['img']['tmp_name']));
                
                    $pics = array(
                        'pics' =>$tmpfile,
                        'porfix'=>'friends/fictitious/avatar',
                        'bucket'=>'cqcfriends',
                    );
                
                    $qiuniu = json_decode(curl_post_express($header,QINIUUPLOAD,$pics),true);

                    if($qiuniu['errno'] == '0'){
                        $img = json_decode($qiuniu['data']['img'],true);
                        $icon[]['picImg'] =$img[0]['picImg'];
                        $data['avatar'] = json_encode($icon);
                    }else{
                      echo "<script>alert('图片上传失败！');window.history.go(-1);</script>";exit;
                    }
            }
            if($this->Public_model->updata($this->member,"user_id",$data['user_id'],$data)){
                 $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."修改了用户信息,用户id是".$data['user_id'],
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.history.go(-1);</script>";exit;
            }else{
                echo "<script>alert('操作失败！');window.history.go(-1);</script>";exit;

            }
        }else{
            $this->load->view('404.html');
        }
    }
     function edit_member_sort(){
        if($_POST){
            $data = $this->input->post();

            if($this->Public_model->updata($this->member,"user_id",$data['user_id'],$data)){
                 $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."修改了用户排序,用户id是".$data['user_id'],
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.history.go(-1);</script>";exit;
            }else{
                echo "<script>alert('操作失败！');window.history.go(-1);</script>";exit;

            }
        }else{
            $this->load->view('404.html');
        }
    }



    //统计信息
    function statistics(){
        
    }



	
}


 ?>