<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  本地生活
 *
 * */

class localLife extends CI_Controller {

    function __construct()
    {
        parent::__construct();

    }

    //本地生活 列表主页
    function localLifeList()
    {
         $this->load->view('localLife/localLifeList.html');
    }
    



}
