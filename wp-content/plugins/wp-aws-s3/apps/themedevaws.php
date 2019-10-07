<?php
namespace TheDevAWSS3\Apps;
if( ! defined( 'ABSPATH' )) die( 'Forbidden' );
/**
 * PHP AWS
 * verson V- 2.0.0 or V2
 * An open source application development AWS for PHP
 *
 * @package AWS S3
 * @author	ThemeDev Team
 * @copyright	Copyright (c) 2015 - 2016, themedev.com by ZERlc2tzLmNvbSBieSBHb2xhcCBIYXpp - themedev2019@gmail.com -- -- -- Z29sYXBoYXppQGdtYWlsLmNvbQ== 
 * 
 * @since	Version 1.0.0
 * @ V2
 */
 /**
 * Tbd_S3uploader.php
 * AWS File Uploader for this controller.
 *
 */

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

use Aws\Common\Exception\MultipartUploadException;
use Aws\S3\MultipartUploader;


class Themedevaws{
	 
	 /**
	 * default s4Client
	 * access: private
	 * @dataType = array
	 */
	 private $NX_S3Client = ['region' => 'ap-southeast-1', 'version' => 'latest'];
	 public $access_key_id   = '';
     public $secrect_access_key = '';
	 private $bucket_defult = 'theme-dev-wp-test';
	 private $path_defult = 'nx-files-path';
	 public $s3Client;
	/**
	 * List of Resion
	 * access: private
	 * @dataType = array
	 */
	 private $NX_regionList = ['us-east-1' => 'US East (N. Virginia)',
							   'us-east-2' => 'US East (Ohio)',
							   'us-west-1' => 'US West (N. California)',
							   'us-west-2' => 'US West (Oregon)',
							   'ap-south-1' => 'Asia Pacific (Mumbai)',
							   'ap-northeast-3' => 'Asia Pacific (Osaka-Local)**',
							   'ap-northeast-2' => 'Asia Pacific (Seoul)',
							   'ap-southeast-1' => 'Asia Pacific (Singapore)',
							   'ap-southeast-2' => 'Asia Pacific (Sydney)',
							   'ap-northeast-1' => 'Asia Pacific (Tokyo)',
							   'ca-central-1' => 'Canada (Central)',
							   'cn-north-1' => 'China (Beijing)',
							   'cn-northwest-1' => 'China (Ningxia)',
							   'eu-central-1' => 'EU (Frankfurt)',
							   'eu-west-1' => 'EU (Ireland)',
							   'eu-west-2' => 'EU (London)',
							   'eu-west-3' => 'EU (Paris)',
							   'eu-north-1' => 'EU (Stockholm)',
							   'sa-east-1' => 'South America (São Paulo)'
							  ];
	 /**
	 * set s4Client
	 */
	
	 private $NX_ACL 	 = ['public-read' => 'Public Read', 'private' => 'Private Read', 'public-read-write' => 'Public Read Write', 'authenticated-read' => 'Authenticated Read'];
	 
	 
	 // file upload
	 private $return_data = [];
	 private $file_path = '';
	 private $crop_allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
	 private $create_image;
	 private $file_name;
	 /**
	 * construct method
	 * access: Public
	 */
	 public function __construct()
	 {	
		putenv('HOME='. THE_DEV_AWS_PLUGIN_PATH .'/lib/aws/');
		include_once ( THE_DEV_AWS_PLUGIN_PATH. '/lib/aws/vendor/autoload.php' );	
		//date_default_timezone_set('America/Los_Angeles');
	 }
	 
	
	 /**
	 * Method Name: initialize();
	 * Method Description: set up s3Client Config
	 * @params: $s3Client - params type: array
	 * @return : set s3 Config
	 * access: Public
	 */
	 public function initialize(array $s3Client){
		 if(is_array($s3Client) && sizeof($s3Client) > 0){
			 if( isset($s3Client['region']) && array_key_exists($s3Client['region'], $this->NX_regionList) ){
				 $this->NX_S3Client['region'] = $s3Client['region'];
			 }
			 if( isset($s3Client['profile']) && strlen($s3Client['profile']) > 1 ){
				// $this->NX_S3Client['profile'] = $s3Client['profile'];
			 }
			 
			 if( isset($s3Client['version']) && strlen($s3Client['version']) > 1 ){
				 $this->NX_S3Client['version'] = $s3Client['version'];
			 }
			
		 }
	 }
	 
