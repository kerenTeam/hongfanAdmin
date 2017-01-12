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
        //月开始
        $BeginDate=date('Y-m-01', strtotime(date("Y-m-d")));
        //月结束
        $end = date('Y-m-d', strtotime("$BeginDate +1 month -1 day"));
        // echo "<pre>";
        //1手机充值 这个月订单
        $phone_money = '0';
        $phone = $this->Payment_model->get_qianmi_money($BeginDate,$end,'1');
        foreach ($phone as $key => $value) {
            $phone_order = json_decode($value['data'],true);
            // var_dump($phone_order);
            $phone_money += $phone_order['data']['orderCost'];
        }
        //2水电煤

        $Utilities = $this->Payment_model->get_qianmi_money($BeginDate,$end,'2');
        foreach ($Utilities as $key => $value) {
            $Utilities_order = json_decode($value['data'],true);
        }
        
        //3火车票
        $train_money = '0';
        $train  = $this->Payment_model->get_qianmi_money($BeginDate,$end,'3');
        foreach ($train as $key => $value) {
            $train_order = json_decode($value['data'],true);
            // var_dump($train_order);
        }
        // exit;
        //4飞机票
        $aircraft = $this->Payment_model->get_qianmi_money($BeginDate,$end,'4');
        // echo "<pre>";
        // var_dump($phone);


        // exit;
        $data['page'] = $this->view_payment;
        $data['menu'] = array('localLife','payment');
        $this->load->view('template.html',$data);
    }

	//充值缴费  水费
    function waterRate(){

        $Utilities = $this->Payment_model->get_qianmi_order('2');
        $data['page'] = $this->view_waterRate;
        $data['menu'] = array('localLife','payment');
        $this->load->view('template.html',$data);
    }

    //返回 水费

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

    //返回飞机票购买订单列表
    function qianmi_order_list(){
        if($_POST){
            $type = $_POST['type'];
            $list = $this->Payment_model->get_qianmi_order($type);
            if(empty($list)){
                echo "2";
            }else{
                echo json_encode($list);
            }
        }else{
            echo "2";
        }
    }

    //删除千米订单
    function del_qianmi_order(){
        if($_POST){
            $id = $_POST['id'];
            if(empty($id)){
                echo "2";
            }else{
                if($this->Payment_model->del_qianmi_order($id)){
                    echo "1";
                }else{
                    echo "2";
                }
            }
        }else{
            echo "2";
        }
    }


}
