<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
	function __construct() {
        parent::__construct();        
        $this->load->helper('text');
        $this->load->database();   
        $this->load->helper('url');
        $this->load->model('M_Categories','m_cat');
        	$this->load->model('Crud_model','m_crud',True); 
       date_default_timezone_set('Asia/Phnom_Penh');

       
    }
	
	public function index($page='home'){	
	$data=array();
		//$sql="SELECT * FROM categories";
		//$data['categories']=$this->m_cat->get_by_sql($sql,FALSE);
		
		// $sql_product="SELECT * FROM products WHERE product_id=".$pro_id;
		// $data['getItem']=$this->m_cat->get_by_sql($sql_product,FALSE);
		
		$sql_getprofile="SELECT * FROM company WHERE company_id=3";
		$data['getprofile']=$this->m_cat->get_by_sql($sql_getprofile,FALSE);
		$sql_getprovince="SELECT * FROM province";
		$data['getprovince']=$this->m_cat->get_by_sql($sql_getprovince,FALSE);
		include_once 'langs.php';

		$data['title']="Trade Title";

		$data['head']="head/v_head_home";
		$data['footer']="footer/v_footer_home";

        $data['body']='fronts/profile/v_my_profile';
		$this->load->view('v_template', $data);
			
	}
	public function my_ads($page='home'){	
	$data=array();
		include_once 'langs.php';
		$data['title']="Trade Title";

		$data['head']="head/v_head_home";
		$data['footer']="footer/v_footer_home";

        $data['body']='fronts/profile/v_my_ads';
		$this->load->view('v_template', $data);
	}

	public function favourite_ads($page='home'){	
	$data=array();
		include_once 'langs.php';
				
		$data['title']="Trade Title";

		$data['head']="head/v_head_home";
		$data['footer']="footer/v_footer_home";

        $data['body']='fronts/profile/v_favourite_ads';
		$this->load->view('v_template', $data);
	}

	public function archived_ads($page='home'){	
	$data=array();
		include_once 'langs.php';		
		$data['title']="Trade Title";

		$data['head']="head/v_head_home";
		$data['footer']="footer/v_footer_home";

        $data['body']='fronts/profile/v_archived_ads';
		$this->load->view('v_template', $data);
	}

	public function pending_ads($page='home'){	
	$data=array();
		include_once 'langs.php';		
		$data['title']="Trade Title";

		$data['head']="head/v_head_home";
		$data['footer']="footer/v_footer_home";

        $data['body']='fronts/profile/v_pending_ads';
		$this->load->view('v_template', $data);
	}

	public function delete_account($page='home'){	
	$data=array();
		include_once 'langs.php';		
		$data['title']="Trade Title";

		$data['head']="head/v_head_home";
		$data['footer']="footer/v_footer_home";

        $data['body']='fronts/profile/v_delete_account';
		$this->load->view('v_template', $data);
	}



}
