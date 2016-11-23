<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->helper('map_helper');
    }



    /**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
        $key = 'e8270d657f9a8f1569f7dd806748f7b5';
        $a="成达大厦(西门)";
        $location1 = GetLatitude($a,$key);
        echo $a."的经纬度为：".$location1['location'];
        echo "<br/>";

        $b="美年广场";
        $location2 = GetLatitude($b,$key);
        echo $b."的经纬度为：".$location2['location'];
        echo "<br/>";
//echo $location2['citycode'];

//$d=GetRealgeo($location2['location'],$key);


        $c=GetRouting($location1['location'],$location2['location'],$key,1);
//echo "<br/>";
//        echo $a."与".$b."的步行距离为：".$c['distance']."米";
//        echo "<br/>";
//        echo "步行需要时间：".$c['duration']."秒";

echo "<pre>";
print_r($c);
		//$this->load->view('welcome_message');
	}


	function asd(){

        $this->load->view('welcome_message.html');
    }
}
