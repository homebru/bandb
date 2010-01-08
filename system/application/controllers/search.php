<?php

class Search extends Application {
		
	function Search()
	{
		parent::Application();
		if($this->uri->segment(2) !== 'demo')
			$this->auth->restrict('user');
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

		if(user_group('admin') === TRUE)
		{
			$query = $this->get_price_type();
			$data['price_type'] = $query->result_array();
			
			$query = $this->get_link_type();
			$data['link_type'] = $query->result_array();
			
			$query = $this->get_ad_packages();
			$data['ad_package'] = $query->result_array();
			
			$query = $this->get_state_list();
			$data['states'] = $query->result_array();
		}
		
		if($this->uri->segment(2) === 'demo')
			set_userID('b2cd1871-34e4-4472-a004-1d6dccb0f0a2');

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
		$sort_column = isset($_POST['sort_column']) ? $_POST['sort_column'] : (user_group('admin') === TRUE) ? "LastUpdated" : "WebSiteText";
		$data['prev_sort_column'] = $sort_column;

		$sort_direction = (user_group('admin') === TRUE) ? "DESC" : "ASC";
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
		$Google = isset($_POST['rblGoogle']) ? $_POST['rblGoogle'] : '';
		$Yahoo = isset($_POST['rblYahoo']) ? $_POST['rblYahoo'] : '';
		$MSN = isset($_POST['rblMSN']) ? $_POST['rblMSN'] : '';
		$Quantified = isset($_POST['rblQuantified']) ? $_POST['rblQuantified'] : '';
		$VacationRental = isset($_POST['rblVacationRental']) ? $_POST['rblVacationRental'] : '';
		$Rating = $this->get_rating();
		$Limited = ($this->uri->segment(2) === 'demo');
		$BBCategory = isset($_POST['rblBBCategory']) ? $_POST['rblBBCategory'] : '';
		$AdPackage = isset($_POST['ddAdPackage']) ? $_POST['ddAdPackage'] : '';
		$State = isset($_POST['ddStates']) ? $_POST['ddStates'] : '';
		$LinkType = isset($_POST['ddLinkType']) ? $_POST['ddLinkType'] : '';
		$UserName = userID();	//'13baaeb6-1bba-4bad-8893-3f0bca64e274'; //'b61fc9d0-d42f-4a8d-a8ae-f75042c1f039';
		
		$LinkPR = '';
		for($i=0; $i<10; $i++)
		{
			If(isset($_POST["chkLinkPR$i"]))
				$LinkPR .= ",$i";
		}

		If(strpos($LinkPR,',') == 0)
			$LinkPR = substr($LinkPR,1);
		
		$MaxPR = '';
		for($i=0; $i<10; $i++)
		{
			If(isset($_POST["chkMaxPR$i"]))
				$MaxPR .= ",$i";
		}

		If(strpos($MaxPR,',') == 0)
			$MaxPR = substr($MaxPR,1);
		
		$my_list = ($this->uri->segment(2) == 'my') || ($this->uri->segment(3) == 'my');	//!($this->uri->segment(2) === FALSE) && ($this->uri->segment(2) !== 'demo');
		
		if(user_group('admin') === TRUE)
			$query = $this->client_admin_search($Rating, $LinkPR, $MaxPR, $Quantified, $BBSpecials, $Yahoo, $BBCategory, $MSN, $Google, $UserReview, $PriceType, $LinkType, $AdPackage, $Website, $Classification, $State, $Limited, $sort_column, $sort_direction);
		else	
			$query = $this->client_data_search($Website, $Classification, $PriceType, $BBSpecials, $UserReview, $Google, $Yahoo, $MSN, $Quantified, $VacationRental, $Rating, $Limited, $UserName, $LinkPR, $BBCategory, $LinkType, $sort_column, $sort_direction);
	
		$data['bbdata'] = $query->result_array();

		$data['row_count'] = $query->num_rows();
	
		$UserName = ($this->uri->segment(2) === 'demo') ? 'Demonstration' : userID();

		$this->load->vars($data);

		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('form');
		$this->load->library('ajax');
		
		$this->load->view(user_group('admin') === TRUE ? 'header_admin' : 'header_user');
		$this->load->view($my_list ? 'my_list' : (user_group('admin') === TRUE ? 'admin_search' : 'search'), $data);
		$this->load->view('footer_std');
		
	}

