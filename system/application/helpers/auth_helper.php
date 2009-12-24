<?php

function logged_in()
{
	$CI =& get_instance();
	if($CI->auth->logged_in() == TRUE)
	{
		return TRUE;
	}
	
	return FALSE;
}

function username()
{
	$CI =& get_instance();
	return $CI->session->userdata('username');
}

function userID()
{
	$CI =& get_instance();
	return $CI->session->userdata('UserID');
}

function set_userID($userID)
//This function is used to push our demo user's id 
//into the system for the demo functions
{
	$CI =& get_instance();
	$data = array(
			'UserID' => $userID
			);
	$CI->session->set_userdata($data);
}

function user_group($group)
{
	$CI =& get_instance();
	
	$system_group = $CI->auth->config['auth_groups'][$group];
	
	if($system_group === $CI->session->userdata('group_id'))
	{
		return TRUE;
	}
}

function user_table()
{
	$CI =& get_instance();
	
	return $CI->auth->user_table;
}

function group_table()
{
	$CI =& get_instance();
	
	return $CI->auth->group_table;
}

?>