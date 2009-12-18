<?php

class Publishers extends Controller {

	function Publishers()
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
		$this->load->helper('form');
		$this->load->library('ajax');
		
		$this->load->view('header_std');
		$this->load->view('publishers');
		$this->load->view('footer_std');
		
	}
	
	function find()
	{
		//$record_id = $_POST['txtSearch'];
		$record_id = $_POST['website'];
		
		$record_id = preg_replace('/^www./i', '', $record_id);
		
		$this->load->model('bbdata');
		//$this->db->where('WebsiteText',$record_id);
		$results = $this->bbdata->get_website($record_id);
		$this->load->view('AJAX_find_publisher', $results);
		//$this->index();
	}
	
	function add()
	{
		$this->load->helper('date');
		$dt = date("Y-m-d H:i:s");
		
		$QuantPageURL  = 'http://www.quantcast.com/'.$this->db->escape($_POST['txtWebsite']);
		$CompetePageURL = 'http://siteanalytics.compete.com/'.$this->db->escape($_POST['txtWebsite']).'/?metric=uv';

		$sql = "INSERT INTO BBData (WebsiteText, PricingPageURL, LogonPageURL, UserReview, BBListSpecials, Quantified, Contact, 
							Contact1Title, EmailSales, TollFreePhone, RegularPhone, Notes, LastUpdated, Classification)
		VALUES (".$this->db->escape($_POST['txtWebsite']).", ".$this->db->escape($_POST['txtPricingURL']).", ".$this->db->escape($_POST['txtLogonURL'])
				.", ".$this->db->escape($_POST['rblUserReview']).", ".$this->db->escape($_POST['rblBBListSpecials']).", ".$this->db->escape($_POST['rblQuantified'])
				.", ".$this->db->escape($_POST['txtContact']).", ".$this->db->escape($_POST['txtTitle']).", ".$this->db->escape($_POST['txtEmail'])
				.", ".$this->db->escape($_POST['txtTollFree']).", ".$this->db->escape($_POST['txtPhone']).", ".$this->db->escape($_POST['txtNotes']).", ".$this->db->escape($dt).", 83)";
		$this->db->query($sql);
		
		$row_id = $this->db->insert_id();
		
		$sql = "INSERT INTO AdminNotes (BBDataId, DateCreated) VALUES (".$row_id.", ".$this->db->escape($dt).")";
		$this->db->query($sql);
			
		$this->send_add_email($_POST['txtEmail'], $_POST['txtWebsite']);
		
		$this->load->view('AJAX_add_publisher');
	}
	
	function send_add_email($txtEmail, $txtWebsite)
	{
		
		$this->load->library('email');

		$bodyMsg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\r\n
		<html xmlns="http://www.w3.org/1999/xhtml">\r\n
		<head>\r\n
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />\r\n
		<title>Thank You</title>\r\n
		</head>\r\n
		
		<body>\r\n
		Hello.
		<br /><br />
		Thanks for submitting your site.
		<br /><br />
		Evaluating online advertising opportunities in the lodging industry is our core business.
		<br /><br />
		The <span style="color:black;font-weight:bold;">InnStrategy.com</span> <span style="color:black;font-weight:bold;">Online Advertising Database</span> is made available as an annual subscription service ($399) to Bed and Breakfast innkeepers and Vacation Rental owners. 
		<br /><br />
		Lodging properties that use the Internet to increase room bookings comprise our main customer base. 
		<br /><br />
		Software Benefit - Our web-based service enables online marketers to actively manage their online advertising buys.  
		<br /><br />
		Advertising Benefit - We evaluate online advertising opportunities so that our subscribers get more Bang for their online advertising Buck.  
		<br /><br />
		As a publisher, your InnStrategy.com listing is FREE.  
		<br /><br />
		You can view a small portion of our database at <a href="http://www.innstrategy.com/login">http://www.innstrategy.com/login</a>.
		<br /><br />
		Logon information - User name = <b>demo</b>  &nbsp;&nbsp;  Password = <b>12345</b>
		<br /><br />
		Here are a few links for additional info:
		<br /><br />
		About us - <a href="http://www.innstrategy.com/about_us">http://www.innstrategy.com/about_us</a>
		<br /><br />
		Our Internet Advertising blog -  <a href="http://www.innstrategy.com/blogengine">http://www.innstrategy.com/blogengine</a>
		<br /><br />
		Thanks, and we look forward to learning more about you,
		<br /><br />
		D.R.
		<br />
		Inn Strategy - Online Advertising Intelligence
		<br />
		InnStrategy.com
		<br />
		San Diego, CA
		<br />
		<br />
		<br />
		</body>\r\n
		</html>';
		
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		
		$this->email->from('dr@innstrategy.com', 'Inn Strategy');
		$this->email->to($txtEmail);
		//$this->email->cc('another@another-example.com'); 
		$this->email->bcc('dr@innstrategy.com'); 
		
		$this->email->subject("Inn Strategy - $txtWebsite is now added!");
		$this->email->message($bodyMsg);
		
		$this->email->send();

	}
	
	function validUrl($host, $page =‘/’, $port=80) 
	{
	//server connection
	$fp= fsockopen($host,$port,$errno, $errstr, 30);
	if ($fp) {//ok, we are connected
		//lets create the HTTP header to send
		$header = "GET $page HTTP/1.0\r\n";
		$header .= "Connection: Close\r\n\r\n";
 
		//sending it
		fwrite($fp, $header);
 
		//getting server response (just one line)
		$ret=fgets($fp);
 
		//see if we got an 200 OK status
		if (ereg(‘200 OK’,$ret)) {
			fclose($fp);
			return true;
		}
		fclose($fp);
	}
	return false;
	}
	
}

/* End of file publishers.php */
/* Location: ./system/application/controllers/publishers.php */