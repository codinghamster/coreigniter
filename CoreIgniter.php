<?php

/**
 * Custom exception for CoreIgniter
 */
class CoreIgniterException extends Exception {}

/**
 * CoreIgniter class
 *
 * Creates a CodeIgniter instance without overhead like URL processing, etc.
 * Suitable for accessing session or another native CodeIgniter's resources
 * in the same manner as using $this variable.
 */
class CoreIgniter
{
    
    /**
     * Version of the library
     */
    const VERSION = '1.5';
    
    /**
     * Internal storage of CodeIgniter super object instance
     * 
     * @static
     * @access protected
     */
    protected static $instance;
    
    /**
     * Initializes the CodeIgniter super object instance
     * 
     * @static
     * @access public
     * @param string $basepath          Absolute path to CodeIgniter system folder
     * @param string $apppath           Absolute path to CodeIgniter application folder
     * @param string $environment       Optional environment of the CodeIgniter instance
     * @param string $assign_to_config  Optional config from index.php if it is used
     * @throws CoreIgniterException if the instance is already initialized or unreachable paths provided
     * @return object CodeIgniter instance
     */
    public static function init($basepath, $apppath, $environment = null, $assign_to_config = array())
    {
        if (self::$instance) {
            throw new CoreIgniterException('Codeigniter instance is already initialized');
        }
        
        if (!is_dir($basepath)) {
            throw new CoreIgniterException('Supplied base path is not a directory');
        } else {
            $basepath = rtrim($basepath, '/').'/';
        }
        
        if (!is_dir($apppath)) {
            throw new CoreIgniterException('Supplied application path is not a directory');
        } else {
            $apppath = rtrim($apppath, '/').'/';
        }
        
        define('BASEPATH', $basepath);
        define('APPPATH', $apppath);
        define('EXT', '.php');
        define('ENVIRONMENT', $environment ? $environment : 'development');
        
        require(BASEPATH.'core/Common.php');
        
        if (file_exists(APPPATH.'config/'.ENVIRONMENT.'/constants.php')) {
            require(APPPATH.'config/'.ENVIRONMENT.'/constants.php');
        } else {
            require(APPPATH.'config/constants.php');
        }
        
        $GLOBALS['CFG'] =& load_class('Config', 'core');
        $GLOBALS['CFG']->_assign_to_config($assign_to_config);
        $GLOBALS['UNI'] =& load_class('Utf8', 'core');
        if (file_exists($basepath.'core/Security.php')) {
            $GLOBALS['SEC'] =& load_class('Security', 'core');
        }
        load_class('Input', 'core');
        load_class('Lang', 'core');
        
        require(BASEPATH.'core/Controller.php');
        
        function &get_instance() {
            return CI_Controller::get_instance();
        }
        
        if (file_exists(APPPATH.'core/'.$GLOBALS['CFG']->config['subclass_prefix'].'Controller.php')) {
            require APPPATH.'core/'.$GLOBALS['CFG']->config['subclass_prefix'].'Controller.php';
            $class = $GLOBALS['CFG']->config['subclass_prefix'].'Controller';
        } else {
            $class = 'CI_Controller';
        }
        
        self::$instance = new $class();
        
        return self::$instance;
    }
    
    /**
     * Getter for the CodeIgniter instance object
     * 
     * @static
     * @access public
     * @throws CoreIgniterException if the instance is not yet initialized
     * @return object CI instance
     */
    public static function instance()
    {
        if (!self::$instance) {
            throw new CoreIgniterException('CodeIgniter instance is not initialized yet');
        }
        return self::$instance;
    }
    
}
