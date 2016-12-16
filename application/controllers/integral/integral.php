<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*  积分商城
*/
require_once(APPPATH.'controllers/default_Controller.php');

class integral extends default_Controller
{
    public $view_integralList = 'integral/integralGoodList.html';
    public $view_integralAddGoods = 'integral/integralGoodAdd.html';
    public $view_integralEditGoods = 'integral/integralGoodEdit.html';
    //dingdan 
    public $view_integralOrderList = 'integral/integralOrderList.html';
    public $view_integralOrderModify = 'integral/integralOrderModify.html';
    public $view_integralOrderDetail = 'integral/integralOrderDetail.html';
    
    function __construct()
    {   
        parent::__construct();
        $this->load->model('integral_model');

    }
    //商品列表
    function integralList(){
        $data['page'] = $this->view_integralList;
        $data['menu'] = array('integral','integralList');
        $this->load->view('template.html',$data);
    }
    //返回积分商品列表
    function store_goods_list(){
        if($_POST){
           $arr = $this->integral_model->get_goods_list();
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
            if($this->integral_model->edit_goods_state($goods_id,$data)){
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
            if($this->integral_model->del_goods($id)){
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
        $data['cates'] = $this->integral_model->get_goods_cates();

        $data['page'] = $this->view_integralAddGoods;
        $data['menu'] = array('integral','integralList');
        $this->load->view('template.html',$data);
    }

     function add_goods(){
        if($_POST){
            $data= $this->input->post();
            $pic = array();
            $i =1;
            foreach($_FILES as $file=>$val){
                if(!empty($_FILES['img'.$i]['name'])){
                    $config['upload_path']      = 'upload/goods/';
                    $config['allowed_types']    = 'gif|jpg|png|jpeg';
                    $config['max_size']     = 2048;
                    $config['file_name'] = date('Y-m-d_His');
                    $this->load->library('upload', $config);
                    // 上传
                    if(!$this->upload->do_upload('img'.$i)) {
                         echo "<script>alert('图片上传失败！');window.location.href='".site_url('/integral/integral/integralAddGoods')."'</script>";exit;
                    }else{
                        if($i == '1'){
                            $data['thumb'] = 'upload/goods/'.$this->upload->data('file_name');
                        }
                        $pic[]['bannerPic'] = 'upload/goods/'.$this->upload->data('file_name');
                        }
                }
                $i++;
             }
             $data['good_pic'] = json_encode($pic);
             $data['differentiate'] = '2';
             if($this->integral_model->add_shop_goods($data)){
                echo "<script>alert('操作成功！');window.location.href='".site_url('/integral/integral/integralList')."'</script>";exit;
             }else{
                echo "<script>alert('操作失败！');window.location.href='".site_url('/integral/integral/integralAddGoods')."'</script>";exit;
             }
        }else{
            $this->load->view('404.html');
        }
    }
    //商品搜索
    function search_goods(){
        if($_POST){
            $cate = $_POST['cateid'];
            $storeid = $this->session->businessId;
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
            $res = search_store_goods($storeid,$cate,$startPrice,$endPrice,$startRepertory,$endRepertory,$state,$sear);
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
        $data['page'] = $this->view_integralEditGoods;
        $data['menu'] = array('integral','integralList');
        $this->load->view('template.html',$data);
    }
     //商品详情
    function goodsDetail(){
        $id = intval($this->uri->segment(4));
        if($id == 0){
            $this->load->view('404.html');
        }else{
            $data['goods'] = $this->mallShop_model->get_goodsInfo($id);
            //所有商品分类
            $data['cates'] = $this->mallShop_model->get_goods_cates();
            $data['page'] = $this->view_goodsDetail;
            $data['menu'] = array('shop','goodsList');       
            $this->load->view('template.html',$data);
        }
    }
    //订单管理
    function integralOrderList(){
        $data['page'] = $this->view_integralOrderList;
        $data['menu'] = array('integral','integralOrderList');
        $this->load->view('template.html',$data);
    }
    //编辑订单
    function integralOrderDetail(){
        $data['page'] = $this->view_integralOrderDetail;
        $data['menu'] = array('integral','integralOrderList');
        $this->load->view('template.html',$data);
    }
    //编辑订单
    function integralOrderModify(){
        $data['page'] = $this->view_integralOrderModify;
        $data['menu'] = array('integral','integralOrderList');
        $this->load->view('template.html',$data);
    }


}






 ?>