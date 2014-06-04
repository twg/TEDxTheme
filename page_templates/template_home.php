<?php
/* Template Name: Homepage */

get_header();
?>

<div class="banner" style="background: url(<?php the_field('banner_background'); ?>) top center repeat-x;">
    <div class="page-width">
        <div class="banner-container">
            <div class="banner-text">
                <?php the_field('banner_title'); ?>
            </div>
            <div class="banner-text">
                <?php the_field('banner_subtitle'); ?>
            </div>
            <a class="button" href="<?php the_field('banner_callout_button_link'); ?>">
                <?php the_field('banner_callout_button_text'); ?>
            </a>
        </div>
    </div>
</div>



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

<?php get_sidebar(); ?>

<?php get_footer(); ?>
