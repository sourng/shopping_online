<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index_one extends CI_Controller {
	function __construct() {
        parent::__construct();        
        $this->load->helper('text');
        $this->load->database();   
        $this->load->helper('url');
        $this->load->model('M_Categories','m_cat');
       
    }
	public function index()
	{		
		$data=array();
		$data['title']="Trade Title";
		$data['head']="head/v_head_home";
		$data['footer']="footer/v_footer_home";

        $data['body']='index_one/v_home_one';
		$this->load->view('v_template', $data);
		
	}
	
	
}
