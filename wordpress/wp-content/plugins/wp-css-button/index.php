<?php
/*
Plugin Name: WP CSS Button
Plugin URI: http://www.59-media.de/wordpress-plugin-wp-css-button/
Description: Adds a fancy CSS Button inside your blog. Just add [CSSBUTTON target="http://www.milchrausch.de" color="ff0000" float="left"]Button Caption[/CSSBUTTON] inside your blogpost. This plugin will replace this with a nice css button
Version: 1.6
Author: Hauke Leweling | 59 MEDIA
Author URI: http://www.59-media.de/
Update Server: http://www.59-media.de/
Min WP Version: 2.7.0
Max WP Version: 3.1
*/

add_action('wp_head', 'addHeaderCode');
add_shortcode('CSSBUTTON', 'cssbutton_func');

function cssbutton_func($Attributes, $Content = null)
{
	extract(shortcode_atts( array(
      'target' => 'http://www.milchrausch.de',
      'color' => '690',
	  'textcolor' => 'fff',
	  'float' => 'left',
	  'newwindow' => 'false'
	), $Attributes));
	
	$color 		= str_replace("#","",$color);
	$textcolor 	= str_replace("#","",$textcolor);
	$target		= $target;
	$float		= $float;
	
	$ReturnValue = '<div class="button_col" style="background-color:#'.$color.';float:'.$float.';"><a href="'.$target.'" style="color:#'.$textcolor.';"';
	
	if($newwindow == 'true')
	    $ReturnValue .= ' target="_blank"';
	
	$ReturnValue .= '>'.do_shortcode($Content).'</a><span></span></div><div class="clear"></div>';
	
	return $ReturnValue;
}

function wp_css_button($Caption = null, $TargetURL = null, $BackgroundColor = null, $TextColor = null, $Float=null, $NewWindow = false)
{
	if(is_null($TargetURL))	{
		$TargetURL = "http://www.59-media.de";
	}
	
	if(is_null($Caption))	{
		$Caption = "WP CSS Button";
	}
	
	if(is_null($Float)) {
		$Float = "left";
	}
	
	if(is_null($TextColor))	{
		$TextColor = "FFFFFF";
	} else {
		$TextColor = str_replace("#", "", $TextColor);
	}
	
	if(is_null($BackgroundColor)) {
		$BackgroundColor = "000000";
	}else {
		$BackgroundColor = str_replace("#", "", $BackgroundColor);
	}
	
	if($NewWindow == true) {
	    $Window = " target=\"_blank\"";
	} else {
	    $Window = "";
	}
	
	echo '<div class="button_col" style="background-color:#'.$BackgroundColor.';float:'.$float.';"><a href="'.$TargetURL.'" style="color:#'.$TextColor.';" '.$Window.'>'.do_shortcode($Caption).'</a><span></span></div><div class="clear"></div>';
}

function addHeaderCode() 
{
	echo '<link type="text/css" rel="stylesheet" href="' . get_bloginfo('wpurl') . '/wp-content/plugins/wp-css-button/wp_button.css" />' . "\n";
}
?>