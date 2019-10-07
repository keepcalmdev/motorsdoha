<?php
namespace TheDevAWSS3\Apps;
if( ! defined( 'ABSPATH' )) die( 'Forbidden' );

class Settings{
	 /**
     * veriable for plugin custom post type - $post_type_aws
     * @since 1.0.0
     * @access private
     */
	private $post_type_aws;
	/**
     * veriable for plugin text domain - $aws_text_domain
     * @since 1.0.0
     * @access private
     */
	private $aws_text_domain;
	/**
     * veriable for plugin settings page title - $aws_title
     * @since 1.0.0
     * @access private
     */
	private $aws_title = 'WP AWS S3';
	
	/**
     * veriable for plugin settings page name - $aws_name
     * @since 1.0.0
     * @access private
     */
	private $aws_name = 'WP AWS S3';
	
	/**
     * Construct the $awsS3
     * @since 1.0.0
     * @access private
     */
	 private $awsS3;
	 /**
     * veriable for plugin s3 services - $s3Services
     * @since 1.0.0
     * @access private
     */
	private $s3Services;
	
	public function __construct(Themedevaws $newThemeAws, Awss3 $newAws, $custom_aws , $aws_text_domain){
		// initialize aws custom post
		$this->post_type_aws = $custom_aws;
		
		// add Admin Page WP- Action
		add_action('admin_menu', [ $this, 'themeDev_aws_s3_admin_menu' ]);
		
		// initialize S3 Services
		$this->s3Services = $newThemeAws;
		
		// initialize AwsS3
		$this->awsS3 = $newAws;
		
		// Load css file for settings page
        add_action( 'admin_enqueue_scripts', [$this, 'themeDev_aws_settings_css_loader' ] );

        // Load script file for settings page
        add_action( 'admin_enqueue_scripts', [$this, 'themeDev_aws_settings_script_loader' ] );

	}
	
