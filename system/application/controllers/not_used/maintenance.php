<?php

class Maintenance extends Application {

	function Maintenance()
	{
		parent::Application();
		$this->auth->restrict('admin');
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
		
		$this->load->view('header_admin');
		$this->load->view('maintenance');
		$this->load->view('footer_std');
	}
}

/* End of file contact_us.php */
/* Location: ./system/application/controllers/contact_us.php */