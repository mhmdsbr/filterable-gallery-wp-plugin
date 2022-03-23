<?php
if ( ! defined( 'ABSPATH' ) )
	exit;

$places = get_terms( [
	'taxonomy'   => 'jrg-place',
	'hide_empty' => true
] );

$countries = array_filter( $places, function ( $item ) {
	return ( $item->parent == 0 );
} );

$cities = array_filter( $places, function ( $item ) {
	return ( $item->parent > 0 );
} );

$years = get_terms( [
	'taxonomy'   => 'jrg-year',
	'hide_empty' => true
] );
?>
<div class="jrg-filter-container">
	<form class="jrg-filter-form">
		<div class="jrg-row">
			<div class="jrg-col">
				<div class="jrg-country">
					<select id="country-select" name="country">
						<option value=""><?php _e( 'All countries', 'janrutgersad' ); ?></option>
						<?php
						foreach ( $countries as $country )
						{
							?>
							<option value="<?php echo $country->term_id; ?>"><?php echo $country->name; ?></option>
							<?php
						}
						?>
					</select>
				</div>
			</div>
			<div class="jrg-col">
				<div class="jrg-city">
					<select id="city-select" name="city">
						<?php
						include JRG_TEMPLATE_DIR . '/cities.php';
						?>
					</select>
				</div>
			</div>
			<div class="jrg-col">
				<div class="jrg-year">
					<select id="year-select" name="year">
						<?php
						include JRG_TEMPLATE_DIR . '/years.php';
						?>
					</select>
				</div>
			</div>
		</div>
		<input type="hidden" name="action" value="jrg_filter_gallery">
	</form>
</div>
<?php
$images = new WP_Query( [
	'post_type'      => 'jrg-image',
	'posts_per_page' => - 1,
	'post_status'    => 'publish'
] );
?>
<div class="jrg-gallery-container">
	<div class="jrg-gallery-items">
		<?php
		while ( $images->have_posts() )
		{
			$images->the_post();

			if ( has_post_thumbnail() )
			{
				$post_id = get_the_ID();
				include JRG_TEMPLATE_DIR . '/gallery-item.php';
			}
		}
		wp_reset_postdata();
		?>
	</div>
</div>