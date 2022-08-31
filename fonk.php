<?php
function koin_liste_fonk( $atts ) {
    $atts = shortcode_atts( array(
        'limit' => true,
    ), $atts );
     
    ob_start();
    $limit = $atts['limit'];
    include 'liste.php'; 
    return ob_get_clean(); 
}
add_shortcode( 'koin_liste', 'koin_liste_fonk' );