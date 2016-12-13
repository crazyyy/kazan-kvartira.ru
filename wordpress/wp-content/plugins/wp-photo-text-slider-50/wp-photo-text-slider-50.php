<?php
/*
Plugin Name: Wp photo text slider 50
Plugin URI: http://www.gopiplus.com/work/2011/06/02/wordpress-plugin-wp-photo-slider-50/
Description:  Wordpress plugin Wp photo text slider 50 create a photo (photo + heading + description) slider on the wordpress website.
Author: Gopi Ramasamy
Version: 7.1
Author URI: http://www.gopiplus.com/work/2011/06/02/wordpress-plugin-wp-photo-slider-50/
Donate link: http://www.gopiplus.com/work/2011/06/02/wordpress-plugin-wp-photo-slider-50/
Tags: wordpress, plugin, photo, slider
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wp-photo-text-slider-50
Domain Path: /languages
*/

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

global $wpdb, $wp_version;
define("WP_PHOTO_50_TABLE", $wpdb->prefix . "wp_photo_50");
define('WP_PHOTO_50_FAV', 'http://www.gopiplus.com/work/2011/06/02/wordpress-plugin-wp-photo-slider-50/');

if ( ! defined( 'WP_PHOTO_50_BASENAME' ) )
	define( 'WP_PHOTO_50_BASENAME', plugin_basename( __FILE__ ) );
	
if ( ! defined( 'WP_PHOTO_50_PLUGIN_NAME' ) )
	define( 'WP_PHOTO_50_PLUGIN_NAME', trim( dirname( WP_PHOTO_50_BASENAME ), '/' ) );
	
if ( ! defined( 'WP_PHOTO_50_PLUGIN_URL' ) )
	define( 'WP_PHOTO_50_PLUGIN_URL', plugins_url() . '/' . WP_PHOTO_50_PLUGIN_NAME );
	
if ( ! defined( 'WP_PHOTO_50_ADMIN_URL' ) )
	define( 'WP_PHOTO_50_ADMIN_URL', admin_url() . 'options-general.php?page=wp-photo-text-slider-50' );

function wp_50_slider() 
{
	global $wpdb;
	$wp_50_random = "";
	$wp_50_direction = stripslashes(get_option('wp_50_direction'));
	$wp_50_speed = stripslashes(get_option('wp_50_speed'));
	$wp_50_timeout = stripslashes(get_option('wp_50_timeout'));
	$wp_50_type = stripslashes(get_option('wp_50_type'));
	
	$sSql = "select * from ".WP_PHOTO_50_TABLE." where wp_50_status='YES' and wp_50_type='$wp_50_type'";
	if($wp_50_random == "YES")
	{
		$sSql  = $sSql . " ORDER BY rand()";
	}
	else
	{
		$sSql  = $sSql . " ORDER BY wp_50_order";
	}
	
	$data = $wpdb->get_results($sSql);

	if ( ! empty($data) ) 
	{
		?>
		<!-- begin wp_50_photo -->
		<div id="wp_50_photo">
		<?php
		$ivrss_count = 0;
		foreach ( $data as $data ) 
		{
			$wp_50_path = $data->wp_50_path;
			$wp_50_link = $data->wp_50_link;
			$wp_50_target = $data->wp_50_target;
			$wp_50_title = stripslashes($data->wp_50_title);
			?>
			<div class="post">
				<div class="thumb">
                <?php if($wp_50_link <> "") { ?><a target="<?php echo $wp_50_target; ?>" href="<?php echo $wp_50_link; ?>"><?php } ?>
                <img style="border: 0px; margin: 0px;" src="<?php echo $wp_50_path; ?>" alt="wp photo slider" />
                <?php if($wp_50_link <> "") { ?></a><?php } ?>
                </div>
                <?php if($wp_50_title <> "") { ?><p><?php echo $wp_50_title; ?></p><?php } ?>
			</div>
			<?php
		}
		?>
		</div>
		<script type="text/javascript">
			jQuery(function() {
			jQuery('#wp_50_photo').cycle({
				fx: '<?php echo @$wp_50_direction; ?>',
				speed: <?php echo @$wp_50_speed; ?>,
				timeout: <?php echo @$wp_50_timeout; ?>
			});
			});
			</script> 
		<!-- end wp_50_photo -->
		<?php
	}
	else
	{
		echo "No images available for this group ". $wp_50_type;
	}
}

