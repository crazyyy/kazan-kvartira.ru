<?php
// Form submitted, check the data
if (isset($_POST['frm_wp_50_display']) && $_POST['frm_wp_50_display'] == 'yes')
{
	$did = isset($_GET['did']) ? $_GET['did'] : '0';
	
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
		?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist', 'wp-photo-text'); ?></strong></p></div><?php
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
			$wp_50_success = __('Selected record was successfully deleted.', 'wp-photo-text');
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
    <h2><?php _e('Wp photo text slider', 'wp-photo-text'); ?>
	<a class="add-new-h2" href="<?php echo WP_PHOTO_50_ADMIN_URL; ?>&amp;ac=add"><?php _e('Add New', 'wp-photo-text'); ?></a></h2>
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
            <th class="check-column" scope="row"><input type="checkbox" /></th>
			<th scope="col"><?php _e('Type / Group', 'wp-photo-text'); ?></th>
            <th scope="col"><?php _e('Heading', 'wp-photo-text'); ?></th>
			<th scope="col"><?php _e('Target', 'wp-photo-text'); ?></th>
            <th scope="col"><?php _e('Order', 'wp-photo-text'); ?></th>
            <th scope="col"><?php _e('Display', 'wp-photo-text'); ?></th>
          </tr>
        </thead>
		<tfoot>
          <tr>
            <th class="check-column" scope="row"><input type="checkbox" /></th>
			<th scope="col"><?php _e('Type / Group', 'wp-photo-text'); ?></th>
            <th scope="col"><?php _e('Heading', 'wp-photo-text'); ?></th>
			<th scope="col"><?php _e('Target', 'wp-photo-text'); ?></th>
            <th scope="col"><?php _e('Order', 'wp-photo-text'); ?></th>
            <th scope="col"><?php _e('Display', 'wp-photo-text'); ?></th>
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
						<td align="left"><input type="checkbox" value="<?php echo $data['wp_50_id']; ?>" name="wp_50_group_item[]"></td>
						<td><?php echo strtoupper(stripslashes($data['wp_50_type'])); ?>
						<div class="row-actions">
						<span class="edit"><a title="Edit" href="<?php echo WP_PHOTO_50_ADMIN_URL; ?>&amp;ac=edit&amp;did=<?php echo $data['wp_50_id']; ?>"><?php _e('Edit', 'wp-photo-text'); ?></a> | </span>
						<span class="trash"><a onClick="javascript:wp_50_delete('<?php echo $data['wp_50_id']; ?>')" href="javascript:void(0);"><?php _e('Delete', 'wp-photo-text'); ?></a></span> 
						</div>
						</td>
						<td><a href="<?php echo stripslashes($data['wp_50_path']); ?>" target="_blank"><?php echo stripslashes($data['wp_50_extra1']); ?></a></td>
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
				?><tr><td colspan="6" align="center"><?php _e('No records available.', 'wp-photo-text'); ?></td></tr><?php 
			}
			?>
		</tbody>
        </table>
		<?php wp_nonce_field('wp_50_form_show'); ?>
		<input type="hidden" name="frm_wp_50_display" value="yes"/>
      </form>	
	  <div class="tablenav">
	  <h2>
	  <a class="button add-new-h2" href="<?php echo WP_PHOTO_50_ADMIN_URL; ?>&amp;ac=add"><?php _e('Add New', 'wp-photo-text'); ?></a>
	  <a class="button add-new-h2" href="<?php echo WP_PHOTO_50_ADMIN_URL; ?>&amp;ac=set"><?php _e('Setting Management', 'wp-photo-text'); ?></a>
	  <a class="button add-new-h2" target="_blank" href="<?php echo WP_PHOTO_50_FAV; ?>"><?php _e('Help', 'wp-photo-text'); ?></a>
	  </h2>
	  </div>
		<div style="height:5px"></div>
		<h3><?php _e('Plugin configuration option', 'wp-photo-text'); ?></h3>
		<ol>
			<li><?php _e('Add the plugin in the posts or pages using short code.', 'wp-photo-text'); ?></li>
			<li><?php _e('Add directly in to the theme using PHP code.', 'wp-photo-text'); ?></li>
			<li><?php _e('Drag and drop the widget to your sidebar.', 'wp-photo-text'); ?></li>
		</ol>
		<p class="description">
			<?php _e('Check official website for more information', 'wp-photo-text'); ?>
			<a target="_blank" href="<?php echo WP_PHOTO_50_FAV; ?>"><?php _e('click here', 'wp-photo-text'); ?></a>
		</p>
	</div>
</div>