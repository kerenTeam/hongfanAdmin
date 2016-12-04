<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  本地生活
 *
 * */
require_once(APPPATH.'controllers/default_Controller.php');
class localLife extends default_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('module_model');
    }

    //本地生活 列表主页
    function localLifeList()
    {
        //获取本地列表
        $data['cates'] = $this->module_model->get_cates('本地生活');
        $this->load->view('module/localLife/localLifeList.html',$data);
    }
    //新增分类操作
    function add_cates(){
        if($_POST){
            $data = $this->input->post();
            if(!empty($_FILES['img']['tmp_name'])){
                $config['upload_path']      = 'upload/icon';
                $config['allowed_types']    = 'gif|jpg|png|jpeg';
                $config['max_size']     = 2048;
                $config['file_name'] = date('Y-m-d_His');
                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload('img')) {
                    echo "<script>alert('图片上传失败！');window.location.href='".site_url('/module/module/localLifeList')."'</script>";
                    exit;
                } else {
                    $data['icon'] =  'upload/icon/'.$this->upload->data('file_name');
                }
            }
            $data['c_id'] = '本地生活';
            if($this->module_model->add_cates($data)){
                echo "<script>alert('操作成功！');window.location.href='".site_url('/module/module/localLifeList')."'</script>";
                exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/module/module/localLifeList')."'</script>";
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
                $config['upload_path']      = 'upload/icon';
                $config['allowed_types']    = 'gif|jpg|png|jpeg';
                $config['max_size']     = 2048;
                $config['file_name'] = date('Y-m-d_His');
                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload('img')) {
                    echo "<script>alert('图片上传失败！');window.location.href='".site_url('/module/module/localLifeList')."'</script>";
                    exit;
                } else {
                    $data['icon'] =  'upload/icon/'.$this->upload->data('file_name');
                }
            }
            if($this->module_model->edit_cates($data['id'],$data)){
                echo "<script>alert('操作成功！');window.location.href='".site_url('/module/module/localLifeList')."'</script>";
                exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/module/module/localLifeList')."'</script>";
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
			$config['per_page'] = 5;
			//获取页码
			$current_page=intval($this->uri->segment(5));//index.php 后数第4个/
			
				//配置
			$config['base_url'] = site_url('/module/localLife/serviceList/').$id;
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
            $cate = $this->module_model->get_cateinfo($id);
            //根据分类查询列表
            switch($cate['typeid']){
                //普通信息  保姆、保洁、维修、咨询、开锁
                case '1':
					//总条数
                    $list = $this->module_model->get_serviceList($cate['id']);
					 $config['total_rows'] = count($list);
					//分页数据
					$listpage = $this->module_model->get_serviceList_page($cate['id'],$config['per_page'],$current_page);
				
                    break;
                //房产信息
                case '2':
				//	$userid = $this->session->users['user_id'];
                    $list = $this->module_model->get_houst();
					$config['total_rows'] = count($list);
					//分页数据
					$listpage = $this->module_model->get_houst_page($config['per_page'],$current_page);
                    break;
                //二手市场
                case '3':
                    $list = $this->module_model->get_mark();
					$config['total_rows'] = count($list);
					//分页数据
					$listpage = $this->module_model->get_mark_page($config['per_page'],$current_page);
                    break;
                // 快递上门
                case '4':
					$list = $this->module_model->get_express();
					$config['total_rows'] = count($list);
					//分页数据
					$listpage = $this->module_model->get_express_page($config['per_page'],$current_page);
                    break;
                //超市比价
                case '5':
					$list = $this->module_model->get_market_data();
					$config['total_rows'] = count($list);
					//分页数据
					$listpage = $this->module_model->get_market_data_page($config['per_page'],$current_page);
                    break;
            }

			$this->load->library('pagination');//加载ci pagination类
			$this->pagination->initialize($config);
            $data = array('id'=>$id,'typeid'=>$cate['typeid'],'name'=>$cate['name'],'lists'=>$listpage,'page' => $this->pagination->create_links());
	
            $this->load->view('module/localLife/serviceList.html',$data);
        }
    }
    //本地生活 本地服务 列表详情
    function serviceInfo()
    {
		$id=intval($this->uri->segment(4));
		$type=intval($this->uri->segment(5));
	
		if($id == 0 || $type == 0){
			$this->load->view('404.html');
		}else{
			switch($type){
				case '1':
					$title = '普通信息';
					$info = $this->module_model->get_serviceinfo($id);
					break;
				case '2':
					$title = '房产信息';
					$info = $this->module_model->get_houstinfo($id);
					break;
				case '3':
					$title = '二手市场';
					$info = $this->module_model->get_markinfo($id);
					break;
				case '5':
					$title = '超市比价';
					$info = $this->module_model->get_market_data_info($id);
					break;
			}
			$data = array('type_id'=>$type,'info'=>$info,'title'=>$title);
			$this->load->view('module/localLife/serviceInfo.html',$data);
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
					$info = $this->module_model->del_service($id);
					break;
				case '2':
				
					$info = $this->module_model->del_houst($id);
					break;
				case '3':
					$info = $this->module_model->del_mark($id);
					break;
				case '5':
					$info = $this->module_model->del_market_data($id);
					break;
			}
			if($info){
				 echo "<script>alert('操作成功！');window.location.href='".site_url('module/localLife/serviceList/').$cate."'</script>";exit;
			}else{
				 echo "<script>alert('操作失败！');window.location.href='".site_url('module/localLife/serviceList/').$cate."'</script>";exit;
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
					$config['upload_path']      = 'upload/service';
					$config['allowed_types']    = 'gif|jpg|png|jpeg';
					$config['max_size']     = 2048;
					$config['file_name'] = date('Y-m-d_His');
					$this->load->library('upload', $config);
					// 上传
					if(!$this->upload->do_upload('img'.$i)) {
					   echo $this->upload->display_errors();
					}else{
						if($i != 4){
						$pic[]['banner'.$i] = 'upload/service/'.$this->upload->data('file_name');
						}else{
							$logo = 'upload/service/'.$this->upload->data('file_name');
						}
					}
				}
				$i++;
			 }
			$data['pic'] = json_encode($pic);
			 $data['logo'] = $logo;
			 if($this->module_model->add_service($data)){
				 echo "<script>alert('操作成功！');window.location.href='".site_url('module/localLife/serviceList/').$data['type_name']."'</script>";exit;
			 }else{
				 echo "<script>alert('操作失败！');window.location.href='".site_url('module/localLife/serviceList/').$data['type_name']."'</script>";exit;
			 }
			 
		}else{
			$this->load->view('404.html');
		}
	}
	
	//编辑普通信息
	function edit_service(){
		if($_POST){
			$data = $this->input->post();
			$pic = array();
			$i =1;
			foreach($_FILES as $file=>$val){
				if(!empty($_FILES['img'.$i]['name'])){
					$config['upload_path']      = 'upload/service';
					$config['allowed_types']    = 'gif|jpg|png|jpeg';
					$config['max_size']     = 2048;
					$config['file_name'] = date('Y-m-d_His');
					$this->load->library('upload', $config);
					//上传
					if(!$this->upload->do_upload('img'.$i)) {
					   echo $this->upload->display_errors();
					}else{
						if($i != 4){
							unset($data['img'.$i]);
						$pic[]['banner'.$i] = 'upload/service/'.$this->upload->data('file_name');
						}else{
							$logo = 'upload/service/'.$this->upload->data('file_name');
						}
					}
				}else{
					if($i != 4){
						if(!empty($data['img'.$i])){
							$pic[]['banner'.$i] = $data['img'.$i];
							unset($data['img'.$i]);
						}
					}else{
						$logo = $data['logo'];
					}
				}
				$i++;
			 }
			 $data['pic'] = json_encode($pic);
			 $data['logo'] = $logo;
			 if($this->module_model->edit_service($data['id'],$data)){
				 echo "<script>alert('操作成功！');window.location.href='".site_url('module/localLife/serviceList/').$data['type_name']."'</script>";exit;
			 }else{
				 echo "<script>alert('操作失败！');window.location.href='".site_url('module/localLife/serviceList/').$data['type_name']."'</script>";exit;
			 }
		}else{
			$this->load->view('404.html');
		}
	}
	
	//新增房产信息
	function add_houst(){
		if($_POST){
			
		}else{
			$this->load->view('404.html');
		}
	}
	
	


}