function wp_50_install() 
{
	add_option('wp_50_title', "Photo Slider");
	add_option('wp_50_direction', "scrollLeft");
	add_option('wp_50_speed', "700");
	add_option('wp_50_timeout', "5000");
	add_option('wp_50_type', "gallery1");
	
	global $wpdb;
	if($wpdb->get_var("show tables like '". WP_PHOTO_50_TABLE . "'") != WP_PHOTO_50_TABLE) 
	{
		$sSql = "CREATE TABLE IF NOT EXISTS `". WP_PHOTO_50_TABLE . "` (";
		$sSql = $sSql . "`wp_50_id` INT NOT NULL AUTO_INCREMENT ,";
		$sSql = $sSql . "`wp_50_path` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,";
		$sSql = $sSql . "`wp_50_link` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,";
		$sSql = $sSql . "`wp_50_target` VARCHAR( 50 ) NOT NULL ,";
		$sSql = $sSql . "`wp_50_title` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,";
		$sSql = $sSql . "`wp_50_order` INT NOT NULL ,";
		$sSql = $sSql . "`wp_50_status` VARCHAR( 10 ) NOT NULL ,";
		$sSql = $sSql . "`wp_50_type` VARCHAR( 100 ) NOT NULL ,";
		$sSql = $sSql . "`wp_50_extra1` VARCHAR( 100 ) NOT NULL ,";
		$sSql = $sSql . "`wp_50_extra2` VARCHAR( 100 ) NOT NULL ,";
		$sSql = $sSql . "`wp_50_date` datetime NOT NULL default '0000-00-00 00:00:00' ,";
		$sSql = $sSql . "PRIMARY KEY ( `wp_50_id` )";
		$sSql = $sSql . ") ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
		$wpdb->query($sSql);
		
		$IsSql = "INSERT INTO `". WP_PHOTO_50_TABLE . "` (`wp_50_path`, `wp_50_link`, `wp_50_target` , `wp_50_title` , `wp_50_order` , `wp_50_status` , `wp_50_type` , `wp_50_extra1` , `wp_50_date`)"; 
		$title = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";
		$i = 1;
		for($i=1; $i<6; $i++)
		{
			$sSql = $IsSql . " VALUES ('".WP_PHOTO_50_PLUGIN_URL."/images/sing_$i.jpg', '#', '_parent', '$title', '$i', 'YES', 'gallery1', 'Wp photo slider $i', '0000-00-00 00:00:00');";
			$wpdb->query($sSql);
			$sSql = "";
		}
	}
}

function wp_50_admin_options() 
{
	global $wpdb;
	$current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
	switch($current_page)
	{
		case 'edit':
			include('pages/image-management-edit.php');
			break;
		case 'add':
			include('pages/image-management-add.php');
			break;
		case 'set':
			include('pages/image-setting.php');
			break;
		default:
			include('pages/image-management-show.php');
			break;
	}
}

