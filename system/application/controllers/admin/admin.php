<?php

class Admin extends Application
{
	function Admin()
	{
		parent::Application();
	}
	
	function index()
	{
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('form');

		if(logged_in())
		{
			$this->auth->view('dashboard');
		}
		else
		{
			$this->auth->login();
		}
	}

}

/* End of file: dashboard.php */
/* Location: application/controllers/admin/dashboard.php */