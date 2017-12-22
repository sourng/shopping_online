<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ads extends CI_Controller {
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
		

		$data['title']="Trade Title";

		$data['head']="head/v_head_home";
		$data['footer']="footer/v_footer_home";

        $data['body']='fronts/ads_post/v_add_post';
		$this->load->view('v_template', $data);
		
	}
	
	public function details($pro_id=''){	
	$data=array();
		$sql="SELECT * FROM categories";
		$data['categories']=$this->m_cat->get_by_sql($sql,FALSE);
		
		//$sql_product="SELECT * FROM products WHERE product_id=".$pro_id;
		//$data['getItem']=$this->m_cat->get_by_sql($sql_product,FALSE);
		
		
		$data['title']="Trade Title";

		$data['head']="head/v_head_detail";
		$data['footer']="footer/v_footer_detail";

        $data['body']='fronts/ads_post/v_ad-post-details';
		$this->load->view('v_template', $data);
			
	}	

}
