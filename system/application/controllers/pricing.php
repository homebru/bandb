<?php

class Pricing extends Application {

	function Pricing()
	{
		parent::Application();	
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
		
		$this->load->view('header_user');
		$this->load->view('pricing');
		$this->load->view('footer_std');
	}
}

/* End of file pricing.php */
/* Location: ./system/application/controllers/pricing.php */