function wp_50_show_shortcode( $atts ) 
{
	global $wpdb;
	$wp_50 = "";
	$wp_50_random = "";
	
	//[wp-photo-slider type="gallery1" direction="scrollUp" random="YES"]
	if ( ! is_array( $atts ) )
	{
		return '';
	}
	$wp_50_type = $atts['type'];
	$wp_50_direction = $atts['direction'];
	$wp_50_random = $atts['random'];
	
	$wp_50_speed = stripslashes(get_option('wp_50_speed'));
	$wp_50_timeout = stripslashes(get_option('wp_50_timeout'));
	
	if(!is_numeric($wp_50_speed)) {	$wp_50_speed = 700; }
	if(!is_numeric($wp_50_timeout)) { $wp_50_timeout = 5000; }
	
	$wp_50_pluginurl = get_option('siteurl') . "/wp-content/plugins/wp-photo-text-slider-50";
    
    $wp_50 = $wp_50 .'<div id="wp_50_photo1">';

	$sSql = "select * from ".WP_PHOTO_50_TABLE." where wp_50_status='YES' and wp_50_type='$wp_50_type'";

	if($wp_50_random == "YES")
	{
		$sSql  = $sSql . " ORDER BY rand()";
	}
	else
	{
		$sSql  = $sSql . " ORDER BY wp_50_order";
	}
	//echo $sSql;
	$data = $wpdb->get_results($sSql);

	if ( ! empty($data) ) 
	{
		$wp_50_count = 0;
		foreach ( $data as $data ) 
		{
			$wp_50_path = stripslashes($data->wp_50_path);
			$wp_50_link = stripslashes($data->wp_50_link);
			$wp_50_target = stripslashes($data->wp_50_target);
			$wp_50_title = stripslashes($data->wp_50_title);
			$wp_50_extra1 = stripslashes($data->wp_50_extra1);
			
			$wp_50 = $wp_50 .'<div class="post">';
			
			if($wp_50_extra1 <> "") 
			{ 
				$wp_50 = $wp_50."<h2>".$wp_50_extra1."</h2>"; 
			}
			
			$wp_50 = $wp_50 .'<div class="thumb">';
			
			if($wp_50_link <> "") 
			{
				$wp_50 = $wp_50 .'<a target="'.$wp_50_target.'" href="'.$wp_50_link.'">';
			}
			
			if($wp_50_path <> "") 
			{		
				$wp_50 = $wp_50 .'<img style="border: 0px; margin: 0px;" src="'.$wp_50_path.'" alt="'.$wp_50_extra1.'" />';
			}
			
			if($wp_50_link <> "") 
			{ 
				$wp_50 = $wp_50 .'</a>';
			}
			
			$wp_50 = $wp_50 .'</div>';
			
			if($wp_50_title <> "") 
			{ 
				$wp_50 = $wp_50."<p>".$wp_50_title."</p>"; 
			}
				
			$wp_50 = $wp_50 .'</div>';
		}
		
		$wp_50 = $wp_50 .'</div>';
		$wp_50 = $wp_50 . '<script type="text/javascript">';
		$wp_50 = $wp_50 . 'jQuery(function() {';
		$wp_50 = $wp_50 . "jQuery('#wp_50_photo1').cycle({fx: '".$wp_50_direction."',speed: 700,timeout: 5000";
		$wp_50 = $wp_50 . '});';
		$wp_50 = $wp_50 . '});';
		$wp_50 = $wp_50 . '</script>';
	}
	else
	{
		$wp_50 = $wp_50 . 'No images available for this group '. $wp_50_type;
	}
	return $wp_50;
}

function wp_50_add_to_menu() 
{
	add_options_page(__('Wp photo text slider', 'wp-photo-text-slider-50'), 
			__('Wp photo text slider', 'wp-photo-text-slider-50'), 'manage_options', 'wp-photo-text-slider-50', 'wp_50_admin_options' );
}

if (is_admin()) 
{
	add_action('admin_menu', 'wp_50_add_to_menu');
}

function wp_50_control() 
{
	echo '<p><b>';
	_e('Wp photo text slider', 'wp-photo-text-slider-50');
	echo '.</b> ';
	_e('Check official website for more information', 'wp-photo-text-slider-50');
	?> <a target="_blank" href="<?php echo WP_PHOTO_50_FAV; ?>"><?php _e('click here', 'wp-photo-text-slider-50'); ?></a></p><?php
}

function wp_50_widget($args) 
{
	extract($args);
	echo $before_widget . $before_title;
	echo get_option('wp_50_title');
	echo $after_title;
	wp_50_slider();
	echo $after_widget;
}

function wp_50_widget_init() 
{
	if(function_exists('wp_register_sidebar_widget')) 	
	{
		wp_register_sidebar_widget( __('Wp photo text slider 50', 'wp-photo-text-slider-50'), __('Wp photo text slider 50', 'wp-photo-text-slider-50'), 'wp_50_widget');
	}
	
	if(function_exists('wp_register_widget_control')) 	
	{
		wp_register_widget_control( __('Wp photo text slider 50', 'wp-photo-text-slider-50'), array( __('Wp photo text slider 50', 'wp-photo-text-slider-50'), 'widgets'), 'wp_50_control');
	} 
}

function wp_50_add_javascript_files() 
{
	if (!is_admin())
	{
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery.cycle.all.latest', WP_PHOTO_50_PLUGIN_URL.'/js/jquery.cycle.all.latest.js');
		wp_enqueue_style('wp-photo-text-slider-50', WP_PHOTO_50_PLUGIN_URL.'/wp-photo-text-slider-50.css');
	}	
}

function wp_50_deactivation() 
{
	// No action required.
}

function wp_50_textdomain() 
{
	  load_plugin_textdomain( 'wp-photo-text-slider-50', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

add_action('plugins_loaded', 'wp_50_textdomain');
add_shortcode( 'wp-photo-slider', 'wp_50_show_shortcode' );
add_action('init', 'wp_50_add_javascript_files');
add_action("plugins_loaded", "wp_50_widget_init");
register_activation_hook(__FILE__, 'wp_50_install');
register_deactivation_hook(__FILE__, 'wp_50_deactivation');
?>