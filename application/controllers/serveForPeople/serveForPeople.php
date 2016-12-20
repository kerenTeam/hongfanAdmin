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
        $data['menu'] = array('serveForPeople','serveForPeople');
        $this->load->view('template.html',$data);
    }
    //

	//为民服务  邻水帮帮团成员列表
    function helpgrouplist(){
        $data['page'] = $this->view_helpgrouplist;
        $data['menu'] = array('serveForPeople','helpgrouplist');
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
        $data['menu'] = array('serveForPeople','helpgroupservelist');
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
        $data['menu'] = array('serveForPeople','addhelpgroup');
        $this->load->view('template.html',$data);
    }
	//为民服务  编辑邻水帮帮团
    function edithelpgroup(){
        $data['page'] = $this->view_edithelpgroup;
        $data['menu'] = array('serveForPeople','edithelpgroup');
        $this->load->view('template.html',$data);
    }


}







