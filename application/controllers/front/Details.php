<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Details extends CI_Controller {
	function __construct() {
        parent::__construct();        
        // $this->load->helper('text');
        $this->load->database();   
        // $this->load->helper('url');
        $this->load->model('M_Categories','m_cat');
        $this->load->model('Crud_model','m_crud');
       
    }
	public function index($cat_id='',$pro_id='')
	{		
		$data=array();
		$data['lang']=$this->session->userdata('site_lang');
		$sql="SELECT * FROM categories";
		$data['categories']=$this->m_cat->get_by_sql($sql,FALSE);
		
		$sql_product="SELECT * FROM products WHERE product_id=".$pro_id;
		$data['getItem']=$this->m_cat->get_by_sql($sql_product,FALSE);

		// $sql_product_gall="SELECT * FROM product_gallery as pg INNER JOIN products as p ON pg.product_id=p.product_id WHERE pg.product_id=4";
		$data['galleries']=$this->m_crud->get_by_sql("SELECT * FROM product_gallery",'trace');

		
		

		// Recommended Ads for You

		$sql_productRecommended="SELECT * FROM products WHERE product_id<>".$pro_id;
		$data['getRecommendedAds']=$this->m_cat->get_by_sql($sql_productRecommended,FALSE);

		
		
		$data['title']="Trade Title";
		$data['head']="head/v_head_home";
		$data['footer']="footer/v_footer_home";
        $data['body']='fronts/home/v_detail';

        //Language file
        include_once 'langs.php';        

		$this->load->view('v_template', $data);
		
	}
	
	

}
