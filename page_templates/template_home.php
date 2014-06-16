<?php
/*
Template Name: Homepage
*/

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


  <!-- Blog Posts -->
  <section class="blog-recent">
    <header>
      <h1 class="minor">Blog
        <a class="see-more-link pull-right" href='<?php bloginfo('url'); ?>/blog'>GO TO THE BLOG</a>
      </h1>
    </header>

    <ul class="third-tile tile-container">
      <?php
      $latest_post = new WP_Query("post_type=post&posts_per_page=3&orderby=date&order=DESC");
      ?>

      <?php foreach ($latest_post as $post): setup_postdata($post) ?>

        <article class="blog-tile tile">
          <a href="<?php the_permalink(); ?>">
            <?php if(has_post_thumbnail()): ?>
              <?php the_post_thumbnail('blog-secondary'); ?>
            <?php else: ?>
              <img src="<?php bloginfo('template_url'); ?>/images/defaults/blog-secondary.jpg" />
            <?php  endif; ?>
          </a>

          <div class="meta-info clearfix">
            <a class="pull-left year" href="#"><?php the_time('F j, Y'); ?></a>
            <a class="pull-right" href="<?php the_permalink(); ?>#disqus_thread">
              <?php comments_number('Leave a Comment', '<strong>1</strong> comment', '<strong>%</strong> comments'); ?>
            </a>
          </div>

          <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        </article>


      <?php endforeach; ?>
    </ul>
  </section>


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
