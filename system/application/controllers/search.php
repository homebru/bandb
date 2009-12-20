<?php

class Search extends Application {
		
	function Search()
	{
		parent::Controller();
	}
	
	function index()
	{		
		
		// Set a few globals
		$data = array(
						'page_title' => 'Inn Strategy - Search',
					);

		$query = $this->get_classifications();
		$data['classification'] = $query->result_array();
		$data['class_count'] = $query->num_rows();

		$query = $this->get_price_type();
		$data['price_type'] = $query->result_array();

/*
		$Website = '';
		$Classification = '';
		$PriceType = '';
		$BBSpecials = '';
		$UserReview = '';
		$Google = '';
		$Yahoo = '';
		$MSN = '';
		$Quantified = '';
		$Rating = '';
		$State = '';
		$LinkType = '';
		$AdPackage = '';
		$BBCategory = '';
		$MaxPR = '';
		$LinkPR = '';
		$Limited = '';
		$query = $this->client_select_many($Website, $Classification, $PriceType, $BBSpecials, $UserReview, $Google, $Yahoo, $MSN, $Quantified, $Rating, $State, $LinkType, $AdPackage, $BBCategory, $MaxPR, $LinkPR, $Limited);
		$data['bbdata'] = $query->result_array();
*/

		$prev_sort_column = isset($_POST['prev_sort_column']) ? $_POST['prev_sort_column'] : "";	//$this->input->post("prev_sort_column");
		$sort_column = isset($_POST['sort_column']) ? $_POST['sort_column'] : "WebSiteText";
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

		$Website = isset($_POST['txtSearch']) ? $_POST['txtSearch'] : '';
		$Classification = $this->get_classification_list($data['classification']);
		$PriceType = $this->get_price_selection();
		$BBSpecials = isset($_POST['rblBBSpecials']) ? $_POST['rblBBSpecials'] : '';
		$UserReview = isset($_POST['rblUserReview']) ? $_POST['rblUserReview'] : '';
		$Google = '';
		$Yahoo = '';
		$MSN = '';
		$Quantified = '';
		$VacationRental = isset($_POST['rblVacationRental']) ? $_POST['rblVacationRental'] : '';
		$Rating = $this->get_rating();
		$Limited = '';
		$UserName = '13baaeb6-1bba-4bad-8893-3f0bca64e274'; //'b61fc9d0-d42f-4a8d-a8ae-f75042c1f039';
		$LinkPR = '';
		$BBCategory = isset($_POST['rblBBCategory']) ? $_POST['rblBBCategory'] : '';
		$LinkType = '';
		
		$query = $this->client_data_search($Website, $Classification, $PriceType, $BBSpecials, $UserReview, $Google, $Yahoo, $MSN, $Quantified, $VacationRental, $Rating, $Limited, $UserName, $LinkPR, $BBCategory, $LinkType, $sort_column, $sort_direction);
		$data['bbdata'] = $query->result_array();
		
		$this->load->vars($data);

		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('form');
		$this->load->library('ajax');
		
		$this->load->view('header_std');
		$this->load->view('search', $data);
		$this->load->view('footer_std');
		
	}

