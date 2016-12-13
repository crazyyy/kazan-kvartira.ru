<div class="wrap">
  <div class="form-wrap">
    <div id="icon-edit" class="icon32 icon32-posts-post"><br>
    </div>
    <h2><?php _e('Wp photo text slider', 'wp-photo-text'); ?></h2>
    <?php
	$wp_50_title = get_option('wp_50_title');
	$wp_50_direction = get_option('wp_50_direction');
	$wp_50_speed = get_option('wp_50_speed');
	$wp_50_timeout = get_option('wp_50_timeout');
	$wp_50_type = get_option('wp_50_type');
	
	if (isset($_POST['wp_50_form_submit']) && $_POST['wp_50_form_submit'] == 'yes')
	{
		//	Just security thingy that wordpress offers us
		check_admin_referer('wp_50_form_setting');
			
		$wp_50_title = stripslashes($_POST['wp_50_title']);
		$wp_50_direction = stripslashes($_POST['wp_50_direction']);
		$wp_50_speed = stripslashes($_POST['wp_50_speed']);
		$wp_50_timeout = stripslashes($_POST['wp_50_timeout']);
		$wp_50_type = stripslashes($_POST['wp_50_type']);
		
		update_option('wp_50_title', $wp_50_title );
		update_option('wp_50_direction', $wp_50_direction );
		update_option('wp_50_speed', $wp_50_speed );
		update_option('wp_50_timeout', $wp_50_timeout );
		update_option('wp_50_type', $wp_50_type );
		
		?>
		<div class="updated fade">
			<p><strong><?php _e('Details successfully updated.', 'wp-photo-text'); ?></strong></p>
		</div>
		<?php
	}
	?>
	<script language="JavaScript" src="<?php echo WP_PHOTO_50_PLUGIN_URL; ?>/pages/setting.js"></script>
	<h3><?php _e('Slider setting', 'wp-photo-text'); ?></h3>
	<form name="wp_50_form" method="post" action="">
	
		<label for="tag-title"><?php _e('Widget title', 'wp-photo-text'); ?></label>
		<input name="wp_50_title" type="text" id="wp_50_title" size="50" value="<?php echo $wp_50_title; ?>" />
		<p><?php _e('Please enter widget title.', 'wp-photo-text'); ?></p>
		
		<label for="tag-title"><?php _e('Slider direction', 'wp-photo-text'); ?></label>
		<select name="wp_50_direction" id="wp_50_direction">
            <option value='scrollLeft' <?php if($wp_50_direction == 'scrollLeft') { echo 'selected' ; } ?>>scrollLeft</option>
            <option value='scrollRight' <?php if($wp_50_direction == 'scrollRight') { echo 'selected' ; } ?>>scrollRight</option>
            <option value='scrollUp' <?php if($wp_50_direction == 'scrollUp') { echo 'selected' ; } ?>>scrollUp</option>
            <option value='scrollDown' <?php if($wp_50_direction == 'scrollDown') { echo 'selected' ; } ?>>scrollDown</option>
          </select>
		<p><?php _e('Please select slider direction.', 'wp-photo-text'); ?></p>
		
		<label for="tag-title"><?php _e('Slider speed', 'wp-photo-text'); ?></label>
		<input name="wp_50_speed" type="text" id="wp_50_speed" value="<?php echo $wp_50_speed; ?>" />
		<p><?php _e('Speed of the slider.', 'wp-photo-text'); ?></p>
		
		<label for="tag-title"><?php _e('Slider timeout', 'wp-photo-text'); ?></label>
		<input name="wp_50_timeout" type="text" id="wp_50_timeout" value="<?php echo $wp_50_timeout; ?>" />
		<p><?php _e('Please enter your slider timeout.', 'wp-photo-text'); ?></p>
		
		<label for="tag-title"><?php _e('Slider image group', 'wp-photo-text'); ?></label>
		<select name="wp_50_type" id="wp_50_type">
		<?php
		$sSql = "SELECT distinct(wp_50_type) as wp_50_type FROM `".WP_PHOTO_50_TABLE."` order by wp_50_type";
		$myDistinctData = array();
		$arrDistinctDatas = array();
		$thisselected = "";
		$myDistinctData = $wpdb->get_results($sSql, ARRAY_A);
		foreach ($myDistinctData as $DistinctData)
		{
			if(strtoupper($DistinctData['wp_50_type']) == strtoupper($wp_50_type)) 
			{ 
				$thisselected = "selected='selected'" ; 
			}
			?><option value='<?php echo strtoupper($DistinctData['wp_50_type']); ?>' <?php echo $thisselected; ?>><?php echo strtoupper($DistinctData['wp_50_type']); ?></option><?php
			$thisselected = "";
		}
		?>
		</select>
		<p><?php _e('Please select your slider image group.', 'wp-photo-text'); ?></p>
		
		<div style="height:10px;"></div>
		<input type="hidden" name="wp_50_form_submit" value="yes"/>
		<input name="wp_50_submit" id="wp_50_submit" class="button add-new-h2" value="<?php _e('Submit', 'wp-photo-text'); ?>" type="submit" />
		<input name="publish" lang="publish" class="button add-new-h2" onclick="wp_50_redirect()" value="<?php _e('Cancel', 'wp-photo-text'); ?>" type="button" />
		<input name="Help" lang="publish" class="button add-new-h2" onclick="wp_50_help()" value="<?php _e('Help', 'wp-photo-text'); ?>" type="button" />
		<?php wp_nonce_field('wp_50_form_setting'); ?>
	</form>
  </div>
  <br />
<p class="description">
	<?php _e('Check official website for more information', 'wp-photo-text'); ?>
	<a target="_blank" href="<?php echo WP_PHOTO_50_FAV; ?>"><?php _e('click here', 'wp-photo-text'); ?></a>
</p>
</div>
