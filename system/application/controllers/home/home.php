<?php

class Home extends Controller {

	function Home()
	{
		parent::Controller();	
	}
	/*
	function index()
	{
		$this->load->view('welcome_message');
	}
*/
	// generate web page using partial sections
	function index()
	{

		$this->load->helper('url');
		$this->load->helper('html');
		
		// Set a few globals
		$data = array(
						'page_title'		=> 'Inn Strategy'
					);
		

		$class_total = 0;
		$data['query1'] = $this->get_classification_count();
		//$query = $this->db->query;
		foreach ($data['query1']->result_array() as $row)
		{
			$class_total += $row['ClassCount'];
		}
		$data['web_sites'] = $class_total . ' Web Sites';

		$free_total = 0;
		$data['query2'] = $this->get_free_site_count();
		foreach ($data['query2']->result_array() as $row)
		{
			$free_total += $row['PriceTypeCount'];
		}
		$data['free_sites'] = $free_total . ' Free Sites';
		
		$state_total = 0;
		$data['query3'] = $this->get_state_count();
		foreach ($data['query3']->result_array() as $row)
		{
			$state_total += $row['StateCount'];
		}
		$data['local_sites'] = $state_total . ' Local Sites';

		$data['query4'] = $this->get_ratings_count();
		foreach ($data['query4']->result_array() as $row)
		{
			$rating = $row['Rating'];
	        If($rating == 0)
            	$row['Rating'] = "<IMG src='../images/star-o.gif'>";
			else
			{
				if($rating === "") 
            		$row['Rating'] = "<IMG src='../images/nr.gif'>";
		        else
				{
					for($i=1; $i<=$rating; $i++)
		                $row['Rating'] .= "<IMG src='images/star.gif'>&nbsp;";
				}
			}
		}

		// generate header section
		$data['header']=$this->load->view('header_home',$data,TRUE);
		
		// generate content section
		$data['content']=$this->load->view('content_home',$data,TRUE);
		
		// generate footer section
		$data['footer']=$this->load->view('footer_home',$data,TRUE);
		
		$this->load->vars($data);
		
		// generate full web page
		$this->load->view('home',$data);
	}
	
	function get_classifications()
	{
		$this->db->query ( 'SELECT ClassficationText, ClassficationID, COALESCE(UserDefault,0) AS UserDefault
							FROM Classification
							WHERE Disabled IS NULL
							ORDER BY ClassficationText');
	}
	
	function get_classification_count()
	{
		return( $this->db->query ( 'SELECT COUNT(BBData.Classification) AS ClassCount, Classification.ClassficationText  As ClassficationText
							FROM Classification 
							INNER JOIN BBData ON Classification.ClassficationID = BBData.Classification
							WHERE BBData.Enabled = 1
							GROUP BY BBData.Classification, Classification.ClassficationText
							ORDER BY ClassCount DESC'));
	}
	
	function get_free_site_count()
	{
		return($this->db->query ('SELECT COUNT(BBData.PriceType) AS PriceTypeCount, PriceType.PriceTypeText
							FROM PriceType 
							INNER JOIN BBData ON PriceType.PriceID = BBData.PriceType
							WHERE (PriceType.PriceID IN (9, 11, 15, 20))
							GROUP BY BBData.PriceType, PriceType.PriceTypeText
							ORDER BY PriceTypeCount DESC'));
	}
	
	function get_ratings_count()
	{
		return($this->db->query ( 'SELECT DISTINCT Rating, COUNT(Classification) AS RatingCount
							FROM BBData
							WHERE (Enabled = 1)
							GROUP BY Rating
							ORDER BY Rating DESC'));
	}
	
	function get_state_count()
	{
		return($this->db->query ( 'SELECT States.StatesCode, States.StatesDescription,
							(SELECT COUNT(*)
								FROM StatesServed 
								INNER JOIN BBData ON StatesServed.BBDataId = BBData.BBDataId
								WHERE (StatesServed.StateServed = States.StatesCode) AND (BBData.Enabled = 1)) AS StateCount
							FROM States
							WHERE States.StatesCode <> \'All\'
							ORDER BY States.StatesCode ASC'));
	}
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */