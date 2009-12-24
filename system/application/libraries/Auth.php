<?php
ob_start();
/**
* The Authentication Library
*
* @package Authentication
* @category Libraries
* @author Adam Griffiths
* @link http://adamgriffiths.co.uk
* @version 1.0.6
* @copyright Adam Griffiths 2009
*
* Auth provides a powerful, lightweight and simple interface for user authentication 
*/

class Auth
{
	
	var $CI; // The CI object
	var $config; // The config items
	var $user_table; // The user table (prefix + config)
	var $group_table; // The group table (prefix + config)
	
	/** 
	* Auth constructor
	*
	* @access public
	* @param string
	*/
	function Auth($config)
	{
		$this->CI =& get_instance();
		$this->config = $config;
		
		$this->CI->load->database();
		$this->CI->load->helper(array('form', 'url', 'email'));
		$this->CI->load->library('form_validation');
		$this->CI->load->library('session');
		
		$this->CI->lang->load('auth', 'english');
		
		$this->CI->form_validation->set_error_delimiters('<p class="error">', '</p>');
		
		$this->user_table = $this->CI->db->dbprefix($this->config['auth_user_table']);
		$this->group_table = $this->CI->db->dbprefix($this->config['auth_group_table']);
		
		if($this->logged_in())
		{
			$this->_verify_cookie();
		}
		else
		{
			if(!array_key_exists('login_attempts', $_COOKIE))
			{
				setcookie("login_attempts", 0, time()+900, '/');
			}
		}
	} // function Auth()
	
