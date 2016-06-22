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
| API URIs
|--------------------------------------------------------------------------
|
| These URIs are used to access the API
|
*/
define('INVOICES_GET_URL', 'api/v1/invoices');
define('INVOICE_POST_URL', 'api/v1/invoices');
define('INVOICE_PUT_URL', 'api/v1/invoices');
define('INVOICE_INFO_URL', 'api/v1/invoices/id/');
define('INVOICE_ITEMS_POST_URL','api/v1/items');

define('USERS_GET_URL', 'api/example/users');
define('PAYMENTS_GET_URL', 'api/example/payments');
define('PAYMENTS_POST_URL', 'api/example/payments');
define('USER_BY_ID_URL', 'api/example/user/');
define('USER_ADD_URL', 'api/example/payment/');



define('UPDATE_URL', 'http://gitbench.com/updates/');


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


/* End of file constants.php */
/* Location: ./application/config/constants.php */