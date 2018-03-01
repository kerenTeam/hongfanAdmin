<?php  
defined('BASEPATH') OR exit('No direct script access allowed');

/*

*活动

 * */

require_once(APPPATH.'controllers/Default_Controller.php');

class Activity extends Default_Controller {

    public $christmas = 'hf_christmas_day';
	public $game = 'hf_game_wining_history';
	function __construct()
	{
		parent::__construct();
		$this->load->model('Public_model');
	}


	//双旦活动
	function newYearsDay(){
 		$_SESSION['newyearNum'] = '0';
		$data['page'] = 'activity/newYearsDay.html';
        $data['menu'] = array('activity','newYearsDay');
        $this->load->view('template.html',$data);
	}

	//返回双旦活动
	function retNewYearList(){
		if($_POST){

            $startTime = $this->input->post('begin_time');
            $endTime = $this->input->post('end_time');
            $state = $this->input->post('state');
            if(!empty($startTime)){
            	$t = $startTime.' 00:00:00';
            	$e = $endTime.' 23:59:59';
            }else{
            	$t= '';
            	$e= '';
            }
            $page = $this->input->post('start');

            $_SESSION['newyearNum'] = $page;
            $size = $this->input->post('count');

            if(!empty($state) && empty($t)){
            	if($state =='2'){
            		$state = '0';
            	}
            	$list = $this->Public_model->select_where($this->christmas,'auditState',$state,'');

            	$this->db->select('a.*,b.content,b.pic,b.create_time,c.phone,c.nickname');
            	$this->db->from('hf_christmas_day as a');
            	$this->db->join('hf_user_member as c', 'c.user_id = a.userId','left');
            	$this->db->join('hf_friends_news as b', 'b.id = a.newsId','left');
            	$query = $this->db->where('a.auditState',$state)->order_by('a.createTime','desc')->limit($size,$page)->get();
            	$listpage = $query->result_array();

            }else if(empty($state) && !empty($t)){
            	$query1 = $this->db->where('createTime >=',$t)->where('createTime <=',$e)->get($this->christmas);
            	$list = $query1->result_array();

            	$this->db->select('a.*,b.content,b.pic,b.create_time,c.phone,c.nickname');
            	$this->db->from('hf_christmas_day as a');
            	$this->db->join('hf_user_member as c', 'c.user_id = a.userId','left');
            	$this->db->join('hf_friends_news as b', 'b.id = a.newsId','left');
            	$query = $this->db->where('createTime >=',$t)->where('createTime <=',$e)->order_by('a.createTime','desc')->limit($size,$page)->get();
            	$listpage = $query->result_array();

            }else if(!empty($state) && !empty($t)){
            	$query1 = $this->db->where('createTime >=',$t)->where('createTime <=',$e)->where('auditState',$state)->get($this->christmas);
            	$list = $query1->result_array();

            	$this->db->select('a.*,b.content,b.pic,b.create_time,c.phone,c.nickname');
            	$this->db->from('hf_christmas_day as a');
            	$this->db->join('hf_user_member as c', 'c.user_id = a.userId','left');
            	$this->db->join('hf_friends_news as b', 'b.id = a.newsId','left');
            	$query = $this->db->where('createTime >=',$t)->where('createTime <=',$e)->where('a.auditState',$state)->order_by('a.createTime','desc')->limit($size,$page)->get();
            	$listpage = $query->result_array();
            }else if(empty($state) && empty($t)){
            	$list = $this->Public_model->select($this->christmas,'');
            	$this->db->select('a.*,b.content,b.pic,b.create_time,c.phone,c.nickname');
            	$this->db->from('hf_christmas_day as a');
            	$this->db->join('hf_user_member as c', 'c.user_id = a.userId','left');
            	$this->db->join('hf_friends_news as b', 'b.id = a.newsId','left');
            	$query = $this->db->order_by('a.createTime','desc')->limit($size,$page)->get();
            	$listpage = $query->result_array();
            }
           
            if(!empty($listpage)){
                echo json_encode(['total'=>count($list),'subjects'=>$listpage]);
            }else{
                echo "2";
            }
		}
	}
	//审核信息
	function auditState(){
		$id = intval($this->uri->segment('4'));
		if($id == '0'){
			echo "<script>alert('请求失败！');window.history.go(-1);</script>";exit;
		}else{
			$news = $this->Public_model->select_where_info($this->christmas,'id',$id);
			$data['auditState'] = '1';
			if($this->Public_model->updata($this->christmas,'id',$id,$data)){
				if($news['feastType'] == '1'){
					$title = '圣诞节';
					$t = '2017-12-26';
				}else{
					$title = '元旦节';
					$t = '2018-01-01';
				}
				$arr = array(
					'messageType'=>'1',
					'userid'=>$news['userId'],
					'title'=>'HI 集给你的'.$title.'礼物',
					'content'=>'恭喜你过获得HI集赠送的'.$title.'礼物一份，我们将在 '.$t.'活动结束后按照您填写的收货地址把礼物快递给您，谢谢使用 HI 集！',
				);
				$this->Public_model->insert('hf_user_message',$arr);
				echo "<script>alert('操作成功！');window.history.go(-1);</script>";exit;
			}else{
				echo "<script>alert('操作失败！');window.history.go(-1);</script>";exit;
			}
		}
	}