	/** 
	* Restricts access to a page
	*
	* Takes a user level (e.g. admin, user etc) and restricts access to that user and above.
	* Example, users can access a profile page, but so can admins (who are above users)
	*
	* @access public
	* @param string
	* @return bool
	*/
	function restrict($group = NULL, $single = NULL)
	{
		if($group === NULL)
		{
			if($this->logged_in() == TRUE)
			{
				return TRUE;
			}
			else
			{
				show_error($this->CI->lang->line('insufficient_privs'));
			}
		}
		elseif($this->logged_in() == TRUE)
		{
			$level = $this->config['auth_groups'][$group];
			$user_level = $this->CI->session->userdata('group_id');
			
			if($user_level > $level OR $single == TRUE && $user_level !== $level)
			{
				show_error($this->CI->lang->line('insufficient_privs'));
			}
			
			return TRUE;
		}
		else
		{
			redirect($this->config['auth_incorrect_login'], 'refresh');
		}
	} // function restrict()
	
	
	/** 
	* Log a user in
	*
	* Log a user in a redirect them to a page specified in the $redirect variable
	*
	* @access public
	* @param string
	*/
	function login($redirect = NULL)
	{
		if($redirect === NULL)
		{
			$redirect = $this->config['auth_login'];
		}

			
		$this->CI->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|max_length[40]|callback_username_check');
		$this->CI->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[12]');
		$this->CI->form_validation->set_rules('remember', 'Remember Me');

		if($this->CI->form_validation->run() == FALSE)
		{
			if((array_key_exists('login_attempts', $_COOKIE)) && ($_COOKIE['login_attempts'] >= 5))
			{
				echo $this->CI->lang->line('max_login_attempts_error');
			}
			else
			{
				$this->view('login');
			}
		}
		else
		{
			$username = set_value('username');
			$auth_type = $this->_auth_type($username);
			$password = $this->_salt(set_value('password'));
			$email = set_value('email');

			if(!$this->_verify_details($auth_type, $username, $password))
			{
				show_error($this->CI->lang->line('login_details_error'));
				$redirect = $this->config['auth_incorrect_login'];
				redirect($redirect);
			}

			$userdata = $this->CI->db->query("SELECT * FROM `$this->user_table` WHERE `$auth_type` = '$username'");
			$row = $userdata->row_array();

			$data = array(
						$auth_type => $username,
						'username' => $row['username'],
						'user_id' => $row['id'],
						'group_id' => $row['group_id'],
						'logged_in' => TRUE,
						'UserID' => $row['UserID']
						);
			$this->CI->session->set_userdata($data);

			if($this->config['auth_remember'] === TRUE)
			{
				$this->_generate();
			}

			redirect($redirect);
		}
	} // function login()
	
	
	/** 
	* Logout - logs a user out
	*
	* @access public
	*/
	function logout()
	{
		$this->CI->session->sess_destroy();
		$this->view('logout');
	} // function logout()
	
	
	/** 
	* Register a new user
	*
	* Register a user and redirect them to the success page
	*
	* @access public
	* @param bool whether or not the user should be logged in once account is created, used in admin panel
	* @param bool whether or not the user is simply being edited, used in admin panel
	* @param string the user ID to be edited, used in the admin panel
	*/
	function register($login = FALSE, $edit = FALSE, $id = NULL)
	{
		if($edit === TRUE)
		{
			$this->CI->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_reg_email_check');
		}
		else
		{
			$this->CI->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|max_length[40]|callback_reg_username_check');
			$this->CI->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[12]|matches[conf_password]');
			$this->CI->form_validation->set_rules('conf_password', 'Password confirmation', 'trim|required|min_length[4]|max_length[12]|matches[password]');
			$this->CI->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_reg_email_check');
		}
		
		if($this->CI->form_validation->run() == FALSE)
		{
			if($edit === TRUE)
			{
				$query = $this->CI->db->query("SELECT * FROM `$this->user_table` WHERE `id` = '$id'");
				$result = $query->result_array();
				
				$this->view('register', $result[0]);
			}
			else
			{
				$this->view('register');
			}
		}
		else
		{
			
			$username = set_value('username');
			$uncrypt_password = set_value('password');
			$password = $this->_salt(set_value('password'));
			$email = set_value('email');
			
			// InnStrategy's legacy .Net system used the .Net Authorization system
			// which, in turn, uses GUIDs as user IDs.
			// The simplest way to bridge between legacy .Net data and this
			// application port is to add a GUID field to our Authorization system
			// and make the GUID (UserID) freely available to any Model/View/Controller
			// that may have need to use it (e.g. many of the leagcy queries that this
			// port uses specify a relation to a UserID parameter).
			$UserID = $this->CreateGUID();

			if($edit === TRUE)
			{
				$this->CI->db->query("UPDATE `$this->user_table` SET `email` = '$email' WHERE `id` = '$id'");
				$data2['msg'] = "The user has now been edited.";
			}
			else
			{				
				$this->CI->load->helper('url');
				
				$this->CI->db->query("INSERT INTO `$this->user_table` (username, email, password, UserID) VALUES ('$username', '$email', '$password', '$UserID')");

				$row_id = $this->CI->db->insert_id();
				$this->send_add_email($row_id, $username, $uncrypt_password, $email);

				$data2['msg'] = "<p><strong>Thank you for creating your account.</strong></p>
								<p>You will receive an activation email shortly.&nbsp; Everything you need is contained
                                in that email. There will be an account activation link in that email plus the user
                                name and password that you just entered. Thank you for becoming our newest member.</p>
								<p>Click the Continue button to be taken to our Blog page to read the tips, comments and information.</p>
								<div style='text-align:center; width:100%'>
									<input type='button' value='Continue' onclick='javascript:window.location=\"".base_url()."blog\"' />
								</div>";
			}
			
			if($login === TRUE)
			{
				$data2['msg'] = "The user has been created, you have now been logged in.";
				
				$userdata = $this->CI->db->query("SELECT * FROM `$this->user_table` WHERE `username` = '$username'");
				$row = $userdata->row_array();
			
				$data = array(
						'username' => $username,
						'user_id' => $row['id'],
						'group_id' => $row['group_id'],
						'logged_in' => TRUE
						);
				$this->CI->session->set_userdata($data);
			
				if($this->config['auth_remember'] === TRUE)
				{
					$this->_generate();
				}
			}
			
			$this->view('reg_success', $data2);
		}
	} // function register()

	
	/** 
	* Check to see if a user is logged in
	*
	* Look in the session and return the 'logged_in' part
	*
	* @access public
	* @param string
	*/
	function logged_in()
	{
		if($this->CI->session->userdata('logged_in') == TRUE)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	} // function logged_in()