	function get_ad_packages()
	{
		return ($this->db->query (  'SELECT AdPackageText, AdPackageId
									FROM AdPackage
									WHERE (Disabled IS NULL)
									ORDER BY AdPackageText ASC'));
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
	
	function get_link_type()
	{
		return ($this->db->query (  'SELECT LinkTypeText, LinkTypeId
									FROM LinkType
									WHERE (Disabled IS NULL)
									ORDER BY LinkTypeText ASC'));
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
	
	function get_state_list()
	{
		$sql =	'SELECT States.StatesCode, States.StatesDescription
				FROM States
				WHERE States.StatesCode <> \'All\'
				ORDER BY States.StatesDescription ASC';
				
		return ($this->db->query($sql));
	}
		
	function client_my_list_search($UserName)
	{
		return ($this->db->query (  'SELECT BBData.BBDataId, BBData.WebsiteText, BBData.Website, BBData.Rating, ClientBBData.DateExpires, ClientBBData.Price, BBData.UserReview, 
                      				BBData.BBListSpecials, BBData.LinkPR, ClientBBData.UserID, Classification.ClassficationID, Classification.ClassficationText AS Classification, 
                      				PriceType.PriceTypeText AS PriceType
									FROM BBData 
									LEFT OUTER JOIN
				                      ClientBBData ON BBData.BBDataId = ClientBBData.BBDataID 
									LEFT OUTER JOIN
                				      PriceType ON BBData.PriceType = PriceType.PriceID 
									LEFT OUTER JOIN
				                      Classification ON BBData.Classification = Classification.ClassficationID
									WHERE (ClientBBData.UserID = \'' . $UserName . '\') AND ()
									ORDER BY BBData.WebsiteText'));
		
	}
	
	function client_data_search($Website, $Classification, $PriceType, $BBSpecials, $UserReview, $Google, $Yahoo, $MSN, $Quantified, $VacationRental, $Rating, $Limited, $UserName, $LinkPR, $BBCategory, $LinkType, $sort_column, $sort_direction)
	{
		if($Limited === 'x') {	//THIS IS BADLY BROKEN!!!
			
			//mySQL doesn't yet support "LIMIT & IN/ALL/ANY/SOME subquery"
			//so we have to do our subquery here
			$sql = $this->db->query ('SELECT b.BBDataID
			FROM Classification c
			INNER JOIN 
			BBData b ON c.ClassficationID = b.Classification
			WHERE ((b.Enabled = 1) AND (Classification = c.ClassficationID) AND (c.ClassficationID <> 32)) LIMIT 0, 2');
			$result = $sql->result();
			$sub_query = '';
			foreach($result as $row)
				{
					$sub_query .= $row->BBDataID . ',';
				}
			if(substr($sub_query,strlen($sub_query)-1,1) == ',')
				$sub_query = substr($sub_query,0,strlen($sub_query)-1);
			
			
			$sql = 'SELECT DISTINCT b.BBDataID, c.ClassficationText, ClientBBData.ClientBBDataId, b.WebSiteText, b.LastUpdated, b.QuantcastCurrent, 
			b.QuantcastChange, b.CompeteCurrent, b.CompeteChange, b.Rating, 0 As Checked, Null as  Price ,  LinkType.LinkTypeText as LinkType,  
			b.BBCategory, b.LinkPR, PriceType.PriceTypeText AS PriceType, b.UserReview, COALESCE(b.VacationRental, 0) As VacationRental, b.BBListSpecials
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
			ClientBBData ON b.BBDataId IN
             (SELECT     ClientBBData.BBDataID FROM ClientBBData
                 WHERE      (ClientBBData.UserID = \'' . $UserName . '\'))


			INNER JOIN
			ClientStates ON StatesServed.StateServed IN
				  (SELECT     ClientStates.StateCode FROM ClientStates
					WHERE      (ClientStates.UserID = \'' . $UserName . '\')) 


			WHERE b.BBDataId IN (' . $sub_query . ')';

/*
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
						       ClientStates.StateCode 
							AND      (ClientStates.UserID = \'' . $UserName . '\') LEFT OUTER JOIN
					ClientBBData ON BBData.BBDataId =
						       ClientBBData.BBDataID 
							AND      (ClientBBData.UserID = \'' . $UserName . '\')
						  
					WHERE (BBData.Enabled = 1)';

					if(!empty($LinkPR))
						$sql .= ' AND COALESCE(LinkPR,0) IN (' . $LinkPR . ')';
					
					if(!empty($BBCategory))
						$sql .= ' AND COALESCE(BBCategory,0) = ' . $BBCategory;
					
					if(!empty($LinkType))
						$sql .= ' AND LinkType = ' . $LinkType;
						
					if(!empty($Quantified))                        
						$sql .= ' AND Quantified LIKE \'' . $Quantified . '%\'';

					if(!empty($VacationRental))
						$sql .= ' AND COALESCE(BBData.VacationRental,0) = ' . $VacationRental;
	
					if(!empty($BBSpecials))
						$sql .= ' AND BBListSpecials LIKE \'' . $BBSpecials . '%\'';

					if(!empty($Yahoo))
						$sql .= ' AND IndexByYahoo LIKE \'' . $Yahoo . '%\'';
					
					if(!empty($MSN))
						$sql .= ' AND IndexByMSN LIKE \'' . $MSN . '%\'';
					
					if(!empty($Google))
						$sql .= ' AND IndexByGoogle LIKE \'' . $Google . '%\'';
					
					if(!empty($UserReview))
						$sql .= ' AND UserReview LIKE \'' . $UserReview . '%\'';
					
					if(!empty($PriceType)) {     
						if($PriceType !== 'Blank') {
							$sql .= ' AND PriceType LIKE \'' . $PriceType . '%\'';
						} else {
							$sql .= ' AND PriceType IS NULL';
						}
					}
					
					if(empty($Website)) { 
						if(!empty($Classification)) {    
							if($Classification <> 'Blank') {
								$sql .= ' AND Classification  IN (' . $Classification . ')';
							} else {
								$sql .= ' AND Classification IS NULL';
							}
						}
					}
					else
					{
						$sql .= ' AND WebsiteText LIKE \'' . $Website . '%\'';
					}

					if(!empty($Rating))
						$sql .= ' AND COALESCE(Rating,-1) IN (' . $Rating . ')';
			}	
							
			$sql .= ' ORDER BY ' . $sort_column . ' ' . $sort_direction . ', ';
			
			if($Limited) {
				$sql .= 'ClassficationText ASC';
			} else {
				$sql .= 'WebSiteText ASC';
			}
			
			if($Limited)
				$sql .= ' LIMIT 0, 10';
//print($sql);
		return ($this->db->query ($sql));
	}

	function client_admin_search($Rating, $LinkPR, $MaxPR, $Quantified, $BBSpecials, $Yahoo, $BBCategory, $MSN, $Google, $UserReview, $PriceType, $LinkType, $AdPackage, $Website, $Classification, $State, $Limited, $sort_column, $sort_direction)
	{
		$sql = 'SELECT DISTINCT BBData.BBDataID, DATE_FORMAT(BBData.LastUpdated,\'%m/%d/%Y\') AS LastUpdated, BBData.QuantcastCurrent, BBData.QuantcastChange, 
				BBData.CompeteCurrent, BBData.CompeteChange, BBData.Rating, BBData.WebSiteText, BBData.WebSite, 
				Classification.ClassficationText, BBData.Score, BBData.Price, BBData.BBCategory, BBData.LinkPR, 
				BBData.MaxPR, LinkType.LinkTypeText as LinkType, AdPackage.AdPackageText as AdPackage, BBData.VacationRental,
				BBData.Quantified, BBData.IndexByYahoo, BBData.IndexByMSN, BBData.IndexByGoogle, PriceType.PriceTypeText AS PriceType,
				BBData.PM, BBData.SEO
				FROM BBData 
				LEFT OUTER JOIN Classification ON BBData.Classification = Classification.ClassficationID 
				LEFT OUTER JOIN LinkType ON BBData.LinkType= LinkType.LinkTypeID 
				LEFT OUTER JOIN PriceType ON BBData.PriceType = PriceType.PriceID 
				LEFT OUTER JOIN AdPackage ON BBData.AdPackage= AdPackage.AdPackageID 
				LEFT OUTER JOIN StatesServed ON BBData.BBDataId = StatesServed.BBDataId
				WHERE (BBData.Enabled = 1)';

		if(!empty($Rating))
			$sql .= ' AND COALESCE(BBData.Rating,-1) IN (' . $Rating . ')';
		
		if(!empty($LinkPR))
			$sql .= ' AND COALESCE(BBData.LinkPR,0) IN (' . $LinkPR . ')';		
	
		if(!empty($MaxPR))
			$sql .= ' AND COALESCE(BBData.MaxPR,0) IN (' . $MaxPR . ')';
		
		if(!empty($Quantified))                                          
			$sql .= ' AND BBData.Quantified LIKE \'' . $Quantified . '%\'';

		if(!empty($BBSpecials))
			$sql .= ' AND BBData.BBListSpecials LIKE \'' . $BBSpecials . '%\'';
		
		if(!empty($Yahoo))
			$sql .= ' AND BBData.IndexByYahoo LIKE \'' . $Yahoo . '%\'';
	
		if(!empty($BBCategory))
			$sql .= ' AND BBData.BBCategory = ' . $BBCategory;
	
		if(!empty($MSN))
			$sql .= ' AND BBData.IndexByMSN LIKE \'' . $MSN . '%\'';
	
		if(!empty($Google))
			$sql .= ' AND BBData.IndexByGoogle LIKE \'' . $Google . '%\'';
		
		if(!empty($UserReview))
			$sql .= ' AND BBData.UserReview LIKE \'' . $UserReview . '%\'';
	
		if(!empty($PriceType))
		{
			if($PriceType !== 'Blank')
			{
				if($PriceType !== 'All')
					$sql .= ' AND BBData.PriceType LIKE \'' . $PriceType . '%\'';
			}
			else
				$sql .= ' AND BBData.PriceType IS NULL';
		}

		if(!empty($LinkType) && ($LinkType !== 'All'))     
			$sql .= ' AND BBData.LinkType = ' . $LinkType;

		if(!empty($AdPackage) && ($AdPackage !== 'All')) 
			$sql .= ' AND BBData.AdPackage = ' . $AdPackage;
		
		if(empty($Website))  
		{
			if(!empty($Classification))    
			{
				if($Classification !== 'Blank') 
					$sql .= ' AND BBData.Classification IN (' . $Classification . ')';
				else
					$sql .= ' AND BBData.Classification IS NULL';
			}
		}
	
		if(!empty($State))
		{

			if($State !== 'Blank')
				$sql .= ' AND BBData.BBDataId IN(SELECT DISTINCT BBDataID FROM StatesServed WHERE StateServed LIKE \'' . $State . '\')';
			else
				$sql .= ' AND BBData.BBDataId NOT IN(SELECT DISTINCT BBDataID FROM StatesServed WHERE NOT StateServed IS NULL )';
		}

		if(!empty($Website))
			$sql .= ' AND BBData.WebsiteText LIKE \'' . $Website . '%\'';
		
		$sql .= ' ORDER BY ' . $sort_column . ' ' . $sort_direction;

		if($Limited)
			$sql .= ' LIMIT 0, 10';
//print($sql);
		return ($this->db->query ($sql));
	}
}

/* End of file search.php */
/* Location: ./system/application/controllers/search.php */