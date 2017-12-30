<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Homethree extends CI_Controller {
	function __construct() {
        parent::__construct();        
        $this->load->helper('text'); 
        $this->load->helper('url');
       
    }
	public function index(){
        $data=array();
        $data['title']="Trade Title";
        $data['head']="head/v_head_home";
        $data['body']='index_three/home_three';

        $data['footer']="footer/v_footer_home";        

		$this->load->view('v_template', $data);
	}
	

}
