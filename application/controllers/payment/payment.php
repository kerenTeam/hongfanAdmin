    <?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*  充值缴费
*/
require_once(APPPATH.'controllers/default_Controller.php');

class payment extends default_Controller
{
	public $view_payment = 'module/payment/payment.html';	
	public $view_waterRate = 'module/payment/waterRate.html';
	public $view_energyCharge = 'module/payment/energyCharge.html';
	public $view_casFee = 'module/payment/casFee.html';
	public $view_phoneCharge = 'module/payment/phoneCharge.html';
	public $view_planeTicket = 'module/payment/planeTicket.html';
	public $view_trainTicket = 'module/payment/trainTicket.html';
	function __construct()
	{
		 parent::__construct();
         $this->load->model('service_model');  
	}

	//充值缴费 主页
    function payment(){
        $data['page'] = $this->view_payment;
        $data['menu'] = array('localLife','payment');
        $this->load->view('template.html',$data);
    }

	//充值缴费  水费
    function waterRate(){
        $data['page'] = $this->view_waterRate;
        $data['menu'] = array('localLife','waterRate');
        $this->load->view('template.html',$data);
    }

    //充值缴费  电费
    function energyCharge(){
        $data['page'] = $this->view_energyCharge;
        $data['menu'] = array('localLife','energyCharge');
        $this->load->view('template.html',$data);
    }

    //充值缴费 气费
    function casFee(){
        $data['page'] = $this->view_casFee;
        $data['menu'] = array('localLife','casFee');
        $this->load->view('template.html',$data);
    }
    //充值缴费 固话充值
    function phoneCharge(){
        $data['page'] = $this->view_phoneCharge;
        $data['menu'] = array('localLife','phoneCharge');
        $this->load->view('template.html',$data);
    }
    //充值缴费 飞机票
   function planeTicket(){
        $data['page'] = $this->view_planeTicket;
        $data['menu'] = array('localLife','planeTicket');
        $this->load->view('template.html',$data);
    }
    //充值缴费 火车票
    function trainTicket(){
        $data['page'] = $this->view_trainTicket;
        $data['menu'] = array('localLife','trainTicket');
        $this->load->view('template.html',$data);
    }



}
