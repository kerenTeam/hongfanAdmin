  <?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*  为民服务
*/
require_once(APPPATH.'controllers/Default_Controller.php');

class ServeForPeople extends Default_Controller
{
	public $view_serveForPeople = 'module/serveForPeople/serveForPeople.html';	
	public $view_helpgrouplist = 'module/serveForPeople/helpgrouplist.html';
	public $view_addhelpgroup = 'module/serveForPeople/addhelpgroup.html';
	public $view_edithelpgroup = 'module/serveForPeople/edithelpgroup.html';
	public $view_helpgroupservelist = 'module/serveForPeople/helpgroupservelist.html';
    public $view_volunteerTeamservelist = 'module/serveForPeople/volunteerTeamservelist.html';
    public $view_volunteerTeamserveMess= 'module/serveForPeople/volunteerTeamserveMess.html';
    //编辑 义工活动
    public $view_volunteerActivityEdit= 'module/serveForPeople/volunteerActivityEdit.html';
    public $view_lawyergrouplist = 'module/serveForPeople/lawyergrouplist.html';
    public $view_lawyergroupservelist = 'module/serveForPeople/lawyergroupservelist.html';
    //新增 律师团成员
    public $viwe_lawyergroupAddUser = "module/serveForPeople/lawyergroupAddUser.html";

	function __construct()
	{
		 parent::__construct();
         $this->load->model('Service_model');  
        // $this->load->helper('search_helper');  
	}

	//为民服务 为民服务主页
    function serveForPeople(){
        $id  = intval($this->uri->segment('4'));
        if($id == 0){
            $this->load->view('404.html');
        }else{
            //获取团队信息
            $data['team'] = $this->Service_model->get_team_info();
            
            $data['id']   = $id;
            $data['page'] = $this->view_serveForPeople;
            $data['menu'] = array('serveForPeople',$id);
            $this->load->view('template.html',$data);
        }
    }
   
