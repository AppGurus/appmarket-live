<?php
/* 
 * This class is used to load template for a widget 
 * Author: admin@leafcolor.com
 * Version: 1.0 - 2013/11/1
 *
 */

// don't load directly
if ( !defined('ABSPATH') )
	die('-1');

if (!class_exists('Leafcolor_Template_Loader')) {
	class Leafcolor_Template_Loader{
		/**
		 * Loads theme files in appropriate hierarchy: 1) child theme,
		 * 2) parent template, 3) plugin resources. 
		 * Will look in the 
		 *     widget-views/
		 * directory in a theme and the 
				views/ 
		 * directory in the plugin/widget
		 *
		 * @param string $template template file to search for
		 * @return template path
		 **/
		public static function getTemplateHierarchy( $template) {
			// add .php extension if missing			 
			if ( substr($template, -4) != '.php' ) {
				$template .= '.php';
			}
			
			$template_base_paths = (array) (get_theme_root() . '/' . get_current_theme() . '/leafcolor-views/'); //change this folder name
			$template_base_paths[] = trailingslashit(  dirname(__FILE__) ) . '/views/';

			$file = '';
			foreach ( $template_base_paths as $template_base_path ) {
				$file = $template_base_path . $template;

				// return the first one found
				if ( file_exists( $file ) )
					break;
			}

			return $file;
		}
	}
}
	