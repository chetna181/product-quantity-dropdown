<?php
/**
 * Product Quantity for WooCommerce - Core Class
 *
 * @version 1.0.0
 * @since   1.0.0
 * @author  Chetna Patel
 */

 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

 if ( ! class_exists( 'product_quantities_core' ) ) :

class product_quantities_core {
    /**
     * Contructor function
     */
    
    function __construct(){
        add_filter( 'wc_get_template', array( $this, 'replace_quantity_input_template' ), PHP_INT_MAX, 5 );
    }
    /**
	 * replace_quantity_input_template.
	 *
	 * @version 1.6.0
	 * @since   1.6.0
	 */
	function replace_quantity_input_template( $located, $template_name, $args, $template_path, $default_path ) {
        $product_page_options = get_option( 'plugin_general_settings_field_one');
        $cart_page_option = get_option( 'plugin_general_settings_field_2');
            //var_dump($cart_page_option);
		if( (is_product() ) ) {
            if('on' === $product_page_options){			
                if ( 'global/quantity-input.php' === $template_name ) {
                    return dirname(__FILE__) . '/templates/quantity-dropdown-template.php';                   
                }
            }
			
		}else if( is_cart() ){  
            if('on' === $cart_page_option){	
                
				if ( 'global/quantity-input.php' === $template_name ) {
					return dirname(__FILE__) . '/templates/quantity-dropdown-template.php';  
				}
            }
        }else if( is_product() || is_cart() ){
            if('on' === $product_page_options && 'on' === $cart_page_option){
                if ( 'global/quantity-input.php' === $template_name ) {
					return dirname(__FILE__) . '/templates/quantity-dropdown-template.php';  
				}
            }
        }
		return $located;
	}
   
}

endif;

return new product_quantities_core();
