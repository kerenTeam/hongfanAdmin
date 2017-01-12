<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  商城管理
 *
 * */
require_once(APPPATH.'controllers/Default_Controller.php');

class Native extends Default_Controller {

    function __construct()
    {
         parent::__construct();
    }

    //
    function native_index(){

        echo "23456";
    }

    //
    function native_order(){
        echo "2";
    }

}
?>