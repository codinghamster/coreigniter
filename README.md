CoreIgniter v.1.5
=================

Simple class that creates generic CodeIgniter instance to make use of some framework functionality in external scripts.

Generic instance means that some functionality is disabled by design e.g. no hooks, no benchmarking, no routing etc.

It was initially created in order to leverage sessions, but some other classes should also work with no problem.

Supposed to work on CodeIgniter 2.0.0 and upper versions.

Example usage
-------------

```php
require 'CoreIgniter.php';
    
//Specify the root directory of CodeIgniter installation
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
```

To be honest
------------

It is neither well written nor well tested class, however in most cases it just works. If you encounter some issues using it — feel free to report on them here on github.