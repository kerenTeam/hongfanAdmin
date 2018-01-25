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
		$this->load->model('Public_model');

	}

	//游戏奖品
	function gameList(){
        //返回所有奖品
        $id = intval($this->uri->segment('4'));
        if($id =='0'){
            $this->load->view('404.html');
        }else{
            $data['prize'] = $this->Game_model->select_prize($id);
            $data['id'] = $id;

            $data['page'] = $this->view_gameList;
            $data['menu'] = array('game', 'gameList');
            $this->load->view('template.html', $data);
        }       
	}


	//新增奖品
	function add_prize(){
		if($_POST){
			$data = $this->input->post();

            if($data['type'] == '2'){
                $data['hiValue'] = $data['value'];
            }else if($data['type'] =='3'){
                $data['redPocket'] = $data['value']; 
            }else if($data['type'] =='4'){
                $data['giftId'] = '23'; 
            }
            unset($data['value'],$data['type']);
            // $data['gameId'] = '2';
   
            //所有奖品库存
            $prize = $this->Game_model->select_prize($data['gameId']);
            $stock = 0;
            foreach ($prize as $key => $value) {
                $stock = $stock + $value['stock'];
            }
            if(count($prize) < '12'){
                if($this->Game_model->add_prize($data)){
                     $a = edit_game_prize($data['gameId']);
                     $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  

                        "content" => $_SESSION['users']['username']."新增了一个游戏奖品，奖品名称是".$data['title'],
                        "create_time" => date('Y-m-d H:i:s'),

                        "userip" => get_client_ip(),

                    );
                    $this->db->insert('hf_system_journal',$log);
                     echo "<script>alert('操作成功！');window.location.href='".site_url('/game/Game/gameList/'.$data['gameId'])."'</script>";exit;
                }else{
                     echo "<script>alert('操作失败！');window.location.href='".site_url('/game/Game/gameList/'.$data['gameId'])."'</script>";exit;
                }
            }else{
                echo "<script>alert('奖品类别数量超过APP限制！');window.location.href='".site_url('/game/Game/gameList/'.$data['gameId'])."'</script>";exit;
            }
		}else{
			$this->load->view('404.html');
		}
	}

    //编辑奖品
    function edit_prize(){
        if($_POST){
            $data = $this->input->post();            
            if($data['type'] == '2'){
                unset($data['couponId']);
                $data['hiValue'] = $data['value'];
                $data['redPocket']=NULL;
                $data['giftId'] =NULL;
                $data['couponId']=NULL;
            }else if($data['type'] =='3'){
                unset($data['couponId']);
                $data['redPocket'] = $data['value']; 
                $data['giftId'] =NULL;
                $data['hiValue'] =NULL;
                $data['couponId']=NULL;
            }else if($data['type'] =='4'){
                unset($data['couponId']);
                $data['giftId'] = '23'; 
                $data['hiValue']=NULL;
                $data['redPocket']=NULL;
                $data['couponId']=NULL;
            }else if($data['type'] == '5'){
                unset($data['couponId']);
                $data['hiValue']=NULL;
                $data['redPocket']=NULL;
                $data['giftId'] =NULL;
                $data['couponId']=NULL;
            }
            unset($data['value'],$data['type']);
    
            if($this->Game_model->edit_prize($data['id'],$data)){
                $a = edit_game_prize($data['gameId']);
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."修改了游戏奖品，奖品名称是".$data['title'],
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                $this->db->insert('hf_system_journal',$log);
                echo "<script>alert('操作成功！');window.location.href='".site_url('/game/Game/gameList/'.$data['gameId'])."'</script>";exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/game/Game/gameList/'.$data['gameId'])."'</script>";exit;
            }
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

    //返回游戏列表
    function gameLists(){
        $data['game'] = $this->Game_model->selectGame();
        $data['page'] = '/game/gameLists.html';
        $data['menu'] = array('game', 'gameInfo');
        $this->load->view('template.html', $data);
    }



	//y=游戏内容
	function gameInfo(){
        //获取游戏详情
        $id = intval($this->uri->segment(4));
        if($id == '0'){
            $this->load->view('404.html');
        }else{
            $data['game'] = $this->Game_model->select_game_info($id);
            $data['page'] = $this->view_gameInfo;
            $data['menu'] = array('game', 'gameInfo');
            $this->load->view('template.html', $data);
        }
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
					  echo "<script>alert('图片上传失败！');window.location.href='".site_url('/game/Game/gameLists')."'</script>";exit;
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
					  echo "<script>alert('图片上传失败！');window.location.href='".site_url('/game/Game/gameLists')."'</script>";exit;
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

                echo "<script>alert('操作成功！');window.location.href='".site_url('/game/Game/gameLists')."'</script>";exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/game/Game/gameLists')."'</script>";exit;

            }
		}else{
			$this->load->view('404.html');
		}
	}

	//
	function awardRecord(){
        $id = intval($this->uri->segment('4'));
        if($id == '0'){
            $this->load->view('404.html');
        }else{
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
            $list = $this->Game_model->select_history($id);

            $config['total_rows'] = count($list);

            // //分页数据
            $listpage = $this->Game_model->select_history_page($id,$config['per_page'],$current_page);
              $this->load->library('pagination');//加载ci pagination类

                $this->pagination->initialize($config);

            //获取所有奖品
            $prize = $this->Game_model->select_prize($id);

            $data = array('lists'=>$listpage,'count'=>count($list),'pages' => $this->pagination->create_links(),'prize'=>$prize,'id'=>$id);


            $data['page'] = $this->view_awardRecord;
            $data['menu'] = array('game','gameInfo');
            $this->load->view('template.html',$data);


        }
	
	}

    //返回中奖纪录
    function retHistory(){
        if($_POST){
            $startTime = $this->input->post('begin_time');
            $endTime = $this->input->post('end_time');
            $prize = $this->input->post('prize');
            $gameId = $this->input->post('gameId');

            $page = $this->input->post('start');
            $size = $this->input->post('count');

            if(!empty($startTime)){
                $time = strtotime($startTime.' 00:00:00')*1000;
                $endtime = strtotime($endTime.' 23:59:59')*1000;
            }else{
                $time= '';
                $endtime='';
            }


            $list = search_history($time,$endtime,$prize,$gameId);
            $listpage = search_history_page($time,$endtime,$prize,$size,$page,$gameId);
          
            if(!empty($listpage)){
                echo json_encode(['total'=>count($list),'subjects'=>$listpage]);
            }else{
                echo "2";
            }

        }else{
            echo "2";
        }
    }


	//
	// function search_history(){
	// 	$config['per_page'] = 10;
 //        //获取页码
 //        $current_page=intval($this->input->get("size"));//index.php 后数第4个/

      
 //        $startTime = $this->input->get('begin_time');
 //        $endTime = $this->input->get('end_time');
 //        $prize = $this->input->get('prize');
 //        // var_dump($_GET);

 //        //分页配置
 //        $config['full_tag_open'] = '<ul class="am-pagination tpl-pagination">';

 //        $config['full_tag_close'] = '</ul>';

 //        $config['first_tag_open'] = '<li>';

 //        $config['first_tag_close'] = '</li>';

 //        $config['prev_tag_open'] = '<li>';

 //        $config['prev_tag_close'] = '</li>';

 //        $config['next_tag_open'] = '<li>';

 //        $config['next_tag_close'] = '</li>';

 //        $config['cur_tag_open'] = '<li class="am-active"><a>';

 //        $config['cur_tag_close'] = '</a></li>';

 //        $config['last_tag_open'] = '<li>';

 //        $config['last_tag_close'] = '</li>';

 //        $config['num_tag_open'] = '<li>';

 //        $config['num_tag_close'] = '</li>';
 //        $config['first_link']= '首页';

 //        $config['next_link']= '下一页';

 //        $config['prev_link']= '上一页';

 //        $config['last_link']= '末页';

 //        $config['page_query_string'] = TRUE;//关键配置
 //        // $config['reuse_query_string'] = FALSE;
 //        $config['query_string_segment'] = 'size';
 //        $config['base_url'] = site_url('/game/Game/search_history?').'prize='.$prize.'&begin_time='.$startTime.'&end_time='.$endTime;

 //        if(!empty($startTime)){
 //    		$time = strtotime($startTime.' 00:00:00')*1000;
 //    		$endtime = strtotime($endTime.' 23:59:59')*1000;
 //    	}else{
 //    		$time= '';
 //    		$endtime='';
 //    	}
 //    	$list = search_history($time,$endtime,$prize);
 //    	$config['total_rows'] = count($list);

 //    	//分页数据
 //    	$listpage = search_history_page($time,$endtime,$prize,$config['per_page'],$current_page);
 //       	$prize = $this->Game_model->select_prize('2');

      
 //        $this->load->library('pagination');//加载ci pagination类

 //        $this->pagination->initialize($config);

 //        $data = array('lists'=>$listpage,'count'=>count($list),'pages' => $this->pagination->create_links(),'prize'=>$prize);

	// 	$data['page'] = $this->view_awardRecord;
 //        $data['menu'] = array('game','awardRecord');
 //        $this->load->view('template.html',$data);
	// }



    //红包提现
    function withdrawals(){
        $config['per_page'] = 10;
        //获取页码
        $current_page=intval($this->uri->segment(4));//index.php 后数第4个/
        //配置
        $config['base_url'] = site_url('/game/Game/withdrawals');
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

        $config['num_links'] = 3;
        $config['use_page_numbers'] = TRUE;

        $config['last_link']= '末页';
        $list = $this->Game_model->retWithdrawals();
        $price = '0';
        $shen = '0';
        $yi = '0';
        $dai = '0';
        foreach ($list as $k => $v) {
            // var_dump($v);
            $price +=$v['redPocket'];
            //1申请提现 2已经提现 0否
            if($v['withsrawls'] == '1'){
                $shen +=$v['redPocket'];
            }else if($v['withsrawls'] == '2'){
                $yi +=$v['redPocket'];
            }else if($v['withsrawls'] == '0'){
                $dai +=$v['redPocket'];
            }
        }
      

        $config['total_rows'] = count($list);

        // //分页数据
        $listpage = $this->Game_model->retWithdrawals_page($config['per_page'],$current_page);
        $this->load->library('pagination');//加载ci pagination类
        $this->pagination->initialize($config);
        //获取奖项
        $prize = $this->Game_model->select_prize('3');
    
        $data = array('lists'=>$listpage,'count'=>count($list),'pages' => $this->pagination->create_links(),'prize'=>$prize,'zong'=>$price,'shen'=>$shen,'yi'=>$yi,'dai'=>$dai);

        $data['page'] = 'game/withdrawals.html';
        $data['menu'] = array('game','withdrawals');
        $this->load->view('template.html',$data);
    }




    //修改提现状态
    function edit_withdrawals(){
        $id = intval($this->uri->segment('4'));
        if($id == '0'){
            $this->load->view('404.html');
        }else{
            $data['withsrawls'] = '2';

            if($this->Game_model->edit_withdrawals($id,$data)){
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."修改了红包提现状态",
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/game/Game/withdrawals')."'</script>";exit;
            } else{

                echo "<script>alert('操作失败！');window.location.href='".site_url('/game/Game/withdrawals')."'</script>";exit;
            }
        }
    }

    //修改用户所有纪录
    function editPhoneWithdrawals(){
        $phone = intval($this->uri->segment('4'));
        if($phone == '0'){
            $this->load->view('404.html');
        }else{
            $data['withsrawls'] = '2';
            if($this->Game_model->editPhonewithdrawals($phone,$data)){
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."修改了红包提现状态",
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/game/Game/withdrawals')."'</script>";exit;
            } else{

                echo "<script>alert('操作失败！');window.location.href='".site_url('/game/Game/withdrawals')."'</script>";exit;
            }
        }
    }

    //返回红包提现纪录
    //返回红包提现纪录
    function retWithdrawalsList(){
        if($_POST){

            $prizeId = $this->input->post('prizeId');
            $withdrawals = $this->input->post('withsrawls');
            $phone = $this->input->post('phone');

            $page = $this->input->post('start');
            $size = $this->input->post('count');
            if($page != '0'){
                $_SESSION['withsrawls'] = $page;
            }
            if(!empty($prizeId) && empty($withdrawals) && empty($phone)){
                $list = $this->Game_model->search_where_withsrawls('prizeId',$prizeId);
               

                //分页数据
                $listpage = $this->Game_model->search_where_withsrawls_page('prizeId',$prizeId,$size,$page);
            }else  if(empty($prizeId) && !empty($withdrawals) && empty($phone)){
                if($withdrawals == '3'){
                    $withdrawals = '0';
                }
                $list = $this->Game_model->search_where_withsrawls('withsrawls',$withdrawals);
               

                //分页数据
                $listpage = $this->Game_model->search_where_withsrawls_page('withsrawls',$withdrawals,$size,$page);
            }else  if(empty($prizeId) && empty($withdrawals) && !empty($phone)){
                $list = $this->Game_model->search_where_withsrawls('phone',$phone);
               

                //分页数据
                $listpage = $this->Game_model->search_where_withsrawls_page('phone',$phone,$size,$page);
       

            }else  if(!empty($prizeId) && !empty($withdrawals) && empty($phone)){
                if($withdrawals == '3'){
                    $withdrawals = '0';
                }
                $list = $this->Game_model->search_withsrawls($prizeId,$withdrawals);
               

                //分页数据
                $listpage = $this->Game_model->search_withsrawls_page($prizeId,$withdrawals,$size,$page);

            }else  if(!empty($prizeId) && empty($withdrawals) && !empty($phone)){
                $list = $this->Game_model->search_Maywhere_withsrawls('prizeId',$prizeId,'phone',$phone);
               

                //分页数据
                $listpage = $this->Game_model->search_Maywhere_withsrawls_page('prizeId',$prizeId,'phone',$phone,$size,$page);

            }else  if(empty($prizeId) && !empty($withdrawals) && !empty($phone)){
                if($withdrawals == '3'){
                    $withdrawals = '0';
                }
                $list = $this->Game_model->search_Maywhere_withsrawls('withsrawls',$withdrawals,'phone',$phone);
               

                //分页数据
                $listpage = $this->Game_model->search_Maywhere_withsrawls_page('withsrawls',$withdrawals,'phone',$phone,$size,$page);


            }else  if(!empty($prizeId) && !empty($withdrawals) && !empty($phone)){
                if($withdrawals == '3'){
                    $withdrawals = '0';
                }
                $list = $this->Game_model->search_Threewithsrawls($prizeId,$withdrawals,$phone);
               

                //分页数据
                $listpage = $this->Game_model->search_Threewithsrawls_page($prizeId,$withdrawals,$phone,$size,$page);

               
            }else if(empty($prizeId) && empty($withdrawals) && empty($phone)){
                $list = $this->Game_model->select_withdrawals();
               

                //分页数据
                $listpage = $this->Game_model->select_withdrawals_page($size,$page);
            }

            if(!empty($listpage)){
                echo json_encode(['total'=>count($list),'subjects'=>$listpage]);
            }else{
                echo "2";
            }

        }else{
            echo "2";
        }
    }


    //搜索红包提现纪录
    function search_withsrawls(){
        $config['per_page'] = 10;
        //获取页码
        $current_page=intval($this->input->get("size"));//index.php 后数第4个/

      
        $prizeId = $this->input->get('prizeId');
        $phone = $this->input->get('phone');
        $withdrawals = $this->input->get('withsrawls');
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
        $config['num_links'] = 3;
        $config['use_page_numbers'] = TRUE;


        $config['query_string_segment'] = 'size';
        $config['base_url'] = site_url('/game/Game/search_withsrawls?').'prizeId='.$prizeId.'&withsrawls='.$withdrawals;

        if(!empty($prizeId) && empty($withdrawals) && empty($phone)){
                $list = $this->Game_model->search_where_withsrawls('prizeId',$prizeId);
               
                   $config['total_rows'] = count($list);
                //分页数据
                $listpage = $this->Game_model->search_where_withsrawls_page('prizeId',$prizeId,$config['per_page'],$current_page);
            }else  if(empty($prizeId) && !empty($withdrawals) && empty($phone)){
                if($withdrawals == '3'){
                    $withdrawals = '0';
                }
                $list = $this->Game_model->search_where_withsrawls('withsrawls',$withdrawals);
               
                   $config['total_rows'] = count($list);
                //分页数据
                $listpage = $this->Game_model->search_where_withsrawls_page('withsrawls',$withdrawals,$config['per_page'],$current_page);
            }else  if(empty($prizeId) && empty($withdrawals) && !empty($phone)){
                $list = $this->Game_model->search_where_withsrawls('a.phone',$phone);
               
                   $config['total_rows'] = count($list);
                //分页数据
                $listpage = $this->Game_model->search_where_withsrawls_page('a.phone',$phone,$config['per_page'],$current_page);
       

            }else  if(!empty($prizeId) && !empty($withdrawals) && empty($phone)){
                if($withdrawals == '3'){
                    $withdrawals = '0';
                }
                $list = $this->Game_model->search_withsrawls($prizeId,$withdrawals);
               
                   $config['total_rows'] = count($list);
                //分页数据
                $listpage = $this->Game_model->search_withsrawls_page($prizeId,$withdrawals,$config['per_page'],$current_page);

            }else  if(!empty($prizeId) && empty($withdrawals) && !empty($phone)){
                $list = $this->Game_model->search_Maywhere_withsrawls('prizeId',$prizeId,'phone',$phone);
               
                   $config['total_rows'] = count($list);
                //分页数据
                $listpage = $this->Game_model->search_Maywhere_withsrawls_page('prizeId',$prizeId,'phone',$phone,$config['per_page'],$current_page);

            }else  if(empty($prizeId) && !empty($withdrawals) && !empty($phone)){
                if($withdrawals == '3'){
                    $withdrawals = '0';
                }
                $list = $this->Game_model->search_Maywhere_withsrawls('withsrawls',$withdrawals,'phone',$phone);
               
                   $config['total_rows'] = count($list);
                //分页数据
                $listpage = $this->Game_model->search_Maywhere_withsrawls_page('withsrawls',$withdrawals,'phone',$phone,$config['per_page'],$current_page);


            }else  if(!empty($prizeId) && !empty($withdrawals) && !empty($phone)){
                if($withdrawals == '3'){
                    $withdrawals = '0';
                }
                $list = $this->Game_model->search_Threewithsrawls($prizeId,$withdrawals,$phone);
               
                   $config['total_rows'] = count($list);
                //分页数据
                $listpage = $this->Game_model->search_Threewithsrawls_page($prizeId,$withdrawals,$phone,$config['per_page'],$current_page);

               
            }else if(empty($prizeId) && empty($withdrawals) && empty($phone)){
                $list = $this->Game_model->select_withdrawals();
               
                   $config['total_rows'] = count($list);
                //分页数据
                $listpage = $this->Game_model->select_withdrawals_page($config['per_page'],$current_page);
            }
       

        $this->load->library('pagination');//加载ci pagination类
        $this->pagination->initialize($config);
        $prize = $this->Game_model->select_prize('3');
        $price = '0';
        $shen = '0';
        $yi = '0';
        $dai = '0';
        foreach ($list as $k => $v) {
            // var_dump($v);
            $price +=$v['redPocket'];
            //1申请提现 2已经提现 0否
            if($v['withsrawls'] == '1'){
                $shen +=$v['redPocket'];
            }else if($v['withsrawls'] == '2'){
                $yi +=$v['redPocket'];
            }else if($v['withsrawls'] == '0'){
                $dai +=$v['redPocket'];
            }
        }
    
        $data = array('lists'=>$listpage,'count'=>count($list),'pages' => $this->pagination->create_links(),'prize'=>$prize,'zong'=>$price,'shen'=>$shen,'yi'=>$yi,'dai'=>$dai,'phone'=>$phone);

        $data['page'] = 'game/withdrawals.html';
        $data['menu'] = array('game','withdrawals');
        $this->load->view('template.html',$data);
    }

    //导出红包纪录
    function Import_withdrawals(){
        if($_POST){
            $prizeId = $this->input->post('prizeid'); 
            $withdrawals = $this->input->post('state'); 
            $starttime = $this->input->post('begin_time');
            $end_time = $this->input->post('end_time');

            if(!empty($starttime)){
                $time = strtotime($starttime.' 00:00:00')*1000;
                $endtime = strtotime($end_time.' 23:59:59')*1000;
            }else{
                $time= '';
                $endtime='';
            }

            $this->load->library('excel');

            //activate worksheet number 1

            $this->excel->setActiveSheetIndex(0);

            //name the worksheet

            $this->excel->getActiveSheet()->setTitle('ImportOrder');

            $arr_title = array(

                'A' => '编号',

                'B' => '奖品名称',
                'C' => '奖品名称',

                'D' => '用户名称',

                'E' => '用户手机号',

                'F' => '提现状态',

                'G' => '支付宝账户',

                'H' => '微信账户',

                'I' => '中奖时间',
                'J' => '是否已经提现(0没有，1提现成功)',

            );

             //设置excel 表头

            foreach ($arr_title as $key => $value) {

                $this->excel->getActiveSheet()->setCellValue($key . '1', $value);

                $this->excel->getActiveSheet()->getStyle($key . '1')->getFont()->setSize(13);

                $this->excel->getActiveSheet()->getStyle($key . '1')->getFont()->setBold(true);

               $this->excel->getActiveSheet()->getDefaultColumnDimension('A')->setWidth(20);

                $this->excel->getActiveSheet()->getStyle($key . '1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            }

            $i = 1;

            //查询数据库得到要导出的内容

            if(!empty($prizeId) && empty($withdrawals) && empty($time)){

                $this->db->select('a.*,b.nickname,c.title,c.redPocket');
                $this->db->from('hf_game_wining_history a');
                $this->db->join('hf_user_member b', 'b.user_id = a.userId','left');
                $this->db->join('hf_game_prize c', 'c.id = a.prizeId','left');
                $list = $this->Game_model->search_where_withsrawls('prizeId',$prizeId);
              
            }else  if(empty($prizeId) && !empty($withdrawals) && empty($time)){
                 if($withdrawals == '3'){
                    $withdrawals = '0';
                    }
                $list = $this->Game_model->search_where_withsrawls('withsrawls',$withdrawals);

            }else if(empty($prizeId) && empty($withdrawals) && !empty($time)){

                $list = $this->Game_model->select_where_with_time($time,$endtime);

            }else if(!empty($prizeId) && !empty($withdrawals) && empty($time)){
                if($withdrawals == '3'){
                    $withdrawals = '0';
                }
                $list = $this->Game_model->search_withsrawls($prizeId,$withdrawals);

            }else  if(!empty($prizeId) && empty($withdrawals) && !empty($time)){
                $list = $this->Game_model->select_where_prizeid_time($prizeId,$time,$endtime);   
            }else  if(empty($prizeId) && !empty($withdrawals) && !empty($time)){
                 if($withdrawals == '3'){
                    $withdrawals = '0';
                    }
                $list = $this->Game_model->select_where_wi_time('withsrawls',$withdrawals,$time,$endtime);   

            }else  if(!empty($prizeId) && !empty($withdrawals) && !empty($time)){
                
                 if($withdrawals == '3'){
                    $withdrawals = '0';
                    }
                $list = $this->Game_model->select_where_wi_time($prizeId,'withsrawls',$withdrawals,$time,$endtime);   

            }else if(empty($prizeId) && empty($withdrawals) && empty($time)){
                $list = $this->Game_model->select_withdrawals();
            }
           

          

            if(!empty($list)){
                foreach ($list as $booking) {

                    $i++;

                    $this->excel->getActiveSheet()->setCellValue('A' . $i, $booking['id']);

                    $this->excel->getActiveSheet()->setCellValue('B' . $i, $booking['title']);
                    $this->excel->getActiveSheet()->setCellValue('C' . $i, $booking['redPocket']);
                    $this->excel->getActiveSheet()->setCellValue('D' . $i, $booking['nickname']);
                    $this->excel->getActiveSheet()->setCellValue('E' . $i, $booking['phone']);
                    if($booking['withsrawls'] == '1'){
                        $this->excel->getActiveSheet()->setCellValue('F' . $i, '申请提现');

                    }else if($booking['withsrawls'] =='2'){
                        $this->excel->getActiveSheet()->setCellValue('F' . $i, '提现成功');

                    }else{
                        $this->excel->getActiveSheet()->setCellValue('F' . $i, '未申请提现');

                    }
                    $this->excel->getActiveSheet()->setCellValue('G' . $i, $booking['aliPay']);
                    $this->excel->getActiveSheet()->setCellValue('H' . $i, $booking['wxpay']);
                    $this->excel->getActiveSheet()->setCellValue('I' . $i, date('Y-m-d H:i:s', $booking['createTime'] / 1000));
                    $this->excel->getActiveSheet()->setCellValue('J' . $i, '0');
                }
                //日志

                $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."导出了红包中奖纪录",

                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );

                $this->db->insert('hf_system_journal',$log);

                $filename = 'ImportOrder.xls'; //save our workbook as this file name

               /// var_dump($filename);

                header('Content-Type: application/vnd.ms-excel'); //mime type

                header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name

                header('Cache-Control: max-age=0'); //no cache



                 $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

                 $objWriter->save('php://output');

                 exit;

            }else{

                echo "<script>alert('暂无红包记录！');window.location.href='".site_url('/game/Game/withdrawals/')."'</script>";

            }

        }else{
            $this->load->view('404.html');
        }
    }

    //导入体现成功纪录
    function Import_withdrawal(){
            $name = date('Y-m-d');

            $inputFileName = "Upload/xls/" .$name .'.xls';

            move_uploaded_file($_FILES["file"]["tmp_name"],$inputFileName);

            $this->load->library('excel');

            if(!file_exists($inputFileName)){

                    echo "<script>alert('文件导入失败!');window.location.href='".site_url('/game/Game/withdrawals')."'</script>";

                    exit;

            }
            $PHPReader = new PHPExcel_Reader_Excel2007();
            if(!$PHPReader->canRead($inputFileName)){
              $PHPReader = new PHPExcel_Reader_Excel5();
              if(!$PHPReader->canRead($inputFileName)){
                echo "<script>alert('文件格式错误，需要xls或xlsx文件后缀!');window.location.href='".site_url('/game/Game/withdrawals')."'</script>";
                return;
              }
            }
            $PHPExcel = $PHPReader->load($inputFileName);
            $currentSheet = $PHPExcel->getSheet(0);  //读取excel文件中的第一个工作表
            $allColumn = $currentSheet->getHighestColumn(); //取得最大的列号
            $allRow = $currentSheet->getHighestRow(); //取得一共有多少行
            $erp_orders_id = array();  //声明数组

            for($currentRow = 2;$currentRow <= $allRow;$currentRow++){


                $id = $PHPExcel->getActiveSheet()->getCell("A".$currentRow)->getValue();//获取c列的值
                $state = $PHPExcel->getActiveSheet()->getCell("J".$currentRow)->getValue();//获取c列的值
                if($state == '1'){
                    $arr['withsrawls'] = '2';
                    $this->db->where('id',$id)->updata("hf_game_wining_history",$arr);
                }
                if($id == NULL){
                    unlink($inputFileName);
                     //删除临时文件
                    break;
                }

            }
            echo "<script>alert('导入成功!');window.location.href='".site_url('/game/Game/withdrawals')."'</script>";
            exit;

    }


    //导出中奖纪录
    function DowAwardRecord(){
        if($_POST){
            $prizeId = $this->input->post('prizeId');
            $begin_time = $this->input->post('begin_time');
            $end_time = $this->input->post('end_time');
            $gameId = $this->input->post('gameId');

            if(!empty($begin_time)){
                $time = strtotime($begin_time.' 00:00:00')*1000;
                $endtime = strtotime($end_time.' 23:59:59')*1000;
            }else{
                $time= '';
                $endtime='';
            }


            $this->load->library('excel');
            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('ImportOrder');

            $arr_title = array(

                'A' => '编号',

                'B' => '奖品名称',

                'C' => '用户名称',

                'D' => '用户手机号',

                'E' => '中奖时间',

            );
             //设置excel 表头
            foreach ($arr_title as $key => $value) {

                $this->excel->getActiveSheet()->setCellValue($key . '1', $value);

                $this->excel->getActiveSheet()->getStyle($key . '1')->getFont()->setSize(13);

                $this->excel->getActiveSheet()->getStyle($key . '1')->getFont()->setBold(true);

               $this->excel->getActiveSheet()->getDefaultColumnDimension('A')->setWidth(20);

                $this->excel->getActiveSheet()->getStyle($key . '1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            }

            $i = 1;

            $list  = search_history($time,$endtime,$prizeId,$gameId);
            if(!empty($list)){
                foreach ($list as $booking) {

                    $i++;

                    $this->excel->getActiveSheet()->setCellValue('A' . $i, $booking['id']);

                    $this->excel->getActiveSheet()->setCellValue('B' . $i, $booking['title']);
                    $this->excel->getActiveSheet()->setCellValue('C' . $i, $booking['nickname']);
                    $this->excel->getActiveSheet()->setCellValue('D' . $i, $booking['phone']);
                    $this->excel->getActiveSheet()->setCellValue('E' . $i, date('Y-m-d H:i:s', $booking['createTime'] / 1000));
                }
                //日志

                $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."导出了中奖纪录",

                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );

                $this->db->insert('hf_system_journal',$log);

                $filename = '中奖纪录.xls'; //save our workbook as this file name

               /// var_dump($filename);

                header('Content-Type: application/vnd.ms-excel'); //mime type

                header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name

                header('Cache-Control: max-age=0'); //no cache



                 $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

                 $objWriter->save('php://output');

                 exit;

            }else{

                echo "<script>alert('404！');window.location.href='".site_url('/Game/awardRecord/')."'</script>";

            }


        }else{
            $this->load->view('404.html');
        }
    }

    //弹窗
    function Popup(){
        //所有弹框$图片
        $data['model'] = $this->Public_model->select('hf_system_model','id');

        $data['page'] = 'game/popup.html';
        $data['menu'] = array('game','popup');
        $this->load->view('template.html',$data);

    }
    //编辑弹窗
    function editModel(){
        if($_POST){
            $data= $this->input->post();
            $header = array("token:".$_SESSION['token'],'city:'.'1');    
            if(!empty($_FILES['img']['name'])){
                $tmpfile = new CURLFile(realpath($_FILES['img']['tmp_name']));
            
                $pics = array(
                    'pics' =>$tmpfile,
                    'porfix'=>'game/Popup',
                    'bucket'=>'cqcother',
                );
            
                $qiuniu = json_decode(curl_post_express($header,QINIUUPLOAD,$pics),true);

                if($qiuniu['errno'] == '0'){
                    $img = json_decode($qiuniu['data']['img'],true);
                    $data['modelContent'] =$img[0]['picImg'];
                   
                }else{
                  echo "<script>alert('图片上传失败！');window.location.href='".site_url('/game/Game/Popup')."'</script>";exit;
                }
            }
            var_dump($data);

            if($this->Public_model->updata('hf_system_model','id',$data['id'],$data)){
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."修改了APP弹框，弹框编号是".$data['id'],
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/game/Game/Popup')."'</script>";exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/game/Game/Popup')."'</script>";exit;
 
            }



        }
    }




}