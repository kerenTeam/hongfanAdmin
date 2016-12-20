  <?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
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
	}

	//为民服务 为民服务主页
    function serveForPeople(){
        $data['page'] = $this->view_serveForPeople;
        $data['menu'] = array('serveForPeople','serveForPeople');
        $this->load->view('template.html',$data);
    }

	//为民服务  邻水帮帮团成员列表
    function helpgrouplist(){
        $data['page'] = $this->view_helpgrouplist;
        $data['menu'] = array('serveForPeople','helpgrouplist');
        $this->load->view('template.html',$data);
    }

    //为民服务  邻水帮帮团服务列表
    function helpgroupservelist(){
        $data['page'] = $this->view_helpgroupservelist;
        $data['menu'] = array('serveForPeople','helpgroupservelist');
        $this->load->view('template.html',$data);
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







