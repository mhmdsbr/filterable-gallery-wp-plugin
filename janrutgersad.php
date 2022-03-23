<?php
/*
Plugin Name: Janrutgersad
Plugin URI: https://bugloos.com/
Description: Wordpress gallery list
Version: 1.0.0
Author: Bugloos Team
Author URI: https://bugloos.com/
Text Domain: janrutgersad
*/

if ( ! defined( 'ABSPATH' ) )
	exit;

if ( ! class_exists( 'Janrutgersad' ) )
{
	class Janrutgersad
	{
		private static $instance;

		public static function get_instance (): Janrutgersad
		{
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) )
			{
				self::$instance = new self();

				self::$instance->setup_constants();

				self::$instance->includes();

				( new JRG_Theme_Setup() );
				( new JRG_Post_Type() );
			}

			return self::$instance;
		}

		private function setup_constants ()
		{
			if ( ! defined( 'JRG_PLUGIN_DIR' ) )
				define( 'JRG_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

			if ( ! defined( 'JRG_PLUGIN_URI' ) )
				define( 'JRG_PLUGIN_URI', plugin_dir_url( __FILE__ ) );

			if ( ! defined( 'JRG_PLUGIN_FILE' ) )
				define( 'JRG_PLUGIN_FILE', __FILE__ );

			if ( ! defined( 'JRG_TEMPLATE_DIR' ) )
				define( 'JRG_TEMPLATE_DIR', JRG_PLUGIN_DIR . '/inc/templates' );
		}

		private function includes ()
		{
			require_once JRG_PLUGIN_DIR . '/inc/class-jrg-post-type.php';
			require_once JRG_PLUGIN_DIR . '/inc/class-jrg-theme-setup.php';
		}
	}
}

function JRG (): Janrutgersad
{
	return Janrutgersad::get_instance();
}

JRG();