<section class="<?php echo esc_attr('themeDev-aws-body');?>">
	<?php require ( THE_DEV_AWS_PLUGIN_PATH.'views/admin/tab-menu.php' );?>
	<h2> <?php echo esc_html__('Upload Files', 'themedev-aws-s3');?></h2>
	<?php if($message_status == 'yes'){?>
	<div class="">
		<div class ="notice is-dismissible" style="margin: 1em 0px; visibility: visible; opacity: 1;">
			<p><?php echo esc_html__(''.$message_text.'', 'themedev-aws-s3');?></p>
			<button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php echo esc_html__('Dismiss this notice.', 'xs-social-login');?></span></button>
		</div>
	</div>
	<?php }?>
	<?php
	if(is_array($file_list) && sizeof($file_list) > 0):
	?>
		<div class="form-box-item full copy-link-item-section">
		
	<?php
		$ml = 1;
		foreach($file_list as $extraFileLink):
			echo '<p><strong> '.$ml.'. </strong> <input type="text" id="copyLinkText__'.$ml.'" value="'.$extraFileLink.'" /> <button onclick="copyLinkItem('.$ml.');" title="Copy Link"> <span class="wp-menu-image dashicons-before dashicons-admin-links" title="Copy Link"></span> </button></p>';
			$ml++;
		endforeach;
		?>
		
		</div>
		<?php
	endif;
	?>