	//导出活动
	function dowNewYearList(){
		if($_POST){
			$startTime = $this->input->post('begin_time');
            $endTime = $this->input->post('end_time');
 			$state = $this->input->post('state');
            if(!empty($startTime)){
            	$t = $startTime.' 00:00:00';
            	$e = $endTime.' 23:59:59';
            }else{
            	$t= '';
            	$e= '';
			}

            if(!empty($state) && empty($t)){
            	if($state =='2'){
            		$state = '0';
            	}

            	$this->db->select('a.*,b.content,b.pic,b.create_time,c.phone,c.nickname');
            	$this->db->from('hf_christmas_day as a');
            	$this->db->join('hf_user_member as c', 'c.user_id = a.userId','left');
            	$this->db->join('hf_friends_news as b', 'b.id = a.newsId','left');
            	$query = $this->db->where('a.auditState',$state)->order_by('a.createTime','desc')->get();
            	$listpage = $query->result_array();

            }else if(empty($state) && !empty($t)){
            	
            	$this->db->select('a.*,b.content,b.pic,b.create_time,c.phone,c.nickname');
            	$this->db->from('hf_christmas_day as a');
            	$this->db->join('hf_user_member as c', 'c.user_id = a.userId','left');
            	$this->db->join('hf_friends_news as b', 'b.id = a.newsId','left');
            	$query = $this->db->where('createTime >=',$t)->where('createTime <=',$e)->order_by('a.createTime','desc')->get();
            	$listpage = $query->result_array();

            }else if(!empty($state) && !empty($t)){
            	
            	$this->db->select('a.*,b.content,b.pic,b.create_time,c.phone,c.nickname');
            	$this->db->from('hf_christmas_day as a');
            	$this->db->join('hf_user_member as c', 'c.user_id = a.userId','left');
            	$this->db->join('hf_friends_news as b', 'b.id = a.newsId','left');
            	$query = $this->db->where('createTime >=',$t)->where('createTime <=',$e)->where('a.auditState',$state)->order_by('a.createTime','desc')->get();
            	$listpage = $query->result_array();
            }else if(empty($state) && empty($t)){

            	$this->db->select('a.*,b.content,b.pic,b.create_time,c.phone,c.nickname');
            	$this->db->from('hf_christmas_day as a');
            	$this->db->join('hf_user_member as c', 'c.user_id = a.userId','left');
            	$this->db->join('hf_friends_news as b', 'b.id = a.newsId','left');
            	$query = $this->db->order_by('a.createTime','desc')->get();
            	$listpage = $query->result_array();
            }

            if(!empty($listpage)){
                    $this->load->library('excel');

                    $this->excel->setActiveSheetIndex(0);

                    //name the worksheet
                    $this->excel->getActiveSheet()->setTitle('activity');

                    $arr_title = array(

                        'A' => '编号',

                        'B' => '用户昵称',

                        'C' => '用户电话',

                        'D' => '发帖内容',
                        'E' => '发帖时间',

                        'F' => '收货人名称',
                        'G' => '收货人电话',
                        'H' => '收货人地址',
                        'I' => '状态',
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
                    foreach ($listpage as $booking) {
                        $i++;
                        $this->excel->getActiveSheet()->setCellValue('A' . $i, $booking['id']);
                        $this->excel->getActiveSheet()->setCellValue('B' . $i, $booking['nickname']);
                        $this->excel->getActiveSheet()->setCellValue('C' . $i, $booking['phone']);
                        $this->excel->getActiveSheet()->setCellValue('D' . $i, $booking['content']);
                        $this->excel->getActiveSheet()->setCellValue('E' . $i, $booking['create_time']);
                        $this->excel->getActiveSheet()->setCellValue('F' . $i, $booking['addresseeName']);
                        $this->excel->getActiveSheet()->setCellValue('G' . $i, $booking['phoneNumber']);
                        $this->excel->getActiveSheet()->setCellValue('H' . $i, $booking['address']);
                        if($booking['auditState'] == '1'){
                            $this->excel->getActiveSheet()->setCellValue('I' . $i, '已审核');
                        }else{
                            $this->excel->getActiveSheet()->setCellValue('I' . $i, '未审核');
                        }
                    }

                    $filename = '活动参加纪录.xls'; //save our workbook as this file name

                    header('Content-Type: application/vnd.ms-excel'); //mime type

                    header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
                    header('Cache-Control: max-age=0'); //no cache

                     $log = array(

                        'userid'=>$_SESSION['users']['user_id'],  

                        "content" => $_SESSION['users']['username']."导出了活动参加纪录",

                        "create_time" => date('Y-m-d H:i:s'),

                        "userip" => get_client_ip(),

                    );

                    $this->db->insert('hf_system_journal',$log);

                    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

                    $objWriter->save('php://output');
            }else{
                echo "<script>alert('暂无活动参加信息！');window.history.go(-1);</script>";
            }
		}

	}

    //删除活动记录
    function del_NewYearList(){
        $id = intval($this->uri->segment('4'));
        if($id == '0'){
            echo "<script>alert('请求失败！');window.history.go(-1);</script>";exit;
        }else{
            if($this->Public_model->delete($this->christmas,'id',$id)){
                
                echo "<script>alert('操作成功！');window.history.go(-1);</script>";exit;
            }else{
                echo "<script>alert('操作失败！');window.history.go(-1);</script>";exit;
            }
        }
    }


    //年货节达人榜
    function masterList(){
        if(isset($_SESSION['masterNum'])){
            $_SESSION['masterNum'] = '0';
        }
        $data['page'] = 'activity/masterList.html';
        $data['menu'] = array('activity','masterList');
        $this->load->view('template.html',$data);
    }

    //返回年货节达人榜参加纪录
     function retMasterList(){
        if($_POST){
            $startTime = $this->input->post('begin_time');
            $endTime = $this->input->post('end_time');
            $state = $this->input->post('state');
            if(!empty($startTime)){
                $t = $startTime.' 00:00:00';
                $e = $endTime.' 23:59:59';
            }else{
                $t= '';
                $e= '';
            }
            $page = $this->input->post('start');

            $_SESSION['masterNum'] = $page;
            $size = $this->input->post('count');

            if(!empty($state) && empty($t)){
                if($state =='2'){
                    $state = '0';
                }

                $query = $this->db->where('gameId','5')->where('examine',$state)->get('hf_game_wining_history');
                $list = $query->result_array();

                $this->db->select('a.*,b.content,b.pic,b.create_time,c.phone,c.nickname,d.commont,d.newsId,e.title');
                $this->db->from('hf_game_wining_history as a');
                $this->db->join('hf_user_member as c', 'c.user_id = a.userId','inner');
                $this->db->join('hf_friends_news as b', 'b.id = a.myNewsId','inner');
                $this->db->join('hf_friends_news_commont as d', 'd.id = a.aboutNewsId','inner');
                $this->db->join('hf_game_prize as e', 'e.id = a.prizeId','inner');
                $query1 = $this->db->where('a.gameId','5')->where('a.examine',$state)->order_by('a.createTime','desc')->limit($size,$page)->get();
                $listpage = $query1->result_array();


            }else if(empty($state) && !empty($t)){
                $query1 = $this->db->where('gameId','5')->where('mysqlTime >=',$t)->where('mysqlTime <=',$e)->get('hf_game_wining_history');
                $list = $query1->result_array();

              $this->db->select('a.*,b.content,b.pic,b.create_time,c.phone,c.nickname,d.commont,d.newsId,e.title');
                $this->db->from('hf_game_wining_history as a');
                $this->db->join('hf_user_member as c', 'c.user_id = a.userId','inner');
                $this->db->join('hf_friends_news as b', 'b.id = a.myNewsId','inner');
                $this->db->join('hf_friends_news_commont as d', 'd.id = a.aboutNewsId','inner');
                $this->db->join('hf_game_prize as e', 'e.id = a.prizeId','inner');
                $query = $this->db->where('a.mysqlTime >=',$t)->where('a.mysqlTime <=',$e)->where('gameId','5')->order_by('a.createTime','desc')->limit($size,$page)->get();
                $listpage = $query->result_array();

            }else if(!empty($state) && !empty($t)){
                $query1 = $this->db->where('mysqlTime >=',$t)->where('mysqlTime <=',$e)->where('examine',$state)->where('gameId','5')->get('hf_game_wining_history');
                $list = $query1->result_array();

              $this->db->select('a.*,b.content,b.pic,b.create_time,c.phone,c.nickname,d.commont,d.newsId,e.title');
                $this->db->from('hf_game_wining_history as a');
                $this->db->join('hf_user_member as c', 'c.user_id = a.userId','inner');
                $this->db->join('hf_friends_news as b', 'b.id = a.myNewsId','inner');
                $this->db->join('hf_friends_news_commont as d', 'd.id = a.aboutNewsId','inner');
                $this->db->join('hf_game_prize as e', 'e.id = a.prizeId','inner');
                $query = $this->db->where('a.mysqlTime >=',$t)->where('a.mysqlTime <=',$e)->where('a.examine',$state)->where('gameId','5')->order_by('a.createTime','desc')->limit($size,$page)->get();
                $listpage = $query->result_array();
            }else if(empty($state) && empty($t)){
                $query = $this->db->where('gameId','5')->get('hf_game_wining_history');
                $list = $query->result_array();

              $this->db->select('a.*,b.content,b.pic,b.create_time,c.phone,c.nickname,d.commont,d.newsId,e.title');
                $this->db->from('hf_game_wining_history as a');
                $this->db->join('hf_user_member as c', 'c.user_id = a.userId','inner');
                $this->db->join('hf_friends_news as b', 'b.id = a.myNewsId','inner');
                $this->db->join('hf_friends_news_commont as d', 'd.id = a.aboutNewsId','inner');
                $this->db->join('hf_game_prize as e', 'e.id = a.prizeId','inner');
                $query1 = $this->db->where('a.gameId','5')->order_by('a.createTime','desc')->limit($size,$page)->get();
                $listpage = $query1->result_array();
            }
 
            if(!empty($listpage)){
                echo json_encode(['total'=>count($list),'subjects'=>$listpage]);
            }else{
                echo "2";
            }
        }
    }

    //审核
    function edithistory(){
        $id = intval($this->uri->segment('4'));
        if($id == '0'){
            echo "<script>alert('请求失败！');window.history.go(-1);</script>";exit;
        }else{
            $news = $this->Public_model->select_where_info($this->game,'id',$id);
            $data['examine'] = '1';
            if($this->Public_model->updata($this->game,'id',$id,$data)){
               
                $arr = array(
                    'messageType'=>'1',
                    'userid'=>$news['userId'],
                    'title'=>'HI 集给你的年货节达人榜礼物',
                    'content'=>'恭喜你获得HI集赠送的年货节达人榜礼物一份，我们将在活动结束后按照您填写的收货地址把礼物快递给您，谢谢使用 HI 集！',
                );
                $this->Public_model->insert('hf_user_message',$arr);
                echo "<script>alert('操作成功！');window.history.go(-1);</script>";exit;
            }else{
                echo "<script>alert('操作失败！');window.history.go(-1);</script>";exit;
            }
        }
    }
    //shanhuc
    function delhistory(){
        $id = intval($this->uri->segment('4'));
        if($id == '0'){
            echo "<script>alert('请求失败！');window.history.go(-1);</script>";exit;
        }else{
            if($this->Public_model->delete($this->game,'id',$id)){
                
                echo "<script>alert('操作成功！');window.history.go(-1);</script>";exit;
            }else{
                echo "<script>alert('操作失败！');window.history.go(-1);</script>";exit;
            }
        }
    }

    //导出
    function dowHistory(){
        if($_POST){
            $startTime = $this->input->post('begin_time');
            $endTime = $this->input->post('end_time');
            $state = $this->input->post('state');
            if(!empty($startTime)){
                $t = $startTime.' 00:00:00';
                $e = $endTime.' 23:59:59';
            }else{
                $t= '';
                $e= '';
            }

            if(!empty($state) && empty($t)){
                if($state =='2'){
                    $state = '0';
                }

                $this->db->select('a.*,b.content,b.pic,b.create_time,c.phone,c.nickname,d.commont,d.newsId,e.title');
                $this->db->from('hf_game_wining_history as a');
                $this->db->join('hf_user_member as c', 'c.user_id = a.userId','inner');
                $this->db->join('hf_friends_news as b', 'b.id = a.myNewsId','inner');
                $this->db->join('hf_friends_news_commont as d', 'd.id = a.aboutNewsId','inner');
                $this->db->join('hf_game_prize as e', 'e.id = a.prizeId','inner');
                $query1 = $this->db->where('a.gameId','5')->where('a.examine',$state)->order_by('a.createTime','desc')->get();
                $listpage = $query1->result_array();


            }else if(empty($state) && !empty($t)){
              

              $this->db->select('a.*,b.content,b.pic,b.create_time,c.phone,c.nickname,d.commont,d.newsId,e.title');
                $this->db->from('hf_game_wining_history as a');
                $this->db->join('hf_user_member as c', 'c.user_id = a.userId','inner');
                $this->db->join('hf_friends_news as b', 'b.id = a.myNewsId','inner');
                $this->db->join('hf_friends_news_commont as d', 'd.id = a.aboutNewsId','inner');
                $this->db->join('hf_game_prize as e', 'e.id = a.prizeId','inner');
                $query = $this->db->where('a.mysqlTime >=',$t)->where('a.mysqlTime <=',$e)->where('gameId','5')->order_by('a.createTime','desc')->get();
                $listpage = $query->result_array();

            }else if(!empty($state) && !empty($t)){
               
              $this->db->select('a.*,b.content,b.pic,b.create_time,c.phone,c.nickname,d.commont,d.newsId,e.title');
                $this->db->from('hf_game_wining_history as a');
                $this->db->join('hf_user_member as c', 'c.user_id = a.userId','inner');
                $this->db->join('hf_friends_news as b', 'b.id = a.myNewsId','inner');
                $this->db->join('hf_friends_news_commont as d', 'd.id = a.aboutNewsId','inner');
                $this->db->join('hf_game_prize as e', 'e.id = a.prizeId','inner');
                $query = $this->db->where('a.mysqlTime >=',$t)->where('a.mysqlTime <=',$e)->where('a.examine',$state)->where('gameId','5')->order_by('a.createTime','desc')->get();
                $listpage = $query->result_array();
            }else if(empty($state) && empty($t)){
               
                $this->db->select('a.*,b.content,b.pic,b.create_time,c.phone,c.nickname,d.commont,d.newsId,e.title');
                $this->db->from('hf_game_wining_history as a');
                $this->db->join('hf_user_member as c', 'c.user_id = a.userId','inner');
                $this->db->join('hf_friends_news as b', 'b.id = a.myNewsId','inner');
                $this->db->join('hf_friends_news_commont as d', 'd.id = a.aboutNewsId','inner');
                $this->db->join('hf_game_prize as e', 'e.id = a.prizeId','inner');
                $query1 = $this->db->where('a.gameId','5')->order_by('a.createTime','desc')->get();
                $listpage = $query1->result_array();
            }

            if(!empty($listpage)){
                    $this->load->library('excel');

                    $this->excel->setActiveSheetIndex(0);

                    //name the worksheet
                    $this->excel->getActiveSheet()->setTitle('activity');

                    $arr_title = array(

                        'A' => '编号',

                        'B' => '奖品名称',

                        'C' => '用户电话',
                        'D' => '用户昵称',
                        'E' => '提问内容',
                        'F' => '回答内容',
                        'G' => '回答问题编号',
                        'H' => '收货人',
                        'I' => '收货人电话',
                        'J' => '收货人地址',
                        'K' => '参加时间',
                        'L' => '状态',
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
                    foreach ($listpage as $booking) {
                        $i++;
                        $this->excel->getActiveSheet()->setCellValue('A' . $i, $booking['id']);
                        $this->excel->getActiveSheet()->setCellValue('B' . $i, $booking['title']);
                        $this->excel->getActiveSheet()->setCellValue('C' . $i, $booking['phone']);
                        $this->excel->getActiveSheet()->setCellValue('D' . $i, $booking['nickname']);
                        $this->excel->getActiveSheet()->setCellValue('E' . $i, $booking['content']);
                        $this->excel->getActiveSheet()->setCellValue('F' . $i, $booking['commont']);
                        $this->excel->getActiveSheet()->setCellValue('G' . $i, $booking['newsId']);
                        $this->excel->getActiveSheet()->setCellValue('H' . $i, $booking['addresseeName']);
                        $this->excel->getActiveSheet()->setCellValue('I' . $i, $booking['phoneNumber']);
                        $this->excel->getActiveSheet()->setCellValue('J' . $i, $booking['address']);
                        $this->excel->getActiveSheet()->setCellValue('K' . $i, $booking['mysqlTime']);
                        if($booking['examine'] == '1'){
                            $this->excel->getActiveSheet()->setCellValue('L' . $i, '已审核');
                        }else{
                            $this->excel->getActiveSheet()->setCellValue('L' . $i, '未审核');
                        }
                    }

                    $filename = '活动参加纪录.xls'; //save our workbook as this file name

                    header('Content-Type: application/vnd.ms-excel'); //mime type

                    header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
                    header('Cache-Control: max-age=0'); //no cache

                     $log = array(

                        'userid'=>$_SESSION['users']['user_id'],  

                        "content" => $_SESSION['users']['username']."导出了活动参加纪录",

                        "create_time" => date('Y-m-d H:i:s'),

                        "userip" => get_client_ip(),

                    );

                    $this->db->insert('hf_system_journal',$log);

                    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

                    $objWriter->save('php://output');
            }else{
                echo "<script>alert('暂无活动参加信息！');window.history.go(-1);</script>";
            }
        }
    }


    //猜灯谜
    function LanternRiddles(){
       
        if(isset($_SESSION['lanternNum'])){
            $_SESSION['lanternNum'] = '0';
        }

        $data['page'] = 'activity/LanternRiddles.html';
        $data['menu'] = array('activity','LanternRiddles');
        $this->load->view('template.html',$data);
    }

    function retLantern(){
        if($_POST){
            $state = $this->input->post('state');
            $title = $this->input->post('sear');

            $page = $this->input->post('start');

            $_SESSION['lanternNum'] = $page;
            $size = $this->input->post('count');


            if(!empty($state) && empty($title)){
                if($state =='2'){
                    $state = '0';
                }
                $query = $this->db->where('isCompleted',$state)->get('hf_friends_lantern');
                $list = $query->result_array();
                $query2 = $this->db->where('isCompleted',$state)->order_by('id','desc')->limit($size,$page)->get('hf_friends_lantern');
                $listpage = $query2->result_array();
            }else if(empty($state) && !empty($title)){
              
                $query = $this->db->like('title',$title,'both')->get('hf_friends_lantern');
                $list = $query->result_array();
                $query2 = $this->db->like('title',$title,'both')->order_by('id','desc')->limit($size,$page)->get('hf_friends_lantern');
                $listpage = $query2->result_array();
            }else if(!empty($state) && !empty($title)){
                if($state =='2'){
                    $state = '0';
                }
                $query = $this->db->like('title',$title,'both')->where('isCompleted',$state)->get('hf_friends_lantern');
                $list = $query->result_array();
                $query2 = $this->db->like('title',$title,'both')->where('isCompleted',$state)->order_by('id','desc')->limit($size,$page)->get('hf_friends_lantern');
                $listpage = $query2->result_array();
            }else if(empty($state) && empty($title)){
                $query = $this->db->get('hf_friends_lantern');
                $list = $query->result_array();
                $query2 = $this->db->order_by('id','desc')->limit($size,$page)->get('hf_friends_lantern');
                $listpage = $query2->result_array();
            }
            // var_dump($list);

            if(!empty($listpage)){
                echo json_encode(['total'=>count($list),'subjects'=>$listpage]);
            }else{
                echo "2";
            }

        }
    }
    //新增灯谜
    function addLanern(){
        if($_POST){
            $data = $this->input->post();
            $data['mysqlTime'] = date('Y-m-d H:i:s');
            $data['qusetion_user_id'] = $_SESSION['users']['user_id'];
            if($this->db->insert('hf_friends_lantern',$data)){

                    $log = array(

                        'userid'=>$_SESSION['users']['user_id'],  

                        "content" => $_SESSION['users']['username']."新增了猜灯谜问题！",

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
    //删除灯谜
    function delLanern(){
        $id = intval($this->uri->segment('4'));
        if($id == '0'){
            $this->load->view('404.html');
        }else{
           if($this->db->where('id',$id)->delete('hf_friends_lantern')){
                 $log = array(

                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."删除了灯谜".$id,

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
    //编辑灯谜
    function editLanern(){
         if($_POST){
            $data = $this->input->post();
            $data['qusetion_user_id'] = $_SESSION['users']['user_id'];
            if($this->db->where('id',$data['id'])->update('hf_friends_lantern',$data)){

                    $log = array(

                        'userid'=>$_SESSION['users']['user_id'],  

                        "content" => $_SESSION['users']['username']."编辑了猜灯谜问题！id是".$data['id'],

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
    //导入灯谜答案
    function ImportLanern(){
            $name = date('Y-m-d');

            $inputFileName = "Upload/xls/" .$name .'.xls';

            move_uploaded_file($_FILES["file"]["tmp_name"],$inputFileName);

            $this->load->library('excel');

            if(!file_exists($inputFileName)){
                    echo "<script>alert('文件导入失败!');window.location.href='".site_url('/activity/Activity/LanternRiddles')."'</script>";
                    exit;
            }
            $PHPReader = new PHPExcel_Reader_Excel2007();
            if(!$PHPReader->canRead($inputFileName)){
              $PHPReader = new PHPExcel_Reader_Excel5();
              if(!$PHPReader->canRead($inputFileName)){
                echo "<script>alert('文件格式错误，需要xls或xlsx文件后缀!');window.location.href='".site_url('/activity/Activity/LanternRiddles')."'</script>";
                return;
              }
            }
            $PHPExcel = $PHPReader->load($inputFileName);
            $currentSheet = $PHPExcel->getSheet(0);  //读取excel文件中的第一个工作表
            $allColumn = $currentSheet->getHighestColumn(); //取得最大的列号
            $allRow = $currentSheet->getHighestRow(); //取得一共有多少行
            $erp_orders_id = array();  //声明数组

            for($currentRow = 2;$currentRow <= $allRow;$currentRow++){


                $data['title'] = $PHPExcel->getActiveSheet()->getCell("B".$currentRow)->getValue();//获取c列的值
                $data['A'] = $PHPExcel->getActiveSheet()->getCell("C".$currentRow)->getValue();//获取c列的值
                $data['B'] = $PHPExcel->getActiveSheet()->getCell("D".$currentRow)->getValue();//获取c列的值
                $data['C'] = $PHPExcel->getActiveSheet()->getCell("E".$currentRow)->getValue();//获取c列的值
                $data['D'] = $PHPExcel->getActiveSheet()->getCell("F".$currentRow)->getValue();//获取c列的值
                $data['E'] = $PHPExcel->getActiveSheet()->getCell("G".$currentRow)->getValue();//获取c列的值
                $data['F'] = $PHPExcel->getActiveSheet()->getCell("H".$currentRow)->getValue();//获取c列的值
                $data['realAnswer'] = $PHPExcel->getActiveSheet()->getCell("I".$currentRow)->getValue();//获取c列的值
                $data['mysqlTime'] = date('Y-m-d H:i:s',time());//获取c列的值
                $data['qusetion_user_id'] = $_SESSION['users']['user_id'];//获取c列的值
                
                if($data['title'] == NULL){
                    unlink($inputFileName);
                     //删除临时文件
                    break;
                }
                $this->db->insert('hf_friends_lantern',$data);

            }
            echo "1";
            exit;
    }

    //灯谜回答纪录
    function LanternAnswer(){

        if(isset($_SESSION['answerNum'])){
            $_SESSION['answerNum'] = '0';
        }

        $data['page'] = 'activity/LanernAnswer.html';
        $data['menu'] = array('activity','LanernAnswer');
        $this->load->view('template.html',$data);
    }
    //返回灯谜答题纪录
    function retLanternAnswer(){
        if($_POST){
            $state = $this->input->post('state');
            $phone = $this->input->post('sear');

            $page = $this->input->post('start');

            $_SESSION['answerNum'] = $page;
            $size = $this->input->post('count');

            if(!empty($state) && empty($phone)){
                $this->db->select('a.*,b.phone,b.nickname,c.title');
                $this->db->from('hf_friends_lantern_answer as a');
                $this->db->join('hf_user_member as b', 'b.user_id = a.userid','inner');
                $this->db->join('hf_friends_lantern as c', 'c.id = a.question_id','inner');
                $query = $this->db->where('a.IsRight',$state)->order_by('a.mysqlTime','desc')->get();

                $this->db->select('a.*,b.phone,b.nickname,c.title');
                $this->db->from('hf_friends_lantern_answer as a');
                $this->db->join('hf_user_member as b', 'b.user_id = a.userid','inner');
                $this->db->join('hf_friends_lantern as c', 'c.id = a.question_id','inner');
                $query2 = $this->db->where('a.IsRight',$state)->order_by('a.mysqlTime','desc')->limit($size,$page)->get();
                $list = $query->result_array();
                $listpage = $query2->result_array();

            }else if(empty($state) && !empty($phone)){
                $this->db->select('a.*,b.phone,b.nickname,c.title');
                $this->db->from('hf_friends_lantern_answer as a');
                $this->db->join('hf_user_member as b', 'b.user_id = a.userid','inner');
                $this->db->join('hf_friends_lantern as c', 'c.id = a.question_id','inner');
                $query = $this->db->where('b.phone',$phone)->order_by('a.mysqlTime','desc')->get();

                $this->db->select('a.*,b.phone,b.nickname,c.title');
                $this->db->from('hf_friends_lantern_answer as a');
                $this->db->join('hf_user_member as b', 'b.user_id = a.userid','inner');
                $this->db->join('hf_friends_lantern as c', 'c.id = a.question_id','inner');
                $query2 = $this->db->where('b.phone',$phone)->order_by('a.mysqlTime','desc')->limit($size,$page)->get();
                $list = $query->result_array();
                $listpage = $query2->result_array();

            }else if(!empty($state) && !empty($phone)){
                $this->db->select('a.*,b.phone,b.nickname,c.title');
                $this->db->from('hf_friends_lantern_answer as a');
                $this->db->join('hf_user_member as b', 'b.user_id = a.userid','inner');
                $this->db->join('hf_friends_lantern as c', 'c.id = a.question_id','inner');
                $query = $this->db->where('a.IsRight',$state)->where('b.phone',$phone)->order_by('a.mysqlTime','desc')->get();

                $this->db->select('a.*,b.phone,b.nickname,c.title');
                $this->db->from('hf_friends_lantern_answer as a');
                $this->db->join('hf_user_member as b', 'b.user_id = a.userid','inner');
                $this->db->join('hf_friends_lantern as c', 'c.id = a.question_id','inner');
                $query2 = $this->db->where('a.IsRight',$state)->where('b.phone',$phone)->order_by('a.mysqlTime','desc')->limit($size,$page)->get();
                $list = $query->result_array();
                $listpage = $query2->result_array();

            }else if(empty($state) && empty($phone)){
                $this->db->select('a.*,b.phone,b.nickname,c.title');
                $this->db->from('hf_friends_lantern_answer as a');
                $this->db->join('hf_user_member as b', 'b.user_id = a.userid','inner');
                $this->db->join('hf_friends_lantern as c', 'c.id = a.question_id','inner');
                $query = $this->db->order_by('a.mysqlTime','desc')->get();
                $list = $query->result_array();
                $this->db->select('a.*,b.phone,b.nickname,c.title');
                $this->db->from('hf_friends_lantern_answer as a');
                $this->db->join('hf_user_member as b', 'b.user_id = a.userid','inner');
                $this->db->join('hf_friends_lantern as c', 'c.id = a.question_id','inner');
                $query2 = $this->db->order_by('a.mysqlTime','desc')->limit($size,$page)->get();
                
                $listpage = $query2->result_array();
            }
            if(!empty($listpage)){
                echo json_encode(['total'=>count($list),'subjects'=>$listpage]);
            }else{
                echo "2";
            }

        }
    }

    //删除灯谜答案纪录
    function delLanternAnswer(){
        $id = intval($this->uri->segment('4'));
        if($id == '0'){
            $this->load->view('404.html');
        }else{
            if($this->db->where('id',$id)->delete('hf_friends_lantern_answer')){
                $log = array(

                        'userid'=>$_SESSION['users']['user_id'],  

                        "content" => $_SESSION['users']['username']."删除了猜灯谜问题回答纪录！id是".$data['id'],

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

    // //灯谜答案
    // function LanernAnswer(){
    //     $id = intval($this->uri->segment('4'));
    //     if($id == '0'){
    //         $this->load->view('404.html');
    //     }else{
    //         $query = $this->db->where('news_id',$id)->order_by('id','desc')->get('hf_friends_lantern_answer');
    //         $data['lists'] = $query->result_array();

    //         $query1 = $this->db->where('id',$id)->get('hf_friends_lantern');
    //         $data['info'] = $query1->row_array();

    //         $data['newsId'] = $id;
    //         $data['page'] = 'activity/LanernAnswer.html';
    //         $data['menu'] = array('activity','LanernAnswer');
    //         $this->load->view('template.html',$data);
    //     }
    // }

    // //新增灯谜答案
    // function addLanernAnswer(){
    //     if($_POST){
    //         $data = $this->input->post();
    //         $data['create_time'] = date('Y-m-d H:i:s',time());
            
    //         if($this->db->insert('hf_friends_lantern_answer',$data)){

    //                 $log = array(

    //                     'userid'=>$_SESSION['users']['user_id'],  

    //                     "content" => $_SESSION['users']['username']."新增了猜灯谜问题！",

    //                     "create_time" => date('Y-m-d H:i:s'),

    //                     "userip" => get_client_ip(),

    //                 );

    //                 $this->db->insert('hf_system_journal',$log);
    //                 echo "<script>alert('操作成功！');window.history.go(-1);</script>";exit;
    //         }else{
    //                 echo "<script>alert('操作失败！');window.history.go(-1);</script>";exit;

                    
    //         }
    //     }
    // }


}


?>