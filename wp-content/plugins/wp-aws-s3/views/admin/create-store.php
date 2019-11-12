<section class="<?php echo esc_attr('themeDev-aws-body');?>">
	<?php require ( THE_DEV_AWS_PLUGIN_PATH.'views/admin/tab-menu.php' );?>
	<h2> <?php echo esc_html__('Create Store', 'themedev-aws-s3');?></h2>
	<?php if($message_status == 'yes'){?>
    <div class="">
        <div class ="notice is-dismissible" style="margin: 1em 0px; visibility: visible; opacity: 1;">
            <p><?php echo esc_html__(''.$message_text.'', 'themedev-aws-s3');?></p>
            <button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php echo esc_html__('Dismiss this notice.', 'xs-social-login');?></span></button>
        </div>
    </div>
    <?php }?>
	<form action="<?php echo esc_url(admin_url().'admin.php?page=theme-dev-aws-s3-new-store');?>" name="global_setting_aws_form" method="post" >
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
					<option value="<?php echo esc_html($regionKey);?>" <?php echo (isset($regionname) && $regionname == $regionKey ) ? 'selected' : ''; ?>> <?php echo esc_html($regionValue) ;?> </option>
					<?php
					endforeach;
				endif;
				?>
			</select>
			
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
			<label for="aws_store_name">
				<?php echo esc_html__('Store Name', 'themedev-aws-s3');?>
				[<small> Example: themedev-store-name</small>]: 
			</label>	
			<input class="themedev-input-text" type="text" id="aws_store_name" name="themedevawsstore[store_name]" value="<?php echo (isset($storename) && strlen($storename) > 0 ) ? $storename : ''; ?>">
			
		</div>
		<div class="<?php echo esc_attr('themeDev-aws-form');?>">
			<button type="submit" name="themedev-aws-create-store" class="themedev-aws-submit"> <?php echo esc_html__('Create', 'themedev-aws-s3');?></button>
		</div>
	</form>
</section>

<section class="<?php echo esc_attr('themeDev-aws-body');?>">
	<h2> <?php echo esc_html__(' Store List', 'themedev-aws-s3');?></h2>
	<table class="widefat fixed" cellspacing="0">
		<thead>
			<tr>
				<th style="width:20px;"> <strong> <?php echo esc_html__('SL.', 'themedev-aws-s3');?></strong></th>
				<th > <strong><?php echo esc_html__('Store Name ', 'themedev-aws-s3');?></strong></th>
				<th > <strong><?php echo esc_html__('Action', 'themedev-aws-s3');?></strong></th>
			</tr>
		</thead>
		
		<tbody>
	<?php
	if(isset($storeList['Buckets']) && is_array($storeList['Buckets']) && sizeof($storeList['Buckets']) > 0 ):
		$m = 1;
		foreach($storeList['Buckets'] AS $storeListData):
			$nameStore = isset($storeListData['Name']) ? $storeListData['Name'] : '';
	?>
		
		<tr valign="middle"> 
			<td ><strong><?php echo $m; ?>. </strong></td>
			<td ><?php echo isset($storeListData['Name']) ? esc_html( $storeListData['Name'] ) : ''; ?></td>
			<td >
				<div class="row-actions" style="left: 0px;">
					<span><a href="<?php echo esc_url(admin_url().'admin.php?page=theme-dev-aws-s3&store='.esc_html($nameStore).'');?>"><?php echo esc_html__('Manage', 'themedev-aws-s3');?></a> |</span>
					<span><a href="<?php echo esc_url(admin_url().'admin.php?page=theme-dev-aws-s3');?>"><?php echo esc_html__('Action', 'themedev-aws-s3');?></a></span>
				</div>
			</td>
		</tr>
		
	<?php 
		$m++;
		endforeach;
	endif;
	?>
		</tbody>
	</table>
</section>