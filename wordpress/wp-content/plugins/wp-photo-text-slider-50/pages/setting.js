/**
 *     Wp photo text slider 50
 *     Copyright (C) 2011 - 2015 www.gopiplus.com
 * 
 *     This program is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 * 
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 * 
 *     You should have received a copy of the GNU General Public License
 *     along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

function wp_50_submit()
{
	if(document.wp_50_form.wp_50_path.value=="")
	{
		alert("Please enter the image path.")
		document.wp_50_form.wp_50_path.focus();
		return false;
	}
	else if(document.wp_50_form.wp_50_type.value=="")
	{
		alert("Select gallery type, This is to group the images.")
		document.wp_50_form.wp_50_type.focus();
		return false;
	}
	else if(document.wp_50_form.wp_50_status.value=="")
	{
		alert("Please select the display status.")
		document.wp_50_form.wp_50_status.focus();
		return false;
	}
	else if(document.wp_50_form.wp_50_order.value=="")
	{
		alert("Please enter the display order, only number.")
		document.wp_50_form.wp_50_order.focus();
		return false;
	}
	else if(isNaN(document.wp_50_form.wp_50_order.value))
	{
		alert("Please enter the display order, only number.")
		document.wp_50_form.wp_50_order.focus();
		return false;
	}
}

function wp_50_delete(id)
{
	if(confirm("Do you want to delete this record?"))
	{
		document.frm_wp_50_display.action="options-general.php?page=wp-photo-text-slider-50&ac=del&did="+id;
		document.frm_wp_50_display.submit();
	}
}	

function wp_50_redirect()
{
	window.location = "options-general.php?page=wp-photo-text-slider-50";
}

function wp_50_help()
{
	window.open("http://www.gopiplus.com/work/2011/06/02/wordpress-plugin-wp-photo-slider-50/");
}