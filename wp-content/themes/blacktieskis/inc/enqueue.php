<?php
function remove_jquery_migrate( $scripts ) {
	if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
	$script = $scripts->registered['jquery'];
		if ( $script->deps ) { // Check whether the script has any dependencies
		$script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
		}
	}
}
	
add_action( 'wp_default_scripts', 'remove_jquery_migrate' );


add_filter( 'wp_default_scripts', $af = static function ( &$scripts ) {
	if ( ! is_admin() ) {
		// $scripts->remove( 'jquery' );
		// $scripts->remove( 'jquery-migrate' );
	}
} );
if ( ! function_exists( 'blacktieskis_admin_enqueue' ) ) {
	function blacktieskis_admin_enqueue( $hook ) {
		// wp_enqueue_script( 'helper_script', get_template_directory_uri() . '/helper-admin.js', '', '1.3' );
		// wp_add_inline_script( 'helper_script', 'var templateUrl ="' . get_bloginfo( "template_url" ) . '";' );
		// wp_enqueue_style( 'blacktieskis-custom-button', get_template_directory_uri() . '/stylesheets/custom-tinymce.css', array(), '1.3' );
	}
}

add_action( 'admin_enqueue_scripts', 'blacktieskis_admin_enqueue' );

if ( ! function_exists( 'blacktieskis_common_script' ) ) {
	function blacktieskis_common_script() {

		wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Open+Sans:200,300,400,500,600,700|Poppins:200,300,400,500,600,700|Reenie+Beanie:300,400,500,700' );
		wp_enqueue_style( 'app', TEMPLATE_URL . '/stylesheets/app.css', array(), '5.9.3.4', 'screen' );
		wp_enqueue_style( 'blacktieskis-custom', TEMPLATE_URL . '/stylesheets/custom.css', array( 'app' ), '5.38', 'screen' );
		wp_enqueue_style( 'print', TEMPLATE_URL . '/stylesheets/print.css', array(), false, 'print' );

        //// Remove styles and js unused on front end side
        if ( ! is_admin() ) {
            wp_deregister_style( 'duplicate-page-and-post' );
            // wp_deregister_style( 'contact-form-7' );
            wp_deregister_style( 'bodhi-svgs-attachment' );
        }
	}
}

add_action( 'wp_enqueue_scripts', 'blacktieskis_common_script' );


add_filter( 'wpcf7_load_js', '__return_false' );