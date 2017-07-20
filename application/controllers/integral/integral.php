<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*  积分商城
*/
require_once(APPPATH.'controllers/Default_Controller.php');

class Integral extends Default_Controller
{
    public $view_integralList = 'integral/integralGoodList.html';
    public $view_integralAddGoods = 'integral/integralGoodAdd.html';
    public $view_integralEditGoods = 'integral/integralGoodEdit.html';
    //dingdan 
    public $view_integralOrderList = 'integral/integralOrderList.html';
    public $view_integralOrderModify = 'integral/integralOrderModify.html';
    public $view_integralOrderDetail = 'integral/integralOrderDetail.html';
    public $view_integralRule = 'integral/integralRule.html';
    function __construct()
    {   
        parent::__construct();
        $this->load->model('Integral_model');
    }
    //积分列表
    function integralList(){
        $data['cates'] = $this->Integral_model->get_goods_cates('1');
        $data['page'] = $this->view_integralList;
        $data['menu'] = array('member','integralList');
        $this->load->view('template.html',$data);
    }
    //返回积分商品列表
    function store_goods_list(){
        if($_POST){
           $arr = $this->Integral_model->get_goods_list();
           if(empty($arr)){
                echo "2";
           }else{
                echo json_encode($arr);
           }
        }else{
            echo "2";
        }
    }
    //修改商品状态
     function edit_goods_state(){
         if($_POST){
            $data['goods_state'] = $_POST['state'];
            $goods_id = $_POST['goodsid'];

             //日志
            $log = array(
                'userid'=>$_SESSION['users']['user_id'],  
                "content" => $_SESSION['users']['username']."修改了积分商品的状态。商品id是".$goods_id,
                "create_time" => date('Y-m-d H:i:s'),
                "userip" => get_client_ip(),
            );
            $this->db->insert('hf_system_journal',$log);


            if($this->Integral_model->edit_goods_state($goods_id,$data)){
                echo "1";
            }else{
                echo "2";
            }
         }else{
            echo "2";
         }
    }
    //删除商品
    function del_goods(){
        if($_POST){
            $id = $_POST['goodsid'];

             //日志
            $log = array(
                'userid'=>$_SESSION['users']['user_id'],  
                "content" => $_SESSION['users']['username']."删除了积分商品。商品id是".$id,
                "create_time" => date('Y-m-d H:i:s'),
                "userip" => get_client_ip(),
            );
            $this->db->insert('hf_system_journal',$log);


            if($this->Integral_model->del_goods($id)){
                echo "1";
            }else{
                echo "2";
            }
        }else{
            echo "2";
        }
    }
    //新增商品
    function integralAddGoods(){
          //所有商品分类
        $data['cates'] = $this->Integral_model->get_goods_cates('1');

        $data['page'] = $this->view_integralAddGoods;
        $data['menu'] = array('member','integralList');
        $this->load->view('template.html',$data);
    }

