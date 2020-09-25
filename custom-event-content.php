<?php

$setting = get_option( 'eap_settings' );
?>

<div id="post-<?php the_ID(); ?>" class="eap__event">
    <div class="eap__img">
        <?php the_post_thumbnail() ?>
    </div>

    <div class="eap__content">
        <!-- header -->
        <header class="eap__header">
            <h2 class="eap__title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
            <?php
          
                // get event categories
                $category = get_the_category();
                ?>

                <p class="eap__category">
                    <?php
                    // display categories
                    for ( $i = 0; $i < sizeof( $category ); $i++ ) {

                        echo $category[$i]->name;
                        // if has more than one category it displays a comma after each category apart the last one
                        if ( sizeof( $category ) > 1 && ( sizeof( $category ) != ( $i + 1 ) ) ) {

                            echo ', ';
                        }
                    }
                    ?>
                </p>
                
            ?>
            <?php include ( plugin_dir_path( __FILE__ ) . 'custom-event-meta.php' ); ?>
        </header>

        <!-- main -->
        <main class="eap__excerpt">
            <?php
            

                the_excerpt();
            
?>
           
                <p class="eap__more">
                    <a href="<?php the_permalink(); ?>"><?php _e( 'Read more', 'events-as-posts' ); ?></a>
                </p>
                
        </main>
    </div>
</div>
