<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  本地生活
 *
 * */
require_once(APPPATH.'controllers/Default_Controller.php');
class LocalLife extends Default_Controller {
    //本地生活 分类列表
    public $view_localLifeList = "module/localLife/localLifeList.html";
    //本地服务 信息列表、
    public $view_serviceList = "module/localLife/serviceList.html";
    //本地服务 信息详情
    public $view_serviceInfo = "module/localLife/serviceInfo.html";
    public $view_marketList = "module/localLife/marketList.html";
	//招聘信息
	public $view_recruit = "module/localLife/recruitList.html";


    function __construct()
    {
        parent::__construct();
        $this->load->model('Module_model');
    }

    //本地生活 列表主页
    function localLifeList()
    {
        //获取本地列表
        $data['cates'] = $this->Module_model->get_cates('本地生活');
        //获取免责声明
        $data['disclaimer'] = $this->Module_model->get_disclaimer();
        //视图界面
        $data['page'] = $this->view_localLifeList;
        $data['menu'] = array('localLife','service');
        $this->load->view('template.html',$data);
    }
    //修改免责声明
    function edit_disclaimer(){
    	if($_POST){
    		$data = $this->input->post();
    		if($this->Module_model->edit_disclaimer($data['id'],$data)){

    			echo "<script>alert('操作成功！');window.location.href='".site_url('/module/LocalLife/localLifeList')."'</script>";exit;
    		}else{
    			echo "<script>alert('操作失败！');window.location.href='".site_url('/module/LocalLife/localLifeList')."'</script>";exit;
        		}
    	}else{
    		$this->load->view('404.html');
    	}
    }


