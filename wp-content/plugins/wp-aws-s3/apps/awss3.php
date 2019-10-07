<?php
namespace TheDevAWSS3\Apps;
if( ! defined( 'ABSPATH' )) die( 'Forbidden' );
class Awss3{
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
     * veriable for plugin s3 services - $s3Services
     * @since 1.0.0
     * @access private
     */
	private $s3Services;
	/**
     * Construct the Awss3 object
     * @since 1.0.0
     * @access public
     */
	public function __construct(Themedevaws $newThemeAws, $custom_aws , $aws_text_domain){
		// initialize aws custom post
		$this->post_type_aws = $custom_aws;
		
		add_action('init', [ $this, 'themedev_aws_init_rest_admin' ]); 	
		
		$this->s3Services = $newThemeAws;
		
		// Load css file for settings page
        add_action( 'admin_enqueue_scripts', [$this, 'themeDev_aws_settings_css_loader' ] );

        // Load script file for settings page
        add_action( 'admin_enqueue_scripts', [$this, 'themeDev_aws_settings_script_loader' ] );
		
		
	}
	
	/**
     * AWS themeDev_aws_s3_admin_new_store
     * Method Description: create new store
     * @since 1.0.0
     * @access public
     */
	public function themeDev_aws_s3_admin_new_store(){
		
		$message_status = 'no';
		$message_text = '';
		$regionList = $this->s3Services->NX_region_list();
		$aclList = $this->s3Services->NX_acl_list();
		
		// output for setn region
		$setRegionOptionsKey = 'theme-dev-aws-region-set';
		$regionname = get_option($setRegionOptionsKey);
		
		$storename = '';
		$permission = 'public-read';
		$error = 1;
		if(isset($_POST['themedev-aws-create-store'])){
			$themedevawsOptions = isset($_POST['themedevawsstore']) ? \TheDevAWSS3\Apps\Settings::sanitize($_POST['themedevawsstore']) : [];
			$regionname = isset($themedevawsOptions['region_list']) ? $themedevawsOptions['region_list'] : $regionname;
			$acl_permision = isset($themedevawsOptions['acl_permision']) ? $themedevawsOptions['acl_permision'] : $permission;
			$storename = isset($themedevawsOptions['store_name']) ? $themedevawsOptions['store_name'] : '';
			if(strlen($storename) < 5){
				$message_text = __('Please enter store name.', 'themedev-aws-s3');
				$message_status = 'yes';
				$error = 0;
			}
			if(strlen($regionname) < 5){
				$message_text = __('Please select region.', 'themedev-aws-s3');
				$message_status = 'yes';
				$error = 0;
			}
			if($error == 1):
				$storename = str_replace( ['_', ' ', '  ', ',', '.', "'", '`'] , '-', $storename);
				$this->s3Services->initialize( ['region' => $regionname ] );
				$returnStore =  $this->s3Services->NX_bucket_create($storename, $acl_permision);
				if($returnStore){
					
					update_option( $setRegionOptionsKey, $regionname, 'Yes' );
					
					/*Save store in my option table*/
					
					$settingsStoreKey = 'theme-dev-aws-store-list';
					$return_data_aws_storelist = get_option($settingsStoreKey);
					if(is_array($return_data_aws_storelist) && sizeof($return_data_aws_storelist) > 0){
						$return_data_aws_storelist[] = $themedevawsOptions;
					}else{
						$return_data_aws_storelist = [$themedevawsOptions];
					}
					
					update_option( $settingsStoreKey, $return_data_aws_storelist, 'No') ;
					/*Save store in my option table end*/
					
					$message_status = 'yes';
					$message_text = __('Successfully create your store', 'themedev-aws-s3');
					$storename = '';
					$regionname = '';
				}  
			endif;
		}
		
		
		// store list
		$storeList = $this->s3Services->NX_bucket_list();
		
		
		if(!file_exists(THE_DEV_AWS_PLUGIN_PATH.'views/admin/create-store.php')){
			die('create-store.php file could not found');
		}
		require ( THE_DEV_AWS_PLUGIN_PATH.'views/admin/create-store.php' );
	}
	
