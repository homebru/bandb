<?php

class About_Us extends Controller {

	function About_Us()
	{
		parent::Controller();	
	}
	
	function index()
	{
		// Set a few globals
		$data = array(
						'page_title' => 'Welcome to Inn Strategy'
					);

		$this->load->vars($data);

		$this->load->helper('url');
		$this->load->helper('html');
		
		$this->load->view('header_std');
		$this->load->view('about_us');
		$this->load->view('footer_std');
	}
}

/* End of file about_us.php */
/* Location: ./system/application/controllers/about_us.php */