	/** 
	* Check to see if a user is logging in with their username or their email
	*
	* @access private
	* @param string
	*/
	function _auth_type($str)
	{
		if(valid_email($str))
		{
			return 'email';
		}
		else
		{
			return 'username';
		}
	} // function _auth_type()
	
	
	/** 
	* Salt the users password
	*
	* @access private
	* @param string
	*/
	function _salt($str)
	{
		return sha1($this->CI->config->item('encryption_key').$str);
	} // function _salt()
	
	
	/** 
	* Verify that their username/email and password is correct
	*
	* @access private
	* @param string
	*/
	function _verify_details($auth_type, $username, $password)
	{
		$query = $this->CI->db->query("SELECT * FROM `$this->user_table` WHERE `$auth_type` = '$username' AND `password` = '$password'");
		
		if($query->num_rows != 1)
		{
			$attempts = $_COOKIE['login_attempts'] + 1;
			setcookie("login_attempts", $attempts, time()+900, '/');
			return FALSE;
		}
		
		return TRUE;
	} // function _verify_details()
	
	
	/** 
	  * Generate a new token/identifier from random.org
	  *
	  * @access private
	  * @param string
	  */
	  function _generate()
	  {
	    $username = $this->CI->session->userdata('username');

	    $rand_url = 'http://random.org/strings/?num=1&len=20&digits=on&upperalpha=on&loweralpha=on&unique=on&format=plain&rnd=new';

	    if (ini_get('allow_url_fopen')) {
	      // Grab the random string using the easy version if we can
	      $token_source = fopen($rand_url, "r");
	      $token = fread($token_source, 20);
	    } elseif (function_exists('curl_version')) {
	      // No easy version, so try cURL
	      $ch = curl_init();
	      curl_setopt($ch, CURLOPT_URL, $rand_url);
	      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	      $token = curl_exec($ch);
	      curl_close($ch);
	    } else {
	      // No love either way, generate a random string ourselves
	      $length = 20;
	        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	        $token = ”;    
	        for ($i = 0; $i < $length; $i++) {
	            $token .= $characters[mt_rand(0, strlen($characters)-1)];
	        }
	    }

	    $identifier = $username . $token;
	    $identifier = $this->_salt($identifier);

	    $this->CI->db->query("UPDATE `$this->user_table` SET `identifier` = '$identifier', `token` = '$token' WHERE `username` = '$username'");

	    setcookie("logged_in", $identifier, time()+3600, '/');
	  }
	
	
	/** 
	* Verify that a user has a cookie, if not generate one. If the cookie doesn't match the database, log the user out and show them an error.
	*
	* @access private
	* @param string
	*/
	function _verify_cookie()
	{
		if((array_key_exists('login_attempts', $_COOKIE)) && ($_COOKIE['login_attempts'] >= 5))
		{
			$username = $this->CI->session->userdata('username');
			$userdata = $this->CI->db->query("SELECT * FROM `$this->user_table` WHERE `username` = '$username'");
			
			$result = $userdata->row();

			$identifier = $result->username . $result->token;
			$identifier = $this->_salt($identifier);
			
			if($identifier !== $_COOKIE['logged_in'])
			{
				$this->CI->session->sess_destroy();
				
				show_error($this->CI->lang->line('logout_perms_error'));
			}
		}
		else
		{
			$this->_generate();
		}
	}
	
	/** 
	* Load an auth specific view
	*
	* @access private
	* @param string
	*/
	function view($page, $params = NULL)
	{
		if($params !== NULL)
		{
			$data['data'] = $params;
		}
		
		$data['page'] = $page;
		$this->CI->load->view($this->config['auth_views_root'].'index', $data);
	}
	
	function send_add_email($row_id, $username, $password, $email)
	{
	
	$this->CI->load->library('email');

	$bodyMsg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\r\n
	<html xmlns="http://www.w3.org/1999/xhtml">\r\n
	<head>\r\n
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />\r\n
	<title>Thank You</title>\r\n
	</head>\r\n
	
	<body>\r\n
	Thank you for creating an account.
	<br /><br />
	Please follow this link to activate:
	<br /><br />
	<a href="'.base_url().'activate?ID='.$row_id.'">Activate Your Account</a>
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
	$this->CI->email->initialize($config);
	
	$this->CI->email->from($this->config->item('email_from'), 'Inn Strategy');
	$this->CI->email->to($email);
	//$this->email->cc('another@another-example.com'); 
	$this->CI->email->bcc($this->config->item('email_from')); 
	
	$this->CI->email->subject("Inn Strategy - Account Information");
	$this->CI->email->message($bodyMsg);
	
	$this->CI->email->send();

	}

	function CreateGUID()
/*  CreateGUID is used to return a unique ID to use as an index
    in the database.  It is a maximum length string of 35.  It uses
    the PHP command uniqid to create a 23 character string appended
    to the IP address of the client without periods.                */
    {
    //Append the IP address w/o periods to the front of the unique ID
    $varGUID = str_replace('.', '', uniqid($_SERVER['REMOTE_ADDR'], TRUE));
	
	$s = strtoupper(md5($varGUID)); 
    $varGUID = 
        substr($s,0,8) . '-' . 
        substr($s,8,4) . '-' . 
        substr($s,12,4). '-' . 
        substr($s,16,4). '-' . 
        substr($s,20); 

   
    //Return the GUID as the function value
    return $varGUID;
    }
	
} // class Auth

?>