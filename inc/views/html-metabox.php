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
	wp_die( __( 'Sorry, you are not allowed to upload files.' ) );
}

$post_categories = wp_get_post_categories( $post->ID );
$cats = array();
    
foreach( $post_categories as $c ){
    $cat = get_category( $c );
    $cats[] = array( 'id' => $cat->term_id, 'name' => $cat->name, 'slug' => $cat->slug );
}

?>

<div class="cfi-wrapper">
    <?php
        echo '<script id="cfi-data">var CFI_DATA=' . json_encode( $cats ) . ';</script>'
    ?>
    <div id="cfiApp">Please enable JavaScript.</div>
    <?php wp_nonce_field( 'cfi_secure_action', 'cfi_secure' ); ?>
</div>