	/**
     * AWS themeDev_aws_s3_admin_upload_file
     * Method Description: files uploader
     * @since 1.0.0
     * @access public
     */
	public function themeDev_aws_s3_admin_upload_file(){
		
		$storeList = $this->s3Services->NX_bucket_list();
		$aclList = $this->s3Services->NX_acl_list();
		$regionList = $this->s3Services->NX_region_list();
		$permission = 'public-read';
		
		
		$message_status = 'no';
		$message_text = '';
		$error = 1;
		// output for folder list
		$settingsKeyFolderThemeDev = 'theme-dev-aws-folder-path';
		$return_data_aws_folder = get_option($settingsKeyFolderThemeDev);
		
		// output for AWS Credentials
		$settingsKeyCropThemeDev = 'theme-dev-aws-crop-dimentions';
        $return_data_aws_crop = get_option($settingsKeyCropThemeDev);
		
		// output for setn region
		$setRegionOptionsKey = 'theme-dev-aws-region-set';
		$regionname = get_option($setRegionOptionsKey);
		// output for set deaault forlder
		$settingsKeyFolderThemeDevDefult = 'theme-dev-aws-folder-default';
		$folderDefult = get_option($settingsKeyFolderThemeDevDefult);
		
		if(empty($regionname)):
			$regionname = 'ap-southeast-1';
		endif;
		
		$error = 1;
		
		$file_list = '';
		$fileArray = [];
		if(isset($_POST['themedev-aws-files-upload'])){
			$uploadFiles = isset($_POST['themedevawsstore']) ? \TheDevAWSS3\Apps\Settings::sanitize($_POST['themedevawsstore']) : [];
			
			$store_name = isset($uploadFiles['upload_store_name']) ? $uploadFiles['upload_store_name'] : '';
			
			if(strlen($store_name) < 5){
				$message_text = __('Please select store.', 'themedev-aws-s3');
				$message_status = 'yes';
				$error = 0;
			}
			
			$region_list = isset($uploadFiles['region_list']) ? $uploadFiles['region_list'] : $regionname;
			$folderName_name = isset($uploadFiles['upload_folder_name']) ? $uploadFiles['upload_folder_name'] : '';
			$acl_permision = isset($uploadFiles['acl_permision']) ? $uploadFiles['acl_permision'] : $permission;
			$crop_status = isset($uploadFiles['crop_status_theme']) ? $uploadFiles['crop_status_theme'] : 'No';
			$crop_full = isset($uploadFiles['crop_dimention_full']) ? $uploadFiles['crop_dimention_full'] : 'Yes';
			$crop_ratio = isset($uploadFiles['aws_radio_center']) ? $uploadFiles['aws_radio_center'] : 'Yes';
			$random_files = isset($uploadFiles['aws_random_files_create']) ? $uploadFiles['aws_random_files_create'] : 'default';
			
			$dimentions = [];
			if($crop_status == 'Yes'){
				$crop_dimention = isset($_POST['crop_dimention']) ? $_POST['crop_dimention'] : [];
				if(is_array($crop_dimention) && sizeof($crop_dimention) > 0){
					foreach($crop_dimention AS $filesDimention):
						if(strlen($filesDimention) > 0){
							$expDi = explode('___', $filesDimention);
							$width = isset($expDi[0]) ? $expDi[0] : '';
							$height = isset($expDi[1]) ? $expDi[1] : '';
							$prefix = isset($expDi[2]) ? $expDi[2] : '';
				
							$width = (strlen($width) > 1 ) ? $width : $height;	
							$height = (strlen($height) > 1 ) ? $height : $width;
							
							$prefix = (strlen($prefix) > 1 ) ? $prefix : '_'.$width.'x'.$height;
				
							$dimentions[] = ['imagewidth' => $width, 'imageheight' => $height, 'image_suffix'  =>  $prefix ];
						}
					endforeach;
				}
			}
			
			if($error == 1):	
				$regionSelect = strlen($region_list) > 1 ? $region_list : $regionname;
				$this->s3Services->initialize( ['region' =>  $regionSelect] );
				
				$imageList = isset($_FILES['upload-files']) ? \TheDevAWSS3\Apps\Settings::sanitize($_FILES['upload-files']['name']) : '';
				
				if(sizeof($imageList) > 0){
					$upload_path = '';
					$upload_path .= 'aws-files/';
					if($folderName_name == 'custom'){
						$settingsKeyFolderThemeDev = 'theme-dev-aws-folder-path';
						
						$folderData = isset($_POST['folder_path']) ? $_POST['folder_path'] : '';
						if( strlen($folderData) > 2){
							$return_data_aws_folder = get_option($settingsKeyFolderThemeDev);
							$folder_pathRtib = str_replace( ['_', ' ', '  ', ',', '.', "'", '`'] , '-', strtolower(trim($folderData, '/')));
							$return_data_aws_folder[] = $folder_pathRtib;
							
							update_option( $settingsKeyFolderThemeDev, $return_data_aws_folder, 'Yes' );
							
							$upload_path .= trim($folder_pathRtib, '/').'/';
							
						}
					}else{
						if( strlen($folderName_name) > 2){
							$upload_path .= trim($folderName_name, '/').'/';
						}
					}
					
					for($i = 0; $i < sizeof($imageList); $i++ ){
						$fileName = isset($_FILES['upload-files']) ? \TheDevAWSS3\Apps\Settings::sanitize($_FILES['upload-files']['name'][$i]) : '';
						if(strlen($fileName) > 5){
							$config = [];
							$config['bucket'] 		= $store_name;						
							$config['acl'] 			= $acl_permision;						
							$config['file_path'] 	= $upload_path;						
							$config['file'] 		= $imageList;						
							$config['name'] 		= $fileName;						
							$config['tmp_name'] 	= isset($_FILES['upload-files']) ? $_FILES['upload-files']['tmp_name'][$i] : '';						
							$config['type'] 		= isset($_FILES['upload-files']) ? $_FILES['upload-files']['type'][$i] : '';						
							$config['create_file'] 	= (isset($random_files) && $random_files == 'Yes') ? 'random' : 'default' ;	// random, default					
							//$config['upload_type'] 	= 'image';	// file, image					
							$config['crop_status'] 	= (isset($crop_status) && $crop_status == 'Yes') ? 'Yes' : 'No' ;						
							$config['crop_ratio'] 	= (isset($crop_ratio) && $crop_ratio == 'Yes') ? true : false ;											
							//$config['allowed_types'] = 'jpg|jpeg|png';
							$config['dimentions_full'] = (isset($crop_full) && $crop_full == 'Yes') ? 'Yes' : 'No' ;
							if($crop_status == 'Yes'){
								$config['dimentions']   = $dimentions;
							}
							$returnFlie = $this->s3Services->NX_file_upload($config);
							
							if(isset($returnFlie['_full']) && strlen($returnFlie['_full']) > 0){
								$fileArray[] = $returnFlie['_full'];
								
							}
							$message_status = 'yes';
							if(isset($returnFlie) AND is_array($returnFlie) ){
								$message_text = __('Successfully uploaded', 'themedev-aws-s3');
							}else{
								$message_text =  $returnFlie;
							}
						}
					}
					$file_list = $fileArray;
				}
				
			endif;
		}
		
		
		if(!file_exists(THE_DEV_AWS_PLUGIN_PATH.'views/admin/upload-files.php')){
			die('upload-files.php file could not found');
		}
		require ( THE_DEV_AWS_PLUGIN_PATH.'views/admin/upload-files.php' );
	}
	/**
     * AWS themeDev_aws_s3_admin_manage_store
     * Method Description: manage store
     * @since 1.0.0
     * @access public
     */
	public function themeDev_aws_s3_admin_manage_store(){
		
		$storeList = $this->s3Services->NX_bucket_list();
		
		// output for setn region
		$setRegionOptionsKey = 'theme-dev-aws-region-set';
		$regionname = get_option($setRegionOptionsKey);
		
		if(empty($regionname)):
			$regionname = 'ap-southeast-1';
		endif;
		
		$this->s3Services->initialize( ['region' =>  $regionname] );
		$getBucketName = isset($_GET['store']) ? \TheDevAWSS3\Apps\Settings::sanitize($_GET['store']) : '';
		$objcetList = '';
		
		if(strlen($getBucketName) > 0){
			$objcetList = $this->s3Services->NX_bucket_objects($getBucketName);
			$getfolderName = isset($_GET['folder']) ? \TheDevAWSS3\Apps\Settings::sanitize($_GET['folder']) : '';
		}
		
		
		if(!file_exists(THE_DEV_AWS_PLUGIN_PATH.'views/admin/manage-store.php')){
			die('manage-store.php file could not found');
		}
		require ( THE_DEV_AWS_PLUGIN_PATH.'views/admin/manage-store.php' );
	}
	
	
	/**
     * AWS themeDev_aws_settings_css_loader .
     * Method Description: Settings Css Loader
     * @since 1.0.0
     * @access public
     */
     public function themeDev_aws_settings_css_loader(){
        wp_register_style( 'themeDev_settings_css_aws', THE_DEV_AWS_PLUGIN_URL. 'assets/admin/css/admin-settings.css');
        wp_enqueue_style( 'themeDev_settings_css_aws' );
		
     }
     /**
     * AWS themeDev_aws_settings_script_loader .
     * Method Description: Settings Script Loader
     * @since 1.0.0
     * @access public
     */
    public function themeDev_aws_settings_script_loader(){
        wp_register_script( 'themeDev_settings_script_aws', THE_DEV_AWS_PLUGIN_URL. 'assets/admin/scripts/admin-settings.js', array('jquery'));
        wp_enqueue_script( 'themeDev_settings_script_aws' );
		wp_localize_script('themeDev_settings_script_aws', 'themedev_aws_url', array( 'siteurl' => get_option('siteurl') ));
     }
	 
