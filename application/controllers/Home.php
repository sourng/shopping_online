<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
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
		$sql="SELECT * FROM categories";
		$data['categories']=$this->m_cat->get_by_sql($sql,FALSE);
		
		$sql_product="SELECT p.*,c.cat_name FROM products as p INNER JOIN categories as c ON p.cat_id=c.cat_id;";
		$data['getProducts']=$this->m_cat->get_by_sql($sql_product,FALSE);
		
		
                $data['main_content']='layouts/template';
		$this->load->view('layouts/v_home', $data);
		
	}
	
	public function details($pro_id){	
	$data=array();
		$sql="SELECT * FROM categories";
		$data['categories']=$this->m_cat->get_by_sql($sql,FALSE);
		
		$sql_product="SELECT * FROM products WHERE product_id=".$pro_id;
		$data['getItem']=$this->m_cat->get_by_sql($sql_product,FALSE);
		
		
		//$data['main_content']='layouts/template';
		//$this->load->view('layouts/v_home', $data);
		$this->load->view('v_details',$data);	
			
	}	

}
