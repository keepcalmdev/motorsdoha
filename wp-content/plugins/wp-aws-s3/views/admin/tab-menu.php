<?php
$active_tab = isset($_GET["page"]) ? $_GET["page"] : 'theme-dev-aws-s3';
?>
 <h2 class="nav-tab-wrapper">
	<a href="?page=theme-dev-aws-s3" class="nav-tab <?php if($active_tab == 'theme-dev-aws-s3'){echo 'nav-tab-active';} ?> "><?php echo esc_html__('Manage Store', 'themedev-aws-s3');?></a>
	<a href="?page=theme-dev-aws-s3-new-store" class="nav-tab <?php if($active_tab == 'theme-dev-aws-s3-new-store'){echo 'nav-tab-active';} ?> "><?php echo esc_html__('Create Store', 'themedev-aws-s3');?></a>
	<a href="?page=theme-dev-aws-s3-upload-file" class="nav-tab <?php if($active_tab == 'theme-dev-aws-s3-upload-file'){echo 'nav-tab-active';} ?>"><?php echo esc_html__('Upload Files', 'themedev-aws-s3');?></a>
	<a href="?page=theme-dev-aws-s3-settings" class="nav-tab <?php if($active_tab == 'theme-dev-aws-s3-settings'){echo 'nav-tab-active';} ?>"><?php echo esc_html__('Settings', 'themedev-aws-s3');?></a>
</h2>