    //新增分类操作
    function add_cates(){
        if($_POST){
            $data = $this->input->post();
            if(!empty($_FILES['img']['tmp_name'])){
                $config['upload_path']      = 'Upload/icon';
                $config['allowed_types']    = 'gif|jpg|png|jpeg';
                $config['max_size']     = 2048;
                $config['file_name'] = date('Y-m-d_His');
                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload('img')) {
                    echo "<script>alert('图片上传失败！');window.location.href='".site_url('/module/LocalLife/localLifeList')."'</script>";
                    exit;
                } else {
                    $data['icon'] =  '/Upload/icon/'.$this->upload->data('file_name');
                }
            }
            $data['c_id'] = '本地生活';
            if($this->Module_model->add_cates($data)){
            	//日志
	            $log = array(
	                'userid'=>$_SESSION['users']['user_id'],  
	                "content" => $_SESSION['users']['username']."新增了一个本地生活分类,分类名称是".$data['name'],
	                "create_time" => date('Y-m-d H:i:s'),
	                "userip" => get_client_ip(),
	            );
	            $this->db->insert('hf_system_journal',$log);
                echo "<script>alert('操作成功！');window.location.href='".site_url('/module/LocalLife/localLifeList')."'</script>";
                exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/module/LocalLife/localLifeList')."'</script>";
                exit;
            }
        }else{
            $this->load->view('404.html');
        }
    }

    //修改分类
    function edit_cates(){
        if($_POST){
            $data = $this->input->post();
            if(!empty($_FILES['img']['tmp_name'])){
                $config['upload_path']      = 'Upload/icon';
                $config['allowed_types']    = 'gif|jpg|png|jpeg';
                $config['max_size']     = 2048;
                $config['file_name'] = date('Y-m-d_His');
                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload('img')) {
                    echo "<script>alert('图片上传失败！');window.location.href='".site_url('/module/LocalLife/localLifeList')."'</script>";
                    exit;
                } else {
                    $icon[]['picImg'] =  '/Upload/icon/'.$this->upload->data('file_name');
                    $data['icon'] = json_encode($icon);
                }
            }
            // var_dumP($data);
            // exit;
      
    
            if($this->Module_model->edit_cates($data['id'],$data)){
            	//日志
	            $log = array(
	                'userid'=>$_SESSION['users']['user_id'],  
	                "content" => $_SESSION['users']['username']."编辑了一个本地生活分类,分类名称是".$data['name']."分类id是：".$data['id'],
	                "create_time" => date('Y-m-d H:i:s'),
	                "userip" => get_client_ip(),
	            );
	            $this->db->insert('hf_system_journal',$log);
                echo "<script>alert('操作成功！');window.location.href='".site_url('/module/LocalLife/localLifeList')."'</script>";
                exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/module/LocalLife/localLifeList')."'</script>";
                exit;
            }
        }else{
            $this->load->view('404.html');
        }
    }



	//本地生活 本地服务 列表主页
    function serviceList()
    {
        $id=intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
	//条数
	$config['per_page'] = 10;
	//获取页码
	$current_page=intval($this->uri->segment(5));//index.php 后数第4个/
	//var_dump($current_page);
		//配置
	$config['base_url'] = site_url('/module/LocalLife/serviceList/'.$id);
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
				
			
            //获取分类信息
            $cate = $this->Module_model->get_cateinfo($id);
			if(empty($cate)){
				$this->load->view('404.html');
			}else{
				$type = '';
				//根据分类查询列表
				switch($cate['typeid']){
					//普通信息  保姆、保洁、维修、咨询、开锁
					case '1':
						//总条数
						$list = $this->Module_model->get_serviceList($cate['id']);
						 $config['total_rows'] = count($list);
						//分页数据
						$listpage = $this->Module_model->get_serviceList_page($cate['id'],$config['per_page'],$current_page);
					
						break;
					//房产信息
					case '2':
					//	$userid = $this->session->users['user_id'];
						$list = $this->Module_model->get_houst();
						$config['total_rows'] = count($list);
						//分页数据
						$listpage = $this->Module_model->get_houst_page($config['per_page'],$current_page);
						break;
					//二手市场
					case '3':
						$list = $this->Module_model->get_mark();
						$config['total_rows'] = count($list);
						//分页数据

						$listpage = $this->Module_model->get_mark_page($config['per_page'],$current_page);
						//分类信息
						$type = $this->Module_model->get_mark_type();
						break;
					// 快递上门
					case '4':
						$list = $this->Module_model->get_express();
						$config['total_rows'] = count($list);
						//分页数据
						$listpage = $this->Module_model->get_express_page($config['per_page'],$current_page);
						break;
					//超市比价
					case '5':
						$list = $this->Module_model->get_market_data();
						$config['total_rows'] = count($list);
						//分页数据
						$listpage = $this->Module_model->get_market_data_page($config['per_page'],$current_page);
						break;
				}

				$this->load->library('pagination');//加载ci pagination类
				$this->pagination->initialize($config);
				$data = array('id'=>$id,'typeid'=>$cate['typeid'],'name'=>$cate['name'],'lists'=>$listpage,'pages' => $this->pagination->create_links(),'type'=>$type);
				//视图

			                $data['page'] = $this->view_serviceList;
			                $data['menu'] = array('localLife','service');
			                $this->load->view('template.html',$data);
			}
        }
    }

    //搜索
    function search(){
    	if($_POST){
    		$typeid = $this->input->post('typeid');
    		$sear = trim($this->input->post('sear'));
    		$cate = trim($this->input->post('cate'));

    		//条数
			$config['per_page'] = 10;
			//获取页码
			$current_page=intval($this->uri->segment(5));//index.php 后数第4个/
			//var_dump($current_page);
				//配置
			$config['base_url'] = site_url('/module/LocalLife/serviceList/'.$cate);
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

			$type = '';
              $cates = $this->Module_model->get_cateinfo($cate);
    		switch ($typeid) {
    			//普通信息
    			case '1':
    				//总数据
    				$list = $this->Module_model->search_service($sear,$cate);
					$config['total_rows'] = count($list);
					// //分页数据
				    $listpage = $this->Module_model->search_service_page($sear,$cate,$config['per_page'],$current_page);
    				break;
    				//房产
    			case '2':
    				//总数据
    				$list = $this->Module_model->search_houst($sear);
					$config['total_rows'] = count($list);
					// //分页数据
				    $listpage = $this->Module_model->search_houst_page($sear,$config['per_page'],$current_page);
    				break;
    			// 二手市场
	    		case '3':
	    			$list = $this->Module_model->search_mark($sear);
					$config['total_rows'] = count($list);
					// //分页数据
				    $listpage = $this->Module_model->search_mark_page($sear,$config['per_page'],$current_page);
                    //分类信息
                    $type = $this->Module_model->get_mark_type();
	    			break;
                    //快递上门
                case '4':
                    $list = $this->Module_model->search_express($sear);
                    $config['total_rows'] = count($list);
                    // //分页数据
                    $listpage = $this->Module_model->search_express_page($sear,$config['per_page'],$current_page);
                    break;
                    //超市比价
                case '5':
                    $list = $this->Module_model->search_market_data($sear);
                    $config['total_rows'] = count($list);
                    // //分页数据
                    $listpage = $this->Module_model->search_market_data_page($sear,$config['per_page'],$current_page);
                    break;
    		}
			$this->load->library('pagination');//加载ci pagination类
			$this->pagination->initialize($config);
    		$data = array('id'=>$cate,'typeid'=>$typeid,'name'=>'搜索结果','lists'=>$listpage,'pages' => $this->pagination->create_links(),'type'=>$type,'catename'=>$cates['name']);
    		  //视图
                $data['page'] = $this->view_serviceList;
                $data['menu'] = array('localLife','service');
                $this->load->view('template.html',$data);

    	}else{
    		$this->load->view('404.html');
    	}
    }
    
    //本地生活 本地服务 列表详情
    function serviceInfo()
    {
		$id=intval($this->uri->segment(4));
                        $type=intval($this->uri->segment(5));
		$cateid=intval($this->uri->segment(6));
	   
		if($id == 0 || $type == 0){
			$this->load->view('404.html');
		}else{
				$tag = '';
            $cate = $this->Module_model->get_cateinfo($cateid);
			switch($type){
				case '1':
					//$title = '普通信息';
					$info = $this->Module_model->get_serviceinfo($id);
					break;
				case '2':
					//$title = '房产信息';
					$info = $this->Module_model->get_houstinfo($id);
					break;
				case '3':
					//$title = '二手市场';
					$info = $this->Module_model->get_markinfo($id);
					$tag = $this->Module_model->get_mark_type();
					break;
				case '5':
					//$title = '超市比价';
					$info = $this->Module_model->get_market_data_info($id);
					break;
			}
			$data = array('type_id'=>$type,'info'=>$info,'title'=>$cate['name'],'cateid'=>$cateid,'type'=>$tag);
			//视图
            $data['page'] = $this->view_serviceInfo;
            $data['menu'] = array('localLife','service');
            $this->load->view('template.html',$data);
		}
    }
	//删除本地服务信息
	function del_service(){

		$id=intval($this->uri->segment(4));
		$type=intval($this->uri->segment(5));
			$cate=intval($this->uri->segment(6));
		if($id == 0 || $type == 0){
			$this->load->view('404.html');
		}else{
		
			switch($type){
				case '1':
					$info = $this->Module_model->del_service($id);
					if($info){
						//日志
			            $log = array(
			                'userid'=>$_SESSION['users']['user_id'],  
			                "content" => $_SESSION['users']['username']."删除了一个普通信息,信息id是".$id,
			                "create_time" => date('Y-m-d H:i:s'),
			                "userip" => get_client_ip(),
			            );
			            $this->db->insert('hf_system_journal',$log);
					}
					break;
				case '2':

					$info = $this->Module_model->del_houst($id);
					if($info){
						//日志
			            $log = array(
			                'userid'=>$_SESSION['users']['user_id'],  
			                "content" => $_SESSION['users']['username']."删除了一个房产信息,信息id是".$id,
			                "create_time" => date('Y-m-d H:i:s'),
			                "userip" => get_client_ip(),
			            );
			            $this->db->insert('hf_system_journal',$log);
					}
					break;
				case '3':
					$info = $this->Module_model->del_mark($id);
					if($info){
						//日志
			            $log = array(
			                'userid'=>$_SESSION['users']['user_id'],  
			                "content" => $_SESSION['users']['username']."删除了一个二手信息,信息id是".$id,
			                "create_time" => date('Y-m-d H:i:s'),
			                "userip" => get_client_ip(),
			            );
			            $this->db->insert('hf_system_journal',$log);
					}
					break;
				case '5':
					$info = $this->Module_model->del_market_data($id);
					if($info){
						//日志
			            $log = array(
			                'userid'=>$_SESSION['users']['user_id'],  
			                "content" => $_SESSION['users']['username']."删除了一个超市比价信息,信息id是".$id,
			                "create_time" => date('Y-m-d H:i:s'),
			                "userip" => get_client_ip(),
			            );
			            $this->db->insert('hf_system_journal',$log);
					}
					break;
			}
			if($info){

				 echo "<script>alert('操作成功！');window.location.href='".site_url('/module/LocalLife/serviceList/'.$cate)."'</script>";exit;
			}else{
				 echo "<script>alert('操作失败！');window.location.href='".site_url('/module/LocalLife/serviceList/'.$cate)."'</script>";exit;
			}
		}
	}
	
	//新增普通信息
	function add_service(){
		
		if($_POST){
			$data = $this->input->post();
			$pic = array();
			$i =1;
			foreach($_FILES as $file=>$val){
				if(!empty($_FILES['img'.$i]['name'])){
					$config['upload_path']      = 'Upload/service/ordinary';
					$config['allowed_types']    = 'gif|jpg|png|jpeg';
					$config['max_size']     = 2048;
					$config['file_name'] = date('Y-m-d_His');
					$this->load->library('upload', $config);
					// 上传
					if(!$this->upload->do_upload('img'.$i)) {
					    echo "<script>alert('图片上传失败！');window.location.href='".site_url('/module/LocalLife/serviceList/'.$data['type_name'])."'</script>";exit;
					}else{
						if($i != 4){
						   $pic[]['picImg'] = '/Upload/service/ordinary/'.$this->upload->data('file_name');
						}else{
							$logo[]['picImg'] = '/Upload/service/ordinary/'.$this->upload->data('file_name');
						}
					}
				}
				$i++;
			 }
        
			 $data['pic'] = json_encode($pic);
			 $data['logo'] = json_encode($logo);
             $data['userid'] = $this->session->users['user_id'];
			 if($this->Module_model->add_service($data)){

				//日志
	            $log = array(
	                'userid'=>$_SESSION['users']['user_id'],  
	                "content" => $_SESSION['users']['username']."新增了一个普通信息,信息名称是".$data['name'],
	                "create_time" => date('Y-m-d H:i:s'),
	                "userip" => get_client_ip(),
	            );
	            $this->db->insert('hf_system_journal',$log);
					
				 echo "<script>alert('操作成功！');window.location.href='".site_url('/module/LocalLife/serviceList/'.$data['type_name'])."'</script>";exit;
			 }else{
				 echo "<script>alert('操作失败！');window.location.href='".site_url('/module/LocalLife/serviceList/'.$data['type_name'])."'</script>";exit;
			 }
			 
		}else{
			$this->load->view('404.html');
		}
	}

	//新增房产信息
	function add_houst(){
		if($_POST){
			$data = $this->input->post();
			$pic = array();
			$i =1;
			foreach($_FILES as $file=>$val){
				if(!empty($_FILES['img'.$i]['name'])){
					$config['upload_path']      = 'Upload/service/houst';
					$config['allowed_types']    = 'gif|jpg|png|jpeg';
					$config['max_size']     = 2048;
					$config['file_name'] = date('Y-m-d_His');
					$this->load->library('upload', $config);
					//上传
					if(!$this->upload->do_upload('img'.$i)) {
					    echo "<script>alert('图片上传失败！');window.location.href='".site_url('/module/LocalLife/serviceList/'.$data['type_id'])."'</script>";exit;
					}else{
						if($i != 4){
							$pic[]['picImg'] = '/Upload/service/houst/'.$this->upload->data('file_name');
						}else{
							$logo[]['picImg'] = '/Upload/service/houst/'.$this->upload->data('file_name');
						}
					}
				}
				$i++;
			 }
			 $data['pic'] =json_encode($pic);
			 $data['list_pic'] = json_encode($logo);
			 $data['userid'] = $this->session->users['user_id'];
			 $id = $data['type_id'];
			 unset($data['type_id']);
			 if($this->Module_model->add_houst($data)){
			 		//日志
	            $log = array(
	                'userid'=>$_SESSION['users']['user_id'],  
	                "content" => $_SESSION['users']['username']."新增了一个房产信息,信息名称是".$data['name'],
	                "create_time" => date('Y-m-d H:i:s'),
	                "userip" => get_client_ip(),
	            );
	            $this->db->insert('hf_system_journal',$log);

				  echo "<script>alert('操作成功！');window.location.href='".site_url('/module/LocalLife/serviceList/'.$id)."'</script>";exit;
			 }else{
				  echo "<script>alert('操作失败！');window.location.href='".site_url('/module/LocalLife/serviceList/'.$id)."'</script>";exit;
			 }
			
		}else{
			$this->load->view('404.html');
		}
	}

	//新增二手产品
	function add_market(){
		if($_POST){
			$data = $this->input->post();
			$pic = array();
			$i =1;
			foreach($_FILES as $file=>$val){
				if(!empty($_FILES['img'.$i]['name'])){
					$config['upload_path']      = 'Upload/service/mark';
					$config['allowed_types']    = 'gif|jpg|png|jpeg';
					$config['max_size']     = 2048;
					$config['file_name'] = date('Y-m-d_His');
					$this->load->library('upload', $config);
					//上传
					if(!$this->upload->do_upload('img'.$i)) {
					    echo "<script>alert('图片上传失败！');window.location.href='".site_url('/module/LocalLife/serviceList/'.$data['id'])."'</script>";exit;
					}else{
						if($i != 4){
							$pic[]['picImg'] = '/Upload/service/mark/'.$this->upload->data('file_name');
						}else{
							$logo[]['picImg'] = '/Upload/service/mark/'.$this->upload->data('file_name');
						}
					}
				}
				$i++;
			}
			$data['pic'] = json_encode($pic);
			$data['list_pic'] = json_encode($logo);
			$data['userid'] = $this->session->users['user_id'];
			$type= $data['id'];
			unset($data['id']);

			if($this->Module_model->add_market($data)){
					//日志
	            $log = array(
	                'userid'=>$_SESSION['users']['user_id'],  
	                "content" => $_SESSION['users']['username']."新增了一个二手信息,信息名称是".$data['title'],
	                "create_time" => date('Y-m-d H:i:s'),
	                "userip" => get_client_ip(),
	            );
	            $this->db->insert('hf_system_journal',$log);
				echo "<script>alert('操作成功！');window.location.href='".site_url('/module/LocalLife/serviceList/'.$type)."'</script>";exit;
			}else{
				echo "<script>alert('操作失败！');window.location.href='".site_url('/module/LocalLife/serviceList/'.$type)."'</script>";exit;
			}
		}else{
			$this->load->view('404.html');
		}
	}
	//编辑
	function edit_service(){
		if($_POST){
			$cateid = $this->input->post('cateid');
			$data = $this->input->post();
			unset($data['cateid']);
			$pic = array();
			switch($data['type_id']){
				case '1':
					$i =1;
					foreach($_FILES as $file=>$val){
						if(!empty($_FILES['img'.$i]['name'])){
							$config['upload_path']      = 'Upload/service/ordinary';
							$config['allowed_types']    = 'gif|jpg|png|jpeg';
							$config['max_size']     = 2048;
							$config['file_name'] = date('Y-m-d_His');
							$this->load->library('upload', $config);
							//上传
							if(!$this->upload->do_upload('img'.$i)) {
							     echo "<script>alert('操作失败！');window.location.href='".site_url('/module/LocalLife/serviceInfo/'.$data['id'].'/'.$type)."'</script>";exit;
							}else{
								unset($data['img'.$i]);
								if($i != 4){
									$pic[]['picImg'] = '/Upload/service/ordinary/'.$this->upload->data('file_name');
								}else{
									$logo[]['picImg'] = '/Upload/service/ordinary/'.$this->upload->data('file_name');
								}
							}
						}else{
							if($i != 4){
								if(!empty($data['img'.$i])){
									$pic[]['picImg'] = $data['img'.$i];
								}
							}else{
								$logo[]['picImg'] = $data['logo'];
							}
                            unset($data['img'.$i]);
						}
						$i++;
					 }
					 $data['pic'] = json_encode($pic);
					 $data['logo'] = json_encode($logo);
					 $type = $data['type_id'];
					 unset($data['type_id']);
					 $isOk = $this->Module_model->edit_service($data['id'],$data);
					 if($isOk){
					 	//日志
			            $log = array(
			                'userid'=>$_SESSION['users']['user_id'],  
			                "content" => $_SESSION['users']['username']."编辑了一个普通信息,信息名称是".$data['name']."，信息id是：".$data['id'],
			                "create_time" => date('Y-m-d H:i:s'),
			                "userip" => get_client_ip(),
			            );
			            $this->db->insert('hf_system_journal',$log);
					 }
					break;
					//房产
				case '2':
					$i =1;
					foreach($_FILES as $file=>$val){
						if(!empty($_FILES['img'.$i]['name'])){
							$config['upload_path']      = 'Upload/service/houst';
							$config['allowed_types']    = 'gif|jpg|png|jpeg';
							$config['max_size']     = 2048;
							$config['file_name'] = date('Y-m-d_His');
							$this->load->library('upload', $config);
							//上传
							if(!$this->upload->do_upload('img'.$i)) {
							     echo "<script>alert('操作失败！');window.location.href='".site_url('/module/LocalLife/serviceInfo/'.$data['id'].'/'.$type)."'</script>";exit;
							}else{
                                unset($data['img'.$i]);
								if($i != 4){
								$pic[]['picImg'] = '/Upload/service/houst/'.$this->upload->data('file_name');
								}else{
									$logo[]['picImg'] = '/Upload/service/houst/'.$this->upload->data('file_name');
								}
							}
						}else{
                            
							if($i != 4){
								if(!empty($data['img'.$i])){
									$pic[]['picImg'] = $data['img'.$i];
									// /unset($data['img'.$i]);
								}
							}else{
								$logo[]['picImg'] = $data['img'.$i];
							}
                            unset($data['img'.$i]);
						}
						$i++;
					 }
					 $data['pic'] = json_encode($pic);
					 $data['list_pic'] = json_encode($logo);
					 $type = $data['type_id'];
					 unset($data['type_id']);
			 		$isOk = $this->Module_model->edit_houst($data['id'],$data);
			 		 if($isOk){
					 	//日志
			            $log = array(
			                'userid'=>$_SESSION['users']['user_id'],  
			                "content" => $_SESSION['users']['username']."编辑了一个房产信息,信息名称是".$data['name']."，信息id是：".$data['id'],
			                "create_time" => date('Y-m-d H:i:s'),
			                "userip" => get_client_ip(),
			            );
			            $this->db->insert('hf_system_journal',$log);
					 }
					break;
					//二手市场
				case '3':
					$i = '1';
					foreach($_FILES as $file=>$val){
						if(!empty($_FILES['img'.$i]['name'])){
							$config['upload_path']      = 'Upload/service/mark';
							$config['allowed_types']    = 'gif|jpg|png|jpeg';
							$config['max_size']     = 2048;
							$config['file_name'] = date('Y-m-d_His');
							$this->load->library('upload', $config);
							//上传
							if(!$this->upload->do_upload('img'.$i)) {
							     echo "<script>alert('操作失败！');window.location.href='".site_url('/module/LocalLife/serviceInfo/'.$data['id'].'/'.$type)."'</script>";exit;
							}else{
								unset($data['img'.$i]);
								if($i != 4){
									$pic[]['picImg'] = '/Upload/service/mark/'.$this->upload->data('file_name');
								}else{
									$logo[]['picImg'] = '/Upload/service/mark/'.$this->upload->data('file_name');
								}
							}
						}else{
							if($i != 4){
								if(!empty($data['img'.$i])){
									$pic[]['picImg'] = $data['img'.$i];
								}
							}else{
								$logo[]['picImg'] = $data['list_pic'];
							}
							unset($data['img'.$i]);
						}
						$i++;
					}
					$data['pic'] = json_encode($pic);
					$data['list_pic'] =json_encode($logo);
					$type = $data['type_id'];
					unset($data['type_id']);
					$isOk = $this->Module_model->edit_markinfo($data['id'],$data);
						if($isOk){
					 	//日志
			            $log = array(
			                'userid'=>$_SESSION['users']['user_id'],  
			                "content" => $_SESSION['users']['username']."编辑了一个二手信息,信息名称是".$data['title']."，信息id是：".$data['id'],
			                "create_time" => date('Y-m-d H:i:s'),
			                "userip" => get_client_ip(),
			            );
			            $this->db->insert('hf_system_journal',$log);
					 }

					break;
					//超市比价
				case '5':
						$type = $data['type_id'];
						$cate = $data['cate'];
						$data['date'] = date('Y-m-d H:i:s');
						unset($data['type_id'],$data['cate']);
						if($this->Module_model->edit_market_info($data['id'],$data)){
							//日志
				            $log = array(
				                'userid'=>$_SESSION['users']['user_id'],  
				                "content" => $_SESSION['users']['username']."编辑了一个超市特价信息,信息名称是".$data['name']."，信息id是：".$data['id'],
				                "create_time" => date('Y-m-d H:i:s'),
				                "userip" => get_client_ip(),
				            );
				            $this->db->insert('hf_system_journal',$log);
							echo "<script>alert('操作成功！');window.location.href='".site_url('/module/LocalLife/serviceList/'.$cate)."'</script>";exit;
						}else{
							echo "<script>alert('操作失败！');window.location.href='".site_url('/module/LocalLife/serviceList/'.$cate)."'</script>";exit;
						}
					break;
			}

			if($isOk){
				echo "<script>alert('操作成功！');window.location.href='".site_url('/module/LocalLife/serviceInfo/'.$data['id'].'/'.$type.'/'.$cateid)."'</script>";exit;
			}else{
				echo "<script>alert('操作失败！');window.location.href='".site_url('/module/LocalLife/serviceInfo/'.$data['id'].'/'.$type.'/'.$cateid)."'</script>";exit;
			}

		}else{
			$this->load->view('404.html');
		}
	}

	//超市比价
	function market_data(){
		$userid = $this->session->users['user_id'];
			//条数
			$config['per_page'] = 10;
			//获取页码
			$current_page=intval($this->uri->segment(4));//index.php 后数第4个/
			//var_dump($current_page);
				//配置
			$config['base_url'] = site_url('/module/LocalLife/market_data');
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
				

			$list = $this->Module_model->get_market_list($userid);
			$config['total_rows'] = count($list);
						//分页数据
			$listpage = $this->Module_model->get_market_list_page($userid,$config['per_page'],$current_page);
						
			$this->load->library('pagination');//加载ci pagination类
			$this->pagination->initialize($config);
			$data = array('name'=>'超市比价','lists'=>$listpage,'pages' => $this->pagination->create_links());
			//视图

            $data['page'] = $this->view_marketList;
            $data['menu'] = array('localLife','localLife');
            $this->load->view('template.html',$data);
		
	}


	//新增超市比价
	function add_market_goods(){
		if($_POST){
			$data = $this->input->post();
			$data['date'] = date('Y-m-d H:i:s');
			$market_name =  $this->user_model->get_user_info( $this->session->users['user_id']);
			$data['market_name'] = $market_name['username'];
			$data['marketid'] = $this->session->users['user_id'];
			if($this->Module_model->add_market_data($data)){
				//日志
	            $log = array(
	                'userid'=>$_SESSION['users']['user_id'],  
	                "content" => $_SESSION['users']['username']."新增了一个超市特价信息,信息名称是".$data['goods_name'],
	                "create_time" => date('Y-m-d H:i:s'),
	                "userip" => get_client_ip(),
	            );
	            $this->db->insert('hf_system_journal',$log);
				echo "<script>alert('操作成功！');window.location.href='".site_url('/module/LocalLife/market_data')."'</script>";exit;
			}else{
				echo "<script>alert('操作失败！');window.location.href='".site_url('/module/LocalLife/market_data')."'</script>";exit;
			}
		}else{
			$this->load->view('404.html');
		}
	}

	//删除超市比价商品
	function del_market_data(){
		$id = intval($this->uri->segment(4));
		if($id == 0){
			$this->load->view('404.html');
		}else{
			if($this->Module_model->del_market_data($id)){
					//日志
		            $log = array(
		                'userid'=>$_SESSION['users']['user_id'],  
		                "content" => $_SESSION['users']['username']."删除了一个超市特价信息,信息名称是".$data['goods_name'].",信息id是：".$id,
		                "create_time" => date('Y-m-d H:i:s'),
		                "userip" => get_client_ip(),
		            );
		            $this->db->insert('hf_system_journal',$log);
					echo "<script>alert('操作成功！');window.location.href='".site_url('/module/LocalLife/market_data')."'</script>";exit;
			}else{
					echo "<script>alert('操作失败！');window.location.href='".site_url('/module/LocalLife/market_data')."'</script>";exit;
			}
		}
	}

	//编辑超市比价
	function edit_market_data(){
		if($_POST){
			$data = $this->input->post();

			if($this->Module_model->edit_market_info($data['id'],$data)){
					//日志
		            $log = array(
		                'userid'=>$_SESSION['users']['user_id'],  
		                "content" => $_SESSION['users']['username']."编辑了一个超市特价信息,信息id是：".$id,
		                "create_time" => date('Y-m-d H:i:s'),
		                "userip" => get_client_ip(),
		            );
		            $this->db->insert('hf_system_journal',$log);
				echo "<script>alert('操作成功！');window.location.href='".site_url('/module/LocalLife/market_data')."'</script>";exit;
			}else{
				echo "<script>alert('操作失败！');window.location.href='".site_url('/module/LocalLife/market_data')."'</script>";exit;
			}
		}else{
			$this->load->view('404.html');
		}
	}


	//新增超市比价
	function add_market_data(){
		if($_POST){
			$data = $this->input->post();
			$id = $data['id'];
			unset($data['id']);
			$data['date'] = date('Y-m-d H:i:s');
			// var_dumP($data);
			// exit;
			if($this->Module_model->add_market_data($data)){
				//日志
		            $log = array(
		                'userid'=>$_SESSION['users']['user_id'],  
		                "content" => $_SESSION['users']['username']."新增了一个超市特价信息,信息名称是：".$data['goods_name'],
		                "create_time" => date('Y-m-d H:i:s'),
		                "userip" => get_client_ip(),
		            );
		            $this->db->insert('hf_system_journal',$log);
				echo "<script>alert('操作成功！');window.location.href='".site_url('/module/LocalLife/serviceList/'.$id)."'</script>";exit;
			}else{
				echo "<script>alert('操作失败！');window.location.href='".site_url('/module/LocalLife/serviceList/'.$id)."'</script>";exit;
			}
		}else{
			$this->load->view('404.html');
		}
	}

	//导入超市比价
	function send_market_data(){
		  $yes = array();
	      $error = array();
		  $name = date('Y-m-d');
		  $inputFileName = "Upload/xls/" .$name .'.xls';
	      move_uploaded_file($_FILES["file"]["tmp_name"],$inputFileName);
	        //引入类库
	      $this->load->library('excel');
	        if(!file_exists($inputFileName)){
	                echo "<script>alert('文件导入失败!');window.location.href='".site_url('/module/LocalLife/serviceList/8')."'</script>";
	                exit;
	        }
	        //导入excel文件类型 excel2007 or excel5
	        $PHPReader = new PHPExcel_Reader_Excel2007();
	        if(!$PHPReader->canRead($inputFileName)){
	          $PHPReader = new PHPExcel_Reader_Excel5();
	          if(!$PHPReader->canRead($inputFileName)){
	            echo 'no Excel';
	            return;
	          }
	        }
	          
	         $PHPExcel = $PHPReader->load($inputFileName);
	         $currentSheet = $PHPExcel->getSheet(0);  //读取excel文件中的第一个工作表
	         $allColumn = $currentSheet->getHighestColumn(); //取得最大的列号
	         $allRow = $currentSheet->getHighestRow(); //取得一共有多少行
	         $erp_orders_id = array();  //声明数组
	         for($currentRow = 2;$currentRow <= $allRow;$currentRow++){
	            $data[$currentRow]['goods_name'] = $PHPExcel->getActiveSheet()->getCell("A".$currentRow)->getValue();//获取A列的值
	            $data[$currentRow]['orginal_price'] = $PHPExcel->getActiveSheet()->getCell("B".$currentRow)->getValue();//获取A列的值
	            // $data[$currentRow]['goods_name'] = $PHPExcecurrentRow)->getValue();//获取B列的值l->getActiveSheet()->getCell("B".$
	            $price = $PHPExcel->getActiveSheet()->getCell("C".$currentRow)->getValue();//获取c列的值
	            if(empty($price)){
	          		$error[] = $currentRow;
	            }else{
	          	  $data[$currentRow]['date_price'] = $price;
	            }
	            $data[$currentRow]['unit'] = $PHPExcel->getActiveSheet()->getCell("D".$currentRow)->getValue();//获取c列的值 
	            $data[$currentRow]['standard'] = $PHPExcel->getActiveSheet()->getCell("E".$currentRow)->getValue();//获取c列的值
	            $data[$currentRow]['date'] = date('Y-m-d H:i:s');
	            	$market_name =  $this->user_model->get_user_info( $this->session->users['user_id']);
	             $data[$currentRow]['market_name'] = $market_name['username'];
	            $data[$currentRow]['import_user'] = $this->session->users['user_id'];
	            $data[$currentRow]['marketid'] = $this->session->users['user_id'];

	            //插入数据库
	            // $where = array('property_id'=>$property_id,'unit_no'=>$unit_no);
	            if(empty($data[$currentRow]['goods_name'])){
	            	 break;
	            }
	           
	         }
	         //删除临时文件
	         foreach ($data as $key => $value) {
	         	if($this->Module_model->add_market_data($value)){
	         		$yes[] = $key;
	         	}else{
					$error[] = $key;
	         	}
	         }
	         $ret = array('yes'=>count($yes),'error'=>count($error),'errorlist'=>$error);
	         //日志
            $log = array(
                'userid'=>$_SESSION['users']['user_id'],  
                "content" => $_SESSION['users']['username']."导入了超市特价信息,信息导入成功：".$ret['yes']."条，导入失败".$ret['error'].'条，错误条数：'.implode(',',$ret['errorlist']),
                "create_time" => date('Y-m-d H:i:s'),
                "userip" => get_client_ip(),
            );
            $this->db->insert('hf_system_journal',$log);

	         echo json_encode($ret);
	         unlink($inputFileName);
	   
	}
	//导出超市比价
	function dowload_market_data(){
			$id = intval($this->uri->segment(4));
			if($id == 0){
				$this->load->view('404.html');
			}else{
				  $this->load->library('excel');
	        //activate worksheet number 1
	        $this->excel->setActiveSheetIndex(0);
	        //name the worksheet
	        $this->excel->getActiveSheet()->setTitle('Bookings');
	        $arr_title = array(
	            'A' => '超市名称',
	            'B' => '商品名称',
	            'C' => '价格',
	            'D' => '单位',
	            'E' => '时间'
	        );
	       //设置excel 表头
	        foreach ($arr_title as $key => $value) {
	            $this->excel->getActiveSheet()->setCellValue($key . '1', $value);
	            $this->excel->getActiveSheet()->getStyle($key . '1')->getFont()->setSize(13);
	            $this->excel->getActiveSheet()->getStyle($key . '1')->getFont()->setBold(true);
	            $this->excel->getActiveSheet()->getStyle($key . '1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	        }

	        $i = 1;
	    	//查询数据库得到要导出的内容
	        $market = $this->Module_model->get_market_data();
	        if(count($market) > 0)
	        {
	            foreach ($market as $booking) {
	                $i++;
	                $this->excel->getActiveSheet()->setCellValue('A' . $i, $booking['market_name']);
	                $this->excel->getActiveSheet()->setCellValue('B' . $i, $booking['goods_name']);
	                $this->excel->getActiveSheet()->setCellValue('C' . $i, $booking['date_price']);
	                $this->excel->getActiveSheet()->setCellValue('D' . $i, $booking['unit']);
	                $this->excel->getActiveSheet()->setCellValue('E' . $i, $booking['date']);
	            }
	        }
	        $name = date('Y-m-d');
	        $filename = $name.'.xls'; //save our workbook as this file name
	        header('Content-Type: application/vnd.ms-excel'); //mime type
	        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
	        header('Cache-Control: max-age=0'); //no cache

	           //日志
            $log = array(
                'userid'=>$_SESSION['users']['user_id'],  
                "content" => $_SESSION['users']['username']."导出了超市特价信息",
                "create_time" => date('Y-m-d H:i:s'),
                "userip" => get_client_ip(),
            );
            $this->db->insert('hf_system_journal',$log);
	        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
	        $objWriter->save('php://output');
		}
	}

	//招聘信息
	function recruit_list(){
		 $data['name'] = "招聘信息";
		 $data['page'] = $this->view_recruit;
         $data['menu'] = array('localLife','service');
         $this->load->view('template.html',$data);
	}

	//返回所有招聘信息
	function ret_recruit_list(){
		if($_POST){
			$list = $this->Module_model->get_recruit_list('4');
			if(!empty($list)){
				echo json_encode($list);
			}else{
				echo "2";
			}
		}else{
			echo "2";
		}
	}

	//新增 招聘信息
	function add_recruit(){
		if($_POST){
			$data = $this->input->post();
			$title = $data['name'];
			$data['content'] = '{"title":"'.$data['name'].'","content":"'.$data['content'].'"}';
		//	unset($data['title']);
			$data['type_name'] = "4";
			if($this->Module_model->add_service($data)){
				//日志
				$log = array(
					'userid'=>$_SESSION['users']['user_id'],  
					"content" => $_SESSION['users']['username']."新增了一个招聘信息！信息标题是：".$title,
					"create_time" => date('Y-m-d H:i:s'),
					"userip" => get_client_ip(),
				);
				$this->db->insert('hf_system_journal',$log);
				echo "<script>alert('操作成功！');window.location.href='".site_url('/module/LocalLife/recruit_list')."'</script>";eixt;
			}else{
				echo "<script>alert('操作失败！');window.location.href='".site_url('/module/LocalLife/recruit_list')."'</script>";eixt;
			}
		}else{
			$this->load->view('404.html');
		}
	}

	//编辑招聘信息
	function edit_recruit(){
		if($_POST){
			$data = $this->input->post();
			$title = $data['name'];
			$data['content'] = '{"title":"'.$data['name'].'","content":"'.$data['content'].'"}';
			if($this->Module_model->edit_service($data['id'],$data)){
				//日志
				$log = array(
					'userid'=>$_SESSION['users']['user_id'],  
					"content" => $_SESSION['users']['username']."编辑了一个招聘信息！信息标题是：".$title.',信息id是：'.$data['id'],
					"create_time" => date('Y-m-d H:i:s'),
					"userip" => get_client_ip(),
				);
				$this->db->insert('hf_system_journal',$log);
				echo "1";exit;
			}else{
				echo "3";exit;
			}

		}else{
			echo "2";
		}
	}
}
