<?php

class Admin extends Application
{
	function Admin()
	{
		parent::Application();
	}
	
	function index()
	{
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('form');

		if(logged_in())
		{
			$this->auth->view('dashboard');
		}
		else
		{
			$this->auth->login();
		}
	}

	function edit()
	{
		$data = array(
						'page_title' => 'Inn Strategy : Password Change'
					);

		$this->load->vars($data);

		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('form_validation');

		if(logged_in())
		{			
			$this->form_validation->set_rules('Password', 'Password', 'trim|required|matches[ConfirmPassword]|min_length[4]|max_length[12]');
			$this->form_validation->set_rules('ConfirmPassword', 'Password Confirmation', 'trim|required');
					
			if ($this->form_validation->run() == FALSE)
				{
	
					$this->load->view('header_user');
					$this->load->view('auth/change_password');
					$this->load->view('footer_std');
				}
			else
				{
					$this->update_password($_POST['Password']);
					$data['msg'] = "<p><strong>Your login Password has been successfully changed.</strong></p>
									<p>You will receive a confirmation email shortly.</p>";
									
					$this->load->vars($data);
					$this->load->view('header_user');
					$this->load->view('auth/change_password');
					$this->load->view('footer_std');
				}
				
		}
		else
		{
			$this->auth->login();
		}
	}
	
	function update_password($pswd)
	{
		$uncrypt_password = set_value($pswd);
		$password = $this->_salt(set_value($pswd));
		$userID = userID();
					
		$user_table = user_table();
		$this->db->query("UPDATE `$user_table` SET `password` = '$password' WHERE `UserID` = '$userID'");
		$userdata = $this->db->query("SELECT * FROM `$user_table` WHERE `UserID` = '$userID'");
		$result = $userdata->row();

		$this->send_change_email($result->username, $uncrypt_password, $result->email);
		
	}
	
	function forgot()
	{
		$data = array(
						'page_title' => 'Inn Strategy - Forgot Password',
					);
		$this->load->vars($data);
		$this->form_validation->set_rules('Email', 'Email', 'trim|required|valid_email|callback_forgot_email_check');
		
		if ($this->form_validation->run() == FALSE)
			{

				//$this->load->view('auth/header');
				$this->load->view('header_user');
				$this->load->view('auth/forgot_password');
				$this->load->view('footer_std');
			}
		else
			{
				$this->set_forgotten_password($_POST['Email']);
				$data['msg'] = "<p><strong>Your login Password has been successfully reset.</strong></p>
								<p>You will receive an email shortly with the details of your new login.</p>";
							
				$this->load->vars($data);

				//$this->load->view('auth/header');
				$this->load->view('header_user');
				$this->load->view('auth/forgot_password');
				$this->load->view('footer_std');
		
			}
	}
	
	function set_forgotten_password($email)
	{
		$length = 8;
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$uncrypt_password = '';    
		for ($i = 0; $i < $length; $i++) {
			$uncrypt_password .= $characters[mt_rand(0, strlen($characters)-1)];
		}
		$password = $this->_salt(set_value($uncrypt_password));
		
		$user_table = user_table();
		$this->db->query("UPDATE `$user_table` SET `password` = '$password' WHERE `email` = '$email'");
		$userdata = $this->db->query("SELECT * FROM `$user_table` WHERE `email` = '$email'");
		$result = $userdata->row();

		$this->send_forgot_email($result->username, $uncrypt_password, $result->email);
	}
	
	function _salt($str)
	{
		return sha1($this->config->item('encryption_key').$str);
	} // function _salt()
	

	function send_change_email($username, $password, $email)
	{
	
	$this->load->library('email');

	$bodyMsg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\r\n
	<html xmlns="http://www.w3.org/1999/xhtml">\r\n
	<head>\r\n
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />\r\n
	<title>Innstrategy Password Change</title>\r\n
	</head>\r\n
	
	<body>\r\n
	You or someone using your InnStrategy account have requested a change of password for your account.
	<br /><br />
	Your new login details are as follows:
	<br /><br />
	UserName: '.$username.'
	<br /><br />
	Password: '.$password.'
	<br /><br />
	Registered Email: '.$email.'
	<br />
	<br />
	</body>\r\n
	</html>';
	
	$config['mailtype'] = 'html';
	$this->email->initialize($config);
	
	$this->email->from($this->config->item('email_from'), 'Inn Strategy');
	$this->email->to($email);
	//$this->email->cc('another@another-example.com'); 
	$this->email->bcc($this->config->item('email_from')); 
	
	$this->email->subject("Inn Strategy - Account Change Information");
	$this->email->message($bodyMsg);
	
	$this->email->send();

	}

	function send_forgot_email($username, $password, $email)
	{
	
	$this->load->library('email');

	$bodyMsg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\r\n
	<html xmlns="http://www.w3.org/1999/xhtml">\r\n
	<head>\r\n
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />\r\n
	<title>Innstrategy Password Change</title>\r\n
	</head>\r\n
	
	<body>\r\n
	You or someone using your InnStrategy account have requested that your password be reset for your InnStrategy account.
	<br /><br />
	Your new login details are as follows:
	<br /><br />
	UserName: '.$username.'
	<br /><br />
	Password: '.$password.'
	<br /><br />
	Registered Email: '.$email.'
	<br />
	<br />
	</body>\r\n
	</html>';
	
	$config['mailtype'] = 'html';
	$this->email->initialize($config);
	
	$this->email->from($this->config->item('email_from'), 'Inn Strategy');
	$this->email->to($email);
	//$this->email->cc('another@another-example.com'); 
	$this->email->bcc($this->config->item('email_from')); 
	
	$this->email->subject("Inn Strategy - Account Change Information");
	$this->email->message($bodyMsg);
	
	$this->email->send();

	}

}

/* End of file: admin.php */
/* Location: application/controllers/admin/admin.php */