    //为民服务  邻水帮帮团成员列表
    function helpgrouplist(){
        $data['page'] = $this->view_helpgrouplist;
        $data['menu'] = array('serveForPeople','1');
        $this->load->view('template.html',$data);
    }
    //为民服务  义工团队信息
    function volunteerTeamserveMess(){
       //获取团队信息
        $data['team'] = $this->Service_model->get_team_info();
        $data['page'] = $this->view_volunteerTeamserveMess;
        $data['menu'] = array('serveForPeople','2');
        $this->load->view('template.html',$data);
    }
    //获取成员列表
    function helpUser_list(){
        if($_POST){
            //h获取列表
            $type = $this->input->post('default');
            $users = $this->Service_model->get_help_user($type);
            if(empty($users)){
                echo "2";
            }else{
                echo json_encode($users);
            }
        }else{
            echo "2";
        }
    }
    // 是否推荐
    function recommend(){
        if($_POST){
            $data['recommend'] = $_POST['state'];
            $id = $_POST['id'];
            if($this->Service_model->edit_helpuser_state($id,$data)){
                //日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."修改了帮帮团成员状态为推荐，帮帮团成员id是：".$id,
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
    //删除帮帮团成员
    function del_help_user(){
       if($_POST){
            $id = $_POST['id'];
            if(empty($id)){
                echo "2";exit;
            }
            if($this->Service_model->del_help_user($id)){
                 //日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."删除了一个帮帮团成员，帮帮团成员id是：".$id,
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
    //批量删除
    function del_users(){
        if($_POST){
            $id = $_POST['id'];
            if(empty($id)){
                echo "2";exit;
            }
            $arr = json_decode($id,true);
            foreach ($arr as $key => $v) {
                $res = $this->Service_model->del_help_user($v);
            }
            if($res){
                //日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."批量删除了帮帮团成员，帮帮团成员id是：".implode(’,‘,$arr),
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
    //导入帮帮团成员
    function impolt_help_user(){
       if(!empty($_FILES['file']['tmp_name'])){
            $name = date('Y-m-d');
            $inputFileName = "Upload/xls/" .$name .'.xls';
            move_uploaded_file($_FILES["file"]["tmp_name"],$inputFileName);
            //引入类库
            $this->load->library('excel');
            if(!file_exists($inputFileName)){
                    echo "<script>alert('文件导入失败!');window.location.href='".site_url('/serveForPeople/serveForPeople/volunteerTeamserveMess')."'</script>";
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


           $i = 0;   
           foreach ($PHPExcel->getActiveSheet()->getDrawingCollection() as $drawing) {
                if ($drawing instanceof PHPExcel_Worksheet_MemoryDrawing) {
                    ob_start();
                    call_user_func(
                        $drawing->getRenderingFunction(),
                        $drawing->getImageResource()
                    );
                    $imageContents = ob_get_contents();
                    ob_end_clean();
                    switch ($drawing->getMimeType()) {
                        case PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_PNG :
                                $extension = 'png'; break;
                        case PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_GIF:
                                $extension = 'gif'; break;
                        case PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_JPEG :
                                $extension = 'jpg'; break;
                    }
                } else {
                    $zipReader = fopen($drawing->getPath(),'r');
                    $imageContents = '';
                    while (!feof($zipReader)) {
                        $imageContents .= fread($zipReader,1024);
                    }
                    fclose($zipReader);
                    $extension = $drawing->getExtension();
                }
                $codata = $drawing->getCoordinates(); 
                $myFileName = 'Upload/headPic/'.date('His').++$i.'.'.$extension;
                file_put_contents($myFileName,$imageContents);
                $arr[$codata][]['headPic'] = $myFileName;
            }

           $allColumn = $currentSheet->getHighestColumn(); //取得最大的列号
           $allRow = $currentSheet->getHighestRow(); //取得一共有多少行
           $erp_orders_id = array();  //声明数组
          for($currentRow = 2;$currentRow <= $allRow;$currentRow++){
            $data['name'] = $PHPExcel->getActiveSheet()->getCell("A".$currentRow)->getValue();//获取A列的值
            if($data['name'] == NULL){
                 @unlink($inputFileName); 
                exit;
            }
            $data['age'] = $PHPExcel->getActiveSheet()->getCell("B".$currentRow)->getValue();//获取B列的值

            $data['sex'] = $PHPExcel->getActiveSheet()->getCell("C".$currentRow)->getValue();//获取B列的值
            $data['phone'] = $PHPExcel->getActiveSheet()->getCell("E".$currentRow)->getValue();//获取c列的值
            $data['email'] = $PHPExcel->getActiveSheet()->getCell("F".$currentRow)->getValue();//获取c列的值 
            $data['occupation'] = $PHPExcel->getActiveSheet()->getCell("G".$currentRow)->getValue();//获取c列的值 
            $com = $PHPExcel->getActiveSheet()->getCell("H".$currentRow)->getValue();//获取c列的值 
            $data['area'] = $PHPExcel->getActiveSheet()->getCell("I".$currentRow)->getValue();//获取c列的值
            $data['address'] = $PHPExcel->getActiveSheet()->getCell("J".$currentRow)->getValue();//获取c列的值
            $data['info'] = $PHPExcel->getActiveSheet()->getCell("K".$currentRow)->getValue();//获取c列的值
            $data['competency'] = json_encode(explode('&',$com),JSON_UNESCAPED_UNICODE);
            $data['import_userid'] = $this->session->users['user_id'];
            $data['profession_type'] = '1';

               //缩略图
            if(isset($arr['D'.$currentRow])){
                 $data['headPic'] = '/'.$arr['D'.$currentRow][0]['headPic'];
            }else{
                $data['headPic'] = '';
            } 
            $import =  $this->db->insert('hf_service_help_user',$data); 
            //日志
            $log = array(
                'userid'=>$_SESSION['users']['user_id'],  
                "content" => $_SESSION['users']['username']."导入了帮帮团成员",
                "create_time" => date('Y-m-d H:i:s'),
                "userip" => get_client_ip(),
            );
            $this->db->insert('hf_system_journal',$log);
          }
       }else{
            $this->load->view('404.html');
       }
    }

    //帮帮团搜索
    function help_search(){
        if($_POST){
            $name = trim($_POST['name']);
            $area = trim($_POST['area']);
            $address = trim($_POST['address']);
            $occupation = trim($_POST['occupation']);
            $sear = trim($_POST['sear']);
            $list = search_help_user($name,$area,$address,$occupation,$sear);

            if(empty($list)){
                echo "2";
            }else{
                echo json_encode($list);
            }
        }else{
            echo '2';
        }
    }
    //为民服务  邻水帮帮团服务列表
    function helpgroupservelist(){
        $data['page'] = $this->view_helpgroupservelist;
        $data['menu'] = array('serveForPeople','1');
        $this->load->view('template.html',$data);
    }
    //服务请求列表
    function help_request_list(){
         if($_POST){
             $type = $this->input->post('default');
            $requert = $this->Service_model->get_requert($type);
            if(empty($requert)){
                echo "2";
            }else{
                echo json_encode($requert);
            }
        }else{
            echo "2";
        }
    }
    //删除
    function del_help_request(){
        if($_POST){
            $id = $_POST['id'];
            if(empty($id)){
                echo "2";exit;
            }
            $arr = json_decode($id,true);
            foreach ($arr as $key => $value) {
               $res = $this->Service_model->del_help_request($value);
            }
            if($res){
              //日志
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."批量删除了服务请求，帮帮团成员id是：".implode(’,‘,$arr),
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                $this->db->insert('hf_system_journal',$log);
                echo "1";
            }else{
                echo '2';
            }
        }else{
            echo "2";
        }
    } 
    //回复请求人
    function reply_help_request(){
        if($_POST){
            $content = $_POST['content'];
            $id = $_POST['id'];
            $userid = $_POST['userid'];
            if(empty($content)){
                echo "2";exit;
            }
            $data['reply_content'] = $content;
            $data['state'] = '1';
            $data['reply_userid'] = $this->session->users['user_id'];
            $data['reply_time'] = date('Y-m-d H:i:s');
            $arr['userid'] = $userid;
            $arr['content'] = $content;
            $arr['sender'] = $this->session->users['user_id'];
            if($this->Service_model->edit_help_request($id,$data)){
                if($this->Service_model->add_user_message($arr)){
                         //日志
                    $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  
                        "content" => $_SESSION['users']['username']."回复了服务请求，回复内容：".$content.'回复请求id是：'.$id,
                        "create_time" => date('Y-m-d H:i:s'),
                        "userip" => get_client_ip(),
                    );
                    $this->db->insert('hf_system_journal',$log);
                    echo "1";
                }else{
                    echo "1";
                }
            }else{
                echo "2";
            }
        }else{
            echo "2";
        }
    }
    //帮帮团请求搜索
    function search_request(){
        if($_POST){
            $username = trim($_POST['username']);
            $helpname = trim($_POST['helpname']);
            $state = $_POST['state'];
            $sear = $_POST['sear'];
            //求助用户id
            $userid = $this->Service_model->get_user_id($username);
           
            //帮帮团成员id
            $helperid = $this->Service_model->get_help_userid($helpname); 
            $list = search_help_request($userid,$helperid,$state,$sear);
            if(empty($list)){
                echo "2";
            }else{
                echo json_encode($list);
            }
        }else{
            echo "2";
        }
    }
    //为民服务  添加邻水帮帮团
    function addhelpgroup(){
        $data['page'] = $this->view_addhelpgroup;
        $data['menu'] = array('serveForPeople','1');
        $this->load->view('template.html',$data);
    }
    //新增帮帮成员
    function add_help_user(){
        if($_POST){
            $data = $this->input->post();
            if(!empty($_FILES['img']['name'])){
                    $config['upload_path']      = 'Upload/headPic/';
                    $config['allowed_types']    = 'gif|jpg|png|jpeg';
                    $config['max_size']     = 2048;
                    $config['file_name'] = date('Y-m-d_His');
                    $this->load->library('upload', $config);
                    // 上传
                    if(!$this->upload->do_upload('img')) {
                         echo "<script>alert('图片上传失败！');window.location.href='".site_url('/serveForPeople/ServeForPeople/addhelpgroup')."'</script>";exit;
                    }else{
                      
                        $data['headPic'] = '/Upload/headPic/'.$this->upload->data('file_name');
                   }     
            }
            $data['profession_type'] = '1';
            $data['competency'] = json_encode(explode("&",$data['competency']),JSON_UNESCAPED_UNICODE);
            if($this->Service_model->add_help_user($data)){
                     //日志
                    $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  
                        "content" => $_SESSION['users']['username']."新增了一个帮帮团成员，成员名称是：".$data['name'],
                        "create_time" => date('Y-m-d H:i:s'),
                        "userip" => get_client_ip(),
                    );
                    $this->db->insert('hf_system_journal',$log);
                 echo "<script>alert('操作成功！');window.location.href='".site_url('/serveForPeople/ServeForPeople/helpgrouplist')."'</script>";exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/serveForPeople/ServeForPeople/addhelpgroup')."'</script>";exit;
            }
            
        }else{
            
            $this->load->view('404.html');
        }
    }

	//为民服务  编辑邻水帮帮团
    function edithelpgroup(){
        $id = intval($this->uri->segment('4'));
        if($id == 0){
            $this->load->view('404.html');
        }else{
            //获取帮帮团成员信息
            $data['info'] = $this->Service_model->ret_help_userinfo($id);
            $data['page'] = $this->view_edithelpgroup;
            $data['menu'] = array('serveForPeople','1');
            $this->load->view('template.html',$data);
        }
    }
    //编辑操作
    function edit_hele_user(){
        if($_POST){
            $data = $this->input->post();
            if(!empty($_FILES['img']['name'])){
                    $config['upload_path']      = 'Upload/headPic/';
                    $config['allowed_types']    = 'gif|jpg|png|jpeg';
                    $config['max_size']     = 2048;
                    $config['file_name'] = date('Y-m-d_His');
                    $this->load->library('upload', $config);
                    // 上传
                    if(!$this->upload->do_upload('img')) {
                         echo "<script>alert('图片上传失败！');window.location.href='".site_url('/serveForPeople/ServeForPeople/edithelpgroup/'.$data['id'])."'</script>";exit;
                    }else{
                      
                        $data['headPic'] = '/Upload/headPic/'.$this->upload->data('file_name');
                   }     
            }
            $id = $data['id'];
            unset($data['img'],$data['id']);
            $con = mb_substr($data['competency'], 0, -1);
            $data['competency'] = json_encode(explode('&',$con),JSON_UNESCAPED_UNICODE);

            if($this->Service_model->edit_help_user($id,$data))
            {
                 //日志
                    $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  
                        "content" => $_SESSION['users']['username']."编辑了一个帮帮团成员，成员名称是：".$data['name'].",成员id是：".$id,
                        "create_time" => date('Y-m-d H:i:s'),
                        "userip" => get_client_ip(),
                    );
                    $this->db->insert('hf_system_journal',$log);
                  echo "<script>alert('操作成功！');window.location.href='".site_url('/serveForPeople/ServeForPeople/helpgrouplist')."'</script>";exit;

            } else{
               echo "<script>alert('操作失败！');window.location.href='".site_url('/serveForPeople/ServeForPeople/edithelpgroup/'.$id)."'</script>";exit;
            }
           
        }else{
            $this->load->view('404.html');
        }
    }

    //服务请求导出
    function dowload_helprequest(){
        if($_GET){
            $type = $_GET['id'];
            $this->load->library('excel');
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Stores');
            $arr_title = array(
                'A' => '求助人',
                'B' => '求助内容',
                'C' => '求助时间',
                'D' => '联系电话',
                'E' => '求助对象',
                'F' => '服务状态',
                'G' => '回复内容',
                'H' => '回复时间'
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
            $bookings = $this->Service_model->get_requert($type);
            if(count($bookings) > 0)
            {
                foreach ($bookings as $booking) {
                    $i++;
                    if($booking['state'] == 0){
                        $t = "待解决";
                    }else{
                        $t = '已解决';
                    }
                 //   $this->excel->getActiveSheet()->setCellValue('A' . $i,  $i - 1);
                    $this->excel->getActiveSheet()->setCellValue('A' . $i, $booking['username']);
                    $this->excel->getActiveSheet()->setCellValue('B' . $i, $booking['content']);
                    $this->excel->getActiveSheet()->setCellValue('C' . $i, $booking['create_time']);
                    $this->excel->getActiveSheet()->setCellValue('D' . $i, $booking['phone']);
                    $this->excel->getActiveSheet()->setCellValue('E' . $i, $booking['name']);
                    $this->excel->getActiveSheet()->setCellValue('F' . $i, $booking['state']);
                    $this->excel->getActiveSheet()->setCellValue('G' . $i, $booking['reply_content']);
                    $this->excel->getActiveSheet()->setCellValue('H' . $i, $booking['reply_time']);
                }
            }
            if($id ==1){
                $filename = '帮帮团服务请求.xls'; //save our workbook as this file name
            }else{
                $filename = '律师团服务请求.xls'; 
            }
            ob_end_clean();
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            
            $log = array(
                'userid'=>$_SESSION['users']['user_id'],  
                "content" => $_SESSION['users']['username']."导出了所有请求信息！",
                "create_time" => date('Y-m-d H:i:s'),
                "userip" => get_client_ip(),
            );
            $this->db->insert('hf_system_journal',$log);


            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            $objWriter->save('php://output');
        }else{
            $this->load->view('404.html');
        }
    }

   //为民服务  义工团队 服务列表
    function volunteerTeamservelist(){
        $data['page'] = $this->view_volunteerTeamservelist;
        $data['menu'] = array('serveForPeople','2');
        $this->load->view('template.html',$data);
    }

    //编辑义工团队信息
    function edit_team_info(){
        if($_POST){
            $data = $this->input->post();
            if(!empty($_FILES['img']['name'])){
                    $config['upload_path']      = 'Upload/team/';
                    $config['allowed_types']    = 'gif|jpg|png|jpeg';
                    $config['max_size']     = 2048;
                    $config['file_name'] = date('Y-m-d_His');
                    $this->load->library('upload', $config);
                    // 上传
                    if(!$this->upload->do_upload('img')) {
                         echo "<script>alert('图片上传失败！');window.location.href='".site_url('/serveForPeople/ServeForPeople/volunteerTeamserveMess')."'</script>";exit;
                    }else{
                        $data['picImg'] = '/Upload/team/'.$this->upload->data('file_name');
                   }     
            }
            if($this->Service_model->edit_team_info($data['id'],$data)){
                   $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  
                        "content" => $_SESSION['users']['username']."编辑了义工团队信息",
                        "create_time" => date('Y-m-d H:i:s'),
                        "userip" => get_client_ip(),
                    );
                    $this->db->insert('hf_system_journal',$log);
                echo "<script>alert('操作成功！');window.location.href='".site_url('/serveForPeople/ServeForPeople/serveForPeople/2')."'</script>";exit;
            }else{
                 echo "<script>alert('操作失败！');window.location.href='".site_url('/serveForPeople/ServeForPeople/volunteerTeamserveMess')."'</script>";exit;
            }
        }else{
            $this->load->view('404.html');
        }
    }

    //义工团心发布活动
    function add_volunteer_activities(){
        if($_POST){
            $data = $this->input->post();
            if(!empty($_FILES['img']['name'])){
                    $config['upload_path']      = 'Upload/team/';
                    $config['allowed_types']    = 'gif|jpg|png|jpeg';
                    $config['max_size']     = 2048;
                    $config['file_name'] = date('Y-m-d_His');
                    $this->load->library('upload', $config);
                    // 上传
                    if(!$this->upload->do_upload('img')) {
                         echo "<script>alert('图片上传失败！');window.location.href='".site_url('/serveForPeople/ServeForPeople/serveForPeople/2')."'</script>";exit;
                    }else{
                        $data['picImg'] = '/Upload/team/'.$this->upload->data('file_name');
                   }     
            }
            if($this->Service_model->add_volunteer_activities($data)){
                    $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  
                        "content" => $_SESSION['users']['username']."发布了一个义工团队活动，活动名称是：".$data['title'],
                        "create_time" => date('Y-m-d H:i:s'),
                        "userip" => get_client_ip(),
                    );
                    $this->db->insert('hf_system_journal',$log);
                  echo "<script>alert('操作成功！');window.location.href='".site_url('/serveForPeople/ServeForPeople/volunteerTeamservelist')."'</script>";exit;
            }else{
                  echo "<script>alert('操作失败！');window.location.href='".site_url('/serveForPeople/ServeForPeople/serveForPeople/2')."'</script>";exit;
            }
        }else{
            $this->load->view('404.html');
        }
    }
    //义工团队 编辑活动
    function volunteerActivityEdit(){
        $data['page'] = $this->view_volunteerActivityEdit;
        $data['menu'] = array('serveForPeople','2');
        $this->load->view('template.html',$data);
    }
    //获取义工团队活动列表
    function get_volunter_activities_list(){
        if($_POST){
            $list = $this->Service_model->get_activities_list();
            if(empty($list)){
                echo "2";
            }else{
                echo json_encode($list);
            }
        }else{
            echo "2";
        }
    }

    //批量删除活动
    function del_volunter_activivies(){
        if($_POST){
            $id = $_POST['id'];
            if(empty($id)){
                echo "2";exit;
            }
            $arr = json_decode($id,true);
            foreach ($arr as $key => $v) {
                $res = $this->Service_model->del_volunter_activivies($v);
            }
            if($res){
                    $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  
                        "content" => $_SESSION['users']['username']."批量删除了义工团队活动，活动id是：".implode(',',$arr),
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
    //活动单个删除
    function del_volunter_active(){
        if($_POST){
            $id = $_POST['id'];
            if(empty($id)){
                echo "2";exit;
            }
            if($this->Service_model->del_volunter_activivies($id)){
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  
                    "content" => $_SESSION['users']['username']."删除了义工团队活动，活动id是：".$id,
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

     //为民服务  邻水律师团 成员列表
    function lawyergrouplist(){
        $data['page'] = $this->view_lawyergrouplist;
        $data['menu'] = array('serveForPeople','3');
        $this->load->view('template.html',$data);
    }

    //新增 律师团成员
    function add_lawyerfroup_user(){
        
        $data['page'] = $this->viwe_lawyergroupAddUser;
        $data['menu'] = array('serveForPeople','3');
        $this->load->view('template.html',$data);
    }

    //新增操作
    function add_lawyerfroupUser(){
        if($_POST){
            $data = $this->input->post();
            if(!empty($_FILES['img']['name'])){
                    $config['upload_path']      = 'Upload/headPic/';
                    $config['allowed_types']    = 'gif|jpg|png|jpeg';
                    $config['max_size']     = 2048;
                    $config['file_name'] = date('Y-m-d_His');
                    $this->load->library('upload', $config);
                    // 上传
                    if(!$this->upload->do_upload('img')) {
                         echo "<script>alert('图片上传失败！');window.location.href='".site_url('/serveForPeople/ServeForPeople/add_lawyerfroup_user')."'</script>";exit;
                    }else{
                      
                        $data['headPic'] = '/Upload/headPic/'.$this->upload->data('file_name');
                   }     
            }
            $data['profession_type'] = '2';
            $data['competency'] = json_encode(explode("、",$data['competency']),JSON_UNESCAPED_UNICODE);
            if($this->Service_model->add_help_user($data)){
                     //日志
                    $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  
                        "content" => $_SESSION['users']['username']."新增了一个律师团成员，成员名称是：".$data['name'],
                        "create_time" => date('Y-m-d H:i:s'),
                        "userip" => get_client_ip(),
                    );
                    $this->db->insert('hf_system_journal',$log);
                 echo "<script>alert('操作成功！');window.location.href='".site_url('/serveForPeople/ServeForPeople/lawyergrouplist')."'</script>";exit;
            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/serveForPeople/ServeForPeople/add_lawyerfroup_user')."'</script>";exit;
            }

        }else{
            $this->load->view('404.html');
        }
    }



    //编辑 律师团成员操作
    function edit_lawyergroupUser(){
        if($_POST){ 
            $data = $this->input->post();
            if(!empty($_FILES['picArray']['name'])){
                    $config['upload_path']      = 'Upload/headPic/';
                    $config['allowed_types']    = 'gif|jpg|png|jpeg';
                    $config['max_size']     = 2048;
                    $config['file_name'] = date('Y-m-d_His');
                    $this->load->library('upload', $config);
                    // 上传
                    if(!$this->upload->do_upload('picArray')) {
                         echo "<script>alert('图片上传失败！');window.location.href='".site_url('/serveForPeople/ServeForPeople/helpgrouplist')."'</script>";exit;
                    }else{
                      
                        $data['headPic'] = '/Upload/headPic/'.$this->upload->data('file_name');
                   }     
            }
            $id = $data['id'];
            unset($data['picArray'],$data['id']);
           // $con = mb_substr($data['competency'], 0, -1);
            $data['competency'] = json_encode(explode('、',$data['competency']),JSON_UNESCAPED_UNICODE);
          //  var_dump($data);
            if($this->Service_model->edit_help_user($id,$data))
            {
                 //日志
                    $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  
                        "content" => $_SESSION['users']['username']."编辑了一个律师团成员，成员名称是：".$data['name'].",成员id是：".$id,
                        "create_time" => date('Y-m-d H:i:s'),
                        "userip" => get_client_ip(),
                    );
                    $this->db->insert('hf_system_journal',$log);
                echo "1";
            } else{
                echo "2";
            }
        }else{
            $this->load->view('404.html');
        }
    }

    //律师团搜索
    function search_lawyerGroupUser(){
        if($_POST){
            $sear = $this->input->post('name');
            if(!empty($sear)){
                $list = $this->Service_model->search_lawergroup($sear);
            }else{
                $list = $this->Service_model->get_help_user('2');
            }
            if(!empty($list)){
                echo json_encode($list);
            }else{
                echo "2";
            }
        }else{
           echo "3";
        }
    }

         //为民服务  邻水律师团 服务列表
    function lawyergroupservelist(){
        $data['page'] = $this->view_lawyergroupservelist;
        $data['menu'] = array('serveForPeople','3');
        $this->load->view('template.html',$data);
    }









}