	 /**
	 * Method Name: config S3();
	 * Method Description: S2 config
	 * @params: Null
	 * @return : object
	 * access: private
	 */
	 
	  private function NX_s3_config(){
		if(!is_array($this->NX_S3Client) && sizeof($this->NX_S3Client) < 1 ){
			die('Please config S3 Client ');
		}
		//$this->s3Client = new S3Client($this->NX_S3Client);
		//return $this->s3Client;
		try {
            $this->s3Client = S3Client::factory(
					$this->NX_S3Client
             );
			return $this->s3Client;
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
		
	 }
	 
	 /**
	 * Method Name: NX_region_list();
	 * Method Description: Get Region List
	 * @params: null
	 * @return : Region Array
	 * access: Public
	 */
	 
	 public function NX_region_list(){
		 return $this->NX_regionList;
	 }
	 
	 
	 /**
	 * Method Name: NX_region_list();
	 * Method Description: Get Region List
	 * @params: null
	 * @return : Region Array
	 * access: Public
	 */
	 
	 public function NX_acl_list(){
		 return $this->NX_ACL;
	 }
	 /**
	 * Method Name: NX_bucket_create
	 * Method Description: create new bucket
	 * @params $bucketName - bucket name
	 * @params $permisionType - permission type
	 * @params $return (boolean, path) - return date - true, false | return bucket path
	 * @return : void true
	 * @return type: object type
	 * access: Public
	 */
	 public function NX_bucket_create(String $bucketName, $permisionType = 'public-read' , $return = 'boolean ')
	{
		$s3Client = $this->NX_s3_config();
		try {
			if(strlen(trim($bucketName)) > 3){
				$bucketNameData = $this->trim_bucket($bucketName);
				$configBucket = [];
				$configBucket['Bucket'] = $bucketNameData;
				if( array_key_exists($permisionType, $this->NX_ACL) ){
					$configBucket['ACL'] = $permisionType;
				}else{
					$configBucket['ACL'] = $this->NX_ACL[0];
				}
				
				$result = $s3Client->createBucket($configBucket);
				if($return == 'path' ){
					return $result;
				}else{
					return true;
				}
				
			}else{
				return false;
			}
		} catch (S3Exception $e) {
			echo $e->getMessage();
		}
	}
	 
	 /**
	 * Method Name: NX_bucket_list
	 * Method Description: get bucket list
	 * @params null
	 * @return : bucket list
	 * @return type: object type
	 * access: Public
	 */
	 public function NX_bucket_list()
	{
		$s3Client = $this->NX_s3_config();
		$buckets = $s3Client->listBuckets();
		return $buckets;
	}
	
	 /**
	 * Method Name: NX_get_files
	 * Method Description: get files from busket list
	 * @params null
	 * @return : bucket list
	 * @return type: object type
	 * access: Public
	 */
	 public function NX_get_files($getBucketName, $keyStore)
	{
		$s3Client = $this->NX_s3_config();
		$result = $s3Client->getObjectUrl($getBucketName,$keyStore);	
		return $result;
	}
	
	 /**
	 * Method Name: NX_get_files
	 * Method Description: get files from busket list
	 * @params null
	 * @return : bucket list
	 * @return type: object type
	 * access: Public
	 */
	 public function NX_folder_dimentions($getBucketName, $keyStore)
	{
		
	}
	/**
	 * Method Name: NX_bucket_objects
	 * Method Description: get bucket object
	 * @params $buckenName = Bucket name
	 * @return : bucket object list 
	 * @return type: object type
	 * access: Public
	 */
	public function NX_bucket_objects(String $bucketName)
	{
		$s3Client = $this->NX_s3_config();
		try {
			$bucketNameData = $this->trim_bucket($bucketName);		
			/*$objects = $s3Client->getIterator( 'ListObjects', ( [
				'Bucket' => $bucketNameData
			]) );
			*/
			$objects = $s3Client->listObjects( [
				'Bucket' => $bucketNameData
			] );
			return $objects;
		} catch (S3Exception $e) {
			echo $e->getMessage() . "\n";
		}
	}
	/**
	 * Method Name: NX_get_bucket_info
	 * Method Description: get bucket info
	 * @params $buckenName = Bucket name
	 * @return : bucket object list 
	 * @return type: object type
	 * access: Public
	 */
	public function NX_get_bucket_info(String $bucketName, $filed='metadata')
	{
		$s3Client = $this->NX_s3_config();
		try {
			$bucketNameData = $this->trim_bucket($bucketName);		
			
			$objects = $s3Client->listObjects( [
				'Bucket' => $bucketNameData
			] );
			if(isset($objects)){
				if($filed == 'metadata'){
					$info = $objects['@metadata'];
					return $info;
				}else{
					return isset($objects[$filed]) ? $objects[$filed] : '';
				}
			}
			return '';
		} catch (S3Exception $e) {
			echo $e->getMessage() . "\n";
		}
	}
	/**
	 * Method Name: NX_bucket_delete
	 * Method Description: delete Bucket
	 * @params $buckenName = Bucket name
	 * @return : bucket list
	 * @return type: object type
	 * access: Public
	 */
	public function NX_bucket_delete(String $bucketName)
	{
		$s3Client = $this->NX_s3_config();
		try {
			if(strlen($bucketName) > 1){
				$bucketNameData = $this->trim_bucket($bucketName);	
				$objects = $s3Client->listObjects( [
					'Bucket' => $bucketNameData
				] );
				foreach ($objects as $object) {
					$result = $s3Client->deleteObject([
						'Bucket' => $bucketNameData,
						'Key' => $object['Key'],
					]);
				}
				$result = $s3Client->deleteBucket([
					'Bucket' => $bucketNameData,
				]);
				return true;
			}else{
				return __('Please put bucket name', 'themedev-aws-s3');
			}
		} catch (S3Exception $e) {
			echo $e->getMessage() . "\n";
		}
	}	
	/**
	 * Method Name: NX_bucket_delete_key
	 * Method Description: delete Bucket key from main bucket
	 * @params $buckenName = Bucket name
	 * @params $buketKey = Bucket Key for individual delete
	 * @return : bucket list
	 * @return type: object type
	 * access: Public
	 */
	public function NX_bucket_delete_key(String $bucketName, $buketKey = null){
		$s3Client = $this->NX_s3_config();
		try {
			$bucketNameData = $this->trim_bucket($bucketName);	
			if(strlen($buketKey) > 1){
				$result = $s3Client->deleteObject([
					'Bucket' => $bucketNameData,
					'Key' => trim($buketKey)
				]);
				return true;
			}else{
				return __('Please put bucket key', 'themedev-aws-s3');
			}
		} catch (S3Exception $e) {
			echo $e->getMessage() . "\n";
		}
	}
	/**
	 * Method Name: NX_file_upload
	 * Method Description: file upload in aws
	 * @params $configData = configaration aws
	 * @params $type = put, 
	 * @return : bucket list
	 * @return type: object type
	 * access: Public
	 */
	public function NX_file_upload(array $configData, $type ='put')
	{
		if(is_array($configData) && sizeof($configData) > 1){			
			$files   	= isset($configData['file']) ? $configData['file'] : '';
			if( !empty($files) ){
				
				$bucketName 	= isset($configData['bucket']) ? $configData['bucket'] : $this->bucket_defult;
				$filePath   	= isset($configData['file_path']) ? $configData['file_path'] : $this->path_defult;
				$createFile     = isset($configData['create_file']) ? $configData['create_file'] : 'default'; // random, default
				$aclPermision   = isset($configData['acl']) ? $configData['acl'] : 'public-read'; 
				$crop_status    = isset($configData['crop_status']) ? $configData['crop_status'] : 'no'; 
				$allowed_types  = isset($configData['allowed_types']) ? $configData['allowed_types'] : ''; 
				$upload_type    = isset($configData['upload_type']) ? $configData['upload_type'] : 'image'; 
				$crop_ratio     = isset($configData['crop_ratio']) ? $configData['crop_ratio'] : false; 
				$dimentions_full = isset($configData['dimentions_full']) ? $configData['dimentions_full'] : 'Yes'; 
				$dimentions     = isset($configData['dimentions']) ? $configData['dimentions'] : []; 
				
				$iptc_status   = isset($configData['iptc_status']) ? $configData['iptc_status'] : 'no'; 
				
				$file_name 		= isset($configData['name']) ? $configData['name'] : $files['name'];						
				$tem_file  		= isset($configData['tmp_name']) ? $configData['tmp_name'] : $files['tmp_name'];
				$file_type  	= isset($configData['type']) ? $configData['type'] : $files['type'];
				
				$extention = $this->file_ext($file_name);
					
				$getFileName = $this->create_file_random(basename($file_name), $createFile);
				
				$s3Client = $this->NX_s3_config();
				$mainFilePath = rtrim($filePath, '/'). '/' . $getFileName;
				
				// files allow type
				$allow = explode('|', $allowed_types);
				$allowType = $this->file_allow_type($allowed_types, $extention);
				if(!$allowType){
					return __('.'.$extention.' format not allowed', 'themedev-aws-s3');
				}
				if(empty($file_name)){
					return __('Sorry empty files name.', 'themedev-aws-s3');
				}
				if(empty($tem_file)){
					return __('Sorry empty tem files name.', 'themedev-aws-s3');
				}
				try {
					/*file Crop start*/
					$cropStatus = 'No';
					$returnData = [];
					if($crop_status == 'Yes' && $upload_type == 'image'){
						if( in_array($extention, $this->crop_allowed_types) ){
							list($width,$height) = $this->image_size($tem_file);
							if($dimentions_full == 'Yes'){
								
								 $mainFilePathFullData = rtrim($filePath, '/'). '/';
								 $filenameShort = explode('.', $getFileName);
								 $resized_fileFUll = $mainFilePathFullData.$filenameShort[0].'_full'.".".$extention;
								 $result = $s3Client->putObject(
										array(
											'Bucket'=> $bucketName,
											'Key' =>  $resized_fileFUll,
											'SourceFile' => $tem_file,
											'ContentType' => $file_type,
											'ACL' => $aclPermision
										)
									);
							
								$returnData['_full'] = $result->get('ObjectURL');
							}
							
							$cropStatus = 'Yes';
						}else{
							$sourceFile = $tem_file;
						}
					}else{
						$sourceFile = $tem_file;
					}
							
					if($cropStatus == 'Yes'){
						$mainFilePathData = rtrim($filePath, '/'). '/';
						
						$this->image_upload($tem_file, THE_DEV_AWS_PLUGIN_PATH.'/'.$mainFilePathData, $getFileName);
						
						if(is_array($dimentions) && sizeof($dimentions) > 0):
							$filenameShort = explode('.', $getFileName);
							$mm = 1;
							foreach($dimentions AS $dimention):
								$crop_suffix = isset($dimention['image_suffix']) ? $dimention['image_suffix'] : '_'.$mm;
								$cropSizeWidth = isset($dimention['imagewidth']) ? $dimention['imagewidth'] : '400';
								$cropSizeheight = isset($dimention['imageheight']) ? $dimention['imageheight'] : '400';
								
								$resized_file = $mainFilePathData.$filenameShort[0].$crop_suffix.".".$extention;
								
								if($this->image_resize(THE_DEV_AWS_PLUGIN_PATH.'/'.$mainFilePath, $resized_file, $cropSizeWidth, $cropSizeheight, $crop_ratio)){
									$s3Client->registerStreamWrapper();
									$result = $s3Client->putObject(
											array(
												'Bucket'=> $bucketName,
												'Key' =>  $resized_file,
												'SourceFile' => $resized_file,
												'ContentType' => $file_type,
												'ACL' => $aclPermision
											)
										);
								
									$returnData[$crop_suffix] = $result->get('ObjectURL');
									$mm++;
									$this->delete_file(THE_DEV_AWS_PLUGIN_PATH.'/'.$resized_file);
								}
							endforeach;
							// remove main file
							$this->delete_folder(THE_DEV_AWS_PLUGIN_PATH.'/'.rtrim($filePath, '/'));
							
							return $returnData;
						endif;
						
						$this->delete_file(THE_DEV_AWS_PLUGIN_PATH.'/'.$mainFilePath);
					}
					else
					{
						//$s3Client->registerStreamWrapper();
						if($type == 'put' ){
							$result = $s3Client->putObject(
										array(
											'Bucket'=> $bucketName,
											'Key' =>  $mainFilePath,
											'SourceFile' => $sourceFile,
											'ContentType' => $file_type,
											'ACL' => $aclPermision
										)
									);
							$returnData['_full'] = $result->get('ObjectURL');
						}else{
							$uploader = new MultipartUploader($s3Client, $sourceFile, [
								'Bucket'=> $bucketName,
								'Key' =>   $mainFilePath,
								'ACL' =>   $aclPermision,
							]);
							try {
								$result = $uploader->upload();
								$returnData['_full'] = $result['ObjectURL'];
							} catch (MultipartUploadException $e) {
								echo $e->getMessage() . PHP_EOL;
							}
						}
						
						return $returnData;
					}
				} catch (S3Exception $e) {
					die('Error:' . $e->getMessage());
				} catch (Exception $e) {
					die('Error:' . $e->getMessage());
				}
				
			}else{
				return 'Please select upload file';
			}
		}else{
			return 'Please config file info';
		}

	}
	/**
	 * Method Name: file_allow_type();
	 * Method Description: file allow typr chaeck
	 * @params: $file - get file location
	 * @return : file location
	 * access: private
	 */
	private function file_allow_type($allowed_types, $ext){
		if(strlen($allowed_types) > 2):
			$allow = explode('|', $allowed_types);
			if(is_array($allow) && sizeof($allow) > 0){
				if(in_array($ext, $allow)){
					return true;
				}else{
					return false;
				}
			}
		endif;
		return true;	
	}
	/**
	 * Method Name: create_image();
	 * Method Description: file crop data
	 * @params: $file - get file location
	 * @return : file location
	 * access: private
	 */
	private function create_image($tmp, $ext){
		
		switch($ext){
			 case 'bmp':
				$img = imagecreatefromwbmp($tmp);
				break;
			 case 'gif': 
				$img = imagecreatefromgif($tmp); 
				break;
			 case 'jpg': 
				$img = imagecreatefromjpeg($tmp); 
				break;
			 case 'png': 
				$img = imagecreatefrompng($tmp); 
				break;
			 default : 
				$img = imagecreatefromjpeg($tmp);
	   }
	return $img;
	}
	/**
	 * Method Name: image_resize();
	 * Method Description: resizeimage
	 * @params: $file - get file location
	 * @return : file location
	 * access: private
	 */
	private function image_resize($src, $dst, $width, $height, $crop = false){
	   $x = 0;
 	   if(!list($w, $h) = getimagesize($src)){ return "Unsupported picture type!"; }
	   
	   $type = $this->file_ext($src);
	   if($type == 'jpeg') {
		   $type = 'jpg'; 
		}
	   
	   $img = $this->create_image($src, $type);
	   // resize
	  
	   if($crop){
		 if($w < $width or $h < $height){
			 $ratio = max($width/$w, $height/$h);
			 $h = $height / $ratio;
			 $x = ($w - $width / $ratio) / 2;
			 $w = $width / $ratio;
		 }
	   }else{
		 if($w < $width and $h < $height) {
			 $ratio = min($width/$w, $height/$h);
			 $width = $w * $ratio;
			 $height = $h * $ratio;
			 $x = 0;
		 }
	   }

	   $new = imagecreatetruecolor($width, $height);
	   // preserve transparency
	   if($type == "gif" or $type == "png"){
		 imagecolortransparent($new, imagecolorallocatealpha($new, 0, 0, 0, 127));
		 imagealphablending($new, false);
		 imagesavealpha($new, true);
	   }
	   imagecopyresampled($new, $img, 0, 0, $x, 0, $width, $height, $w, $h);
	   switch($type){
		 case 'bmp': 
			imagewbmp($new, $dst); 
			break;
		 case 'gif': 
			imagegif($new, $dst); 
			break;
		 case 'jpg': 
			imagejpeg($new, $dst); 
			break;
		 case 'png': 
			imagepng($new, $dst); 
			break;
	   }
	   return true;
	 }
	 
	/**
	 * Method Name: image_upload();
	 * Method Description: upload file 
	 * @params: $file_name - get file name
	 * @params: $type - random, static
	 * @return : file extension
	 * access: private
	 */
	private function image_upload($file_temp, $file_path, $file_name){
		$this->create_path($file_path);
		if ( ! @copy($file_temp, $file_path.$file_name))
		{
			if ( ! @move_uploaded_file($file_temp, $file_path.$file_name))
			{
				return false;
			}else{
				$this->return_data = array('path' => $file_path, 'file_name' => $file_name, 'full_path' => $file_path.$file_name);
				return true;
			}
		}else{
			return false;
		}
		
	}
	/**
	 * Method Name: create_path();
	 * Method Description: create path
	 * @params: $file_name - get file name
	 * @params: $type - random, static
	 * @return : file extension
	 * access: private
	 */
	public function create_path($upload_path = ''){
		if(strlen($upload_path) > 3){
			$this->file_path = $upload_path;
		}else{
			$this->file_path = '';
		}
		
		if( !is_dir( $this->file_path ) ){
			@mkdir($this->file_path, 0777, TRUE );
		}
		
		return $this->file_path;
	}
	/**
	 * Method Name: file_ext();
	 * Method Description: cget file extention
	 * @params: $file_name - get file name
	 * @params: $type - random, static
	 * @return : file extension
	 * access: private
	 */
	private function file_ext($fileName = ''){
	    if(strlen($fileName) > 2){
			$file_exp 		= explode('.', $fileName);
			if(sizeof($file_exp) > 1){
				$this->extension = strtolower(end($file_exp)); 
			 }else{
				 $this->extension = '';
			 }
		}else{
			$this->extension = '';
		}
	  return $this->extension;
	}
	/**
	 * Method Name: create_file_random();
	 * Method Description: create ramdom file name
	 * @params: $file_name - get file name
	 * @params: $type - random, static
	 * @return : get file name
	 * access: private
	 */
	 
	private function create_file_random($file_name = '', $type = 'default'){
		if(strlen($file_name) > 3){
			$this->file_name = $file_name;
		}else{
			$this->file_name = 	time();
		}
		if($type == 'random'){
			$this->file_ext($this->file_name);
			$this->file_name = md5(strtolower(str_replace([' ', '.', '  ', '%', '#', '$'], "-", trim($this->file_name))).time()).'.'.$this->extension;
		}else{
			$this->file_name = strtolower(str_replace([' ', '  ', '%', '#', '$'], "-", trim($this->file_name)));
		}
		return $this->file_name;
	}
	/**
	 * Method Name: image_size();
	 * Method Description: create get image size file name
	 * @params: $file_name - get file name
	 * @params: $type - random, static
	 * @return : get file name
	 * access: private
	 */
	private function image_size($tmpFile){
		$this->file_size = getimagesize($tmpFile);
		return $this->file_size;
	}
	/**
	 * Method Name: delete_file();
	 * Method Description: delete file
	 * @params: $file_name - get file name
	 * @params: $type - random, static
	 * @return : get file name
	 * access: private
	 */
	private function delete_file($file = ''){
		if(file_exists($file)){
			@unlink($file);
		}
	}
	/**
	 * Method Name: delete_folder();
	 * Method Description: delete folder
	 * @params: $file_name - get file name
	 * @params: $type - random, static
	 * @return : get file name
	 * access: private
	 */
	private function delete_folder($getFolder = ''){
		if(strlen($getFolder) > 2){  
			$files = glob(''.$getFolder.'/*'); 
			foreach($files as $file){
				if(file_exists($file))
					@unlink($file); 
			}
		}
	}
	
	private function trim_bucket(String $bucketName){
		return str_replace( array("_",' ', '  '), '-', strtolower(trim($bucketName)) );		
	}
	
	 
 }