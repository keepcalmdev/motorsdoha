<section class="<?php echo esc_attr('themeDev-aws-body');?>">
	<?php require ( THE_DEV_AWS_PLUGIN_PATH.'views/admin/tab-menu.php' );?>
	<h2><?php echo esc_html__('Enable AWS S3 Service', 'themedev-aws-s3');?></h2>
	<?php if($message_status == 'yes'){?>
    <div class="">
        <div class ="notice is-dismissible" style="margin: 1em 0px; visibility: visible; opacity: 1;">
            <p><?php echo esc_html__(''.$message_text.' ', 'themedev-aws-s3');?></p>
            <button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php echo esc_html__('Dismiss this notice.', 'xs-social-login');?></span></button>
        </div>
    </div>
    <?php }?>
	<form action="<?php echo esc_url(admin_url().'admin.php?page=theme-dev-aws-s3-settings');?>" name="global_setting_aws_form" method="post" >
		<div class="<?php echo esc_attr('themeDev-aws-form');?>">
			<label for="aws_access_id">
				<?php echo esc_html__('AWS Access Id: ', 'themedev-aws-s3');?>
				<a href="<?php echo esc_url('https://aws.amazon.com/console/');?>" target="_blank">  <?php echo esc_html__('Get amazon s3 console credentials ', 'themedev-aws-s3');?></a>
			</label>
			<input class="themedev-input-text" placeholder="AKIAJEFDHJRAMN5QRG6JQ" type="text" id="aws_access_id" name="themedevaws[aws_access_id]" value="<?php echo isset($return_data_aws_credentials['aws_access_id']) ? esc_html($return_data_aws_credentials['aws_access_id']) : ''; ?>">
		</div>	
		<div class="<?php echo esc_attr('themeDev-aws-form');?>">
			<label for="aws_secret_access_key">
				<?php echo esc_html__('AWS Secret Access Key: ', 'themedev-aws-s3');?> 
			</label>	
			<input class="themedev-input-text" type="text" placeholder="OQO0K8xDJPHhDr8fn7DrEUkJfIN1IxMD5JhYo" id="aws_secret_access_key" name="themedevaws[aws_secret_access_key]" value="<?php echo isset($return_data_aws_credentials['aws_secret_access_key']) ? esc_html($return_data_aws_credentials['aws_secret_access_key']) : ''; ?>">
			
		</div>
		<div class="<?php echo esc_attr('themeDev-aws-form');?>">
			<button type="submit" name="themedev-aws-s3-config" class="themedev-aws-submit"> <?php echo esc_html__('Save ', 'themedev-aws-s3');?></button>
		</div>
	</form>
</section>

<section class="<?php echo esc_attr('themeDev-aws-body');?>" id="folder_path">
	<h2> <?php echo esc_html__('Set Region ', 'themedev-aws-s3');?></h2>
	
	<form action="<?php echo esc_url(admin_url().'admin.php?page=theme-dev-aws-s3-settings');?>" name="global_setting_aws_form" method="post" >
		<div class="<?php echo esc_attr('themeDev-aws-form');?>">
			<label for="aws_region_list">
				 <?php echo esc_html__('Select Region:', 'themedev-aws-s3');?>
			</label>
			<select name="themedevawsstore_region_list" class="themeDev-select" id="aws_region_list">
				<?php 
				if(is_array($regionList) AND sizeof($regionList) > 1):
					if(strlen($regionname) > 0){
						//$regionList = isset($regionList[$regionname]) ? [$regionname => $regionList[$regionname]]: $regionList;
					}
					foreach($regionList AS $regionKey=>$regionValue):	
					?>
					<option value="<?php echo esc_html($regionKey);?>" <?php echo (isset($regionname) && $regionname == $regionKey ) ? 'selected' : ''; ?>> <?php echo esc_html($regionValue) ;?> </option>
					<?php
					endforeach;
				endif;
				?>
			</select>
			
		</div>
		<div class="<?php echo esc_attr('themeDev-aws-form');?>">
			<button type="submit" name="themedev-set-tegion" class="themedev-aws-submit"> <?php echo esc_html__('Save ', 'themedev-aws-s3');?></button>
		</div>
	</form>
	
</section>
<section class="<?php echo esc_attr('themeDev-aws-body');?>" id="crop_dimentions">
	<h2> <?php echo esc_html__('Crop Dimentions ', 'themedev-aws-s3');?></h2>
	
	<form action="<?php echo esc_url(admin_url().'admin.php?page=theme-dev-aws-s3-settings');?>" name="global_setting_aws_form" method="post" >
		<div class="<?php echo esc_attr('themeDev-aws-form');?>">
			<label for="width_size">
				<?php echo esc_html__('Width [px]: ', 'themedev-aws-s3');?>
			</label>
			<input class="themedev-input-text" type="text" onkeyup="removeChar(this)"  onblur="removeChar(this)" id="width_size" name="themedevdimentions[width]" value="" placeholder="100">
		</div>	
		<div class="<?php echo esc_attr('themeDev-aws-form');?>">
			<label for="height_size">
				<?php echo esc_html__('Height  [px]: ', 'themedev-aws-s3');?> 
			</label>	
			<input class="themedev-input-text" type="text" onkeyup="removeChar(this)"  onblur="removeChar(this)"  id="height_size" name="themedevdimentions[height]" value="" placeholder="100">
			
		</div>
		<div class="<?php echo esc_attr('themeDev-aws-form');?>">
			<label for="prefix_size">
				<?php echo esc_html__('Prefix : ', 'themedev-aws-s3');?> 
			</label>	
			<input class="themedev-input-text" type="text" id="prefix_size" name="themedevdimentions[prefix]" value="" placeholder="_100x100">
			
		</div>
		<div class="<?php echo esc_attr('themeDev-aws-form');?>">
			<button type="submit" name="themedev-crop-dimantions-config" class="themedev-aws-submit"> <?php echo esc_html__('Add ', 'themedev-aws-s3');?></button>
		</div>
	</form>
	
