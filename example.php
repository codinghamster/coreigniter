<?php

require 'CoreIgniter.php';
    
//Specify the root directory of CI installation
$root = dirname('/path/to/codeigniter/index.php');

//Specify the path to the system folder
$basepath = $root.'/system/';

//Specify the path to the application folder
$apppath = $root.'/application/';

//Specify the supposed environment of the instance
$environment = 'development';

//Specify the $assign_to_config array if you use it
$assign_to_config = array('key' => 'value');

//Create the instance
try {
    $CI = CoreIgniter::init($basepath, $apppath, $environment, $assign_to_config);
} catch (CoreIgniterException $e) {
    exit($e->getMessage());
}

//Use it as usual
$CI->load->library('session');

var_dump($CI->session->userdata);
