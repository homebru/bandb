<?php

class Contact_Us extends Controller {

	function Contact_Us()
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
		$this->load->view('contact_us');
		$this->load->view('footer_std');
	}
}

/* End of file contact_us.php */
/* Location: ./system/application/controllers/contact_us.php */