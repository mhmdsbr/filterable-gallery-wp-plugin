<?php
if ( ! defined( 'ABSPATH' ) )
	exit;
?>
	<option value=""><?php _e( 'All years', 'janrutgersad' ); ?></option>
<?php
foreach ( $years as $year )
{
	?>
	<option value="<?php echo $year->term_id; ?>"><?php echo $year->name; ?></option>
	<?php
}