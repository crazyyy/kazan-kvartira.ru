<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
// Form submitted, check the data
if (isset($_POST['frm_wp_50_display']) && $_POST['frm_wp_50_display'] == 'yes')
{
	$did = isset($_GET['did']) ? intval($_GET['did']) : '0';
	if(!is_numeric($did)) { die('<p>Are you sure you want to do this?</p>'); }
	
	$wp_50_success = '';
	$wp_50_success_msg = FALSE;
	
	// First check if ID exist with requested ID
	$sSql = $wpdb->prepare(
		"SELECT COUNT(*) AS `count` FROM ".WP_PHOTO_50_TABLE."
		WHERE `wp_50_id` = %d",
		array($did)
	);
	$result = '0';
	$result = $wpdb->get_var($sSql);
	
	if ($result != '1')
	{
		?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist', 'wp-photo-text-slider-50'); ?></strong></p></div><?php
	}
	else
	{
		// Form submitted, check the action
		if (isset($_GET['ac']) && $_GET['ac'] == 'del' && isset($_GET['did']) && $_GET['did'] != '')
		{
			//	Just security thingy that wordpress offers us
			check_admin_referer('wp_50_form_show');
			
			//	Delete selected record from the table
			$sSql = $wpdb->prepare("DELETE FROM `".WP_PHOTO_50_TABLE."`
					WHERE `wp_50_id` = %d
					LIMIT 1", $did);
			$wpdb->query($sSql);
			
			//	Set success message
			$wp_50_success_msg = TRUE;
			$wp_50_success = __('Selected record was successfully deleted.', 'wp-photo-text-slider-50');
		}
	}
	
	if ($wp_50_success_msg == TRUE)
	{
		?><div class="updated fade"><p><strong><?php echo $wp_50_success; ?></strong></p></div><?php
	}
}
?>
<div class="wrap">
  <div id="icon-edit" class="icon32 icon32-posts-post"></div>
    <h2><?php _e('Wp photo text slider', 'wp-photo-text-slider-50'); ?>
	<a class="add-new-h2" href="<?php echo WP_PHOTO_50_ADMIN_URL; ?>&amp;ac=add"><?php _e('Add New', 'wp-photo-text-slider-50'); ?></a></h2>
    <div class="tool-box">
	<?php
		$sSql = "SELECT * FROM `".WP_PHOTO_50_TABLE."` order by wp_50_type, wp_50_order";
		$myData = array();
		$myData = $wpdb->get_results($sSql, ARRAY_A);
		?>
		<script language="JavaScript" src="<?php echo WP_PHOTO_50_PLUGIN_URL; ?>/pages/setting.js"></script>
		<form name="frm_wp_50_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
			<th scope="col"><?php _e('Type / Group', 'wp-photo-text-slider-50'); ?></th>
            <th scope="col"><?php _e('Heading', 'wp-photo-text-slider-50'); ?></th>
			<th scope="col"><?php _e('Image', 'left-right-image-slideshow-gallery'); ?></th>
			<th scope="col"><?php _e('URL', 'left-right-image-slideshow-gallery'); ?></th>
			<th scope="col"><?php _e('Target', 'wp-photo-text-slider-50'); ?></th>
            <th scope="col"><?php _e('Order', 'wp-photo-text-slider-50'); ?></th>
            <th scope="col"><?php _e('Display', 'wp-photo-text-slider-50'); ?></th>
          </tr>
        </thead>
		<tfoot>
          <tr>
			<th scope="col"><?php _e('Type / Group', 'wp-photo-text-slider-50'); ?></th>
            <th scope="col"><?php _e('Heading', 'wp-photo-text-slider-50'); ?></th>
			<th scope="col"><?php _e('Image', 'left-right-image-slideshow-gallery'); ?></th>
			<th scope="col"><?php _e('URL', 'left-right-image-slideshow-gallery'); ?></th>
			<th scope="col"><?php _e('Target', 'wp-photo-text-slider-50'); ?></th>
            <th scope="col"><?php _e('Order', 'wp-photo-text-slider-50'); ?></th>
            <th scope="col"><?php _e('Display', 'wp-photo-text-slider-50'); ?></th>
          </tr>
        </tfoot>
		<tbody>
			<?php 
			$i = 0;
			if(count($myData) > 0 )
			{
				foreach ($myData as $data)
				{
					?>
					<tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
						<td><?php echo strtoupper(stripslashes($data['wp_50_type'])); ?>
						<div class="row-actions">
						<span class="edit"><a title="Edit" href="<?php echo WP_PHOTO_50_ADMIN_URL; ?>&amp;ac=edit&amp;did=<?php echo $data['wp_50_id']; ?>"><?php _e('Edit', 'wp-photo-text-slider-50'); ?></a> | </span>
						<span class="trash"><a onClick="javascript:wp_50_delete('<?php echo $data['wp_50_id']; ?>')" href="javascript:void(0);"><?php _e('Delete', 'wp-photo-text-slider-50'); ?></a></span> 
						</div>
						</td>
						<td><?php echo stripslashes($data['wp_50_extra1']); ?></td>
						<td><a href="<?php echo esc_html($data['wp_50_path']); ?>" target="_blank"><img src="<?php echo WP_PHOTO_50_PLUGIN_URL; ?>/inc/image-icon.png"  /></a></td>
						<td><a href="<?php echo esc_html($data['wp_50_link']); ?>" target="_blank"><img src="<?php echo WP_PHOTO_50_PLUGIN_URL; ?>/inc/link-icon.gif"  /></a></td>
						<td><?php echo stripslashes($data['wp_50_target']); ?></td>
						<td><?php echo stripslashes($data['wp_50_order']); ?></td>
						<td><?php echo stripslashes($data['wp_50_status']); ?></td>
					</tr>
					<?php 
					$i = $i+1; 
				} 
			}
			else
			{
				?><tr><td colspan="7" align="center"><?php _e('No records available.', 'wp-photo-text-slider-50'); ?></td></tr><?php 
			}
			?>
		</tbody>
        </table>
		<?php wp_nonce_field('wp_50_form_show'); ?>
		<input type="hidden" name="frm_wp_50_display" value="yes"/>
      </form>	
	<div class="tablenav bottom">
		<a href="<?php echo WP_PHOTO_50_ADMIN_URL; ?>&amp;ac=add"><input class="button action" type="button" value="<?php _e('Add New', 'wp-photo-text-slider-50'); ?>" /></a>
		<a href="<?php echo WP_PHOTO_50_ADMIN_URL; ?>&amp;ac=set"><input class="button action" type="button" value="<?php _e('Setting Management', 'wp-photo-text-slider-50'); ?>" /></a>
		<a target="_blank" href="<?php echo WP_PHOTO_50_FAV; ?>"><input class="button action" type="button" value="<?php _e('Help', 'wp-photo-text-slider-50'); ?>" /></a>
	</div>
	<h3><?php _e('Plugin configuration option', 'wp-photo-text-slider-50'); ?></h3>
	<ol>
		<li><?php _e('Add the plugin in the posts or pages using short code.', 'wp-photo-text-slider-50'); ?></li>
		<li><?php _e('Add directly in to the theme using PHP code.', 'wp-photo-text-slider-50'); ?></li>
		<li><?php _e('Drag and drop the widget to your sidebar.', 'wp-photo-text-slider-50'); ?></li>
	</ol>
	<p class="description">
		<?php _e('Check official website for more information', 'wp-photo-text-slider-50'); ?>
		<a target="_blank" href="<?php echo WP_PHOTO_50_FAV; ?>"><?php _e('click here', 'wp-photo-text-slider-50'); ?></a>
	</p>
	</div>
</div>