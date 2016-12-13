=== WP CSS Button (CTA-Button Plugin) ===
Contributors: joghurtKULTUR
Donate link: http://www.59-media.de
Tags: CSS, button, cta, cta button, css button, post, posts, buttons, link, hyperlink
Requires at least: 2.7.0
Tested up to: 3.2.5
Stable Tag: 1.6

The Wordpress Plugin WP CSS BUTTON is a simple and easy to configurable plugin to create CSS based CTA Buttons inside your blog.

== Description ==

The Wordpress Plugin *WP CSS BUTTON* is a simple and easy to configurable Wordpress plugin which allows to create CSS based CTA Buttons inside your blog.

I would be the happiest guy in the world if you write a little blogpost about my plugin :-)

Just add the following line inside your blogpost

`[CSSBUTTON target="http://www.linktarget.com" color="000000" textcolor="ffffff" float="left" newwindow="true"]Button Caption[/CSSBUTTON]` 

* **target** = The target the button will link to. Like the href tag in a hyperlink
* **color** = The color property is optional. This is the background color of the button
* **textcolor** = The color property is optional. This is te textcolor of the caption text.
* **float** = position of the button inside your post
* **newwindow** = Use true or false to open link in a new window. If attribute is not set, the link opens in the same window 

The color will be set in hex codes like

* FFFFFF for white
* 000000 for black
* FF0000 for red


WP CSS BUTTON will convert these line to a nice button

**New in Version 1.4**
If you need an WP CSS Button outside your posts just use the following line in your template
`<?php 
if(function_exists("wp_css_button")) {
	wp_css_button("Button", "http://www.link.de", "FFFFFF", "000000", "right");
} 
?>`

1. Param is the Caption 
1. Param is the Link 
1. Param is the Textcolor 
1. Param is the Backgroundcolor 
1. Param is the float position
1. Param is for open the link in a new window (_blank)

**Contact**

* Developer Home [59 MEDIA - Suchmaschinenoptimierung](http://www.59-media.de/)
* Plugins Page [WP CSS Button](http://www.59-media.de/wordpress-plugin-wp-css-button/)
* 59 MEDIA on [Twitter](http://www.twitter.com/59MEDIA)

**Plugin in Action**

If you want to see the Wordpress CTA Button in action, take a look at these Websites

* [Microsim Tipps](http://www.microsim-tipps.de/fonic-veroffentlicht-preise-fur-seine-micro-sim-ipad-tarife/)
* [Kleidermotten](http://www.kleidermotten.eu/schlupfwespen-gegen-kleidermotten/)

== Changelog ==

= 1.6 =
* added attribute newwindow 

= 1.5.1 =
* Implemented recursive shortcodes. Now you can use [CSSBUTTON][another_shortcode /][CSSBUTTON/] for example multi language support or other fancy features

= 1.5 =
* Implemented float-attribute

= 1.4 =
* Implemented the use outside of posts
* Fixed an CSS-Error with underlined buttons

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the plugin folder folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Screenshots ==

1. This is an example of the button inside your blogpost
2. This is an example of the button inside your blogpost

