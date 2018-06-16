<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	function __construct() {
        parent::__construct();        
        //$this->load->helper('text');
        $this->load->database();   
        //$this->load->helper('url');
        $this->load->model('M_Categories','m_cat');
        $this->load->model('Crud_model','m_crud');
       
    }
	public function index($page='home')
	{		
		$data=array();

		$sql="SELECT cat.cat_id,cat.cat_name,cat.cat_ico_class,cat_ico_image,
		count(cat.cat_name) as number from categories as cat inner join products as 
		p ON cat.cat_id=p.cat_id group by cat.cat_id";
		$data['categories']=$this->m_cat->get_by_sql($sql,FALSE);

		
		
		$sql_product="SELECT p.*,c.cat_name FROM products as p INNER JOIN categories as c ON p.cat_id=c.cat_id;";
		$data['getProducts']=$this->m_cat->get_by_sql($sql_product,FALSE);
		

		$data['title']="Trade Title ";

		$data['head']="head/v_head_home";
		$data['footer']="footer/v_footer_home";

        $data['body']='fronts/home/v_home_main';

        include_once 'langs.php';



		$this->load->view('v_template', $data);
		
	}
	
	public function details($pro_id){	
	$data=array();

		$data['lang']=$this->session->userdata('site_lang')?$this->session->userdata('site_lang'):'english';
		$sql="SELECT cat.cat_id,cat.cat_name,cat.cat_ico_class,
		count(cat.cat_name) as number from categories as cat inner join products as 
		p ON cat.cat_id=p.cat_id group by cat.cat_id";
		$data['categories']=$this->m_cat->get_by_sql($sql,FALSE);
		

		$sql_branch="SELECT * FROM products as p INNER JOIN branch as b ON p.branch_id=b.branch_id where p.product_id=".$pro_id;
		$data['getBranch']=$this->m_cat->get_by_sql($sql_branch,FALSE);

		$sql_product="SELECT * FROM products as p INNER JOIN model as m ON p.pro_model=m.model_id where p.product_id=".$pro_id;
		$data['getItem']=$this->m_cat->get_by_sql($sql_product,FALSE);

		$sql_galleries="SELECT * FROM product_gallery WHERE product_id=".$pro_id;
		$data['galleries']=$this->m_crud->get_by_sql($sql_galleries,false);

		// Recommended Ads for You

		$sql_productRecommended="SELECT * FROM products WHERE product_id<>".$pro_id;
		$data['getRecommendedAds']=$this->m_cat->get_by_sql($sql_productRecommended,FALSE);

		$pro="SELECT * FROM province";
		$data['province']=$this->m_cat->get_by_sql($pro,FALSE);

		
		$data['title']="Trade Title";

		$data['head']="head/v_head_home";
		$data['footer']="footer/v_footer_home";

        $data['body']='fronts/home/v_detail';

        //Language file
        include_once 'langs.php';
        

		$this->load->view('v_template', $data);
			
	}

	public function pages($page_name){
		echo "About" .$page_name;
	}
	public function langs(){
		echo $this->m_crud->get_langs('about','english');
	}	

}