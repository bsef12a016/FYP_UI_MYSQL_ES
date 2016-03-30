<?php

defined('BASEPATH') OR exit('No direct script access allowed');

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
define('DIR_WRITE_MODE', 0755);

/*
  |--------------------------------------------------------------------------
  | File Stream Modes
  |--------------------------------------------------------------------------
  |
  | These modes are used when working with fopen()/popen()
  |
 */

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

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
define('SHOW_DEBUG_BACKTRACE', TRUE);

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
define('EXIT_SUCCESS', 0); // no errors
define('EXIT_ERROR', 1); // generic error
define('EXIT_CONFIG', 3); // configuration error
define('EXIT_UNKNOWN_FILE', 4); // file not found
define('EXIT_UNKNOWN_CLASS', 5); // unknown class
define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
define('EXIT_USER_INPUT', 7); // invalid user input
define('EXIT_DATABASE', 8); // database error
define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code
//User Defined Constants

$ALLOW_LOGIN = TRUE;

//API KEY
define('API_KEY', 'AIzaSyAUstEMWunH22j5D0mpJatREDNcYpUCMrc');

//Admin
define('ADMINISTRATOR_CREDENTIAL_NAME', 'administrator');
define('ADMINISTRATOR_CREDENTIAL_STATUS', 'ADMINISTRATOR_CREDENTIAL_STATUS');
define('ADMINISTRATOR_CREDENTIAL_STATUS_TRUE', TRUE);
define('ADMINISTRATOR_CREDENTIAL_STATUS_FALSE', FALSE);



//Login
define('LOGIN_STATUS_TRUE', TRUE);
define('LOGIN_STATUS_FLASE', FALSE);
define('LOGIN_STATUS', 'LOGIN_STATUS');

//User
define('USER_ID', 'USER_ID');
define('USER_NAME', 'USER_NAME');
define('USER_DATA_SOURCE', 'USER_DATA_SOURCE');
define('MYSQL_DATA_SOURCE', 'MYSQL_DATA_SOURCE');
define('ES_DATA_SOURCE', 'ES_DATA_SOURCE');



//Project
define('PROJECT_ID', 'PROJECT_ID');
define('PROJECT_OPEN_STATUS', 'PROJECT_OPEN_STATUS');
define('PROJECT_OPEN_STATUS_TRUE', TRUE);
define('PROJECT_OPEN_STATUS_FALSE', FALSE);
define('PROJECT_APIKEY', 'PROJECT_APIKEY');


//Emails
define('USER_EMAIL_STATUS', 'USER_EMAIL_STATUS');
define('USER_EMAIL_STATUS_TRUE', TRUE);
define('USER_EMAIL_STATUS_FLASE', FALSE);
define('VISITOR_EMAIL_STATUS', 'USER_EMAIL_STATUS');
define('VISITOR_EMAIL_STATUS_TRUE', TRUE);
define('VISITOR_EMAIL_STATUS_FALSE', FALSE);


//Admin Dashboard
define('USER_COUNT', 'USER_COUNT');
define('PROJECTS_COUNT', 'PROJECTS_COUNT');
define('ERRORS_COUNT', 'ERRORS_COUNT');


define('SIGNIN_ERROR', 'Username or password is invalid');

//REST API Response
define('PROCEED', 'PROCEED');
define('ERROR', 'ERROR');




//MY SQL TABLE NAME COLUMN CONSTANTS
//PROJECTS
define('PROJECT_TABLE_ID', 'id');
define('PROJECT_TABLE_PROJECT_NAME', 'projectName');
define('PROJECT_TABLE_PROJECT_URL', 'project_url');
define('PROJECT_TABLE_API_KEY', 'api_key');
define('PROJECT_TABLE_ERRORS', 'errors');
define('PROJECT_TABLE_USER_ID', 'userID');
define('PROJECT_TABLE_CREATED_AT', 'created_at');



//ERRORS
define('ERRORS_TABLE_ID', 'id');
define('ERRORS_TABLE_CLASS', 'class');
define('ERRORS_TABLE_LAST_MESSAGE', 'last_message');
define('ERRORS_TABLE_RESOLVED', 'resolved');
define('ERRORS_TABLE_OCCURENCES', 'occurences');
define('ERRORS_TABLE_FIRST_RECIEVED', 'first_recieved');
define('ERRORS_TABLE_LAST_RECIEVED', 'last_recieved');
define('ERRORS_TABLE_API_KEY', 'api_key');
define('ERRORS_TABLE_LAST_CONTEXT', 'last_context');


//EVENTS
define('EVENTS_TABLE_ID', 'id');
define('EVENTS_TABLE_CLASS', 'class');
define('EVENTS_TABLE_MESSAGE', 'message');
define('EVENTS_TABLE_RECIEVED_AT', 'recieved_at');
define('EVENTS_TABLE_SEVERITY', 'severity');
define('EVENTS_TABLE_OS', 'os_version');
define('EVENTS_TABLE_IP', 'client_ip');
define('EVENTS_TABLE_URL', 'url');
define('EVENTS_TABLE_PROJECT_URL', 'project_url');
define('EVENTS_TABLE_BROWSER_NAME', 'browser_name');
define('EVENTS_TABLE_BROWSER_VERSION', 'browser_version');
define('EVENTS_TABLE_USER_AGENT', 'user_agent');
define('EVENTS_TABLE_LANGUAGE', 'language');
define('EVENTS_TABLE_FILE_URL', 'file_url');
define('EVENTS_TABLE_LINE_NUMBER', 'line_number');
define('EVENTS_TABLE_COLUMN_NUMBER', 'column_number');
define('EVENTS_TABLE_CONTEXT', 'context');
define('EVENTS_TABLE_API_KEY', 'api_key');
define('EVENTS_TABLE_ERROR_ID', 'error_id');
define('EVENTS_TABLE_LATTITUDE', 'latitude');
define('EVENTS_TABLE_LONGITUDE', 'longitude');
define('EVENTS_TABLE_COUNTRY', 'country');


