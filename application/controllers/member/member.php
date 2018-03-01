<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  会员管理
 *
 * */
require_once(APPPATH.'controllers/Default_Controller.php');

class Member extends Default_Controller {
    //会员列表
    public $view_memberList = 'member/memberList.html';
    //新增会员
    public $view_addMember = 'member/addMember.html';  
    //编辑会员
    public $view_editMember = 'member/editMember.html'; 
    //会员详情管理
    public $view_memberInfo = 'member/memberInfo.html';
    //会员卡列表
    public $view_memberCard = "member/memberCard.html";
    //新增会员卡
    public $view_memberCardAdd = "member/memberCardAdd.html";
    //编辑会员卡
    public $view_memberCardDetail = 'member/memberCardDetail.html';

    function __construct()
    {
        parent::__construct();
    }

    //会员 列表
    function memberList()
    {
       
        $data['userNum'] = $this->user_model->selectMember();
        //获取今天
        $time = date('Y-m-d',time());
        $data['newNum'] = $this->user_model->new_member_num($time);

        //获取昨天
        $d = date("Y-m-d",strtotime("-1 day"));
        $data['yesterday'] = $this->user_model->new_member_num($d);
        if(!isset($_SESSION['userPage'])){
            $_SESSION['userPage'] = '0';
        }
        
        $data['page'] = $this->view_memberList;
        $data['menu'] = array('member','memberList');
    	$this->load->view('template.html',$data);
    }

    //返回会员列表
    function ret_member_list(){
        if($_POST){
            $page = $this->input->post('page');
            $size = $this->input->post('size');

            $gender = $this->input->post('gender');
            $start_time = $this->input->post('begin_date');
            $end_time = $this->input->post('end_date');
            $sear = trim($this->input->post('sear'));

            if(!empty($start_time)){
                $t = $start_time .' 00:00:00';
                $e = $end_time .' 23:59:59';
            }else{
                $t = '';
                $e = '';
            }
            $_SESSION['userPage'] = $page;


            $list = selectMember($gender,$t,$e,$sear);
            $listpage = selectMember_page($gender,$t,$e,$sear,$size,$page);

            if(!empty($listpage)){
                echo json_encode(['total'=>count($list),'subjects'=>$listpage]);

            }else{
                echo "2";
            }
        }else{
            echo "3";
        }
    }


    //新增会员
    function addMember(){

        $data['cards'] = $this->user_model->get_card_type( );
          //视图界面
        $data['page'] = $this->view_addMember;
        $data['menu'] = array('member','addMember');
        $this->load->view('template.html',$data);
    }

