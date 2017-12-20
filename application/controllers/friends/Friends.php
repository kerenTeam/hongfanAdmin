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
        $data['menu'] = array('friends','circle');
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
        $data['menu'] = array('friends','circle');
        $this->load->view('template.html',$data);
	}

	//交友dongtai 
	function dynamic(){
	
        $data['page'] = $this->view_friends_news;
        $data['menu'] = array('friends','dynamic');
        $this->load->view('template.html',$data);
	}

    //返回交友动态
    function retFriendsNews(){
        if($_POST){
            $start = $this->input->post('start');
            if($start != '0'){
                $_SESSION['friendsNews'] = $start;
            }
            // var_dump($_SESSION['pageNum']);
            $count = $this->input->post('count');
            $list = $this->Public_model->select_where($this->dynamic,'typeId','1','');

            $listpage = $this->Public_model->select_news_page('typeId','1',$count,$start,'create_time');

            if(!empty($listpage)){
                echo json_encode(['total'=>count($list),'subjects'=>$listpage]);
            }else{
                echo "2";
            }
        }else{
            echo "2";
        }
    }

    //发放HI豆
    function grantHidou(){
        $id = intval($this->uri->segment('4'));
        if($id == '0'){
            echo "<script>alert('请求错误！');window.history.go(-1);</script>";
            exit;
        }else{
            $news = $this->Public_model->select_where_info($this->dynamic,'id',$id);

            //获取用户今天以奖励的纪录
            $time =date('Y-m-d',strtotime($news['create_time']));
            $today = $this->Public_model->selectToday($this->dynamic,'1','userid',$news['userid'],$time);

            if(count($today) >= get_option('dynamicNum')){
                echo "<script>alert('该用户今天发放的HI豆已达上限！');window.history.go(-1);</script>";
                exit;
            }else{
                //获取用户hidou
                $user = $this->Public_model->select_where_info($this->member,'user_id',$news['userid']);
                $data['intergral'] = $user['intergral']+get_option('dynamicPrice');
                if($this->Public_model->updata($this->member,'user_id',$news['userid'],$data)){
                    $arr['award'] = '2'; 
                    $this->Public_model->updata($this->dynamic,'id',$id,$arr);

                    echo "<script>alert('发放成功！');window.history.go(-1);</script>";
                    exit;

                }else{
                    echo "<script>alert('发放失败！');window.history.go(-1);</script>";
                    exit;
                }
            }
        }
    }




	//举报帖子
	function report(){
		
        $data['page'] = $this->view_report_news;
        $data['menu'] = array('friends','report');
        $this->load->view('template.html',$data);

	}

    //返回举报帖子
    function retReport(){
        if($_POST){
            $sear = $this->input->post('sear');
            $start = $this->input->post('start');
            // if($start != '0'){
                $_SESSION['reportNews'] = $start;
            // }
            // var_dump($_SESSION['pageNum']);
            $size = $this->input->post('count');
            if(empty($sear)){
                $list = $this->Public_model->select_where($this->dynamic,'typeId','5','id');
                $listpage = $this->Public_model->select_news_page('typeId','5',$size,$start,'report_time');
            }else{
                $query = $this->db->where('typeId','5')->like('content',$sear,'both')->get($this->dynamic);
                $list = $query->result_array();
                // $list = ($res);
                //
                $query1 = $this->db->where('typeId','5')->like('content',$sear,'both')->order_by('report_time','desc')->limit($size,$start)->get($this->dynamic);
                $listpage = $query1->result_array();
            }

            if(!empty($listpage)){
                echo json_encode(['total'=>count($list),'subjects'=>$listpage]);
            }else{
                echo "2";
            }
        }
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
        $list = $this->Public_model->select_frirnds_user();
        //获取今日的注册用户
        $member = $this->Public_model->ret_new_member();
        // //分页数据
        $data = array('userNum'=>count($list),'newNum'=>count($member));
        $data['page'] = $this->view_friends_member;
        $data['menu'] = array('friends','friends_member');
        $this->load->view('template.html',$data);

    }

    //交友会员
    function searchFriendsMember(){
        if($_POST){
            $age = $this->input->post('ages');
            $startTime = $this->input->post('begin_time');
            $endTime = $this->input->post('end_time');
            $sear = $this->input->post('sear');
            $gender = $this->input->post('gender');

            $page = $this->input->post('start');
            // if($page != '0'){
                $_SESSION['fmNum'] = $page;
            // }
            $size = $this->input->post('count');
            $list = friends_member_search($age,$gender,$startTime,$endTime,$sear);
            $listpage = friends_member_search_page($age,$gender,$startTime,$endTime,$sear,$size,$page);

            if(!empty($listpage)){
                echo json_encode(['total'=>count($list),'subjects'=>$listpage]);
            }else{
                echo "2";
            }

        }
    }
    //男神榜
    function schoolboy(){
    
        $list = $this->Public_model->select_where_member($this->member,'gender','1','resommendOnHomeIndex');
        $data = array('userNum'=>count($list),'gender'=>'1');

        $data['page'] = 'friends/makeFriends.html';
        $data['menu'] = array('friends','schoolboy');
        $this->load->view('template.html',$data);
    }

    //女神榜
    function goddess(){

        $list = $this->Public_model->select_where_member($this->member,'gender','2','');

        $data = array('userNum'=>count($list),'gender'=>'2');

        $data['page'] = 'friends/makeFriends.html';
        $data['menu'] = array('friends','goddess');
        $this->load->view('template.html',$data);
    }

    //推荐榜
    function recomment(){

        $list = $this->Public_model->select_where_member($this->member,'recommend','1','');

       
        $data = array('userNum'=>count($list),'recomd'=>
            '1');

        $data['page'] = 'friends/friends_recommend.html';
        $data['menu'] = array('friends','recomment');
        $this->load->view('template.html',$data);
    }
    //返回推荐表用户信息
    function retFriendsRecommend(){
        if($_POST){
            $page = $this->input->post('start');
           
            $_SESSION['fmrecom'] = $page;
            $size = $this->input->post('count');

            $list = $this->Public_model->select_where_member($this->member,'recommend','1','');
            $listpage = $this->Public_model->select_where_member_page($this->member,'recommend','1',$size,$page,'resommendOnHomeIndex');
            if(!empty($listpage)){
                echo json_encode(['total'=>count($list),'subjects'=>$listpage]);
            }else{
                echo "2";
            }
        }
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

    //APP首页推荐
    function appHomeFriends(){

        $list = $this->Public_model->select_where_member($this->member,'recommend','1','');
        $data = array('userNum'=>count($list),'recomd'=>
            '1');
        $data['page'] = 'friends/friends_recommend.html';
        $data['menu'] = array('friends','recomment');
        $this->load->view('template.html',$data);

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

    //审核交友资料
    function edit_dataState(){
        if($_POST){
            $id = $this->input->post('id');
            $data['needReview'] = $this->input->post('state');
            // 是否审核   0待审   1审过
            $ids = explode(',',$id);
            foreach ($ids as $key => $value) {
                $this->Public_model->updata('hf_friends_my_photo','id',$value,$data);
            }

            echo "1";
        }else{
            echo "3";
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
        if($_POST){
            $time = $this->input->post('begin_time');
            $end_time = $this->input->post('end_time');
           
                $new = date('Y-m-d',time()).' 00:00:00';
                $endnew = date('Y-m-d',time()).' 23:59:59';

                //获取今日新增帖子
                $query = $this->db->where('create_time >=',$new)->where('create_time <=',$endnew)->where('typeId','1')->get('hf_friends_news');
                // $query = $this->db->query();
                $res = $query->result_array(); 

              

                //获取今日新增问答 
                $query2 = $this->db->where('create_time >=',$new)->where('create_time <=',$endnew)->where('typeId','2')->get('hf_friends_news');
                // $query = $this->db->query();
                $res2 = $query2->result_array(); 
                $a = '0';
                foreach ($res2 as $key => $value) {
                    $query1 = $this->db->where('newsId',$value['id'])->get('hf_friends_news_commont');
                    // // $query = $this->db->query();
                    $res1 = $query1->result_array();
                    $a += count($res1);
                    // var_dump($a);
                }

                $data['friends'] = count($res);
                $data['question'] = count($res2);
                $data['questionData'] = $a;
                $data['time'] = '';
            if($time != ''){
                $new = $time.' 00:00:00';
                $endnew = $end_time.' 23:59:59';

                //获取今日新增帖子
                $friends = $this->db->where('create_time >=',$new)->where('create_time <=',$endnew)->where('typeId','1')->get('hf_friends_news');
                // $query = $this->db->query();
                $friendsList = $friends->result_array(); 

              

                //获取今日新增问答 
                $Question = $this->db->where('create_time >=',$new)->where('create_time <=',$endnew)->where('typeId','2')->get('hf_friends_news');
                // $query = $this->db->query();
                $QuestionList = $Question->result_array(); 
                $b = '0';
                foreach ($QuestionList as $key => $value) {
                    $query3 = $this->db->where('newsId',$value['id'])->get('hf_friends_news_commont');
                    // // $query = $this->db->query();
                    $res3 = $query3->result_array();
                    $b += count($res3);
                    // var_dump($a);
                }

                $data['friends'] = count($res);
                $data['question'] = count($res2);
                $data['questionData'] = count($a);

                $data['time'] = $time;
                $data['endtime'] = $end_time;

                $data['friendsList'] = count($friendsList);
                $data['questionList'] = count($QuestionList);
                $data['questData'] = $b;
            }

            $data['page'] = "friends/statistics.html";
            $data['menu'] = array('friends','statistics');
            $this->load->view('template.html',$data);


        }else{
            $time = date('Y-m-d',time()).' 00:00:00';
            $end = date('Y-m-d',time()).' 23:59:59';

            //获取今日新增帖子
            $query = $this->db->where('create_time >=',$time)->where('create_time <=',$end)->where('typeId','1')->get('hf_friends_news');
            // $query = $this->db->query();
            $res = $query->result_array(); 

          

            //获取今日新增问答 
            $query2 = $this->db->where('create_time >=',$time)->where('create_time <=',$end)->where('typeId','2')->get('hf_friends_news');
            // $query = $this->db->query();
            $res2 = $query2->result_array(); 
            $a = '0';
            foreach ($res2 as $key => $value) {
                $query1 = $this->db->where('newsId',$value['id'])->get('hf_friends_news_commont');
                // // $query = $this->db->query();
                $res1 = $query1->result_array();
                $a += count($res1);
                // var_dump($a);
            }

            $data['friends'] = count($res);
            $data['question'] = count($res2);
            $data['questionData'] = $a;




            $data['page'] = "friends/statistics.html";
            $data['menu'] = array('friends','statistics');
            $this->load->view('template.html',$data);
        }
    }


    //奖励设置
    function reward(){


        $data['page'] = "friends/reward.html";
        $data['menu'] = array('friends','reward');
        $this->load->view('template.html',$data);

    }
    //修改交友奖励哦配置
    function editReward(){
        if($_POST){
            $data = $this->input->post();
            foreach ($data as $k => $v) {
                $this->Public_model->updata('hf_friends_system','name',$k,array('value'=>$v));
            }
            $log = array(
                'userid'=>$_SESSION['users']['user_id'],  

                "content" => $_SESSION['users']['username']."修改里了交友奖励配置",
                "create_time" => date('Y-m-d H:i:s'),

                "userip" => get_client_ip(),

            );
            $this->db->insert('hf_system_journal',$log);

            echo "<script>alert('操作成功！');window.location.href='".site_url('/friends/Friends/reward')."'</script>";exit;

        }else{
             echo "<script>alert('请求错误！');window.location.href='".site_url('/friends/Friends/reward')."'</script>";exit;

        }
    }

	
}


 ?>