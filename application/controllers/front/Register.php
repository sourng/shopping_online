<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {
	function __construct() {
        parent::__construct();        
        $this->load->helper('text');
        $this->load->database();   
        $this->load->helper('url');
       
       	$this->load->model('Crud_model','m_crud',True); 
      	$this->load->model('M_Upload','welcome'); 
      	date_default_timezone_set('Asia/Phnom_Penh');
       
    }
	public function index($page='home')
	{				
		 $data=array();  

		include_once 'langs.php';
		$this->load->view('register/v_signup',$data);
		
	}
	public function signup(){
		$data=array();  
		$data['name']=$this->input->post['name'];
		$data['email']=$this->input->post['email'];
		$data['pass']=$this->input->post['pass'];
		$data['confirm_pass']=$this->input->post['confirm_pass'];
		$data['phone']=$this->input->post['phone'];

		include_once 'langs.php';

		
		$this->load->view('register/v_signup_result',$data);
	}

	public function name($value='')
	{
		echo "Hello";
	}
	

}
