<?php
if( ! defined( 'ABSPATH' )) die( 'Forbidden' );
/**
 * Plugin Name: WP AWS S3
 * Description: The most advanced WordPress AWS S3 Management Console (Amazon). Better solution for Files manage of S3 Server(Amazon). The Amazon S3 Console is the advanvced service for Amazon S3. Unlimited files upload, Create Unlimited Bucket or Store, Create Unlimited Folder in Bucket. Manage All files in Bucket. Automatic Crop Image when upload by your Crop Dimentions and Other features
 * Plugin URI: http://themedev.net/?plugin=wp-aws-s3
 * Author: ThemeDev
 * Version: 1.0.0
 * Author URI: http://themedev.net/
 *
 * Text Domain: thedev-aws-s3
 *
 * @package WP AWS S3
 * @category Pro
 * Domain Path: /languages/
 * License: GPL2+
 */
/**
 * Defining static values as global constants
 * @since 1.0.0
 */
define( 'THE_DEV_AWS_VERSION', '1.0.0' );
define( 'THE_DEV_AWS_PREVIOUS_STABLE_VERSION', '1.0.0' );

define( 'THE_DEV_AWS_KEY', 'themedev-aws-s3' );

define( 'THE_DEV_AWS_DOMAIN', 'themedev-aws-s3' );

define( 'THE_DEV_AWS_FILE_', __FILE__ );
define( "THE_DEV_AWS_PLUGIN_PATH", plugin_dir_path( THE_DEV_AWS_FILE_ ) );
define( 'THE_DEV_AWS_PLUGIN_URL', plugin_dir_url( THE_DEV_AWS_FILE_ ) );

// initiate actions
add_action( 'plugins_loaded', 'thedev_aws_s3_load_plugin_textdomain' );
/**
 * Load AWS S3 textdomain.
 * @since 1.0.0
 * @return void
 */
function thedev_aws_s3_load_plugin_textdomain() {
	load_plugin_textdomain( 'themedev-aws-s3', false, basename( dirname( __FILE__ ) ) . '/languages'  );
}

// add action page hook
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'themedev_aws_action_links' );

// added custom link
function themedev_aws_action_links($links){
	$links[] = '<a href="' . admin_url( 'admin.php?page=theme-dev-aws-s3-settings' ).'"> '. __('Settings', 'themedev-aws-s3').'</a>';
	return $links;
}
/**
 * Load AWS S3 Loader main page.
 * @since 1.0.0
 * @return plugin output
 */
require_once(THE_DEV_AWS_PLUGIN_PATH.'init.php');
new \TheDevAWSS3\Init();

