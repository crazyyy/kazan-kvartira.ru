<div class="wrap">
<?php
$wp_50_errors = array();
$wp_50_success = '';
$wp_50_error_found = FALSE;

// Preset the form fields
$form = array(
	'wp_50_id' => '',
	'wp_50_path' => '',
	'wp_50_link' => '',
	'wp_50_target' => '',
	'wp_50_title' => '',
	'wp_50_order' => '',
	'wp_50_status' => '',
	'wp_50_type' => '',
	'wp_50_extra1' => '',
	'wp_50_extra2' => ''
);

// Form submitted, check the data
if (isset($_POST['wp_50_form_submit']) && $_POST['wp_50_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('wp_50_form_add');
	
	$form['wp_50_path'] = isset($_POST['wp_50_path']) ? $_POST['wp_50_path'] : '';
	$form['wp_50_link'] = isset($_POST['wp_50_link']) ? $_POST['wp_50_link'] : '';
	$form['wp_50_target'] = isset($_POST['wp_50_target']) ? $_POST['wp_50_target'] : '';
	$form['wp_50_title'] = isset($_POST['wp_50_title']) ? $_POST['wp_50_title'] : '';
	$form['wp_50_order'] = isset($_POST['wp_50_order']) ? $_POST['wp_50_order'] : '';
	$form['wp_50_status'] = isset($_POST['wp_50_status']) ? $_POST['wp_50_status'] : '';
	$form['wp_50_type'] = isset($_POST['wp_50_type']) ? $_POST['wp_50_type'] : '';
	$form['wp_50_extra1'] = isset($_POST['wp_50_extra1']) ? $_POST['wp_50_extra1'] : '';

	//	No errors found, we can add this Group to the table
	if ($wp_50_error_found == FALSE)
	{
		$sql = $wpdb->prepare(
			"INSERT INTO `".WP_PHOTO_50_TABLE."`
			(`wp_50_path`, `wp_50_link`, `wp_50_target`, `wp_50_title`, `wp_50_order`, `wp_50_status`, `wp_50_type`, `wp_50_extra1`)
			VALUES(%s, %s, %s, %s, %s, %s, %s, %s)",
			array($form['wp_50_path'], $form['wp_50_link'], $form['wp_50_target'], $form['wp_50_title'], 
					$form['wp_50_order'], $form['wp_50_status'], strtoupper($form['wp_50_type']), $form['wp_50_extra1'])
		);
		
		$wpdb->query($sql);
		
		$wp_50_success = __('New details was successfully added.', 'wp-photo-text');
		
		// Reset the form fields
		$form = array(
			'wp_50_id' => '',
			'wp_50_path' => '',
			'wp_50_link' => '',
			'wp_50_target' => '',
			'wp_50_title' => '',
			'wp_50_order' => '',
			'wp_50_status' => '',
			'wp_50_type' => '',
			'wp_50_extra1' => '',
			'wp_50_extra2' => ''
		);
	}
}

if ($wp_50_error_found == TRUE && isset($wp_50_errors[0]) == TRUE)
{
	?>
	<div class="error fade">
		<p><strong><?php echo $wp_50_errors[0]; ?></strong></p>
	</div>
	<?php
}
if ($wp_50_error_found == FALSE && strlen($wp_50_success) > 0)
{
	?>
	<div class="updated fade">
		<p><strong><?php echo $wp_50_success; ?>
		<a href="<?php echo WP_PHOTO_50_ADMIN_URL; ?>"><?php _e('Click here to view the details', 'wp-photo-text'); ?></a></strong></p>
	</div>
	<?php
}
?>
<script language="JavaScript" src="<?php echo WP_PHOTO_50_PLUGIN_URL; ?>/pages/setting.js"></script>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php _e('Wp photo text slider', 'wp-photo-text'); ?></h2>
	<form name="wp_50_form" method="post" action="#" onsubmit="return wp_50_submit()"  >
      <h3><?php _e('Add details', 'wp-photo-text'); ?></h3>
      
		<label for="tag-title"><?php _e('Enter image path (URL)', 'wp-photo-text'); ?></label>
		<input name="wp_50_path" type="text" id="wp_50_path" value="" size="123" />
		<p><?php _e('Where is the picture located on the internet', 'wp-photo-text'); ?> 
		(ex: http://www.gopiplus.com/work/wp-content/uploads/pluginimages/250x167/250x167_2.jpg)</p>
		
		<label for="tag-title"><?php _e('Enter target link', 'wp-photo-text'); ?></label>
		<input name="wp_50_link" type="text" id="wp_50_link" value="#" size="123" />
		<p><?php _e('When someone clicks on the picture, where do you want to send them.', 'wp-photo-text'); ?></p>
			
		<label for="tag-title"><?php _e('Select target option', 'wp-photo-text'); ?></label>
		<select name="wp_50_target" id="wp_50_target">
			<option value='_blank'>_blank</option>
			<option value='_parent'>_parent</option>
			<option value='_self'>_self</option>
			<option value='_new'>_new</option>
      	</select>
		<p><?php _e('Do you want to open link in new window?', 'wp-photo-text'); ?></p>
		
		<label for="tag-title"><?php _e('Enter heading (Title)', 'wp-photo-text'); ?></label>
		<input name="wp_50_extra1" type="text" id="wp_50_extra1" value="" size="123" />
		<p><?php _e('Enter your title.', 'wp-photo-text'); ?></p>
		
		<label for="tag-title"><?php _e('Enter description', 'wp-photo-text'); ?></label>
		<textarea name="wp_50_title" cols="120" rows="10" id="wp_50_title"></textarea>
		<p><?php _e('Enter your description.', 'wp-photo-text'); ?></p>
		
		<label for="tag-title"><?php _e('Select gallery type (This is to group the images)', 'wp-photo-text'); ?></label>
		<select name="wp_50_type" id="wp_50_type">
		<option value=''>Select</option>
		<?php
		$sSql = "SELECT distinct(wp_50_type) as wp_50_type FROM `".WP_PHOTO_50_TABLE."` order by wp_50_type";
		$myDistinctData = array();
		$arrDistinctDatas = array();
		$myDistinctData = $wpdb->get_results($sSql, ARRAY_A);
		$i = 0;
		foreach ($myDistinctData as $DistinctData)
		{
			$arrDistinctData[$i]["wp_50_type"] = strtoupper($DistinctData['wp_50_type']);
			$i = $i+1;
		}
		for($j=$i; $j<$i+5; $j++)
		{
			$arrDistinctData[$j]["wp_50_type"] = "GROUP" . $j;
		}
		$arrDistinctDatas = array_unique($arrDistinctData, SORT_REGULAR);
		foreach ($arrDistinctDatas as $arrDistinct)
		{
			?><option value='<?php echo strtoupper($arrDistinct["wp_50_type"]); ?>'><?php echo strtoupper($arrDistinct["wp_50_type"]); ?></option><?php
		}
		?>
		</select>
		<p><?php _e('This is to group the text. Select your slideshow group.', 'wp-photo-text'); ?></p>
		
		<label for="tag-title"><?php _e('Display status', 'wp-photo-text'); ?></label>
		<select name="wp_50_status" id="wp_50_status">
			<option value='YES'>Yes</option>
			<option value='NO'>No</option>
		</select>
		<p><?php _e('Do you want the display this in your slider?', 'wp-photo-text'); ?></p>
		
		<label for="tag-title"><?php _e('Display order', 'wp-photo-text'); ?></label>
		<input name="wp_50_order" type="text" id="wp_50_rder" size="10" value="1" maxlength="3" />
		<p><?php _e('Enter your display order.', 'wp-photo-text'); ?></p>
		
      <input name="wp_50_id" id="wp_50_id" type="hidden" value="">
      <input type="hidden" name="wp_50_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button add-new-h2" value="<?php _e('Insert Details', 'wp-photo-text'); ?>" type="submit" />&nbsp;
        <input name="publish" lang="publish" class="button add-new-h2" onclick="wp_50_redirect()" value="<?php _e('Cancel', 'wp-photo-text'); ?>" type="button" />&nbsp;
        <input name="Help" lang="publish" class="button add-new-h2" onclick="wp_50_help()" value="<?php _e('Help', 'wp-photo-text'); ?>" type="button" />
      </p>
	  <?php wp_nonce_field('wp_50_form_add'); ?>
    </form>
</div>
<p class="description">
	<?php _e('Check official website for more information', 'wp-photo-text'); ?>
	<a target="_blank" href="<?php echo WP_PHOTO_50_FAV; ?>"><?php _e('click here', 'wp-photo-text'); ?></a>
</p>
</div>