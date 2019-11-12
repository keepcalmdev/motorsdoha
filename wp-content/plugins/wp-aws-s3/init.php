<?php
namespace TheDevAWSS3;
if( ! defined( 'ABSPATH' )) die( 'Forbidden' );
/**
 * Class Name : Init - This main class for review plugin
 * Class Type : Normal class
 *
 * initiate all necessary classes, hooks, configs
 *
 * @since 1.0.0
 * @access Public
 */

Class Init{
     
     /**
     * veriable for meta box post type - $post_type_aws
     * @since 1.0.0
     * @access private
     */
     private $post_type_aws = 'themeDev_aws';
	  /**
     * veriable for plugin text domain - $aws_text_domain
     * @since 1.0.0
     * @access public
     */
     private $aws_text_domain = 'thedev-aws-s3';
	 /**
     * Construct the plugin object
     * @since 1.0.0
     * @access public
     */
	public function __construct(){
		$this->aws_autoloder();
         $newThemeAws 	= new Apps\Themedevaws();
         $newAws 		= new Apps\Awss3($newThemeAws, $this->post_type_aws, $this->aws_text_domain );
		 new Apps\Settings($newThemeAws, $newAws, $this->post_type_aws, $this->aws_text_domain );
          
	}
	
	
	/**
     * Review aws_autoloder.
     * xs_review autoloader loads all the classes needed to run the plugin.
     * @since 1.0.0
     * @access private
     */
	
	private function aws_autoloder(){
		require_once THE_DEV_AWS_PLUGIN_PATH . '/appsloader.php';
        Appsloader::run_plugin_aws();
	}
	 
}