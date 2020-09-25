<?php

// add meta to content
function eap_add_meta_to_event_content( $content ) {

    ob_start();

    if( is_singular( 'cep_event' ) ) {

        include ( plugin_dir_path( __FILE__ ) . 'custom-event-meta.php' );
    }

    $event_meta = ob_get_clean();

    $content = $event_meta . $content;

    return $content;
}
add_filter( 'the_content', 'eap_add_meta_to_event_content' );


// display all events
function eap_display_all_events( $atts ) {

    ob_start();

    // shortcode attributes
    extract( shortcode_atts( array(
        'category'       => '',
        'order'          => 'ASC'
    ), $atts));

    $args = array (
        'posts_per_page' => -1,
        'post_type'      => 'cep_event',
        'order'          => $order,
        'orderby'        => 'meta_value',
        'meta_key'       => 'eap_from_day',
        'category_name'  => $category,
    );

    $custom_query = new WP_Query( $args );

    if ( $custom_query->have_posts() ) : ?>

        <div class="eap__list">
            <?php while( $custom_query->have_posts() ) :

                // post content
                $custom_query->the_post();

                    // displays event content
                    include ( plugin_dir_path( __FILE__ ) . 'custom-event-content.php' );

            endwhile; ?>
        </div>
        <br>

   <?php else :

       _e( 'There are no events', 'events-as-posts' );

   endif;

   wp_reset_postdata();

   $loop_content = ob_get_clean();

   return $loop_content;
}


// shows events in category pages
function eap_category_filter( $query ) {

    if ( ! is_admin() && $query->is_main_query() ) {

        if ( $query->is_category ) {

            $query->set( 'post_type', array( 'post', 'cep_event' ) );
        }
    }
}
add_action( 'pre_get_posts','eap_category_filter' );


// register shortcodes
function eap_register_shortcodes() {

    add_shortcode( 'display_events', 'eap_display_all_events' );
}
add_action( 'init', 'eap_register_shortcodes' );
