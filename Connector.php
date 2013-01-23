<?php

/**
 * Custom exception for CI_Connector
 */
class CI_Connector_Exception extends Exception {}

/**
 * CI_Connector class
 *
 * Creates a CodeIgniter instance without overhead like URL processing, etc.
 * Suitable for accessing session or another native CodeIgniter's resources
 * in the same manner as using $this variable.
 */
class CI_Connector {
    
    /**
     * Version of the library
     */
    const VERSION = '1.0';
    
    /**
     * Internal storage of CodeIgniter's super object
     * 
     * @static
     * @access protected
     */
    protected static $CI;
    
    /**
     * Initializes the CodeIgniter (CI) object
     * 
     * @static
     * @access public
     * @param string $basepath      Absolute path to CI's system folder
     * @param string $apppath       Absolute path to CI's application folder
     * @param string $environment   Optional environment of the CI instance
     * @return object CI instance
     */
    public static function init($basepath, $apppath, $environment = null) {
        if (isset(self::$CI)) {
            throw new CI_Connector_Exception('Codeigniter instance is already initialized');
        }
        
        if (!is_dir($basepath)) {
            throw new CI_Connector_Exception('Supplied base path is not a directory');
        }
        else {
            $basepath = rtrim($basepath, '/').'/';
        }
        
        if (!is_dir($apppath)) {
            throw new CI_Connector_Exception('Supplied application path is not a directory');
        }
        else {
            $apppath = rtrim($apppath, '/').'/';
        }
        
        define('BASEPATH', $basepath);
        define('APPPATH', $apppath);
        
        if ($environment) {
            define('ENVIRONMENT', $environment);
        }
        
        require(BASEPATH.'core/Common.php');
        require(BASEPATH.'core/Controller.php');
        
        function &get_instance() {
            return CI_Controller::get_instance();
        }
        
        $GLOBALS['CFG'] = $CFG =& load_class('Config', 'core');
        
        if (file_exists(APPPATH.'core/'.$CFG->config['subclass_prefix'].'Controller.php')) {
            require APPPATH.'core/'.$CFG->config['subclass_prefix'].'Controller.php';
            $class = $CFG->config['subclass_prefix'].'Controller';
        }
        else {
            $class = 'CI_Controller';
        }
        
        $GLOBALS['UNI'] =& load_class('Utf8', 'core');
        load_class('Input', 'core');
        
        self::$CI = new $class();
        
        return self::$CI;
    }
    
    /**
     * Getter for the CodeIgniter instance object
     * 
     * @static
     * @access public
     * @return object CI instance
     */
    public static function CI() {
        return self::$CI;
    }
    
}

/* EOF */