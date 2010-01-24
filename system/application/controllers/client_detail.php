<?php

class Client_Detail extends Application {

	function Client_Detail()
	{
		parent::Application();	
		$this->auth->restrict('admin');
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
		
		$this->load->view('header_admin');
		$this->load->view('client_detail');
		$this->load->view('footer_std');
	}
	
	function edit()
	{
		
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('auth');
		
		// Set a few globals
		$data = array(
						'page_title' => 'Inn Strategy - Account Information',
					);
		
		$UserID = $this->uri->segment(2);	//'13baaeb6-1bba-4bad-8893-3f0bca64e274';
		
		if($this->input->post('btnSaveTop') || $this->input->post('btnSaveBottom'))
		{
			 // load model
			$this->load->model('profile_model','',TRUE);
			$this->load->model('admin_notes_model','',TRUE);
			$this->load->library('form_validation');
			
			if($this->form_validation->run() != FALSE)
			{
				// Don't allow them to mess with the demo client
				// (BELT AND BRACES)
				if($this->uri->segment(2) !== 'demo')
				{
					$today = mktime(date("m"), date("d"), date("Y"));
					$today = date("Y-m-d H:i:s", $today);
	
					$userID = userID();
	
					$detail = array(//'PropertyName' => $_POST['txtPropertyName'],
									//'Address' => $_POST['txtAddress'],
									//'City' => $_POST['txtCity'],
									//'State' => $_POST['ddlState'],
									//'Zip' => $_POST['txtZip'],
									//'WebEmail' => $_POST['txtWebEmail'],
									//'Contact1' => $_POST['txtContact1'],
									//'Title1' => $_POST['txtTitle1'],
									//'Email1' => $_POST['txtEmail1'],
									//'Phone1' => $_POST['txtPhone1'],
									//'Contact2' => $_POST['txtContact2'],
									//'Title2' => $_POST['txtTitle2'],
									//'Email2' => $_POST['txtEmail2'],
									//'Phone2' => $_POST['txtPhone2'],
									'Geo' => $_POST['rblGeo'],
									'Enabled' => $_POST['rblEnabled'],
									'Processor' => $_POST['ddProcessor'],
									//'Notes' => $_POST['txtNotes'],
									//'SubscriptionStartDate'] => $_POST['txtSubscriptionStartDate'],
									'SubscriptionEndDate' => $_POST['txtSubscriptionEndDate'],
									'PayType' => $_POST['rblPayType'],
									'LastUpdateDate' => $today,	//$_POST['txtLastUpdateDate'],
									'Price' => $_POST['txtPrice']
									//'URL' => $_POST['txtPropertyURL'],
									//'Deleted' => $_POST['txtDeleted']
									);
					$this->profile_model->update($userID, $detail);
	
					$detail = array('AdminNote' => $_POST['txtAdminNotes']);
					$this->admin_notes_model->update($_POST['BBDataID'], $detail);
					
					//$this->states_served_model->delete_all($_POST['BBDataID']);
					foreach($data['client_states'] as $state)
					{
						if($this->input->post('MyStates_'.$state['StateCode']))
						{
							$detail = array('StateServed' => $state['StateCode'],
											'BBDataID' => $_POST['BBDataID']
											);
							$this->states_served_model->insert($detail);
						}
					}
				}
			}
		}

		$query = $this->get_ClientProfile_SelectOne($UserID);
		$data['client'] = $query->row();
		
		$data['states'] = $this->get_state_list();
		
		$data['client_states'] = $this->get_client_states($UserID);
		$this->load->vars($data);

		$this->load->view('header_user');
		$this->load->view('client_detail');
		$this->load->view('footer_std');
	}

	function get_state_list()
	{
		$sql =	'SELECT States.StatesCode, CASE States.StatesDescription WHEN \'All\' THEN \'National\' ELSE States.StatesDescription END AS StatesDescription
				FROM States
				ORDER BY States.StateID ASC';
				
		return ($this->db->query($sql));
	}
	
	function get_client_states($UserID)
	{
		$sql =	'SELECT ClientStates.StateCode, ClientStates.ClientStateID
				FROM ClientStates
				WHERE ClientStates.UserID = \'' . $UserID . '\'
				ORDER BY ClientStates.StateCode ASC';
				
		return ($this->db->query($sql));
	}
	
	function get_ClientProfile_SelectOne($UserID)
	{
		$sql =  'SELECT ClientProfile.PropertyName, ClientProfile.Address, ClientProfile.City, ClientProfile.State, ClientProfile.Zip,
				ClientProfile.WebEmail, ClientProfile.Contact1, ClientProfile.Title1, ClientProfile.Email1, ClientProfile.Phone1,
				ClientProfile.Contact2, ClientProfile.Title2, ClientProfile.Email2, ClientProfile.Phone2, ClientProfile.Geo, ClientProfile.Enabled,
				ClientProfile.Processor, ClientProfile.Notes, ClientProfile.SubscriptionStartDate, DATE_FORMAT(ClientProfile.SubscriptionEndDate,\'%m/%d/%Y\') AS SubscriptionEndDate,
				ClientProfile.PayType, ClientProfile.LastUpdateDate, ClientProfile.Price, ClientProfile.URL, AdminNotes.AdminNote, ClientBBData.BBDataID, ClientProfile.UserID
				FROM ClientProfile
				LEFT JOIN ClientBBData ON ClientBBData.UserID = ClientProfile.UserID
				LEFT JOIN AdminNotes ON AdminNotes.BBDataId = ClientBBData.BBDataID
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