     function add_goods(){
        if($_POST){
            $data= $this->input->post();
            $pic = array();
            $i =1;
            foreach($_FILES as $file=>$val){
                if(!empty($_FILES['img'.$i]['name'])){
                    $config['upload_path']      = 'Upload/goods/';
                    $config['allowed_types']    = 'gif|jpg|png|jpeg';
                    $config['max_size']     = 2048;
                    $config['file_name'] = date('Y-m-d_His');
                    $this->load->library('upload', $config);
                    // 上传
                    if(!$this->upload->do_upload('img'.$i)) {
                         echo "<script>alert('图片上传失败！');window.location.href='".site_url('/integral/Integral/integralAddGoods')."'</script>";exit;
                    }else{
                        if($i == '1'){
                            $data['thumb'] = 'Upload/goods/'.$this->upload->data('file_name');
                        }
                        $pic[]['bannerPic'] = 'Upload/goods/'.$this->upload->data('file_name');
                        }
                }
                $i++;
             }
               //日志
            $log = array(
                'userid'=>$_SESSION['users']['user_id'],  
                "content" => $_SESSION['users']['username']."新增了积分商品。商品名称是".$data['title'],
                "create_time" => date('Y-m-d H:i:s'),
                "userip" => get_client_ip(),
            );
            $this->db->insert('hf_system_journal',$log);



             $data['good_pic'] = json_encode($pic);
             $data['differentiate'] = '2';
             if($this->Integral_model->add_shop_goods($data)){
                echo "<script>alert('操作成功！');window.location.href='".site_url('/integral/Integral/integralList')."'</script>";exit;
             }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/integral/Integral/integralAddGoods')."'</script>";exit;
             }
        }else{
            $this->load->view('404.html');
        }
    }
    //商品搜索
    function search_goods(){
        if($_POST){
            $cate = $_POST['cateid'];
            $storeid = '';
           // echo $storeid;
            //单价起价格
            $startPrice = $_POST['startPrice'];
            //单价结束价格
            $endPrice = $_POST['endPrice'];
            //kucun
            $startRepertory = $_POST['startRepertory'];
            $endRepertory = $_POST['endRepertory'];
            //商品状态
            $state = $_POST['state']; 
            //关键字
            $sear = $_POST['sear'];
            $differentiate = '2';
            $res = search_store_goods($storeid,$cate,$startPrice,$endPrice,$startRepertory,$endRepertory,$state,$sear,$differentiate);
            if(empty($res)){
                echo '2';
            }else{
                echo json_encode($res);
            }
        }else{
            echo "2";
        }
    }

    //编辑商品
    function integralEditGoods(){
        $id = intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
            $data['goods'] = $this->Integral_model->get_goodsInfo($id);
            //所有商品分类
            $data['cates'] = $this->Integral_model->get_goods_cates('1');
            $data['page'] = $this->view_integralEditGoods;
            $data['menu'] = array('member','integralList');
            $this->load->view('template.html',$data);
        }
    }
    //商品编辑操作
    function edit_goods(){
        if($_POST){
            $data = $this->input->post();
            $pic = array();
            $i =1;
            foreach($_FILES as $file=>$val){
                if(!empty($_FILES['img'.$i]['name'])){
                    $config['upload_path']      = 'Upload/goods/';
                    $config['allowed_types']    = 'gif|jpg|png|jpeg';
                    $config['max_size']     = 2048;
                    $config['file_name'] = date('Y-m-d_His');
                    $this->load->library('upload', $config);
                    // 上传
                    if(!$this->upload->do_upload('img'.$i)) {
                        echo "<script>alert('图片上传失败！');window.location.href='".site_url('/integral/Integral/integralEditGoods/'.$data['id'])."'</script>";exit;
                    }else{
                        if($i == '1'){
                            $data['thumb'] = 'Upload/goods/'.$this->upload->data('file_name');
                        }
                        $pic[]['bannerPic'] = 'Upload/goods/'.$this->upload->data('file_name');
                        unset($data['img'.$i]);
                    }
                }else{
                    if(isset($data['img'.$i])){
                         if($i == '1'){
                                $data['thumb'] = $data['img'.$i];
                         }
                         $pic[]['bannerPic'] = $data['img'.$i];
                         unset($data['img'.$i]);
                     }
                }
                $i++;
             }

            //日志
            $log = array(
                'userid'=>$_SESSION['users']['user_id'],  
                "content" => $_SESSION['users']['username']."编辑了积分商品。商品id是".$data['goods_id'],
                "create_time" => date('Y-m-d H:i:s'),
                "userip" => get_client_ip(),
            );
            $this->db->insert('hf_system_journal',$log);


             $data['good_pic'] = json_encode($pic);
             if($this->Integral_model->edit_goods($data['goods_id'],$data)){
                 echo "<script>alert('操作成功！');window.location.href='".site_url('/integral/Integral/integralList')."'</script>";exit;
             }else{
                 echo "<script>alert('操作失败！');window.location.href='".site_url('/integral/Integral/integralEditGoods/'.$data['id'])."'</script>";exit;
             }
        }else{
            $this->load->view('404.html');
        }
    }
  
    //订单管理
    function integralOrderList(){
        $data['page'] = $this->view_integralOrderList;
        $data['menu'] = array('member','integralOrderList');
        $this->load->view('template.html',$data);
    }
    //编辑订单
    function integralOrderDetail(){
        $data['page'] = $this->view_integralOrderDetail;
        $data['menu'] = array('member','integralOrderList');
        $this->load->view('template.html',$data);
    }
    //编辑订单
    function integralOrderModify(){
        $data['page'] = $this->view_integralOrderModify;
        $data['menu'] = array('member','integralOrderList');
        $this->load->view('template.html',$data);
    }

    //积分规则
    function integralRule(){
        //获取积分所有规则
        $data['inter'] = $this->Integral_model->get_integral_rule();
        // var_dump($inter);
        // exit;
        $data['page'] = $this->view_integralRule;
        $data['menu'] = array('member','integralRule');
        $this->load->view('template.html',$data);
    }
    //修改积分规则
    function edit_integralrule(){
        if($_POST){
            $id = $_POST['id'];
            $data['integral'] = $_POST['integral'];

            //日志
            $log = array(
                'userid'=>$_SESSION['users']['user_id'],  
                "content" => $_SESSION['users']['username']."修改了积分规则。规则id是".$id,
                "create_time" => date('Y-m-d H:i:s'),
                "userip" => get_client_ip(),
            );
            $this->db->insert('hf_system_journal',$log);


            if($this->Integral_model->edit_integral_rule($id,$data)){
                echo "1";
            }else{
                echo "2";
            }
        }else{
            echo "2";
        }
    }


}






 ?>