<?php

class Client_Search extends Application {
		
	function Client_Search()
	{
		parent::Application();
		$this->auth->restrict('admin');
	}
	
	function index()
	{		
		
		// Set a few globals
		$data = array(
						'page_title' => 'Inn Strategy - Client Search',
					);

		$query = $this->get_state_list();
		$data['states'] = $query->result_array();
	
		$query = $this->get_processor_list();
		$data['processor'] = $query->result_array();

		$prev_sort_column = isset($_POST['prev_sort_column']) ? $_POST['prev_sort_column'] : "";	//$this->input->post("prev_sort_column");
		$sort_column = isset($_POST['sort_column']) ? $_POST['sort_column'] : "PropertyName";
		$data['prev_sort_column'] = $sort_column;
	
		$sort_direction = "ASC";
		if($prev_sort_column == $sort_column)
		{
			if(isset($_POST['sort_direction']) && ($_POST['sort_direction'] == "ASC"))
				$sort_direction = "DESC";
			else
				$sort_direction = "ASC";
		}
		$data['sort_direction'] = $sort_direction;
		
		$PropertyName = isset($_POST['txtSearch']) ? $_POST['txtSearch'] : ''; 
		$PayType = isset($_POST['rblPayType']) ? $_POST['rblPayType'] : '';
		$Processor = isset($_POST['ddProcessor']) ? $_POST['ddProcessor'] : '';
		$State = isset($_POST['ddState']) ? $_POST['ddState'] : '';
		$Geo = isset($_POST['rblGeo']) ? $_POST['rblGeo'] : '';
		
		$query = $this->get_client_profiles($PropertyName, $PayType, $Processor, $State, $Geo, $sort_column, $sort_direction);
		$data['client_profile'] = $query->result_array();

		$data['row_count'] = $query->num_rows();

		$this->load->vars($data);

		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('form');

		$this->load->view('header_user');
		$this->load->view('client_search', $data);
		$this->load->view('footer_std');

	}
	
	function get_state_list()
	{
		$sql =	'SELECT States.StatesCode, States.StatesDescription
				FROM States
				WHERE States.StatesCode <> \'All\'
				ORDER BY States.StatesDescription ASC';
				
		return ($this->db->query($sql));
	}
		
	function get_processor_list()
	{
		return ($this->db->query (  'SELECT Processor, ProcessorID
									FROM Processor
									WHERE (Disabled IS NULL)
									ORDER BY Processor ASC'));
	}
		
	function get_client_profiles($PropertyName, $PayType, $Processor, $State, $Geo, $sort_column, $sort_direction)
	{
		$sql = 'SELECT ClientProfile.UserID, ClientProfile.PropertyName, DATE_FORMAT(ClientProfile.LastUpdateDate, \'%m/%d/%Y\') AS LastUpdateDate, 
				DATE_FORMAT(ClientProfile.SubscriptionEndDate, \'%m/%d/%Y\') AS SubscriptionEndDate, 
				Processor.Processor, CASE COALESCE(ClientProfile.Geo, 0) WHEN 1 THEN \'One\' ELSE \'Many\' END AS Geo, users.LastLogin, 
				CASE ClientProfile.PayType WHEN 0 THEN \'Cash\' ELSE \'Account\' END AS PayType, ClientProfile.State, ClientProfile.City 
				FROM ClientProfile 
				LEFT OUTER JOIN Processor ON ClientProfile.Processor = Processor.ProcessorID
				LEFT JOIN users ON users.UserID = ClientProfile.UserID
				WHERE NOT ClientProfile.PropertyName IS NULL AND NOT COALESCE(ClientProfile.Deleted, 0) = 1';      
                      
		if(!empty($PropertyName))
			$sql .= ' AND ClientProfile.PropertyName LIKE \'' . $PropertyName . '%\'';

		if(!empty($PayType))
			$sql .= ' AND ClientProfile.PayType = ' . $PayType;

		if(!empty($Processor))
			$sql .= ' AND ClientProfile.Processor = ' . $Processor;
		
		if(!empty($State))
			$sql .= ' AND ClientProfile.State LIKE \'' . $State . '%\'';
		
		if(!empty($Geo))
			$sql .= ' AND ClientProfile.Geo LIKE \'' . $Geo . '%\'';
				
		$sql .= ' ORDER BY ' . $sort_column . ' ' . $sort_direction;

//print($sql);
		return ($this->db->query ($sql));
	}

}