	 public function themedev_aws_init_rest_admin(){
		
		add_action( 'rest_api_init', function () {
		  register_rest_route( 'themedev-submit-form', '/download-files/(?P<filesid>\w+)/', 
			array(
				'methods' => 'GET',
				'callback' => [$this, 'themedev_action_rest_download_files'],
			  ) 
			);
		  
		} );
    }
	
	public function themedev_action_rest_download_files(\WP_REST_Request $request){
		$return = ['success' => [], 'error' => [] ];
		$store = isset($request['store']) ? $request['store'] : '';
		$link = isset($request['link']) ? $request['link'] : '';
		
		return $return;
	}
	 public function themedev_aws_create_folder($patharray,$filesize, $path){
		  $tree=[];
			if(count($patharray) === 1) {
				$filename = array_pop($patharray);
				$tree[] = ['name' => $filename, 'size'=>$filesize, 'path' => $path];
			} else {
				$pathpart = array_pop($patharray);
				$tree[$pathpart] = $this->themedev_aws_create_folder($patharray,$filesize,$path);
			}
			return $tree;
	 }
	 
	public function  natkrsort($array) 
	{
			$keys = array_keys($array);
			natsort($keys);

			foreach ($keys as $k)
			{
				$new_array[$k] = $array[$k];
			}
		   
			$new_array = array_reverse($new_array, true);

			return $new_array;
		
	}
	public function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
	}
}