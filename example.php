<?php

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

/* EOF */