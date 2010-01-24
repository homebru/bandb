<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
| 	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['scaffolding_trigger'] = 'scaffolding';
|
| This route lets you set a "secret" word that will trigger the
| scaffolding feature for added security. Note: Scaffolding must be
| enabled in the controller in which you intend to use it.   The reserved 
| routes must come before any wildcard or regular expression routes.
|
*/

$route['default_controller'] = "home";
$route['scaffolding_trigger'] = "maintain";

// BEGIN AUTHENTICATION LIBRARY ROUTES
$route['login'] = "admin/admin/login";
$route['logout'] = "admin/admin/logout";
$route['register'] = "admin/admin/register";
$route['change'] = "admin/admin/edit";
$route['forgot'] = "admin/admin/forgot";
$route['admin/dashboard'] = "admin/admin/index";
// END AUTHENTICATION LIBRARY ROUTES

$route['search/demo'] = "search";
$route['search/my'] = "search";
$route['search/demo/my'] = "search";
$route['search/my/(:any)'] = "search";

$route['detail/(:num)'] = "detail/show/$1";

$route['profile'] = "profile/edit";
$route['profile/demo'] = "profile/edit";

// Admin Screens
$route['maintenance/(:any)'] = "$1/maintain";
$route['maintenance'] = "pricetype/maintain";
$route['users'] = "client_search";
$route['client_detail/(:any)'] = "client_detail/edit/$1";
$route['admin_detail/(:num)'] = "admin_detail/edit/$1";
$route['admin_scripts'] = "admin_scripts/edit";

/* End of file routes.php */
/* Location: ./system/application/config/routes.php */