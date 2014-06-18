<div class="post-content">

  <?php if (have_posts()): while (have_posts()) : the_post(); ?>
    <?php if (has_post_thumbnail()): ?>
      <div class="feature-image">
        <?php the_post_thumbnail(); ?>
      </div>
    <?php endif; ?>

    <div class="page-header">
      <h2><?php the_title(); ?></h2>
      <ul class="inline post-meta">
        <li>
          <small><i class="fa fa-clock-o"></i> <?php the_time('F j, Y'); ?></small>
        </li>
      </ul>
    </div>

    <div class="user-generated-content">
      <?php the_content(); ?>
    </div><!-- .user-generated-content -->

    <?php comments_template(); ?>

    <?php WP_Render::partial('partials/_pagination.php'); ?>


  <?php endwhile; endif; ?>

</div><!-- .post-content -->