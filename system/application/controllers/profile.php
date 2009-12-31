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
						'page_title' => 'Inn Strategy - Account Information'
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
		
		$this->load->helper('url');
		$this->load->helper('html');
		
		// Set a few globals
		$data = array(
						'page_title' => 'Inn Strategy - Account Information',
					);
		
		$UserID = userID();	//'13baaeb6-1bba-4bad-8893-3f0bca64e274';
		$query = $this->get_ClientProfile_SelectOne($UserID);
		$data['client'] = $query->row();
		
		$data['states'] = $this->get_state_list();

		$this->load->vars($data);

		if($this->input->post('Save'))
		{
			 // load model
			$this->load->model('profile_model','',TRUE);
			$this->load->library('form_validation');
			
			// Set Validation Rules
			$this->form_validation->set_rules('txtPropertyName', 'Property Name', 'trim|required');
			$this->form_validation->set_rules('txtAddress', 'Address', 'trim|required');
			$this->form_validation->set_rules('txtCity', 'City', 'trim|required');
			$this->form_validation->set_rules('ddlState', 'State', 'trim|required|min_length[2]');
			$this->form_validation->set_rules('txtZip', 'Zip Code', 'trim|required|min_length[5]');
			$this->form_validation->set_rules('txtPropertyURL', 'Property URL', 'trim|callback_valid_urls');
			$this->form_validation->set_rules('txtContact1', 'First Contact', 'trim|required');
			$this->form_validation->set_rules('txtEmail1', 'First Email', 'trim|required|valid_email');
			
			if($this->form_validation->run() != FALSE)
			{
				$today = mktime(date("m"), date("d"), date("Y"));
				$today = date("Y-m-d H:i:s", $today);

				$id = userID();
				$profile = array('PropertyName' => $_POST['txtPropertyName'],
								'Address' => $_POST['txtAddress'],
								'City' => $_POST['txtCity'],
								'State' => $_POST['ddlState'],
								'Zip' => $_POST['txtZip'],
								//'WebEmail' => $_POST['txtWebEmail'],
								'Contact1' => $_POST['txtContact1'],
								'Title1' => $_POST['txtTitle1'],
								'Email1' => $_POST['txtEmail1'],
								'Phone1' => $_POST['txtPhone1'],
								'Contact2' => $_POST['txtContact2'],
								'Title2' => $_POST['txtTitle2'],
								'Email2' => $_POST['txtEmail2'],
								'Phone2' => $_POST['txtPhone2'],
								//'Geo' => $_POST['txtGeo'],
								//'Enabled' => $_POST['txtEnabled'],
								//'Processor' => $_POST['txtProcessor'],
								//'Notes' => $_POST['txtNotes'],
								//'SubscriptionStartDate'] => $_POST['txtSubscriptionStartDate'],
								//'SubscriptionEndDate'] => $_POST['txtSubscriptionEndDate'],
								//'PayType' => $_POST['txtPayType'],
								'LastUpdateDate' => $today,	//$_POST['txtLastUpdateDate'],
								//'Price' => $_POST['txtPrice'],
								'URL' => $_POST['txtPropertyURL'],
								//'Deleted' => $_POST['txtDeleted']
				);

				// Don't allow them to mess with the demo client
				if($this->uri->segment(2) !== 'demo')
					$this->profile_model->update($id, $profile);
			}
		}

		$this->load->view('header_user');
		$this->load->view('profile');
		$this->load->view('footer_std');
	}
	
   function modify() {

		// has the form been submitted and with valid form info (not empty values)
		if($this->input->post('Save'))
		{
			 // load model
			$this->load->model('profile_model','',TRUE);
			$this->load->library('form_validation');
			
			// Set Validation Rules
			$this->form_validation->set_rules('txtPropertyName', 'Property Name', 'trim|required');
			$this->form_validation->set_rules('txtAddress', 'Address', 'trim|required');
			$this->form_validation->set_rules('txtCity', 'City', 'trim|required');
			$this->form_validation->set_rules('ddlState', 'State', 'trim|required|min_length[2]');
			$this->form_validation->set_rules('txtZip', 'Zip', 'trim|required|min_length[5]');
			$this->form_validation->set_rules('txtPropertyURL', 'Property URL', 'trim|callback_valid_urls');
			$this->form_validation->set_rules('txtContact1', 'First Contact', 'trim|required');
			$this->form_validation->set_rules('txtEmail1', 'First Email', 'trim|required|valid_email');
			
			if($this->form_validation->run() == FALSE)
			{
				$this->load->view('profile');
			}
			else
			{
				$today = mktime(date("m"), date("d"), date("Y"));
				$today = date("Y-m-d H:i:s", $today);

				$id = userID();
				$profile = array('PropertyName' => $_POST['txtPropertyName'],
								'Address' => $_POST['txtAddress'],
								'City' => $_POST['txtCity'],
								'State' => $_POST['ddlState'],
								'Zip' => $_POST['txtZip'],
								//'WebEmail' => $_POST['txtWebEmail'],
								'Contact1' => $_POST['txtContact1'],
								'Title1' => $_POST['txtTitle1'],
								'Email1' => $_POST['txtEmail1'],
								'Phone1' => $_POST['txtPhone1'],
								'Contact2' => $_POST['txtContact2'],
								'Title2' => $_POST['txtTitle2'],
								'Email2' => $_POST['txtEmail2'],
								'Phone2' => $_POST['txtPhone2'],
								//'Geo' => $_POST['txtGeo'],
								//'Enabled' => $_POST['txtEnabled'],
								//'Processor' => $_POST['txtProcessor'],
								//'Notes' => $_POST['txtNotes'],
								//'SubscriptionStartDate'] => $_POST['txtSubscriptionStartDate'],
								//'SubscriptionEndDate'] => $_POST['txtSubscriptionEndDate'],
								//'PayType' => $_POST['txtPayType'],
								'LastUpdateDate' => $today,	//$_POST['txtLastUpdateDate'],
								//'Price' => $_POST['txtPrice'],
								'URL' => $_POST['txtPropertyURL'],
								//'Deleted' => $_POST['txtDeleted']
				);

				// Don't allow them to mess with the demo client
				if($this->uri->segment(2) !== 'demo')
					$this->profile_model->update($id, $profile);
			}
		}
		redirect('/profile', 'location');
   }

	function get_state_list()
	{
		$sql =	'SELECT States.StatesCode, States.StatesDescription
				FROM States
				WHERE States.StatesCode <> \'All\'
				ORDER BY States.StatesDescription ASC';
				
		return ($this->db->query($sql));
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

		return ($this->db->query($sql));

	}
	
	function valid_urls($str) 
	{

		if(!filter_var($str, FILTER_VALIDATE_URL))
		  {
				$this->form_validation->set_message('valid_urls', 'The URL field is not valid.');
				return FALSE;
		  }
		else 
		{
			return TRUE;
		}
	}
	
	function valid_url($str)
	{
		return ( ! preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $str)) ? FALSE : TRUE;
	}
	
}

/* End of file detail.php */
/* Location: ./system/application/controllers/detail.php */