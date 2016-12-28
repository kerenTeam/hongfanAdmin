<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  电子券管理
 *
 * */
require_once(APPPATH.'controllers/Default_Controller.php');
class Electronic extends Default_Controller {
    //电子劵列表
    public $view_electronicList = "electronic/electronicList.html"; 
    //电子劵新增
    public $view_addElectronic = "electronic/addElectronic.html";
    //电子卷编辑
    public $view_editElectronic = "electronic/editElectronic.html";
    function __construct()
    {
        parent::__construct();
    }
    //electronic列表
    function electronicList(){

    	 
         $data['page']= $this->view_electronicList;
         $data['menu'] = array('electronic','electronicList');
         $this->load->view('template.html',$data);

    }
    //新增electronic
    function addElectronic(){
       $data['page']= $this->view_addElectronic;
         $data['menu'] = array('electronic','electronicList');
         $this->load->view('template.html',$data);
    }
    //编辑electronic
    function editElectronic(){
        $data['page']= $this->view_editElectronic;
         $data['menu'] = array('electronic','electronicList');
         $this->load->view('template.html',$data);
    }
}