	/**
     * AWS themeDev_aws_s3_admin_menu
     * Method Description: Added new manu in admin dashboard
     * @since 1.0.0
     * @access public
     */
	public function themeDev_aws_s3_admin_menu() {
		// main page
		add_menu_page(
			__( $this->aws_title, 'themedev-aws-s3' ),
			$this->aws_name,
			'manage_options',
			'theme-dev-aws-s3',
			[ $this->awsS3 , 'themeDev_aws_s3_admin_manage_store'],
			THE_DEV_AWS_PLUGIN_URL. 'assets/images/s3.png',
			101
		);
		//sub main page - Manage Store
		add_submenu_page(
			'theme-dev-aws-s3',
			__( 'Manage Store', 'themedev-aws-s3' ),
			__('Manage Store', 'themedev-aws-s3' ),
			'manage_options',
			'theme-dev-aws-s3',
			[ $this->awsS3 , 'themeDev_aws_s3_admin_manage_store']
		);
		//sub main page - Create Store
		add_submenu_page(
			'theme-dev-aws-s3',
			__( 'Create Store', 'themedev-aws-s3' ),
			__('Create Store', 'themedev-aws-s3' ),
			'manage_options',
			'theme-dev-aws-s3-new-store',
			[ $this->awsS3, 'themeDev_aws_s3_admin_new_store']
		);
		//sub main page - File Upload
		add_submenu_page(
			'theme-dev-aws-s3',
			__( 'Upload Files', 'themedev-aws-s3' ),
			__('Upload Files', 'themedev-aws-s3' ),
			'manage_options',
			'theme-dev-aws-s3-upload-file',
			[ $this->awsS3, 'themeDev_aws_s3_admin_upload_file']
		);
		
		//sub main page - settings
		add_submenu_page(
			'theme-dev-aws-s3',
			__( 'AWS Settings', 'themedev-aws-s3' ),
			__('Settings', 'themedev-aws-s3' ),
			'manage_options',
			'theme-dev-aws-s3-settings',
			[$this, 'themeDev_aws_s3_admin_settings']
		);
	}
	
	
	/**
     * AWS themeDev_aws_s3_admin_settings
     * Method Description: admin sub page for settings
     * @since 1.0.0
     * @access public
     */
	public function themeDev_aws_s3_admin_settings(){
		$message_status = 'no';
		$message_text = '';
		$regionList = $this->s3Services->NX_region_list();
		$settingsKeyThemeDev = 'theme-dev-aws-credentials';
		
		if(isset($_POST['themedev-aws-s3-config'])){
			
			$themedevawsOptions = isset($_POST['themedevaws']) ? self::sanitize($_POST['themedevaws']) : [];
			if(is_array($themedevawsOptions) && sizeof($themedevawsOptions) > 0){
				 if(update_option( $settingsKeyThemeDev, $themedevawsOptions, 'Yes' )){
				    $configFile = THE_DEV_AWS_PLUGIN_PATH. '/lib/aws/.aws/credentials/config.php';
					
					$accessId = isset($_POST['themedevaws']['aws_access_id']) ? self::sanitize($_POST['themedevaws']['aws_access_id']) : '';
					
					$accessId = (strlen($accessId) > 6 ) ? $accessId : $this->s3Services->access_key_id;
					
					$secrectKey = isset($_POST['themedevaws']['aws_secret_access_key']) ? self::sanitize($_POST['themedevaws']['aws_secret_access_key']) : '';
					
					$secrectKey = (strlen($secrectKey) > 6 ) ? $secrectKey : $this->s3Services->secrect_access_key;
					
					$fileData = '';
					$fileData .= '[default]'.PHP_EOL;
					$fileData .= 'aws_access_key_id = '.$accessId.''.PHP_EOL;
					$fileData .= 'aws_secret_access_key = '.$secrectKey.''.PHP_EOL;
					
					file_put_contents($configFile, $fileData);
					$message_status = 'yes';
					$message_text = __('AWS Credentials data have been updated.', 'themedev-aws-s3');	
				}
			}
			
		}
		// output for AWS Credentials
        $return_data_aws_credentials = get_option($settingsKeyThemeDev);
		$setRegionOptionsKey = 'theme-dev-aws-region-set';
		
		if(isset($_POST['themedev-set-tegion'])){
			$region = isset($_POST['themedevawsstore_region_list']) ? self::sanitize($_POST['themedevawsstore_region_list']) : '';
			if(strlen($region) > 1){
				if(update_option( $setRegionOptionsKey, $region, 'Yes' )){
					$message_status = 'yes';
					$message_text = __('Set Region successfully', 'themedev-aws-s3');	
				}
			}
		}
		$regionname = get_option($setRegionOptionsKey);
		// crop dimaintions
		$settingsKeyCropThemeDev = 'theme-dev-aws-crop-dimentions';
		if(isset($_POST['themedev-crop-dimantions-config'])){
			$themedevdimentionsOptions = isset($_POST['themedevdimentions']) ? self::sanitize($_POST['themedevdimentions']) : [];
			if(is_array($themedevdimentionsOptions) && sizeof($themedevdimentionsOptions) > 0){
				$width = isset($_POST['themedevdimentions']['width']) ? self::sanitize($_POST['themedevdimentions']['width']) : '100';
				$height = isset($_POST['themedevdimentions']['height']) ? self::sanitize($_POST['themedevdimentions']['height']) : '100';
				$prefix = isset($_POST['themedevdimentions']['prefix']) ? self::sanitize($_POST['themedevdimentions']['prefix']) : '_100x100';
				
				if(strlen($width) > 1 && strlen($height) > 1 ){
					
					$prefix = (strlen($prefix) > 1 ) ? $prefix : '_'.$width.'x'.$height;
					
					$return_data_aws_cropData = get_option($settingsKeyCropThemeDev);
					
					if(is_array($return_data_aws_cropData) && !empty($return_data_aws_cropData)){
						$return_data_aws_cropData[] = ['width' => $width, 'height' => $height, 'prefix' => $prefix];
					}else{
						$return_data_aws_cropData = [['width' => $width, 'height' => $height, 'prefix' => $prefix]];
					}
					if(update_option( $settingsKeyCropThemeDev, $return_data_aws_cropData, 'Yes' )){
						$message_status = 'yes';
						$message_text = __('Crop Dimentions successfully', 'themedev-aws-s3');	
					}
				}else{
					$message_status = 'yes';
					$message_text = __('Set width & height', 'themedev-aws-s3');	
				}				
			}
		}
		// output for AWS Credentials
        $return_data_aws_crop = get_option($settingsKeyCropThemeDev);
		//print_r( $return_data_aws_crop);
		
		
		$settingsKeyFolderThemeDev = 'theme-dev-aws-folder-path';
		$settingsKeyFolderThemeDevDefult = 'theme-dev-aws-folder-default';
		if(isset($_POST['themedev-folder-path-config'])){
			$folder_pathDefult = isset($_POST['default_folder']) ? self::sanitize($_POST['default_folder']) : 'No';
			$folder_path = isset($_POST['folder_path']) ? self::sanitize($_POST['folder_path']) : '';
			$return_data_aws_folder = get_option($settingsKeyFolderThemeDev);
			
			$folder_pathRtib = str_replace( ['_', ' ', '  ', ',', '.', "'", '`'] , '-', strtolower( trim($folder_path, '/') ) );
			
			if(is_array($return_data_aws_folder) && sizeof($return_data_aws_folder) > 0){
				$return_data_aws_folder[] = $folder_pathRtib;
			}else{
				$return_data_aws_folder = [$folder_pathRtib];
			}
			
			if(strlen($folder_pathRtib) > 1){
				if($folder_pathDefult == 'Yes'){
					update_option( $settingsKeyFolderThemeDevDefult, $folder_pathRtib, 'Yes' );
				}
				
				if(update_option( $settingsKeyFolderThemeDev, $return_data_aws_folder, 'Yes' )){
					$message_status = 'yes';
					$message_text = __('Create folder successfully', 'themedev-aws-s3');	
				}
			}else{
				$message_status = 'yes';
				$message_text = __('Enter folder name', 'themedev-aws-s3');	
			}
		}
		
		$return_data_aws_folder = get_option($settingsKeyFolderThemeDev);
		//echo '<pre>';
		//print_r( $return_data_aws_folder);
		//echo '</pre>';
		
		if(!file_exists(THE_DEV_AWS_PLUGIN_PATH.'views/admin/aws-settings.php')){
			die('aws-settings.php file could not found');
		}
		require ( THE_DEV_AWS_PLUGIN_PATH.'views/admin/aws-settings.php' );
	}
	