</section>

<section class="<?php echo esc_attr('themeDev-aws-body');?>" >
	<h2> <?php echo esc_html__(' Dimentions List', 'themedev-aws-s3');?></h2>
	<table class="widefat fixed" cellspacing="0">
		<thead>
			<tr>
				<th style="width:20px;"> <strong><?php echo esc_html__(' SL. ', 'themedev-aws-s3');?></strong></th>
				<th > <strong> <?php echo esc_html__(' Width', 'themedev-aws-s3');?></strong></th>
				<th > <strong><?php echo esc_html__('Height', 'themedev-aws-s3');?></strong></th>
				<th > <strong><?php echo esc_html__(' Prefix', 'themedev-aws-s3');?></strong></th>
			</tr>
		</thead>
		
		<tbody>
	<?php
	if(is_array($return_data_aws_crop) && !empty($return_data_aws_crop) ):
		$m = 1;
		foreach($return_data_aws_crop AS $crop):
			$width = isset($crop['width']) ? $crop['width'] : '';
			$height = isset($crop['height']) ? $crop['height'] : '';
			$prefix = isset($crop['prefix']) ? $crop['prefix'] : '';
	?>
		
		<tr valign="middle"> 
			<td ><strong><?php echo $m; ?>. </strong></td>
			<td ><?php echo $width; ?></td>
			<td ><?php echo $height; ?></td>
			<td ><?php echo $prefix; ?></td>
		</tr>
		
	<?php 
		$m++;
		endforeach;
	endif;
	?>
		</tbody>
	</table>
</section>

<section class="<?php echo esc_attr('themeDev-aws-body');?>" id="folder_path">
	<h2> <?php echo esc_html__('Set Folder ', 'themedev-aws-s3');?></h2>
	
	<form action="<?php echo esc_url(admin_url().'admin.php?page=theme-dev-aws-s3-settings');?>" name="global_setting_aws_form" method="post" >
		<div class="<?php echo esc_attr('themeDev-aws-form');?>">
			<label for="default_folder">
				<input type="checkbox" name="default_folder"  id="default_folder"value="Yes"/> <?php echo esc_html__('Default Set', 'themedev-aws-s3');?>
			</label>
			<label for="width_size">
				<?php echo esc_html__('Path Name: ', 'themedev-aws-s3');?>
			</label>
			
			<input class="themedev-input-text" type="text" onkeyup="removeSpace(this)"  onblur="removeSpace(this)" id="width_size" name="folder_path" value="" placeholder="folder_name/folder_name">
			<p><small> <strong><?php echo esc_html__('Note: ', 'themedev-aws-s3');?> </strong><?php echo esc_html__(' you may create single folder path or nested folder path here.', 'themedev-aws-s3');?> <br/><strong>Like as </strong>: foldername or parent_foldername/child_foldername </small></p>
		</div>
		<div class="<?php echo esc_attr('themeDev-aws-form');?>">
			
		</div>		
		<div class="<?php echo esc_attr('themeDev-aws-form');?>">
			<button type="submit" name="themedev-folder-path-config" class="themedev-aws-submit"> <?php echo esc_html__('Add ', 'themedev-aws-s3');?></button>
		</div>
	</form>
	
</section>


<section class="<?php echo esc_attr('themeDev-aws-body');?>">
	<h2> <?php echo esc_html__(' Folder List', 'themedev-aws-s3');?></h2>
	<table class="widefat fixed" cellspacing="0">
		<thead>
			<tr>
				<th style="width:20px;"> <strong><?php echo esc_html__(' SL. ', 'themedev-aws-s3');?></strong></th>
				<th > <strong> <?php echo esc_html__(' Folder Name', 'themedev-aws-s3');?></strong></th>
				
			</tr>
		</thead>
		
		<tbody>
	<?php
	if(is_array($return_data_aws_folder) && !empty($return_data_aws_folder) ):
		$m = 1;
		foreach($return_data_aws_folder AS $folder):
			
	?>
		<tr valign="middle"> 
			<td ><strong><?php echo $m; ?>. </strong></td>
			<td ><?php echo $folder; ?></td>
		</tr>
		
	<?php 
		$m++;
		endforeach;
	endif;
	?>
		</tbody>
	</table>
</section>