<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  电子券管理
 *
 * */

class electronic extends CI_Controller {

    function __construct()
    {
        parent::__construct();

    }
    //electronic列表
    function index(){

    	 $this->load->view('electronic/electronicList.html');
    }
    //新增electronic
    function addElectronic(){
        $this->load->view('electronic/addElectronic.html');
    }
    //编辑electronic
    function editElectronic(){
        $this->load->view('electronic/editElectronic.html');
    }
   
}

