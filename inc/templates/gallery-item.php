<?php
if ( ! defined( 'ABSPATH' ) )
	exit;

$city = get_the_terms( $post_id, 'jrg-place' );

$country_name = '';
$city_name    = '';
$year_name    = '';

if ( isset( $city[ 0 ]->term_id ) )
{
	$city_name = $city[ 0 ]->name;

	$country = get_term( $city[ 0 ]->parent );

	if ( ! is_wp_error( $country ) )
		$country_name = $country->name;
}

$year = get_the_terms( $post_id, 'jrg-year' );
if ( isset( $year[ 0 ]->term_id ) )
	$year_name = $year[ 0 ]->name;
?>
<div class="jrg-gallery-item">
	<a href="<?php the_post_thumbnail_url( 'full' ); ?>" data-country="<?php echo $country_name; ?>" data-city="<?php echo $city_name; ?>" data-year="<?php echo $year_name; ?>" data-desc="<?php echo nl2br(get_the_excerpt()); ?>">
		<?php the_post_thumbnail( 'jrg-small-image' ); ?>
	</a>
</div>