<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

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
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESCTRUCTIVE') OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


define('IS_LIVE', 1);

define('DB_HOST', 'localhost');
define('DB_USER', 'chemcali_student_portal_live');
define('DB_PASSWORD', 'CLrIGtGbRW$~;1B_#@Lg[^iL;IXl8(d1');
define('DB_MAIN_DATABASE', 'chemcali_student_portal_live');

define('DEFAULT_PASSWORD', 'Student@2023');

define('ENCRIPTION_KEY', "@#BUTTER#@");

define( 'COMPANY_NAME', 'MouryaEdu Student Portal');
define( 'COMPANY_EMAIL', 'info@chemcaliba.com');

//----   Email
define( 'SMTP_HOST', 'mail.chemcaliba.com');
define( 'SMTP_PORT', 587);
define( 'SMTP_USER', 'no-reply@chemcaliba.com');
define( 'SMTP_PASSWORD', 'Chemcaliba@2024$');
define( 'SMTP_FROM_NAME', 'ChemCaliba');

//----   SMS
define( 'SMS_USER', 'CHEMCALIBA');
define( 'API_KEY', 'F1F93-2D93F');
define( 'API_REQUEST', 'Text');
define( 'SMS_SENDER', 'CHMCAL');
define( 'SMS_ROUTE', 'TRANS');

//----   SMS TEMPLATES
define( 'NEW_REGISTRATION_TEMPLATE', '1007324100881740092');
define( 'COURSE_ENROLLMENT_TEMPLATE', '1007324771412549324');
define( 'NEW_COURSE_PUBLISHED_TEMPLATE', '1007963842678248112');
define( 'TEST_SCHEDULE_TEMPLATE', '1007397074191656958');
define( 'TEST_RESULT_TEMPLATE', '1007645741593283694');
define( 'PT_MEET_TEMPLATE', '1007261579205441965');
define( 'HOLIDAY_INFORMATION_TEMPLATE', '1007055498271287711');
define( 'ASSIGNMENT_UPDATE_TEMPLATE', '1007413476232052265');

//----   PASSWORD LENGTH
define( 'MIN_LENGTH_PASSWORD', 8);
define( 'MAX_LENGTH_PASSWORD', 16);

define( 'RESET_DEFAULT_PASSWORD', 'Chem@Edtech2023');

//----  RAZOR PAY
if(IS_LIVE){
    define( 'RAZOR_KEY_ID', 'rzp_live_2lAX6lqJQEb5yi');
    define( 'RAZOR_KEY_SECRET', 'lXB2UmzzQMZAcoeXGu5X5DxE');
}
else{
    define( 'RAZOR_KEY_ID', 'rzp_test_4OaRHILaXqcwlp');
    define( 'RAZOR_KEY_SECRET', 'v9cHLHTvEjtLQ1zBRYdyDSlY');
}
