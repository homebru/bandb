<?php
class SitePasswords extends Controller {


	function SitePasswords()
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

		$this->load->view('header_std');
		$this->load->view('sitepasswords');
		$this->load->view('footer_std');
	}
	
	function lookup()
	{
		if($this->get_password($_POST['SitePassword'])) {
			$this->load->helper('url');
			redirect('register');
		}
		//$this->index();
	}
	
	function get_password($password)
	{
		$query = $this->db->query ( 'SELECT COUNT(ID) as is_there
									FROM SitePasswords
									WHERE SitePassword = \''.$this->db->escape_like_str($password).'\'');

		$row = $query->row();
		if ($row->is_there > 0)
		{
			return true;
		}
		else
			return false;
	}

}
?>
