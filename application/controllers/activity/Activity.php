<?php  
defined('BASEPATH') OR exit('No direct script access allowed');

/*

*活动

 * */

require_once(APPPATH.'controllers/Default_Controller.php');

class Activity extends Default_Controller {

	public $christmas = 'hf_christmas_day';
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




}


?>