<?php

class GDS extends Application {

	function GDS()
	{
		parent::Application();
		if($this->uri->segment(2) !== 'demo')
			$this->auth->restrict('user');
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
		$this->load->view('gds');
		$this->load->view('footer_std');
	}
}

/* End of file pricing.php */
/* Location: ./system/application/controllers/pricing.php */