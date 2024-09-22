<?php

/*
 | --------------------------------------------------------------------
 | App Namespace
 | --------------------------------------------------------------------
 |
 | This defines the default Namespace that is used throughout
 | CodeIgniter to refer to the Application directory. Change
 | this constant to change the namespace that all application
 | classes should use.
 |
 | NOTE: changing this will require manually modifying the
 | existing namespaces of App\* namespaced-classes.
 */
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');

/*
 | --------------------------------------------------------------------------
 | Composer Path
 | --------------------------------------------------------------------------
 |
 | The path that Composer's autoload file is expected to live. By default,
 | the vendor folder is in the Root directory, but you can customize that here.
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

/*
 |--------------------------------------------------------------------------
 | Timing Constants
 |--------------------------------------------------------------------------
 |
 | Provide simple ways to work with the myriad of PHP functions that
 | require information to be in seconds.
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2592000);
defined('YEAR')   || define('YEAR', 31536000);
defined('DECADE') || define('DECADE', 315360000);

/*
 | --------------------------------------------------------------------------
 | Exit Status Codes
 | --------------------------------------------------------------------------
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
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

defined('EMAIL_FROM')      || define('EMAIL_FROM', 'karthik.hbk24@gmail.com'); 
defined('FROM_NAME')      || define('FROM_NAME', 'Audit Survey'); 

defined('SEND_EMAIL_CONFIG')      || define('SEND_EMAIL_CONFIG', TRUE); 

defined('ACTIVE_STATUS')  || define('ACTIVE_STATUS', 1); 
defined('NOT_ACTIVE_STATUS')  || define('NOT_ACTIVE_STATUS', 0); 


//Roles
defined('ROLE_SA') || define('ROLE_SA', 'SA'); 
defined('ROLE_RTC') || define('ROLE_RTC', 'RTC');
defined('ROLE_RTS') || define('ROLE_RTS', 'RTS');
defined('ROLE_LTC') || define('ROLE_LTC', 'LTC');
defined('ROLE_LTS') || define('ROLE_LTS', 'LTS');
defined('ROLE_OAC') || define('ROLE_OAC', 'OAC');
defined('ROLE_OAS') || define('ROLE_OAS', 'OAS');     


//Role id
defined('ROLE_SA_ID') || define('ROLE_SA_ID', 1); 
defined('ROLE_RTC_ID') || define('ROLE_RTC_ID', 2);
defined('ROLE_RTS_ID') || define('ROLE_RTS_ID', 3);
defined('ROLE_LTC_ID') || define('ROLE_LTC_ID', 4);
defined('ROLE_LTS_ID') || define('ROLE_LTS_ID', 5);
defined('ROLE_OAC_ID') || define('ROLE_OAC_ID', 6);
defined('ROLE_OAS_ID') || define('ROLE_OAS_ID', 7);     


//group
defined('GROUP_SA') || define('GROUP_SA', 1);     
