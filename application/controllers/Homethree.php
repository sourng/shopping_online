<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Homethree extends CI_Controller {
	function __construct() {
        parent::__construct();        
             
        $this->load->helper('text');
        $this->load->database();   
        //$this->load->helper('url');
        $this->load->model('M_Categories','m_cat');
        $this->load->model('Crud_model','m_crud');
       
       
       
    }
	public function index(){
        $data=array();
        $sql="SELECT * FROM categories";
		$data['categories']=$this->m_cat->get_by_sql($sql,FALSE);
		
		$sql_product="SELECT p.*,c.cat_name FROM products as p INNER JOIN categories as c ON p.cat_id=c.cat_id;";
        $data['getProducts']=$this->m_cat->get_by_sql($sql_product,FALSE);
        
        $data['title']="Trade Title";
        $data['head']="head/v_head_home";
        $data['body']='index_three/home_three';

        $data['footer']="footer/v_footer_home";  
        include_once 'front/langs.php';      

		$this->load->view('v_template', $data);
	}
	

}
