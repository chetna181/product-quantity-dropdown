<?php
/**
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @snippet       Add to Cart Quantity drop-down
 * @author        Chetna Patel
 * @testedwith    WooCommerce 8
 */
defined( 'ABSPATH' ) || exit;

if ( $max_value && $min_value === $max_value ) {
	?>
	<div class="quantity hidden">
		<input type="hidden" id="<?php echo esc_attr( $input_id ); ?>" class="qty" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $min_value ); ?>" />
	</div>
	<?php
} else {
	/* translators: %s: Quantity. */
	$label = ! empty( $args['product_name'] ) ? sprintf( esc_html__( '%s quantity', 'woocommerce' ), wp_strip_all_tags( $args['product_name'] ) ) : esc_html__( 'Quantity', 'woocommerce' );
	?>
	<div class="quantity">
		<?php do_action( 'woocommerce_before_quantity_input_field' ); ?>
		<label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>"><?php echo esc_attr( $label ); ?></label>
		
		<?php 
			$options = '';
			
			if ( empty($max_value) ) $max_value = 10;

			for ( $count = $min_value; $count <= $max_value; $count = $count + $step ) {
				$selected = ($count == $input_value ) ? 'selected' : '';
				$options .= '<option value="' . $count . '" ' . $selected . '>' . $count . '</option>';
			 }

			 $select = '<select name="' . $input_name . '" class="qty" >' . $options . '</select>';
			 echo $select;
		?>

		<?php do_action( 'woocommerce_after_quantity_input_field' ); ?>
	</div>
	<?php
}