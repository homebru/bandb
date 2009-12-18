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
						'page_title' => 'Inn Strategy - Search'
					);

		$query = $this->get_classifications();
		$data['classification'] = $query->result_array();
		$data['class_count'] = $query->num_rows();

		$query = $this->get_price_type();
		$data['price_type'] = $query->result_array();

		$Website = '';
		$Classification = '';
		$PriceType = '';
		$BBSpecials = '';
		$UserReview = '';
		$Google = '';
		$Yahoo = '';
		$MSN = '';
		$Quantified = '';
		$VacationRental = '';
		$Rating = '';
		$Limited = '';
		$UserName = '';
		$LinkPR = '';
		$BBCategory = '';
		$LinkType = '';
		$query = $this->client_data_search($Website, $Classification, $PriceType, $BBSpecials, $UserReview, $Google, $Yahoo, $MSN, $Quantified, $VacationRental, $Rating, $Limited, $UserName, $LinkPR, $BBCategory, $LinkType);
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

	function client_data_search($Website, $Classification, $PriceType, $BBSpecials, $UserReview, $Google, $Yahoo, $MSN, $Quantified, $VacationRental, $Rating, $Limited, $UserName, $LinkPR, $BBCategory, $LinkType)
	{
		if($Limited !== '') {
			$sql = 'SELECT b.BBDataID, c.ClassficationText, ClientBBData.ClientBBDataId, b.WebsiteText, 
					b.LastUpdated, b.QuantcastCurrent, b.QuantcastChange, b.CompeteCurrent, b.CompeteChange, b.Rating, 
					ISNULL(Cast(ClientBBData.BBDataID as bit), 0) As Checked, CAST(b.Price AS money) AS Price ,
					LinkType.LinkTypeText as LinkType, b.BBCategory, b.LinkPR, PriceType.PriceTypeText AS PriceType, 
					b.UserReview, b.BBListSpecials, Isnull(b.VacationRental, 0) As VacationRental
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
					 (SELECT     ClientBBData.BBDataID
						 WHERE      (ClientBBData.UserID = \'' . $UserName . '\'))
		
		
					INNER JOIN
					ClientStates ON StatesServed.StateServed =
						  (SELECT     ClientStates.StateCode
							WHERE      (ClientStates.UserID = \'' . $UserName . '\')) 
		
		
					WHERE b.BBDataId IN (
		
						SELECT TOP 2 [BBDataID]
						FROM         BBData  
			
						WHERE (BBData.Enabled = 1) 
						AND [Classification] = c.[ClassficationID] AND c.[ClassficationID] <> 32
				)';
					
		} else {

			$sql = 'SELECT DISTINCT BBData.BBDataID, Classification.ClassficationText, BBData.LastUpdated, BBData.QuantcastCurrent, BBData.QuantcastChange, BBData.CompeteCurrent, BBData.CompeteChange, BBData.Rating, BBData.WebSiteText, ISNULL(Cast(ClientBBData.BBDataID as bit),0) As Checked, CAST( BBData.Price AS money) AS Price , ClientBBData.ClientBBDataId ,  LinkType.LinkTypeText as LinkType, BBData.BBCategory, BBData.LinkPR, PriceType.PriceTypeText AS PriceType, BBData.UserReview, BBData.BBListSpecials, Isnull(BBData.VacationRental, 0) As VacationRental
					FROM BBData INNER JOIN
					StatesServed ON BBData.BBDataId = StatesServed.BBDataId 
					LEFT OUTER JOIN
					LinkType ON BBData.LinkType= LinkType.LinkTypeID
					LEFT OUTER JOIN
					PriceType ON BBData.PriceType = PriceType.PriceID LEFT OUTER JOIN
					Classification ON BBData.Classification = Classification.ClassficationID 	
					INNER JOIN
					ClientStates ON StatesServed.StateServed =
						  (SELECT     ClientStates.StateCode
							WHERE      (ClientStates.UserID = \'' . $UserName . '\')) LEFT OUTER JOIN
					ClientBBData ON BBData.BBDataId =
						  (SELECT     ClientBBData.BBDataID
							WHERE      (ClientBBData.UserID = \'' . $UserName . '\')) WHERE (BBData.Enabled = 1)';

			if($Website !== '') {  
				$sql .= ' AND WebsiteText LIKE \'' . $Website . '%\'';
			} else {
					if($LinkPR !== '') {
						$sql .= ' AND isnull(LinkPR,0) IN (' . $LinkPR . ')';
					}		
					
					if($BBCategory  !== '') {
						$sql .= ' AND ISNULL(BBCategory,0) = ' . $BBCategory;
					}
					
					if($LinkType  !== '') {     
						$sql .= ' AND LinkType = ' . $LinkType;
					}
						
					if($Quantified !== '') {                                          
						$sql .= ' AND Quantified LIKE \'' . $Quantified . '%\'';
					}

					if($VacationRental  !== '') {
						$sql .= ' AND ISNULL(BBData.VacationRental,0) = ' . $VacationRental;
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
							$sql .= ' AND PriceType is Null';
						}
					}
					
					if($Website === '') {  
						if($Classification !== '') {    
							if($Classification <> 'Blank') {
								$sql .= ' AND Classification  In (' . $Classification . ')';
							} else {
								$sql .= ' AND Classification is Null';
							}
						}
					}
				
					if($Rating !== '') {
						$sql .= ' AND isnull(Rating,-1) IN (' . $Rating . ')';
					}	
			}	
					
			if($Limited !== '') {
				$sql .= ' ORDER BY c.ClassficationText Asc';
			} else {
				$sql .= ' ORDER BY WebSiteText Asc';
			}
		}
print($sql);
		return ($this->db->query ($sql));
	}

}

/* End of file search.php */
/* Location: ./system/application/controllers/search.php */