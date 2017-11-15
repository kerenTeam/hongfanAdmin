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

            if($data['type'] == '2'){
                $data['hiValue'] = $data['value'];
            }else if($data['type'] =='3'){
                $data['redPocket'] = $data['value']; 
            }else if($data['type'] =='4'){
                $data['giftId'] = '23'; 
            }
            unset($data['value'],$data['type']);
            $data['gameId'] = '2';
   
            //所有奖品库存
            $prize = $this->Game_model->select_prize('2');
            // $stock = 0;
            // foreach ($prize as $key => $value) {
            //     $stock = $stock + $value['stock'];
            // }
            if(count($prize) < '8'){
                if($this->Game_model->add_prize($data)){
                     $a = edit_game_prize();
                     $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  

                        "content" => $_SESSION['users']['username']."新增了一个游戏奖品，奖品名称是".$data['title'],
                        "create_time" => date('Y-m-d H:i:s'),

                        "userip" => get_client_ip(),

                    );
                    $this->db->insert('hf_system_journal',$log);
                     echo "<script>alert('操作成功！');window.location.href='".site_url('/game/Game/gameList')."'</script>";exit;
                }else{
                     echo "<script>alert('操作失败！');window.location.href='".site_url('/game/Game/gameList')."'</script>";exit;
                }
            }else{
                echo "<script>alert('奖品类别数量超过APP限制！');window.location.href='".site_url('/game/Game/gameList')."'</script>";exit;
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
                $a = edit_game_prize();
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."修改了游戏奖品，奖品名称是".$data['title'],
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                $this->db->insert('hf_system_journal',$log);
                echo "<script>alert('操作成功！');window.location.href='".site_url('/game/Game/gameList')."'</script>";exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/game/Game/gameList')."'</script>";exit;
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

	//y=游戏内容
	function gameInfo(){
		//获取游戏详情
		$data['game'] = $this->Game_model->select_game_info('2');
		

		$data['page'] = $this->view_gameInfo;
        $data['menu'] = array('game','gameInfo');
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

        $config['last_link']= '末页';
        $list = $this->Game_model->select_withdrawals();

        $config['total_rows'] = count($list);

        // //分页数据
        $listpage = $this->Game_model->select_withdrawals_page($config['per_page'],$current_page);
        $this->load->library('pagination');//加载ci pagination类
        $this->pagination->initialize($config);

    
        $data = array('lists'=>$listpage,'count'=>count($list),'pages' => $this->pagination->create_links());

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

    //搜索红包提现纪录
    function search_withsrawls(){
        $config['per_page'] = 10;
        //获取页码
        $current_page=intval($this->input->get("size"));//index.php 后数第4个/

      
        $prizeId = $this->input->get('prizeId');
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
        $config['query_string_segment'] = 'size';
        $config['base_url'] = site_url('/game/Game/search_withsrawls?').'prizeId='.$prizeId.'&withsrawls='.$withdrawals;

        if(!empty($prizeId) && empty($withdrawals)){
            $list = $this->Game_model->search_where_withsrawls('prizeId',$prizeId);
            $config['total_rows'] = count($list);

            //分页数据
            $listpage = $this->Game_model->search_where_withsrawls_page('prizeId',$prizeId,$config['per_page'],$current_page);
        }else  if(empty($prizeId) && !empty($withdrawals)){
            if($withdrawals == '3'){
            $withdrawals = '0';
            }
            $list = $this->Game_model->search_where_withsrawls('withsrawls',$withdrawals);
            $config['total_rows'] = count($list);

            //分页数据
            $listpage = $this->Game_model->search_where_withsrawls_page('withsrawls',$withdrawals,$config['per_page'],$current_page);
        }else  if(!empty($prizeId) && !empty($withdrawals)){
            if($withdrawals == '3'){
            $withdrawals = '0';
            }
            $list = $this->Game_model->search_withsrawls($prizeId,$withdrawals);
            $config['total_rows'] = count($list);

            //分页数据
            $listpage = $this->Game_model->search_withsrawls_page($prizeId,$withdrawals,$config['per_page'],$current_page);
        }else if(empty($prizeId) && empty($withdrawals)){
            $list = $this->Game_model->select_withdrawals($prizeId,$withdrawals);
            $config['total_rows'] = count($list);

            //分页数据
            $listpage = $this->Game_model->select_withdrawals_page($config['per_page'],$current_page);
        }
       

        $this->load->library('pagination');//加载ci pagination类
        $this->pagination->initialize($config);

    
        $data = array('lists'=>$listpage,'count'=>count($list),'pages' => $this->pagination->create_links());

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

                'C' => '用户名称',

                'D' => '用户手机号',

                'E' => '提现状态',

                'F' => '支付宝账户',

                'G' => '微信账户',

                'H' => '中奖时间',

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
                $list = $this->Game_model->select_withdrawals($prizeId,$withdrawals);
               
            }
           

          

            if(!empty($list)){
                foreach ($list as $booking) {

                    $i++;

                    $this->excel->getActiveSheet()->setCellValue('A' . $i, $booking['id']);

                    $this->excel->getActiveSheet()->setCellValue('B' . $i, $booking['title']);
                    $this->excel->getActiveSheet()->setCellValue('C' . $i, $booking['nickname']);
                    $this->excel->getActiveSheet()->setCellValue('D' . $i, $booking['phone']);
                    if($booking['withsrawls'] == '1'){
                        $this->excel->getActiveSheet()->setCellValue('E' . $i, '申请提现');

                    }else if($booking['withsrawls'] =='2'){
                        $this->excel->getActiveSheet()->setCellValue('E' . $i, '提现成功');

                    }else{
                        $this->excel->getActiveSheet()->setCellValue('E' . $i, '未申请提现');

                    }
                    $this->excel->getActiveSheet()->setCellValue('F' . $i, $booking['aliPay']);
                    $this->excel->getActiveSheet()->setCellValue('G' . $i, $booking['wxpay']);
                    $this->excel->getActiveSheet()->setCellValue('H' . $i, date('Y-m-d H:i:s', $booking['createTime'] / 1000));
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

                echo "<script>alert('暂无红包记录！');window.location.href='".site_url('/Game/withdrawals/')."'</script>";

            }

        }else{
            $this->load->view('404.html');
        }
    }

    //导出中奖纪录
    function DowAwardRecord(){
        if($_POST){
            $prizeId = $this->input->post('prizeId');
            $begin_time = $this->input->post('begin_time');
            $end_time = $this->input->post('end_time');

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

            $list  = search_history($time,$endtime,$prizeId);
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

}