	function get_classifications()
	{		
		return ($this->db->query ( 'SELECT \'All\' AS ClassficationText, 0 AS ClassficationID, 0 AS UserDefault, 1 AS sort_order
									UNION
									SELECT \'Blank\' AS ClassficationText, 1 AS ClassficationID, 0 AS UserDefault, 2 AS sort_order
									UNION
									SELECT ClassficationText, ClassficationID, COALESCE(UserDefault,0) AS UserDefault, 3 AS sort_order
									FROM Classification
									WHERE Disabled IS NULL
									ORDER BY sort_order, ClassficationText ASC'));
	}
	
	function get_price_type()
	{
		return ($this->db->query (  'SELECT PriceTypeText, PriceID
									FROM PriceType
									WHERE (Disabled IS NULL)
									ORDER BY PriceTypeText ASC'));
	}

	function get_rating()
	{
		$strRating = '';
		for($i=0; $i < 5; $i++)
		{
			if(isset($_POST["chk$i"]))
				$strRating .= ",$i";
		}
			
		if(isset($_POST['chkNR']))
			$strRating .= ',-1';
		
		if(!empty($strRating))
            $strRating = substr($strRating, 1);

		
		return $strRating;
	}
	
	function get_price_selection()
	{
		$price_type = '';
		if(isset($_POST['ddPriceType']))
		 	$price_type = $_POST['ddPriceType'] == 'All' ? '' : $_POST['ddPriceType'];
		
		return $price_type;
	}
	
	function get_classification_list($classification)
	{
		$cb_list = '';
		foreach($_POST as $key => $value)
		{
			if((strpos($key, 'chkClass_') > -1))
				$cb_list .= substr($key, 9) . ',';
		} 
		
		if(empty($cb_list))
		{
			foreach($classification as $cb)
			{
				$cb_list .= ($cb['UserDefault'] == 1 ? $cb['ClassficationID'] . ',' : '');
			}
		}
		
		if(substr($cb_list, strlen($cb_list)-1, 1) === ',')
			$cb_list = substr($cb_list, 0, strlen($cb_list)-2);
			
		return $cb_list;
	}
	
	function client_data_search($Website, $Classification, $PriceType, $BBSpecials, $UserReview, $Google, $Yahoo, $MSN, $Quantified, $VacationRental, $Rating, $Limited, $UserName, $LinkPR, $BBCategory, $LinkType, $sort_column, $sort_direction)
	{
		if($Limited !== '') {

			$sql = 'SELECT b.BBDataID, c.ClassficationText, ClientBBData.ClientBBDataId, b.WebSiteText, 
					b.LastUpdated, b.QuantcastCurrent, b.QuantcastChange, b.CompeteCurrent, b.CompeteChange, b.Rating, 
					COALESCE(ClientBBData.BBDataID,0) AS Checked, b.Price,
					LinkType.LinkTypeText as LinkType, b.BBCategory, b.LinkPR, PriceType.PriceTypeText AS PriceType, 
					b.UserReview, b.BBListSpecials, COALESCE(b.VacationRental, 0) As VacationRental
					FROM Classification c
					INNER JOIN 
					BBData b ON c.ClassficationID = b.Classification
		
					LEFT OUTER JOIN
					PriceType ON b.PriceType = PriceType.PriceID 
		
					INNER JOIN
					StatesServed ON b.BBDataId = StatesServed.BBDataId 
		
					LEFT OUTER JOIN
					LinkType ON b.LinkType= LinkType.LinkTypeID
					
					LEFT OUTER JOIN
					ClientBBData ON b.BBDataId =
					 (SELECT     ClientBBData.BBDataID FROM ClientBBData
						 WHERE      (ClientBBData.UserID = \'' . $UserName . '\') LIMIT 0, 1)
		
		
					INNER JOIN
					ClientStates ON StatesServed.StateServed =
						  (SELECT    ClientStates.StateCode FROM ClientStates
							WHERE      (ClientStates.UserID = \'' . $UserName . '\') LIMIT 0, 1) 
		
		
					WHERE b.Enabled = 1
					AND Classification = c.ClassficationID AND c.ClassficationID <> 32
				';

/*
					WHERE b.BBDataId IN (SELECT BBDataID
										FROM BBData
										WHERE BBData.Enabled = 1)
					AND Classification = c.ClassficationID AND c.ClassficationID <> 32
*/

		} else {

			$sql = 'SELECT DISTINCT BBData.BBDataID, Classification.ClassficationText, BBData.LastUpdated, BBData.QuantcastCurrent, 
					BBData.QuantcastChange, BBData.CompeteCurrent, BBData.CompeteChange, BBData.Rating, BBData.WebSiteText, 
					COALESCE(ClientBBData.BBDataID,0) AS Checked, BBData.Price, 
					ClientBBData.ClientBBDataId, LinkType.LinkTypeText as LinkType, BBData.BBCategory, BBData.LinkPR, 
					PriceType.PriceTypeText AS PriceType, BBData.UserReview, BBData.BBListSpecials, COALESCE(BBData.VacationRental, 0) As VacationRental
					FROM BBData INNER JOIN
					StatesServed ON BBData.BBDataId = StatesServed.BBDataId 
					LEFT OUTER JOIN
					LinkType ON BBData.LinkType= LinkType.LinkTypeID
					LEFT OUTER JOIN
					PriceType ON BBData.PriceType = PriceType.PriceID LEFT OUTER JOIN
					Classification ON BBData.Classification = Classification.ClassficationID 	
					INNER JOIN
					ClientStates ON StatesServed.StateServed =
						  (SELECT     ClientStates.StateCode FROM ClientStates
							WHERE      (ClientStates.UserID = \'' . $UserName . '\') LIMIT 1, 1) LEFT OUTER JOIN
					ClientBBData ON BBData.BBDataId =
						  (SELECT     ClientBBData.BBDataID FROM ClientBBData
							WHERE      (ClientBBData.UserID = \'' . $UserName . '\') LIMIT 0, 1) 
						  
					WHERE (BBData.Enabled = 1)';

			if($Website !== '') {  
				$sql .= ' AND WebsiteText LIKE \'' . $Website . '%\'';
			} else {
					if($LinkPR !== '') {
						$sql .= ' AND COALESCE(LinkPR,0) IN (' . $LinkPR . ')';
					}		
					
					if($BBCategory  !== '') {
						$sql .= ' AND COALESCE(BBCategory,0) = ' . $BBCategory;
					}
					
					if($LinkType  !== '') {     
						$sql .= ' AND LinkType = ' . $LinkType;
					}
						
					if($Quantified !== '') {                                          
						$sql .= ' AND Quantified LIKE \'' . $Quantified . '%\'';
					}

					if($VacationRental  !== '') {
						$sql .= ' AND COALESCE(BBData.VacationRental,0) = ' . $VacationRental;
					}				
	
					if($BBSpecials !== '') {
						$sql .= ' AND BBListSpecials LIKE \'' . $BBSpecials . '%\'';
					}

					if($Yahoo  !== '') {
						$sql .= ' AND IndexByYahoo LIKE \'' . $Yahoo . '%\'';
					}
					
					if($MSN  !== '') {
						$sql .= ' AND IndexByMSN LIKE \'' . $MSN . '%\'';
					}
					
					if($Google  !== '') { 
						$sql .= ' AND IndexByGoogle LIKE \'' . $Google . '%\'';
					}
					
					if($UserReview  !== '') {
						$sql .= ' AND UserReview LIKE \'' . $UserReview . '%\'';
					}
					
					if($PriceType  !== '') {     
						if($PriceType !== 'Blank') {
							$sql .= ' AND PriceType LIKE \'' . $PriceType . '%\'';
						} else {
							$sql .= ' AND PriceType IS NULL';
						}
					}
					
					if($Website === '') {  //Why is Website being checked here?  We aleady know website is blank
						if($Classification !== '') {    
							if($Classification <> 'Blank') {
								$sql .= ' AND Classification  IN (' . $Classification . ')';
							} else {
								$sql .= ' AND Classification IS NULL';
							}
						}
					}
				
					if($Rating !== '') {
						$sql .= ' AND COALESCE(Rating,-1) IN (' . $Rating . ')';
					}	
			}	
			
			$sql .= ' ORDER BY ';
			
//			if($this->config->item('sort_column') !== '')
				$sql .= $sort_column . ' ' . $sort_direction . ', ';
			
			if($Limited !== '') {
				$sql .= 'c.ClassficationText ASC';
			} else {
				$sql .= 'WebSiteText ASC';
			}
		}
//print($sql);

		return ($this->db->query ($sql));
	}

	function client_select_many($Website, $Classification, $PriceType, $BBSpecials, $UserReview, $Google, $Yahoo, $MSN, $Quantified, $Rating, $State, $LinkType, $AdPackage, $BBCategory, $MaxPR, $LinkPR, $Limited)
	{

		if($Limited !== '')
		{
			$sql = 'SELECT DISTINCT TOP ' . $Limited;
		} else {
			$sql = 'SELECT DISTINCT';
		}

		$sql .= ' BBData.BBDataID, BBData.LastUpdated, BBData.QuantcastCurrent, BBData.QuantcastChange, BBData.CompeteCurrent, 
				BBData.CompeteChange, BBData.Rating, BBData.WebSiteText, BBData.WebSite, Classification.ClassficationText, BBData.Score, 
				BBData.Price, BBData.BBCategory, BBData.LinkPR, BBData.MaxPR, LinkType.LinkTypeText as LinkType, AdPackage.AdPackageText as AdPackage, 
				BBData.Quantified, BBData.IndexByYahoo, BBData.IndexByMSN, BBData.IndexByGoogle, PriceType.PriceTypeText AS PriceType
				FROM BBData 
				LEFT OUTER JOIN Classification ON BBData.Classification = Classification.ClassficationID 
				LEFT OUTER JOIN LinkType ON BBData.LinkType= LinkType.LinkTypeID 
				LEFT OUTER JOIN PriceType ON BBData.PriceType = PriceType.PriceID 
				LEFT OUTER JOIN AdPackage ON BBData.AdPackage= AdPackage.AdPackageID 
				LEFT OUTER JOIN StatesServed ON BBData.BBDataId = StatesServed.BBDataId
				WHERE (BBData.Enabled = 1)';

		if($Rating !== '')
		{
			$sql .= ' AND COALESCE(BBData.Rating,-1) IN (' . $Rating . ')';
		}		
		
		
		if($LinkPR !== '')
		{
			$sql .= ' AND COALESCE(BBData.LinkPR,0) IN (' . $LinkPR . ')';
		}		
		
	
		if($MaxPR !== '')
		{
			$sql .= ' AND COALESCE(BBData.MaxPR,0) IN (' . $MaxPR . ')';
		}		
		
		if($Quantified !== '')                                          
		{
			$sql .= ' AND BBData.Quantified LIKE \'' . $Quantified . '%\'';
		}

		if($BBSpecials !== '')
		{
			$sql .= ' AND BBData.BBListSpecials LIKE \'' . $BBSpecials . '%\'';
		}
		
		if($Yahoo !== '')
		{
			$sql .= ' AND BBData.IndexByYahoo LIKE \'' . $Yahoo . '%\'';
		}
		
	
		if($BBCategory !== '')
		{
			$sql .= ' AND BBData.BBCategory = ' . $BBCategory . '';
		}
		
		if($MSN !== '')
		{
			$sql .= ' AND BBData.IndexByMSN LIKE \'' . $MSN . '%\'';
		}
		
		if($Google !== '') 
		{
			$sql .= ' AND BBData.IndexByGoogle LIKE \'' . $Google . '%\'';
		}
		
		if($UserReview !== '')
		{
			$sql .= ' AND BBData.UserReview LIKE \'' . $UserReview . '%\'';
		}
		
		if($PriceType !== '')     
		{
			if($PriceType !== 'Blank')
			{
				$sql .= ' AND BBData.PriceType LIKE \'' . $PriceType . '%\'';
			} else {
				$sql .= ' AND BBData.PriceType IS NULL';
			}
		}

		if($LinkType !== '')     
		{
			$sql .= ' AND BBData.LinkType = ' . $LinkType . '';
		}

		if($AdPackage !== '')     
		{
			$sql .= ' AND BBData.AdPackage = ' . $AdPackage . '';
		}
		
		if($Website === '')
		{
			if($Classification !== '')    
			{
				if($Classification !== 'Blank')
				{
					$sql .= ' AND BBData.Classification IN (' . $Classification . ')';
				} else {
					$sql .= ' AND BBData.Classification IS NULL';
				}
			 }
	
			if($State !== '')
			{
				if($State !== 'Blank')
				{
					$sql .= ' AND BBData.BBDataId IN(SELECT DISTINCT BBDataID FROM StatesServed WHERE StatesServed.StateServed LIKE \'' . $State . '\')';
				} else {
					$sql .= ' AND BBData.BBDataId NOT IN(SELECT DISTINCT BBDataID FROM StatesServed WHERE NOT StateServed IS NULL )';
				}
			}
		}

		if($Website !== '')  
		{
			$sql .= ' AND BBData.WebsiteText LIKE \'' . $Website . '%\'';
		}
		
		$sql .= ' ORDER BY BBData.LastUpdated Desc';
		
//print $sql;
			
		return ($this->db->query ($sql));

	}
	
}

/* End of file search.php */
/* Location: ./system/application/controllers/search.php */