<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	function __construct() {
        parent::__construct();        
        $this->load->helper('text');
        $this->load->database();   
        $this->load->helper('url');
        //$this->load->model('M_Categories','m_cat');
         $this->load->model('Crud_model','m_crud');
       
    }
	
	public function index($page='home'){	
		$data=array();
		include_once 'langs.php';

		$this->load->view('login/v_login',$data);	
			
	}	
	

}
?>
