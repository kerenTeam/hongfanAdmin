<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  一键钟情
 *
 * */
require_once(APPPATH.'controllers/Default_Controller.php');
class Fallinlove extends Default_Controller {
    //一键钟情 活动列表
    public $view_loveactivityList = "module/fallinlove/loveactivityList.html";
    //本地服务 编辑活动详情
    public $view_loveEditactivity = "module/fallinlove/loveEditactivity.html";
    //本地服务 新增活动
    public $view_loveAddactivity = "module/fallinlove/loveAddactivity.html";

	//本地服务 报名情况列表
    public $view_loveApplyList = "module/fallinlove/loveApplyList.html";
    //一键钟情 活动列表
    function loveactivityList()
    {
        $data['page'] = $this->view_loveactivityList;
        $data['menu'] = array('fallinlove','loveactivityList');
        $this->load->view('template.html',$data);
    }
    //一键钟情 编辑活动详情
    function loveEditactivity()
    {
        $data['page'] = $this->view_loveEditactivity;
        $data['menu'] = array('fallinlove','loveEditactivity');
        $this->load->view('template.html',$data);
    }
    //一键钟情 新增活动
    function loveAddactivity()
    {
        $data['page'] = $this->view_loveAddactivity;
        $data['menu'] = array('fallinlove','loveAddactivity');
        $this->load->view('template.html',$data);
    }
    //一键钟情 报名情况列表
    function loveApplyList()
    {
        $data['page'] = $this->view_loveApplyList;
        $data['menu'] = array('fallinlove','loveApplyList');
        $this->load->view('template.html',$data);
    }

}
