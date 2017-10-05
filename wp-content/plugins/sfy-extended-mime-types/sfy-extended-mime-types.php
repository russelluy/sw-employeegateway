<?php
/*
	Plugin Name: AP Extended Mime Types
	Plugin URI: http://ardentpixels.com/josh/wordpress/plugins/ap-extended-mime-types/
	Description: Extends the allowed uploadable MIME types to include a WIDE range of file types. 
	Version: 1.0
	Author: Josh Maxwell (Ardent Pixels)
	Author URI: http://ardentpixels.com/josh
	License: GPL2
*/

/*  Copyright 2010 Josh Maxwell & Ardent Pixels

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

// Add the filter
add_filter('upload_mimes', 'sfy_extended_mime_types');

// Function to add mime types
function sfy_extended_mime_types ( $mimes ) {
	$mime_types=array();	

	// add your extension & app info to mime-types.txt in this format
	//	doc,doct application/msword
	//	pdf application/pdf
	//	etc...
	$file = fopen( plugin_dir_path( __FILE__ ) . 'mime-types.txt','r');

	if($file){
		// add as many as you like
		 while (($buffer = fgets($file)) !== false) {
        		$mime_type = explode(" ",rtrim(rtrim($buffer,"\n"),"\r"));
				$mime_types[$mime_type[0]] = $mime_type[1];
    		}
	}

	 $mimes = array_merge($mimes,$mime_types );
	
	return $mimes;
}

?>