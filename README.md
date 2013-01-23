CodeIgniter Connector (CI_Connector) v.1.0
==========================================

Simple class for creating generic CodeIgniter instance without any URL processing overhead in order to utilize some framework functionality e.g. Sessions.

Supposed to work on CI 2.1+ installations, not tested on previous versions.

Example usage
-------------

    require 'Connector.php';
    
    //Specify the root directory of CI installation
    $root = dirname('/path/to/codeigniter/index.php');
    
    //Specify the path to the system folder
    $basepath = $root.'/system/';
    
    //Specify the path to the application folder
    $apppath = $root.'/application/';
    
    //Specify the the supposed environment of the instance
    $environment = 'development';
    
    //Create the instance
    $CI = CI_Connector::init($basepath, $apppath, $environment);
    
    //Use it as usual
    $CI->load->library('session');
    
    var_dump($CI->session->userdata);