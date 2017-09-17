    <?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*  充值缴费
*/
require_once(APPPATH.'controllers/Default_Controller.php');

class Payment extends Default_Controller
{
	public $view_payment = 'module/payment/recharge_settings.html';	
	public $view_energyCharge = 'module/payment/energyCharge.html';
	function __construct()
	{
		 parent::__construct();
         $this->load->model('Payment_model');  
	}

    //充值设置
    function recharge(){
        //获取充值设置
        $data['lists'] = $this->Payment_model->ret_recharge();
        $data['page'] = $this->view_payment;
        $data['menu'] = array('payment','recharge');
        $this->load->view('template.html',$data);
    }
    //新增手机设置
    function add_recharge(){
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
            $data['createUserid'] = $_SESSION['users']['user_id'];
            if($this->Payment_model->add_recharge($data)){
                 //日志    
                 $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."新增了话费\流量套餐，套餐额度是：".$data['name'],
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                echo "<script>alert('操作成功！');window.location.href='".site_url('/payment/Payment/recharge')."'</script>";exit;

            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/payment/Payment/recharge')."'</script>";exit;

            }

        }
    }

    //编辑充值设置
    function edit_recharge(){
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
            $data['createUserid'] = $_SESSION['users']['user_id'];
            if($this->Payment_model->edit_recharge($data['id'],$data)){
                 //日志    
                 $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."编辑了话费\流量套餐，套餐额度是：".$data['name'],
                    "create_time" => date('Y-m-d H:i:s'),

                    "userip" => get_client_ip(),

                );
                echo "<script>alert('操作成功！');window.location.href='".site_url('/payment/Payment/recharge')."'</script>";exit;

            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/payment/Payment/recharge')."'</script>";exit;

            }
        }else{
            $this->load->view('404.html');
        }
    }

    //删除套餐
    function del_recharge(){
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
        $id = intval($this->uri->segment('4'));
       // var_Dump($id);
        if($id == '0'){
            $this->load->view('404.html');
        }else{
            if($this->Payment_model->del_recharge($id)){
                $log = array(
                    'userid'=>$_SESSION['users']['user_id'],  

                    "content" => $_SESSION['users']['username']."删除了话费\流量套餐，套餐id是：".$id,
                    "create_time" => date('Y-m-d H:i:s'),
                    "userip" => get_client_ip(),
                );
                echo "<script>alert('操作成功！');window.location.href='".site_url('/payment/Payment/recharge')."'</script>";exit;

            }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/payment/Payment/recharge')."'</script>";exit;
            }
        }


    }




    //手机充值记录
    function energyCharge(){
        $data['page'] = $this->view_energyCharge;
        $data['menu'] = array('payment','energyCharge');
        $this->load->view('template.html',$data);
    }

    //返回充值记录
    function qianmi_order_list(){
        if($_POST){
            $type = $this->input->post('type');
            $list = $this->Payment_model->get_qianmi_order($type);
            if(!empty($list)){
                echo json_encode($list);
            }else{
                echo "2";
            }

        }else{
            echo "2";
        }

    }




}
 