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
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
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


//爱购保稅 AppKey 和 AppSecret
defined('IGOAPPKEY')           OR define('IGOAPPKEY', '2184365138');//爱购AppKey
defined('IGOAPPSECRET')           OR define('IGOAPPSECRET', '47accd33cafb73548e135bb3bec6c290');//爱购AppSecret
defined('IGOLISTAPIURL')           OR define('IGOLISTAPIURL', 'http://api.igetmall.net/DRP_getProList');//爱购商品列表api
defined('IGOINFOAPIURL')           OR define('IGOINFOAPIURL', 'http://api.igetmall.net/DRP_getProDetail'); //爱购商品详情api
defined('IGOCATEAPIURL')           OR define('IGOCATEAPIURL', 'http://api.igetmall.net/DRP_getCategory'); //爱购商品详情api
defined('APPLOGIN')           OR define('APPLOGIN', 'http://api.zlzmm.com'); //APP登陆
defined('QINIUUPLOAD')           OR define('QINIUUPLOAD', 'http://api.zlzmm.com/api/index/qiniuimg'); //七牛上次
defined('USERPHONE')           OR define('USERPHONE', '18180924082'); //七牛上次
defined('USERPASSWORD')           OR define('USERPASSWORD', '12345a'); //七牛上次
defined('BUCKET')           OR define('BUCKET', 'ebus'); //七牛上次



//个推消息推送
defined('APPID')           OR define('APPID', 'Npuq5Gtr4b7EFd4urKowg1'); //七牛上次
defined('AppSecret')           OR define('AppSecret', 'pyhCCdAhji63WvrDZdqWz5'); //七牛上次
defined('APPKEY')           OR define('APPKEY', 'O8dShsMUiK7MZTyfPXDUy2'); //七牛上次
defined('MASTERSECRET')           OR define('MASTERSECRET', 'ekPvNh6zLk6sn7BoR7sEC8'); //七牛上次
defined('HOST')           OR define('HOST', 'http://sdk.open.api.igexin.com/apiex.htm'); //七牛上次





