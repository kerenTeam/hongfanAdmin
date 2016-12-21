  <?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*  为民服务
*/
require_once(APPPATH.'controllers/default_Controller.php');

class serveForPeople extends default_Controller
{
	public $view_serveForPeople = 'module/serveForPeople/serveForPeople.html';	
	public $view_helpgrouplist = 'module/serveForPeople/helpgrouplist.html';
	public $view_addhelpgroup = 'module/serveForPeople/addhelpgroup.html';
	public $view_edithelpgroup = 'module/serveForPeople/edithelpgroup.html';
	public $view_helpgroupservelist = 'module/serveForPeople/helpgroupservelist.html';
	function __construct()
	{
		 parent::__construct();
         $this->load->model('service_model');  
	}

	//为民服务 为民服务主页
    function serveForPeople(){
        $data['page'] = $this->view_serveForPeople;
        $data['menu'] = array('localLife','serveForPeople');
        $this->load->view('template.html',$data);
    }
    //

	//为民服务  邻水帮帮团成员列表
    function helpgrouplist(){
        $data['page'] = $this->view_helpgrouplist;
        $data['menu'] = array('localLife','serveForPeople');
        $this->load->view('template.html',$data);
    }
    //获取成员列表
    function helpUser_list(){
        if($_POST){
            //h获取列表
            $users = $this->service_model->get_help_user();
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
            if($this->service_model->edit_helpuser_state($id,$data)){
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
            if($this->service_model->del_help_user($id)){
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
                $res = $this->service_model->del_help_user($v);
            }
            if($res){
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
            $inputFileName = "upload/xls/" .$name .'.xls';
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
            $data['name'] = $PHPExcel->getActiveSheet()->getCell("A".$currentRow)->getValue();//获取A列的值
            if($data['name'] == NULL){
                 @unlink($inputFileName); 
                exit;
            }
            $data['sex'] = $PHPExcel->getActiveSheet()->getCell("B".$currentRow)->getValue();//获取B列的值
            $data['phone'] = $PHPExcel->getActiveSheet()->getCell("C".$currentRow)->getValue();//获取c列的值
            $data['email'] = $PHPExcel->getActiveSheet()->getCell("D".$currentRow)->getValue();//获取c列的值 
            $data['occupation'] = $PHPExcel->getActiveSheet()->getCell("E".$currentRow)->getValue();//获取c列的值 
           $com = $PHPExcel->getActiveSheet()->getCell("F".$currentRow)->getValue();//获取c列的值 
            $data['area'] = $PHPExcel->getActiveSheet()->getCell("G".$currentRow)->getValue();//获取c列的值
            $data['address'] = $PHPExcel->getActiveSheet()->getCell("H".$currentRow)->getValue();//获取c列的值
            $data['info'] = $PHPExcel->getActiveSheet()->getCell("I".$currentRow)->getValue();//获取c列的值
            $data['competency'] = json_encode(explode(',',$com),JSON_UNESCAPED_UNICODE);
            $data['import_userid'] = $this->session->users['user_id'];

           
            $import =  $this->db->insert('hf_service_help_user',$data); 
           

          }
       }else{
            $this->load->view('404.html');
       }
    }

    //帮帮团搜索
    function help_search(){
        if($_POST){
            $name = $_POST['name'];
            $area = $_POST['area'];
            $address = $_POST['address'];
            $occupation = $_POST['occupation'];
            $sear = $_POST['sear'];

        }else{
            echo '2';
        }
    }
    //为民服务  邻水帮帮团服务列表
    function helpgroupservelist(){
        $data['page'] = $this->view_helpgroupservelist;
        $data['menu'] = array('localLife','serveForPeople');
        $this->load->view('template.html',$data);
    }
    //服务请求列表
    function help_request_list(){
         if($_POST){
            $requert = $this->service_model->get_requert();
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
               $res = $this->service_model->del_help_request($value);
            }
            if($res){
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
            if($this->service_model->edit_help_request($id,$data)){
                if($this->service_model->add_user_message($arr)){
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
    //为民服务  添加邻水帮帮团
    function addhelpgroup(){
        $data['page'] = $this->view_addhelpgroup;
        $data['menu'] = array('localLife','serveForPeople');
        $this->load->view('template.html',$data);
    }
	//为民服务  编辑邻水帮帮团
    function edithelpgroup(){
        $data['page'] = $this->view_edithelpgroup;
        $data['menu'] = array('localLife','serveForPeople');
        $this->load->view('template.html',$data);
    }


}







