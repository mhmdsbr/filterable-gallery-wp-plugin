<?php
if ( ! defined( 'ABSPATH' ) )
	exit;

if ( ! class_exists( 'JRG_Post_Type' ) )
{
	class JRG_Post_Type
	{
		public function __construct ()
		{
			add_action( 'init', [
				$this,
				'register_post_type'
			] );
		}

		public function register_post_type ()
		{
			$labels = [
				'name'           => __( 'Images', 'janrutgersad' ),
				'singular_name'  => __( 'Images', 'janrutgersad' ),
				'name_admin_bar' => __( 'Images', 'janrutgersad' ),
				'all_items'      => __( 'All Images', 'janrutgersad' ),
				'add_new'        => __( 'Add New', 'janrutgersad' ),
				'new_item'       => __( 'New Image', 'janrutgersad' ),
				'add_new_item'   => __( 'Add New Image', 'janrutgersad' ),
				'edit_item'      => __( 'Edit Instagram Page', 'janrutgersad' ),
				'search_items'   => __( 'Search' )
			];

			$args = [
				'labels'             => $labels,
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => true,
				'taxonomies'         => [
					'jrg-place',
					'jrg-year'
				],
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => 6,
				'menu_icon'          => 'dashicons-format-gallery',
				'supports'           => [
					'title',
					'editor',
					'excerpt',
					'thumbnail'
				]
			];

			register_post_type( 'jrg-image', $args );

			$labels = [
				'name'              => __( 'Place', 'janrutgersad' ),
				'singular_name'     => __( 'Place', 'janrutgersad' ),
				'search_items'      => __( 'Search Places', 'janrutgersad' ),
				'all_items'         => __( 'All Places', 'janrutgersad' ),
				'view_item'         => __( 'View Place', 'janrutgersad' ),
				'parent_item'       => __( 'Parent Place', 'janrutgersad' ),
				'parent_item_colon' => __( 'Parent Place:', 'janrutgersad' ),
				'edit_item'         => __( 'Edit Place', 'janrutgersad' ),
				'update_item'       => __( 'Update Place', 'janrutgersad' ),
				'add_new_item'      => __( 'Add New Place', 'janrutgersad' ),
				'new_item_name'     => __( 'New Place Name', 'janrutgersad' ),
				'not_found'         => __( 'No Places Found', 'janrutgersad' ),
				'back_to_items'     => __( 'Back to Places', 'janrutgersad' ),
				'menu_name'         => __( 'Places', 'janrutgersad' )
			];

			$args = [
				'labels'            => $labels,
				'hierarchical'      => true,
				'public'            => true,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true
			];

			register_taxonomy( 'jrg-place', 'jrg-image', $args );

			$labels = [
				'name'              => __( 'Year', 'janrutgersad' ),
				'singular_name'     => __( 'Year', 'janrutgersad' ),
				'search_items'      => __( 'Search Years', 'janrutgersad' ),
				'all_items'         => __( 'All Years', 'janrutgersad' ),
				'view_item'         => __( 'View Year', 'janrutgersad' ),
				'parent_item'       => __( 'Parent Year', 'janrutgersad' ),
				'parent_item_colon' => __( 'Parent Year:', 'janrutgersad' ),
				'edit_item'         => __( 'Edit Year', 'janrutgersad' ),
				'update_item'       => __( 'Update Year', 'janrutgersad' ),
				'add_new_item'      => __( 'Add New Year', 'janrutgersad' ),
				'new_item_name'     => __( 'New Year Name', 'janrutgersad' ),
				'not_found'         => __( 'No Years Found', 'janrutgersad' ),
				'back_to_items'     => __( 'Back to Years', 'janrutgersad' ),
				'menu_name'         => __( 'Years', 'janrutgersad' )
			];

			$args = [
				'labels'              => $labels,
				'public'              => true,
				'publicly_queryable'  => true,
				'exclude_from_search' => false,
				'show_ui'             => true,
				'show_admin_column'   => true,
				'query_var'           => true
			];

			register_taxonomy( 'jrg-year', 'jrg-image', $args );
		}
	}
}