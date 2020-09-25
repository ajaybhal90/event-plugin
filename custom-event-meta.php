<?php
// retrieves the stored values from the database
$from_date = get_post_meta( get_the_ID(), 'eap_from_day', true );
$until_date = get_post_meta( get_the_ID(), 'eap_until_day', true );
$location = get_post_meta( get_the_ID(), 'eap_location', true );
$city = get_post_meta( get_the_ID(), 'eap_city', true );
$country = get_post_meta( get_the_ID(), 'eap_country', true );
$setting = get_option( 'eap_settings' );


// separation mark '–' between from day/time and until day/time
$sepmark_date = ' – ';
// separation mark between date and time
$sepmark_time = ' | ';
$comma = ', ';
?>

<!-- event meta -->
<p class="eap__meta">
    <?php
    // from date
    if ( $from_date ) {
        ?>
        <span class="eap__date no-wrap">
            <?php
            

            echo date_i18n( $setting['date_format'], strtotime( $from_date ) );
            ?>
        </span>
        <?php
    }

    

    // until date
    if ( $until_date && ( $until_date != $from_date ) ) {

        echo $sepmark_date;
        ?>
        <span class="eap__date no-wrap">
            <?php

            echo date_i18n( $setting['date_format'], strtotime( $until_date ) );
            ?>
        </span>
        <?php
    }

   