<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {
	function __construct() {
        parent::__construct();        
        $this->load->helper('text');
        $this->load->database();   
        $this->load->helper('url');
       
       
    }
	public function index()
	{				
		$this->load->view('register/v_signup');
		
	}
	

}
