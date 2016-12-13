<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
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
	
	$form['wp_50_path'] 	= isset($_POST['wp_50_path']) ? esc_url_raw($_POST['wp_50_path']) : '';
	$form['wp_50_link'] 	= isset($_POST['wp_50_link']) ? esc_url_raw($_POST['wp_50_link']) : '';
	$form['wp_50_target'] 	= isset($_POST['wp_50_target']) ? sanitize_text_field($_POST['wp_50_target']) : '';
	$form['wp_50_title'] 	= isset($_POST['wp_50_title']) ? sanitize_text_field($_POST['wp_50_title']) : '';
	$form['wp_50_order'] 	= isset($_POST['wp_50_order']) ? intval($_POST['wp_50_order']) : '';
	$form['wp_50_status'] 	= isset($_POST['wp_50_status']) ? sanitize_text_field($_POST['wp_50_status']) : '';
	$form['wp_50_type'] 	= isset($_POST['wp_50_type']) ? sanitize_text_field($_POST['wp_50_type']) : '';
	$form['wp_50_extra1'] 	= isset($_POST['wp_50_extra1']) ? sanitize_text_field($_POST['wp_50_extra1']) : '';
	
	if($form['wp_50_status'] != "YES" && $form['wp_50_status'] != "NO")
	{
		$form['wp_50_status'] = "YES";
	}
	
	if($form['wp_50_target'] != "_blank" && $form['wp_50_target'] != "_parent" && $form['wp_50_target'] != "_self" && $form['wp_50_target'] != "_new")
	{
		$form['wp_50_target'] = "_blank";
	}

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
		
		$wp_50_success = __('New details was successfully added.', 'wp-photo-text-slider-50');
		
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
		<a href="<?php echo WP_PHOTO_50_ADMIN_URL; ?>"><?php _e('Click here to view the details', 'wp-photo-text-slider-50'); ?></a></strong></p>
	</div>
	<?php
}
?>
<script language="JavaScript" src="<?php echo WP_PHOTO_50_PLUGIN_URL; ?>/pages/setting.js"></script>
<script type="text/javascript">
jQuery(document).ready(function($){
    $('#upload-btn').click(function(e) {
        e.preventDefault();
        var image = wp.media({ 
            title: 'Upload Image',
            // mutiple: true if you want to upload multiple files at once
            multiple: false
        }).open()
        .on('select', function(e){
            // This will return the selected image from the Media Uploader, the result is an object
            var uploaded_image = image.state().get('selection').first();
            // We convert uploaded_image to a JSON object to make accessing it easier
            // Output to the console uploaded_image
            console.log(uploaded_image);
            var img_imageurl = uploaded_image.toJSON().url;
			var img_imagetitle = uploaded_image.toJSON().title;
            // Let's assign the url value to the input field
            $('#wp_50_path').val(img_imageurl);
			$('#wp_50_extra1').val(img_imagetitle);
        });
    });
});
</script>
<?php
wp_enqueue_script('jquery'); // jQuery
wp_enqueue_media(); // This will enqueue the Media Uploader script
?>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php _e('Wp photo text slider', 'wp-photo-text-slider-50'); ?></h2>
	<form name="wp_50_form" method="post" action="#" onsubmit="return wp_50_submit()"  >
      <h3><?php _e('Add details', 'wp-photo-text-slider-50'); ?></h3>
      
		<label for="tag-title"><?php _e('Enter image path (URL)', 'wp-photo-text-slider-50'); ?></label>
		<input name="wp_50_path" type="text" id="wp_50_path" value="" size="93" />
		<input type="button" name="upload-btn" id="upload-btn" class="button-secondary" value="Upload Image">
		<p><?php _e('Where is the picture located on the internet', 'wp-photo-text-slider-50'); ?> 
		(ex: http://www.gopiplus.com/work/wp-content/uploads/pluginimages/250x167/250x167_2.jpg)</p>
		
		<label for="tag-title"><?php _e('Enter target link', 'wp-photo-text-slider-50'); ?></label>
		<input name="wp_50_link" type="text" id="wp_50_link" value="#" size="93" />
		<p><?php _e('When someone clicks on the picture, where do you want to send them.', 'wp-photo-text-slider-50'); ?></p>
			
		<label for="tag-title"><?php _e('Select target option', 'wp-photo-text-slider-50'); ?></label>
		<select name="wp_50_target" id="wp_50_target">
			<option value='_blank'>_blank</option>
			<option value='_parent'>_parent</option>
			<option value='_self'>_self</option>
			<option value='_new'>_new</option>
      	</select>
		<p><?php _e('Do you want to open link in new window?', 'wp-photo-text-slider-50'); ?></p>
		
		<label for="tag-title"><?php _e('Enter heading (Title)', 'wp-photo-text-slider-50'); ?></label>
		<input name="wp_50_extra1" type="text" id="wp_50_extra1" value="" size="93" />
		<p><?php _e('Enter your title.', 'wp-photo-text-slider-50'); ?></p>
		
		<label for="tag-title"><?php _e('Enter description', 'wp-photo-text-slider-50'); ?></label>
		<textarea name="wp_50_title" cols="90" rows="10" id="wp_50_title"></textarea>
		<p><?php _e('Enter your description.', 'wp-photo-text-slider-50'); ?></p>
		
		<label for="tag-title"><?php _e('Select gallery type (This is to group the images)', 'wp-photo-text-slider-50'); ?></label>
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
		<p><?php _e('This is to group the text. Select your slideshow group.', 'wp-photo-text-slider-50'); ?></p>
		
		<label for="tag-title"><?php _e('Display status', 'wp-photo-text-slider-50'); ?></label>
		<select name="wp_50_status" id="wp_50_status">
			<option value='YES'>Yes</option>
			<option value='NO'>No</option>
		</select>
		<p><?php _e('Do you want the display this in your slider?', 'wp-photo-text-slider-50'); ?></p>
		
		<label for="tag-title"><?php _e('Display order', 'wp-photo-text-slider-50'); ?></label>
		<input name="wp_50_order" type="text" id="wp_50_rder" size="10" value="1" maxlength="3" />
		<p><?php _e('Enter your display order.', 'wp-photo-text-slider-50'); ?></p>
		
      <input name="wp_50_id" id="wp_50_id" type="hidden" value="">
      <input type="hidden" name="wp_50_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button add-new-h2" value="<?php _e('Insert Details', 'wp-photo-text-slider-50'); ?>" type="submit" />&nbsp;
        <input name="publish" lang="publish" class="button add-new-h2" onclick="wp_50_redirect()" value="<?php _e('Cancel', 'wp-photo-text-slider-50'); ?>" type="button" />&nbsp;
        <input name="Help" lang="publish" class="button add-new-h2" onclick="wp_50_help()" value="<?php _e('Help', 'wp-photo-text-slider-50'); ?>" type="button" />
      </p>
	  <?php wp_nonce_field('wp_50_form_add'); ?>
    </form>
</div>
<p class="description">
	<?php _e('Check official website for more information', 'wp-photo-text-slider-50'); ?>
	<a target="_blank" href="<?php echo WP_PHOTO_50_FAV; ?>"><?php _e('click here', 'wp-photo-text-slider-50'); ?></a>
</p>
</div>