<?php
/*
Plugin Name:  Custom Events-orig 
Plugin URI:   #
Description:  A Custom Events Plugin
Version:      1.1
Author:       Ajay
Author URI:   #
Domain Path:  /languages
License:      GPLv2 or later
*/


defined( 'ABSPATH' ) or die( 'Stop!' );

// include all the required files
require ( plugin_dir_path( __FILE__ ) . 'custom-event-functions.php' );
require ( plugin_dir_path( __FILE__ ) . 'custom-event-post-type.php' );

// activation hook
function cep_activation() {

 // registers custom post type
    eap_create_event_post_type();

    

    global $wpdb;

        $the_page_title = 'Events';
        $the_page_name = 'events';
         // the slug...
        delete_option("my_plugin_page_name");
        add_option("my_plugin_page_name", $the_page_name, '', 'yes');
        // the id...
        delete_option("my_plugin_page_id");
        add_option("my_plugin_page_id", '0', '', 'yes');


        $the_page = get_page_by_title( $the_page_title );

        if ( ! $the_page ) {

            // Create post object
            $_p = array();
            $_p['post_title'] = $the_page_title;
            $_p['post_content'] = "[display_events]";
            $_p['post_status'] = 'publish';
            $_p['post_type'] = 'page';
            $_p['comment_status'] = 'closed';
            $_p['ping_status'] = 'closed';
            $_p['post_category'] = array(1); // the default 'Uncatrgorised'

            // Insert the post into the database
            $the_page_id = wp_insert_post( $_p );

        }
        else {
            // the plugin may have been previously active and the page may just be trashed...

            $the_page_id = $the_page->ID;

            //make sure the page is not trashed...
            $the_page->post_status = 'publish';
            $the_page_id = wp_update_post( $the_page );

        }
        delete_option( 'my_plugin_page_id' );
        add_option( 'my_plugin_page_id', $the_page_id );


}
register_activation_hook( __FILE__, 'cep_activation' );

// deactivation hook
function cep_deactivation() {

	global $wpdb;

        $the_page_title = get_option( "my_plugin_page_title" );
        $the_page_name = get_option( "my_plugin_page_name" );

        //  the id of our page...
        $the_page_id = get_option( 'my_plugin_page_id' );
        if( $the_page_id ) {

            wp_delete_post( $the_page_id ); // this will trash, not delete

        }

        delete_option("my_plugin_page_title");
        delete_option("my_plugin_page_name");
        delete_option("my_plugin_page_id");
    // unregister the post type, so the rules are no longer in memory
    unregister_post_type( 'cep_event' );
    // clear the permalinks to remove our post type's rules from the database
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'cep_deactivation' );