<?php
/**
 * Admin View: Metabox
 * 
 * Pardon the language.
 * 
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! current_user_can( 'upload_files' ) ) {
	wp_die( __( 'Sorry, you are not allowed to upload files.', 'cfi' ) );
}

$terms = $this->get_object_terms();

?>

<div class="cfi-wrapper">
    <?php
        echo '<script id="cfi-data">var CFI_DATA=' . json_encode( $terms ) . ';</script>'
    ?>
    <div id="cfiApp"><?php _e( 'Please enable Javascript.', 'cfi' ); ?></div>
    <?php wp_nonce_field( 'cfi_secure_action', 'cfi_secure' ); ?>
</div>