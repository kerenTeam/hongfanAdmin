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
        $plateid = $this->user_model->group_permiss($this->session->users['gid']);
        $plateid = json_decode($plateid,true);
        if(!empty($plateid)){
            if(!in_array('0',$plateid) && !in_array('8',$plateid)){
                echo "<script>alert('您没有权限访问！');window.location.href='".site_url('/admin/index')."';</script>";exit;
            }
        }else{
             echo "<script>alert('您没有权限访问！');window.location.href='".site_url('/admin/index')."';</script>";exit;
        }
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
			$config['per_page'] = 10;
			//获取页码
			$current_page=intval($this->uri->segment(5));//index.php 后数第4个/
			//var_dump($current_page);
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
			if(empty($cate)){
				$this->load->view('404.html');
			}else{
				$type = '';
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
						//分类信息
						$type = $this->module_model->get_mark_type();
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
				$data = array('id'=>$id,'typeid'=>$cate['typeid'],'name'=>$cate['name'],'lists'=>$listpage,'page' => $this->pagination->create_links(),'type'=>$type);
				
				$this->load->view('module/localLife/serviceList.html',$data);
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
			$config['base_url'] = site_url('/module/localLife/serviceList/').$cate;
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
              $cates = $this->module_model->get_cateinfo($cate);
    		switch ($typeid) {
    			//普通信息
    			case '1':
    				//总数据
    				$list = $this->module_model->search_service($sear,$cate);
					$config['total_rows'] = count($list);
					// //分页数据
				    $listpage = $this->module_model->search_service_page($sear,$cate,$config['per_page'],$current_page);
    				break;
    				//房产
    			case '2':
    				//总数据
    				$list = $this->module_model->search_houst($sear);
					$config['total_rows'] = count($list);
					// //分页数据
				    $listpage = $this->module_model->search_houst_page($sear,$config['per_page'],$current_page);
    				break;
    			// 二手市场
	    		case '3':
	    			$list = $this->module_model->search_mark($sear);
					$config['total_rows'] = count($list);
					// //分页数据
				    $listpage = $this->module_model->search_mark_page($sear,$config['per_page'],$current_page);
                    //分类信息
                    $type = $this->module_model->get_mark_type();
	    			break;
                    //快递上门
                case '4':
                    $list = $this->module_model->search_express($sear);
                    $config['total_rows'] = count($list);
                    // //分页数据
                    $listpage = $this->module_model->search_express_page($sear,$config['per_page'],$current_page);
                    break;
                    //超市比价
                case '5':
                    $list = $this->module_model->search_market_data($sear);
                    $config['total_rows'] = count($list);
                    // //分页数据
                    $listpage = $this->module_model->search_market_data_page($sear,$config['per_page'],$current_page);
                    break;
    		}
			$this->load->library('pagination');//加载ci pagination类
			$this->pagination->initialize($config);
    		$data = array('id'=>$cate,'typeid'=>$typeid,'name'=>'搜索结果','lists'=>$listpage,'page' => $this->pagination->create_links(),'type'=>$type,'catename'=>$cates['name']);
    		$this->load->view('module/localLife/serviceList.html',$data);

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
            $cate = $this->module_model->get_cateinfo($cateid);
			switch($type){
				case '1':
					//$title = '普通信息';
					$info = $this->module_model->get_serviceinfo($id);
					break;
				case '2':
					//$title = '房产信息';
					$info = $this->module_model->get_houstinfo($id);
					break;
				case '3':
					//$title = '二手市场';
					$info = $this->module_model->get_markinfo($id);
					$tag = $this->module_model->get_mark_type();
					break;
				case '5':
					//$title = '超市比价';
					$info = $this->module_model->get_market_data_info($id);
					break;
			}
			$data = array('type_id'=>$type,'info'=>$info,'title'=>$cate['name'],'cateid'=>$cateid,'type'=>$tag);
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
					$config['upload_path']      = 'upload/service/ordinary';
					$config['allowed_types']    = 'gif|jpg|png|jpeg';
					$config['max_size']     = 2048;
					$config['file_name'] = date('Y-m-d_His');
					$this->load->library('upload', $config);
					// 上传
					if(!$this->upload->do_upload('img'.$i)) {
					   echo $this->upload->display_errors();
					}else{
						if($i != 4){
						$pic[]['banner'] = 'upload/service/ordinary/'.$this->upload->data('file_name');
						}else{
							$logo = 'upload/service/ordinary/'.$this->upload->data('file_name');
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

	//新增房产信息
	function add_houst(){
		if($_POST){
			$data = $this->input->post();
			$pic = array();
			$i =1;
			foreach($_FILES as $file=>$val){
				if(!empty($_FILES['img'.$i]['name'])){
					$config['upload_path']      = 'upload/service/houst';
					$config['allowed_types']    = 'gif|jpg|png|jpeg';
					$config['max_size']     = 2048;
					$config['file_name'] = date('Y-m-d_His');
					$this->load->library('upload', $config);
					//上传
					if(!$this->upload->do_upload('img'.$i)) {
					   echo $this->upload->display_errors();
					}else{
						if($i != 4){
							$pic[]['picImg'] = 'upload/service/houst/'.$this->upload->data('file_name');
						}else{
							$logo = 'upload/service/houst/'.$this->upload->data('file_name');
						}
					}
				}
				$i++;
			 }
			 $data['pic'] =json_encode($pic);
			 $data['list_pic'] = $logo;
			 $data['userid'] = $this->session->users['user_id'];
			 $id = $data['type_id'];
			 unset($data['type_id']);
			 if($this->module_model->add_houst($data)){
				  echo "<script>alert('操作成功！');window.location.href='".site_url('module/localLife/serviceList/').$id."'</script>";exit;
			 }else{
				  echo "<script>alert('操作失败！');window.location.href='".site_url('module/localLife/serviceList/').$id."'</script>";exit;
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
					$config['upload_path']      = 'upload/service/mark';
					$config['allowed_types']    = 'gif|jpg|png|jpeg';
					$config['max_size']     = 2048;
					$config['file_name'] = date('Y-m-d_His');
					$this->load->library('upload', $config);
					//上传
					if(!$this->upload->do_upload('img'.$i)) {
					   echo $this->upload->display_errors();
					}else{
						if($i != 4){
							$pic[]['picImg'] = 'upload/service/mark/'.$this->upload->data('file_name');
						}else{
							$logo = 'upload/service/mark/'.$this->upload->data('file_name');
						}
					}
				}
				$i++;
			}
			$data['pic'] = json_encode($pic);
			$data['list_pic'] = $logo;
			$data['userid'] = $this->session->users['user_id'];
			$type= $data['id'];
			unset($data['id']);
			if($this->module_model->add_market($data)){
				echo "<script>alert('操作成功！');window.location.href='".site_url('module/localLife/serviceList/').$type."'</script>";exit;
			}else{
				echo "<script>alert('操作失败！');window.location.href='".site_url('module/localLife/serviceList/').$type."'</script>";exit;
			}
		}else{
			$this->load->view('404.html');
		}
	}
	//编辑
	function edit_service(){
		if($_POST){
			$data = $this->input->post();
			$pic = array();
			switch($data['type_id']){
				case '1':
					$i =1;
					foreach($_FILES as $file=>$val){
						if(!empty($_FILES['img'.$i]['name'])){
							$config['upload_path']      = 'upload/service/ordinary';
							$config['allowed_types']    = 'gif|jpg|png|jpeg';
							$config['max_size']     = 2048;
							$config['file_name'] = date('Y-m-d_His');
							$this->load->library('upload', $config);
							//上传
							if(!$this->upload->do_upload('img'.$i)) {
							   echo $this->upload->display_errors();
							}else{
								unset($data['img'.$i]);
								if($i != 4){
									$pic[]['banner'] = 'upload/service/ordinary/'.$this->upload->data('file_name');
								}else{
									$logo = 'upload/service/ordinary/'.$this->upload->data('file_name');
								}
							}
						}else{
							if($i != 4){
								if(!empty($data['img'.$i])){
									$pic[]['banner'] = $data['img'.$i];
								}
							}else{
								$logo = $data['logo'];
							}
                            unset($data['img'.$i]);
						}
						$i++;
					 }
					 $data['pic'] = json_encode($pic);
					 $data['logo'] = $logo;
					 $type = $data['type_id'];
					 unset($data['type_id']);
					 $isOk = $this->module_model->edit_service($data['id'],$data);
					break;
					//房产
				case '2':
					$i =1;
					foreach($_FILES as $file=>$val){
						if(!empty($_FILES['img'.$i]['name'])){
							$config['upload_path']      = 'upload/service/houst';
							$config['allowed_types']    = 'gif|jpg|png|jpeg';
							$config['max_size']     = 2048;
							$config['file_name'] = date('Y-m-d_His');
							$this->load->library('upload', $config);
							//上传
							if(!$this->upload->do_upload('img'.$i)) {
							   echo $this->upload->display_errors();
							}else{
                                unset($data['img'.$i]);
								if($i != 4){
								$pic[]['picImg'] = 'upload/service/houst/'.$this->upload->data('file_name');
								}else{
									$logo = 'upload/service/houst/'.$this->upload->data('file_name');
								}
							}
						}else{
                            
							if($i != 4){
								if(!empty($data['img'.$i])){
									$pic[]['picImg'] = $data['img'.$i];
									// /unset($data['img'.$i]);
								}
							}else{
								$logo = $data['logo'];
							}
                            unset($data['img'.$i]);
						}
						$i++;
					 }
					 $data['pic'] = json_encode($pic);
					 $data['list_pic'] = $logo;
					 $type = $data['type_id'];
					 unset($data['type_id']);
			 		$isOk = $this->module_model->edit_houst($data['id'],$data);
					break;
					//二手市场
				case '3':
					$i = '1';
					foreach($_FILES as $file=>$val){
						if(!empty($_FILES['img'.$i]['name'])){
							$config['upload_path']      = 'upload/service/mark';
							$config['allowed_types']    = 'gif|jpg|png|jpeg';
							$config['max_size']     = 2048;
							$config['file_name'] = date('Y-m-d_His');
							$this->load->library('upload', $config);
							//上传
							if(!$this->upload->do_upload('img'.$i)) {
							   echo $this->upload->display_errors();
							}else{
								unset($data['img'.$i]);
								if($i != 4){
									$pic[]['picImg'] = 'upload/service/mark/'.$this->upload->data('file_name');
								}else{
									$logo = 'upload/service/mark/'.$this->upload->data('file_name');
								}
							}
						}else{
							if($i != 4){
								if(!empty($data['img'.$i])){
									$pic[]['picImg'] = $data['img'.$i];
								}
							}else{
								$logo = $data['list_pic'];
							}
							unset($data['img'.$i]);
						}
						$i++;
					}
					$data['pic'] = json_encode($pic);
					$data['list_pic'] = $logo;
					$type = $data['type_id'];
					unset($data['type_id']);
					$isOk = $this->module_model->edit_markinfo($data['id'],$data);
					break;
					//超市比价
				case '5':
						$type = $data['type_id'];
						$cate = $data['cate'];
						$data['date'] = date('Y-m-d H:i:s');
						unset($data['type_id'],$data['cate']);
						if($this->module_model->edit_market_info($data['id'],$data)){
							echo "<script>alert('操作成功！');window.location.href='".site_url('module/localLife/serviceList/').$cate."'</script>";exit;
						}else{
							echo "<script>alert('操作失败！');window.location.href='".site_url('module/localLife/serviceList/').$cate."'</script>";exit;
						}
					break;
			}
			if($isOk){
				echo "<script>alert('操作成功！');window.location.href='".site_url('module/localLife/serviceInfo/').$data['id'].'/'.$type."'</script>";exit;
			}else{
				echo "<script>alert('操作失败！');window.location.href='".site_url('module/localLife/serviceInfo/').$data['id'].'/'.$type."'</script>";exit;
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
			if($this->module_model->add_market_data($data)){
				echo "<script>alert('操作成功！');window.location.href='".site_url('module/localLife/serviceList/').$id."'</script>";exit;
			}else{
				echo "<script>alert('操作失败！');window.location.href='".site_url('module/localLife/serviceList/').$id."'</script>";exit;
			}
		}else{
			$this->load->view('404.html');
		}
	}

	//导入超市比价
	function send_market_data(){
		  $name = date('Y-m-d');
		  $inputFileName = "./upload/xls/" .$name .'.xls';
	      move_uploaded_file($_FILES["file"]["tmp_name"],$inputFileName);
	        //引入类库
	      $this->load->library('excel');
	        if(!file_exists($inputFileName)){
	                echo "<script>alert('文件导入失败!');window.location.href='".site_url('module/localLife/serviceList/8')."'</script>";
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
	            $data['market_name'] = $PHPExcel->getActiveSheet()->getCell("A".$currentRow)->getValue();//获取A列的值
	            $data['goods_name'] = $PHPExcel->getActiveSheet()->getCell("B".$currentRow)->getValue();//获取B列的值
	            $data['date_price'] = $PHPExcel->getActiveSheet()->getCell("C".$currentRow)->getValue();//获取c列的值
	            $data['unit'] = $PHPExcel->getActiveSheet()->getCell("D".$currentRow)->getValue();//获取c列的值
	            $data['date'] = date('Y-m-d H:i:s');
	            $data['import_user'] = $this->session->users['user_id'];
	            if($data['market_name'] == NULL){
	                exit;
	            }
	            //插入数据库
	            // $where = array('property_id'=>$property_id,'unit_no'=>$unit_no);
	            $import =  $this->db->insert('hf_local_market_data',$data); 
	         }
	     //删除临时文件
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
	        $market = $this->module_model->get_market_data();
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

	        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
	        $objWriter->save('php://output');
		}
	}



}
