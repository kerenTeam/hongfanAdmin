    <?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*  充值缴费
*/
require_once(APPPATH.'controllers/Default_Controller.php');

class Payment extends Default_Controller
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
         $this->load->model('Payment_model');  
	}

	//充值缴费 主页
    function payment(){
        $BeginDate=date('Y-m-01', strtotime(date("Y-m-d")));
      
         $end = date('Y-m-d', strtotime("$BeginDate +1 month -1 day"));
        $list = $this->Payment_model->get_qianmi_money($BeginDate,$end);
        echo "<pre>";
        var_dump($list);

        exit;
        $data['page'] = $this->view_payment;
        $data['menu'] = array('localLife','payment');
        $this->load->view('template.html',$data);
    }

	//充值缴费  水费
    function waterRate(){
        $data['page'] = $this->view_waterRate;
        $data['menu'] = array('localLife','payment');
        $this->load->view('template.html',$data);
    }

    //充值缴费  电费
    function energyCharge(){
        $data['page'] = $this->view_energyCharge;
        $data['menu'] = array('localLife','payment');
        $this->load->view('template.html',$data);
    }

    //充值缴费 气费
    function casFee(){
        $data['page'] = $this->view_casFee;
        $data['menu'] = array('localLife','payment');
        $this->load->view('template.html',$data);
    }
    //充值缴费 固话充值
    function phoneCharge(){
        $data['page'] = $this->view_phoneCharge;
        $data['menu'] = array('localLife','payment');
        $this->load->view('template.html',$data);
    }
    //充值缴费 飞机票
   function planeTicket(){
        $data['page'] = $this->view_planeTicket;
        $data['menu'] = array('localLife','payment');
        $this->load->view('template.html',$data);
    }
    //充值缴费 火车票
    function trainTicket(){
        $data['page'] = $this->view_trainTicket;
        $data['menu'] = array('localLife','payment');
        $this->load->view('template.html',$data);
    }



}