    //新增会员操作
    function add_user(){
        if($_POST){
            $data = $this->input->post();
            $data['password'] = md5($this->input->post('password'));
            $data['gid'] = '5';
            //是否被注册
            $user = $this->user_model->get_login_user($data['phone']);
            if($user){
                echo "<script>alert('电话已被注册！请重新添加！');window.location.href='".site_url('/member/Member/addMember')."'</script>";
                exit;
            }
            //插入
            if($this->user_model->add_user_member($data)){
                 //日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."新增了一个普通用户。用户名是".$data['username'],
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);
                echo "<script>alert('操作成功！');window.location.href='".site_url('/member/Member/memberList')."'</script>";
                exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/member/Member/addMember')."'</script>";
                exit;
            }
        }else{
            $this->load->view('404.html');
        }
    }

    //编辑会员
    function editMember(){

         $id = intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
            //获取会员信息
            $data['userinfo'] = $this->user_model->get_user_info($id);
            //获取分组信息
           // $data['group'] = $this->user_model->get_user_group();
             $data['cards'] = $this->user_model->get_card_type( );
            $data['userid'] = $id;
            //视图界面
            $data['page'] = $this->view_editMember;
            $data['menu'] = array('member','memberList');
            $this->load->view('template.html',$data);
        }
    }

    //编辑处理
    function edit_userinfo(){
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
            if(!empty(trim($data['password']))){
                $data['password'] = md5($this->input->post('password'));
            }else{
                unset($data['password']);
            }
            
            // 9cbf8a4dcb8e30682b927f352d6559a0
            if($this->user_model->edit_userinfo($data['user_id'],$data)){
                //日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."编辑了一个普通用户。用户名是".$data['nickname']."用户id是：".$data['user_id'],
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);
                echo "<script>alert('操作成功！');window.location.href='".site_url('/member/Member/memberList')."'</script>";
                exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/member/Member/editMember/'.$data['userid'])."'</script>";
                exit;
            }
        }else{
            $this->load->view('404.html');
        }
    }
    //删除会员
    function delMember(){
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
        $id = intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
          
            //自己不能删除
            if($id == $_SESSION['users']['user_id']){
                echo "<script>alert('不能删除自己！');window.location.href='".site_url('/member/Member/memberList')."'</script>";
                exit;
            }
            if($this->user_model->del_member($id)){
                //日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."删除了一个普通用户。用户id是：".$id,
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);
                echo "<script>alert('操作成功！');window.location.href='".site_url('/member/Member/memberList')."'</script>";
                exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/member/Member/memberList')."'</script>";
                exit;
            }
        }
    }
    //会员详情管理
    function memberInfo(){
        $id=intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
            //用户信息
            $data['userinfo'] = $this->user_model->get_user_info($id);
            //用户地址
            $data['address'] = $this->user_model->get_user_address('hf_user_address',$id);
            //用户积分记录
            $data['inter'] = $this->user_model->get_user_address('hf_user_intergral',$id);
            //消息记录
            $data['message'] = $this->user_model->get_user_address('hf_user_message',$id);
             //视图界面
            $data['page'] = $this->view_memberInfo;
            $data['menu'] = array('member','memberList');
            $this->load->view('template.html',$data);
        }
    }

    //返回用户消息
    function ret_user_message(){
        if($_POST){
            $id = $_POST['userid'];
                    //消息记录
            $list= $this->user_model->get_user_address('hf_user_message',$id);
            if(empty($list)){
                echo "3";
            }else{
                echo json_encode($list);
            }
        }else{
            echo "2";
        }
    }

    //返回用户积分记录
    function ret_user_intergral(){
        if($_POST){
            $id = $_POST['userid'];
            $list = $this->user_model->get_user_address('hf_user_intergral',$id);
            if(empty($list)){
                echo "3";
            }else{
                echo json_encode($list);
            }
        }else{
            echo "2";
        }
    }

    //返回用户地址
    function ret_user_address(){
        if($_POST){
                $id = $_POST['userid'];
                $list = $this->user_model->get_user_address('hf_user_address',$id);
                if(empty($list)){
                    echo "3";
                }else{
                    echo json_encode($list);
                }
        }else{
            echo "2";
        }
    }



    //会员组
    function memberGroup()
    {

        $this->load->view('member/memberGroup.html');
    }

    //会员卡管理
    function memberCard(){
        //获取所有会员卡
        $data['cards'] = $this->user_model->get_card_type();
          //视图界面
            $data['page'] = $this->view_memberCard;
            $data['menu'] = array('member','memberCard');
            $this->load->view('template.html',$data);
    }

    //会员卡管理-会员卡详情
    function memberCardDetail(){
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
        $id=intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
            //获取会员卡详情
            $data['card'] = $this->user_model->get_cardinfo($id);
            $data['id'] = $id;
            //视图界面
            $data['page'] = $this->view_memberCardDetail;
            $data['menu'] = array('member','memberCard');
            $this->load->view('template.html',$data);
        }
    }
    //会员卡编辑处理
    function edit_card(){
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
            if(!empty($_FILES['img']['tmp_name'])){
                //配置
                $config['upload_path']      = 'Upload/cards';
                $config['allowed_types']    = 'gif|jpg|png|jpeg';
                $config['max_size']     = 2048;
                $config['file_name'] = date('Y-m-d_His');
                $this->load->library('upload', $config);
                //上传
                if ( ! $this->upload->do_upload('img')) {
                    echo "<script>alert('图片上传失败！');window.location.href='".site_url('/member/Member/memberCardDetail/'.$data['id'])."'</script>";
                    exit;
                } else{
                    $data['pic'] =  '/Upload/cards/'.$this->upload->data('file_name');
                }
            }
            //操作数据库
            if($this->user_model->edit_cards($data['id'],$data)){
                 //日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."编辑了一个会员卡。会员卡名是".$data['name']."会员卡Id是:".$data['id'],
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);
                echo "<script>alert('操作成功！');window.location.href='".site_url('/member/Member/memberCard')."'</script>";
                exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/member/Member/memberCardDetail/'.$data['id'])."'</script>";
                exit;
            }
        }else{
            $this->load->view('404.html');
        }
    }

    //删除会员卡
    function del_card(){
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
        $id=intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
            if($this->user_model->del_cards($id)){
                //日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."删除了一个会员卡。会员卡Id是:".$id,
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/member/Member/memberCard')."'</script>";
                exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/member/Member/memberCard')."'</script>";
                exit;
            }
        }

    }

    //会员卡管理-添加会员卡
    function memberCardAdd(){
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
 
            $data['page'] = $this->view_memberCardAdd;
            $data['menu'] = array('member','memberCard');
            $this->load->view('template.html',$data);
    }

    //会员卡新增操作
    function add_cards(){
        if($_POST){
            $data = $this->input->post();
            if(!empty($_FILES['img']['tmp_name'])){
                $config['upload_path']      = 'Upload/cards';
                $config['allowed_types']    = 'gif|jpg|png|jpeg';
                $config['max_size']     = 2048;
                $config['file_name'] = date('Y-m-d_His');

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('img'))
                {
                    echo "<script>alert('图片上传失败！');window.location.href='".site_url('/member/Member/memberCardAdd')."'</script>";
                    exit;
                }
                else
                {
                    $data['pic'] =  '/Upload/cards/'.$this->upload->data('file_name');
                }
            }
            if($this->user_model->add_cards($data)){
                 //日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."新增了一个会员卡。会员卡名是".$data['name'],
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);

                echo "<script>alert('操作成功！');window.location.href='".site_url('/member/Member/memberCard')."'</script>";
                exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/member/Member/memberCardAdd')."'</script>";
                exit;
            }
        }else{
            $this->load->view('404.html');
        }
    }

    //屏蔽会员/解除会员屏蔽
    function up_user_state(){
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
        
    	$state=intval($this->uri->segment(4));
    	$id=intval($this->uri->segment(5));
        //是否是修改状态
    	if($id ==0 && $state ==0){
    		$this->load->view('404.html');
    	}else if($state == 1 || $state ==2){
    	    //网站建立者不能屏蔽
    		if($id == 1){
    			echo "<script>alert('网站创建者不能冻结！');window.location.href='".site_url('/member/Member/memberList')."'</script>";
    			exit;
    		}
    		//自己不能屏蔽
    		if($id == $_SESSION['users']['user_id']){
    			echo "<script>alert('不能冻结自己！');window.location.href='".site_url('/member/Member/memberList')."'</script>";
    			exit;
    		}
    		if($state == 2){
    			$state = 0;
    		}
    		$arr = array('state'=>$state);
    		if($this->user_model->edit_state($id,$arr)){
                 //日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."屏蔽了一个会员。会员id是".$id,
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);
				echo "<script>alert('操作成功！');window.location.href='".site_url('/member/Member/memberList')."'</script>";
				exit;
    		}else{
    			echo "<script>alert('失败，请重新操作！');window.location.href='".site_url('/member/Member/memberList')."'</script>";
				exit;
    		}
    	}else{
    		$this->load->view('404.html');
    	}
    }


    //积分纪录
    function integralList(){

        $data['page'] = 'member/integralList.html';
        $data['menu'] = array('member','integralRec');
        if(isset($_SESSION['intNum'])){
            $_SESSION['intNum'] = '0';
        }
        $this->load->view('template.html',$data);
    }

    //
    function retIntegralRecomd(){
        if($_POST){
            // HI豆的独立统计分析（可做到会员中心里），每个用户每一次的HI豆获取和使用记录统计，时间、数量、渠道，收支合计，分类筛选。 全员的合计（周期筛选，历史累计（后面2个求和），当前余额，累计使用）
            $type = $this->input->post('type');
            $phone = $this->input->post('phone');
            $begin_time = $this->input->post('begin_time');
            $end_time = $this->input->post('end_time');

            if(!empty($begin_time)){
                $t = $begin_time .' 00:00:00';
                $e = $end_time.' 23:59:59';
            }else{
                $t = '';
                $e = '';
            }
            
            $page = $this->input->post('start');
            $_SESSION['intNum'] = $page;
            $size = $this->input->post('count');

            //
            $list = searchIntegral($type,$phone,$t,$e);
            $listpage = searchIntegral_page($type,$phone,$t,$e,$size,$page);
            // var_dump(count($list));
            if(!empty($listpage)){
                echo json_encode(['total'=>count($list),'subjects'=>$listpage]);
            }else{
                echo "2";
            }
            
        }
    }

    //导出会员内容
    function dowUserMember(){
        if($_POST){
            $time = $this->input->post('begin_time');
            $endtime = $this->input->post('end_time');

            if(!empty($time)){
                $t = $time.' 00:00:00';
                $e = $endtime.' 23:59:59';
            }else{
                $t = '';
                $e = '';
            }


            $sql1 = "select user_id,phone,username,nickname,city,create_time,gender,intergral from hf_user_member where create_time >='".$t."' and create_time <='".$e."' and gid ='5' order by create_time desc";
            $query1 = $this->db->query($sql1);
            $res1 = $query1->result_array();

            
            if(!empty($res1)){
                $this->load->library('excel');

                //activate worksheet number 1

                $this->excel->setActiveSheetIndex(0);

                //name the worksheet

                $this->excel->getActiveSheet()->setTitle('Stores');

                $arr_title = array(

                    'A' => '用户编号',
                    'B' => '所属城市',
                    'C' => '姓名',
                    'D' => '用户昵称',
                    'E' => '电话',
                    'F' => '性别',
                    'G' => '会员积分',
                    'H' => '注册时间',
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

               // $bookings = $this->Shop_model->shop_list($id);


                foreach ($res1 as $booking) {
                    $i++;
                   
                    $this->excel->getActiveSheet()->setCellValue('A' . $i, $booking['user_id']);
                    switch ($booking['city']) {
                        case '1':
                             $this->excel->getActiveSheet()->setCellValue('B' . $i, '重庆');

                            break;    
                        case '2':
                            $this->excel->getActiveSheet()->setCellValue('B' . $i, '南江');

                            break;    
                        case '3':
                             $this->excel->getActiveSheet()->setCellValue('B' . $i, '宣汉');

                            break; 
                        case '4':
                             $this->excel->getActiveSheet()->setCellValue('B' . $i, '邻水');

                            break;
                        
                        default:
                            $this->excel->getActiveSheet()->setCellValue('B' . $i, '');
                            break;
                    }
                    $this->excel->getActiveSheet()->setCellValue('C' . $i, $booking['username']);
                    $this->excel->getActiveSheet()->setCellValue('D' . $i, $booking['nickname']);
                    $this->excel->getActiveSheet()->setCellValue('E' . $i, $booking['phone']);
                    //性别 1男2女3商家4保密
                    switch ($booking['gender']) {
                        case '1':
                            $this->excel->getActiveSheet()->setCellValue('F' . $i, '男');
                            break; 
                        case '2':
                            $this->excel->getActiveSheet()->setCellValue('F' . $i, '女');
                            break; 
                        default:
                            $this->excel->getActiveSheet()->setCellValue('F' . $i, '保密');
                            break;
                    }
                    $this->excel->getActiveSheet()->setCellValue('G' . $i, $booking['intergral']);
                
                    $this->excel->getActiveSheet()->setCellValue('H' . $i, $booking['create_time']);
                  
                }

                
                $filename = '注册用户.xls'; //save our workbook as this file name



                header('Content-Type: application/vnd.ms-excel'); //mime type

                header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name

                header('Cache-Control: max-age=0'); //no cache



                $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

                $objWriter->save('php://output');


            }
        }
    }

    //用户分析
    function useranalysis(){

        //获取注册用户
        // $list = YueselectList("hf_user_member",'create_time');
        // $list = ToDayselectList("hf_user_member",'create_time');
        // var_dump($list);
        // exit;
        $startTime = date("Y-m-d",strtotime("-1 day"));
        $endTime = date("Y-m-d",strtotime("-1 day"));
        // var_dump($startTime);
        // exit;

        $data['page'] = 'member/useranalysis.html';
        $data['menu'] = array('member','useranalysis');
        
       // var_dump($_SESSION['userAnaly']);
        $this->load->view('template.html',$data);

    }
    //返回时间段纪录
    function DateList(){
        if($_POST){
            $t = $this->input->post('time');
            $e = $this->input->post('endtime');


            $da = prDates($t,$e);

            foreach ($da as $key => $value) {
                //用户
                $etime = date("Y-m-d",strtotime("+1 day",strtotime($value['Ymdate'])));
               
                $da[$key]['userNum'] = retDateList('gid','=','5','hf_user_member','create_time',$value['Ymdate'],$etime);
                $da[$key]['friendsNum'] = retDateList('typeId','=','1','hf_friends_news','create_time',$value['Ymdate'],$etime);
                $da[$key]['wenDaNum'] = retDateList('typeId','=','2','hf_friends_news','create_time',$value['Ymdate'],$etime);
                $da[$key]['orderNum'] = retDateList('order_status','!=','1','hf_mall_order','create_time',$value['Ymdate'],$etime);
            }
            array_multisort(array_column($da,'Ymdate'),SORT_DESC,$da);
            $userNum = retDateList('gid','=','5','hf_user_member','create_time',$t,$e);
            $friendsNum = retDateList('typeId','=','1','hf_friends_news','create_time',$t,$e);
            $wenDaNum = retDateList('typeId','=','2','hf_friends_news','create_time',$t,$e);
            $orderNum = retDateList('order_status','!=','1','hf_mall_order','create_time',$t,$e);



            if(!empty($da)){
                echo json_encode(["list"=>$da,"userListNum"=>$userNum,"friendsNum"=>$friendsNum,"wendaNum"=>$wenDaNum,"orderNum"=>$orderNum]);
            }else{
                echo "2";
            }
            
        }
    }

  



}

