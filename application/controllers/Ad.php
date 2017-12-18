<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ad extends CI_Controller {

	public function index()
	{
		$this->load->helper('url');
		$this->load->view('ad_post');
	}

	public function ad_details()
	{
		$this->load->helper('url');
		$this->load->view('ad_post_details');
	}
	



	

}
