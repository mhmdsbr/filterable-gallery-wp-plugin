<?php
if ( ! defined( 'ABSPATH' ) )
	exit;

if ( ! class_exists( 'JRG_Theme_Setup' ) )
{
	class JRG_Theme_Setup
	{
		public function __construct ()
		{
			add_action( 'after_setup_theme', [
				$this,
				'setup'
			] );

			add_shortcode( 'jrg_gallery', [
				$this,
				'gallery_shortcode'
			] );

			add_action( 'wp_ajax_jrg_filter_gallery', [
				$this,
				'filter_gallery'
			] );

			add_action( 'wp_ajax_nopriv_jrg_filter_gallery', [
				$this,
				'filter_gallery'
			] );

			add_action( 'wp_enqueue_scripts', [
				$this,
				'enqueue_front_scripts'
			] );
		}

		public function setup ()
		{
			add_image_size( 'jrg-small-image', 1080, auto, true );
		}

		public function gallery_shortcode ()
		{
			// [jrg_gallery]

			ob_start();

			include JRG_TEMPLATE_DIR . '/gallery.php';

			return ob_get_clean();
		}

		public function filter_gallery ()
		{
			$template = [
				'cities'  => '',
				'years'   => '',
				'gallery' => ''
			];

			$country_term_id = isset( $_POST[ 'country' ] ) ? absint( $_POST[ 'country' ] ) : 0;
			$city_term_id    = isset( $_POST[ 'city' ] ) ? absint( $_POST[ 'city' ] ) : 0;
			$year_term_id    = isset( $_POST[ 'year' ] ) ? absint( $_POST[ 'year' ] ) : 0;

			$args = [
				'post_type'      => 'jrg-image',
				'posts_per_page' => - 1,
				'post_status'    => 'publish'
			];

			$args[ 'tax_query' ] = [];

			if ( $city_term_id || $country_term_id )
			{
				$args[ 'tax_query' ][] = [
					'taxonomy' => 'jrg-place',
					'field'    => 'term_id',
					'terms'    => $city_term_id ? : $country_term_id
				];
			}

			if ( $year_term_id )
			{
				$args[ 'tax_query' ][] = [
					'taxonomy' => 'jrg-year',
					'field'    => 'term_id',
					'terms'    => $year_term_id
				];
			}

			$images = new WP_Query( $args );

			ob_start();

			$year_term_ids = [];

			while ( $images->have_posts() )
			{
				$images->the_post();

				if ( has_post_thumbnail() )
				{
					$post_id = get_the_ID();
					include JRG_TEMPLATE_DIR . '/gallery-item.php';
				}

				if ( ! $year_term_id )
				{
					$terms = get_the_terms( get_the_ID(), 'jrg-year' );

					foreach ( $terms as $term )
						$year_term_ids[] = $term->term_id;
				}
			}
			wp_reset_postdata();

			$template[ 'gallery' ] = ob_get_clean();

			$args = [
				'taxonomy'   => 'jrg-place',
				'hide_empty' => true
			];

			ob_start();

			if ( $country_term_id )
				$args[ 'parent' ] = $country_term_id;

			$cities = get_terms( $args );

			if ( ! $country_term_id )
			{
				$cities = array_filter( $cities, function ( $item ) {
					return ( $item->parent > 0 );
				} );
			}

			include JRG_TEMPLATE_DIR . '/cities.php';

			$template[ 'cities' ] = ob_get_clean();

			if ( $year_term_ids )
			{
				$args = [
					'taxonomy'   => 'jrg-year',
					'hide_empty' => true,
					'include'    => $year_term_ids
				];

				ob_start();

				$years = get_terms( $args );

				include JRG_TEMPLATE_DIR . '/years.php';

				$template[ 'years' ] = ob_get_clean();
			}

			wp_send_json( $template );
		}

		public function enqueue_front_scripts ()
		{
			wp_register_style( 'jrg-magnific-popup', JRG_PLUGIN_URI . 'assets/css/magnific-popup.css', [], '1.0.0' );
			wp_enqueue_style( 'jrg-magnific-popup' );

			wp_register_style( 'jrg-custom-style', JRG_PLUGIN_URI . 'assets/css/custom-styles.css', [ 'jrg-magnific-popup' ], '1.0.0' );
			wp_enqueue_style( 'jrg-custom-style' );

			wp_register_style( 'jrg-jquery-nice-select', JRG_PLUGIN_URI . 'assets/jquery-nice-select/css/nice-select.css', [], '1.0.0' );
			wp_enqueue_style( 'jrg-jquery-nice-select' );


			wp_register_script( 'jrg-magnific-popup', JRG_PLUGIN_URI . 'assets/js/jquery.magnific-popup.min.js', [
				'jquery'
			], '1.0.0', true );

			wp_enqueue_script( 'jrg-magnific-popup' );

			wp_register_script( 'jrg-custom-script', JRG_PLUGIN_URI . 'assets/js/custom-scripts.js', [
				'jquery',
				'jrg-magnific-popup'
			], '1.0.0', true );

			wp_enqueue_script( 'jrg-custom-script' );
			
			wp_register_script( 'jrg-jquery-nice-select', JRG_PLUGIN_URI . 'assets/jquery-nice-select/js/jquery.nice-select.js', [
				'jquery',
			], '1.0.0', true );

			wp_enqueue_script( 'jrg-jquery-nice-select' );

			wp_localize_script( 'jrg-custom-script', 'jrg_js_object', [ 'ajax_url' => admin_url( 'admin-ajax.php' ) ] );
		}
	}
}