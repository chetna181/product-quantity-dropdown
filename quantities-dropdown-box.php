<?php
/*
* Plugin Name: Quantities Dropdown Box For WooCommerce
* Plugin URI: 
* Description: This plugin allows to display Product Quantities box to Drowpdown selection box.
* Version: 1.0.0
* Author: Chetna Patel
* Requires PHP: 7.4
* WC requires at least: 3.0.0
* WC tested up to: 8.8.2
* Text Domain: quantities-dropdown-box-for-wc
*/
//require_once 'include/frontend-product-page.php';


if ( ! class_exists( 'quantities_dropdown_box' ) ) {
    class quantities_dropdown_box {
		
        public function __construct()
        {
            // Initialize settings
            add_action( 'admin_menu', array( &$this, 'wpdocs_register_my_plugin_menu_page_to_wc' ) );
			//Add a Custom Setting Page in WordPress
            add_action( 'admin_init', array( &$this, 'plugin_initialize_settings' ));
			// Include required files
			$this->includes_files();
        }

        /**
		 * Register a custom menu page.
		 */
		public function wpdocs_register_my_plugin_menu_page_to_wc() { 

			add_submenu_page( 
				'woocommerce', 
				__( 'Quantity Dropdown', 'quantities-dropdown-box-for-wc' ), 
				__( 'Quantity Dropdown', 'quantities-dropdown-box-for-wc' ), 
				'manage_options', 
				'qty_dropdown_plugin_page',	
				array( &$this, 'qty_dropdown_admin_page_contents' )
			);
		} 

        public function qty_dropdown_admin_page_contents() {
            
			$page    = isset( $_GET['page'] ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : ''; 
			
			if ( 'qty_dropdown_plugin_page' === $page ) {
				
				?>
				<p><?php esc_html_e( 'This my creation.', 'quantities-dropdown-box-for-wc' ); ?></p>
				<form method="post" action="options.php">
					<?php do_settings_sections( 'qty_dropdown_plugin_page' ); ?>
					<?php settings_fields( 'plugin_register_settings' ); ?>
					<?php settings_errors(); ?>
					<?php submit_button(); ?>
				</form>
				<?php			 			
			}
        } 
		public function plugin_initialize_settings() {
			//qty_dropdown_plugin_page page me setting section add karo
			add_settings_section(
				'plugin_general_section_one',                                                       // ID used to identify this section and with which to register options.
				__( 'Product Quantities Dropdown', 'quantities-dropdown-box-for-wc' ), // Title to be displayed on the administration page.
				array( $this, 'plugin_settings_section_callback' ),                                             // Callback used to render the description of the section.
				'qty_dropdown_plugin_page'                                                        // Page on which to add this section of options.
			);
			//'qty_dropdown_plugin_page' page me, plugin_general_section_one section me setting field named "plugin_general_settings_field_one" add karo
			add_settings_field(
				'plugin_general_settings_field_one',
				__( 'Product Page', 'quantities-dropdown-box-for-wc' ),
				array( $this, 'plugin_setting_field_one_callback' ),
				'qty_dropdown_plugin_page',
				'plugin_general_section_one',
				array( 'Select this checkbox to appear product quantities dropdown box on product page', 'quantities-dropdown-box-for-wc' )
			);
			// plugin_general_settings_field_one setting field me 'plugin_register_settings' Register karo
			register_setting(
				'plugin_register_settings',
				'plugin_general_settings_field_one'
			);
			
			//'qty_dropdown_plugin_page' page me, plugin_general_section_2 section me setting field named "plugin_general_settings_field" add karo
			add_settings_field(
				'plugin_general_settings_field_2',
				__( 'Cart Page', 'quantities-dropdown-box-for-wc' ),
				array( $this, 'plugin_setting_field_2_callback' ),
				'qty_dropdown_plugin_page',
				'plugin_general_section_one',
				array( 'Select this checkbox to appear product quantities dropdown box on Cart page.', 'quantities-dropdown-box-for-wc' )
			);
			// plugin_general_settings_field_2 setting field me 'plugin_register_settings' Register karo
			register_setting(
				'plugin_register_settings',
				'plugin_general_settings_field_2'
			);
		}
		public function plugin_settings_section_callback(){
			echo "this is setting section callback";
		}
		public function plugin_setting_field_one_callback($args){
			
			$product_page_options = get_option( 'plugin_general_settings_field_one', '' );  
			if ( empty($product_page_options) ) {
				$product_page_options = 'off';
			}
			printf(
				'<input type="checkbox" id="plugin_general_settings_field_one" name="plugin_general_settings_field_one" 
					value="on" ' . checked( 'on', $product_page_options, false ) . ' />'
			);
			$html = '<label for="plugin_general_settings_field_one"> ' . esc_html($args[0]) . '</label>';
			echo wp_kses_post( $html );
		}
		public function plugin_setting_field_2_callback($args){
			$cart_page_options = get_option( 'plugin_general_settings_field_2', '' );  
			if ( empty($cart_page_options) ) {
				$cart_page_options = 'off';
			}
			printf(
				'<input type="checkbox" id="plugin_general_settings_field_2" name="plugin_general_settings_field_2" 
					value="on" ' . checked( 'on', $cart_page_options, false ) . ' />'
			);
			$html = '<label for="plugin_general_settings_field_2"> ' . esc_html($args[0]) . '</label>';
			echo wp_kses_post( $html );
		}

		public function includes_files(){
			require_once( 'include/frontend-conditions.php' );
		}
    }
}
 
$quantities_dropdown_box = new quantities_dropdown_box();
 