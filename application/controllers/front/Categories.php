<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CI_Controller {
	function __construct() {
        parent::__construct();        
        $this->load->helper('text');
        $this->load->database();   
        $this->load->helper('url');
        $this->load->model('M_Categories','m_cat');
        $this->load->model('Crud_model','m_crud');
       
    }
	public function index($page='home')
	{		
		$data=array();
		$sql="SELECT * FROM categories";
		$data['categories']=$this->m_cat->get_by_sql($sql,FALSE);
		
		$sql_product="SELECT * FROM products";
		$data['getProducts']=$this->m_cat->get_by_sql($sql_product,FALSE);
		
		$sql_cat_left="SELECT cat.cat_id,cat.cat_name,cat.cat_ico_class,count(cat.cat_name) as number from categories as cat inner join products as p ON cat.cat_id=p.cat_id group by cat.cat_id";
		$data['getCat_Left']=$this->m_cat->get_by_sql($sql_cat_left,FALSE);

		//$data['main_content']='layouts/template';
		//$this->load->view('layouts/v_home', $data);
		include_once 'langs.php';

		$this->load->view('categories/v_categories',$data);
		
	}
	public function find($cat_id)
	{		
		$data=array();
		$sql="SELECT * FROM categories";
		$data['categories']=$this->m_cat->get_by_sql($sql,FALSE);
		
		$sql_product="SELECT * FROM products WHERE cat_id=$cat_id";
		$data['getProducts']=$this->m_cat->get_by_sql($sql_product,FALSE);
		
		$sql_cat_left="SELECT cat.cat_id,cat.cat_name,cat.cat_ico_class,count(cat.cat_name) as number from categories as cat inner join products as p ON cat.cat_id=p.cat_id group by cat.cat_id";
		$data['getCat_Left']=$this->m_cat->get_by_sql($sql_cat_left,FALSE);
		
		//$data['main_content']='layouts/template';
		//$this->load->view('layouts/v_home', $data);
		include_once 'langs.php';

		$this->load->view('categories/v_categories',$data);
		
	}
	
	public function details($pro_id){	
	$data=array();
		$sql="SELECT * FROM categories";
		$data['categories']=$this->m_cat->get_by_sql($sql,FALSE);
		
		$sql_product="SELECT * FROM products WHERE product_id=".$pro_id;
		$data['getItem']=$this->m_cat->get_by_sql($sql_product,FALSE);
		
		
		//$data['main_content']='layouts/template';
		//$this->load->view('layouts/v_home', $data);
		include_once 'langs.php';

		$this->load->view('v_details',$data);	
		//echo "Hello";
			
	}
	public function login(){	
		$this->load->view('login/v_login');	
			
	}	
	

}
