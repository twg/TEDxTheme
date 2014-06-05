<?php
/* Template Name: Homepage */

get_header();
?>

<div class="banner" style="background: url(<?php the_field('banner_background'); ?>) top center repeat-x;">
    <div class="banner-container">
        <h1><?php the_field('banner_title'); ?></h1>

        <h2><?php the_field('banner_subtitle'); ?></h2>
        <a class="btn btn-danger" href="<?php the_field('banner_callout_button_link'); ?>"><?php the_field('banner_callout_button_text'); ?></a>
    </div>
</div>


<div class="container contents">


    <div class="row">
        <div class="col-md-8">
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
        <div class="col-md-4">
            <?php get_sidebar(); ?>
        </div>
    </div>




    <h3>Full width, single column</h3>

    <p class="text-warning">No grid classes are necessary for full-width elements.</p>

    <hr>

    <h3>Two columns with two nested columns</h3>

    <p>Per the documentation, nesting is easy—just put a row of columns within an existing column. This gives you two
        columns <strong>starting at desktops and scaling to large desktops</strong>, with another two (equal widths) within
        the larger column.</p>

    <p>At mobile device sizes, tablets and down, these columns and their nested columns will stack.</p>

    <div class="row">
        <div class="col-md-8">
            .col-md-8
            <div class="row">
                <div class="col-md-6">.col-md-6</div>
                <div class="col-md-6">.col-md-6</div>
            </div>
        </div>
        <div class="col-md-4">.col-md-4</div>
    </div>

    <hr>

    <h3>Mixed: mobile and desktop</h3>

    <p>The Bootstrap 3 grid system has four tiers of classes: xs (phones), sm (tablets), md (desktops), and lg (larger
        desktops). You can use nearly any combination of these classes to create more dynamic and flexible layouts.</p>

    <p>Each tier of classes scales up, meaning if you plan on setting the same widths for xs and sm, you only need to
        specify xs.</p>

    <div class="row">
        <div class="col-xs-12 col-md-8">.col-xs-12 .col-md-8</div>
        <div class="col-xs-6 col-md-4">.col-xs-6 .col-md-4</div>
    </div>
    <div class="row">
        <div class="col-xs-6 col-md-4">.col-xs-6 .col-md-4</div>
        <div class="col-xs-6 col-md-4">.col-xs-6 .col-md-4</div>
        <div class="col-xs-6 col-md-4">.col-xs-6 .col-md-4</div>
    </div>
    <div class="row">
        <div class="col-xs-6">.col-xs-6</div>
        <div class="col-xs-6">.col-xs-6</div>
    </div>

    <hr>

    <h3>Mixed: mobile, tablet, and desktop</h3>

    <p></p>

    <div class="row">
        <div class="col-xs-12 col-sm-6 col-lg-8">.col-xs-12 .col-sm-6 .col-lg-8</div>
        <div class="col-xs-6 col-lg-4">.col-xs-6 .col-lg-4</div>
    </div>
    <div class="row">
        <div class="col-xs-6 col-sm-4">.col-xs-6 .col-sm-4</div>
        <div class="col-xs-6 col-sm-4">.col-xs-6 .col-sm-4</div>
        <div class="col-xs-6 col-sm-4">.col-xs-6 .col-sm-4</div>
    </div>

    <hr>

    <h3>Column clearing</h3>

    <p><a href="http://getbootstrap.com/css/#grid-responsive-resets">Clear floats</a> at specific breakpoints to prevent
        awkward wrapping with uneven content.</p>

    <div class="row">
        <div class="col-xs-6 col-sm-3">
            .col-xs-6 .col-sm-3
            <br>
            Resize your viewport or check it out on your phone for an example.
        </div>
        <div class="col-xs-6 col-sm-3">.col-xs-6 .col-sm-3</div>

        <!-- Add the extra clearfix for only the required viewport -->
        <div class="clearfix visible-xs"></div>

        <div class="col-xs-6 col-sm-3">.col-xs-6 .col-sm-3</div>
        <div class="col-xs-6 col-sm-3">.col-xs-6 .col-sm-3</div>
    </div>

    <hr>

    <h3>Offset, push, and pull resets</h3>

    <p>Reset offsets, pushes, and pulls at specific breakpoints.</p>

    <div class="row">
        <div class="col-sm-5 col-md-6">.col-sm-5 .col-md-6</div>
        <div class="col-sm-5 col-sm-offset-2 col-md-6 col-md-offset-0">.col-sm-5 .col-sm-offset-2 .col-md-6
            .col-md-offset-0
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-5 col-lg-6">.col-sm-6 .col-md-5 .col-lg-6</div>
        <div class="col-sm-6 col-md-5 col-md-offset-2 col-lg-6 col-lg-offset-0">.col-sm-6 .col-md-5 .col-md-offset-2
            .col-lg-6 .col-lg-offset-0
        </div>
    </div>
</div>





<?php get_footer(); ?>
