<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  家乡报道
 *
 * */
require_once(APPPATH.'controllers/Default_Controller.php');
class HomeReport extends Default_Controller {
    //本地生活 家乡报道
    public $view_homeReport = "module/homeReport/homeReport.html";
    //本地生活 家乡报道
    function index()
    {
        $data['page'] = $this->view_homeReport;
        $data['menu'] = array('localLife','homeReport');
        $this->load->view('template.html',$data);
    }

}
