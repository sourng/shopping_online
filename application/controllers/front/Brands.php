<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Brands extends CI_Controller {
	function __construct() {
        parent::__construct();        
		$this->load->helper('text');
		$this->load->library('pagination');

        $this->load->database();   
        $this->load->helper('url');
        $this->load->model('M_Categories','m_cat');
        $this->load->model('Crud_model','m_crud');
       
    }
	public function index($cat_id=false)
	{		
		$data=array();
		
		$pro="SELECT * FROM province";
		$data['province']=$this->m_cat->get_by_sql($pro,FALSE);

		$sql="SELECT cat.cat_id,cat.cat_name,cat.cat_ico_class,
		count(cat.cat_name) as number from categories as cat inner join products as 
		p ON cat.cat_id=p.cat_id group by cat.cat_id";
		$data['categories']=$this->m_cat->get_by_sql($sql,FALSE);

		if($cat_id==false){
			$sql_product="SELECT * FROM products";
			
		}else{
			$sql_product="SELECT * FROM products WHERE cat_id=$cat_id";
		}
		
		
		$data['getProducts']=$this->m_cat->get_by_sql($sql_product,FALSE);
		
		$sql_cat_left="SELECT cat.cat_id,cat.cat_name,cat.cat_ico_class,
		count(cat.cat_name) as number from categories as cat inner join products as 
		p ON cat.cat_id=p.cat_id group by cat.cat_id";

		$data['getCat_Left']=$this->m_cat->get_by_sql($sql_cat_left,FALSE);
		

		include_once 'langs.php';

		// Pagination Script
		$limit_per_page = 2; //total data show on page
        $page = ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) : 0;
		$total_records = $this->m_crud->get_total('products',false);
     
        if ($total_records > 0)
        {
            // get current page records
            $data["getProducts"] = $this->m_crud->get_current_page_records($limit_per_page, $page*$limit_per_page,false);
                 
			// $config['base_url'] = base_url() . 'categories.html';
			$config['base_url'] = base_url(). 'categories/pages.html';
			$config['total_rows'] = $total_records;
			$config['per_page'] = $limit_per_page;
			$config["uri_segment"] = 3;
			// load config file
			$this->config->load('pagination', TRUE);  
			
			$this->pagination->initialize($config);
			
			// End Pagination Script
                 
            // build paging links
            $params["links"] = $this->pagination->create_links();
        }
     

		$this->load->view('categories/v_categories',$data);
		
	}
	

	public function pages($brand_id=false)
	{		
		$data=array();
		$sql="SELECT cat.cat_id,cat.cat_name,cat.cat_ico_class,
		count(cat.cat_name) as number from categories as cat inner join products as 
		p ON cat.cat_id=p.cat_id group by cat.cat_id";
		$data['categories']=$this->m_cat->get_by_sql($sql,FALSE);
		
		// $sql_product="SELECT * FROM products WHERE cat_id=$cat_id";
		// $data['getProducts']=$this->m_cat->get_by_sql($sql_product,FALSE);
		
		$sql_cat_left="SELECT cat.cat_id,cat.cat_name,cat.cat_ico_class,count(cat.cat_name) as number from categories as cat inner join products as p ON cat.cat_id=p.cat_id group by cat.cat_id";
		$data['getCat_Left']=$this->m_cat->get_by_sql($sql_cat_left,false);
		
	
		include_once 'langs.php';

		// Pagination Script
		$limit_per_page = 2; //total data show on page
        $page = ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) : 0;
        $total_records = $this->m_crud->get_total('products',false);
		// echo "Total Records:".$total_records;
        if ($total_records > 0)
        {
            // get current page records
            $data["getProducts"] = $this->m_crud->get_current_page_records($limit_per_page, $page*$limit_per_page,false);
                 
            $config['base_url'] = base_url() . 'brands/pages.html';
            $config['total_rows'] = $total_records;
			$config['per_page'] = $limit_per_page;
			$config["uri_segment"] = 3;
             
           // load config file
    		$this->config->load('pagination', TRUE);          
             
			$this->pagination->initialize($config);
			
			// End Pagination Script
                 
            // build paging links
            $params["links"] = $this->pagination->create_links();
        }

		$this->load->view('categories/v_categories',$data);
		
	}

	public function find($brand_id=false)
	{		
		$data=array();

		$pro="SELECT * FROM province";
		$data['province']=$this->m_cat->get_by_sql($pro,FALSE);
		
		$sql="SELECT cat.cat_id,cat.cat_name,cat.cat_ico_class,
		count(cat.cat_name) as number from categories as cat inner join products as 
		p ON cat.cat_id=p.cat_id group by cat.cat_id";
		$data['categories']=$this->m_cat->get_by_sql($sql,FALSE);


		if($brand_id!=false){
			$sql_product="SELECT * FROM products as p INNER JOIN branch as b ON p.branch_id=b.branch_id where b.branch_id=".$brand_id;
		}else{
			$sql_product="SELECT * FROM products";
		}
				
		$sql_cat_left="SELECT cat.cat_id,cat.cat_name,cat.cat_ico_class,count(cat.cat_name) as number from categories as cat inner join products as p ON cat.cat_id=p.cat_id group by cat.cat_id";
		$data['getCat_Left']=$this->m_cat->get_by_sql($sql_cat_left,FALSE);
			
		include_once 'langs.php';
		// Pagination Script
		$limit_per_page = 2; //total data show on page
		$page = ($this->uri->segment(4)) ? ($this->uri->segment(4) - 1) : 0;
		// $page = ($page) ? ($page - 1) : 0;
		$total_records = $this->m_crud->get_total('products',$brand_id);
		
        if ($total_records > 0)
        {
            // get current page records
            $data["getProducts"] = $this->m_crud->get_current_page_records($limit_per_page, $page*$limit_per_page,$brand_id);
                 
			$config['base_url'] = base_url() . 'brands/findpage/'.$this->uri->segment(3);
			$config['total_rows'] = $total_records;
			$config['per_page'] = $limit_per_page;
			$config["uri_segment"] = 4;

			// load config file			
    		$this->config->load('pagination', TRUE);         
             
			$this->pagination->initialize($config);
			
			// End Pagination Script
                 
            // build paging links
            $params["links"] = $this->pagination->create_links();
        }

		$this->load->view('categories/v_categories',$data);
		
	}

	public function findpage($brand_id=false)
	{		
		$data=array();
		$sql="SELECT cat.cat_id,cat.cat_name,cat.cat_ico_class,
		count(cat.cat_name) as number from categories as cat inner join products as 
		p ON cat.cat_id=p.cat_id group by cat.cat_id";
		$data['categories']=$this->m_cat->get_by_sql($sql,FALSE);
		
		if($brand_id!=false){
			$sql_product="SELECT * FROM products as p INNER JOIN branch as b ON p.branch_id=b.branch_id where b.branch_id=".$brand_id;
		}else{
			$sql_product="SELECT * FROM products";
		}
				
		$sql_cat_left="SELECT cat.cat_id,cat.cat_name,cat.cat_ico_class,count(cat.cat_name) as number from categories as cat inner join products as p ON cat.cat_id=p.cat_id group by cat.cat_id";
		$data['getCat_Left']=$this->m_cat->get_by_sql($sql_cat_left,FALSE);
			
		include_once 'langs.php';
		// Pagination Script
		$limit_per_page = 2; //total data show on page
		$page = ($this->uri->segment(4)) ? ($this->uri->segment(4) - 1) : 0;
		// $page = ($page) ? ($page - 1) : 0;
		$total_records = $this->m_crud->get_total('products',$brand_id);
		// echo "Total Records:".$total_records;
     
        if ($total_records > 0)
        {
            // get current page records
            $data["getProducts"] = $this->m_crud->get_current_page_records($limit_per_page, $page*$limit_per_page,$brand_id);
                 
			$config['base_url'] = base_url() . 'brands/find.html/'.$this->uri->segment(3);
			$config['total_rows'] = $total_records;
			$config['per_page'] = $limit_per_page;
			$config["uri_segment"] = 4;

			// load config file			
    		$this->config->load('pagination', TRUE);         
             
			$this->pagination->initialize($config);
			
			// End Pagination Script
                 
            // build paging links
            $params["links"] = $this->pagination->create_links();
        }

		$this->load->view('categories/v_categories',$data);
		
	}


	public function brand($brand_id=false)
	{		
		$data=array();
		$sql="SELECT cat.cat_id,cat.cat_name,cat.cat_ico_class,
		count(cat.cat_name) as number from categories as cat inner join products as 
		p ON cat.cat_id=p.cat_id group by cat.cat_id";
		$data['categories']=$this->m_cat->get_by_sql($sql,FALSE);


		if($brand_id!=false){
			$sql_product="SELECT * FROM products as p INNER JOIN branch as b ON p.branch_id=b.branch_id where b.branch_id=".$brand_id;
		}else{
			$sql_product="SELECT * FROM products";
		}
		
				
		$sql_cat_left="SELECT cat.cat_id,cat.cat_name,cat.cat_ico_class,count(cat.cat_name) as number from categories as cat inner join products as p ON cat.cat_id=p.cat_id group by cat.cat_id";
		$data['getCat_Left']=$this->m_cat->get_by_sql($sql_cat_left,FALSE);
			
		include_once 'langs.php';
		// Pagination Script
		$limit_per_page = 2; //total data show on page
		$page = ($this->uri->segment(4)) ? ($this->uri->segment(4) - 1) : 0;
		// $page = ($page) ? ($page - 1) : 0;
		$total_records = $this->m_crud->get_total('products',$brand_id);
		
        if ($total_records > 0)
        {
            // get current page records
            $data["getProducts"] = $this->m_crud->get_current_page_records($limit_per_page, $page*$limit_per_page,$brand_id);
                 
			$config['base_url'] = base_url() . 'brands/findpage/'.$this->uri->segment(3);
			$config['total_rows'] = $total_records;
			$config['per_page'] = $limit_per_page;
			$config["uri_segment"] = 4;

			// load config file			
    		$this->config->load('pagination', TRUE);         
             
			$this->pagination->initialize($config);
			
			// End Pagination Script
                 
            // build paging links
            $params["links"] = $this->pagination->create_links();
        }

		$this->load->view('categories/v_categories',$data);
		
	}


	
	public function login(){	
		$this->load->view('login/v_login');	
			
	}	
	

}
