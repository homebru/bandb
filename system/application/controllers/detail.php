<?php

class Detail extends Controller {

	function Detail()
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
		
		$this->load->view('header_user');
		$this->load->view('detail');
		$this->load->view('footer_std');
	}
	
	function show($id)
	{
		
		// Set a few globals
		$data = array(
						'page_title' => 'Inn Strategy - Search',
					);

		$query = $this->get_BBData_SelectOne($id);
		$data['bbdata'] = $query->row();
		
		$UserID = '13baaeb6-1bba-4bad-8893-3f0bca64e274';
		$query = $this->get_ClientBBDataSelectOne($UserID, $id);
		$data['ad_log'] = $query->row();
		$data['ad_log_count'] = $query->num_rows();

//die(print_r($data));

		$this->load->vars($data);

		$this->load->helper('url');
		$this->load->helper('html');
		
		$this->load->view('header_user');
		$this->load->view('detail');
		$this->load->view('footer_std');
	}
	
	function get_BBData_SelectOne($id)
	{
		$sql =  'SELECT COALESCE(BBData.WebsiteText, \'\') AS WebsiteText, COALESCE(BBData.Website, \'\') AS Website, BBData.BBDataId, 
				COALESCE(BBData.PricingPageText, \'\') AS PricingPageText, COALESCE(BBData.PricingPageURL, \'\') AS PricingPageURL, COALESCE(BBData.LogonPageText, \'\') 
				AS LogonPageText, COALESCE(BBData.LogonPageURL, \'\') AS LogonPageURL, COALESCE(BBData.EditMethod, \'\') AS EditMethod, 
				COALESCE(BBData.IndexPageURL, \'\') AS IndexPageURL, COALESCE(BBData.Affliation, \'\') AS Affliation, COALESCE(BBData.Classification, \'\') AS Classification, 
				COALESCE(BBData.LastUpdated, \'\') AS LastUpdated, COALESCE(BBData.Price, Null) AS Price, COALESCE(BBData.PriceType, \'\') AS PriceType, 
				COALESCE(BBData.UserReview, \'\') AS UserReview, COALESCE(BBData.IndexByGoogle, \'\') AS IndexByGoogle, COALESCE(BBData.IndexByYahoo, \'\') 
				AS IndexByYahoo, COALESCE(BBData.IndexByMSN, \'\') AS IndexByMSN, COALESCE(BBData.GeoSpecificity, \'\') AS GeoSpecificity, COALESCE(BBData.Notes, \'\') 
				AS Notes, COALESCE(BBData.PaymentAccepted, \'\') AS PaymentAccepted, COALESCE(BBData.Terms, \'\') AS Terms, COALESCE(BBData.Contact, \'\') AS Contact, 
				COALESCE(BBData.EmailSales, \'\') AS EmailSales, COALESCE(BBData.EmailSupport, \'\') AS EmailSupport, COALESCE(BBData.RegularPhone, \'\') AS RegularPhone,
				COALESCE(BBData.TollFreePhone, \'\') AS TollFreePhone, COALESCE(BBData.QuantcastCurrent, 0) AS QuantcastCurrent, 
				COALESCE(BBData.QuantcastCurrentDataDate, Null) AS QuantcastCurrentDataDate, COALESCE(BBData.QuantcastPrevious, 0) AS QuantcastPrevious, 
				COALESCE(BBData.QuantcastChange, 0) AS QuantcastChange, COALESCE(BBData.CompeteCurrent, 0) AS CompeteCurrent, 
				COALESCE(BBData.CompeteCurrentDataDate, Null) AS CompeteCurrentDataDate, COALESCE(BBData.CompetePrevious, 0) AS CompetePrevious, 
				COALESCE(BBData.CompeteChange, 0) AS CompeteChange, COALESCE(BBData.Rating, Null) AS Rating, COALESCE(an.AdminNote, \'\') AS AdminNote, 
				COALESCE(BBData.BBListSpecials, \'\') AS BBListSpecials, COALESCE(BBData.ListingRequirements, \'\') AS ListingRequirements, COALESCE(BBData.Specials, \'\') 
				AS Specials, COALESCE(BBData.Contact1Title, \'\') AS Contact1Title, COALESCE(BBData.Contact2, \'\') AS Contact2, COALESCE(BBData.Contact2Title, \'\') 
				AS Contact2Title, COALESCE(BBData.Contact2RegularPhone, \'\') AS Contact2RegularPhone, COALESCE(BBData.Contact2TollFreePhone, \'\') 
				AS Contact2TollFreePhone, COALESCE(BBData.CancellationPolicy, \'\') AS CancellationPolicy, COALESCE(BBData.SpecialPageURL, \'\') AS SpecialPageURL, 
				COALESCE(BBData.QuantPageURL, \'\') AS QuantPageURL, COALESCE(BBData.CompetePageURL, \'\') AS CompetePageURL, COALESCE(BBData.Quantified, \'\') 
				AS Quantified, Classification.ClassficationID, COALESCE(EditMethod.Method,\'\') as Method, COALESCE(Classification.ClassficationText,\'\') as ClassficationText , 
				COALESCE(PriceType.PriceTypeText,\'\') as PriceTypeText, COALESCE(LinkType.LinkTypeText,\'\') as LinkTypeText,
				COALESCE(BBData.MaxPR, \'\') AS MaxPR,
				COALESCE(BBData.LinkPR, \'\') AS LinkPR,
				COALESCE(BBData.AdPackage, \'\') AS AdPackage,
				COALESCE(BBData.LinkType, \'\') AS LinkType,
				COALESCE(BBData.BBCategory, \'\') AS BBCategory,
				COALESCE(BBData.Score, \'\') AS Score
				FROM BBData LEFT OUTER JOIN
									  PriceType ON BBData.PriceType = PriceType.PriceID LEFT OUTER JOIN
									  EditMethod ON BBData.EditMethod = EditMethod.MethodID LEFT OUTER JOIN
									  LinkType ON BBData.LinkType= LinkType.LinkTypeID LEFT OUTER JOIN
									  Classification ON BBData.Classification = Classification.ClassficationID LEFT OUTER JOIN
									  AdminNotes AS an ON BBData.BBDataId = an.BBDataId
				WHERE     (BBData.BBDataId = ' . $id . ') LIMIT 0, 1';

//print($sql);
	return ($this->db->query($sql));

	}
	
	function get_ClientBBDataSelectOne($UserID, $BBDataID)
	{
		$sql = 'SELECT ClientBBDataID, UserID, BBDataId, COALESCE(Price, \'\') AS Price, COALESCE(DateExpires, \'\') AS DateExpires, COALESCE(Password, \'\') AS Password, 
				COALESCE(UserName, \'\') AS UserName, COALESCE(ListingType, \'\') AS ListingType, COALESCE(SiteLocation, \'\') AS SiteLocation, COALESCE(Comments, \'\') AS Comments
				FROM ClientBBData
				WHERE (UserID = \'' . $UserID . '\') AND (BBDataId = ' . $BBDataID . ')';

//print($sql);
	return ($this->db->query($sql));
	}
}

/* End of file detail.php */
/* Location: ./system/application/controllers/detail.php */