<?php
/*
Template Name: One column (Default)
*/
get_header();
?>
  <div class="container contents spacing-top">
    <section>
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php the_content(); ?>
      <?php endwhile; endif; ?>
    </section>
  </div><!-- .container contents -->
<?php get_footer(); ?>