	 /**
     * AWS themeDev_aws_settings_css_loader .
     * Method Description: Settings Css Loader
     * @since 1.0.0
     * @access public
     */
     public function themeDev_aws_settings_css_loader(){
        wp_register_style( 'themeDev_settings_css', THE_DEV_AWS_PLUGIN_URL. 'assets/admin/css/admin-settings.css');
        wp_enqueue_style( 'themeDev_settings_css' );
		
     }
     /**
     * AWS themeDev_aws_settings_script_loader .
     * Method Description: Settings Script Loader
     * @since 1.0.0
     * @access public
     */
    public function themeDev_aws_settings_script_loader(){
        wp_register_script( 'themeDev_settings_script', THE_DEV_AWS_PLUGIN_URL. 'assets/admin/scripts/admin-settings.js', array('jquery'));
        wp_enqueue_script( 'themeDev_settings_script' );
		
     }
	 
	 public static function sanitize($value, $senitize_func = 'sanitize_text_field'){
        $senitize_func = (in_array($senitize_func, [
                'sanitize_email', 
                'sanitize_file_name', 
                'sanitize_hex_color', 
                'sanitize_hex_color_no_hash', 
                'sanitize_html_class', 
                'sanitize_key', 
                'sanitize_meta', 
                'sanitize_mime_type',
                'sanitize_sql_orderby',
                'sanitize_option',
                'sanitize_text_field',
                'sanitize_title',
                'sanitize_title_for_query',
                'sanitize_title_with_dashes',
                'sanitize_user',
                'esc_url_raw',
                'wp_filter_nohtml_kses',
            ])) ? $senitize_func : 'sanitize_text_field';
        
        if(!is_array($value)){
            return $senitize_func($value);
        }else{
            return array_map(function($inner_value) use ($senitize_func){
                return self::sanitize($inner_value, $senitize_func);
            }, $value);
        }
    }
	 
}