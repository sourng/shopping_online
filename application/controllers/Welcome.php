<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$this->load->helper('url');
		$data['main_content']='layouts/template';
		$this->load->view('layouts/v_home', $data);
	}

	public function categories()
	{
		$this->load->helper('url');
		$this->load->view('categories/v_categories_main');
	}

	public function details()
	{
		$this->load->helper('url');
		$this->load->view('v_details');
	}

	public function faq()
	{
		$this->load->helper('url');
		$this->load->view('v_faq');
	}

	public function page()
	{
		$this->load->helper('url');
		$this->load->view('v_500_page');
	}





	

}
