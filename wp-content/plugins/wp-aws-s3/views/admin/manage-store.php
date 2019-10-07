<section class="<?php echo esc_attr('themeDev-aws-body');?>">
	<?php require ( THE_DEV_AWS_PLUGIN_PATH.'views/admin/tab-menu.php' );?>
	<h2> <?php echo esc_html__('Manage Store', 'themedev-aws-s3');?></h2>
	<div class="<?php echo esc_attr('themeDev-aws-form');?>">
		<ul class="manage-aws-themeDev">
		<?php
			if(isset($storeList['Buckets']) && is_array($storeList['Buckets']) && sizeof($storeList['Buckets']) > 0 ):
				$m = 1;
				foreach($storeList['Buckets'] AS $storeListData):
					$nameStore = isset($storeListData['Name']) ? $storeListData['Name'] : '';
			?>
				<li class="<?php echo ($getBucketName === $nameStore) ? 'active-store' : ''?>"><a href="<?php echo esc_url(admin_url().'admin.php?page=theme-dev-aws-s3&store='.$nameStore.'');?>"><span class="dashicons dashicons-admin-site-alt2"></span> <?php echo esc_html(ucwords(str_replace('-', ' ', $nameStore)));?> </a></li>
			<?php 
				$m++;
				endforeach;
			endif;
			?>
		</ul>
	</div>
</section>
<?php 
global $wp;
$current_url = add_query_arg( $_SERVER['QUERY_STRING'], '', admin_url('admin.php'. $wp->request ) );

if(isset($objcetList['Contents']) && is_array($objcetList['Contents']) && sizeof($objcetList['Contents']) > 0 ):
	$filearray=[];
	foreach($objcetList['Contents'] as $fileentry) {
		$patharray = array_reverse(explode('/', $fileentry['Key']));
		$thisarray = $this->themedev_aws_create_folder($patharray, $fileentry['Size'], $fileentry['Key']);
		$filearray = array_merge_recursive($filearray,$thisarray);
	}
	$fileList = isset($filearray['aws-files']) ? $filearray['aws-files'] : '';
	$folderDetils = isset($_GET['folder']) ? \TheDevAWSS3\Apps\Settings::sanitize($_GET['folder']) : [];
	if(!empty($folderDetils)){
		foreach($folderDetils as $f){
			$fileList = isset($fileList[$f]) ? $fileList[$f] : $fileList;
		}
	}
?>
<section class="<?php echo esc_attr('themeDev-aws-body');?>">
	<h2> <?php echo esc_html__('Store Files', 'themedev-aws-s3');?></h2>
		<div class="<?php echo esc_attr('themeDev-aws-form');?>">
			<ul class="manage-aws-themeDev">
				<?php
				if(is_array($fileList) && !empty($fileList)){
					$arrayFIl = $this->natkrsort($fileList);
					foreach($arrayFIl as $k=>$v):
						if(isset($v['name'])){
							$name = $v['name'];
							$size = $v['size'];
							$path = $v['path'];
							
							$urlDataFiles = $this->s3Services->NX_get_files($getBucketName, $path);
							$explodeFiles = explode('/', $urlDataFiles);
							$fileName = end($explodeFiles);
							$extFormat = explode('.', $fileName);
							$ext = strtolower(end($extFormat));
							
							
							if(in_array($ext, ['png', 'tiff', 'jpg', 'jpeg', 'svg', 'bmp', 'gif', 'ai'])){
								$htmlData = '<span class="dashicons dashicons-format-image"></span> ';
								$htmlData = '<img src="'.$urlDataFiles.'" alt="'.$fileName.'"/>';
							}else if(in_array($ext, ['pdf'])){
								$htmlData = '<span class="dashicons dashicons-media-spreadsheet"></span> ';
							}else if(in_array($ext, ['txt', 'json'])){
								$htmlData = '<span class="dashicons dashicons-media-text"></span> ';
							}else if(in_array($ext, ['php', 'html', 'htm', 'css', 'js', 'py', 'c', 'java'])){
								$htmlData = '<span class="dashicons dashicons-media-code"></span> ';
							}else if(in_array($ext, ['mp3'])){
								$htmlData = '<span class="dashicons dashicons-media-audio"></span> ';
							}else if(in_array($ext, ['mp4', 'avi', 'mkv', 'mov', 'flv', 'swf', 'wmv'])){
								$htmlData = '<span class="dashicons dashicons-media-video"></span> ';
							}else if(in_array($ext, ['zip', 'rar', 'tar', 'iso', 'mar'])){
								$htmlData = '<span class="dashicons dashicons-media-archive"></span> ';
							}else{
								$htmlData = '<span class="dashicons dashicons-admin-links"></span> ';
							}
							$length = (strlen($name) > 15) ? (strlen($name) - 10) : 0;
							if($length > 0){	
								$htmlData .= substr_replace($name, '...', -$length, -10);
							}else{
								$htmlData .= $name;
							}
							
						?>
							<li title="Size: <?php echo esc_html($this->formatSizeUnits($size));?>" class="bottom_content"><a target="_blank" href="<?php echo esc_url($urlDataFiles);?>"><?php echo $htmlData ;?> </a>
								<div class="over-info-link">
									<span class="dashicons dashicons-visibility" onclick="themedev_view_link(this)" themedev-link="<?php echo esc_url($urlDataFiles);?>"></span>
									<span class="dashicons dashicons-admin-links"  onclick="themedev_copy_link(this)" themedev-link="<?php echo esc_url($urlDataFiles);?>"></span>
									
								</div>
							</li>
						<?php	
						}else{
							$length = (strlen($k) > 15) ? (strlen($k) - 10) : 0;
							if($length > 0){	
								$folder = ucwords(substr_replace($k, '...', -$length, -10));
							}else{
								$folder = ucwords($k);
							}
						?>
							<li><a href="<?php echo esc_url($current_url);?>&folder[]=<?php echo $k;?>">
							<span class="dashicons dashicons-book"></span>
							<?php echo $folder;?> </a></li>
						<?php	
						}
					endforeach;
				}
				?>
			</ul>
		</div>
</section>
<?php endif;?>

<script>

function themedev_copy_link(idda){
	event.preventDefault();
	if(idda){
		var getLink = idda.getAttribute('themedev-link');
		var linkData = prompt("Copy link, then click OK.", getLink);
		if(linkData){
			document.execCommand("copy");
		}
	}
}

function themedev_view_link(idda){
	event.preventDefault();
	if(idda){
		var getLink = idda.getAttribute('themedev-link');
		if(getLink){
			//window.location.href = getLink;
			window.open(getLink);
		}
	}
}


</script>