</section>
<section class="<?php echo esc_attr('themeDev-aws-body');?>">
		<form action="<?php echo esc_url(admin_url().'admin.php?page=theme-dev-aws-s3-upload-file');?>" name="global_setting_aws_form" method="post" enctype="multipart/form-data" class="themeDev-aws-formall">
			<div class="<?php echo esc_attr('themeDev-left-div');?>">	
				<div class="<?php echo esc_attr('themeDev-aws-form');?>">
					<label for="aws_region_list">
						 <?php echo esc_html__('Select Store : ', 'themedev-aws-s3');?> <a href="<?php echo esc_url(admin_url().'admin.php?page=theme-dev-aws-s3-new-store');?>">  <?php echo esc_html__('New store ', 'themedev-aws-s3');?></a>
					</label>
					<select name="themedevawsstore[upload_store_name]" class="themeDev-select" id="aws_region_list">
						<option value=""> Select store </option>
						<?php 
						if(isset($storeList['Buckets']) && is_array($storeList['Buckets']) && sizeof($storeList['Buckets']) > 0 ):
							foreach($storeList['Buckets'] AS $storeListData):
							$nameStore = isset($storeListData['Name']) ? $storeListData['Name'] : '';
						?>
							<option value="<?= $nameStore;?>" > <?php echo esc_html( $nameStore );?> </option>
						<?php
							endforeach;
						endif;
						?>
					</select>
					
				</div>
				<div class="<?php echo esc_attr('themeDev-aws-form');?>">
					<label for="aws_region_list">
						 <?php echo esc_html__('Select Region:', 'themedev-aws-s3');?>
					</label>
					<select name="themedevawsstore[region_list]" class="themeDev-select" id="aws_region_list">
						<?php 
						if(is_array($regionList) AND sizeof($regionList) > 1):
							if(strlen($regionname) > 0){
								$regionList = isset($regionList[$regionname]) ? [$regionname => $regionList[$regionname]]: $regionList;
							}
							foreach($regionList AS $regionKey=>$regionValue):
								
							?>
							<option value="<?php echo esc_html($regionKey);?>" <?php echo (isset($regionname) && $regionname == $regionKey ) ? 'selected' : ''; ?> > <?php echo esc_html($regionValue) ;?> </option>
							<?php
							endforeach;
						endif;
						?>
					</select>
					
				</div>
				
				<div class="<?php echo esc_attr('themeDev-aws-form');?>">
					<label for="aws_region_folder_path">
						 <?php echo esc_html__('Select Folder:', 'themedev-aws-s3');?>
						 
					</label>
						
					<select name="themedevawsstore[upload_folder_name]" onchange="custom_folder_aws(this);" class="themeDev-select" id="aws_region_folder_path">
						<option value=""> Select Folder </option>
						<option value="custom"> Custom Folder </option>
						<?php 
						if(isset($return_data_aws_folder) && is_array($return_data_aws_folder) && sizeof($return_data_aws_folder) > 0 ):
							foreach($return_data_aws_folder AS $folder):
							if( strlen($folder) > 1){
						?>
							<option value="<?= $folder;?>" <?php echo (isset($folderDefult) && $folderDefult == $folder ) ? 'selected' : ''; ?> > <?php echo esc_html( $folder );?> </option>
						<?php
							}
							endforeach;
						endif;
						?>
					</select>
					
				</div>
				<div class="<?php echo esc_attr('themeDev-aws-form');?>" id="aws_path_folder_div" style="display:none;">
					<label for="width_size">
						<?php echo esc_html__('Custom Path: ', 'themedev-aws-s3');?>
					</label>
					<input class="themedev-input-text" type="text" onkeyup="removeSpace(this)"  onblur="removeSpace(this)" id="width_size" name="folder_path" value="" placeholder="folder_name/folder_name">
					<p><small> <strong><?php echo esc_html__('Note: ', 'themedev-aws-s3');?></strong><?php echo esc_html__('you may create single folder path or nested folder path here. ', 'themedev-aws-s3');?><br/><strong>Like as </strong>: foldername or parent_foldername/child_foldername </small></p>
				</div>
				<div class="<?php echo esc_attr('themeDev-aws-form');?>">
					<label for="aws_persion_list">
						 <?php echo esc_html__('Permission', 'themedev-aws-s3');?>
					</label>	
					<select name="themedevawsstore[acl_permision]" class="themeDev-select" id="aws_persion_list">
						
						<?php 
						if(is_array($aclList) AND sizeof($aclList) > 1):
							foreach($aclList AS $aclKey=>$aclValue):
						?>
							<option value="<?= esc_html($aclKey);?>" <?php echo (isset($permission) && $permission == $aclKey ) ? 'selected' : ''; ?>> <?php echo esc_html($aclValue) ;?> </option>
						<?php
							endforeach;
						endif;
						?>
					</select>
					
				</div>	
				<div class="<?php echo esc_attr('themeDev-aws-form');?>">
					<label for="aws_region_list">
						 <?php echo esc_html__('Select Files:', 'themedev-aws-s3');?>
					</label>
					<div class="nx-step3_property">
						<div class="nx-image-upload" >
							<?php
							$imageNameTham = THE_DEV_AWS_PLUGIN_URL.'assets/images/no-image-icon-6.png';
							?>
							<div class="theme_devp_for_image">
								<img src="<?php echo esc_url( $imageNameTham ); ?>" class="themedev-shadow_image" id="show_image__thambal"/>
								<input class="form-control select_image" name="upload-files[]" type="file" id="item_images__extra" multiple>
							</div>	
						</div>
					</div>
					
				</div>
				
				
				<div class="<?php echo esc_attr('themeDev-aws-form');?>">
					<button type="submit" name="themedev-aws-files-upload" class="themedev-aws-submit"> <?php echo esc_html__('Upload', 'themedev-aws-s3');?></button>
				</div>
			
		</div>
		<div class="<?php echo esc_attr('themeDev-right-div');?>">
			<div class="<?php echo esc_attr('themeDev-aws-form');?>">
				<label for="aws_region_folder_pathCrop">
					 <?php echo esc_html__('Crop Status:', 'themedev-aws-s3');?>
					 
				</label>
				<input class="themedev_switch_button" onchange="enable_crop_status(this)" type="checkbox" id="crop_status_theme" name="themedevawsstore[crop_status_theme]" value="Yes"  >	
				<label for="crop_status_theme"  class="themedev_switch_button_label small"> <?php echo __('Yes, No ', 'themedev-aws-s3')?></label>
                            
			</div>
			<div class="<?php echo esc_attr('themeDev-aws-form disable_themeDev_div');?> " id="themeDev_div_enable__crop_status_theme">
				<label for="aws_region_folder_path">
					 <?php echo esc_html__('Crop Dimentions:', 'themedev-aws-s3');?>
					<a href="<?php echo esc_url(admin_url().'admin.php?page=theme-dev-aws-s3-settings#crop_dimentions');?>"> <?php echo esc_html__('New Dimention', 'themedev-aws-s3');?> </a>
				</label>
				<ul class="theme-dev-ul-left">
				<?php 
				if(isset($return_data_aws_crop) && is_array($return_data_aws_crop) && sizeof($return_data_aws_crop) > 0 ):
					$m = 1;
					foreach($return_data_aws_crop AS $cropDimention):
					if( is_array($cropDimention) && sizeof($cropDimention) > 1){
						$width = isset($cropDimention['width']) ? $cropDimention['width'] : '';
						$height = isset($cropDimention['height']) ? $cropDimention['height'] : '';
						$prefix = isset($cropDimention['prefix']) ? $cropDimention['prefix'] : '';
						
						if(strlen($width) > 1 && strlen($height) > 1 ){
				?>
					<li>
					<label for="dimen__<?php echo $m;?>">
						<input type="checkbox" id="dimen__<?php echo $m;?>" checked name="crop_dimention[]" value="<?php echo esc_html($width);?>___<?php echo esc_html($height);?>___<?php echo esc_html($prefix);?>"/> <?php echo esc_html($prefix);?> (W:<?php echo esc_html($width);?>px, h:<?php echo esc_html($height);?>px)
					</label>
					</li>
				<?php
						}
					}
					$m++;
					endforeach;
				endif;
				?>
				<li>
					<label for="dimen__full">
						<input type="checkbox" id="dimen__full" checked name="themedevawsstore[crop_dimention_full]" value="Yes"/> <?php echo esc_html('_full');?> (W:full, h:full)
					</label>
				</li>
				</ul>
				<label for="aws_radio_centerCrop">
					 <?php echo esc_html__('Crop Ratio Center:', 'themedev-aws-s3');?>
					 
				</label>
				<input class="themedev_switch_button" type="checkbox" id="aws_radio_center" name="themedevawsstore[aws_radio_center]" value="Yes"  >	
				<label for="aws_radio_center"  class="themedev_switch_button_label small"> <?php echo __('Yes, No ', 'themedev-aws-s3')?></label>
                   
			</div>
			<div class="<?php echo esc_attr('themeDev-aws-form');?>">
				<label for="aws_randdomfiles">
					 <?php echo esc_html__('Random File:', 'themedev-aws-s3');?>
					 
				</label>
				<input class="themedev_switch_button" type="checkbox" id="aws_randdomfiles_create" name="themedevawsstore[aws_random_files_create]" value="Yes"  >	
				<label for="aws_randdomfiles_create"  class="themedev_switch_button_label small"> <?php echo __('Yes, No ', 'themedev-aws-s3')?></label>
                   
			</div>
		</div>
	</form>
</section>
