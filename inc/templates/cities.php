<?php
if ( ! defined( 'ABSPATH' ) )
	exit;
?>
	<option value=""><?php _e( 'All cities', 'janrutgersad' ); ?></option>
<?php
$selected_city = $city_term_id ?? 0;
foreach ( $cities as $city )
{
	?>
	<option value="<?php echo $city->term_id; ?>" <?php echo $selected_city == $city->term_id ? 'selected' : ''; ?>><?php echo $city->name; ?></option>
	<?php
}
