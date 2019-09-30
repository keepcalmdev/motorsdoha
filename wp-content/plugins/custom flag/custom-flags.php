<?php
/**
 * Plugin Name: Custom flags
 * Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
 * Description: A brief description of the Plugin.
 * Version: The Plugin's Version Number, e.g.: 1.0
 * Author: MatviichukY
 * Author URI: http://URI_Of_The_Plugin_Author
 * License: A "Slug" license name e.g. GPL2
 */

/*  Copyright YEAR  PLUGIN_AUTHOR_NAME  (email : PLUGIN AUTHOR EMAIL)
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
/**
 * Change flags folder path for certain languages.
 *
 * Add the language codes you wish to replace in the list below.
 * Make sure you place your desired flags in a folder called "flags" next to this file.
 * Make sure the file names for the flags  are identical with the ones in the original folder located at 'plugins/translatepress/assets/images/flags/'.
 * If you wish to change the file names, use filter trp_flag_file_name .
 *
 */

add_filter( 'trp_flags_path', 'trpc_flags_path', 10, 2 );
function trpc_flags_path( $original_flags_path,  $language_code ){

	// only change the folder path for the following languages:
	$languages_with_custom_flags = array( 'ar' );

	if ( in_array( $language_code, $languages_with_custom_flags ) ) {
		return  plugin_dir_url( __FILE__ ) . '/flags/' ;
	}else{
		return $original_flags_path;
	}
}