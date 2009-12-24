<?php

class Profile extends Application {

	function Profile()
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
		$this->load->view('profile');
		$this->load->view('footer_std');
	}
	
	function edit()
	{
		
		// Set a few globals
		$data = array(
						'page_title' => 'Inn Strategy - Search',
					);
		
		$UserID = userID();	//'13baaeb6-1bba-4bad-8893-3f0bca64e274';
		$query = $this->get_ClientProfile_SelectOne($UserID);
		$data['client'] = $query->row();

//die(print_r($data));

		$this->load->vars($data);

		$this->load->helper('url');
		$this->load->helper('html');
		
		$this->load->view('header_user');
		$this->load->view('profile');
		$this->load->view('footer_std');
	}
	
	function get_ClientProfile_SelectOne($UserID)
	{
		$sql =  'SELECT     ClientProfile.PropertyName, ClientProfile.Address, ClientProfile.City, ClientProfile.State, ClientProfile.Zip,
				ClientProfile.WebEmail, ClientProfile.Contact1, ClientProfile.Title1, ClientProfile.Email1, ClientProfile.Phone1,
				ClientProfile.Contact2, ClientProfile.Title2, ClientProfile.Email2, ClientProfile.Phone2, ClientProfile.Geo, ClientProfile.Enabled,
				ClientProfile.Processor, ClientProfile.Notes, ClientProfile.SubscriptionStartDate, ClientProfile.SubscriptionEndDate,
				ClientProfile.PayType, ClientProfile.LastUpdateDate, ClientProfile.Price, ClientProfile.URL
				FROM ClientProfile
				WHERE
				ClientProfile.UserID = \'' . $UserID . '\'';

//print($sql);
	return ($this->db->query($sql));

	}
	
}

/* End of file detail.php */
/* Location: ./system/application/controllers/detail.php */