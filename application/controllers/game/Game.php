<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Default_Controller.php');
/**
* 
*/
class Game extends Default_Controller
{
	

	public $view_gameList = 'game/gameList.html';
	public $view_gameInfo = 'game/gameInfo.html';
	public $view_awardRecord = 'game/awardRecord.html';


	function __construct()
	{
		parent::__construct();	
		$this->load->model('Game_model');

	}

	//游戏奖品
	function gameList(){
		//返回所有奖品
		$data['prize'] = $this->Game_model->select_prize('2');

		$data['page'] = $this->view_gameList;
        $data['menu'] = array('game','gameList');
        $this->load->view('template.html',$data);

	}
	//新增奖品
	function add_prize(){
		if($_POST){
			$data = $this->input->post();


		}else{
			$this->load->view('404.html');
		}
	}

	//返回卷
	function ret_shop_coupon(){
		if($_POST){
			$list = $this->Game_model->select_coupon();
			if(!empty($list)){
				echo json_encode($list);
			}else{
				echo "2";
			}

		}else{	
			echo "2";
		}
	}


	//删除游戏奖品
	function del_prize(){
		if($_POST){
			$id = $this->input->post('id');
			if($this->Game_model->del_prize($id)){
				$log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."删除了游戏奖品，奖品ID是：".$id,
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

	//y=游戏内容
	function gameInfo(){
		//获取游戏详情
		$data['game'] = $this->Game_model->select_game_info('2');
		

		$data['page'] = $this->view_gameInfo;
        $data['menu'] = array('game','gameList');
        $this->load->view('template.html',$data);

	}

	//编辑游戏详情
	function edit_game(){
		if($_POST){
			$data= $this->input->post();

			$header = array("token:".$_SESSION['token'],'city:'.'1');    
			if(!empty($_FILES['bgi']['name'])){
                    $tmpfile = new CURLFile(realpath($_FILES['bgi']['tmp_name']));
                
                    $pics = array(
                        'pics' =>$tmpfile,
                        'porfix'=>'game/gamebgi',
                        'bucket'=>'cqcother',
                    );
				
					$qiuniu = json_decode(curl_post_express($header,QINIUUPLOAD,$pics),true);

					if($qiuniu['errno'] == '0'){
						$img = json_decode($qiuniu['data']['img'],true);
						$icon[]['picImg'] =$img[0]['picImg'];
						$data['BGI'] = json_encode($icon);
					}else{
					  echo "<script>alert('图片上传失败！');window.location.href='".site_url('/friends/Friends/circle')."'</script>";exit;
					}
            }
            if(!empty($_FILES['fei']['name'])){
                    $tmpfile = new CURLFile(realpath($_FILES['fei']['tmp_name']));
                
                    $pics = array(
                        'pics' =>$tmpfile,
                        'porfix'=>'game/gamebgi',
                        'bucket'=>'cqcother',
                    );
				
					$qiuniu = json_decode(curl_post_express($header,QINIUUPLOAD,$pics),true);

					if($qiuniu['errno'] == '0'){
						$img = json_decode($qiuniu['data']['img'],true);
						$icon[]['picImg'] =$img[0]['picImg'];
						$data['FEI'] = json_encode($icon);
					}else{
					  echo "<script>alert('图片上传失败！');window.location.href='".site_url('/game/Game/gameInfo')."'</script>";exit;
					}
            }

            $data['startTime'] = strtotime($data['starttime']. ' 00:00:00')*1000;
            $data['endTime'] = strtotime($data['endtime'].' 23:59:59')*1000;
            unset($data['starttime'],$data['endtime']);
            
            if($this->Game_model->edit_game($data['id'],$data)){
            	$log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."编辑了游戏详情",
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/game/Game/gameInfo')."'</script>";exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/game/Game/gameInfo')."'</script>";exit;

            }
		}else{
			$this->load->view('404.html');
		}
	}

	//
	function awardRecord(){
		//返回所有中奖纪录
		$config['per_page'] = 10;
        //获取页码
        $current_page=intval($this->uri->segment(4));//index.php 后数第4个/
        //配置
        $config['base_url'] = site_url('/game/Game/awardRecord');
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
        $list = $this->Game_model->select_history('2');

        $config['total_rows'] = count($list);

        // //分页数据
        $listpage = $this->Game_model->select_history_page('2',$config['per_page'],$current_page);
          $this->load->library('pagination');//加载ci pagination类

            $this->pagination->initialize($config);

        //获取所有奖品
        $prize = $this->Game_model->select_prize('2');

        $data = array('lists'=>$listpage,'count'=>count($list),'pages' => $this->pagination->create_links(),'prize'=>$prize);


		$data['page'] = $this->view_awardRecord;
        $data['menu'] = array('game','awardRecord');
        $this->load->view('template.html',$data);

	}

	//
	function search_history(){
		$config['per_page'] = 10;
        //获取页码
        $current_page=intval($this->input->get("size"));//index.php 后数第4个/

      
        $startTime = $this->input->get('begin_time');
        $endTime = $this->input->get('end_time');
        $prize = $this->input->get('prize');
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

        $config['page_query_string'] = TRUE;//关键配置
        // $config['reuse_query_string'] = FALSE;
        $config['query_string_segment'] = 'size';
        $config['base_url'] = site_url('/game/Game/search_history?').'prize='.$prize.'&begin_time='.$startTime.'&end_time='.$endTime;

        if(!empty($startTime)){
    		$time = strtotime($startTime.' 00:00:00')*1000;
    		$endtime = strtotime($endTime.' 23:59:59')*1000;
    	}else{
    		$time= '';
    		$endtime='';
    	}
    	$list = search_history($time,$endtime,$prize);
    	$config['total_rows'] = count($list);

    	//分页数据
    	$listpage = search_history_page($time,$endtime,$prize,$config['per_page'],$current_page);
       	$prize = $this->Game_model->select_prize('2');

      
        $this->load->library('pagination');//加载ci pagination类

        $this->pagination->initialize($config);

        $data = array('lists'=>$listpage,'count'=>count($list),'pages' => $this->pagination->create_links(),'prize'=>$prize);

		$data['page'] = $this->view_awardRecord;
        $data['menu'] = array('game','awardRecord');
        $this->load->view('template.html',$data);
	}







}