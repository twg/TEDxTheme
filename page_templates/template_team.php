<?php
/* Template Name: Team Members */

get_header();
?>



<div class="container contents">


    <div class="row">
        <div class="col-md-12">
            <main role="main">
                <!-- section -->
                <section>

                    <h1><?php the_title(); ?></h1>

                    <?php if (have_posts()): while (have_posts()) : the_post(); ?>

                        <!-- article -->
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                            <?php the_content(); ?>


                            <br class="clear">

                            <?php edit_post_link(); ?>

                        </article>
                        <!-- /article -->

                    <?php endwhile; ?>

                    <?php else: ?>

                        <!-- article -->
                        <article>

                            <h2><?php _e( 'Sorry, nothing to display.', 'tedx' ); ?></h2>

                        </article>
                        <!-- /article -->

                    <?php endif; ?>

                </section>
                <!-- /section -->
            </main>

        </div>

    </div>

</div>


<?php get_footer(); ?>
