<?php
namespace TheDevAWSS3; 
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Review autoloader.
 * Handles dynamically loading classes only when needed. This is the main loader file in plugin.
 *
 * @since 1.0.0
 */
class Appsloader {
	
	/**
     * Review run_plugin static method.
     * xs_review autoloader loads all the classes needed to run the plugin.
     * @since 1.0.0
     * @access plugic
     */
	
	public static function run_plugin_aws(){
		spl_autoload_register( [ __CLASS__, 'the_autoload_class' ] );
	}
	
	/**
	 * Autoload Class.
	 * For a given class, check if it exist and load it.
	 *
	 * @since 1.0.0
	 * @access private
	 * @param string $class Class name.
	 * @return : void
	 */
	private static function the_autoload_class( $load_class ){
		// check our keyword in my class of plugin
	    if ( 0 !== strpos( $load_class, 'TheDevAWSS3' ) ) {
            return;
        }
        
        $file_name = strtolower(
								preg_replace(
									[ '/\bTheDevAWSS3\\\/', '/([a-z])([A-Z])/', '/_/', '/\\\/' ],
									[ '', '$1-$2', '-', DIRECTORY_SEPARATOR],
									$load_class
								)
							);
        // generate file of class
        //echo $file_name; die();
		$file = THE_DEV_AWS_PLUGIN_PATH . $file_name . '.php';
		// If a file is found
        if ( file_exists( $file ) ) {
            require_once( $file );
        }
	}
}
