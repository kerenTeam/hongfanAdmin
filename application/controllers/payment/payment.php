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

        $data['page'] = $this->view_payment;
        $data['menu'] = array('localLife','payment');
        $this->load->view('template.html',$data);
    }

	//充值缴费  生活缴费
    function waterRate(){

        $Utilities = $this->Payment_model->get_qianmi_order('2');
        $data['page'] = $this->view_waterRate;
        $data['menu'] = array('payment','waterRate');
        $this->load->view('template.html',$data);
    }

    //手机充值
    function energyCharge(){
        $data['page'] = $this->view_energyCharge;
        $data['menu'] = array('payment','energyCharge');
        $this->load->view('template.html',$data);
    }

    //充值缴费 飞机票
    function phoneCharge(){
        $data['page'] = $this->view_phoneCharge;
        $data['menu'] = array('payment','phoneCharge');
        $this->load->view('template.html',$data);
    }

    //充值缴费 火车票
    function trainTicket(){
        $data['page'] = $this->view_trainTicket;
        $data['menu'] = array('payment','trainTicket');
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
                    $log = array(
                        'userid'=>$_SESSION['users']['user_id'],  
                        "content" => $_SESSION['users']['username']."删除了一个千米订单，订单id是".$id,
                        "create_time" => date('Y-m-d H:i:s'),
                        "userip" => get_client_ip(),
                    );
                    $this->db->insert('hf_system_journal',$log);
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
