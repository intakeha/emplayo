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
|	example.com/class/method/id/
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
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

//$route['default_controller'] = "emplayo";//chon's setting
//$route['default_controller'] = "home";//brad's orig setting
$route['default_controller'] = "home";
$route['404_override'] = 'emplayo404';
$route['login'] = 'user/login';
$route['signup'] = 'user/signup';
$route['forgot'] = 'user/forgot_password';
$route['change'] = 'user/change_password';
$route['logout'] = 'user/logout';
$route['company'] = 'company';
$route['admin'] = 'admin/home';
$route['employers'] = 'about/employers';
$route['contact'] = 'about/contact';
$route['terms'] = 'about/terms';
$route['privacy'] = 'about/privacy';
$route['ambassadors'] = 'about/ambassadors';
$route['company/(:any)'] = 'company/profile/$1';

/* End of file routes.php */
/* Location: ./application/config/routes.php */