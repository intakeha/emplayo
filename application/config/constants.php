<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/*
|--------------------------------------------------------------------------
| Application Paths
|--------------------------------------------------------------------------
|!!FOR NEW PATHS, BE SURE THE .htaccess FILE IS UPDATED TO ALLOW ACCESS TO THE PATH!!
|Also, remember that paths need to be specified differently in the view vs. the controller.
*/
define('COMPANY_LOGO_PATH', 'uploads/images/company_logos/');
define('COMPANY_LOGO_TEMP_PATH', 'uploads/images/company_logos/temp/');
define('PROFILE_PIC_PATH', 'uploads/images/company_profile_pics/');
define('PROFILE_PIC_TEMP_PATH', 'uploads/images/company_profile_pics/temp/');

/* End of file constants.php */
/* Location: ./application/config/constants.php */